	<!----right---->
	<div class="right_box">  
		<div class="mob_tool" style="padding:12px;margin:0px;border-bottom:solid #DCDCDC 1px">
			<a href="javascript:history.go(-1)"><{$EVALU_RIGHTER_BACK|default:"返回"}></a>
		</div>
		<style>
			table{margin:12px;}
			table tr{height:30px;line-height:30px;}
		</style>
		<table>
			<tr>
				<td><{$EVALU_RIGHTER_DEVICE_NO|default:"设备编号"}>：</td>
				<td><input type="text" id="no" name="no" placeholder="<{$EVALU_RIGHTER_INPUT_NO_TIP|default:"请输入设备编号"}>" value="<{$evalu.E_no}>"></td>
			</tr>
			<tr>
				<td><{$EVALU_RIGHTER_DEVICE_SERIES|default:"设备序列号"}>：</td>
				<td><input type="text" disabled size="50" id="series" name="series" placeholder="<{$EVALU_RIGHTER_INPUT_SERIES_TIP|default:"请输入设备序列号"}>" value="<{$evalu.E_series}>"></td>
			</tr>
			<tr>
				<td><{$EVALU_RIGHTER_JG|default:"所属网点"}>：</td>
				<td>
					<select name="JG_ID" id="JG_ID" onchange="getCounter(<{$evalu.C_no}>)">
						<option value="0"><{$EVALU_RIGHTER_CHOOSE_TIP|default:"请选择"}></option>
						<{foreach item=row from=$itsOrgArr}>
						<{if $row.sysno eq $evalu.JG_ID}>
						<option value="<{$row.sysno}>" selected><{$row.sysname}></option>
						<{else}>
						<option value="<{$row.sysno}>"><{$row.sysname}></option>
						<{/if}>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<td><{$EVALU_RIGHTER_COUNTER_NO|default:"所属柜台"}>：</td>
				<td>
					<select name="C_no" id="C_no">
						<option value="0"><{$EVALU_RIGHTER_CHOOSE_TIP|default:"请选择"}></option>
						<{foreach item=row from=$cnos}>
						<{if $row.C_no eq $evalu.C_no}>
						<option value="<{$row.C_no}>" selected><{$row.C_no}></option>
						<{else}>
						<option value="<{$row.C_no}>"><{$row.C_no}></option>
						<{/if}>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<td><{$EVALU_RIGHTER_IS_USE_ZIP|default:"使用模板"}>：</td>
				<td>
					<select name="T_id" id="T_id">
						<option value="0"><{$EVALU_RIGHTER_CHOOSE_TIP|default:"请选择"}></option>
						<{foreach item=row from=$tplInfos}>
						<{if $row.id eq $evalu.T_id}>
						<option value="<{$row.id}>" selected><{$row.tpl_name}></option>
						<{else}>
						<option value="<{$row.id}>"><{$row.tpl_name}></option>
						<{/if}>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<!--
			<tr>
				<td><{$EVALU_RIGHTER_UPDATE_TIME|default:"更新时间"}>：</td>
				<td>
					<input type="time" name="update" id="update" value="<{$evalu.E_update}>">
				</td>
			</tr>
			-->
			<tr>
				<td><{$EVALU_RIGHTER_ISUSE|default:"是否启用"}>：</td>
				<td>
					<select id="isuse" name="isuse">
						<option value="1" <{if $evalu.E_isuse eq 1}>selected<{/if}>><{$EVALU_RIGHTER_ISUSE_ON|default:"启用"}></option>
						<option value="0" <{if $evalu.E_isuse eq 0}>selected<{/if}>><{$EVALU_RIGHTER_ISUSE_OFF|default:"禁用"}></option>
					</select>
				</td>
			</tr>
		</table>
		<input onclick="editEvaluInfo()" type="button" value="<{$COMMON_BOX_CHANGE|default:"修改"}>" style="margin:12px"/>
	</div>
</div>
<!--content end-->
<script>
	// 异步获取网点对应的窗口数据
	function getCounter(cno){
		// 获取网点id
		var orgId = $('#JG_ID').val();
		var url = "<{$baseUrl}>/index.php?control=basedata&action=getCounterParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			dataType:'json',
			success: function(data) {
				var optionStr = '<option value="0"><{$EVALU_RIGHTER_CHOOSE_TIP|default:"请选择"}></option>';
				for (var idx in data){
					var item = data[idx];
					if (cno == item.C_no){
						optionStr = optionStr+'<option value="'+item.C_no+'" selected>'+item.C_no+'</option>';
					}else{
						optionStr = optionStr+'<option value="'+item.C_no+'">'+item.C_no+'</option>';
					}
				}// for
				
				$('#C_no').html(optionStr);
			}
		}); // ajax
	}

	function editEvaluInfo(){
		var no = $('#no').val();
		var series = $('#series').val();
		var eId = '<{$eId}>';
		
		if (no === ''){
			alert('<{$EVALU_RIGHTER_INPUT_NO_TIP|default:"请输入设备编号"}>.');
			return;
		}// func
		
		if (series === ''){
			alert('<{$EVALU_RIGHTER_INPUT_SERIES_TIP|default:"请输入设备序列号"}>.');
			return;
		}// func
		
		var jg = $('#JG_ID').val();
		var tpl = $('#T_id').val();
		var update = $('#update').val();
		if (update == 'undefined') update = '';
		var isuse = $('#isuse').val();
		var cno = $('#C_no').val();
		
		var url = "<{$baseUrl}>/index.php?control=evalu&action=saveEvalu";
		$.ajax({
			type: "post",
			url: url,
			//data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&update='+update+'&isuse='+isuse+'&eId='+eId+'&cno='+cno,
			data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&isuse='+isuse+'&eId='+eId+'&cno='+cno,
			dataType:'json',
			success: function(data) {
				if (data > 0) alert('<{$COMMON_TIP_EDIT_SUCCESS|default:"修改成功."}>');
				else alert('<{$COMMON_TIP_EDIT_FAILED|default:"修改失败."}>');
			}
		}); // ajax
	}// func
</script>
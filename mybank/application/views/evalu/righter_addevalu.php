	<!----right---->
	<div class="right_box">  
		<div class="mob_tool" style="padding:12px;margin:0px;border-bottom:solid #DCDCDC 1px">
			<a href="javascript:history.go(-1)">返回</a>
		</div>
		<style>
			table{margin:12px;}
			table tr{height:30px;line-height:30px;}
		</style>
		<table>
			<tr>
				<td>编号：</td>
				<td><input type="text" id="no" name="no" placeholder="请输入设备编号"></td>
			</tr>
			<tr>
				<td>序列号：</td>
				<td><input type="text" id="series" name="series" placeholder="请输入设备序列号"></td>
			</tr>
			<tr>
				<td>所属网点：</td>
				<td>
					<select name="JG_ID" id="JG_ID" onchange="getCounter()">
						<option value="0">请选择</option>
						<{foreach item=row from=$orgInfos}>
						<option value="<{$row.JG_ID}>"><{$row.JG_name}></option>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<td>所属柜台：</td>
				<td>
					<select name="C_no" id="C_no">
						<option value="0">请选择</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>使用模板：</td>
				<td>
					<select name="T_id" id="T_id">
						<option value="0">请选择</option>
						<{foreach item=row from=$tplInfos}>
						<option value="<{$row.id}>"><{$row.tpl_name}></option>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<td>更新时间：</td>
				<td>
					<input type="time" name="update" id="update">
				</td>
			</tr>
			<tr>
				<td>是否启用：</td>
				<td>
					<input type="radio" name="isuse" value="1" checked>启用
					<input type="radio" name="isuse" value="0">禁用
				</td>
			</tr>
		</table>
		<input onclick="addEvaluInfo()" type="button" value="添加" style="margin:12px" />
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
				var optionStr = '<option value="0">请选择</option>'
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

	function addEvaluInfo(){
		var no = $('#no').val();
		var series = $('#series').val();
		
		if (no === ''){
			alert('请输入设备编号.');
			return;
		}// func
		
		if (series === ''){
			alert('请输入设备序列号');
			return;
		}// func
		
		var jg = $('#JG_ID').val();
		var tpl = $('#T_id').val();
		var update = $('#update').val();
		var isuse = $('input[name="isuse"]').val();
		var cno = $('#C_no').val();
		
		var url = "<{$baseUrl}>/index.php?control=evalu&action=saveEvalu";
		$.ajax({
			type: "post",
			url: url,
			data: "no="+no+'&series='+series+'&JG_ID='+jg+'&T_id='+tpl+'&update='+update+'&isuse='+isuse+'&cno='+cno,
			dataType:'json',
			success: function(data) {
				if (data > 0) alert('添加成功.');
				else alert('添加失败.');
			}
		}); // ajax
	}// func
</script>
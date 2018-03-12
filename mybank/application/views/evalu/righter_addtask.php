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
				<td>所属网点：</td>
				<td>
					<select name="JG_ID" id="JG_ID">
						<option value="0">请选择</option>
						<{foreach item=row from=$itsOrgArr}>
						<option value="<{$row.sysno}>"><{$row.sysname}></option>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<td>更新时间：</td>
				<td>
					<input type="time" name="updatetime" id="updatetime">
				</td>
			</tr>
		</table>
		<input onclick="addTaskInfo()" type="button" value="添加" style="margin:12px" />
	</div>
</div>
<!--content end-->
<script>
	function addTaskInfo(){
		var jgId = $('#JG_ID').val();
		var updatetime = $('#updatetime').val();
		
		if (jgId == 0){
			alert('请选择机构.');
			return;
		}// func
		
		if (updatetime == ''){
			alert('请输入信息包更新时间');
			return;
		}// func
		
		var url = "<{$baseUrl}>/index.php?control=evalu&action=saveTask";
		$.ajax({
			type: "post",
			url: url,
			data: 'jgId='+jgId+'&updatetime='+updatetime,
			success: function(data) {
				if (data > 0) alert('添加成功.');
				else alert('添加失败.');
			}
		}); // ajax
	}// func
</script>
	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=addTask" class="tool_add statItem">添加</a>
			<!--<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><{$COMMON_EDIT|default:"编辑"}></a>-->
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem">删除</a>
		</div>
		<script>
		//	<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th>机构</th>
						<th>添加时间</th>
						<th>添加用户</th>
						<th>管理</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<script>
	window.onload=function(){
		getTaskParam();
	}
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					console.dir($(this));
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		
		// 进入编辑界面
		location.href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=editEvalu&eId="+paramId;
	}// func
	
	// 获取公共参数数据
	function getTaskParam(){
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=getTask";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			dataType:'json',
			success: function(data) {
				$('#tbCounterPram > tbody').html('');
				var paramObjs = data;
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCounterPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var time = paramInfo.createtime.substring(0, paramInfo.createtime.indexOf('.'));
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.id+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.JG_name+'</td>'+
						  '<td>'+time+'</td>'+
						  '<td>'+paramInfo.username+'</td>'+
						  '<td><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=taskdetail&taskid='+paramInfo.id+'" style="text-decoration:underline">查看设备</a></td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=deleteTask";
		
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('删除成功.');
					getTaskParam();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:addText()" class="tool_add statItem">添加文本</a>
			<a auth="u" href="javascript:editText()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteRes()" class="tool_del statItem">删除</a>
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">编号</th>
						<th width="5%">状态</th>
						<th width="10%">文本名称</th>
						<th width="15%">文本大小</th>
						<!-- <th width="20%"><{$RES_RIGHTER_TABLE_FILEPATH|default:"文件路径"}></th> -->
						<th width="15%">录入时间</th>
						<th width="15%">录入用户代码</th>
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
	// 文件上传对象
	window.onload = function () { // Do something... 	
		getResList();
	}
	
	// 添加文本
	function addText(){
		var title = '添加文本';
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=addText";
		popWin.showWin("820","600",title,url);
	}
	
	// 编辑文本
	function editText(){
		var checkedCnt = 0;
		var resid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				resid = $(this).attr('id');
				checkedCnt++;
			}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		
		var title = '编辑文本';
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editText&resid="+resid;
		popWin.showWin("820","600",title,url);
	}
	
	// 获取资源列表
	function getResList(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=3',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var resObjs = eval('(' + data + ')');
				var resStr = "";
				for (var idx in resObjs){
					resStr = generateRes(resObjs[idx]);
					$('#tbCommonPram > tbody').append(resStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateRes(res){
		var status;
		if (res.status == 1){
			status = '已审核';
		}else{
			status = '<span style="color:red">未审核<span>';
		}
	
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+res.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+res.id+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td title="点击预览"><span style="cursor:pointer" onclick="showRes(\''+res.name+'\', \'<?php echo $session['baseurl']; ?>/index.php?control=resource&action=checkRes&resid='+res.id+'\')">'+res.name+'</span></td>'+
						  '<td>'+res.size+'</td>'+
						  //'<td>'+res.path+'</td>'+
						  '<td>'+res.create_time+'</td>'+
						  '<td>'+res.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	 
	// 展示路线封面
	function uploadSuccessRoute(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("完成上传.");
			progress.toggleCancel(false);
		} catch (ex) {
			this.debug(ex);
		}
	}
	
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 删除资源
	function deleteRes(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteRes";
		$.ajax({
			type: "post",
			url: url,
			data: "resids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('删除成功.');
					getResList();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
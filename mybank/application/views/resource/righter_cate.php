	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editCate" class="tool_add statItem">添加分类</a>
			<a auth="u" href="javascript:updateCate()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteCate()" class="tool_del statItem">删除</a>
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
		//	<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%">序号</th>
						<th width="30%">分类名称</th>
						<th width="30%">录入时间</th>
						<th width="30%">录入用户代码</th>
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
	window.onload = function(){
		getCateList();
	}
	// 获取分类列表
	function getCateList(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getCateList";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var cateObjs = JSON.parse(data);
				var cateStr = "";
				for (var idx in cateObjs){
					cateStr = generateCate(cateObjs[idx]);
					$('#tbCommonPram > tbody').append(cateStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateCate(cate){
		var parts = cate.create_time.split('.');
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+cate.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+cate.sortno+'</td>'+
						  '<td>'+cate.cate_name+'</td>'+
						  '<td>'+parts[0]+'</td>'+
						  '<td>'+cate.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 跳转到修改新闻分类
	function updateCate(){
		var checkedCnt = 0;
		var tplid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				cateid = $(this).attr('id');
				checkedCnt++;
			}
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		location.href = '<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editCate&cateid='+cateid;
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
	
	// 删除分类
	function deleteCate(){
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
		console.log(deleteItemArr.join(',').trimcomma());
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteCate";
		$.ajax({
			type: "post",
			url: url,
			data: "cateids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == "")
				{
					alert('删除成功.');
					getCateList();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
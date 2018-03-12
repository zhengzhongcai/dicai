	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editItem" class="tool_add statItem">添加新闻</a>
			<a auth="u" href="javascript:updateItem()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteItem()" class="tool_del statItem">删除</a>
			<span style="padding-left:10px;border-left:1px solid #C7C7C7;">分类</span>
			<select id="newscate" onchange="changeCate()">
				<option value="0">全部</option>
			</select>
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
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%">序号</th>
						<th width="20%">条目名称</th>
						<th width="20%">所属分类</th>
						<th width="20%">录入时间</th>
						<th width="20%">录入用户代码</th>
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
		getItemList(0);
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getCateList";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				var cateObjs = JSON.parse(data);
				for (var idx in cateObjs){
					$('#newscate').append('<option value='+cateObjs[idx].id+'>'+cateObjs[idx].cate_name+'</option>');
				}// for
			}
		}); // ajax
	}
	
	// 根据分类获取新闻项
	function changeCate(){
		var cateid = $('#newscate').val();
		getItemList(cateid);
	}
	
	// 获取分类列表
	function getItemList(cateid){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getItemList";
		$.ajax({
			type: "post",
			url: url,
			data: 'cateid='+cateid,
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var itemObjs = JSON.parse(data);
				var itemStr = "";
				for (var idx in itemObjs){
					itemStr = generateItem(itemObjs[idx]);
					$('#tbCommonPram > tbody').append(itemStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateItem(item){
		var parts = item.create_time.split('.');
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+item.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+item.sortno+'</td>'+
						  '<td>'+item.item_name+'</td>'+
						  '<td>'+item.cate_name+'</td>'+
						  '<td>'+parts[0]+'</td>'+
						  '<td>'+item.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 跳转到修改新闻分类
	function updateItem(){
		var checkedCnt = 0;
		var tplid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				itemid = $(this).attr('id');
				checkedCnt++;
			}
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		location.href = '<?php echo $session['baseurl']; ?>/index.php?control=resource&action=editItem&itemid='+itemid;
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
	
	// 删除条目
	function deleteItem(){
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
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteItem";
		$.ajax({
			type: "post",
			url: url,
			data: "itemids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('删除成功.');
					getItemList(0);
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
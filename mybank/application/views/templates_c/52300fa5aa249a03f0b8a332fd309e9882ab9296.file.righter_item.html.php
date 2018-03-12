<?php /* Smarty version Smarty-3.1.8, created on 2013-08-23 11:22:02
         compiled from "G:\WWW\webmark\application/views\resource\righter_item.html" */ ?>
<?php /*%%SmartyHeaderCode:49675216d55ab12743-71120605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52300fa5aa249a03f0b8a332fd309e9882ab9296' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\resource\\righter_item.html',
      1 => 1376878259,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49675216d55ab12743-71120605',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
    'RES_RIGHTER_ITEM_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'RES_RIGHTER_ITEM_CATE' => 0,
    'RES_RIGHTER_ITEM_ALL' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_ITEM_SORTNO' => 0,
    'RES_RIGHTER_ITEM_NAME' => 0,
    'RES_RIGHTER_ITEM_BEYOND_CATE' => 0,
    'RES_RIGHTER_ITEM_ADDTIME' => 0,
    'RES_RIGHTER_ITEM_ADDUSERCODE' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5216d55ac057e9_86679415',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5216d55ac057e9_86679415')) {function content_5216d55ac057e9_86679415($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editItem" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_ADD']->value)===null||$tmp==='' ? "添加新闻" : $tmp);?>
</a>
			<a auth="u" href="javascript:updateItem()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteItem()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
			<span style="padding-left:10px;border-left:1px solid #C7C7C7;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_CATE']->value)===null||$tmp==='' ? "分类" : $tmp);?>
</span>
			<select id="newscate" onchange="changeCate()">
				<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_ALL']->value)===null||$tmp==='' ? "全部" : $tmp);?>
</option>
			</select>
		</div>
		<script>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				$('a[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['Operation'];?>
"]').css('display', 'inline-block');
			<?php } ?>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_SORTNO']->value)===null||$tmp==='' ? "序号" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_NAME']->value)===null||$tmp==='' ? "条目名称" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_BEYOND_CATE']->value)===null||$tmp==='' ? "所属分类" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_ADDTIME']->value)===null||$tmp==='' ? "录入时间" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ITEM_ADDUSERCODE']->value)===null||$tmp==='' ? "录入用户代码" : $tmp);?>
</th>
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getCateList";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getItemList";
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
		location.href = '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editItem&itemid='+itemid;
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=deleteItem";
		$.ajax({
			type: "post",
			url: url,
			data: "itemids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getItemList(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 16:41:45
         compiled from "G:\WWW\cdyh\application/views\resource\righter_cate.html" */ ?>
<?php /*%%SmartyHeaderCode:73452dce149e86375-62765308%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97f73917dbdec68dd9d694de0ebdb7ba2c992ec2' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\righter_cate.html',
      1 => 1376877759,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73452dce149e86375-62765308',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
    'RES_RIGHTER_CATE_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_CATE_SORTNO' => 0,
    'RES_RIGHTER_CATE_NAME' => 0,
    'RES_RIGHTER_CATE_ADDTIME' => 0,
    'RES_RIGHTER_CATE_ADDUSERCODE' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dce14a024721_36929249',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dce14a024721_36929249')) {function content_52dce14a024721_36929249($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editCate" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CATE_ADD']->value)===null||$tmp==='' ? "添加分类" : $tmp);?>
</a>
			<a auth="u" href="javascript:updateCate()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteCate()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
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
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CATE_SORTNO']->value)===null||$tmp==='' ? "序号" : $tmp);?>
</th>
						<th width="30%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CATE_NAME']->value)===null||$tmp==='' ? "分类名称" : $tmp);?>
</th>
						<th width="30%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CATE_ADDTIME']->value)===null||$tmp==='' ? "录入时间" : $tmp);?>
</th>
						<th width="30%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CATE_ADDUSERCODE']->value)===null||$tmp==='' ? "录入用户代码" : $tmp);?>
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
		getCateList();
	}
	// 获取分类列表
	function getCateList(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getCateList";
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		location.href = '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=editCate&cateid='+cateid;
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		console.log(deleteItemArr.join(',').trimcomma());
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=deleteCate";
		$.ajax({
			type: "post",
			url: url,
			data: "cateids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == "")
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCateList();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2013-11-15 18:25:34
         compiled from "G:\WWW\webmark\application/views\resource\righter_check.html" */ ?>
<?php /*%%SmartyHeaderCode:98675285c62cca9ee9-53272002%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddcc499bf7d806c2f406fb8aa66ccd8ee291ddb8' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\resource\\righter_check.html',
      1 => 1384511131,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98675285c62cca9ee9-53272002',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5285c62cee2202_53974959',
  'variables' => 
  array (
    'RES_RIGHTER_ALL' => 0,
    'RES_LEFTER_MENU_LIST_VIDEO' => 0,
    'RES_LEFTER_MENU_LIST_AUDIO' => 0,
    'RES_LEFTER_MENU_LIST_PIC' => 0,
    'RES_LEFTER_MENU_LIST_TEXT' => 0,
    'RES_RIGHTER_VIDEO_ADD' => 0,
    'COMMON_EDIT' => 0,
    'RES_RIGHTER_SETCHECK' => 0,
    'optArr' => 0,
    'row' => 0,
    'RES_RIGHTER_TABLE_ID' => 0,
    'RES_RIGHTER_STATUS' => 0,
    'RES_RIGHTER_TABLE_FILENAME' => 0,
    'RES_RIGHTER_TABLE_FILESIZE' => 0,
    'RES_RIGHTER_CHECK_TIME' => 0,
    'RES_RIGHTER_CHECK_MAN' => 0,
    'baseUrl' => 0,
    'RES_RIGHTER_CHECKED' => 0,
    'RES_RIGHTER_NOCHECK' => 0,
    'COMMON_CLICK_TO_PREVIEW' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5285c62cee2202_53974959')) {function content_5285c62cee2202_53974959($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="restype" id="restype" onchange="getResList()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_ALL']->value)===null||$tmp==='' ? "全部" : $tmp);?>
</option>
				<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_VIDEO']->value)===null||$tmp==='' ? "视频" : $tmp);?>
</option>
				<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_AUDIO']->value)===null||$tmp==='' ? "音频" : $tmp);?>
</option>
				<option value="2"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_PIC']->value)===null||$tmp==='' ? "图片" : $tmp);?>
</option>
				<option value="3"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_LEFTER_MENU_LIST_TEXT']->value)===null||$tmp==='' ? "文字" : $tmp);?>
</option>
			</select>
			<!--<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_VIDEO_ADD']->value)===null||$tmp==='' ? "添加视频" : $tmp);?>
</a>-->
			<!--<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>-->
			<a auth="u" href="javascript:setCheck()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_SETCHECK']->value)===null||$tmp==='' ? "通过审核" : $tmp);?>
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
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_ID']->value)===null||$tmp==='' ? "编号" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_STATUS']->value)===null||$tmp==='' ? "状态" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILENAME']->value)===null||$tmp==='' ? "文件名称" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TABLE_FILESIZE']->value)===null||$tmp==='' ? "文件大小" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CHECK_TIME']->value)===null||$tmp==='' ? "审核时间" : $tmp);?>
</th>
						<th width="15%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CHECK_MAN']->value)===null||$tmp==='' ? "审核人" : $tmp);?>
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
	window.onload = function () { // Do something... 	
		getResList();
	}
	
	// 获取资源列表
	function getResList(){
		var res_type = $('#restype').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type='+res_type,
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
			status = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_CHECKED']->value)===null||$tmp==='' ? "已审核" : $tmp);?>
';
		}else{
			status = '<span style="color:red"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_NOCHECK']->value)===null||$tmp==='' ? "未审核" : $tmp);?>
<span>';
		}
		
		if (res.checktime == null) res.checktime = '';
		if (res.username == null) res.username = '';
		
		var time = res.checktime.substring(0, res.checktime.indexOf('.'));
		
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+res.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+res.id+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CLICK_TO_PREVIEW']->value)===null||$tmp==='' ? "点击预览" : $tmp);?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid='+res.id+'" target="_blank">'+res.name+'</a></td>'+
						  '<td>'+res.size+'</td>'+
						  '<td>'+time+'</td>'+
						  '<td>'+res.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	 
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
	
	// 资源通过审核
	function setCheck(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要审核的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认通过审核!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=setcheck";
		
		$.ajax({
			type: "post",
			url: url,
			data: "resids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "处理成功." : $tmp);?>
');
					getResList();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "处理失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
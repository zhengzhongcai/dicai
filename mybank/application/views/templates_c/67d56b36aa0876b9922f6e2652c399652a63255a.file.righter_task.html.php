<?php /* Smarty version Smarty-3.1.8, created on 2013-11-15 17:57:58
         compiled from "G:\WWW\webmark\application/views\evalu\righter_task.html" */ ?>
<?php /*%%SmartyHeaderCode:57352846851264fa1-58140562%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67d56b36aa0876b9922f6e2652c399652a63255a' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\evalu\\righter_task.html',
      1 => 1384509475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57352846851264fa1-58140562',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_528468513d4f47_58463888',
  'variables' => 
  array (
    'baseUrl' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'EVALU_RIGHTER_JGSP' => 0,
    'EVALU_RIGHTER_ADD_TIME' => 0,
    'EVALU_RIGHTER_ADD_USER' => 0,
    'EVALU_RIGHTER_MAN' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'EVALU_RIGHTER_CHECK' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_528468513d4f47_58463888')) {function content_528468513d4f47_58463888($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=addTask" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<!--<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>-->
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
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
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_JGSP']->value)===null||$tmp==='' ? "机构" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ADD_TIME']->value)===null||$tmp==='' ? "添加时间" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_ADD_USER']->value)===null||$tmp==='' ? "添加用户" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_MAN']->value)===null||$tmp==='' ? "管理" : $tmp);?>
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		
		// 进入编辑界面
		location.href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=editEvalu&eId="+paramId;
	}// func
	
	// 获取公共参数数据
	function getTaskParam(){
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=getTask";
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
						  '<td><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=taskdetail&taskid='+paramInfo.id+'" style="text-decoration:underline"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_CHECK']->value)===null||$tmp==='' ? "查看设备" : $tmp);?>
</a></td>'+
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=deleteTask";
		
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getTaskParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
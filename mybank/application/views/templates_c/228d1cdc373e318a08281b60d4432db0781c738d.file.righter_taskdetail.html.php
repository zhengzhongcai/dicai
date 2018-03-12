<?php /* Smarty version Smarty-3.1.8, created on 2014-01-21 14:54:23
         compiled from "G:\WWW\cdyh\application/views\evalu\righter_taskdetail.html" */ ?>
<?php /*%%SmartyHeaderCode:1508652de199fe52ef8-30261807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '228d1cdc373e318a08281b60d4432db0781c738d' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\evalu\\righter_taskdetail.html',
      1 => 1384509858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1508652de199fe52ef8-30261807',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMON_BACK' => 0,
    'baseUrl' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'EVALU_RIGHTER_COUNTER_NO' => 0,
    'EVALU_RIGHTER_DEVICE_NO' => 0,
    'EVALU_RIGHTER_DEVICE_SERIES' => 0,
    'EVALU_RIGHTER_UPDATE_STATUS' => 0,
    'details' => 0,
    'EVALU_RIGHTER_UPDATING' => 0,
    'EVALU_RIGHTER_UPDATED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52de19a001e4b0_68523889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52de19a001e4b0_68523889')) {function content_52de19a001e4b0_68523889($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<a href="javascript:history.go(-1)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BACK']->value)===null||$tmp==='' ? "返回" : $tmp);?>
</a>
			<!--<a auth="c" href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&action=addTask" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>-->
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
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_COUNTER_NO']->value)===null||$tmp==='' ? "所属窗口" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_NO']->value)===null||$tmp==='' ? "设备编号" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_DEVICE_SERIES']->value)===null||$tmp==='' ? "设备序列号" : $tmp);?>
</th>
						<th><?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_UPDATE_STATUS']->value)===null||$tmp==='' ? "更新状态" : $tmp);?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['details']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<tr>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['C_no'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['E_no'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['row']->value['E_series'];?>
</td>
							<td>
								<?php if ($_smarty_tpl->tpl_vars['row']->value['status']==0){?>
									<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_UPDATING']->value)===null||$tmp==='' ? "等待更新..." : $tmp);?>

								<?php }else{ ?>
									<?php echo (($tmp = @$_smarty_tpl->tpl_vars['EVALU_RIGHTER_UPDATED']->value)===null||$tmp==='' ? "已更新" : $tmp);?>

								<?php }?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end--><?php }} ?>
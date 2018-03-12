<?php /* Smarty version Smarty-3.1.8, created on 2017-03-21 14:19:21
         compiled from "D:\bankSct2\BANK\application/views\device\lefter_adv.html" */ ?>
<?php /*%%SmartyHeaderCode:2197558d0c5e9b0f8e5-26757447%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e547dbeda2fbd1f6b8225f6e3c1a7f54b2c3184' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\device\\lefter_adv.html',
      1 => 1490003889,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2197558d0c5e9b0f8e5-26757447',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DEVICE_LEFTER_MENU_TITLE' => 0,
    'baseUrl' => 0,
    'DEVICE_LEFTER_MENU_ORG' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58d0c5e9ba47d8_93085119',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58d0c5e9ba47d8_93085119')) {function content_58d0c5e9ba47d8_93085119($_smarty_tpl) {?><!--content-->
<div class="content">
	<!----left---->
	<div class="left_box">
		<div class="left_menu">
			<h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_LEFTER_MENU_TITLE']->value)===null||$tmp==='' ? "设备管理" : $tmp);?>
</h2>
			<div class="left_menu_tab">
				<ul>
					<li class="li1" style="width:100%"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device" class="on"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_LEFTER_MENU_ORG']->value)===null||$tmp==='' ? "组织架构" : $tmp);?>
</a></li>
				</ul>
			</div>
			<div class="left_menu_tab">
				<ul>
					<li class="li1" style="width:100%"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=adMachine" class="on">广告机器</a></li>
				</ul>
			</div>
		</div>
	</div>

<a onclick="hiddenLeft()" class="hidden_left" style="background-color:#EEECED"></a>

<!----left end---->
<script>
	<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fcodeArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
	$('li[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['F_code'];?>
"]').css('display', 'block');
	<?php } ?>
</script>
	<!----left end---->
<?php }} ?>
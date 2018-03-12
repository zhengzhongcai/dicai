<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:22:30
         compiled from "D:\WWW\cdbank\application/views\device\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:646657fdf2c61f42b8-51541021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f90b9366e64d80e92658acdb7bb3a555682cd8da' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\device\\lefter.html',
      1 => 1376641344,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '646657fdf2c61f42b8-51541021',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DEVICE_LEFTER_MENU_TITLE' => 0,
    'DEVICE_LEFTER_MENU_ORG' => 0,
    'orgTreeStr' => 0,
    'fcodeArr' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf2c63a3cf7_32745488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf2c63a3cf7_32745488')) {function content_57fdf2c63a3cf7_32745488($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_LEFTER_MENU_TITLE']->value)===null||$tmp==='' ? "设备管理" : $tmp);?>
</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="#" class="on"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_LEFTER_MENU_ORG']->value)===null||$tmp==='' ? "组织架构" : $tmp);?>
</a></li>
        </ul>
      </div>
      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">
			<?php echo $_smarty_tpl->tpl_vars['orgTreeStr']->value;?>

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
  </script><?php }} ?>
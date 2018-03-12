<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 15:20:43
         compiled from "G:\WWW\cdyh\application/views\device\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:1485052dcce4b9fba53-27771990%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c3435ad8c2865d3ce57feba7c94007c3954df57' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\device\\lefter.html',
      1 => 1376641343,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1485052dcce4b9fba53-27771990',
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
  'unifunc' => 'content_52dcce4ba6b062_31588769',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce4ba6b062_31588769')) {function content_52dcce4ba6b062_31588769($_smarty_tpl) {?><!--content-->
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
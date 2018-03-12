<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:22:21
         compiled from "D:\WWW\cdbank\application/views\statistic\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:2765757fdf2bdcc13f7-76527287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0085c055510102864c74c1149850d1552e010f22' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\statistic\\lefter.html',
      1 => 1376566978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2765757fdf2bdcc13f7-76527287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'STAT_LEFT_TABLE' => 0,
    'STAT_LEFT_ORG' => 0,
    'orgTreeStr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf2bddfb565_98591946',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf2bddfb565_98591946')) {function content_57fdf2bddfb565_98591946($_smarty_tpl) {?><!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_LEFT_TABLE']->value)===null||$tmp==='' ? "统计报表" : $tmp);?>
</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="#" class="on"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_LEFT_ORG']->value)===null||$tmp==='' ? "组织架构" : $tmp);?>
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
  <!----left end----><?php }} ?>
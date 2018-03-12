<?php /* Smarty version Smarty-3.1.8, created on 2013-08-19 16:27:18
         compiled from "G:\WWW\webmark\application/views\statistic\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:122585211d6e6497f30-67501004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3e46ef8a225972bcf1a5ac3475563275da255b8' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\statistic\\lefter.html',
      1 => 1376566976,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '122585211d6e6497f30-67501004',
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
  'unifunc' => 'content_5211d6e65b00e3_15962827',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211d6e65b00e3_15962827')) {function content_5211d6e65b00e3_15962827($_smarty_tpl) {?><!--content-->
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
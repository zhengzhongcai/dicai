<?php /* Smarty version Smarty-3.1.8, created on 2017-03-15 17:31:32
         compiled from "D:\bankSct2\BANK\application/views\statistic\lefter.html" */ ?>
<?php /*%%SmartyHeaderCode:2647258c909f460b373-96398484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd08831197c2885faeeae7e8b37a7cc406c2cb838' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\statistic\\lefter.html',
      1 => 1376566978,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2647258c909f460b373-96398484',
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
  'unifunc' => 'content_58c909f464f609_22942236',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909f464f609_22942236')) {function content_58c909f464f609_22942236($_smarty_tpl) {?><!--content-->
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
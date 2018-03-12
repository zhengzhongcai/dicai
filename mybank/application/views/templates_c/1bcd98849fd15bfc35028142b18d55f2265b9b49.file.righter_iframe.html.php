<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 15:15:51
         compiled from "D:\bankSct2\BANK\application/views\device\righter_iframe.html" */ ?>
<?php /*%%SmartyHeaderCode:469958c90a0121d554-31976564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bcd98849fd15bfc35028142b18d55f2265b9b49' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\device\\righter_iframe.html',
      1 => 1490866943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '469958c90a0121d554-31976564',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c90a012455b6_66723610',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c90a012455b6_66723610')) {function content_58c90a012455b6_66723610($_smarty_tpl) {?><input id="orgId" type="hidden"/>
	<!----right---->
	<div class="right_box" style="height:600px;">
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
	<div style="height:100%">
	<iframe frameborder="0" style="height:100%; width:100%;  overflow-x:hidden " src="/CI/index.php/client/getClientInfo"></iframe>
	</div>
</div><?php }} ?>
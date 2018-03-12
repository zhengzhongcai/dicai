<?php /* Smarty version Smarty-3.1.8, created on 2017-03-17 13:50:36
         compiled from "D:\bankSct2\BANK\application/views\evalu\righter_iframe.html" */ ?>
<?php /*%%SmartyHeaderCode:2760558cb792ce8df10-30244933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69bc8b44d7b44f12afb356431aa53e2349df8880' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\evalu\\righter_iframe.html',
      1 => 1489549419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2760558cb792ce8df10-30244933',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'src' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58cb792cec2703_68279145',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58cb792cec2703_68279145')) {function content_58cb792cec2703_68279145($_smarty_tpl) {?><input id="orgId" type="hidden"/>
	<!----right---->
	<div class="right_box">
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
	<div style="height:100%">

	<iframe frameborder="0" style="height:100%; width:100%;  overflow-x:hidden " src="<?php echo $_smarty_tpl->tpl_vars['src']->value;?>
"></iframe>
	</div>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 15:20:30
         compiled from "G:\WWW\cdyh\application/views\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:290952dcce3e5e2fe1-56981131%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19d5076059c32776cce5df8eb51ffcef0b7f2658' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\footer.html',
      1 => 1376903622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '290952dcce3e5e2fe1-56981131',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMON_COPY_RIGHT' => 0,
    'COMMON_MIN' => 0,
    'COMMON_SEC' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcce3e613ae8_13394585',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce3e613ae8_13394585')) {function content_52dcce3e613ae8_13394585($_smarty_tpl) {?><div class="foot">
  <p><?php echo $_smarty_tpl->tpl_vars['COMMON_COPY_RIGHT']->value;?>
</p>
</div>
<script src="assets/js/common.js"></script>
<script>
// 格式化时间
function formateTiemStr(second){
	var minute = 0;
	if (second > 60) 
	{
		minute = parseInt(second/60);
		second = second%60;
	}// if
	return minute+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_MIN']->value)===null||$tmp==='' ? "分" : $tmp);?>
'+second+'<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_SEC']->value)===null||$tmp==='' ? "秒" : $tmp);?>
';
}// func
</script>
</body>
</html>
<?php }} ?>
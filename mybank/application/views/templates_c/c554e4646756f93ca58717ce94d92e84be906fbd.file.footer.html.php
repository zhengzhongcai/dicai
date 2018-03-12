<?php /* Smarty version Smarty-3.1.8, created on 2017-03-09 09:42:29
         compiled from "D:\WWW\cdbank\application/views\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:2686657fdf16f719012-72861644%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c554e4646756f93ca58717ce94d92e84be906fbd' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\footer.html',
      1 => 1489023747,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2686657fdf16f719012-72861644',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf16f742e45_24783054',
  'variables' => 
  array (
    'COMMON_COPY_RIGHT' => 0,
    'COMMON_MIN' => 0,
    'COMMON_SEC' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf16f742e45_24783054')) {function content_57fdf16f742e45_24783054($_smarty_tpl) {?><div class="foot">
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
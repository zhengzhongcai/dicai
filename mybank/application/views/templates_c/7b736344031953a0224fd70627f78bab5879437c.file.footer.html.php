<?php /* Smarty version Smarty-3.1.8, created on 2013-08-19 17:13:54
         compiled from "G:\WWW\webmark\application/views\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:105935211c71b757d69-38853117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b736344031953a0224fd70627f78bab5879437c' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\footer.html',
      1 => 1376903622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105935211c71b757d69-38853117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5211c71b760d84_18419797',
  'variables' => 
  array (
    'COMMON_COPY_RIGHT' => 0,
    'COMMON_MIN' => 0,
    'COMMON_SEC' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211c71b760d84_18419797')) {function content_5211c71b760d84_18419797($_smarty_tpl) {?><div class="foot">
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
<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 14:59:41
         compiled from "E:\WWW\cdbank\application/views\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:1870755b333dd983928-18881065%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5996b4f7fa0bda844b96998777bc17715d364e04' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\footer.html',
      1 => 1376903624,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1870755b333dd983928-18881065',
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
  'unifunc' => 'content_55b333dd993a70_62435674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b333dd993a70_62435674')) {function content_55b333dd993a70_62435674($_smarty_tpl) {?><div class="foot">
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
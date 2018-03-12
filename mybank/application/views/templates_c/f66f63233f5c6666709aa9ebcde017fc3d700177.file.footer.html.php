<?php /* Smarty version Smarty-3.1.8, created on 2017-03-15 17:31:09
         compiled from "D:\bankSct2\BANK\application/views\footer.html" */ ?>
<?php /*%%SmartyHeaderCode:1212158c89ff9c3c9f4-55421309%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f66f63233f5c6666709aa9ebcde017fc3d700177' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\footer.html',
      1 => 1489549419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1212158c89ff9c3c9f4-55421309',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c89ff9c49f04_15127705',
  'variables' => 
  array (
    'COMMON_COPY_RIGHT' => 0,
    'COMMON_MIN' => 0,
    'COMMON_SEC' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c89ff9c49f04_15127705')) {function content_58c89ff9c49f04_15127705($_smarty_tpl) {?><div class="foot">
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
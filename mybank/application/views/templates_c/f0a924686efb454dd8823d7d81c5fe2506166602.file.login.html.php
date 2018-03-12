<?php /* Smarty version Smarty-3.1.8, created on 2013-08-22 09:42:37
         compiled from "G:\WWW\webmark\application/views\login.html" */ ?>
<?php /*%%SmartyHeaderCode:2701952156c8d295085-04402779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0a924686efb454dd8823d7d81c5fe2506166602' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\login.html',
      1 => 1376556051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2701952156c8d295085-04402779',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LOGIN_SYS_NAME' => 0,
    'LOGIN_LOGINBOX_TITLE' => 0,
    'LOGIN_FORGET_PASS' => 0,
    'LOGIN_EN' => 0,
    'baseUrl' => 0,
    'LOGIN_INPUT_ACOUNT_TIP' => 0,
    'LOGIN_INPUT_PASS_TIP' => 0,
    'COMMON_COPY_RIGHT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52156c8d6427b6_87485663',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52156c8d6427b6_87485663')) {function content_52156c8d6427b6_87485663($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登录</title>
<link href="assets/css/login.css" rel="stylesheet" type="text/css" />
<link href="assets/css/head_foot.css" rel="stylesheet" type="text/css" />
<script src="assets/js/jquery.js"></script>
</head>

<body class="login_bg">
<!--top-->
<div class="top_bar">
  <div class="top_bar_left"> </div>
  <div class="top_bar_middle"></div>
</div><!--top end-->

<!--login_content-->
<div class="login_content">
	<h1 class="login_h1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_SYS_NAME']->value)===null||$tmp==='' ? "排号机联网监控系统" : $tmp);?>
</h1>
	<div class="login_box">
		<div class="login_title"><h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_LOGINBOX_TITLE']->value)===null||$tmp==='' ? "登录排号机联网监控系统" : $tmp);?>
</h2></div>
		<div class="login_form">
			<input name="fade_username" type="input" class="login_id" />
			<input name="fade_password" type="password" class="login_pw" />
			<p><a href="#"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_FORGET_PASS']->value)===null||$tmp==='' ? "忘记密码？" : $tmp);?>
</a></p>
			<p>
				<input type="button" class="btn_login" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_EN']->value)===null||$tmp==='' ? "登录" : $tmp);?>
" onclick="login()" />
			</p>
		</div>
	</div>
</div><!--login_content end-->
<form id="loginForm" action="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=welcome&action=login" method="post">
	<input type="hidden" name="username">
	<input type="hidden" name="password">
</form>

<script>
	 $("body").keydown(function() {
		 if (event.keyCode == "13") {//keyCode=13是回车键
			 login();
		 }
	 });
	function login(){
		var username = $('input[name="fade_username"]').val();
		var password = $('input[name="fade_password"]').val();
		if ("" == username){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_INPUT_ACOUNT_TIP']->value)===null||$tmp==='' ? "请输入登录账号." : $tmp);?>
');
			return;
		}
		if ("" == password)
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['LOGIN_INPUT_PASS_TIP']->value)===null||$tmp==='' ? "请输入密码." : $tmp);?>
');
			return;
		}
		$('input[name="username"]').val(username);
		$('input[name="password"]').val(password);
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=welcome&action=login";
		$.ajax({
			type: "post",
			url: url,
			data: "username=" + username + '&password=' + password,
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=dashboard";
					location.href = url;
				}// 
				else
					alert(data);
			}
		}); // ajax
		//$('#loginForm').submit();
	}// func
</script>

<div class="foot">
  <p><?php echo $_smarty_tpl->tpl_vars['COMMON_COPY_RIGHT']->value;?>
</p>
</div>
</body>
</html>
<?php }} ?>
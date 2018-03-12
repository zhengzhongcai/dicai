<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 16:25:53
         compiled from "G:\WWW\cdyh\application/views\header.html" */ ?>
<?php /*%%SmartyHeaderCode:2515852dcce3e14fbe9-23536261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '108ac85f143e3ae3156f0c664abecc6cf18ebb14' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\header.html',
      1 => 1390206030,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2515852dcce3e14fbe9-23536261',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dcce3e37a6c8_17009532',
  'variables' => 
  array (
    'COMMON_HEADER_YEAR' => 0,
    'COMMON_HEADER_MONTH' => 0,
    'COMMON_HEADER_DAY' => 0,
    'COMMON_HEADER_WELCOME' => 0,
    'admin' => 0,
    'roleName' => 0,
    'COMMON_HEADER_SET_LANG' => 0,
    'COMMON_HEADER_CHANGE_PASS' => 0,
    'baseUrl' => 0,
    'COMMON_HEADER_LOGOUT' => 0,
    'COMMON_HEADER_SYS_NAME' => 0,
    'control' => 0,
    'COMMON_HEADER_MONITOR' => 0,
    'COMMON_HEADER_STAT' => 0,
    'COMMON_HEADER_DATA' => 0,
    'COMMON_HEADER_AGENCY' => 0,
    'COMMON_HEADER_DEVICE' => 0,
    'COMMON_HEADER_RESOURCE' => 0,
    'COMMON_HEADER_EVALU' => 0,
    'COMMON_HEADER_AUTH' => 0,
    'COMMON_CHANGE_PASS_BOX_TITLE' => 0,
    'COMMON_CHANGE_PASS_BOX_OLD' => 0,
    'COMMON_CHANGE_PASS_BOX_NEW' => 0,
    'COMMON_CHANGE_PASS_BOX_RE' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'COMMON_CHANGE_LANG_BOX_TITLE' => 0,
    'langList' => 0,
    'lang' => 0,
    'COMMON_CHANGE_PASS_TIP1' => 0,
    'COMMON_CHANGE_PASS_TIP2' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
    'COMMON_HEADER_SUM' => 0,
    'COMMON_HEADER_MON' => 0,
    'COMMON_HEADER_TUS' => 0,
    'COMMON_HEADER_WED' => 0,
    'COMMON_HEADER_THUR' => 0,
    'COMMON_HEADER_FRI' => 0,
    'COMMON_HEADER_SAT' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dcce3e37a6c8_17009532')) {function content_52dcce3e37a6c8_17009532($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>成都银行</title>
<link href="assets/css/head_foot.css" rel="stylesheet" type="text/css" />
<link href="assets/css/common.css" rel="stylesheet" type="text/css" />
<link href="assets/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
<link href="assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="assets/tachyon/css/jquery.visualize.css" rel="stylesheet" type="text/css" />

<script src="assets/js/jquery.js"></script>
<script src="assets/js/popwin.js"></script>
<script src="assets/js/jquery.treeview.js"></script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/tachyon/js/jquery/jquery.visualize.js"></script>
<script src="assets/js/md5.js"></script>

</head>

<body>
<!--top-->
<div class="top_bar">
  <div class="top_bar_left">
    <div class="top_bar_time">
		<span id="nav_year"></span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_YEAR']->value)===null||$tmp==='' ? "年" : $tmp);?>
<span id="nav_month"></span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_MONTH']->value)===null||$tmp==='' ? "月" : $tmp);?>
<span id="nav_date"></span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_DAY']->value)===null||$tmp==='' ? "日" : $tmp);?>

		<span id="nav_day"></span>
	</div>
  </div>
  <div class="top_bar_middle"></div>
  <div class="top_bar_right">
	<!--
    <p>欢迎您！<a href="#">[超级管理员]</a><a href="#">[成都银行总行]</a> </p>
	-->
	<p><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_WELCOME']->value)===null||$tmp==='' ? "欢迎您！" : $tmp);?>
<a href="#">[<?php echo $_smarty_tpl->tpl_vars['admin']->value;?>
]</a> [<?php echo $_smarty_tpl->tpl_vars['roleName']->value;?>
]</p>
	<a href="javascript:changeLangBox()">[<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_SET_LANG']->value)===null||$tmp==='' ? "语言设置" : $tmp);?>
]</a>
    <a href="javascript:changePassBox()" class="change_pw"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_CHANGE_PASS']->value)===null||$tmp==='' ? "修改密码" : $tmp);?>
</a><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=welcome&action=loginout" class="canceled"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_LOGOUT']->value)===null||$tmp==='' ? "注销" : $tmp);?>
</a></div>
</div>
<!--top end--> 

<!--head-->
<div class="head_bar">
  <h1><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_SYS_NAME']->value)===null||$tmp==='' ? "排号机联网监控系统" : $tmp);?>
</h1>
  <div class="menu">
    <ul>
		<li auth="monitor" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&fcode=monitor" <?php if ($_smarty_tpl->tpl_vars['control']->value=="monitor"){?>class="on"<?php }?>><i class="icon_monitor"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_MONITOR']->value)===null||$tmp==='' ? "实时监控" : $tmp);?>
</a></li>
		<li auth="report" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&fcode=report" <?php if ($_smarty_tpl->tpl_vars['control']->value=="statistic"){?>class="on"<?php }?>><i class="icon_statistic"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_STAT']->value)===null||$tmp==='' ? "统计报表" : $tmp);?>
</a></li>
		<li auth="data" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&fcode=data" <?php if ($_smarty_tpl->tpl_vars['control']->value=="basedata"){?>class="on"<?php }?>><i class="icon_basedata"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_DATA']->value)===null||$tmp==='' ? "数据管理" : $tmp);?>
</a></li>
		<li auth="organization" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&fcode=organization" <?php if ($_smarty_tpl->tpl_vars['control']->value=="institution"){?>class="on"<?php }?>><i class="icon_institution"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_AGENCY']->value)===null||$tmp==='' ? "机构管理" : $tmp);?>
</a></li>
		<li auth="device" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&fcode=device" <?php if ($_smarty_tpl->tpl_vars['control']->value=="device"){?>class="on"<?php }?>><i class="icon_device"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_DEVICE']->value)===null||$tmp==='' ? "设备管理" : $tmp);?>
</a></li>
		<li auth="resource" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&fcode=resource" <?php if ($_smarty_tpl->tpl_vars['control']->value=="resource"){?>class="on"<?php }?>><i class="icon_resource"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_RESOURCE']->value)===null||$tmp==='' ? "资源管理" : $tmp);?>
</a></li>
		<li auth="evalu" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=evalu&fcode=evalu" <?php if ($_smarty_tpl->tpl_vars['control']->value=="evalu"){?>class="on"<?php }?>><i class="icon_evalu"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_EVALU']->value)===null||$tmp==='' ? "评价器管理" : $tmp);?>
</a></li>
		<li auth="authority" class="statItem"><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&fcode=authority" <?php if ($_smarty_tpl->tpl_vars['control']->value=="authority"){?>class="on"<?php }?>><i class="icon_authority"></i><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_AUTH']->value)===null||$tmp==='' ? "权限管理" : $tmp);?>
</a></li>
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
			alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_TIP1']->value)===null||$tmp==='' ? "请输入全部信息." : $tmp);?>
");
			return;
		}
		
		if (rePass != newPass){
			alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_CHANGE_PASS_TIP2']->value)===null||$tmp==='' ? "请确认新密码重复输入正确." : $tmp);?>
");
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
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_SUM']->value)===null||$tmp==='' ? "星期日" : $tmp);?>
";
			break;
		case 1:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_MON']->value)===null||$tmp==='' ? "星期一" : $tmp);?>
";
			break;
		case 2:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_TUS']->value)===null||$tmp==='' ? "星期二" : $tmp);?>
";
			break;
		case 3:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_WED']->value)===null||$tmp==='' ? "星期三" : $tmp);?>
";
			break;
		case 4:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_THUR']->value)===null||$tmp==='' ? "星期四" : $tmp);?>
";
			break;
		case 5:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_FRI']->value)===null||$tmp==='' ? "星期五" : $tmp);?>
";
			break;
		case 6:
			day="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_HEADER_SAT']->value)===null||$tmp==='' ? "星期六" : $tmp);?>
";
			break;
	}// swith
	$('#nav_year').html(year);
	$('#nav_month').html(month);
	$('#nav_date').html(date);
	$('#nav_day').html(day);
</script><?php }} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>成都银行</title>
	<link href="assets/css/head_foot.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/common.css" rel="stylesheet" type="text/css" />
	<base href="<?php echo base_url(); ?>" />
	<link href="assets/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
	<link href="assets/tachyon/css/jquery.visualize.css" rel="stylesheet" type="text/css" />


    <script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery-min.js"></script>
	<script type="text/javascript" src="application/views/javaScript/main.page.js"></script>
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
	<script language="JavaScript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
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
	<script type="text/javascript">
		$(function() {
			$('#demo6').lightTreeview({
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
			<span id="nav_year"></span><?= lang('HEADER_YEAR')?lang('HEADER_YEAR'):'年'?><span id="nav_month"></span><?= lang('HEADER_MONTH')?lang('HEADER_MONTH'):'月'?><span id="nav_date"></span><?= lang('HEADER_DAY')?lang('HEADER_DAY'):'日'?>
			<span id="nav_day"></span>
		</div>
	</div>
	<div class="top_bar_middle"></div>
	<div class="top_bar_right">
		<!--
        <p>欢迎您！<a href="#">[超级管理员]</a><a href="#">[成都银行总行]</a> </p>
        -->
		<p><?=lang('HEADER_WELCOMY')?lang('HEADER_WELCOMY'):'欢迎您！'?><a href="<?php echo $session['baseurl']; ?>/index.php?control=monitor&fcode=monitor"><?php echo $session['username']; ?></a>[<?php echo $session['rolename']; ?>]</p>
		<a  href="javascript:editParamCheck1('<?php echo $session['roleId']; ?>')"><?=lang('HEADER_ROLE')?lang('HEADER_ROLE'):'[权限查看]'?></a>
		<a href="javascript:changeLangBox()"><?=lang('HEADER_SET_LANG')?lang('HEADER_SET_LANG'):'语言设置'?></a>
		<a href="javascript:changePassBox()" class="change_pw"><?=lang('HEADER_CHANGE_PASS')?lang('HEADER_CHANGE_PASS'):'密码修改'?></a><a href="<?php echo $session['baseurl']; ?>/index.php?control=welcome&action=loginout" class="canceled"><?=lang('HEADER_LOGOUT')?lang('HEADER_LOGOUT'):'注销'?></a></div>
</div>
<!--top end-->

<!--head-->
<div class="head_bar">
	<h1><?=lang('HEADER_SYS_NAME')?lang('HEADER_SYS_NAME'):'排号机联网监控系统'?></h1>
	<div class="menu">
		<ul>
			<li auth="299" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=monitor&fcode=monitor" ><i class="icon_monitor"></i>实时监控</a></li>
			<li auth="302" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=play&fcode=monitor" ><i class="icon_play"></i>节目播放管理</a></li>
			<li auth="304" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=statistic&fcode=report" ><i class="icon_statistic"></i>统计报表</a></li>
			<li auth="306" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&fcode=data" ><i class="icon_basedata"></i>数据管理</a></li>
			<li auth="308" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=institution&fcode=organization" ><i class="icon_institution"></i>机构管理</a></li>
			<li auth="310" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=device&fcode=device" ><i class="icon_device"></i>设备管理</a></li>
			<li auth="312" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=resource&fcode=resource" ><i class="icon_resource"></i>资源管理</a></li>
			<li auth="314" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&fcode=evalu"><i class="icon_evalu"></i>信息发布管理</a></li>
			<li auth="316" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=authority&fcode=authority" ><i class="icon_authority"></i>权限管理</a></li>
			<!--
			<li auth="299" class="statItem"><a href="<{$baseUrl}>/index.php?control=monitor&fcode=monitor"><i class="icon_monitor"></i>实时监控</a></li>
			<li auth="302" class="statItem"><a href="<{$baseUrl}>/index.php?control=play&fcode=monitor" ><i class="icon_play"></i>节目播放管理<a></li>
			<li auth="304" class="statItem"><a href="<{$baseUrl}>/index.php?control=statistic&fcode=report" ><i class="icon_statistic"></i>统计报表</a></li>
			<li auth="306" class="statItem"><a href="<{$baseUrl}>/index.php?control=basedata&fcode=data" ><i class="icon_basedata"></i>数据管理<a></li>
			<li auth="308" class="statItem"><a href="<{$baseUrl}>/index.php?control=institution&fcode=organization" ><i class="icon_institution"></i>机构管理</a></li>
			<li auth="310" class="statItem"><a href="<{$baseUrl}>/index.php?control=device&fcode=device" ><i class="icon_device"></i>设备管理</a></li>
			<li auth="312" class="statItem"><a href="<{$baseUrl}>/index.php?control=resource&fcode=resource"><i class="icon_resource"></i>资源管理</a></li>
			<li auth="314" class="statItem"><a href="<{$baseUrl}>/index.php?control=evalu&fcode=evalu" ><i class="icon_evalu"></i>信息发布管理</a></li>
			<li auth="316" class="statItem"><a href="<{$baseUrl}>/index.php?control=authority&fcode=authority" ><i class="icon_authority"></i>权限管理</a></li>
			-->
		</ul>
	</div>
</div>

<div id="changePass" class="pass_pop_box" style="display:none;z-index:9999999">
	<div class="pop_title">
		<h3>修改密码</h3>
		<a href="javascript:hiddenPassBox()" class="pop_close"></a>
	</div>
	<div class="pass_pop_body" id="tbChangePass">
		<table>
			<tr>
				<th scope="row">原密码:</th>
				<td><input name="oldpassword" type="password"/></td>
			</tr>
			<tr>
				<th scope="row">新密码:</th>
				<td><input name="newpassword" type="password"/></td>
			</tr>
			<tr>
				<th scope="row">重复密码:</th>
				<td><input name="repassword" type="password"/></td>
			</tr>
		</table>
		<div class="pass_pop_foot">
			<input onclick="saveChange()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hiddenPassBox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
	</div>
</div>
<!--
<div id="popupedit2" class="pop_box" style="display:none;z-index: 9999">
	<div class="pop_title">
		<h3>权限查看</h3>
		<a href="javascript:hideEditPopbox1()" class="pop_close"></a>
	</div>
	<div class="pop_body" id="tbEditParamInfo1">
		<div id="authUpdate1" style="height:500px;overflow-y:auto;">
		</div>
	</div>
</div>
-->
<div id="changeLang" class="lang_pop_box" style="display:none;z-index:9999999">
	<div class="pop_title">
		<h3>选择语言</h3>
		<a href="javascript:hiddenLangBox()" class="pop_close"></a>
	</div>
	<div class="lang_pop_body" id="tbChangeLang">
		<table>
			<tr>
				<th scope="row"></th>
				<td>
					<select name="lang">
						<?php foreach($language as $val): ?>
						<option value="<?php echo $val['visit_str'] ;?>" ><?php echo $val['visit_str'] ;?></option>
						<?php endforeach ;?>
					</select>
				</td>
			</tr>
		</table>
		<div class="pass_pop_foot">
			<input onclick="saveLangChange()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hiddenLangBox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=changePass";
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=welcome&action=setDefaultLang";
		$.ajax({
			type: "post",
			url: url,
			data: 'lang='+lang,
			success: function(data) {
				if ('' == data) {
					alert('修改成功.');
					location.reload();
				}
				else alert('修改失败.');
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




	function editParamCheck1(){
		var checkedCnt = 0;
		//var paramId=$id;
		//var isEdit = $('#isEdit').val();
		//if (isEdit-0) return;
		//else $('#isEdit').val(1);
		//paramInfo.R_ID = paramId;
		$('#popupedit1').css('display', 'block');
		/*
		$.ajax({
			type: "post",
			url: url,
			data: 'R_ID='+paramId,
			success: function(data) {
				var roleObj = eval('(' + data + ')');
				$('#authUpdate1').html(roleObj.auths);
			}
		}); // ajax
		*/
	}// func
	function hideEditPopbox1(){
		$('#popupedit1').css('display', 'none');
		$('#tbEditParamInfo1').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
		getCommonParam();
	}// func
</script>



<?php /* Smarty version Smarty-3.1.8, created on 2014-01-21 13:49:47
         compiled from "G:\WWW\cdyh\application/views\resource\edit_text.html" */ ?>
<?php /*%%SmartyHeaderCode:3046052dde293e5b934-16605919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f06ac4c373524e4e93c18717bcdc814c36744f1' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\edit_text.html',
      1 => 1390283319,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3046052dde293e5b934-16605919',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dde293ec6c07_51230081',
  'variables' => 
  array (
    'title' => 0,
    'content' => 0,
    'baseUrl' => 0,
    'resid' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dde293ec6c07_51230081')) {function content_52dde293ec6c07_51230081($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
	<style>
		.btn_orange,
.btn_gray{height:24px; padding:0px 8px ; margin-right:5px; border-radius:4px; box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1); font-size:12px; cursor:pointer;}
		.btn_orange{ border:1px solid #c28b51; background:#ffeec7; color:#7c3a00;
background-image: linear-gradient(bottom, rgb(255,228,171) 32%, rgb(255,250,237) 85%);
background-image: -o-linear-gradient(bottom, rgb(255,228,171) 32%, rgb(255,250,237) 85%);
background-image: -moz-linear-gradient(bottom, rgb(255,228,171) 32%, rgb(255,250,237) 85%);
background-image: -webkit-linear-gradient(bottom, rgb(255,228,171) 32%, rgb(255,250,237) 85%);
background-image: -ms-linear-gradient(bottom, rgb(255,228,171) 32%, rgb(255,250,237) 85%);

background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0.32, rgb(255,228,171)),
	color-stop(0.85, rgb(255,250,237))
);}
.btn_orange:hover{background-image: linear-gradient(bottom, rgb(248,185,109) 32%, rgb(254,234,207) 85%);
background-image: -o-linear-gradient(bottom, rgb(248,185,109) 32%, rgb(254,234,207) 85%);
background-image: -moz-linear-gradient(bottom, rgb(248,185,109) 32%, rgb(254,234,207) 85%);
background-image: -webkit-linear-gradient(bottom, rgb(248,185,109) 32%, rgb(254,234,207) 85%);
background-image: -ms-linear-gradient(bottom, rgb(248,185,109) 32%, rgb(254,234,207) 85%);

background-image: -webkit-gradient(
	linear,
	left bottom,
	left top,
	color-stop(0.32, rgb(248,185,109)),
	color-stop(0.85, rgb(254,234,207))
);}
		
	</style>
</head>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="assets/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="assets/ueditor/ueditor.all.js"></script>
<body>
<div id="content" style="width:100%;text-align:center">
		标题：<input id="title" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
">
		<br/>
		<div id="edit_text" style="width:820px;margin:0 auto;height:400px">
		</div>
		<br/>
		<button onclick="saveText()" class="btn_orange">保存</button>
</div>
<script>
	window.UEDITOR_HOME_URL = "assets/ueditor/";

	 //实例化编辑器
    var options = {
        lang:/^zh/.test(navigator.language || navigator.browserLanguage || navigator.userLanguage) ? 'zh-cn' : 'en',
        langPath:UEDITOR_HOME_URL + "lang/",

        webAppKey:"9HrmGf2ul4mlyK8ktO2Ziayd",
        initialFrameWidth:800,
        initialFrameHeight:400,
        focus:true,
		toolbars: [["undo","redo","bold","italic","underline","strikethrough","forecolor","backcolor","superscript","subscript","touppercase","tolowercase",,"removeformat","fontfamily","fontsize"]]
    };



	var ue = UE.getEditor('edit_text', options);
    var domUtils = UE.dom.domUtils;

    ue.addListener("ready", function () {
        ue.focus(true);
		ue.setContent('<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
');
    });
	
	// 保存文本
	function saveText(){
		var content = encodeURIComponent(ue.getContent());
		var title = document.getElementById('title').value;
		if (content == '' || title == ''){
			alert('请检查标题或内容是否为空.');
			return;
		}
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=updateText";
		$.ajax({
			type: "post",
			url: url,
			data: 'content='+content+'&title='+title+'&resid='+<?php echo $_smarty_tpl->tpl_vars['resid']->value;?>
,
			success: function(data) {
				if (data > 0){
					alert('修改成功.');
				}else{
					alert('修改失败.');
				}
			}
		}); // ajax
	}
</script>
</body>
</html><?php }} ?>
<!DOCTYPE html PUBLIC  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="JavascriptClass/defaultInfo.js" type="text/javascript"></script>

<script src="JavascriptClass/artDialog/jquery.artDialog.js" type="text/javascript"></script>
<script src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<link href="JavascriptClass/artDialog/skins/default.css" rel="stylesheet" type="text/css" />
<link id="easyuiTheme" rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/bootstrap/easyui.css"/>
<link rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/icon.css"/>
<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
<script id="easy-lang" type="text/javascript" src="JavascriptClass/jquery-easyui/locale/easyui-lang-zh_CN.js"></script>
<script src="application/views/javaScript/templateManage.js" type="text/javascript"></script>
<script type="text/javascript" src="JavascriptClass/defaultInfo.js"></script>
<title>播放列表</title>
<style type="text/css">
<!--
body {
margin:0px;
padding:0px;
border:0px;
}
a {
	text-decoration: none; /*让链接的下划线消失*/
}
.temp_sample a:hover {
	display:block;
	padding:0px 19px 0px 0px;
	border:#0FF solid 0px;
	background-image:url(Skin/web/skin/temp_show_small.png);
	background-position:-172px top;
}
.temp_sample a:hover .div {
	display:block;
	padding:5px 0px 13px 19px!important;
	padding:5px 0px 5px 19px;
	border:0px;
}
.temp_sample a .div {
	display:block;
	/*padding:5px 0px 13px 19px!important;*/
	padding:5px 0px 5px 19px;

	background-position: -193px 0;
}
.temp_sample a {
	height:160px;
	text-decoration:none;
	color:#000;
	display:block;
	background-image:url(Skin/web/skin/temp_show_small.png);
	padding:0px 19px 0px 0px;
	border:#0FF solid 0px;
	background-repeat:no-repeat;
}

label { cursor:pointer;}

.show_con_div { display:block;}

input,select {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
input ,label { font-family:Tahoma,Verdana, Geneva, sans-serif; vertical-align:middle; font-size:12px; }
-->

.toolBar{ display:block; width:100%; height:27px; padding:1px 0px 0px 2px; }
</style>
</head>
<div class="right_box" id="right_box">
	<a id="create_temp" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true">新建模版</a>
	<a id="edit_temp" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-edit',plain:true">编辑模版</a> 
	<a id="del_temp" href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true">删除模版</a>

<div id="template_list_panel" style="width:1158px;"></div>
<div id="template_list_pageBar" class="easyui-pagination"></div>
</div>

</div>
</html>

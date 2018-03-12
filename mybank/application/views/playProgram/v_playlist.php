
<!DOCTYPE html>
<html >
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script  src="JavascriptClass/artDialog/artDialog.js?skin=blue" type="text/javascript"></script>
<script src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>

<link id="easyuiTheme" rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/bootstrap/easyui.css"/>
<link rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/icon.css"/>
<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
<script id="easy-lang" type="text/javascript" src="JavascriptClass/jquery-easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="application/views/javaScript/ps_playlist.js"></script>

</head>


<body style="padding: 0px; margin: 0px;top:0px;">
	
<table id="programGrid" toolbar="#toolbar">
</table> 

<div id="toolbar" >
	
	    <a id="add" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="program.createplaylist()">新建计划</a>
	    <a id="cut" class="easyui-linkbutton" plain="true" iconCls="icon-cut" onclick="program.deleteMulpPlaylist()">删除</a>
	    <!-- <a id="save" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick="#">功能键</a> -->
	
		<!-- <span>播放计划名称</span>
	    <input id="itemid" >
	    <span>开始时间</span>
	    <input id="productid">
	    <a id="search"  class="easyui-linkbutton" plain="true" iconCls="icon-search" >搜索</a> -->
	
</div>

</body>

</html>

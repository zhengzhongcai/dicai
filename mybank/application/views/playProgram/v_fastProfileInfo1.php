<!DOCTYPE html>
<html >
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script  src="JavascriptClass/artDialog/artDialog.js?skin=blue" type="text/javascript"></script>
<script src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>



<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
<script id="easy-lang" type="text/javascript" src="JavascriptClass/jquery-easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="application/views/javaScript/fastProgramManage.js"></script>

</head>


<body style="padding: 0px; margin: 0px;">
	
<table id="programGrid" toolbar="#toolbar">
</table> 

<div id="toolbar" >
	
	    <a id="add" class="easyui-linkbutton" plain="true" iconCls="icon-add" onclick="program.createprofile()">快速新建节目</a>
	    <a id="cut" class="easyui-linkbutton" plain="true" iconCls="icon-cut" onclick="program.deleteMulProfile()">删除</a>
	    <!-- <a id="save" href="#" class="easyui-linkbutton" plain="true" iconCls="icon-save" onclick="#">功能键</a> -->
	
		<!-- <span>节目名称</span>
	    <input id="itemid" >
	    <span>时长（秒）</span>
	    <input id="productid">
	    <a id="search"  class="easyui-linkbutton" plain="true" iconCls="icon-search" >搜索</a> -->
</div>

</body>
<script type="text/javascript">

$(function(){
program.createprofile();


});

</script>


</html>

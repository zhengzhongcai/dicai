<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="JavascriptClass/jquery-1.7.2.js" ></script>

<script language="javascript" src="JavascriptClass/defaultInfo.js" ></script>
<script language="javascript" src="JavascriptClass/bx.core.js" ></script>
<script language="javascript" src="JavascriptClass/drapDrag.js" ></script>
<script src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script language="javascript" src="JavascriptClass/bx.comment.js" ></script>
<script language="javascript" src="JavascriptClass/template_left.js" ></script>

<!-- 添加-->

<script type="text/javascript" language="JavaScript" src="JavascriptClass/defaultInfo.js"></script>
<script type="text/javascript" language="JavaScript" src="JavascriptClass/bx.core.js"></script>
<script type="text/javascript" language="JavaScript" src="JavascriptClass/bx.ajax.js"></script>
<script src="template/JavaScriptProduct/JavaScript/DropDrag.js" type="text/javascript"></script>
<link id="easyuiTheme" rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/default/easyui.css"/>
<link id="easyuiTheme" rel="stylesheet" type="text/css" href="JavascriptClass/jquery-easyui/themes/icon.css"/>
<script src="./template/JavaScriptProduct/JavaScriptCreateMode/templateProportion.js" type="text/javascript"></script>
<script type="text/javascript" src="JavascriptClass/jquery-easyui/jquery.easyui.min.js"></script>
<script language="JavaScript" src="template/JavaScriptProduct/JavaScriptCreateMode/createProfile_left.js" ></script>
<script src="JavascriptClass/jqueryui/jquery-ui.min.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<script src="JavascriptClass/jqueryui/timepicker/jquery-ui-sliderAccess.js" type="text/javascript"></script>

<!--结束-->
<script language="JavaScript1.5" src="application/views/javaScript/createPlayList.js" type="text/javascript"></script>

<link type="text/css" rel="stylesheet" href="skin/web/index.css" />
<link href="JavascriptClass/artDialog/skins/default.css" rel="stylesheet" type="text/css" />
<title>快速创建节目</title>
<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	-moz-user-select: -moz-none;
	font-size: 12px;
}
/*******************模版选择列表样式********************/
.temp_sample a:hover {
	display: block;
	padding: 0px 19px 0px 0px;
	border: #0FF solid 0px;
	background-image: url(/bank/Skin/web/skin/temp_show_small.png);
	background-position: -172px top;
}
.temp_sample a:hover .div {
	display: block;
	padding: 5px 0px 13px 19px!important;
	padding: 5px 0px 5px 19px;
	border: 0px;
}
.temp_sample a .div {
	display: block;
	/*padding:5px 0px 13px 19px!important;*/
	padding: 5px 0px 5px 19px;
	background-position: -193px 0;
}
.temp_sample a {
	height: 160px;
	text-decoration: none;
	color: #000;
	display: block;
	background-image: url(/bank/Skin/web/skin/temp_show_small.png);
	padding: 0px 19px 0px 0px;
	border: #0FF solid 0px;
	background-repeat: no-repeat;
}
/*********************文件列表拖放掩饰**************************/
.DragContainer {
/*BORDER: #669999 1px solid;
	PADDING: 5px 0px 0px 0px;
	FLOAT: left;
	MARGIN: 0px;
	WIDTH: 160px;*/
}
.OverDragContainer {
	BORDER: #669999 0px solid;
	PADDING: 5px 0px 0px 0px;
	FLOAT: left;
	MARGIN: 0px;
	WIDTH: 200px;
}
.OverDragContainer {
	BACKGROUND-COLOR: #eee;
}
.DragBox {
	display: block;
	border: solid 1px #ccc;
	padding: 2px;
	margin-top:2px;
	FONT-SIZE: 12px;
	MARGIN-BOTTOM: 2px;
	WIDTH: 160px;
	height: 15px;
	line-height: 15px;
	overflow: hidden;
	CURSOR: pointer;
}
.OverDragBox {
	display: block;
	padding: 2px;
	FONT-SIZE: 12px;
	MARGIN-BOTTOM: 2px;
	WIDTH: 160px;
	height: 15px;
	line-height: 15px;
	overflow: hidden;
	CURSOR: pointer;
	/*BACKGROUND-COLOR: #eee;*/
	background-image: url(../../ceShi_Image/f3.gif);
	background-position: -10px -12px;
	background-repeat: no-repeat;
	border: solid 1px #7da2ce;
	-moz-border-radius: 3px;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	box-shadow: inset 0 0 1px #fff;
	-moz-box-shadow: inset 0 0 1px #fff;
	-webkit-box-shadow: inset 0 0 1px #fff;
	background-color: #cfe3fd;
	background: -moz-linear-gradient(top, #dcebfd, #c2dcfd);
	background: -webkit-gradient(linear, center top, center bottom, from(#dcebfd), to(#c2dcfd));
}
.DragDragBox {
	CURSOR: pointer;
	_FILTER: alpha(opacity=50);/*只有IE6才能识别，因此可以用于单独对IE6的设置中*/
	opacity: 0.7!important;/*用于Opera、Firefox2、Firefox3等现代浏览器*/
	/*>FILTER: alpha(opacity=50)!important; /*IE7、IE8可以识别该规则，因此它覆盖掉了上一条规则*/
	BACKGROUND-COLOR: #ff99cc;
    display: block;
	padding: 2px;
	FONT-SIZE: 12px;
	MARGIN-BOTTOM: 2px;
	WIDTH: 160px;
	height: 15px;
	line-height: 15px;
	overflow: hidden;
	CURSOR: pointer;
	/*BACKGROUND-COLOR: #eee;*/
	background-image: url(../../ceShi_Image/f3.gif);
	background-position: -10px -12px;
	background-repeat: no-repeat;
	border: solid 1px #7da2ce;
	-moz-border-radius: 3px;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	box-shadow: inset 0 0 1px #fff;
	-moz-box-shadow: inset 0 0 1px #fff;
	-webkit-box-shadow: inset 0 0 1px #fff;
	background-color: #cfe3fd;
	background: -moz-linear-gradient(top, #dcebfd, #c2dcfd);
	background: -webkit-gradient(linear, center top, center bottom, from(#dcebfd), to(#c2dcfd));
}
.dragHander {
	display:block;
	overflow:visible;
	background-color: #999;
	background: -moz-linear-gradient(top, #dcebfd, #c2dcfd);
	background: -webkit-gradient(linear, center top, center bottom, from(#dcebfd), to(#c2dcfd));
	padding:5px;
	border:1px solid #CCCCCC;
	z-index:9999;
	}
.dragHanderHidden {display:none; }
.ziYuanLiebiao {
	display:block;
	height:14px;
	line-height: 14px;
	font-size: 12px;
	font-weight: bold;
	color: #999;
	border-bottom: 1px solid #003;}

/********************************文件列表样式开始**********************************/
.vZheDie {
	display: block;
	width: 235px;
	font-size: 12px;
	position: relative;
}
.left {
	display: block;
	width: 65px;
	float: left;
	height: 100%;
	position: absolute;
	top: 0px;
	left: 0px;
	bottom: 0px;
}
.leftItm {
	display: block;
	width: 100%;
	height: auto;
	cursor: pointer;
	background-color: #539de2;
	font-size: 12px;
	font-weight: bold;
	margin-bottom: 2px;
	color: #fff;
	padding: 2px;
}
.right {
	display: block;
	width: 100%;
	float: left;
	height: 100%;
	/*background-color: #f4f4f4;*/
	position: absolute;
	top: 0px;
	left: 65px;
	bottom: 0px;
	right: 0px;
}
.rightItm {
	display: block;
	width: 100%;
	cursor: pointer;
	background-color: #eee;
	height: 100%;
	margin-left: 2px;
}
.hidden {
	display: none;
}
.show {
	display: block;
}
.select {
	background-color: #f4f4f4;
	color: #000;/*opacity: 0.5;*/
}
.unselect {
	background-color: #FF6600;
 color:#fff;
}
.mouseenter {
	background-color: #aed3f6;
}
.mouseleave {
	background-color: #539de2;
}
/******************************文件列表样式结束************************************/
.div_main {
	position: relative;
	display: block;
	font-size: 1px;
	width: 100%;
	font-family: "宋体", "微软雅黑", Verdana, Geneva, sans-serif;
	overflow: hidden;
}
.div_main .topBar, .leftBar, .rightBar, .conArea, .bottomBar {
	position: absolute;
	display: block;
	margin: 0px;
	padding: 0px;
}
.div_main .topBar {
	top: 0px;
	left: 50px;
	right: 0px;
	height: 25px;
_width:expression(this.parentNode.clientWidth-50+"px");
	background: -moz-linear-gradient(top, white, #eee, white);
	background: -webkit-linear-gradient(top, white, #eee, white);
}
.div_main .leftBar {
	top: 0px;
	left: 0px;
	bottom: 0px;
	width: 50px;
	height: auto;

}
.div_main .rightBar {
	top: 25px;
	left: auto;
	right: 0px;
	bottom: 0px;
	width: 200px;
	height: auto;
_height:expression(this.parentNode.clientHeight-25+"px");
	background-color: #f0f0f0;
}


.div_main .conArea {
	background-color: #999999;
	top: 25px;
	left: 50px;
	right: 200px;
	bottom: 35px;
	width: auto;
	height: auto;
_height:expression(this.parentNode.clientHeight-60+"px");
_width:expression(this.parentNode.clientWidth-250+"px");
}
.div_main .bottomBar{
	background-color: #CCCCCC;

	left: 50px;
	right: 200px;
	bottom: 0px;
	width: auto;
	height: 35px;
	_width:expression(this.parentNode.clientWidth-250+"px");

	background: -moz-linear-gradient(top, #eee, #ccc, white);
	background: -webkit-linear-gradient(top, #eee, #ccc, white);
}


.div_main .areaTypeCon span {
	width: 48px;
	height: 40px;
	line-height: 30px;
	font-size: 14px;
	margin-bottom: 5px;
	text-align: center;
	background: -moz-linear-gradient(top, #FF6600, #FF6600, #FF6600);
	background: -webkit-linear-gradient(top, #FF6600, #FF6600, #FF6600);
	/*background: -moz-linear-gradient(top, #3167a3, #22588a, #25527c);
	background: -webkit-linear-gradient(top, #3167a3, #22588a, #25527c);
	-webkit-box-shadow:0px 0px 5px #000000;
 -moz-box-shadow:0px 0px 5px #000000;
 box-shadow:0px 0px 5px #000000;*/
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
}
.div_main .tempInfo {
	font-size: 12px;
	position: absolute;
	top: 0px;
	left: 50px;
	height: 25px;
	line-height: 25px;
}
.div_main .bottom_bar_a{
	display:inline-block;
	font-size: 12px;
	position: absolute;
	top: 5px;
	left: 50px;
	height: 25px;
	line-height: 25px;}
.div_main .buttonItem {
		background: url(skin/web/skin/b_bt_nrbg2.jpg);
	background-repeat: no-repeat;
	line-height: 26px;
	width: 50px;
	height: 26px;
	color: #FFF;
	outline: none;
}


.div_main .canvasDiv {
	/*position:absolute;top:0px; left:0px; right:0px; bottom:0px;*/
	width: auto;
	height: auto;
_height:expression(this.parentNode.clientHeight+"px");
_width:expression(this.parentNode.clientWidth+"px");
	display: block;
	margin: auto;
	background-image: url(skin/web/skin/transBg.png);
	background-repeat: repeat;
	box-shadow: 0px 0px 5px #000;
	-webkit-box-shadow: 0px 5px 5px #000;
	-moz-box-shadow: 0px 5px 5px #000;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
.div_main .tempArea {
	position: absolute;
	width: 50px;
	height: 50px;
	font-size: 20px;
	line-height: 50px;
	text-align: center;
	color: #000;
	font-weight: bold;
	/*background: -moz-linear-gradient(top, white, #eee, white);
 background: -webkit-linear-gradient(top, white, #eee, white);*/

/* -webkit-box-shadow:0px 0px 5px #000000;
 -moz-box-shadow:0px 0px 5px #000000;
 box-shadow:0px 0px 5px #000000;*/
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
}
.area_unselect {

	opacity: 0.7;
	filter:alpha(opacity=70);
}
.area_selected {
	filter:alpha(opacity=50);
	opacity: 0.5;
/*	-webkit-box-shadow: 0px 0px 5px #00F;
	-moz-box-shadow: 0px 0px 5px #00F;
	box-shadow: 0px 0px 5px #00F;*/
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;

}

	#jj,.area_leftBar, .area_rightBar, .area_topBar, .area_bottomBar, .area_lefttopBar, .area_leftbottomBar, .area_righttopBar, .area_rightbottomBar {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	position: absolute;
	overflow: hidden;
}
.area_leftBar {
	border-left: 5px solid #000;
	cursor: e-resize;
	width: 8px;
	height: 20px;
	left: 0px;
	top: 50%;
	margin-top: -10px;
}
.area_rightBar {
	border-right: 5px solid #000;
	cursor: e-resize;
	width: 18px;
	height: 20px;
	right: 0px;
	top: 50%;
	margin-top: -10px;
}
.area_topBar {
	border-top: 5px solid #000;
	cursor: n-resize;
	width: 20px;
	height: 8px;
	top: 0px;
	left: 50%;
	margin-left: -10px;
}
.area_bottomBar {
	border-bottom: 5px solid #000;
	cursor: n-resize;
	width: 20px;
	height: 8px;
	bottom: 0px;
	left: 50%;
	margin-left: -10px;
}
.area_lefttopBar {
	cursor: nw-resize;
	border: 5px solid #000;
	border-width: 5px 0 0 5px;
	width: 10px;
	height: 10px;
	top: 0px;
	left: 0px;
}
.area_leftbottomBar {
	cursor: sw-resize;
	border: 5px solid #000;
	border-width: 0 0 5px 5px;
	width: 10px;
	height: 10px;
	bottom: 0px;
	left: 0px;
}
.area_righttopBar {
	cursor: sw-resize;
	border: 5px solid #000;
	border-width: 5px 5px 0 0;
	width: 10px;
	height: 10px;
	top: 0px;
	right: 0px;
}
.area_rightbottomBar {
	cursor: nw-resize;
	border: 5px solid #000;
	border-width: 0 5px 5px 0;
	width: 10px;
	height: 10px;
	bottom: 0px;
	right: 0px;
}
.div_main .hidden {
	display: none;
}
.div_main .areaAttr {
	font-size: 12px;
}
.div_main .areaAttr .attr_item {
	display: block;
	height: 25px;
	line-height: 25px;
	padding-left: 5px;
}
.div_main .areaAttr .attr_item ul {
	display: block;
	list-style: none;
	margin: 0px;
	padding: 0px;
}
.div_main .areaAttr .attr_item ul li {
	display: inline-block;
	float: left;
	list-style: none;
	margin: 0px;
	padding: 0px;
}
.div_main .areaAttr .attr_item ul li input {
	display: block;
	padding: 0px;
	width: 50px;
	height: 20px;
	font-size: 12px;
	line-height: 20px;
	float: left;
}
.div_main .areaAttr .attr_button {
	display: block;
	height: 20px;
	line-height: 20px;
	padding-left: 5px;
}
.wei {
	display: block;
	float: left;
	text-align: center;
	width: 20px;
	height: 20px;
	line-height:20px;
	background: -moz-linear-gradient(top, #eee, #ccc, #eee);
	background: -webkit-linear-gradient(top, #eee, #ccc, #eee);
	color: #fff;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	background-color:#ccc;
	border:1px solid #999;
	margin-left:2px;
	cursor:pointer;
}
.div_main .clientType {
	display: block;
	width: 200px;
	font-size: 12px;
	background: #CCC;
	background: -moz-linear-gradient(top, white, #eee, white);
	background: -webkit-linear-gradient(top, white, #eee, white);
	-webkit-box-shadow: 0px 0px 5px #000000;
	-moz-box-shadow: 0px 0px 5px #000000;
	box-shadow: 0px 0px 5px #000000;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	padding: 5px;
}
.div_main .clientType .clientType_item {
	display: block;
	height: 20px;
	line-height: 20px;
	padding-left: 5px;
	margin-bottom: 2px;
}
.div_main .clientType .clientType_item ul {
	display: block;
	list-style: none;
	margin: 0px;
	padding: 0px;
}
.div_main .clientType .clientType_item ul li {
	display: inline-block;
	float: left;
	list-style: none;
	margin: 0px;
	padding: 0px;
}
.div_main .clientResolution {
	width: 60px;
	display: inline-block;
	float: left;
}
.div_main .float {
	display: inline-block;
	float: left;
}
.div_main .tempName {
	font-size: 12px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	border: 1px solid #999;
	width: 80px;
	height:18px;
	line-height: 18px;
}
.temp_backGroundImage {
	position: absolute;
	top: 0px;
	left: 0px;
	right: 0px;
	bottom: 0px;
	display: block;
	width: 100%;
	height: 100px;
_height:expression(this.parentNode.clientHeight+"px");
}
.fileAttrbuteBtn {
	width: 60px;
}
input, button, select {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.bg_img_list {
	display: block;
	width: 80px;
	height: 80px;
	margin: 5px;
	float: left;
	text-decoration: none;
	border: 0px;
	cursor: pointer;
}
.bg_img_list ul {
	display: block;
	list-style: none;
	padding: 0px;
	margin: 0px;
}
.bg_img_list ul li {
	display: block;
	list-style: none;
	padding: 0px;
	margin: 0px;
	width: 80px;
}
.bg_img_list .f_img {
	height: 60px;
	border: 0px;
}
.bg_img_list .f_name {
	display: block;
	width: 80px;
	height: 20px;
	text-align: center;
	text-decoration: none;
	font-size: 14px;
	font-weight: bold;
	color: #000000;
	overflow: hidden;
}
.bg_img_list ul li img {
	width: 70px;
	height: 50px;
	margin: 5px;
	border: 0px;
}
.bg_img_list:hover {
	background-color: #488dce;
}
.bg_img_list:active {
	background-color: #488dce;
}
.bg_img_select {
	background-color: #488dce;
}
/*------------------------------button 蓝色小按钮---------------------------*/
.rightBar .areaAttr button {
	background: url(skin/web/skin/b_bt_nrbg2.jpg);
	background-repeat: no-repeat;
	line-height: 26px;
	width: 50px;
	height: 26px;
	color: #FFF;
	outline: none;
}
.rightBar input {
	border: 1px solid #ccc;
	padding: 2px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.button_item {
	outline: none;
}
#_clType, #_clDir {
	font-size: 12px;
	width: 77px;
	height: 18px;
	color: #FFF;
	line-height: 18px;
	vertical-align: middle;
	text-align: center;
	padding-right: 18px;
	background: url("skin/web/skin/button.png");
	background-repeat: no-repeat;
}

/*
#_clReso {
	width: 100px;
	height: 25px;
	color: #FFF;
	line-height: 18px;
	vertical-align: middle;
	text-align: center;
	padding-right: 8px;
	background: url("skin/web/skin/button.png");
	background-position: -112px 0;
	background-repeat: no-repeat;
}*/
#_tmpBgImg, #_cleartmpBgImg {
	width: 35px;
	height: 22px;
	color: #FFF;
	line-height: 22px;
	vertical-align: middle;
	text-align: center;
	background: url("skin/web/skin/button.png");
	background-position: -270px 0;
	background-repeat: no-repeat;
}
.mouseOnItem {
	background: -moz-linear-gradient(top, #3167a3, #22588a, #25527c);
	background: -webkit-linear-gradient(top, #3167a3, #22588a, #25527c);
	color: #fff;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
}
</style>
<script language="javascript" type="text/javascript">
		function reloade(){
				var  parentobj=window.parent.document.getElementById("createTemplate");
				if(parentobj)
				{
					if(parentobj.contentWindow){
						parentobj.contentWindow.location.reload();
					}else{
						parentobj.contentDocument.location.reload();
					}
				}
			}
		window.onunload=reloade;


</script>
</head>

<body>
<div id="main" class="div_main">
  <div class="topBar">
    <div></div>
    <div class="tempInfo">
      <!--span>模板类型:</span><span class="button_item">
      <button class="button" id="_clType">X86</button>
      </span--> <span>模板方向:</span><span class="button_item">
      <button class="button" id="_clDir" >横向</button>
      </span> <span>模板分辨率:</span><span><span>
       <!--select  id="_clReso" ><button class="button" id="_clReso">1024x768</butto>
            <option value="1024x768">1024x768</option>
            <option value="1290x1200">1290x1200</option>
      </select>
            <input name="box" style="width:100px;">

      </span-->
      <span style="margin-left:100px;width:18px;overflow:hidden;">
          <select style="width:120px;margin-left:-100px" id="aa" onchange="this.parentNode.nextSibling.value=this.value;javascript:abcdefg();">
            <option value=""></option>
            <option value="1920x1200">1920x1200</option>
            <option value="1920x1080">1920x1080</option>
             <option value="1680x1050">1680x1050</option>
             <option value="1600x1200">1600x1200</option>
             <option value="1600x900">1600x900</option>
             <option value="1440x900">1400x900</option>
             <option value="1366x768">1366x768</option>
             <option value="1360x768">1360x768</option>
             <option value="1280x1024">1280x1024</option>
             <option value="1280x720">1280x720</option>
             <option value="1600x900">1600x900</option>

          </select></span><input  id="_clReso"style="width:95px;position:absolute;left:210px;" type='text' value='1920x1080' oninput="abcdefg()" />
 </span>
      <span>模板背景:</span><span class="button_item">
      <button class="button" id="_tmpBgImg">选择</button>
      </span> <span class="button_item" >
      <button class="button" id="_cleartmpBgImg">清除</button>
      </span>  </div>
  </div>
  <div class="leftBar">
    <div class="areaTypeTitle">区域类型</div>
    <div id="areaTypeCon" class="areaTypeCon"></div>
  </div>
  <div class="rightBar" id="rightBar">
    <div class="areaAttr" id="areaAttr">
    <div class="easyui-accordion" style="width:600px;height:500px;">

    <div title="区域属性"  style="padding:10px;">
      <div class="attr_item">
        <ul>
          <li><span style="text-align:center; width:200px; display:block; font-weight:600">区域属性</span></li>
        </ul>
      </div>
      <div class="attr_item">
        <ul>
          <li>区域类型:</li>
          <li id="_areaType">图片</li>
        </ul>
      </div>
      <div class="attr_item">
        <ul>
          <li>区域宽度:</li>
          <li>
            <input type="text" id="_areaW" value="" />
            <b  wtype="_areaW" type="-" class="wei" >-</b><b wtype="_areaW" type="+" class="wei">+</b>
          </li>
        </ul>
      </div>
      <div class="attr_item">
        <ul>
          <li>区域高度:</li>
          <li>
            <input type="text" id="_areaH" value="" />
            <b  wtype="_areaH" type="-" class="wei" >-</b><b wtype="_areaH" type="+" class="wei">+</b>
          </li>
        </ul>
      </div>
      <div class="attr_item">
        <ul>
          <li>区域 X轴:</li>
          <li>
            <input type="text" id="_areaX" value="" />
            <b wtype="_areaX" type="-" class="wei" >-</b><b wtype="_areaX" type="+" class="wei">+</b></li>
        </ul>
      </div>
      <div class="attr_item">
        <ul>
          <li>区域 Y轴:</li>
          <li>
            <input type="text" id="_areaY" value="" />
            <b wtype="_areaY" type="-" class="wei" >-</b><b wtype="_areaY" type="+" class="wei">+</b>
          </li>
        </ul>
      </div>
      <div class="attr_button"> <span class="button_item">
        <button class="button" id="area_weiTiao">确 定</button>
        </span> <span class="button_item">
        <button class="button" id="area_del">删 除</button>
        </span> </div>
     </div>


<div title="区域文件列表"   style="padding:10px;"> <td valign="top" width="150"><!--区域文件显示栏 开始-->

    <div class="ziYuanLiebiao">区域文件列表</div>
      <div id="fileArea" style="width:150px; overflow-x:hidden; height:242px;"></div>

      <!--区域文件显示栏 结束-->

      <!--功能按钮 开始-->

      <div style="overflow:hidden; display:block"> <a href="javascript:void(0)" class="zduan_left" onclick="fileMoveUp(this)"
			id="fl_moveUp"><span class="zduan_right">上移</span></a><a href="javascript:void(0)" class="zduan_left" onclick="fileMoveDown(this)" id="fl_moveDown"><span class="zduan_right">下移</span></a><a href="javascript:void(0)" class="zduan_left" onclick="fileDelte(this)" id="fl_del"><span class="zduan_right">删除</span></a>
        <!--   <a href="javascript:void(0)" class="blue_left" onclick="setRelevanceFile(this)" id="fl_relevance"><span class="blue_right">关联文件</span></a>-->

      </div>

      <!--功能按钮 结束--> <!--文件属性设置 开始-->

      <div id="file_info" style="display:block"></div>
      </td>
      <!--区域文件显示栏 结束-->
     </div>




       <div title="资源列表"style="padding:10px;" data-options="selected:true">
    	<div id="fileArea1" style="width:200px; overflow-x:hidden; height:380px;">
    	<td valign="top" style="width:235px;  "><div class="ziYuanLiebiao">资源列表</div>
            <div class="vZheDie" id="fileList_menu">
        <div class="left"> </div>
        <div class="right" id="content"> </div>
      </div>
     </div>
      </td>
      <td align="left"><a href="javascript:void(0)" class="zduan_left" id="file_first_page" ><span class="zduan_right">首页</span></a><a href="javascript:void(0)" class="zduan_left" id="file_pre_page" ><span class="zduan_right">上一页</span></a><a href="javascript:void(0)" class="zduan_left" id="file_next_page" ><span class="zduan_right">下一页</span></a><a href="javascript:void(0)" class="zduan_left" id="file_final_page" ><span class="zduan_right">尾页</span></a></td>

       </div>

   </div>
    </div>
  </div>

  <!--这是画布的呈现-->

  <div class="conArea" id="conArea">
  	<!--td valign="middle" align="center" style="padding:2px; background-color:#F0F0F0;" -->
  	<div id="canvasDiv" class="canvasDiv">
  	</div>
       <div id="101" areatype="Audio" class="DragContainer" style="height:30px; text-align:left; background-color:#09C; display:none; float:left; line-height:30px;" maintype='N' onclick="areaMenue(event)"  position="'left':'1','top':'1','height':'1','width':'1'">背景音乐</div>
       <div id="100" areatype="Txt" class="DragContainer" style="height:50px;width:50%; text-align:center; background-color:#06F;display:none; float:left; line-height:50px;"
maintype='N' onclick="areaMenue(event)" ledtype='LED' position="'left':'0','top':'0','height':'0','width':'0'">LED专属区域</div>
<!--/td--></div>


  <!--底部工具条-->
  <div class="bottomBar" id="bottomBar">
  	<div class="bottom_bar_a">
	  <span>模板名称:<input name="templatename" type="text" class="input tempName" id="_temName" onchange="templateObj.setTempName(this)" /></span>
      <!--<span class="button_item"><button class="buttonItem" id="tem_save">保存</button></span>-->
      <a href="javascript:void(0)" class="blue_left" id="tem_save" > <span class="blue_right">保&nbsp;存&nbsp;模&nbsp;板</span> </a>

     <tr>
        	<td>节目类型: <select id="program_type"><option value="X86" selected="selected">X86(windows,Linux)</option><option value="Android">Android</option></select></td>
          <td style="font-size:12px">节目名称:
            <input type="text" id="profile_name" style="width:80px;"
			value="" size="20" maxlength="10" /></td>
          <td ><a href="javascript:void(0)" class="blue_left" id="save_button" > <span class="blue_right">保&nbsp;存&nbsp;节&nbsp;目</span> </a>
           <td ><a href="javascript:void(0)" class="blue_left" id="save_as_button" > <span class="blue_right">节目另存为</span> </a>

          <span> <a href="javascript:void(0)" class="blue_left" id="getTempListBtn" ><span class="blue_right">模&nbsp;板&nbsp;样&nbsp;式</span></a></span>
          <!--<td ><a href="javascript:void(0)" class="blue_left" option="Add" areaid="100" id="led_1"onclick="setLedDiv(this)"><span class="blue_right">LED设置</span></a></td>-->
         <!-- <a href="javascript:void(0)" class="blue_left" onclick="program.setBgMusic(this);" option="Add"  id="bgMusic"><span class="blue_right">背景音乐</span></a>
          <a href="javascript:void(0)" class="blue_left" id="editTempBtn" ><span class="blue_right">编辑模版</span></a></td>
        --></tr>
      </div>
  </div>
</div>
<div id="loadMessage"></div>
<input type="hidden" id="UserFolder" value="" />
<div style="display:none" id="operatingType"></div>
<input type="hidden" id="profileIdText" value="" />
</body>
<script type="text/javascript">

function start()
{



setTimeout(function()
	{
		$.ajax({url:"./template/ajaxPHP/getUname.php",type:"POST",success: function(data){_("UserFolder").value=data;

			_("profile_name").setAttribute("cacheName",data+"Cache");}});
	},2000);
}

function resizeHeight()
{

	_("fileList_menu").style.height=(clientHeight(getParentNode(_("fileList_menu")))-16)+"px";
}
start();
$(function(){

	resizeHeight();

    //阻止浏览器默认行。
    $(document).on({
        dragleave:function(e){    //拖离
            e.preventDefault();
        },
        drop:function(e){  //拖后放
            e.preventDefault();
        },
        dragenter:function(e){    //拖进
            e.preventDefault();
        },
        dragover:function(e){    //拖来拖去
            e.preventDefault();
        }
    });


});

document.body.oncontextmenu=function(){return false;}
</script>
</html>
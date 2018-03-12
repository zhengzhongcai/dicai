<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" src="JavascriptClass/jquery-1.7.2.js" ></script>
<script language="javascript" src="JavascriptClass/artDialog/jquery.artDialog.js" ></script>
<script language="javascript" src="JavascriptClass/defaultInfo.js" ></script>
<script language="javascript" src="JavascriptClass/bx.core.js" ></script>
<script language="javascript" src="JavascriptClass/drapDrag.js" ></script>
<script src="JavascriptClass/artDialog/plugins/iframeTools.js" type="text/javascript"></script>
<script language="javascript" src="JavascriptClass/bx.comment.js" ></script>
<script language="javascript" src="JavascriptClass/template.js" ></script>
<link type="text/css" rel="stylesheet" href="skin/web/index.css" />
<link href="JavascriptClass/artDialog/skins/default.css" rel="stylesheet" type="text/css" />
<title>模板创建</title>
<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
	-moz-user-select: -moz-none;
	font-size: 12px;
}
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
_height:expression(this.parentNode.clientHeight+"px");
	background: -moz-linear-gradient(top, white, #eee, white);
	background: -webkit-linear-gradient(top, white, #eee, white);
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
.div_main .areaTypeTitle {
	font-size: 12px;
	display: block;
	height: 25px;
	line-height: 25px;
}
.div_main .areaTypeCon {
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
	/*-webkit-box-shadow:0px 0px 5px #000000;
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
.area_leftBar, .area_rightBar, .area_topBar, .area_bottomBar, .area_lefttopBar, .area_leftbottomBar, .area_righttopBar, .area_rightbottomBar {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	position: absolute;
	overflow: hidden;
}
.area_leftBar {
	border-left: 1px solid #000;
	cursor: e-resize;
	width: 8px;
	height: 20px;
	left: 0px;
	top: 50%;
	margin-top: -10px;
}
.area_rightBar {
	border-right: 1px solid #000;
	cursor: e-resize;
	width: 8px;
	height: 20px;
	right: 0px;
	top: 50%;
	margin-top: -10px;
}
.area_topBar {
	border-top: 1px solid #000;
	cursor: n-resize;
	width: 20px;
	height: 8px;
	top: 0px;
	left: 50%;
	margin-left: -10px;
}
.area_bottomBar {
	border-bottom: 1px solid #000;
	cursor: n-resize;
	width: 20px;
	height: 8px;
	bottom: 0px;
	left: 50%;
	margin-left: -10px;
}
.area_lefttopBar {
	cursor: nw-resize;
	border: 1px solid #000;
	border-width: 1px 0 0 1px;
	width: 10px;
	height: 10px;
	top: 0px;
	left: 0px;
}
.area_leftbottomBar {
	cursor: sw-resize;
	border: 1px solid #000;
	border-width: 0 0 1px 1px;
	width: 10px;
	height: 10px;
	bottom: 0px;
	left: 0px;
}
.area_righttopBar {
	cursor: sw-resize;
	border: 1px solid #000;
	border-width: 1px 1px 0 0;
	width: 10px;
	height: 10px;
	top: 0px;
	right: 0px;
}
.area_rightbottomBar {
	cursor: nw-resize;
	border: 1px solid #000;
	border-width: 0 1px 1px 0;
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
/*------------------------------button 蓝色小按钮-----------------------*/
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
#_clReso {
	width: 91px;
	height: 18px;
	color: #FFF;
	line-height: 18px;
	vertical-align: middle;
	text-align: center;
	padding-right: 8px;
	background: url("skin/web/skin/button.png");
	background-position: -112px 0;
	background-repeat: no-repeat;
}
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
      </span> <span>模板分辨率:</span><span class="button_item">
      <button class="button" id="_clReso">1024x768</button>
      </span> <span>模板背景:</span><span class="button_item" >
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
  </div>
  
  <!--这是画布的呈现-->
  <div class="conArea" id="conArea">
    <div id="canvasDiv" class="canvasDiv"></div>
  </div>
  <!--底部工具条-->
  <div class="bottomBar" id="bottomBar">
  	<div class="bottom_bar_a">
	  <span>模板名称:<input name="templatename" type="text" class="input tempName" id="_temName" onchange="templateObj.setTempName(this)" /></span> 
      <span class="button_item"><button class="buttonItem" id="tem_save">保存</button></span> 
      
      </div>
  </div>
</div>
<script  type="text/javascript">
		/*2012/8/7  11:15:38*/
		function nocontextmenu(event){ 
				return false; 
		} 
		document.oncontextmenu = nocontextmenu; 
  </script>
</body>
</html>

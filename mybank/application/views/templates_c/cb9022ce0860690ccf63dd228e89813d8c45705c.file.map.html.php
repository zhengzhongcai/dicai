<?php /* Smarty version Smarty-3.1.8, created on 2016-10-12 16:21:06
         compiled from "D:\WWW\cdbank\application/views\monitor\map.html" */ ?>
<?php /*%%SmartyHeaderCode:2065757fdf272bb2a61-13848787%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb9022ce0860690ccf63dd228e89813d8c45705c' => 
    array (
      0 => 'D:\\WWW\\cdbank\\application/views\\monitor\\map.html',
      1 => 1368323960,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2065757fdf272bb2a61-13848787',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_57fdf272c6d320_15044360',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fdf272c6d320_15044360')) {function content_57fdf272c6d320_15044360($_smarty_tpl) {?><!----right---->
<style>
.sel_container{
	z-index:9999;
	font-size:12px;
	position:absolute;
	left:260px;
	top:135px;
	width:140px;
	height:30px;
	line-height:30px;
	padding:5px;
}

.spot{
	border:1px solid #000;
	z-index:9999;
	font-size:12px;
	position:absolute;
	right:100px;
	top:135px;
	background-color:#FFF;
}

.spot img{
	display:inline-block;
}

dl,dt,dd,ul,li{
    margin:0;
    padding:0;
    list-style:none;
}
dt{
    font-size:14px;
    font-family:"微软雅黑";
    font-weight:bold;
    border-bottom:1px dotted #000;
    padding:5px 0 5px 5px;
    margin:5px 0;
}
dd{
    padding:5px 0 0 5px;
}
</style>
<div class="right_box">
	<div id="allmap" style="width:100%;"></div>
	
	<select class="sel_container" onchange="changeMap(this)">
		<option value="wait">等待人流量</option>
		<option value="pjhc">评价不满意数量</option>
		<option value="waitcs">等待超时数量</option>
		<option value="blcs">受理超时数量</option>
	</select>
	
	<div class="spot">
		<img src="assets/images/icon_coordinate_small_green.png" /><span>正常</span>
		<img src="assets/images/icon_coordinate_small_yellow.png" /><span>三级预警</span>
		<img src="assets/images/icon_coordinate_small_orange.png" /><span>二级预警</span>
		<img src="assets/images/icon_coordinate_small_red.png" /><span>一级预警</span>
	</div>
	
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=B76449be6c23b255e18b31151fbcfe38"></script>
<script type="text/javascript">
// 正常图标
var normal_icon_url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/icon_coordinate_green.png";
// 一级预警图标
var onelevel_icon_url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/icon_coordinate_red.png";
// 二级预警图标
var twolevel_icon_url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/icon_coordinate_orange.png";
// 三级预警图标
var threelevel_icon_url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/assets/images/icon_coordinate_yellow.png";

var normalIcon = new BMap.Icon(normal_icon_url, new BMap.Size(40,40),{anchor:new BMap.Size(13, 40)});
var onelevelIcon = new BMap.Icon(onelevel_icon_url, new BMap.Size(40,40),{anchor:new BMap.Size(8, 20)});
var twolevelIcon = new BMap.Icon(twolevel_icon_url, new BMap.Size(40,40),{anchor:new BMap.Size(8, 20)});
var threelevelIcon = new BMap.Icon(threelevel_icon_url, new BMap.Size(40,40),{anchor:new BMap.Size(8, 20)});

window.onload=function(){
	setJgWaitIcon();
}

// 改变地图上的监控内容
function changeMap(elem){
	var type = $(elem).val();
	switch (type){
		case 'wait':
			setJgWaitIcon();
			break;
		case 'pjhc':
			setJgPjhcIcon();
			break;
		case 'waitcs':
			setJgWaitcsIcon();
			break;
		case 'blcs':
			setJgblcsIcon();
			break;
	}// switch
}// func

// 设置等待排队人流量的标注
function setJgWaitIcon(){
	var map = new BMap.Map("allmap");
	var center = new BMap.Point(104.064474, 30.689881);  // 创建点坐标
	map.centerAndZoom(center, 13);                 // 初始化地图，设置中心点坐标和地图级别
	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	
	var url="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&action=getWaitMaxList";
	$.ajax({
		type: "post",
		url: url,
		data: "",
		success: function(data) {
			var jgObjs = eval('(' + data + ')');
			for (var idx in jgObjs){
				generateJg(map, jgObjs[idx]);
			}// for
		}
	}); // ajax
}// func

// 设置评价不满意数量的标注
function setJgPjhcIcon(){
	var map = new BMap.Map("allmap");
	var center = new BMap.Point(104.064474, 30.689881);  // 创建点坐标
	map.centerAndZoom(center, 13);                 // 初始化地图，设置中心点坐标和地图级别
	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	
	var url="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&action=getPjhcMaxList";
	$.ajax({
		type: "post",
		url: url,
		data: "",
		success: function(data) {
			var jgObjs = eval('(' + data + ')');
			for (var idx in jgObjs){
				generateJg(map, jgObjs[idx]);
			}// for
		}
	}); // ajax
}// func

// 设置排队等待超时数量的标注
function setJgWaitcsIcon(){
	var map = new BMap.Map("allmap");
	var center = new BMap.Point(104.064474, 30.689881);  // 创建点坐标
	map.centerAndZoom(center, 13);                 // 初始化地图，设置中心点坐标和地图级别
	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	
	var url="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&action=getWaitCsMaxList";
	$.ajax({
		type: "post",
		url: url,
		data: "",
		success: function(data) {
			var jgObjs = eval('(' + data + ')');
			for (var idx in jgObjs){
				generateJg(map, jgObjs[idx]);
			}// for
		}
	}); // ajax
}// func

// 设置受理超时数量的标注
function setJgblcsIcon(){
	var map = new BMap.Map("allmap");
	var center = new BMap.Point(104.064474, 30.689881);  // 创建点坐标
	map.centerAndZoom(center, 13);                 // 初始化地图，设置中心点坐标和地图级别
	map.enableScrollWheelZoom();
	map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
	
	var url="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=monitor&action=getBlCsMaxList";
	$.ajax({
		type: "post",
		url: url,
		data: "",
		success: function(data) {
			var jgObjs = eval('(' + data + ')');
			for (var idx in jgObjs){
				generateJg(map, jgObjs[idx]);
			}// for
		}
	}); // ajax
}// func

// 生成网点
function generateJg(mapObj, jgInfo){
	var sContent = '<dl><dt>机构名称</dt><dd>'+jgInfo.sysname+'</dd><dt>数量</dt><dd>'+jgInfo.cnt+'</dd></dl><a href="index.php?control=monitor&orgId='+jgInfo.sysno+'" style="float:right;color:blue">查看</a>';
	var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
	var point = new BMap.Point(jgInfo.sysJd, jgInfo.sysWd);
	var marker;
	// 设置预警图标
	switch (jgInfo.level){
		case 0:
			marker = new BMap.Marker(point,{icon:normalIcon});  // 创建标注
			break;
		case 1:
			marker = new BMap.Marker(point,{icon:onelevelIcon});  // 创建标注
			break;
		case 2:
			marker = new BMap.Marker(point,{icon:twolevelIcon});  // 创建标注
			break;
		case 3:
			marker = new BMap.Marker(point,{icon:threelevelIcon});  // 创建标注
	}// switch
	mapObj.addOverlay(marker);
	
	marker.addEventListener("mouseover", function(){          
		this.openInfoWindow(infoWindow);
	});
	
	marker.addEventListener("click", function(){          
		location.href="index.php?control=monitor&orgId="+jgInfo.sysno;
	});
}// func
</script>
<!--content end--><?php }} ?>
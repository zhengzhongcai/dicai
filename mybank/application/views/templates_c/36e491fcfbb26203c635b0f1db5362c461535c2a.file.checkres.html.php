<?php /* Smarty version Smarty-3.1.8, created on 2013-11-15 17:36:14
         compiled from "G:\WWW\webmark\application/views\resource\checkres.html" */ ?>
<?php /*%%SmartyHeaderCode:56125285e3fda5c434-43276409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36e491fcfbb26203c635b0f1db5362c461535c2a' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\resource\\checkres.html',
      1 => 1384508172,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56125285e3fda5c434-43276409',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5285e3fdb554f0_98428077',
  'variables' => 
  array (
    'filetype' => 0,
    'baseUrl' => 0,
    'filepath' => 0,
    'textStr' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5285e3fdb554f0_98428077')) {function content_5285e3fdb554f0_98428077($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
</head>

<body>
<div id="content" class="span10">
	<!-- content starts -->
		<div style="text-align:center;margin:20px">
			<button onclick="shut()">关闭</button>
		</div>

		<div style="width:100%;">
			<?php if ($_smarty_tpl->tpl_vars['filetype']->value==0){?>
			<div id="video" style="margin:0 auto;width:550px;height:330px;"><div id="a1"></div></div>
			<?php }elseif($_smarty_tpl->tpl_vars['filetype']->value==1){?>
			<div style="width:350px;height:310px;margin:0 auto;">
				<audio width="550" src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['filepath']->value;?>
" controls="controls"></audio>
			</div>
			<?php }elseif($_smarty_tpl->tpl_vars['filetype']->value==2){?>
			<div style="width:550px;margin:0 auto;">
				<img id="displayImg" style="margin:0 auto;" width="550" height="310" src="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['filepath']->value;?>
" />
			</div>
			<?php }else{ ?>
			<p style="width:550px;height:310px;margin:0 auto"><?php echo $_smarty_tpl->tpl_vars['textStr']->value;?>
</p>
			<?php }?>
			<br><br>
		</div>

<script type="text/javascript">
<?php if ($_smarty_tpl->tpl_vars['filetype']->value==2){?>
window.onload=function(){
	AutoResizeImage(550,310,$("#displayImg"));
}
<?php }?>

function AutoResizeImage(maxWidth,maxHeight,objImg){
	var img = new Image();
	img.src = $(objImg).attr('src');
	var hRatio;
	var wRatio;
	var Ratio = 1;
	var w = img.width;
	var h = img.height;
	wRatio = maxWidth / w;
	hRatio = maxHeight / h;
	if (maxWidth ==0 && maxHeight==0){
		Ratio = 1;
	}else if (maxWidth==0){//
		if (hRatio<1) Ratio = hRatio;
	}else if (maxHeight==0){
		if (wRatio<1) Ratio = wRatio;
	}else if (wRatio<1||hRatio<1){
		Ratio = (wRatio<=hRatio?wRatio:hRatio);
	}
	if (Ratio<1){
		w = w*Ratio;
		h = h*Ratio;
	}
	$(objImg).attr('height',h);
	$(objImg).attr('width',w);
}// func

</script>

<?php if ($_smarty_tpl->tpl_vars['filetype']->value=="0"){?>
<script type="text/javascript" src="assets/ckplayer/ckplayer.js" charset="utf-8"></script>
<script type="text/javascript">
var flashvars={
	f:'<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['filepath']->value;?>
',//视频地址
	a:'',//调用时的参数，只有当s>0的时候有效
	s:'0',//调用方式，0=普通方法（f=视频地址），1=网址形式,2=xml形式，3=swf形式(s>0时f=网址，配合a来完成对地址的组装)
	c:'0',//是否读取文本配置,0不是，1是
	x:'',//调用xml风格路径，为空的话将使用ckplayer.js的配置
	i:'',//初始图片地址
	d:'',//暂停时播放的广告，swf/图片,多个用竖线隔开，图片要加链接地址，没有的时候留空就行
	u:'',//暂停时如果是图片的话，加个链接地址
	l:'',//前置广告，swf/图片/视频，多个用竖线隔开，图片和视频要加链接地址
	r:'',//前置广告的链接地址，多个用竖线隔开，没有的留空
	t:'10|10',//视频开始前播放swf/图片时的时间，多个用竖线隔开
	y:'',//这里是使用网址形式调用广告地址时使用，前提是要设置l的值为空
	z:'',//缓冲广告，只能放一个，swf格式
	e:'2',//视频结束后的动作，0是调用js函数，1是循环播放，2是暂停播放，3是调用视频推荐列表的插件，4是清除视频流并调用js功能和1差不多
	v:'80',//默认音量，0-100之间
	p:'0',//视频默认0是暂停，1是播放
	h:'0',//播放http视频流时采用何种拖动方法，=0不使用任意拖动，=1是使用按关键帧，=2是按时间点，=3是自动判断按什么(如果视频格式是.mp4就按关键帧，.flv就按关键时间)，=4也是自动判断(只要包含字符mp4就按mp4来，只要包含字符flv就按flv来)
	q:'',//视频流拖动时参考函数，默认是start
	m:'0',//默认是否采用点击播放按钮后再加载视频，0不是，1是,设置成1时不要有前置广告
	g:'',//视频直接g秒开始播放
	j:'',//视频提前j秒结束
	k:'',//提示点时间，如 30|60鼠标经过进度栏30秒，60秒会提示n指定的相应的文字
	n:'',//提示点文字，跟k配合使用，如 提示点1|提示点2
	w:'',//指定调用自己配置的文本文件,不指定将默认调用和播放器同名的txt文件
	//调用播放器的所有参数列表结束
	//以下为自定义的播放器参数用来在插件里引用的
	my_url:'ckhtm'//本页面地址
	//调用自定义播放器参数结束
	};
var params={bgcolor:'#FFF',allowFullScreen:true,allowScriptAccess:'always'};//这里定义播放器的其它参数如背景色（跟flashvars中的b不同），是否支持全屏，是否支持交互
var attributes={id:'ckplayer_a1',name:'ckplayer_a1'};
//下面一行是调用播放器了，括号里的参数含义：（播放器文件，要显示在的div容器，宽，高，需要flash的版本，当用户没有该版本的提示，加载初始化参数，加载设置参数如背景，加载attributes参数，主要用来设置播放器的id）
swfobject.embedSWF('assets/ckplayer/ckplayer.swf', 'a1', '550', '330', '10.0.0','assets/ckplayer/expressInstall.swf', flashvars, params, attributes); //播放器地址，容器id，宽，高，需要flash插件的版本，flashvars,params,attributes	
//调用ckplayer的flash播放器结束
/*
下面三行是调用html5播放器用到的
var video='视频地址和类型';
var support='支持的平台或浏览器内核名称';	
*/
//var video={'http://movie.ks.js.cn/flv/other/02.mp4':'video/mp4'};
//var support=['iPad','iPhone','ios'];
//html5object.embedHTML5('video','ckplayer_a1',600,400,video,flashvars,support);
/*
只要把上面三行前面的双斜杠去掉就可以使用html5播放器
=================================================================

以下代码并不是播放器里的，只是播放器应用时用到的

=================================================================
*/
</script>
<?php }?>

<script>
	function shut(){  
		window.opener=null;  
		window.open('','_self');  
		window.close();  
	}  
</script>
</body>
</html><?php }} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?= base_url()?>"  />
<title>无标题文档</title>
<script language="JavaScript1.5" src="JavascriptClass/bx.core.js" type="text/javascript"></script>
<script type="text/javascript"  src="JavascriptClass/bx.ajax.js"></script>
</head>

<body style="padding:0px; margin:0px;">
<div style="display:block; position:relative; top:0px; left:0px; ">
<img style="display:block; position:absolute; top:0px; left:0px; z-index:10;" width="252" height="172"  src="<?= base_url()?>Skin/default/loadView.png" >
<div style="display:block; position:absolute; top:0px; left:0px; z-index:12; margin:6px; width:240px; height:160px;" id="flashCon"><span style="display:block; line-height:160px; height:160px; text-align:center; font-size:18px;">预览区</span></div>
</div>


</body>
<script>
var url="<?=$arg["url"]?>";
var burl="<?= base_url()?>";
<?php
$tp=$arg["tp"];
if($tp==1)
{
?>
var path=burl+"flvplayer.swf?video="+burl+"Material/view/"+url+"&startvolume=100&autoplay=true";
var str='<object id="viewFile" type="application/x-shockwave-flash" width="240" height="160" data="'+path+'">';
	str+='<param name="movie" value="'+path+'" />';
	str+='<param name="allowfullscreen" value="true"/>';
	str+='<embed id="viewFile" src="'+path+'" width="240" height="160"> </embed></object> ';

<?
}

if($tp==2)
{
	?>
	//var path=burl+'musicplayer.swf?song=Material/'+url;
	//var str='<object data="'+path+'" type="application/x-shockwave-flash" width="250" height="40"><param name="movie" value="'+path+'"/><embed id="viewFile" src="'+path+'" width="240" height="160"> </embed></object>
	var path=burl+"flvplayer.swf?video="+burl+"Material/view/"+url+"&startvolume=100&autoplay=true";
var str='<object id="viewFile" type="application/x-shockwave-flash" width="240" height="160" data="'+path+'">';
	str+='<param name="movie" value="'+path+'" />';
	str+='<param name="allowfullscreen" value="true"/>';
	str+='<embed id="viewFile" src="'+path+'" width="240" height="160"> </embed></object> ';
	<?
}

if($tp==3)
{
	?>
	var str='<img width="240" height="160" border="0" src="'+burl+'Material/'+url+'">';

	<?
}

if($tp==4)
{
?>
	var path=burl+'Material/'+url;
var str='<object id="viewFile" type="application/x-shockwave-flash" width="240" height="160" data="'+path+'">';
	str+='<param name="movie" value="'+path+'" />';
	str+='<param name="allowfullscreen" value="true"/>';
	str+='<embed id="viewFile" src="'+path+'" width="240" height="160"> </embed></object> ';
<?
}

if($tp==5)
{
	?>
	var str='<span style="display:block; line-height:160px; height:160px; text-align:center; font-size:18px;"><a style="font-size:12px;" href="'+burl+'Material/'+url+'" target="_blank">如果没有弹出窗口请点击这里</a><span>';
	var path=burl+'Material/'+url;
	window.open(path);
	<?
}

if($tp==6)
{
	?>
	var str='<span style="display:block; line-height:160px; height:160px; text-align:center; font-size:18px;"><a style="font-size:12px;" href="'+burl+'index.php/fileManage/txtView/'+url+'" target="_blank">文本预览请点击我</a><span>';
	var path=burl+'index.php?contol=fileManage&action=txtView&url='+url;
	var ajax = new AJAXRequest();
	ajax.get("index.php?control=fileManage&action=txtView&url="+url,function(obj){
		_("flashCon").innerHTML="<div style='word-break: break-all; word-wrap:break-word;width:240px;height:160px;text-indent:16px;overflow-y:auto;'>"+obj.responseText+"</div>";
	});
	window.open(path,"_blank");
	<?
}
?>
try{
	_("flashCon").innerHTML=str;
	}catch(e){}
</script>
</html>

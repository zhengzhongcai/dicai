<?php
//定义全局变量或者常量
//include('config.php');
define("FILELIB","FileLib/");
define("FTPTAR","/tar/");
define("FTPTXT","/text/");
define("FTPLED","/led/");
define("TXT","Text/");//滚动字幕临时存放路径
define("SWF",'swf');
define('EXPORT','FileLib/Profile/');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function pArr($arr=array()){
	echo '<pre>';
	@print_r($arr);
	echo '</pre>';
}
function errStr($str){
	echo $str."<br>";	
}
function fileNameCharset($str_fileName)
{
	return iconv("UTF-8","GBK",$str_fileName);
}
function proEncodeName($name)
{
	return preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$name)));
}

function proDecodeName($name)
{
	if(count(explode("_",$name))>1)
	{
		if(!(@iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$name)))))
		{
			return urldecode(preg_replace("/\_/","%",$name));
		}
		else
		{return @iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$name)));}
	}
	else{ return $name;}
}

function proDeName($name)
{
	
	if(count(explode("_",$name))>1)
	{
		return iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$name)));
	}
	else{ return $name;}
}


function Information($title,$info)
{
	if(is_array($info))
	{
		return "<p style='border:1px solid red'><b>$title</b><br><span><pre>".print_r($info,true)."</pre></span></p>";
	}
	if(is_string($info))
	{
		return "<p style='border:1px solid red'><b>$title</b><br><span>$info</span></p>";
	}
	
}
//获得文件的扩展名
function fileExt($filepath){
	$pathInfoArr=pathinfo($filepath);
	$fileExt=$pathInfoArr['extension'];
	return $fileExt;
}


function getrgb($matches){
	return "(".intval($matches[1],16).",".intval($matches[2],16).",".intval($matches[3],16).")";
}

function color2rgb($value){
	if(preg_match("/^\#[0-9a-fA-F]{6}$/i",$value)){
	   return preg_replace_callback("/^\#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})/i","getrgb",$value);
	}else{
	   return false;
	}
}
function color2int($rgb){
	$arr=split('[(,)]',$rgb);
	$int=$arr[0]*pow(2,16)+$arr[1]*pow(2,8)+$arr[2];
	return $int;	
}

function fileNameEncode($fileName)
{
	if (PHP_OS=="Linux")
	{
			return urlencode(utf8ToGb($fileName));
	}
	else
	{
		return urlencode($fileName);
	}


	
}

function utf8ToGb($str_string)
{
	return iconv("UTF-8","GBK",$str_string);
}

function showInfo($s=true,$d="",$e=""){
	echo json_encode(array(
		"state"=>$s
		,"data"=>$d
		,"info"=>$e
	));
}
?>
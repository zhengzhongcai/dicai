<?php
header('Content-Type:text/html;charset=gb2312');
$areaId = $_GET['areaId'];
$filename = $_GET['filename'];
$floder = $_GET['floder'];
$uscroll = $_GET['scroll'];
$ubg = @$_GET['bg'];
$utype = $_GET['utype'];
if(empty($floder))
{
	echo '{"state":"false","message":"empty floder!"}';
	exit;
}
$floder = "../../Filelib/".$floder;
if(!file_exists($floder))
{
	echo '{"state":"false","message":"floder error!"}';
	exit;
}
//$html = !get_magic_quotes_gpc()?$_POST['html']:stripcslashes($_POST['html']);//允许存在'"
$html = $HTTP_RAW_POST_DATA;
if(empty($html))
{
	echo '{"state":"false","message":"empty editor!"}';
	exit;
}
if(empty($areaId))
{
	echo '{"state":"false","message":"lost areaId!"}';
	exit;
}
if(empty($filename))
{
	echo '{"state":"false","message":"lost filename!"}';
	exit;
}
if(empty($utype))
{
	echo '{"state":"false","message":"lost Url type!"}';
	exit;
}
//生成随机数	echo randomkeys(8);
function randomkeys($length)
{
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";  //字符池
	$key = "";
	for($i=0;$i<$length;$i++)
	{
		$key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
	}
	return $key;
}
$html = iconv("utf-8","gb2312",$html);
//产生随机文件...过滤特殊字符
if($utype == "Url1")
{
	$filename = preg_replace("/(\.html)$|(\.htm)$/","",$filename).randomkeys(3).".html";
}
else
{
	$filename = preg_replace("/(\.txt)$/","",$filename).randomkeys(3).".txt";
}
$fileid = "file_".$areaId."_".mt_rand(1,99);
if(!file_exists($floder."/".$filename))
{
	$fp = fopen($floder."/".$filename,"w");
	if($fp){
		if(fwrite($fp,$html)){
			//$md5 = md5_file("ftp://ams:ams@localhost/".$filename);
			//filemtime
			$filemtime = date("Y-m-d H:i:s.",filemtime($floder."/".$filename));
			//filesizes
			$filesize = filesize($floder."/".$filename);
			//上传至FTP服务器	默认html目录
			include_once("../CLASS/FTP.class.php");
			$myFtp=new FTP();
			if($myFtp->checkdir("html") == false)
			{
				$myFtp->createdir("html");
				$myFtp->checkdir("html");
			}
			if($myFtp->upLoadFile($floder."/".$filename,$filename) == false)
			{
				unlink($floder."/".$filename);
				fclose($fp);
				echo '{"state":"false","message":"false to upload file!"}';
				exit;
			}
		}
		fclose($fp);
	}
	else{	
		echo '{"state":"false","message":"false to create file!"}';
		exit;
	}
}
else{ 	
	echo '{"state":"false","message":"file exists!"}';
	exit;
}
$fullpath = urlencode('ftp://'.FTP_USER_NAME.':'.FTP_USER_PASS.'@'.FTP_SERVER.'/html/'.$filename);
$filepath = urlencode('ftp://'.FTP_SERVER.'/html/'.$filename);
echo '{"state":"success","areaid":"'.$areaId.'","fileid":"'.$fileid.'","full_path":"'.$fullpath.'","file_path":"'.$filepath.'","file_name":"'.$filename.'","file_type":"'.$utype.'","file_size":"'.$filesize.'","modify_date":"'.$filemtime.'","scroll_type":"'.$uscroll.'","back_ground":"'.$ubg.'"}';
?>
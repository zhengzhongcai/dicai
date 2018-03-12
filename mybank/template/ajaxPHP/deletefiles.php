<?php
/**
*资源管理-->删除文件..
**/
header('Content-Type:text/html;charset=gb2312');
require_once('../chkLogin.php');
$ids    = $_POST['ids'];
$floder = iconv("utf-8","gb2312",$_POST['flo']);
//echo $floder;exit;
if($ids){
	$ids      = preg_replace("/\,$/","",$ids);
	$floder   = preg_replace("/\,$/","",$floder);
	$arrfiles = explode(",", $floder);
	$sql = "delete from `play_file_property` where `PlayFileID` in ($ids)";
	include_once("../MySqlDateBase.class.php");
	$SqlDB = new MySqlDateBase();
	if($SqlDB->Query($sql))
	{
		include_once("../CLASS/FTP.class.php");
		$myFtp=new FTP();
		foreach($arrfiles as $v)
		{
			if(ftp_size($myFtp->conn_id,$v) != -1){
				ftp_delete($myFtp->conn_id, $v);
			}
		}
		$myFtp->closeFTP();
		echo "success";
	}
	else
	{
		echo "false";
	}
}
else
{
	echo "data error";
}
?>
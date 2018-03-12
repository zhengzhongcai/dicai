<?php
//文件管理，文件审核
require_once('../chkLogin.php');
$ids   = $_POST['ids'];
$ctype = intval($_POST['cktype']);
$notes = $_POST['name'];
if($ids){
	$ids = preg_replace("/\,$/","",$ids);
	$timestamp = date("Y-m-d H:i:s");//审核时间
	$auditor = $_SESSION['opuser'];
	include_once("../MySqlDateBase.class.php");
	$SqlDB = new MySqlDateBase();
	$sql = "update `play_file_property` set `state`=$ctype, `notes`='".$notes."', `auditor`='".$auditor."', `auditDate`='".$timestamp."' where `PlayFileID` in ($ids) and `state`=0";
	if($SqlDB->Query($sql))
	{
		echo "success";
	}
	else
	{
		echo "false";
	}
	$SqlDB->Close();
}
else
{
	echo "data error";
}

/*$filename = 'sss.txt';
$somecontent = "$sql \n".$ids."/".$ctype;
if (!$handle = fopen($filename, 'a')) {
	 echo "不能打开文件 $filename";
	 exit;
}

// 将$somecontent写入到我们打开的文件中。
if (fwrite($handle, $somecontent) === FALSE) {
	echo "不能写入到文件 $filename";
	exit;
}
fclose($handle);*/
?>
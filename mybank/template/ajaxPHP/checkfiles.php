<?php
//�ļ������ļ����
require_once('../chkLogin.php');
$ids   = $_POST['ids'];
$ctype = intval($_POST['cktype']);
$notes = $_POST['name'];
if($ids){
	$ids = preg_replace("/\,$/","",$ids);
	$timestamp = date("Y-m-d H:i:s");//���ʱ��
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
	 echo "���ܴ��ļ� $filename";
	 exit;
}

// ��$somecontentд�뵽���Ǵ򿪵��ļ��С�
if (fwrite($handle, $somecontent) === FALSE) {
	echo "����д�뵽�ļ� $filename";
	exit;
}
fclose($handle);*/
?>
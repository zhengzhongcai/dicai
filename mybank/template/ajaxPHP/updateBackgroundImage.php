<?php

/*


*/
//ģ����Ϣ
include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
$TempID=$_POST["TempID"];//ģ��ID
$TempIMG=urldecode($_POST["bgImg"]);
//
//echo'OK_@_@@_@_'.$TempID.'-'.$TempIMG;
$sql="update template set Extend1='".$TempIMG."' where TemplateID=".$TempID;
if($SqlDB->Query($sql))
	{$SqlDB->Close();echo "OK_@_@@_@_�޸� ���� �ɹ�\n";}
	else
	{$SqlDB->Close();echo "NO_@_@@_@_�޸� ���� ʧ��\n";}

//echo $tempInfo;

?>
<?php

/*


*/
//模板信息
include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
$TempID=$_POST["TempID"];//模板ID
$TempIMG=urldecode($_POST["bgImg"]);
//
//echo'OK_@_@@_@_'.$TempID.'-'.$TempIMG;
$sql="update template set Extend1='".$TempIMG."' where TemplateID=".$TempID;
if($SqlDB->Query($sql))
	{$SqlDB->Close();echo "OK_@_@@_@_修改 背景 成功\n";}
	else
	{$SqlDB->Close();echo "NO_@_@@_@_修改 背景 失败\n";}

//echo $tempInfo;

?>
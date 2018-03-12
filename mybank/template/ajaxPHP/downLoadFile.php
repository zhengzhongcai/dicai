<?php

$info=$_POST["data"];
$state=false;
$data="";
if(is_array($info))
{
	$file_name=iconv("utf-8","GBK",$info["file_name"]);
	$folder_Name=preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$info["folder_Name"])));
	$local_path="../../FileLib/".$folder_Name."/".$file_name;
	$oldPath="../../Material/".$file_name;
	if(@copy($oldPath,$local_path))
	{
		$state=true;
	}
}
echo json_encode(array("state"=>$state,"data"=>""));
?>
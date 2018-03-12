<?php
$file_folder=preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$_POST["folder_Name"])));
$local_ph= "../../FileLib/".$file_folder."/";
$file_name=urldecode($_POST["file_name"]);
$local_path=$local_ph.$file_name;

if(file_exists(@$local_path))
{
	if(@unlink($local_path))
	{
		echo "OK_@_@@_@_文件 \"".$file_name."\" 删除成功!";
	}
	else
	{
		echo "NO_@_@@_@_文件 \"".$file_name."\" 删除失败\n\t请检查您是否有足够的权限!";
	}
}
else
{
	echo "NULL_@_@@_@_文件 \"".$file_name."\" 删除成功!";
}
?>
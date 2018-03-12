<?php
$folderName=$_POST["folderName"];
$old_folderName=$_POST["old_folderName"];
$testdir="../../FileLib/".$folderName; 
$old_dir="../../FileLib/".$old_folderName; 

//echo "\n$testdir\n../../FileLib/".$folderName."\n";

include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
//删除子区域信息
$sql="select ProfileName from profile where ProfileName='".$folderName."'";
$res=$SqlDB->Query($sql);
$countRows=$SqlDB->getRowsNum($res);
if($countRows>0)
{
	echo "no_@_@@_@_对不起此profile已存在,请重新填写!";
}
else
{
	if(file_exists($testdir))
	{
		if(removeDir($testdir))
		{
			
			rename($old_dir,$testdir) or die("no_@_@@_@_对不起此profile名称创建失败,权限$testdir不够!");
			mkdir($old_dir,0777) or die("no_@_@@_@_对不起此profile名称已存在,请重新$testdir填写!");
			echo "ok_@_@@_@_创建成功$testdir!";
		}
		else
		{
			echo "no_@_@@_@_对不起此profile名称创建失败,权限$testdir不够!";
		}
	}
	else
	{
		rename($old_dir,$testdir) or die("no_@_@@_@_对不起此profile名称创建失败,权限$testdir不够!");
		mkdir($old_dir,0777) or die("no_@_@@_@_对不起此profile名称已存在,请重新$testdir填写!");
		echo "ok_@_@@_@_创建成功!$testdir";
	}
}

$SqlDB->Close();

function removeDir($dir) {
	  if ($handle = opendir("$dir")) {
	   while (false !== ($item = readdir($handle))) {
		 if ($item != "." && $item != "..") {
		   if (is_dir("$dir/$item")) {
			 removeDir("$dir/$item");
		   } else {
			 unlink("$dir/$item");
			 //echo " removing $dir/$item<br>\n";
		   }
		 }
	   }
	   closedir($handle);
	   rmdir($dir);
	   //echo "removing $dir<br>\n";
	  }
	  if(file_exists($testdir))
	  {return false;}
	  else
	  {return true;}
	} 
?>
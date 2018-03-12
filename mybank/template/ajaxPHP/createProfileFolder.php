<?php
$folderName=preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$_POST["folderName"])));
$old_folderName=iconv("utf-8","gb2312",$_POST["old_folderName"]);
$testdir="../../FileLib/".$folderName;   
$old_dir="../../FileLib/".$old_folderName;   



include_once("../MySqlDateBase.class.php");
//echo $_POST["folderName"]."----".$_POST["old_folderName"]."<br>  ";
//echo $testdir."----".$old_dir;
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
			if($old_folderName=="")
			{
				create_folders($testdir,0777)  or die("no_@_@@_@_对不起此profile名称已存在,请重新填写!");
				echo "ok_@_@@_@_创建成功".$testdir."!";
			}
			else
			{
				rename($old_dir,$testdir) or die("no_@_@@_@_对不起此profile名称已存在,请重新填写!");
				create_folders($old_dir,0777);
				echo "ok_@_@@_@_创建成功".$testdir."!";
			}
			
		}
		else
		{
			echo "no_@_@@_@_对不起此profile名称创建失败,权限不够!";
		}
	}
	else
	{
		if($old_folderName=="")
			{
				//echo "___________________________________".$testdir."___________________________________";
				create_folders($testdir,0777)  or die("no_@_@@_@_对不起此profile名称已存在,请重新填写!");
				echo "ok_@_@@_@_创建成功!";
			}
			else
			{
				rename($old_dir,$testdir) or die("no_@_@@_@_对不起此profile名称已存在,请重新填写!");
				create_folders($old_dir,0777);
				echo "ok_@_@@_@_创建成功!";
			}
	}
}

$SqlDB->Close();


 function create_folders($dir){  
 return is_dir($dir) or (create_folders(dirname($dir)) and mkdir($dir, 0777));  
 }




function removeDir($dir) {
	  if ($handle = opendir("$dir")) 
	  {
	   while (false !== ($item = readdir($handle))) 
	   {
		 if ($item != "." && $item != "..") 
		 {
		   if (is_dir("$dir/$item")) 
		   {
			 removeDir("$dir/$item");
		   } 
		   else 
		   {
			 unlink("$dir/$item");
			 //echo " removing $dir/$item<br>\n";
		   }
		 }
	   }
	   closedir($handle);
	   rmdir($dir);
	   //echo "removing $dir<br>\n";
	  }
	  if(file_exists($dir))
	  {return false;}
	  else
	  {return true;}
	} 


/*function deleteDir($dir) 
{ 
	if (rmdir($dir)==false && is_dir($dir)) { 
		 if ($dp = opendir($dir))
		 { 
			  while (($file=readdir($dp)) != false) 
			  { 
				   if (is_dir($file) && $file!='.' && $file!='..') 
				   { 
						deleteDir($file); 
				   } 
				   else 
				   { 
						unlink($file); 
				   } 
			  } 
			  closedir($dp); 
			  return true;
		 }
		 else 
		 { 
		  	return false;
		 } 
	}  
	else
	{return true;}
}*/
?>
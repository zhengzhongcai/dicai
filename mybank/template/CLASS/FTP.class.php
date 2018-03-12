<?php
header("content-type:text/html; charset=utf-8");
class FTP
{
	var $ftp_server;
	var $ftp_user_name;
	var $ftp_user_pass;
	var $conn_id;
	var $login_result;
	var $fileType;
	function FTP()
	{
			include_once("../config.php");
			include_once("FileType.class.php");
			$this->fileType=new FileType();
			$this->ftp_server=FTP_SERVER;
			$this->ftp_user_name=FTP_USER_NAME;
			$this->ftp_user_pass=FTP_USER_PASS;
			/*$this->ftp_server=$myconfig['ftpServer'];
			$this->ftp_user_name=$myconfig['ftpUser'];
			$this->ftp_user_pass=$myconfig['ftpPwd'];*/
			$this->conn_id = ftp_connect($this->ftp_server);// set up basic connection
			if ((!$this->conn_id))
			{
					echo "FTP connection has failed!";
					exit;
			}
			$this->login_result = ftp_login($this->conn_id, $this->ftp_user_name, $this->ftp_user_pass);// login with username and password
			// check connection
			if ((!$this->login_result))
			{
					echo "FTP connection has failed!";
					echo "Attempted to connect to $this->ftp_server for user $this->ftp_user_name";
					exit;
			}
			/*else
			{
					echo "Connected to $this->ftp_server, for user $this->ftp_user_name <hr>";
			}*/
	}

	function filecollect($dir="/"){
	  static $flist=array();
	  if ($files = ftp_nlist($this->conn_id,$dir)){
	  if($dir=="/")
	  {
		foreach ($files as $file) 
		{
			if (ftp_size($this->conn_id, $file) == "-1")
			{
				//$flist[] = $file; //父目录添加目录
				if($this->fileType->fileName($file)=="images"||$this->fileType->fileName($file)=="txt"||$this->fileType->fileName($file)=="swf"||$this->fileType->fileName($file)=="video"||$this->fileType->fileName($file)=="audio"||$this->fileType->fileName($file)=="html")
				{
					$this->filecollect($file);
				}
			}
		}
	  }
	  else
	  {
		foreach ($files as $file) 
		{
		  if (ftp_size($this->conn_id, $file) == "-1"){
			  //$flist[] = $file; //父目录添加目录
			$this->filecollect($file);
		  }
		  else 
		  {
			  $tp=$this->fileType->getType($file);
			  if($tp)
			  {
				switch($tp)
				 {
					 case"Swf":
					 $flist["Swf"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								    "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					 case"Video":
					 $flist["Video"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								   "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					 case"Txt":
					 $flist["Txt"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								   "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					 case"Img":
					 $flist["Img"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								    "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					 case"Audio":
					 $flist["Audio"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								    "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //iconv('UTF-8','GBK',$str) 
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					 case"Url":
					 $flist["Url"][] = array(
								   "fileName"=>$this->fileType->fileName($file),
								   "fileType"=>$tp,
								    "fileFullPath"=>urlencode("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "filePath"=>urlencode("ftp://".$this->ftp_server.$file),
								   //iconv('UTF-8','GBK',$str) 
								   //"fileSize"=>$this->get_size(ftp_size($this->conn_id,$file)),
								   "fileSize"=>ftp_size($this->conn_id,$file),
								   //"filemd5"=>md5_file("ftp://".$this->ftp_user_name.":".$this->ftp_user_pass."@".$this->ftp_server.$file),
								   "lastUpdateTime"=>date ("Y-m-d H:i:s", ftp_mdtm($this->conn_id,$file))
								   );
					 break;
					
				 }
			  }
			}
		}
	  }
	  }
	  return $flist;
	}
function s()
{
	  $tp=$this->fileType->getType("/a.swf");
	  echo $tp;
}
	 function get_size($size)
     {
         if ($size < 1024)
          {
              return round($size,2).' Byte';
          }
         elseif ($size < (1024*1024))
          {
              return round(($size/1024),2).' KB';
          }
         elseif ($size < (1024*1024*1024))
          {
              return round((($size/1024)/1024),2).' MB';
          }
         elseif ($size < (1024*1024*1024*1024))
          {
              return round(((($size/1024)/1024)/1024),2).' GB';
          }
     }


	// close the FTP stream
	function closeFTP()
	{
		ftp_close($this->conn_id);
	}
	
	function downLoadFile($local_path, $server_file)
	{
		//echo $local_path."\n".$server_file;
		if(ftp_get($this->conn_id, $local_path, $server_file, FTP_BINARY))
		{return true;}
		else
		{return false;}
	}
	//add upload file
	function upLoadFile($local_path,$server_file)
	{
		if(ftp_put($this->conn_id, $server_file, $local_path, FTP_BINARY))
		{
			return true;
		}
		{
			return false;
		}
	}
	//check dir	exists
	function checkdir($dir)
	{
		if(@ftp_chdir($this->conn_id, $dir))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//create dir
	function createdir($dir)
	{
		if(ftp_mkdir($this->conn_id, $dir))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

/*$keywords = preg_split ("/[\s]/", "hypertext language, programming");
print_r($keywords);
echo "<hr />";
$ftp=new FTP();
$f=$ftp->filecollect();
$a=$ftp->s();
$ftp->closeFTP();
echo "所有的文件分类 ".$a;
echo "<pre>";
print_r($f);
echo "<pre>";*/

?>
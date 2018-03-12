<?php
class M_fileManageGrid extends CI_Model
{
		function __construct(){
		parent::__construct();	
		$this->load->model('m_userEntity','userEntity');
	}
	
	//查询 文件列表
	function selectFilelist($up_user=1,$file_comm="0",$page=0,$pageSize=20,$dept,$fileType=NULL,$count=0,$filename,$sfilesize,$efilesize,$filenotes)
	{
	    //session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
		$debug=false;
		$sql="SELECT PlayFileID, URL, FileSize, ModifyDate, FileType,(select nodeName from userFileType where id=FileType) as FileTypeName, FileName, FileViewURL, UploadUser, UploadDate, Auditor, AuditDate, AuditState, IsCommon, FileNotes, FileTreeMenu, Extend3 FROM play_file_property WHERE 1";
		//$sql.=" AND UploadUser = ".$this->esValue($up_user, "int");
		$str_accessArea=$this->areaAccess();
		if(!is_bool($str_accessArea))
		{
			$sql.=" AND (UploadUser in ( select UserID from user where UGroupID= ".$str_accessArea.") or ".$this->userEntity->userID." = 1)";
		}
		
		$sql.=" AND IsCommon = ".$this->esValue($file_comm, "text");
		if($fileType!='all')
		{
		    $sql.=$fileType!=NULL?" AND FileType = ".$this->esValue($fileType, "int"):"";
		}
		$sql.=$filename!=''?" AND FileName  like '%".$filename."%'":"";
		$sql.=$sfilesize!=''?" AND FileSize  >= ".$sfilesize*1024:"";
		$sql.=$efilesize!=''?" AND FileSize  <= ".$efilesize*1024:"";
		$sql.=$filenotes!=''?" AND FileNotes  like '%".$filenotes."%'":"";
		$totalRows=$this->db->query($sql)->num_rows;
		$sql.=" ORDER BY PlayFileID DESC";
		$sql.=" LIMIT ".$page." , ".$pageSize;
		
		$Recordset=$this->db->query($sql)->result_array();
		
		$res["total"]=$totalRows;
		$res["data"]=$Recordset;
		if($debug)
		{
			$res["sql"]=$sql;
			echo Information("用户文件信息:",$res);
			exit(0);
		}
		return $res;
	}

	/**
	 *输出上传的资源
	 *@access public
	 *@param  $up_user
	 *@param  $file_comm 
	 *@param  $page
	 *@param  $pageSize
	 *@param  $dept
	 *@param  $fileType
	 *@param  $count
	 *@return Array $rs 查询结果
	 *@author BB
	 *@copyright 2013-4-22
	 */
	function getFileList($up_user,$file_comm,$page=0,$pageSize=20,$dept,$fileType=NULL,$count=0)
	{
	  /*  @session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
		{
			$_SESSION["access_area"]="all";
		}else $_SESSION["access_area"]=$_SESSION["Dept"];*/
		$debug=false;
		$sql="SELECT PlayFileID, URL, FileSize, ModifyDate, FileType,(select nodeName from userFileType where id=FileType) as FileTypeName, FileName, FileViewURL, UploadUser, UploadDate, Auditor, AuditDate, AuditState, IsCommon, FileNotes, FileTreeMenu, Extend3 FROM play_file_property WHERE 1";
		
		$str_accessArea=$this->areaAccess();
		if(!is_bool($str_accessArea))
		{
			$sql.=" AND (UploadUser in ( select UserID from user where ".$str_accessArea.") or ".$this->userEntity->userID." = 1)";
		}
		//$sql.=" AND UploadUser = ".$this->esValue($up_user, "int");
		//文件权限设置(自己上传的和被完全公开的)
        $sql.=" AND UploadUser not like '%/tar/%' ";

		if($this->userEntity->userRoleID!=1){
          $sql.=" AND UploadUser =".$up_user;
          $sql.=" OR IsCommon = 2";

		}
		
		//$sql.=" AND IsCommon = ".$this->esValue($file_comm, "text");
		if($fileType!='all')
		{
		    $sql.=$fileType!=NULL?" AND FileType = ".$this->esValue($fileType, "int"):"";
			//echo ($fileType==null?1:0)."--".$sql;
			//exit(1);
		}
		if($count<=0)
		{
			$totalRows=$this->db->query($sql)->num_rows;
			$totalPages = ceil($totalRows/$pageSize);
		}
		else{$totalPages=$count;}
		$sql.=" ORDER BY PlayFileID DESC";
		$sql.=" LIMIT ".$page." , ".$pageSize;
		
		$Recordset=$this->db->query($sql)->result_array();
		
		$res["totalPage"]=$totalPages;
		$res["totalRows"]=$totalRows;
		$res["data"]=$Recordset;
		if($debug)
		{
			$res["sql"]=$sql;
			echo Information("用户文件信息:",$res);
			exit(0);
		}
		return $res;
	}
	
	function areaAccess()
	{
		
		/*if(!isset($_SESSION["access_area"]))
		{
			@session_start();
		}
		if($_SESSION["access_area"]!="all")
		{	
//			echo  $_SESSION["access_area"];
//			exit(1);
			$arr_accessArea=explode(",",$_SESSION["access_area"]);
			$str_accessArea="";
			for($i=0,$n=count($arr_accessArea); $i<$n; $i++)
			{
				
				$str_accessArea.="UGroupID= ".$this->esValue($arr_accessArea[$i], "text");
				if($i!=$n-1)
				{
					$str_accessArea.=" or ";
				}
			}
//			echo  $str_accessArea;
//			exit(1);
			return $str_accessArea;
		}*/
		return true;
	}
	
	function esValue($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
	  if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }

	 // $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
}
?>
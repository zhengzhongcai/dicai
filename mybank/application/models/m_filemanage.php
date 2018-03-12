<?php
class m_fileManage extends CI_Model
{

	function __construct(){
		parent::__construct();	
		$this->load->model("m_userlog","UserLog");
		$this->load->model('m_userEntity','userEntity');
		$this->load->model('m_ftpserver','m_ftp');
	}
	private function returnInfo(){return array("state"=>"true","message"=>"","data"=>"");}
	private function debug(){return 0;}

	//清除文件地址中的FTP信息
	function delFtpInfo($url){
		$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$this->userEntity->userFTPID));
		$userFTPIP=$ftpInfo[0]["ftpIP"];
		return preg_replace("/ftp:\/\/".$userFTPIP."\//","",iconv("GBK","UTF-8",$url));
	}

    //从文件地址中提取出文件名称
    function getFileNameByPath($f_path){
    	$arr_pathInfo=explode("/",$f_path);
		if(count($arr_pathInfo)>1){
			return $arr_pathInfo[count($arr_pathInfo)-1];
		}
		else {
			return $f_path;
		}
    }
	function deleteFile($fileId)
	{
		//echo '{"state":"true","message":"\u4f60\u7684\u64cd\u4f5c\u72b6\u6001\u5982\u4e0b\uff1a","data":{"unused":[{"fileId":"183","fileName":"aaa.jpg","state":"true"}]}}';
		//exit();
		$returnInfo=$this->returnInfo();
		$returnInfo["data"]=array();
		//先检查是否有Profile在使用此文件
		//如果有则不删除
		//没有就删除
		//checkFileInPlayList 返回可以删除的文件的ID
		$_fileId=$fileId;			
		$fileId=$this->checkFileInPlayList($fileId);
		if(!is_array($fileId))
		{
			$returnInfo["state"]="false";
			$returnInfo["message"]="对不起，您的文件已经被删除。";
			echo json_encode($returnInfo);
			exit();
		}
		//如果有存在可以被删除的文件的Id
		if(count($fileId["unused"])>0)
		{
			$arr_result=array();
			$info=array();
			$info["fileId"]="";
			$info["fileName"]="";
			$info["state"]=array();
			$arr_used=$fileId["unused"];
			foreach($arr_used as $k=>$v)
			{
				//for($i=0,$n=count($v); $i<$n; $i++)
				//{
						$info["fileId"]=$v["PlayFileID"];
						$info["fileName"]=iconv("GBK","UTF-8",$this->getFileNameByPath($v["URL"]));
						$where["URL"]=$v["URL"];
						$where["FileViewURL"]=$v["FileViewURL"];
						$where["CheckSum"]=$v["CheckSum"];
						if($this->deleteMow($where))
						{
							$info["state"]="true";
							$info["info"]="";
							$this->UserLog->loginLog(3,3,$info["fileName"],'FileName='.$info["fileName"].'&URL='.$v['URL'],1);
						}
						else
						{
							$info["state"]="false";
							$info["info"]="您没有物理文件操作权限!";
							$this->UserLog->loginLog(3,3,$info["fileName"],'FileName='.$info["fileName"].'&URL='.$v['URL'],0);
						}
					
					$arr_result[]=$info;
					
				//}
			}
			$returnInfo["data"]["unused"]=$arr_result;
			
		}
		if(count($fileId["used"])>0)
		{
			$arr_result=array();
			$info=array();
			$info["fileId"]="";
			$info["fileName"]="";
			$info["usingId"]=array();
			$arr_used=$fileId["used"];
			
			foreach($arr_used as $k=>$v)
			{
				//for($i=0,$n=count($v); $i<$n; $i++)
				//{
					$file_name=
					
						$info["fileId"]=$v["PlayFileID"];
						$info["fileName"]=iconv("GBK","UTF-8",$this->getFileNameByPath($v["URL"]));
						$info["usingId"][]=$v["PlayFileID"];
					
				//}
				$arr_result[]=$info;
			}
			$returnInfo["data"]["used"]=$arr_result;
		}
		$returnInfo["state"]="true";
		$returnInfo["message"]="你的操作状态如下：";
		echo json_encode($returnInfo);
	}
	//在数据库中删除
	function deleteMow($where)
	{		
			//物理删除文件
			if (PHP_OS!="Linux")
		 	{
				 $d_path = getcwd()."\\Material\\";
				 $v_path= getcwd()."\\Material\\view\\";
			}
			else
			{
				$d_path = getcwd()."/Material/";
				$v_path= getcwd()."/Material/view/";
			}
			//获取被删除文件的路径
			
			$dpath=explode("/",$where["URL"]);
			$dpath=$dpath[count($dpath)-1];
			$d_path=$d_path.$dpath;
			$v_path=$v_path.$where["FileViewURL"];
			
			if($where["FileViewURL"]!="")
			{
				$this->deleFileFromFolder($v_path);
			}
			if($this->deleFileFromFolder($d_path))
			{
				$this->deleteFromDateBase($where["CheckSum"]);
				return true;
			}
			return false;
	}
	//从数据库删除
	function deleteFromDateBase($fileId)
	{
		//
		$sql="delete from play_file_property where CheckSum in ('".$fileId."')";
		$this->db->query($sql);
		if($this->debug())
		{
			echo "删除文件后输出删除的行数:<br>";
			var_dump($this->db->affected_rows());
		}

		if($this->db->affected_rows())
		{
			return true;
		}
		else
		{return false;}
	}
	//查询被删除文件的路径和预览文件路径
	function getFilePath($fileId)
	{
		$arr=array();
		$sql="select PlayFileID,URL,FileViewURL,CheckSum,FileName from play_file_property where PlayFileID in(".$fileId.")";
		$rs=$this->db->query($sql)->result_array();
		if(count($rs)>0)
		{
			$arr=$rs;
			return $arr;
		}
		else
		{ return $arr;}
	}
	//从文件库中删除文件
	function deleFileFromFolder($_path)
	{
		$t=false;
		if(file_exists($_path))
		{
			//echo "开始物理删除文件<br />文件: -->$_path<br />";
			
			$t=@unlink($_path);
		}
		else
		{
			$t=true;
		}
		return $t;
	}

	//检查被删除的文件是否在Profile种被使用
	function checkFileInPlayList($fileId)
	{
		//echo $fileId."<br>";
		$arr_rs_info=array();
		$arr_rs_info["used"]=array();
		$arr_rs_info["unused"]=array();
		
		$arr_fileId=explode(",", $fileId);
		//print_r($arr_fileId);
		
		//已经被使用的文件信息
		$this->db->select("PlayFileID");
		$this->db->where_in("PlayFileID",$arr_fileId);
		$arr_usedId=$this->db->get("playlist_describe")->result_array();
		
		$arr_PlayFileID=array();
		if(count($arr_usedId)){
			foreach($arr_usedId as $k=>$v)
			{
					$arr_PlayFileID[]=$v["PlayFileID"];
			}
			//$str_usedId=implode(",",$arr_PlayFileID);
			$this->db->select("PlayFileID,CheckSum,URL, FileViewURL");
			$this->db->where_in("PlayFileID",$arr_PlayFileID);
			$arr_rs_info["used"]=$this->db->get("play_file_property")->result_array();
		}
		
		//未被使用的文件信息
		foreach($arr_fileId as $k=>$v){
			foreach ($arr_PlayFileID as $key => $value) {
				if($v==$value){
					unset($arr_fileId[$k]);
				}
			}
		}
		//$str_unUsedId=implode(",",$arr_fileId);
		//echo "str_unUsedId:".$str_unUsedId."<br>";
		if(count($arr_fileId))
		{
			$this->db->select("PlayFileID,CheckSum,URL, FileViewURL");
			$this->db->where_in("PlayFileID",$arr_fileId);
			$arr_rs_info["unused"]=$this->db->get("play_file_property")->result_array();
		}
		else {
			$arr_rs_info["unused"]=array();
		}
		//echo $this->db->last_query();
		// $sql="SELECT `PlayFileID`,`CheckSum` FROM `play_file_property` WHERE `PlayFileID` in(".$fileId.")";
		// $arr_CheckSum=$this->db->query($sql)->result_array();
		// $str_CheckSum="";
		// $arr_CheckSum_info=array();
		// if(count($arr_CheckSum)>0)
		// {
			// foreach($arr_CheckSum as $k=>$v)
			// {
				// $arr_CheckSum_info[]="'".$v["CheckSum"]."'";
			// }
			// $str_CheckSum=implode(",",$arr_CheckSum_info);
		// }
		// if($str_CheckSum==""){return false;}
		// //echo Information("str_CheckSum",$str_CheckSum);
		// $sql="SELECT `PlayFileID`,`CheckSum`,`URL`, `FileViewURL`,`FileName` FROM `play_file_property` WHERE `CheckSum` in(".$str_CheckSum.")";
		// $arr_rs=$this->db->query($sql)->result_array();
		//echo Information("arr_rs",$arr_rs);
		
		//$arr_con=array();
		// for($a=0,$b=count($arr_CheckSum_info); $a<$b; $a++)
		// {
			// for($i=0,$n=count($arr_rs); $i<$n; $i++)
			// {
				// if(preg_replace("/'/","",$arr_CheckSum_info[$a])==$arr_rs[$i]["CheckSum"])
				// {
					// $arr_con[$arr_CheckSum_info[$a]][] = $arr_rs[$i];
				// }
			// }
		// }
		
		// $arr_rs_info=array();
		// $arr_rs_info["used"]=array();
		// $arr_rs_info["unused"]=array();
		
		
		
		
		// foreach($arr_con as $k=>$v )
		// {
			// if(count($v)>1)
			// {
				// $arr_rs_info["used"][]=$v;
			// }
			// else
			// {
				// $arr_rs_info["unused"][]=$v;
			// }
		// }
		// echo Information("00000",$arr_rs_info);
		// exit();
		//print_r($arr_rs_info);
		return $arr_rs_info;
	}

	//审核文件
	function shenheFile($fileId,$sate,$info)
	{
		$sql="update play_file_property set state=".$sate.",Extend1='"+$info+"' where PlayFileID=".$fileId;
		return $this->db->affected_rows();
	}

	//检查文件状态
	function checkedFileState($fileId)
	{
		$sql="select state from play_file_property where PlayFileID=".$fileId." LIMIT 1";
		$query = $this->db->query($sql);
		$row = $query->row();
		return  $row->state;
	}

	function getFileInfo($fileId){
		$sql = "select PlayFileID,
											URL,
											FileSize,
											ModifyDate,
											`CheckSum`,
											FileType,
											FileName,
											FileViewURL,
											UploadUser,
											UploadDate,
											Auditor,
											AuditDate,
											AuditState,
											IsCommon,
											FileNotes,
											FileTreeMenu,
											Extend1,
											Extend2,
											Extend3  from play_file_property where PlayFileID = ".$fileId;
		return $this->db->query($sql)->result_array();
	}
	
	
	
	function getFileList($up_user=1,$file_comm="0",$page=0,$pageSize=20,$dept,$fileType=NULL,$count=0)
	{
	   @session_start();
		
		
			
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
		$debug=false;
		$sql="SELECT PlayFileID, URL, FileSize, ModifyDate, FileType,(select nodeName from userFileType where id=FileType) as FileTypeName, FileName, FileViewURL, UploadUser, UploadDate, Auditor, AuditDate, AuditState, IsCommon, FileNotes, FileTreeMenu, Extend3, CheckSum FROM play_file_property WHERE 1";
		
		$str_accessArea=$this->areaAccess();
		if(!is_bool($str_accessArea))
		{
			$sql.=" AND (UploadUser in ( select UserID from user where ".$str_accessArea.") or ".$this->userEntity->userID." = 1)";
		}
		//自己上传的和别人上传公开的
		if($this->userEntity->userRoleID!=1){
			$sql.=" AND (UploadUser = ".$this->esValue($up_user, "int")." OR IsCommon =".$this->esValue(2, "text").")";
		
		}
		$sql.=" AND AuditState = 1";
		//$sql.=" AND IsCommon in (".$this->esValue($file_comm, "text").",".$this->esValue(2, "text").")";
		//$sql.=" AND IsCommon =".$this->esValue($file_comm, "text");
		if($fileType!='all')
		{
		    $sql.=$fileType!=NULL?" AND FileType = ".$this->esValue($fileType, "int"):"";
		}
		
		$data["totalRows"]=$this->db->query($sql)->num_rows;

		$sql.=" ORDER BY PlayFileID DESC";
		$sql.=" LIMIT ".$page." , ".$pageSize;
		$data["data"]=$this->db->query($sql)->result_array();
		return $data;
	}
	function areaAccess()
	{
		
		if(!isset($_SESSION["access_area"]))
		{
			session_start();
		}
		if($_SESSION["access_area"]!="all")
		{
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
			return $str_accessArea;
		}



		return true;
	}
	function esValue($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
	  if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }
	

	 //$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
      //print_r($theValue);
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

	/**
	 *把资源信息写到数据库
	 *@param Array $fileInfo
	 *@return 
	 *@author BB
	 *@copyright 2013-4-22
	 */
	function saveFileInfo($fileInfo)
	{
		/*`Auditor` ,
					`AuditDate` ,
					`AuditState` ,*/
		$sql="INSERT INTO `play_file_property` (
					`PlayFileID` ,
					`URL` ,
					`FileSize` ,
					`ModifyDate` ,
					`CheckSum` ,
					`FileType` ,
					`FileName`,
					`FileViewURL`,
					`UploadUser` ,
					`UploadDate` ,
					`FileTreeMenu` ,
					`IsCommon`,
					`AuditState`,
					`Extend1` ,
					`Extend3`
					)
					VALUES (
					NULL ,
					'".$fileInfo["fileUrl"]."',
					'".$fileInfo["fileSize"]."',
					'".$fileInfo["fileMdTime"]."',
					'".$fileInfo["fileMd5"]."',
					'".$fileInfo["fileTypeId"]."',
					'".$fileInfo["fileName"]."',
					'".$fileInfo["viewpath"]."',
					'".$fileInfo["uploadUserId"]."',
					'".$fileInfo["uploadDateTime"]."',
					'".$fileInfo["nodeId"]."',
					'0',
					'0',
					'".$fileInfo["ftpIp"]."',
					".$fileInfo["playtime"]."
					)";
		$this->db->query($sql);
		$r=$this->db->insert_id();
		return $r;
	}

	function updateFileInfo($info)
	{
		$this->db->where("PlayFileID",$info["fileId"]);
		$this->db->update("play_file_property",array("FileNotes"=>$info["fileNotes"],"IsCommon"=>$info["isCommon"]));
		$r=$this->db->affected_rows();
		return $r?true:false;
	}


	function  verifyFile($fileid,$tag){
		$data = explode(",",$fileid);
		$arr=$this->userEntity->userPermission;
		//var_dump($arr);
		if(is_array($data)){
								for($k = 0, $len = count($data);$k < $len;$k++){
									$this->db->where("PlayFileID",$data[$k]);
									$this->db->update("play_file_property",array("AuditState"=>$tag));
								}
								$succ = $this->db->affected_rows();
								return $succ ? 1:0;
		     /*   foreach ($arr as &$value) {
                 foreach($value as $k=>$v){
				        if($v == "审核资源"){ 
				          // return "dfgd" ;
				           if(is_array($data)){
								for($k = 0, $len = count($data);$k < $len;$k++){
									$this->db->where("PlayFileID",$data[$k]);
									$this->db->update("play_file_property",array("AuditState"=>$tag));
								}
								$succ = $this->db->affected_rows();
								return $succ ? 1:0;
							}else return 0;
				        }
				    }*/
				}
		
		
	}
	function  commonFile($fileid,$tag){
		$data = explode(",",$fileid);
        $user=$this->userEntity->userID;
		if(is_array($data)){
			for($k = 0, $len = count($data);$k < $len;$k++){
				$this->db->where("PlayFileID",$data[$k]);
				$this->db->select('UploadUser');
				$query=$this->db->get("play_file_property");
				$UploadUser=$query->result_array();
				if($user!=$UploadUser[0]['UploadUser']&&$user!=1){
					//var_dump($UploadUser);
					return 2;
				}
				$this->db->where("PlayFileID",$data[$k]);
				$this->db->select('AuditState');
				$query=$this->db->get("play_file_property");
				$AuditState=$query->result_array();
				if($AuditState[0]['AuditState']==0){
					return 3;
				}
				$this->db->where("PlayFileID",$data[$k]);
				$this->db->update("play_file_property",array("IsCommon"=>$tag));
			}
			$succ = $this->db->affected_rows();
			return $succ ? 1:0;
		}else return 0;
	}
	function  privateFile($fileid,$tag){
		$data = explode(",",$fileid);
		$user=$this->userEntity->userID;
		if(is_array($data)){
			for($k = 0, $len = count($data);$k < $len;$k++){
				$this->db->where("PlayFileID",$data[$k]);
				$this->db->select('UploadUser');
				$query=$this->db->get("play_file_property");
				$UploadUser=$query->result_array();
				if($user!=$UploadUser[0]['UploadUser']&&$user!=1){
					//var_dump($UploadUser);
					return 2;
				}
				$this->db->where("PlayFileID",$data[$k]);
				$this->db->update("play_file_property",array("IsCommon"=>$tag));
			}
			$succ = $this->db->affected_rows();
			return $succ ? 1:0;
		}else return 0;
	}
	
		/**
	 *通过文件ID获取到某一个文件的详细信息
	 *@param int $f_id 文件对应数据库ID
	 *@return bool或者查询到的数据
	 *@author 莫波
	 *@copyright 2013-09-23 13:02:31
	 */
	function getFileInfoByID($f_id){
		$this->db->select("PlayFileID as file_ID,
										URL as file_path,
										FileSize as file_size,
										ModifyDate as file_modifyDate,
										CheckSum as file_checkSum,
										FileType as file_type,
										FileName as file_name,
										FileViewURL as file_viewPath,
										UploadUser as file_upuser,
										UploadDate as file_update,
										Auditor as file_auditor,
										AuditDate as file_audate,
										AuditState as file_austate,
										IsCommon as file_com,
										FileNotes as file_notes,
										FileTreeMenu as file_treeMenu,
										Extend1 as file_ext1,
										Extend2 as file_ext2,
										Extend3 as file_playTime");
		$this->db->where("PlayFileID",$f_id);
		$arr_res=$this->db->get("play_file_property")->result_array();
		if(count($arr_res)){
			return $arr_res[0];
		}
		return false ;
	}
}
?>
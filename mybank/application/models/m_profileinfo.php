<?php
class M_profileInfo extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->helper("serverSystemInfo");
		$this->load->model('m_userEntity','userEntity');
	}
	function checkProfileName($profileName)
	{	
		$sql="select ProfileName from profile where ProfileName='".$profileName."'";
		$query=$this->db->query($sql);
		if ($query->num_rows() > 0)
		{
			return true;
		}
		return false;
	}
	function createProfileFolder($profileName)
	{
		//检查是否存在同名
		if(!$this->checkProfileName($profileName))
		{
			//把缓存文件的文件夹重命名为profile的名称
			@session_start();
			$path=iconv("utf-8","gb2312",$this->userEntity->userName."Cache");
			if(PHP_OS=="WINNT")
			{
				if(!rename(getcwd()."\\FileLib\\".$path,getcwd()."\\FileLib\\".$profileName))
				{
					echo "重命名";
					exit(0);
				}
				
				if(!mkdir(getcwd()."\\FileLib\\".$path,0777))
				{
					echo "创建新目录";
					exit(0);
				}
			}
			else
			{
				if(!rename(getcwd()."/FileLib/".$path,getcwd()."/FileLib/".$profileName))
				{
					echo "重命名";
					exit(0);
				}	
				if(!mkdir(getcwd()."/FileLib/".$path,0777))
				{
					echo "创建新目录";
					exit(0);
				}
			}
		}
		else
		{
			echo "存在同名";
			exit(0);
		}
		
	}
	
	//-------------------------------------
	//-
	//- 创建 Profile 失败 后 重建立文件缓存
	//-
	//- 第一步: 先删除数据库中的数据
	//- 第二步: 重建文件缓存
	//-------------------------------------
	function resetProfileCacheFiles($profileName)
	{
		//第二步 重建文件缓存
		//把缓存文件的文件夹重命名为profile的名称
		@session_start();
		$path=iconv("utf-8","gb2312",$this->userEntity->userName."Cache");
		if(PHP_OS=="WINNT")
		{
			@rmdir(getcwd()."\\FileLib\\".$path);
			if(!rename(getcwd()."\\FileLib\\".$profileName,getcwd()."\\FileLib\\".$path))
			{
				echo "重建文件缓存失败";
				exit(0);
			}
		}
		else
		{
			@rmdir(getcwd()."/FileLib/".$path);
			if(!rename(getcwd()."/FileLib/".$profileName,getcwd()."/FileLib/".$path))
			{
				echo "重建文件缓存失败";
				exit(0);
			}	
		}
	}
	//----------------------------
	// 
	// 2011年12月28日17:12:25 by mobo
	//----------------------------
	function getProfileInfo($pageInfo){
		$profileInfo=array();
		@session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
	
		$var_dept=$this->areaAccess();
		$sql="";
		if(!is_bool($var_dept))
		{
			$sql.=" where Extend5 in (".$var_dept.")";
		}
		$sql.=" order by profileID desc";
		
		$sql_count="select count(*) as resultCount from profile ".$sql;
		$query=$this->db->query($sql_count)->result_array();
		
		$data=array();
		$data["totalRows"]=$query[0]["resultCount"];
		
		$sql_content="select *  from profile ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		$query=$this->db->query($sql_content);
		$i=0;
		foreach($query->result() as $row)
		{
			$profileInfo[$i]['profileID']=$row->ProfileID;
			//$profileInfo[$i]['profileName']=preg_replace($row->ProfileName);
			$profileInfo[$i]['profileName']=iconv("gbk","utf-8",urldecode(preg_replace("/\_/","%",$row->ProfileName)));
			$profileInfo[$i]['profileViewName']=$row->ProfileName;
			$profileInfo[$i]['profileTime']=$row->ProfilePeriod;
			$profileInfo[$i]['profileType']=$row->ProfileType;
			$profileInfo[$i]['profileJumpUrl']=$row->TouchJumpUrl;
			$profileInfo[$i]['profileTemplateID']=$row->TemplateID;
			$profileInfo[$i]['profileTemplateFileID']=$row->TemplateFileID;
			$i++;
		}//循环结束
		$data["result"]=$profileInfo;
		return $data;
	}

	function getProgramByWhere($where,$limit=20){
		//@session_start();
		$this->db->where($where);
		//$this->db->where('Extend5', $this->userEntity->userGroupID);
		
		$this->db->limit($limit);
		$this->db->order_by('ProfileID','desc');
		$query=$this->db->get('profile');
		$i=0;
		$profile=array();
		foreach($query->result() as $row){
			$profile[$i]['profileID']=$row->ProfileID;
			$profile[$i]['profileName']=urldecode(preg_replace("/\_/","%",$row->ProfileName));
			$profile[$i]['profileType']=$row->ProfileType;
			$i++;
		}
		//print_r($profile);
		return $profile;
	
	}

	function areaAccess()
	{
		
		if(!isset($_SESSION["access_area"]))
		{
			@session_start();
		}
		if($_SESSION["access_area"]!="all")
		{
			$arr_accessArea=explode(",",$_SESSION["access_area"]);
			$str_accessArea="";
			for($i=0,$n=count($arr_accessArea); $i<$n; $i++)
			{
				$str_accessArea.="'".$arr_accessArea[$i]."'";
				if($i!=$n-1)
				{
					$str_accessArea.=" , ";
				}
			}
			return $str_accessArea;
		}
		return true;
	}
	//-----------------------------
	//	删除节目
	//	需要从 表: profile,profile_describe,playlist_describe,play_file_property 中删除
	//	然后从fileLib中删除
	//	对应 键 如下
	//	profile(profileID)-------profile_describe(profileID)
	//	profile_describe(PlayFileID)------play_file_property(PlayFileID)
	//	playlist_describe(ProfileID)
	function deleteMulProfile($where)
	{
		$info=array(); //------------> 操作信息记录(日志)
		$profileID=$where["ProfileID"];
		//从playlist_describe中删除profile相关信息
		//从profile_describe中删除profile相关信息
		$playlistIDArr=$this->getProfileDescribe($profileID);
		$playlistIDNum=count($playlistIDArr);
		for($i=0;$i<$playlistIDNum;$i++)
		{
			
			$playfileIDArr=$this->getPlaylistDesribe($playlistIDArr[$i]);
			$playfileIDNum=count($playfileIDArr);
			for($j=0;$j<$playfileIDNum;$j++)
			{
				$tables = array('playlist_describe');
				$this->db->where('PlayFileID', $playfileIDArr[$j]);
				$this->db->delete($tables);
			}
			$tables = array('profile_describe', 'playlist',);
			$this->db->where('PlaylistID', $playlistIDArr[$i]);
			$this->db->delete($tables);
		}
		
		
		//从play_file_property中删除profile tar包相关信息
		$this->db->select("TemplateFileID");
		$this->db->where("ProfileID",$profileID);
		$this->db->from("profile");
		$query=$this->db->get();
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $tar_id=$row->TemplateFileID;
		   $this->db->delete('play_file_property',array('PlayFileID'=>$tar_id));
		}
		
		// 获得profile名称
		$profileName=$this->getProfileNameByID($profileID);
		
		//从profile表中删除
		$this->db->delete('profile',array('ProfileID'=>$profileID));
		//从week_playlist_describe表中删除
		$this->db->delete('week_playlist_describe',array('ProfileID'=>$profileID));
		
		
		
		//删除文件夹
		
		if(is_bool($profileName))
		{
			$profileDir="";
			$info["proNameIsNull"]=true;
		}
		else
		{ 
			$info["proName"]=$profileName;
		}
		$profileDir=FILELIB.$profileName;
		
		if($profileDir!=""&&count(explode(FILELIB,$profileDir))>1)
		{
			$this->removeDir($profileDir);
		}
		else {$info["proDirIsNull"]=true;}
		//删除tar包
		//echo Information("删除tar包",FILELIB.$profileName.'.tar');
		if(file_exists(FILELIB.$profileName.'.tar'))
		{
			@unlink(FILELIB.$profileName.'.tar');
		}
		else {$info["proTarIsNull"]=true;}
		return trueInfo($info);
	}
	/*************************************************************
    |
    |	函数名:deleteProgramSaveFiles
    |	功能:通过节目名删除节目,保留物理文件?
    |	返回值: 直接输出 JQUERY
    |	参数: $name 节目名称, $bool 是否删除物理文件
    |	创建时间:2012年8月2日 17:28:03 by 莫波
    |   
    **************************************************************/
	function deleteProgramSaveFiles($where,$bool=true){
		$info=array(); //------------> 操作信息记录(日志)
		$profileID=$where["ProfileID"];

		
		
		//从playlist_describe中删除profile相关信息
		//从profile_describe中删除profile相关信息
		$playlistIDArr=$this->getProfileDescribe($profileID);
		$playlistIDNum=count($playlistIDArr);
		for($i=0;$i<$playlistIDNum;$i++)
		{
			
			$playfileIDArr=$this->getPlaylistDesribe($playlistIDArr[$i]);
			$playfileIDNum=count($playfileIDArr);
			for($j=0;$j<$playfileIDNum;$j++)
			{
				$tables = array('playlist_describe');
				$this->db->where('PlayFileID', $playfileIDArr[$j]);
				$this->db->delete($tables);
				
				
			}
			$tables = array('profile_describe', 'playlist',);
			$this->db->where('PlaylistID', $playlistIDArr[$i]);
			$this->db->delete($tables);
		}
		
		
		//从play_file_property中删除profile相关信息
		$this->db->select("TemplateFileID");
		$this->db->where("ProfileID",$profileID);
		$this->db->from("profile");
		$query=$this->db->get();
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $tar_id=$row->TemplateFileID;
		   $this->db->delete('play_file_property',array('PlayFileID'=>$tar_id));
		}
		
		// 获得profile名称
		$profileName=$this->getProfileNameByID($profileID);
		
		//从profile表中删除
		$this->db->delete('profile',array('ProfileID'=>$profileID));
		//从week_playlist_describe表中删除
		$this->db->delete('week_playlist_describe',array('ProfileID'=>$profileID));
		if($bool)
		{
			//删除文件夹
		
			if(is_bool($profileName))
			{
				$profileDir="";
				$info["proNameIsNull"]=true;
			}
			else
			{ 
				$info["proName"]=$profileName;
			}
			$profileDir=FILELIB.$profileName;
			
			if($profileDir!=""&&count(explode(FILELIB,$profileDir))>1)
			{
				$this->removeDir($profileDir);
			}
			else {$info["proDirIsNull"]=true;}
			//删除tar包
			//echo Information("删除tar包",FILELIB.$profileName.'.tar');
			if(file_exists(FILELIB.$profileName.'.tar'))
			{
				@unlink(FILELIB.$profileName.'.tar');
			}
			else {$info["proTarIsNull"]=true;}
		}
		return true;
	}
	//-----------------------------
	//	查询某个节目的详情文件id
	//	$profileID int 播放文件的ID
	//  2011年12月28日20:00:41 mobo
	function getProfileDescribe($profileID){
		$sql="select PlaylistID from profile_describe";
		if($profileID!=""){
			$sql.=" where ProfileID=".$profileID;
		}
		$playlist=array();
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$playlist[$i]=$row->PlaylistID;
				$i++;
			}
		}
		return $playlist;
	}
	//-----------------------------
	//	查询某个播放计划中的节目的id
	//	$playlistID int 节目的id
	//  2011年12月28日20:03:41 mobo
	function getPlaylistDesribe($playlistID){
		$sql="select PlayFileID from playlist_describe";
		if($playlistID!=""){
			$sql.=" where PlaylistID=".$playlistID;
		}
		$playfile=array();
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$playfile[$i]=$row->PlayFileID;
				$i++;
			}
		}
		return $playfile;
	}
	//-----------------------------
	//	查询某个节目的名称
	//	$profileID int 节目的id
	//  2011年12月28日20:05:30 mobo
	function getProfileNameByID($profileID=''){
		//$this->db->select('ProfileName');
		//$query=$this->db->get_where('profile',array('ProfileID'=>$profileID));
		$sql="select ProfileName from profile where ProfileID=".$profileID;
		$query=$this->db->query($sql);
		$profileName='';
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$profileName=$row->ProfileName;
				break;
			}
		}
		else
		{
			return false;
		}
		return $profileName;
	}
	
	function removeDir($dir) {
		if(!is_dir($dir))
		{
			return false;
		}
		if ($handle = @opendir($dir)) 
		{ 
			while (false !== ($item = readdir($handle))) 
			{
				if ($item != "." && $item != "..") 
				{
					if (is_dir("$dir/$item")) 
					{
						$this->removeDir("$dir/$item");
					} 
					else 
					{
						@unlink("$dir/$item");
						//echo " removing $dir/$item<br>\n";
					}
				}
			}
	   closedir($handle);
	   @rmdir($dir);
	  // echo " removing $dir<br>\n";
	  }
	}
	
	
	function removeAreaFiles($data){
	//print_r($data);
		if(isset($data["fileArray"])&&isset($data["folder"])&&isset($data["programId"])&&isset($data["areaId"]))
		{
			//从数据库删除
			$where=array("ProfileID"=>$data["programId"],"SequenceNum"=>$data["areaId"]);
			$this->db->select("PlaylistID,PlaylistType,PlaylistSubType");
			$this->db->where($where);
			$programAreaInfo=$this->db->get("profile_describe")->result_array();

			if(!count($programAreaInfo))
			{
				return false;
			}
			$playlistID=$programAreaInfo[0]["PlaylistID"];
			   // 从数据表 profile_describe 中删除
			$this->db->where($where);
			$this->db->delete("profile_describe");
			
				//从数据表中找到文件列表中的文件例如 滚动字幕的Tar包记录
			//-- 如果是滚动字幕还要删除滚动字幕包
			if($programAreaInfo[0]["PlaylistType"]=="MESSAGE"&&$programAreaInfo[0]["PlaylistSubType"]=="0")
			{
				$this->db->select("PlayFileID,ControlPara9");
				$this->db->where("PlaylistID",$playlistID);
				$playFilesID=$this->db->get("playlist_describe")->result_array();
				if(count($playFilesID)){
					foreach($playFilesID as $k=>$v)
					{
						$this->db->where("PlayFileID",$v["PlayFileID"]);
						$this->db->or_where("PlayFileID",$v["ControlPara9"]);
						$this->db->delete("play_file_property");
					}
				}	
			}
			else
			{
				$this->db->select("PlayFileID");
				$this->db->where("PlaylistID",$playlistID);
				$playFilesID=$this->db->get("playlist_describe")->result_array();
				if(count($playFilesID)){
					foreach($playFilesID as $k=>$v)
					{
						$this->db->where("PlayFileID",$v["PlayFileID"]);
						$this->db->delete("play_file_property");
					}
				}	
			}
			$this->db->where("PlaylistID",$playlistID);
			$this->db->delete(array("playlist","playlist_describe"));
			
			//从文件库删除
			$file_folder = preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$data["folder"])));
			$folder_ph= "FileLib/".$file_folder."/";
			$stateArray=array();
			foreach($data["fileArray"] as $k=>$v)
			{
				$file_name=$v;
				$local_path=$folder_ph.$file_name;
				if(@is_file($local_path))
				{
					@unlink($local_path);
				}
				// $error_arrray=error_get_last();
				// if(is_array($error_arrray))
				// {
					// $stateArray[$file_name]=array("state"=>false,"data"=>"","error"=>$error_arrray["message"]);
				// }
			}
			// if(!count($stateArray)){
				// echo json_encode("state"=>false,"data"=>"","error"=>$stateArray);
			// }
			return true;
		}
	}
}
?>
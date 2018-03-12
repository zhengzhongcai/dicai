<?php
class C_profileInfo extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model("m_profileInfo","mProfileInfo");
		$this->load->model("m_templatemanage","mTemplate");
		
		$this->load->model('m_userLog','userLog');
	}
	//--------------------------
	//	获取节目列表
	//	2011年12月28日19:43:05
	//
	function getProfileInfo()
	{
		// $data=array();
		// $data['title']='节目列表';
		// $data['pageSize']=20;
		// $data['pageIndex']=0;
		// //pArr($data);
		// $arr_result=$this->mProfileInfo->getProfileInfo($data);
		// $data['playListInfo']=$arr_result["result"];
// 		
		// $pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
		// $data['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
		// $this->load->view('v_profileInfo',$data);
		
		$this->load->view('v_profileInfo');
	}

    //获取快速创建节目管理
	function getFastProfileInfo()
	{
		// $data=array();
		// $data['title']='节目列表';
		// $data['pageSize']=20;
		// $data['pageIndex']=0;
		// //pArr($data);
		// $arr_result=$this->mProfileInfo->getProfileInfo($data);
		// $data['playListInfo']=$arr_result["result"];
// 		
		// $pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
		// $data['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
		// $this->load->view('v_profileInfo',$data);
		
		$this->load->view('v_fastProfileInfo');
	}

	function profileList(){
		
		$data=array();
		$data['title']='节目列表';
		$data['pageSize']=$this->input->post("rows");
		$data['pageIndex']=($this->input->post("page")*1-1)*$data['pageSize'];
		$arr_result=$this->mProfileInfo->getProfileInfo($data);
		
		$result=array(
			"total"=>$arr_result["totalRows"],
			"rows"=>$arr_result["result"]
		);
		//showInfo(true,$result);
		echo json_encode($result);
	}
	function deleteMulProfile()
	{
		$profileId=$this->input->post("data");
		$profileId=explode(",",$profileId);
		foreach($profileId as $v)
		{
			$where["ProfileID"]=$v;
			$state=$this->mProfileInfo->deleteMulProfile($where);
			if($state[0]=="true")
			{
				$this->userLog->delProLog($state[1]);
			}
		}
		
	}
	function getProfileListPage()
	{
		$pageInfo=$this->input->post("data");
		//echo $pageInfo;
		
		$data=json_decode($pageInfo,true);
		$pageInfo=array();
		$pageInfo["pageSize"]=$data["pageSize"];
		$pageInfo["pageIndex"]=($data["curent"]*1-1)*$pageInfo["pageSize"];
		$keyWord=$data["keyWord"];
		if(is_array($keyWord))
		{
			$pageInfo["keyWord"]="";
		}
		$arr_result=$this->mProfileInfo->getProfileInfo($pageInfo);
		$info=array();
		$info['profileInfo']=$arr_result["result"];
		//$info['pageCount']=$arr_result["totalRows"];
		$pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
		$info['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
		echo json_encode($info);
	}
	//
	/*************************************************************
    |
    |	函数名:deleteProfileByName
    |	功能:当profile创建失败的时候执行 还原当前Program的环境
    |	返回值: 直接输出 JQUERY
    |	参数:
    |	创建时间:2012年8月2日 17:23:57 by 莫波
    |   
    **************************************************************/
	function clearCreateProgramErrorInfo(){
		$state=false;
		@session_start();
		if(isset($_SESSION["failedProfileFolder"]))
		{
			$profileName=$_SESSION["failedProfileFolder"];
			$path=getcwd()."\\FileLib\\".iconv("utf-8","gb2312",$_SESSION["opuser"])."Cache";
			@rmdir($path);
			if(@rename(getcwd()."\\FileLib\\".$profileName,$path)){
				$state=true;
			}
			$this->deleteProfileByName($profileName,false);
			unset($_SESSION["failedProfileFolder"]);
		}
		if(isset($_SESSION["scrollImgCacheFolder"]))
		{
			for($i=0,$n=count($_SESSION["scrollImgCacheFolder"]); $i<$n; $i++)
			{
				$this->removeDir($_SESSION["scrollImgCacheFolder"][$i]);
			}
			unset($_SESSION["scrollImgCacheFolder"]);
		}
		echo json_encode(array("state"=>$state,"data"=>""));
	}
	/*************************************************************
    |
    |	函数名:deleteProfileByName
    |	功能:通过节目名删除节目,但是保留物理文件
    |	返回值: 直接输出 JQUERY
    |	参数: $name 节目名称, $bool 是否删除物理文件
    |	创建时间:2012年8月2日 17:23:05 by 莫波
    |   
    **************************************************************/
	function deleteProfileByName($name,$bool){
		$this->db->where("ProfileName",$name);
		$this->db->select('ProfileID');
		$res = $this->db->get('profile');
		foreach ($res->result() as $row)
		{
			$where["ProfileID"]=$row->ProfileID;
			$state=$this->mProfileInfo->deleteProgramSaveFiles($where,$bool);
			break;
		}
		
	
	}
	function removeDir($dir) 
	{
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
	
	function getProgramInfoToEdit($profileId){
		$this->lang->load('profileInfo');
		$ProfileID=$profileId;//$this->input->post("profileid");
		//查询节目的数据信息
		$sql_Profile="select ProfileID, ProfileType,ProfileName,ProfilePeriod,TouchJumpUrl,TemplateID from profile where ProfileID='".$ProfileID."'";
		$profileInfo=$this->db->query($sql_Profile)->result_array();
		if(!count($profileInfo)){echo json_encode(array("state"=>false,"data"=>"","error"=>$this->lang->line("profileInfo_Error_profielNotFound")));}
		$sql_Profile_des="select SequenceNum,PlaylistType,PlaylistSubType,PlaylistID from profile_describe where ProfileID=".$ProfileID;
		$profileDesInfo=$this->db->query($sql_Profile_des);
		if(!count($profileInfo)){echo json_encode(array("state"=>false,"data"=>"","error"=>$this->lang->line("profileInfo_Error_infoNotComplete")));}
		//查询节目模板信息
		$templateId=$profileInfo[0]["TemplateID"];
		$sql_template=$this->mTemplate->getTempById($templateId);
		
	}
	/*************************************************************
    |
    |	函数名:removeAreaFiles
    |	功能: 编辑节目模板时候,删除某个区域时候触发,删除此区域,以及区域中的文件
    |	返回值: 直接输出 JQUERY
    |	参数: $data["fileArray"] array 区域文件名称;  
	|         $data["folder"] string 节目缓存文件夹; 
	|		  $data["programId"] int 节目ID; 
	|		  $data["areaId"] int 区域ID
    |	创建时间:2012年12月30日 18:31:46 by 莫波
    |   
    **************************************************************/
	function removeAreaFiles(){
		$data=$this->input->post("data");
		if(is_array($data))
		{
			$rs=$this->mProfileInfo->removeAreaFiles($data);
			if($rs){
				echo json_encode(array("state"=>true,"data"=>"删除成功!"));
			}
			else
			{
				echo json_encode(array("state"=>false,"data"=>"","error"=>"您指定的区域不存在"));
			}
		}
		else{
			echo json_encode(array("state"=>false,"data"=>"","error"=>"您提交的数据不对"));
			}
	}
	
	function copyFilesToCacheFolder(){
		$info=array("state"=>true,"data"=>"","extend"=>"","error"=>"");
		$data=$this->input->post("data");
		//dump($data);
		if(is_array($data))
		{
			$extend=array();
			$state=false;
			$folder_Name=preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$data["folder_Name"])));

			for($i=0,$n=count($data["file_name"]); $i<$n; $i++)
			{
				$file_name=iconv("utf-8","GBK",$data["file_name"][$i]);
				$local_path="FileLib/".$folder_Name."/".$file_name;
				$oldPath="Material/".$file_name;
				//copy($local_path,$oldPath);
				$info["extend"]= $local_path;
				if(!(@copy($oldPath,$local_path))){
					$extend[]=$data["file_name"][$i];
					//echo $data["folder_Name"];
				}
			}
		
			if(count($extend)){
				$info["extend"]="您分配的文件中: <br />".implode(",",$extend)."<br />没有移动成功! <br />以上文件不会被放进区域文件队列中!";
				$info["state"]=false;
				$info["data"]=$extend;
			}
			
			
			echo json_encode($info,true);
		}
		else{
			echo json_encode(array("state"=>false,"data"=>"","error"=>"您提交的数据不对"),true);
			}
	}
}
?>
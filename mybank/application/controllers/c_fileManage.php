<?php
class C_fileManage extends CI_Controller {
	/**
	 * 
	 * 构造函数 引用各种model供后续函数获取信息
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_filemanage','m_fm');
		$this->load->model("m_filetype","m_ft");
//		$this->load->model('m_config','mconfig');
//		$this->load->model('m_userManage','m_um');
		$this->load->model('m_userEntity','userEntity');
		$this->load->model('m_ftpserver','m_ftp');
	}

	/**
	 * 
	 * 获取用户的用户名和sessionid用来预览素材，同时返回资源的所有类型并在页面显示
	 * 
	 * @author	BB  
	 * @param	null
	 * @return	void
	 * @internal  kycool add note
	 * @copyright  2013.2.27
	 */
	function fileManageUI()
	{
		//@session_start(); 
		$data["Uid"] = $this->userEntity->userID;
		//$data["sessionId"]= session_id();
		$data["fileTypeForFlashUpload"]=$this->m_ft->getFileTypeForFlashUpload();
		$this->load->view("fileManage",$data);
	}
	
	/**
	 * 功能:获取某一类型的文件列表
	 * 
     * @method  getOneTypeFileList 
     * @param  分页参数
     * @return 直接输出jquery 
	*/
	function getImageFileListToTemp()
	{

		$data=$this->input->post("data");
		if(is_array($data))
		{
			$result=$this->getOneTypeFileList_data($data);
			$info=array();
            
			$info['pageCount']=$result["pageCount"];
			$info['bgImgInfo']=array();
			foreach($result["arr_result"] as $k=>$v)
			{
				$info['bgImgInfo'][]=array(
					"fileID"=>$v["PlayFileID"],
					"name"=>$v["FileName"],
					"viewpath"=>base_url()."Material/".$v["FileViewURL"]
					);
			}
			
			if(count($info['bgImgInfo']))
			{
				echo json_encode(array("state"=>"true","data"=>$info));
			}
			else
			{
				echo json_encode(array("state"=>"false","data"=>""));
			}
		}		
	}
	


	/**
	 * 
	 * 获取某一类型的文件列表
	 * 
	 * @author  BB
	 * @param   分页参数
	 * @return	直接输出jQuery
	 * @internal  kycool add note
	 * @copyright  2013.2.27
	 */
	function getOneTypeFileList()
	{
		$data=$this->input->post("data");
		if(is_array($data))
		{
			$fileType="";
			switch($data["keyWord"]["type"])
				{
					case"4":$fileType="Swf";  break;
					case"1":$fileType="Video"; break;
					case"6":$fileType="Txt";break;
					case"3":$fileType="Img";break;
					case"2":$fileType="Audio";break;
					case"5":$fileType="Url";break;
				}
			$result=$this->getOneTypeFileList_data($data);
			$info=array();
			$info['pageCount']=$result["pageCount"];
			$info['fileInfo']=array();
			foreach($result["arr_result"] as $k=>$v)
			{	
				
				$info['fileInfo'][] = array(
				"fileID"=>$v["PlayFileID"],
				   "fileName"=>$v["FileName"],
				   "fileMD5"=>$v["CheckSum"],
				   "fileType"=>$fileType,
					"fileViewPath"=>$v["FileViewURL"],
					"filePath"=>$this->m_fm->delFtpInfo($v["URL"]),
				   "fileSize"=>$v["FileSize"],
				   "lastUpdateTime"=>$v["ModifyDate"],
				   "playTime"=>$v["Extend3"]
					);
			}
			
			if(count($info['fileInfo']))
			{
				echo json_encode(array("state"=>"true","data"=>$info));
			}
			else
			{
				echo json_encode(array("state"=>"false","data"=>""));
			}
		}			
	}
	
	function getOneTypeFileList_data($data)
	{
			$keyWord=$data["keyWord"];
			$user=$this->userEntity->userName;
			$up_user=$this->userEntity->userID;
			$dept=$this->userEntity->userGroupID;
			$file_comm=$keyWord["my_comm"];
			$count=0;
			
			$pageSize=$data["pageSize"];
			$page=($data["curent"]*1-1)*$data["pageSize"];
			$FileType=$keyWord["type"];
			$arr_result=$this->m_fm->getFileList($up_user,$file_comm,$page,$pageSize,$dept,$FileType,$count);
			$pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
			$info=array();
			$info['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
			$info['arr_result']=$arr_result["data"];

			return $info;
			
	}
	
	/**
	 * 
	 * 加载用户组文件列表，并分类
	 * 
	 * @author    BB
	 * @name      getFileListToProfileCreate
	 * @return    直接输出jQuery
	 * @internal  kycool add note
	 * @copyright 2013.2.27
	 */
	function getFileListToProfileCreate()
	{
	
		$data=array();
		$data["pageSize"]=20;
		$data["curent"]=1;
		$data["keyWord"]=array("my_comm"=>"0","type"=>"0");
		
		$fileListInfo=array();
		
		for($i=1,$n=6; $i<=$n; $i++)
		{
			$data["keyWord"]["type"]=$i;
			$result=$this->getOneTypeFileList_data($data);
			$fileListArray=array();
			$fileType="";
			$typeTitle="";
			
			foreach($result["arr_result"] as $k=>$v)
			{
				switch($v["FileType"])
				{
					case"4":$fileType="Swf"; $typeTitle=$this->m_ft->getFileTypeTitleById(4); break;
					case"1":$fileType="Video"; $typeTitle=$this->m_ft->getFileTypeTitleById(1); break;
					case"6":$fileType="Txt"; $typeTitle=$this->m_ft->getFileTypeTitleById(6); break;
					case"3":$fileType="Img"; $typeTitle=$this->m_ft->getFileTypeTitleById(3); break;
					case"2":$fileType="Audio"; $typeTitle=$this->m_ft->getFileTypeTitleById(2); break;
					case"5":$fileType="Url"; $typeTitle=$this->m_ft->getFileTypeTitleById(5); break;
				}
				$fileListArray[] = array(
										"fileID"=>$v["PlayFileID"],
									   "fileName"=>$v["FileName"],
									   "fileMD5"=>$v["CheckSum"],
									   "fileType"=>$fileType,
										"fileViewPath"=>$v["FileViewURL"],
										"filePath"=>$this->m_fm->delFtpInfo($v["URL"]),
									   "fileSize"=>$v["FileSize"],
									   "lastUpdateTime"=>$v["ModifyDate"],
									   "playTime"=>$v["Extend3"]
										);
			}
			if(count($fileListArray))
			{
				$fileListInfo[$i]["typeKey"]=$i;
				$fileListInfo[$i]["type"]=$fileType;
				$fileListInfo[$i]["title"]=$typeTitle;
				$fileListInfo[$i]["list"]=$fileListArray;
				$fileListInfo[$i]['pageCount']=$result["pageCount"];
			}
		}
		$fileTypeList=$this->m_ft->getFileTypeKeyTitle();
		for( $i =0, $n=count($fileTypeList); $i<$n; $i++)
		{
			if($fileTypeList[$i]["key"]=="7")
			{
				unset($fileTypeList[$i]);
			}
		}
		if(count($fileListInfo))
		{
			echo json_encode(array("state"=>"true","data"=>array("fileListInfo"=>$fileListInfo,"fileType"=>$fileTypeList)));
		}
		else
		{
			echo json_encode(array("state"=>"false","data"=>""));
		}
	}
	
	function updateFileInfo(){
		$f_info=$this->input->post("data");
		$state=false;
		$message="您的文件数据不完整!";
		if(is_array($f_info))
		{
			
			$message=array();
			
			for($i=0,$n=count($f_info); $i<$n; $i++){
				$info=array();
				$info["isCommon"]=$f_info[$i]["fileSharing"];
				$info["fileNotes"]=$f_info[$i]["fileOtherInfo"];
				$info["fileId"]=$f_info[$i]["fileId"];
				$info["fileName"]=$f_info[$i]["fileName"];
				$state=$this->m_fm->updateFileInfo($info);
				//保存失败则删除文件
				if(!$state)
				{
					$message[$i]["state"]=false;
					$state=false;
				}
				else
				{
					$state=true;
					$message[$i]["state"]=true;
				}
				$message[$i]["fileName"]=$info["fileName"];
			}
		}
		echo json_encode(array("state"=>$state,"data"=>$message));
	}
	
	/**
	 * 
	 * 检测文件名称是否存在
	 * 
	 * @author		BB
	 * @name		checkFileName
	 * @return		JSON ouput
	 * @internal	kycool add note
	 * @copyright	2013.2.27		  
	 */
	function checkFileName()
	{
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
		$data=$this->input->post("data");
		$fname=$data["fileName"];//iconv("GBK","utf-8",$data["fileName"]);
		$state=false;
		$info = $this->db->query("SELECT FileName FROM `play_file_property` where FileName in (".$fname.")")->result_array();
		//echo count($info ).is_file($d_path.$data["fileName"]);
		if(count($info )||is_file($d_path.$data["fileName"])){
		
			$state=true;
		}
		else
		{ $state=false;}
		echo json_encode(array("state"=>$state,"data"=>$info));
	}
}
?>
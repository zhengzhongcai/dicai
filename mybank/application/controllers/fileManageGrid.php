<?php
class FileManageGrid extends CI_Controller {
    public function __construct() {
        parent::__construct();	
		$this->load->model('m_fileManagegrid','FMGrid');
		$this->load->model('m_userManage','m_um');
		$this->load->model('m_userEntity','userEntity');
	}

	function index()
	{
		// $arg=json_decode($arg,true);
		//print_r($arg);
		//exit(0);
		// if($arg)
		// {
			
			$user=$this->userEntity->userName;
			$up_user=$this->userEntity->userID;
			$dept=$this->userEntity->userGroupID;
			$file_comm=0;
			
			$pageSize=$this->input->post("rows");
			$page=$pageSize*($this->input->post("page")-1);
			$res=$this->FMGrid->getFileList($up_user,$file_comm,$page,$pageSize,$dept);
			$rs["rows"]=$res["data"];
			$rs["total"]=$res["totalRows"];
			// $this->load->view('fileManageGrid',$rs);
			echo json_encode($rs);
		// }
					
	}

	function getOneType()
	{
		//$arg=json_decode($arg,true);
		//print_r($arg);
		//exit(0);
		
		$page=$this->input->post("page");
		$rows=$this->input->post("rows");
		$type=$this->input->post("type");
		//if(is_array($arg))
		//{
			//@session_start();
			$user=$this->userEntity->userName;
			$up_user=$this->userEntity->userID;
			$dept=$this->userEntity->userGroupID;
			$file_comm=0;//$arg["my_comm"];
			$count=0;//$arg["pageCount"];
			$pageSize=$rows;
			$page=((int)$page-1)*$rows;
			$FileType=$type;
			$res=$this->FMGrid->getFileList($up_user,$file_comm,$page,$pageSize,$dept,$FileType,$count);

			//$rs["res"]=$res;
			//$rs["pageSize"]=$pageSize;
			//$this->load->view('fileManageGrid',$rs);
        foreach($res["data"] as $k=>$v){
            unset($res["data"][$k]["URL"]);
        }
			$result=array("total"=>$res["totalRows"],"rows"=>$res["data"]);
			echo json_encode($result);
		//}
					
	}

	function selectFilelist()
	{
	   		@session_start();
			$user=$this->userEntity->userName;
			$up_user=$this->userEntity->userID;
			$file_comm=0;
			$count=0;
			$FileType="";
			$filename=$_POST["fileName"]; 
			$sfilesize=$_POST["sfilesize"];
			$efilesize=$_POST["efilesize"];
			$filenotes=$_POST["filenotes"];
			$dept=$_SESSION["Dept"];
			$pageSize=$_POST["rows"];
			$page=$pageSize*((int)$_POST["page"]-1);
			$res=$this->FMGrid->selectFilelist($up_user,$file_comm,$page,$pageSize,$dept,$FileType,$count,$filename,$sfilesize,$efilesize,$filenotes);
        foreach($res["data"] as $k=>$v){
            unset($res["data"][$k]["URL"]);
        }
			$rs["rows"]=$res["data"];
			$rs["total"]=$res["total"];
			
			echo json_encode($rs);
	}
	
	
	function getAllSouce()
	{
		$sql="SELECT `PlayFileID`, `URL`, `FileSize`, `ModifyDate`, `CheckSum`, `FileType`, `FileName`, `FileViewURL`, `UploadUser`, `UploadDate`, `Auditor`, `AuditDate`, `AuditState`, `IsCommon`, `FileNotes`, `FileTreeMenu`, `Extend1`, `Extend2`, `Extend3` FROM play_file_property";
		$rs=$this->db->query($sql)->result_array();
		foreach($rs as  $k=>$v) 
		{ //".$v["PlayFileID"]."
			echo "\$sql[]=\"INSERT INTO `play_file_property` VALUES (NULL,'".$v["URL"]."',".$v["FileSize"].",'".$v["ModifyDate"]."','".$v["CheckSum"]."',".$v["FileType"].",'".$v["FileName"]."','".$v["FileViewURL"]."',".$v["UploadUser"].",'".$v["UploadDate"]."',".$v["Auditor"].",'".$v["AuditDate"]."',".$v["AuditState"].",'".$v["IsCommon"]."','".$v["FileNotes"]."','".$v["FileTreeMenu"]."','".$v["Extend1"]."',".$v["Extend2"].",".$v["Extend3"].")\";<br>";		
		}
	}
}
?>
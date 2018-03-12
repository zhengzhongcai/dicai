<?php
class FileManage extends CI_Controller {
    public function __construct() {
        parent::__construct();	
		$this->load->model("m_fileManage","Manage");
		$this->load->model('m_userEntity','userEntity');
		$this->load->helper('file');
	}

	function fileManageUINew()
	{
		 
		$data["Uid"] = $this->userEntity->userID;
		$this->load->view("fileManageNew",$data);	
	}

	function txtView()
	{    
		$path=$_GET['url'];
		if(PHP_OS=="WINNT")
		{
			header('Content-Type:text/html;charset=utf-8');
			//$txt=file_get_contents(getcwd()."\\Material\\".$path);
			$txt=read_file("./Material/".iconv("utf-8","gb2312",$path));
			//$txt=read_file("./Material/测试.txt");
			$txt= @iconv("gb2312","UTF-8",$txt);
			echo $txt;
		}
		else
		{
			$txt=file_get_contents(getcwd()."/Material/".$path);
			$txt= @iconv("GBK","UTF-8",$txt);
			header('Content-Type:text/html;charset=utf-8');
			echo $txt;
		}
		
	}
	
	
	function deleteFile()
	{  
       $fileid=$_GET['id'];
		echo $this->Manage->deleteFile($fileid);
	}

	/**
	 *对资源通过审核
	 *@param String $fileid 审核文件的PlayFileID组成的字符串
	 *@return void
	 *@author kycool
	 *@copyright 2013-4-22
	 */
	function verifyFile()
	{
		$fileid=$_GET['id'];
		echo $this->Manage->verifyFile($fileid,1);
	}
	function verifyBackFile()
	{
		$fileid=$_GET['id'];
		echo $this->Manage->verifyFile($fileid,0);
	}
	function commonFile()
	{  
        $fileid=$_GET['id'];
		echo $this->Manage->commonFile($fileid,2);
	}
	function privateFile()
	{
		$fileid=$_GET['id'];
		echo $this->Manage->privateFile($fileid,0);
	}
	function groupFile($fileid)
	{
		echo $this->Manage->commonFile($fileid,1);
	}
	function getUploadUser(){
                $UserID=$_POST['value'];
		        $this->db->where("UserID",$UserID);
				$this->db->select('UserName');
				$query=$this->db->get("user");
				$UserName=$query->result_array();
			
				echo $UserName[0]['UserName'];
	}
	
	function shenheFile($arg)
	{
		echo $arg;
		
		$a=json_decode($arg,true);
		//$fileState=$this->Manage->checkedFileState($fileId);
		$state=$this->Manage->shenheFile($fileId,$state,$info);
		if($state)
		{
			echo 1;
			exit(0);
		}
		else{	
				echo 0;
				exit(0);
			}
	}
	
	function tbFile()
	{
		
		$info["ftpIP"]="";
		$info["ftpName"]="";
		$this->getFtpInfo($info);
		
		//$this->load->library('ftp');
//		$config['hostname'] = 'ftp.example.com';
//		$config['username'] = 'your-username';
//		$config['password'] = 'your-password';
//		$config['debug'] = TRUE;
//		
//		$this->ftp->connect($config);
//		
//		$this->ftp->upload('/local/path/to/myfile.html', '/public_html/myfile.html', 'ascii', 0775);
//		
//		$this->ftp->close(); 
		
	}
	
	
	
	function getFtpInfo($info)
	{
		$info=array("HostIP"=>$info["ftpIP"],"Extend1"=>$info["ftpName"]);
		$this->db->select("*");
		$this->db->where($info);
		$info=$this->db->get("ftp_info")->result_array();
		//echo Information("--------------",$info);
	}
	
	function getAllFtp()
	{
		$this->db->select("*");
		$this->db->where(array("UserID"=>0));
		$info=$this->db->get("ftp_info")->result_array();
		$ftps=array();
		//$ftpStr="";
		foreach($info as $v)
		{
			$ftps[]=array("ip"=>$v["HostIP"],"nm"=>$v["Extend1"]);
			
		}
		//echo Information("--------------",$ftps);
		echo json_encode($ftps);
	}
}
?>
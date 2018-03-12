<?php
class M_userEntity extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->load->model('m_ftpserver','m_ftp');
		$this->init();
	}

	public $userName="";
	public $userID="";
	public $userRoleID="";
	public $userPassword="";
	public $userGroupID="";
	public $userFTPID="";
	public $userAddress="";
	public $userPhone="";
	public $userRemarks="";
	public $userExtend1="";
	public $userExtend2="";
	public $userPermission="";
	public $Km="";
	public $opuser="";

	function init(){
		//if(!isset($_SESSION["UserName"]))
		//{
		//	@session_start();
			/*if(!isset($_SESSION["UserName"])){
				//echo $_SESSION["UserName"];
				//showInfo(false,"","您的登录已过期!");
				return false;
			}*/
		//}
		/*$this->userName=$_SESSION["UserName"];
		$this->userID=$_SESSION["UserID"];
		$this->userRoleID=$_SESSION["RoleID"];
		$this->userPassword=$_SESSION["Password"];
		$this->userGroupID=$_SESSION["UGroupID"];
		$this->userFTPID=$_SESSION["FTPID"];
		$this->userAddress=$_SESSION["Address"];
		$this->userPhone=$_SESSION["Phone"];
		$this->userRemarks=$_SESSION["Remarks"];
		$this->userExtend1=$_SESSION["Extend1"];
		$this->userExtend2=$_SESSION["Extend2"];
		$this->userPermission=$_SESSION["Permission"];
		$this->Km=$_SESSION["Km"];*/
		$this->userName='sa';
		$this->userID='1';
		$this->userRoleID='1';
		$this->userPassword='1234';
		$this->userGroupID='1';
		$this->userFTPID='1';
		$this->userAddress='';
		$this->userPhone='';
		$this->userRemarks='';
		$this->userExtend1='';
		$this->userExtend2='';
		$this->Km="1";
		$this->opuser="sa";
		$this->userPermission=[];
		//$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$this->userFTPID));
		
		//$this->userFTPIP=$ftpInfo[0]["ftpIP"];
	}
}
?>
<?php
class M_config extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	function getProfile(){	
		$query=$this->db->get('profile');
		$i=0;
		$profile=array();
		foreach($query->result() as $row){
			$profile[$i]['profileID']=$row->ProfileID;
			$profile[$i]['profileName']=$row->ProfileName;	
			$profile[$i]['profileType']=$row->ProfileType;
			$i++;
		}
		return $profile;		
	}
	function getOptions(){
		$optionsInfo=array();
		$query=$this->db->get('ams_options');
		if($query->num_rows>0){		
			foreach($query->result() as $row){
				//获得播放计划名称
				if($row->OptionName=="SCROLL_FOLLOWED_VIDEO"){
					$optionsInfo['isFollow']=$row->IsChecked;	
				}
				if($row->OptionName=="DEFAULT_PROFILE")
				{
					$optionsInfo['isDefault']=$row->IsChecked;
					$optionsInfo['profileID']=$row->OptionPara1;
					$optionsInfo['profileName']=$row->OptionPara5;
				}
				if($row->OptionName=="Touch_Jump_Setting")
				{
					$optionsInfo['isJump']=$row->IsChecked;
					$optionsInfo['jumpTime']=$row->OptionPara1;
					$optionsInfo['jumpUrl']=$row->OptionPara7;	
				}
				/*$optionsInfo[$i]['optionName']=$row->OptionName;
				$optionsInfo[$i]['optionValue']=$row->OptionPara1;
				$optionsInfo[$i]['optionJumpUrl']=$row->OptionPara7;*/		
			}//循环结束
			
		}
		return $optionsInfo;		
	}
	function saveOptions($isFollow='',$jumpStr='',$defaultStr=''){
		if($isFollow!=''){
			$followData=array(
						'IsChecked'=>$isFollow,
							  );
			$this->db->where('OptionName','SCROLL_FOLLOWED_VIDEO');
			$this->db->update('ams_options', $followData);
		}
		if($defaultStr!=''){
			$defaultArr=explode(',',$defaultStr);
			$defaultData=array(
						'IsChecked'=>$defaultArr[0],//'isDefault'
						'OptionPara1'=>$defaultArr[1],//'profileID'
						'OptionPara5'=>$defaultArr[2]//'profileName'
							);
			$this->db->where('OptionName','DEFAULT_PROFILE');
			$this->db->update('ams_options', $defaultData);
		}
		if($jumpStr!=''){
			$jumpArr=explode(',',$jumpStr);
			$jumpData=array(
						'IsChecked'=>$jumpArr[0],//isJump
						'OptionPara1'=>$jumpArr[1],//'jumpTime'
						'OptionPara7'=>$jumpArr[2]//'jumpUrl'
						);
			$this->db->where('OptionName','Touch_Jump_Setting');
			$this->db->update('ams_options', $jumpData);
		}
	}
	function saveFtp($ftpStr=''){
		if($ftpStr!=''){
			$ftpArr=explode(",",$ftpStr);
			$ftpData=array(
						'HostIP'=>$ftpArr[0],
						'UserName'=>$ftpArr[2],
						'Password'=>$ftpArr[3],
						'Extend3'=>$ftpArr[1],
			            'Extend1'=>$ftpArr[4],
						'Extend2'=>$ftpArr[5],//最大下载数
						'Extend5'=>$ftpArr[6]==""?10:$ftpArr[6],//同步间隔时间
						'PrimaryFTP'=>1
						);
			$sql="select HostIP from ftp_info where HostIP='$ftpArr[0]'";	
			$query=$this->db->query($sql);
			if($query->num_rows>0){//存在即修改
				$this->db->where('HostIP',$ftpArr[0]);
				$this->db->update('ftp_info', $ftpData);
			}else{
				$this->db->insert('ftp_info', $ftpData);	
			}
		}
	}
	function getDefaultFtp($ip=''){
		$deaultFTP=array();
		$this->db->select('HostIP','UserName','Password');
		$query = $this->db->get_where('mytable', array('HostIP' => $ip));
		//$query = $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
		if($query->num_rows>0){
			foreach ($query->result() as $row)
				{
					$deaultFTP['UserName']=$row->UserName;
					$deaultFTP['Password']=$row->Password;
				}	
		}
		return $defaultFTP;
	}
	//获取所有的ftp
	function getFtpList(){
		$deaultFTP=array();
		$sql = "SELECT HostIP,UserName,Password,Extend1,Extend3,Extend2,Extend4,Extend5 FROM `ftp_info` where UserID=0";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
    //获取当前用户默认ftp
	function getUserDefaultFtp($ftpId=""){
		if($ftpId=="")
		{
			$this->load->model('m_userEntity','userEntity');
			$ftpId=$this->userEntity->userFTPID;
		}
		
		$deaultFTP=array();
		$sql = "SELECT HostIP FROM `ftp_info` where FTPID=".$ftpId;
		$query = $this->db->query($sql);
		$DefaultHostIP = '';
	    if($query->num_rows>0){
			foreach ($query->result() as $row)
				{
					$DefaultHostIP = $row->HostIP;
				}	
			$sql1 = "SELECT Extend4 FROM `ftp_info` where UserID=0 and HostIP = '".$DefaultHostIP."' ";
			$query1 = $this->db->query($sql1);
			 if($query1->num_rows>0){
			    foreach ($query1->result() as $row1)
				{
					$DefaultHostIP = $row1->Extend4;
				}	
			}
		}
		
		return $DefaultHostIP;
	}
	//删除ftp
	function DeleteFtp($Ftp_ip='')
	{
	    $sql1 = "SELECT Extend4 FROM `ftp_info` where UserID=0 and HostIP = '".$Ftp_ip."' ";
		$query1 = $this->db->query($sql1);
		$ftpid = '';
		if($query1->num_rows>0){
			foreach ($query1->result() as $row1)
			{
				$ftpid = $row1->Extend4;
			}
			$selsql = "select * from play_file_property where Extend1  = '".$ftpid."' ";
			$query = $this->db->query($selsql);
			if($query->num_rows>0){
				echo '1';
			}else {
			  $sql = "delete FROM `ftp_info` where HostIP = '".$Ftp_ip."' ";
			  $this->db->query($sql);
			}	
		}
		
	}
	
	
	function getFtpInfo($Ftp_ip='')
	{
		$sql = "SELECT HostIP,UserName,Password,Extend1,Extend3,Extend2,Extend5 FROM ftp_info where HostIP = '".$Ftp_ip."'";
	    $query = $this->db->query($sql);
	    $ftpInfo = "";
	    if($query->num_rows>0){
			 $row = $query->result();
					$ftpInfo .=$row[0]->HostIP.",";
					$ftpInfo .=$row[0]->UserName.",";
					$ftpInfo .=$row[0]->Password.",";
					$ftpInfo .=$row[0]->Extend1.",";
					$ftpInfo .=$row[0]->Extend3.",";
					$ftpInfo .=$row[0]->Extend2.",";
					$ftpInfo .=$row[0]->Extend5;
					
				
		}
		return $ftpInfo;
	}
	//设置用户默认FTP
    function SetUserDefaultFtp($ftpStr='',$uid)
	{
		
		$sql = "SELECT HostIP,UserName,Password,Extend1,Extend3 FROM ftp_info where HostIP = '".$ftpStr."' and UserID =".$uid;
	    $query = $this->db->query($sql);
	    $ftpInfo = "";
	    if($query->num_rows>0){
			
		}
		else {
			$this->db->query("delete from ftp_info where UserID =".$uid);
			$query = $this->db->query("select HostIP,UserName,Password,Extend1,Extend3,Extend2,Extend5 from ftp_info where HostIP ='".$ftpStr."'");
			$row = '';
			if($query->num_rows>0){
				 $row = $query->result();
			}
			if($row!=''){
				//$ftpArr=explode(",",$ftpStr);
				$ftpData=array(
							'HostIP'=>$row[0]->HostIP,
							'UserName'=>$row[0]->UserName,
							'Password'=>$row[0]->Password,
							'UserID'=>$uid,
							'Extend1'=>$row[0]->Extend1,
							'Extend3'=>$row[0]->Extend3,
							'Extend2'=>$row[0]->Extend2,
							'Extend5'=>$row[0]->Extend5,
							'PrimaryFTP'=>1
							);
					$this->db->insert('ftp_info', $ftpData);	
			}
		}
		
	}
     //判断FTP是否存在
    function IsNullFTP($ftpStr='')
	{
	    $sql = "SELECT HostIP,UserName,Password,Extend1,Extend3 FROM ftp_info where HostIP = '".$ftpStr."'";
	    $query = $this->db->query($sql);
	    $ftpInfo = "0";
	    if($query->num_rows>0){
			$ftpInfo = "1";
		}
		return $ftpInfo;
	}
}
?>
<?php
class M_clientext extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model('m_userEntity','userEntity');
	}
	function getGroup($clientNode){
		$parentClientNode=substr($clientNode,0,strlen($clientNode)-4);
		$this->db->select("Name");
		$this->db->where('TreeNodeCode',$parentClientNode);
		$query=$this->db->get("client_tree");
		$groupName="root";
		foreach($query->result() as $row){
			$groupName=$row->Name;
			break;
		}
		return $groupName;
	}
	function allClientTree($item=''){
		
		$ClientTree=array();
		$i=0;
		if($item==''){
			$item='0001';
			$ClientTree[$i]['TreeNum']="1";
			$ClientTree[$i]['TreeName']="Root";
			$ClientTree[$i]['TreeNodeCode']="0001";
			//$ClientTree[$i]['TreeIsClient']="0";
			$ClientTree[$i]['child']=$this->allClientTree($item);
		}
		else
		{
			$len=(strlen($item)+4);
			$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
			client_tree ";
			$sql.= "where IsClient=0 and  length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by TreeNodeSerialID";
			//echo $sql;
			$query=$this->db->query($sql);
			if($query->num_rows>0){
				foreach($query->result() as $row){
					$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
					$ClientTree[$i]['TreeName']=$row->Name;
					//$ClientTree[$i]['TreeName']=str_encode('formDb',$row->Name);
					$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
					//$ClientTree[$i]['TreeIsClient']=$row->IsClient;
					if($row->IsClient==0){
						$ClientTree[$i]['child']=$this->allClientTree($row->TreeNodeCode);
					}
					$i++;
				}
			}

		}
		return $ClientTree;
	}
	function getUsersTree()
	{
		@session_start();
		$clientInfo=array();
		$sql="SELECT TreeNodeSerialID, TreeNodeCode,Name from client_tree where TreeNodeSerialID in (select CGroupID from user_cgroup where UserID=".$this->userEntity->userID.") order by TreeNodeSerialID asc";
		$query=$this->db->query($sql);
		if($query->num_rows>0)
		{
			$i=0;
			foreach($query->result() as $row)
			{
				$clientInfo[$i]['TreeName']=$row->Name;
				$clientInfo[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$clientInfo[$i]['TreeNum']=$row->TreeNodeSerialID;
			//	$clientInfo[$i]=$row->TreeNodeCode;
				$i++;
			}
		}
		//sort($clientInfo);
		return $clientInfo;
	}
	function getUserAllTreeInfo()
	{
		$user_tree=array();
		$rs=$this->getUsersTree();
		if($rs[0]['TreeNodeCode']=="0001")
		{
			$user_tree[0]=$rs[0];
			$user_tree[0]["child"]=$this->allClientTree($rs[0]['TreeNodeCode']);
		}
		else
		{
			$user_tree=$rs;
			for($i=0,$n=count($rs); $i<$n; $i++)
			{
				$user_tree[$i]["child"]=$this->allClientTree($rs[$i]['TreeNodeCode']);
			}
		}
		return $user_tree;
	}
//一对一分组
	function b_getClientInfo($clientID=''){
		$clientInfo=array();
		$sql="select    a.TreeNodeSerialID,b.TreeNodeCode,MacAddress,WeekPlaylistID,Volume,ShutOnTime,ShutOffTime,NetTypeCode,ScreenResolution,ScreenRotation,ClientModel,
		Name,TreeNodeCode,a.Extend1 from client_info as a 		
		left join client_tree as b on a.TreeNodeSerialID=b.TreeNodeSerialID";
		if($clientID!=''){
			$sql.=' where a.TreeNodeSerialID='.$clientID;	
		}
		$query=$this->db->query($sql);
		if($query->num_rows>0){		
			$i=0;
			foreach($query->result() as $row){
				//获得播放列表名称
				$WeekId=$row->WeekPlaylistID;
				$WeekName='null';
				if($WeekId!=''){			
					$sql="select WeekPlayListName as palyName from week_playlist where WeekPlayListID=".$WeekId;
					
					$query=$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						 $Weekrow= $query->row_array();
						 $WeekName=$Weekrow['palyName'];					 
					}				
					}else{
					 	$WeekName='null';
					}
				//获得ip地址
				$treeId=$row->TreeNodeSerialID;
				if($treeId!=''){			
					$sql="select IP from lan_conf where TreeNodeSerialID=".$treeId;
					$query=$this->db->query($sql);
					if ($query->num_rows() > 0)
					{

						 $IProw = $query->row_array();
						 $IP=$IProw['IP'];					 
					}				
				}
				//获得终端类型
				$clientModel=$row->ClientModel;
				if(isset($clientModel)){
					switch($clientModel){
						  case '0':
							  $clientType='X86';
							  break;
						  case '1':
						  	  $clientType='em8621';
							  break;
						  case '2':
							  	$clientType='Sigma';
						  	  break;
						  case '3':
						  	  $clientType='LED';
							  break;
						  case '4':
						  	  $clientType='LED 2008';
							  break;
						  case '6':
						  	  $clientType='Windows X86';
							  break;
					      case '7':
						  	  $clientType='Ubuntu X86';
							  break;
						   case '5':
						  	  $clientType='Android';
							  break;
						  default:
						  	  $clientType=$clientModel;
						 	  break;						
					}			
				}
				//print_r($row);

				$clientInfo[$i]['clientNum']=$row->TreeNodeSerialID;
				$clientInfo[$i]['clientNodeCode']=$row->TreeNodeCode;
				$clientInfo[$i]['clientGroupName']=$this->getGroup($row->TreeNodeCode);//分组
				$clientInfo[$i]['clientName']=$row->Name;
				$clientInfo[$i]['clientProfile']=$WeekName;
				$clientInfo[$i]['clientVolume']=$row->Volume;
				$clientInfo[$i]['clientShutOnTime']=$row->ShutOnTime;
				$clientInfo[$i]['clientShutOffTime']=$row->ShutOffTime;
				$clientInfo[$i]['clientScreenResolution']=$row->ScreenResolution;
				$clientInfo[$i]['clientScreenRotation']=$row->ScreenRotation;
				$clientInfo[$i]['clientType']=$clientType;
				$clientInfo[$i]['clientMac']=$row->MacAddress;
				$clientInfo[$i]['clientIP']= ($IP=='')?'0.0.0.0':$IP;
				$clientInfo[$i]['clientStatus']= '';
				$clientInfo[$i]['clientFTP']= $row->Extend1;
			}//循环结束
			
		}
		/*echo '<pre>';	
		print_r($clientInfo);
		echo '</pre>';*/
		return $clientInfo;		
	}
		/*
		终端控制界面终端信息获取 2010年11月3日13:28:15 启用
		解决一对多分组
		莫波
		2010-11-4 13:28:38
	*/
	function getClientInfo($clientID=''){
	    header ("Content-Type:text/html; charset=utf-8");
		$clientInfo=array();
		@session_start();			
			
		$sql="SELECT TreeNodeCode from client_tree where TreeNodeSerialID in (select CGroupID from `user_cgroup` where UserID=".$this->userEntity->userID.")";
		$query=$this->db->query($sql);
		
		$code="";
		if($query->num_rows>0)
		{
			
			foreach($query->result() as $row)
			{
				//超级用户sa
				if($this->userEntity->userID=="1")
				{  
					$code.="TreeNodeCode like '".$row->TreeNodeCode."%' or ";
				}
				else
				{
					//if($row->TreeNodeCode!="0001")
					//{
						$code.="TreeNodeCode like '".$row->TreeNodeCode."%' or ";
					//}
				}
				
			}
			$code=substr($code,0,strlen($code)-3);
			if(strlen($code)==0)
			{
				echo "对不起,您没有被分配任何的终端组!";
				exit();
			}
		}
		else
		{
				echo "对不起,您没有被分配任何的终端组!";
				exit();
		}
		
		$sql="SELECT TreeNodeSerialID,Name,TreeNodeCode ,Extend4 as Extend4_A,(select TreeNodeSerialID from client_tree where TreeNodeCode=Extend4_A) as old_TreeNodeSerialID FROM `client_tree` WHERE IsClient=1 and ".$code;

		
		$query=$this->db->query($sql);
		if($query->num_rows>0)
		{
			$clientArray=$query->result();
		}
		else
		{
				echo "对不起,您的服务器当前没有任何终端连接!";
				exit();
		}
		
		$sql="select RegCode,TreeNodeSerialID,MacAddress,WeekPlaylistID,EnableBgTemplate,Volume,ShutOnTime,ShutOffTime,ShutOnTime2,ShutOffTime2,ShutOnTime3,ShutOffTime3,DownLoadTime,NetTypeCode,FileSaveDirectory,DiskSize,DiskFreeSize,VMSVersion,URL,ScreenResolution,ResolutionList,ScreenRotation,ClientModel,Extend1,Extend2,Extend3,Extend4,Extend5,Extend6,Extend7,ClientAddress,UserID,DisPlaySize,Remark from `client_info`";
		$query=$this->db->query($sql);
		if($query->num_rows>0)
		{
			$client_info=$query->result();
		}
		else
		{
				echo "对不起,您的服务器当前没有任何终端连接!";
				exit();
		}
		$clientInfo=array();
		$clientInfo_=array();
		
		foreach($clientArray as $c)
		{
			foreach($client_info as $i)
			{
				//echo $c->old_TreeNodeSerialID."-------".$i->TreeNodeSerialID."<br>";
				if($c->old_TreeNodeSerialID=="")
				{
					if($c->TreeNodeSerialID==$i->TreeNodeSerialID)
					{
						$c_info["TreeNodeInfoId"]=$i->TreeNodeSerialID;
						$c_info["RegCode"]=$i->RegCode;
						$c_info["MacAddress"]=$i->MacAddress;
						$c_info["WeekPlaylistID"]=$i->WeekPlaylistID;
						$c_info["EnableBgTemplate"]=$i->EnableBgTemplate;
						$c_info["Volume"]=$i->Volume;
						$c_info["ShutOnTime"]=$i->ShutOnTime;
						$c_info["ShutOffTime"]=$i->ShutOffTime;
						$c_info["ShutOnTime2"]=$i->ShutOnTime2;
						$c_info["ShutOffTime2"]=$i->ShutOffTime2;
						$c_info["ShutOnTime3"]=$i->ShutOnTime3;
						$c_info["ShutOffTime3"]=$i->ShutOffTime3;
						$c_info["DownLoadTime"]=$i->DownLoadTime;
						$c_info["NetTypeCode"]=$i->NetTypeCode;
						$c_info["FileSaveDirectory"]=$i->FileSaveDirectory;
						$c_info["DiskSize"]=$i->DiskSize;
						$c_info["DiskFreeSize"]=$i->DiskFreeSize;
						$c_info["VMSVersion"]=$i->VMSVersion;
						$c_info["URL"]=$i->URL;
						$c_info["ScreenResolution"]=$i->ScreenResolution;
						$c_info["ResolutionList"]=$i->ResolutionList;
						$c_info["ScreenRotation"]=$i->ScreenRotation;
						$c_info["ClientModel"]=$i->ClientModel;
						$c_info["Extend1"]=$i->Extend1;
						$c_info["Extend2"]=$i->Extend2;
						$c_info["Extend3"]=$i->Extend3;
						$c_info["Extend4"]=$i->Extend4;
						$c_info["Extend5"]=$i->Extend5;
						$c_info["Extend6"]=$i->Extend6;
						$c_info["Extend7"]=$i->Extend7;
						$c_info["ClientAddress"]=$i->ClientAddress;
						$c_info["UserID"]=$i->UserID;
						$c_info["DisPlaySize"]=$i->DisPlaySize;
						$c_info["Remark"]=$i->Remark;
						$c_lient["Name"]=$c->Name;
						$c_lient["TreeNodeSerialID"]=$c->TreeNodeSerialID;
						$c_lient["TreeNodeCode"]=$c->TreeNodeCode;
						$c_lient["old_TreeNodeSerialID"]=$c->old_TreeNodeSerialID;
						$sqlplay = "select p.WeekPlaylistID,WeekPlaylistName,WeekPlaylistType  from client_playlist   as c left join week_playlist as p on p.WeekPlaylistID=c.weekPlayListID where c.clientID =".$i->TreeNodeSerialID;                        $queryplay=$this->db->query($sqlplay);
						$c_lient["playlistInfo"] = "";
		                if($queryplay->num_rows>0)
						{
							$playinfo=$queryplay->result();
							foreach($playinfo as $p)
			                {  
							   $c_lient["playlistInfo"] .= "| ".$p->WeekPlaylistName." |";
							}
						}
						$clientInfo[]=array_merge_recursive($c_lient,$c_info);
						//var_dump(array_merge_recursive($c,$i));
					}
				}
				else
				{
					if($c->old_TreeNodeSerialID==$i->TreeNodeSerialID)
					{
						$c_info["TreeNodeInfoId"]=$i->TreeNodeSerialID;
						$c_info["RegCode"]=$i->RegCode;
						$c_info["WeekPlaylistID"]=$i->WeekPlaylistID;
						$c_info["MacAddress"]=$i->MacAddress;
						$c_info["EnableBgTemplate"]=$i->EnableBgTemplate;
						$c_info["Volume"]=$i->Volume;
						$c_info["ShutOnTime"]=$i->ShutOnTime;
						$c_info["ShutOffTime"]=$i->ShutOffTime;
						$c_info["ShutOnTime2"]=$i->ShutOnTime2;
						$c_info["ShutOffTime2"]=$i->ShutOffTime2;
						$c_info["ShutOnTime3"]=$i->ShutOnTime3;
						$c_info["ShutOffTime3"]=$i->ShutOffTime3;
						$c_info["DownLoadTime"]=$i->DownLoadTime;
						$c_info["NetTypeCode"]=$i->NetTypeCode;
						$c_info["FileSaveDirectory"]=$i->FileSaveDirectory;
						$c_info["DiskSize"]=$i->DiskSize;
						$c_info["DiskFreeSize"]=$i->DiskFreeSize;
						$c_info["VMSVersion"]=$i->VMSVersion;
						$c_info["URL"]=$i->URL;
						$c_info["ScreenResolution"]=$i->ScreenResolution;
						$c_info["ResolutionList"]=$i->ResolutionList;
						$c_info["ScreenRotation"]=$i->ScreenRotation;
						$c_info["ClientModel"]=$i->ClientModel;
						$c_info["Extend1"]=$i->Extend1;
						$c_info["Extend2"]=$i->Extend2;
						$c_info["Extend3"]=$i->Extend3;
						$c_info["Extend4"]=$i->Extend4;
						$c_info["Extend5"]=$i->Extend5;
						$c_info["Extend6"]=$i->Extend6;
						$c_info["Extend7"]=$i->Extend7;
						$c_info["ClientAddress"]=$i->ClientAddress;
						$c_info["UserID"]=$i->UserID;
						$c_info["DisPlaySize"]=$i->DisPlaySize;
						$c_info["Remark"]=$i->Remark;
						$c_lient["Name"]=$c->Name;
						$c_lient["TreeNodeSerialID"]=$c->TreeNodeSerialID;
						$c_lient["TreeNodeCode"]=$c->TreeNodeCode;
						$c_lient["old_TreeNodeSerialID"]=$c->old_TreeNodeSerialID;
						$sqlplay = "select p.WeekPlaylistID,WeekPlaylistName,WeekPlaylistType  from client_playlist   as c left join week_playlist as p on p.WeekPlaylistID=c.weekPlayListID where c.clientID =".$i->TreeNodeSerialID;
						 $queryplay=$this->db->query($sqlplay);
						$c_lient["playlistInfo"] = "";
		                if($queryplay->num_rows>0)
						{
							$playinfo=$queryplay->result();
							foreach($playinfo as $p)
			                {  
							   $c_lient["playlistInfo"] .= "| ".$p->WeekPlaylistName." |";
							}
						}
						$clientInfo[]=array_merge_recursive($c_lient,$c_info);
						//var_dump(array_merge_recursive($c,$i));
					}
				}
			}
		}		
		
		if(count($clientInfo)>0){
			$i=0;
			foreach($clientInfo as $row){
				//获得播放计划名称
				$WeekId=$row["WeekPlaylistID"];
				$WeekName='null';
				if($WeekId!=''){
					$sql="select WeekPlayListName as palyName from week_playlist where WeekPlayListID=".$WeekId;

					$query=$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						 $Weekrow= $query->row_array();
						 $WeekName=$Weekrow['palyName'];
					}
					}else{
					 	$WeekName='null';
					}
				//获得ip地址
				$treeId=$row["TreeNodeInfoId"];
				$IP="";
				if($treeId!=''){
					$sql="select IP from lan_conf where TreeNodeSerialID=".$treeId;
					$query=$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						 $IProw = $query->row_array();
						 $IP=$IProw['IP'];
					}
				}
				$UserName = 'null';
				if($row["UserID"]!=0)
				{
				   $sql="SELECT Name FROM `client_maintainer`  where ID=".$row["UserID"];
					$query=$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						 $UserNamerow= $query->row_array();
						 $UserName=$UserNamerow['Name'];
					}
				}
				else
				{
					$UserName='';
				}
				
				//获得终端类型
				$clientModel=$row["ClientModel"];
				if(isset($clientModel)){
					switch($clientModel){
						  case '0':
							  $clientType='Linux X86';
							  break;
						  case '1':
						  	  $clientType='em8621';
							  break;
						  case '2':
						   	 $clientType='NXP';
							  break;
						  case '3':
						  	  $clientType='LED 2005';
							  break;
						  case '4':
						  	  $clientType='LED 2008';
							  break;
						  case '6':
						  	  $clientType='Windows X86';
							  break;
						case '5':
						  	  $clientType='Android';
							  break;
						  default:
						  	  $clientType=$clientModel;
						 	  break;
					}
				}
				//print_r($row);
				
				$clientInfo_[$i]['clientNum']=$row["TreeNodeInfoId"];
				$clientInfo_[$i]['clientNodeCode']=$row["TreeNodeCode"];
				$clientInfo_[$i]['clientGroupName']=$this->getGroup($row["TreeNodeCode"]);//分组
				$clientInfo_[$i]['clientName']=$row["Name"];
				$clientInfo_[$i]['clientProfile']=$WeekName;
				$clientInfo_[$i]['clientVolume']=$row["Volume"];
				$clientInfo_[$i]['clientShutOnTime']=$row["ShutOnTime"];
				$clientInfo_[$i]['clientShutOffTime']=$row["ShutOffTime"];
				$clientInfo_[$i]['clientScreenResolution']=$row["ScreenResolution"];
				$clientInfo_[$i]['clientScreenRotation']=$row["ScreenRotation"];
				$clientInfo_[$i]['clientType']=$clientType;
				$clientInfo_[$i]['clientMac']=$row["MacAddress"];
				$clientInfo_[$i]['clientIP']= ($IP=='')?'0.0.0.0':$IP;
				$clientInfo_[$i]['clientStatus']= '';
				$clientInfo_[$i]['clientFTP']=$row["Extend1"];
				$clientInfo_[$i]['clientUserName']= $UserName;
				$clientInfo_[$i]['clientAddress']= $row["ClientAddress"];
				$clientInfo_[$i]['clientDisPlaySize']= $row["DisPlaySize"];
				$clientInfo_[$i]['clientRemark']= $row["Remark"];
				$clientInfo_[$i]['clientPlaylistInfo']= $row["playlistInfo"];
				//增加用于判断终端是否注册20160720
				$clientInfo_[$i]['clientRegCode']= $row["RegCode"];
				$i++;
			}//循环结束
		}		
		return $clientInfo_;
	}
	
	function getClientById($ids){
		$this->db->select("cl.TreeNodeSerialID AS clientID,
									cl.ClientModel AS clientType,
									cl.MacAddress AS clientMac,
									cl.WeekPlaylistID AS clientPlaylistID,
									cl.Volume AS clientVolume,
									cl.ShutOnTime AS clientShutOnTime,
									cl.ShutOffTime AS clientShutOffTime,
									cl.DownLoadTime AS clientDownloadTime,
									cl.DiskSize AS clientDiskSize,
									cl.DiskFreeSize AS clientDiskFreeSize,
									cl.VMSVersion AS clientVersion,
									cl.ScreenResolution AS clientResolution,
									cl.ResolutionList AS clientResolutionList,
									cl.ScreenRotation AS clientScreenRotation,
									cl.Extend2 AS clientShutMultiTime,
									cl.ClientAddress AS clientAddress,
									cl.UserID AS clientManagerID,
									cl.DisPlaySize AS clientScreenSize,
									cl.Remark AS clientRemark,
									cl.Screenshot AS clientScreenShot,
									cl.MachineCode AS clientMachineCode,
									cl.RegCode AS clientRegcode,
									lc.IP AS clientIP");
		$this->db->join("lan_conf as lc","lc.TreeNodeSerialID=cl.TreeNodeSerialID");
		if(is_array($ids)){
			$this->db->where_in("cl.TreeNodeSerialID",$ids);
		}
		if(is_string($ids)){
			$this->db->where("cl.TreeNodeSerialID",$ids);
		}
		return $this->db->get("client_info as cl")->result_array();
	}
}
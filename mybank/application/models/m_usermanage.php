<?php
class M_usermanage extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getUserInfoList($pageInfo){
		
		
		$sql_count="select count(*) as resultCount from `user`  order by UserID desc";
		$query=$this->db->query($sql_count)->result_array();
		
		$data=array();
		$data["total"]=$query[0]["resultCount"];
		
	
		// $sql_content="SELECT 
		// u.`UserID` as uid , 
		// u.`UserName` as name, 
		// u.Password , 
		// u.`RoleID` , 
		// u.`UGroupID` , 
		// u.`FTPID` , 
		// u.`Address`  as address, 
		// u.`Phone` , 
		// u.`Remarks` , 
		// u.`Extend1` , 
		// u.`Extend1` , 
		// g.`UGroupName` , 
		// r.`RoleName` as roleName
		// FROM `user` AS u
		// LEFT JOIN ugroup AS g ON u.UGroupID = g.UGroupID
		// LEFT JOIN role AS r ON u.RoleID = r.RoleID ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		
		$sql_content="SELECT 
								u.UserID AS uid,
								u.UserName AS name,
								u.RoleID AS roleId,
								u.UGroupID AS ugroupId,
								u.FTPID AS ftpId,
								u.Address AS address,
								u.Phone AS phone,
								u.Remarks AS remarks,
								u.Extend1,
								u.Extend2,
								g.UGroupName AS groupName,
								r.RoleName AS roleName,
								uc.TreeNodeSerialID as clientGroup 
								FROM 
								`user` AS u 
								LEFT JOIN 
								`ugroup` AS g ON u.UGroupID=g.UGroupID 
								LEFT JOIN 
								`role` AS r ON u.RoleID=r.RoleID 
								LEFT JOIN 
								`user_client` AS uc ON uc.UserID=u.UserID 
								order by u.UserID desc limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		
		$data["data"]=$this->db->query($sql_content)->result_array();
		return $data;
	}
	/*************************************************************
    |
    |	函数名: saveUserInfo
    |	功能: 存储用户基本信息到数据库
    |	返回值: 插入数据的UserID
    |	参数: $info array --> 用户信息
    |	创建时间: 2012年9月27日 11:41:53 by 莫波
    |   
    **************************************************************/
	function saveUserInfo($info){
		//"INSERT INTO `user` (`UserID`, `UserName`, `RoleID`, `Password`, `UGroupID`, `FTPID`, `Address`, `Phone`, `Remarks`, `Extend1`, `Extend2`) VALUES(1, 'sa', 1, '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, NULL, NULL, NULL, NULL, NULL)";
		
		$data=array(
			"UserName"=>$info["UserName"],
			"RoleID"=>$info["RoleID"],
			"UGroupID"=>$info["UGroupID"],
			"FTPID"=>$info["FTPID"],
			"Address"=>isset($info["Address"])?$info["Address"]:"",
			"Phone"=>isset($info["Phone"])?$info["Phone"]:"",
			"Remarks"=>isset($info["Remarks"])?$info["Remarks"]:"",
			"Extend1"=>isset($info["Extend1"])?$info["Extend1"]:"",
			"Extend2"=>isset($info["Extend2"])?$info["Extend2"]:NULL
		);
		$this->db->set("Password","password('".$info["Password"]."')",False);
		$this->db->set($data);
		$this->db->insert("user");
		return $this->db->insert_id();
	}
	/*************************************************************
    |
    |	函数名: saveEditUserInfo
    |	功能: 更新用户基本信息
    |	返回值: 
    |	参数: $info array --> 用户信息
    |	创建时间: 2012年9月27日 15:41:53 by 莫波
    |   
    **************************************************************/
	function saveEditUserInfo($info){
		//"INSERT INTO `user` (`UserID`, `UserName`, `RoleID`, `Password`, `UGroupID`, `FTPID`, `Address`, `Phone`, `Remarks`, `Extend1`, `Extend2`) VALUES(1, 'sa', 1, '81dc9bdb52d04dc20036dbd8313ed055', 1, 1, NULL, NULL, NULL, NULL, NULL)";
		$data=array(
			"UserName"=>$info["UserName"],
			"RoleID"=>$info["RoleID"],
			"UGroupID"=>$info["UGroupID"],
			"FTPID"=>$info["FTPID"],
			"Address"=>isset($info["Address"])?$info["Address"]:"",
			"Phone"=>isset($info["Phone"])?$info["Phone"]:"",
			"Remarks"=>isset($info["Remarks"])?$info["Remarks"]:"",
			"Extend1"=>isset($info["Extend1"])?$info["Extend1"]:"",
			"Extend2"=>isset($info["Extend2"])?$info["Extend2"]:NULL
		);
		//$this->db->set("Password","password('".$info["Password"]."')",False);
		//print_r($data);
		$this->db->set($data);
		$this->db->where('UserID', $info["UserID"]);
		$this->db->update("user",$data);
		//echo $this->db->last_query();
	}
	/*************************************************************
    |
    |	函数名: getUserInfo
    |	功能:   通过指定的条件 获取某一个用户的基本信息
    |	返回值:  输出 json
    |	参数:
    |	创建时间: 2012年9月27日 15:35:15 by 莫波
    |   
    **************************************************************/
	function getUserInfo($info){
		$this->db->where($info);
		$query=$this->db->get("user");
		return $query->result_array();
	}

	/*************************************************************
    |
    |	函数名: editUserClientGroup
    |	功能: 更新用户的终端组信息
    |	返回值: 
    |	参数: $info array --> 用户信息
    |	创建时间: 2012年9月28日 15:25:13 by 莫波
    |   
    **************************************************************/
	// function editUserClientGroup($id,$info){
			// //"INSERT INTO `user_cgroup` (`UserID`, `CGroupID`, `Extend1`, `Extend2`) VALUES (1, 1, NULL, NULL);";
			// $this->db->where("UserID",$id);
			// $this->db->delete("user_cgroup");
			// $data=array();
			// foreach($info as $k=>$v)
			// {
				// $data=array(
					// "UserID"=>$id,
					// "CGroupID"=>$v,
					// "Extend1"=>isset($info["Extend1"])?$info["Extend1"]:"",
					// "Extend2"=>isset($info["Extend2"])?$info["Extend2"]:NULL
				// );
				// $this->db->set($data);
				// $this->db->insert("user_cgroup",$data);
			// }
	// }
	
	/*************************************************************
    |
    |	函数名: getUserClientGroup
    |	功能:   通过指定的条件 获取某一个用户的终端组基本信息
    |	返回值:  输出 json
    |	参数:
    |	创建时间: 2012年9月27日 16:35:15 by 莫波
    |   
    **************************************************************/
	function getUserClientGroup($userID){			

		$sql="SELECT c.UserID,c.CGroupID,t.Name,t.TreeNodeCode
		FROM `user_cgroup` AS c
		LEFT JOIN client_tree AS t ON t.`TreeNodeSerialID` = c.`CGroupID`
		WHERE `UserID` =$userID
		LIMIT 0 , 30";
			
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	/*************************************************************
    |
    |	函数名: deleteClientGroup
    |	功能: 删除用户的终端组信息
    |	返回值: 
    |	参数: $userID int --> 用户id
    |	创建时间: 2012年10月11日 17:59:46 by 莫波
    |   
    **************************************************************/
	function deleteClientGroup($userID){
			//"INSERT INTO `user_cgroup` (`UserID`, `CGroupID`, `Extend1`, `Extend2`) VALUES (1, 1, NULL, NULL);";
			$data=array("UserID"=>$userID);
			$this->db->set("user_cgroup",$data);
			$this->db->where($data);
			$this->db->delete("user_cgroup");
			
	}
	/*************************************************************
    |
    |	函数名: deleteUserInfo
    |	功能:   通过ID 删除某一个用户的基本信息
    |	返回值:  bool
    |	参数:
    |	创建时间: 2012年10月11日 17:41:51 by 莫波
    |   
    **************************************************************/
	function deleteUserInfo($userID){
		$data=array("UserID"=>$userID);
		$this->db->set("user",$data);
		$this->db->where($data);
		$this->db->delete("user");
	}
	function checkUserName($name,$id){
		$this->db->select("UserName,UserID");
		$this->db->where("UserName",$name);
		$query=$this->db->get("user")->result_array();
		if(count($query)){
			if($id!="")
			{
				if($query[0]["UserID"]!=$id){
					return "used";
				}
			}
			else {
				return "used";
			}
		}
		
			return "unused";
	}
}
?>
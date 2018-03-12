<?php
class M_ftpServer extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model("m_userentity","m_uentity");
	}
	/*************************************************************
    |
    |	函数名: insertFtpInfo
    |	功能: 添加FTP服务器
    |	返回值: 输出 json
    |	参数: $info array --> 添加结果状态
    |	创建时间: 2012年9月28日 14:54:39 by 莫波
    |   
    **************************************************************/
	function insertFtpInfo()
	{
		"INSERT INTO `ams`.`new_ftp_info` (`FTPID`, `HostIP`, `Port`, `UserName`, `PassWord`, `Name`, `PrimaryFTP`, `SyncSpeed`, `SyncPeriod`, `Extend1`, `Extend2`, `Extend3`, `Extend4`) VALUES (NULL, '192.168.10.123', '21', 'ams', 'ams', 'DefauleFTP', NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
	}
	/*************************************************************
    |
    |	函数名: getFtpInfoList
    |	功能: 获取FTP列表
    |	返回值: array 查询结果
    |	参数: $info array --> 分页信息
    |	创建时间: 2012年9月28日 12:45:13 by 莫波
    |   
    **************************************************************/
    /**
     * 获取FIP列表
     *@param Array $pageInfo 分页信息
     *@return Array 查询结果
     *@author BB
     *@copyright 2012-9-28 
     */
	function getFtpInfoList($pageInfo=array("pageIndex"=>0,"pageSize"=>20))
	{
		$sql=" ORDER BY `FTPID` DESC";
		
		$sql_count="select count(*) as resultCount from `ftp_info_30` ".$sql;
		$query=$this->db->query($sql_count)->result_array();
		
		$data=array();
		$data["totalRows"]=$query[0]["resultCount"];
		
		$sql_content="select *  from `ftp_info_30` ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		$data["data"]=$this->db->query($sql_content)->result_array();
		return $data;
	}
	/*************************************************************
    |
    |	函数名: getUserFtpInfo
    |	功能:   通过指定的条件 获取某一个FTP基本信息
    |	返回值:  查询结果
    |	参数:
    |	创建时间: 2012年9月27日 18:35:15 by 莫波
    |   
    **************************************************************/
	function getUserFtpInfo($info){
		$this->db->where($info);
		$query=$this->db->get("ftp_info_30");
		$res=$query->result_array();
		$_info=array();
		foreach($res as $k=>$v)
		{
			$_info[$k]["ftpID"]=$v["FTPID"];
			$_info[$k]["ftpIP"]=$v["HostIP"];
			$_info[$k]["ftpPort"]=$v["Port"];
			$_info[$k]["ftpUserName"]=$v["UserName"];
			$_info[$k]["ftpPassword"]=$v["PassWord"];
			$_info[$k]["ftpName"]=$v["Name"];
			$_info[$k]["ftpSyncSpeed"]=$v["SyncSpeed"];
			$_info[$k]["ftpSyncPeriod"]=$v["SyncPeriod"];
			$_info[$k]["ftpExt1"]=$v["Extend1"];
			$_info[$k]["ftpExt2"]=$v["Extend2"];
			$_info[$k]["ftpExt3"]=$v["Extend3"];
			$_info[$k]["ftpExt4"]=$v["Extend4"];
		}
		return $_info;
	}
	function getFtpInfo($info){
		$this->db->where($info);
		$query=$this->db->get("ftp_info_30");
		$res=$query->result_array();
		$_info=array();
		foreach($res as $k=>$v)
		{
			$_info[$k]["ftpID"]=$v["FTPID"];
			$_info[$k]["ftpIP"]=$v["HostIP"];
			$_info[$k]["ftpPort"]=$v["Port"];
			$_info[$k]["ftpUserName"]=$v["UserName"];
			$_info[$k]["ftpPassword"]=$v["PassWord"];
			$_info[$k]["ftpName"]=$v["Name"];
			$_info[$k]["ftpSyncSpeed"]=$v["SyncSpeed"];
			$_info[$k]["ftpSyncPeriod"]=$v["SyncPeriod"];
			$_info[$k]["ftpExt1"]=$v["Extend1"];
			$_info[$k]["ftpExt2"]=$v["Extend2"];
			$_info[$k]["ftpExt3"]=$v["Extend3"];
			$_info[$k]["ftpExt4"]=$v["Extend4"];
		}
		return $_info;
	}
// function getUserFtpInfo($info=array()){
		// $uid=$this->m_uentity->userID;
		// $this->db->where(array("UserID"=>$uid,"PrimaryFTP"=>1));
		// $query=$this->db->get("ftp_info");
		// $res=$query->result_array();
		// $_info=array();
		// foreach($res as $k=>$v)
		// {
			// $_info[$k]["ftpIP"]=$v["HostIP"];
			// $_info[$k]["ftpName"]=$v["HostIP"];
			// $_info[$k]["ftpUserName"]=$v["UserName"];
			// $_info[$k]["ftpPassword"]=$v["Password"];
			// $_info[$k]["ftpPort"]=$v["Extend3"];
		// }
		// return $_info;
	// }
//---------------------------------兼容AMS2.0 开始--------------------------------------
	/*************************************************************
    |
    |	函数名: insertFtpInfoAms20
    |	功能: 添加FTP服务器 兼容AMS2.0使用
    |	返回值: 
    |	参数: $info array --> 添加结果状态
    |	创建时间: 2012年10月10日 14:27:31 by 莫波
    |   
    **************************************************************/
	function insertFtpInfoAms20($info)
	{
		//"INSERT INTO `ftp_info` (`HostIP`, `UserName`, `Password`, `UserID`, `PrimaryFTP`, `Comment`, `Extend1`, `Extend2`, `Extend3`, `Extend4`, `Extend5`) VALUES('".$this->localIp."', 'ams', 'ams', 1, 1, '', '".$this->localIp."', '12', 21, 2, 12);";
		$data=array(
			"HostIP" =>$info["hostIP"],
			"UserName" =>$info["userName"],
			"Password" =>$info["userPassword"],
			"UserID" =>$info["userID"],
			"PrimaryFTP" =>$info["primaryFtp"],
			"Comment" =>$info["comment"],
			"Extend1" =>$info["ext1"],
			"Extend2" =>$info["ext2"],
			"Extend3" =>$info["ext3"],
			"Extend4" =>null,
			"Extend5" =>$info["ext5"]
		);
		$this->db->set($data);
		$this->db->insert("ftp_info");
	}
	/*************************************************************
    |
    |	函数名: deleteFtpInfoAms20
    |	功能: 删除FTP服务器 兼容AMS2.0使用
    |	返回值: 
    |	参数: $userID int --> 用户ID
    |	创建时间: 2012年10月10日 15:32:55 by 莫波
    |   
    **************************************************************/
	function deleteFtpInfoAms20($userID)
	{
		$this->db->where(array("UserID"=>$userID,"PrimaryFTP"=>1));
		$this->db->delete("ftp_info");
	}
//---------------------------------兼容AMS2.0 结束--------------------------------------
}
?>
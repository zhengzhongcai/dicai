<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserAccessJG extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_UserAccessJG';
	}
	
	// 根据用户id获取其有权限查看的机构代号
	public function getOrgByUid($uid)
	{
		if ($uid) $this->db->where('UID', $uid);
		$this->db->select("JG_ID");
		$this->db->group_by("JG_ID");
		$this->db->from($this->_tableName);
		$query = $this->db->get();
		$ret = $query->result_array();
		
		$jgArr = array();
		foreach ($ret as $row)
		{
			$jgArr[] = "'{$row['JG_ID']}'";
		}// for
		
		return implode(',', $jgArr);
	}// func
}// class
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roleopt extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_roleOperate';
	}
	
	// 根据角色功能id找出操作数据
	public function getOptByRfid($fid)
	{
		$this->db->where('RF_ID', $fid);
		$query = $this->db->get($this->_tableName);
		$ret = $query->result_array();
		
		return $ret;
	}// func
}// class
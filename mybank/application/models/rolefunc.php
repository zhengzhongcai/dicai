<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolefunc extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_roleFunction';
	}
	
	public function getFcodeByRoleId($roleId)
	{
		$this->db->where('R_ID', $roleId);
		$query = $this->db->get($this->_tableName);
		$fcodeArr = $query->result_array();
		return $fcodeArr;
	}// func
	
	public function getFidByRoleIdAndFcode($roleId, $fcode)
	{
		$this->db->where('R_ID', $roleId);
		$this->db->where('F_code', $fcode);
		$query = $this->db->get($this->_tableName);
		$ret = $query->row_array();
		if (count($ret))
			return $ret['ID'];
		
		return '';
	}// func
}// class
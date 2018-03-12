<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adminlog extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_adminLog';
	}
	
	function add_log($userid, $opt){
		$data = array(
			'userid' => $userid,
			'createtime' => time(),
			'content' => $opt
			);
		$this->db->insert($this->_tableName, $data);
	}
}// class
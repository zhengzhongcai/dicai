<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userrole extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_UserRole';
	}
}// class
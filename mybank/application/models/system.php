<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_system';
	}
}// class
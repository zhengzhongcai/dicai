<?php
class M_checkSession extends CI_Model{
	function __construct(){
		parent::__construct();	
		$this->load->model("m_user","USER");
		$this->load->model('m_userEntity','userEntity');
		
	}
	function check()
	{
		

		$user=$this->userEntity->userName;
		$up_user=$this->userEntity->userID;
		return $up_user;
	}
}
?>
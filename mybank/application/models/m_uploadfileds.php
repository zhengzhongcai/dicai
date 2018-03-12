<?php
class m_uploadFileds extends CI_Model{
	function __construct()
    {
        parent::__construct();	
	}
	function checkMd5($md5)
	{
		$sql="select CheckSum from play_file_property where FileType is Not NULL And CheckSum='".$md5."'";
		$arr_info=$this->db->query($sql)->result_array();
		//print_r($arr_info);
		$count=count($arr_info);
		if($count>0)
		{
			return true;
		}
		else
		{ return false;}
	}
}
?>
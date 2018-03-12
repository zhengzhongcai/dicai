<?php
 
class ViewFile extends CI_Controller
{
	//public $userEntity="";
   
	function __construct()
	{
		parent::__construct();
        }
		function index()
		{
				$arg["tp"]=$_GET['tp'];
			    $arg['url']=$_GET['url'];
			
			
			
			$data["arg"]=$arg; 
			
			$this->load->view("resourceManage/viewFile",$data);
		}
}
?>
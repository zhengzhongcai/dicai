<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/../../authed_list.php');

class Dashboard extends CI_Controller {
    var $_userid;
    var $_roleId;
    var $authM;

	function __construct()
	{

		parent::__construct();
		// 判断用户是否登录
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
        $this->_userid = $_SESSION[$sid]['userid'];
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
        
        //$this->smarty->assign('auths', $_SESSION[$sid]['auths']);
        $this->smarty->assign('admin', $_SESSION[$sid]['username']);
        $this->smarty->assign('roleName', $_SESSION[$sid]['R_name']);
        $this->_roleId = $_SESSION[$sid]['RID'];
        $this->authM = AuthManager::getInstance();
        $this->authM->setController($this); // $this的类型 为 Controller
		$fcode = isset($_GET['fcode'])?$_GET['fcode']:'';
        $opid = isset($_GET['opid'])?$_GET['opid']:'';
        /*
        if($fcode){
            //echo $authM->hasAuthOnOperation($this->_userid, $fcode, $opid);
            if(!$this->authM->hasAuthOnOperation($this->_userid, $fcode, $opid)){
                $this->smarty->display('error/forbidden.html');
                exit;
            }
        }
        */
	}

	public function index()
	{
		$authList = $this->authM->getAuthListOnRole(9);
        $forbidden = false;
        if(empty($authList)){
            $this->smarty->display('error/forbidden.html');
            exit;
        }
        foreach($authList as $key=>$val){
            if(strrpos($key, '-')===false){
                $c_key = $this->authM->getControllerByFuncode($key);
                if($c_key){

                    header("location:{$this->_baseUrl}/index.php?control={$c_key}");
                }else{
                    $this->smarty->display('error/forbidden.html');
                }
                exit;
            }
        }
        $this->smarty->display('error/forbidden.html');
        exit;


	}// func

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
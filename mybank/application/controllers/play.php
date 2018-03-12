<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Play extends CI_Controller {
	var $_userid;
	var $_roleId;
	function __construct()
	{

		parent::__construct();
		
		// 判断用户是否登录
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
		$this->_userid = $_SESSION[$sid]['userid'];
		//$this->smarty->assign('auths', $_SESSION[$sid]['auths']);
		$this->_admin = $_SESSION[$sid]['username'];
		$this->smarty->assign('admin', $_SESSION[$sid]['username']);
		$this->smarty->assign('roleName', $_SESSION[$sid]['R_name']);
		$this->_roleId = $_SESSION[$sid]['RID'];
		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
        $fcode = isset($_GET['fcode'])?$_GET['fcode']:'';
        $opid = isset($_GET['opid'])?$_GET['opid']:'';
		/*
        if($fcode){
            $authM = AuthManager::getInstance();
            $authM->setController($this); // $this的类型 为 Controller
            //echo $authM->hasAuthOnOperation($this->_userid, $fcode, $opid);
            if(!$authM->hasAuthOnOperation($this->_userid, $fcode, $opid)){
                $this->smarty->display('error/forbidden.html');
                exit;
            }
        }
		*/
        // 加载模型
        $this->load->model('Rolefunc', '_Mrolefunc');
        $this->load->model('Roleopt', '_Mroleopt');
        $this->load->model('User', '_Muser');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');

        $this->load->model('Adminlog', '_Madminlog');
        $this->load->model('Pfproject', '_Mpfproject');
       $this->load->model('Language','_Mlanguage');

		$this->load->model('Language','_Mlanguage');


        $this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
	    // 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('upload');

		global $language;
		global $roleid;
		$roleid=$this->_roleId;
		$language=$this->_Mlanguage->getstr();
        // 加载语言包

		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);

		load_lang('COMMON', $this->smarty, $this);
		load_lang('DATA', $this->smarty, $this);
		lang_list($this->smarty);

		// 控制器类型
		$this->smarty->assign('control', 'play');
		$flanguage=$this->_Mlanguage->getvstr();
		$this->config->set_item('language',$flanguage[0]['visit']);

		global $language;
		global $fcodeArr;
		global $arr;

		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid); 
		$this->smarty->assign('optArr', $optArr);
		$language=$this->_Mlanguage->getstr();


		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'roleId'=>$this->_roleId,
			//	'orgtree'=>$this->_orgTreeStr,
				'timeControl'=> getDayTypeSelect($this),
		);

    }
public function index()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
	//	$this->smarty->assign('action', 'fast_second');
	//	$this->smarty->assign('action', 'fast_second');
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		
		//$this->smarty->assign('action', 'fast');
		$this->load->view('header',$data);
		$this->load->view('play/lefter.html',$data);
		$this->load->view('playProgram/v_fastProfileInfo');
		$this->load->view('footer');
	}
	public function index1(){
		$this->load->view('header');
		$this->load->view('playProgram/v_fastProfileInfo1');

	}

		public function fast()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		$this->smarty->assign('action', 'fast_second');
		$this->smarty->assign('action', 'fast_second');
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		
		//$this->smarty->assign('action', 'fast');
		$this->load->view('header',$data);
		$this->load->view('play/lefter.html',$data);
		$this->load->view('playProgram/v_fastProfileInfo');
		$this->load->view('footer');
	}// func


   	public function temp()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		$this->smarty->assign('action', 'temp_second');
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		
		//$this->smarty->assign('action', 'fast');
		$this->load->view('header',$data);
		$this->load->view('play/lefter.html',$data);
	//$this->smarty->display('playProgram/v_templateManage.html');
		$this->load->view('playProgram/v_templateManage');
		//$this->smarty->display('play/righter_temp.html');
		//$this->smarty->display('footer.html');
		$this->load->view('footer');
	}// func


		public function profile()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		$this->smarty->assign('action', 'profile_second');
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		
		//$this->smarty->assign('action', 'fast');
		$this->load->view('header',$data);
		$this->load->view('play/lefter.html',$data);
		$this->load->view('playProgram/v_ProfileInfo');
	$this->load->view('footer');
	}// func
   
   	public function play_list()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		$this->smarty->assign('action', 'play_list_second');
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		
		//$this->smarty->assign('action', 'fast');
		$this->load->view('header',$data);
		$this->load->view('play/lefter.html',$data);
		//$this->smarty->display('playProgram/v_playlist.html');
		$this->load->view('playProgram/v_playlist');
		//$this->smarty->display('footer.html');
		$this->load->view('footer');
	}// func

	//快速创建节目
    function fastCreateProfile()
    {
    	$this->load->view('v_fastCreateProfile');
    }
  }  
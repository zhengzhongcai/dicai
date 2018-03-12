<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('User', '_Muser');
		$this->load->model('Role', '_Mrole');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('Func', '_Mfunc');
		$this->load->model('Userrole', '_Muserrole');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
		$authM = AuthManager::getInstance();
		$authM->setController($this);
		
		$this->load->helper('common');//加载自定义函数库
		load_lang('COMMON', $this->smarty, $this);
		load_lang('LOGIN', $this->smarty, $this);
	}

	public function index()
	{
         ///添加
		$this->load->helper('form');
		$data['title']="add contacts commay Info";
		$data['headline']='Welcome';
		$data['include']='home';
		$this->load->vars($data);
		$this->smarty->display('login.html');

	//$this->smarty->display('login.html');
		/*
		$query = $this->db->query("select username from {$this->_Muser->_tableName}");
		$ret = $query->result_array();
		$result= json_encode($ret);
		echo $result;
		*/




		/**
		 *

		$filename = LANGPATH.'default.ini';
		if (file_exists($filename)) $str = file_get_contents($filename);
		else die('Not exists the default.ini file, please check.');
		if (!trim($str)) die('Not set the default language, please check.');
		// 加载默认语言
		@$filename = LANGPATH.$str.'/'.COMMON.'.ini';
		if (file_exists($filename)) {
			$fp = fopen($filename, 'r');
			while (!feof($fp)) {
				$line = fgets($fp);
			$pare=explode('=',$line);
				echo "<pre>";
				print_r($pare);
				echo "<br/>";
			}
		}
		 */


	}
	public function login()
	{
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$this->db->where('username', $_POST['username']);
			$this->db->where('password', md5($_POST['password']));

			$query = $this->db->get($this->_Muser->_tableName);
			$ret = $query->row_array();

			if (count($ret)) {
				$sid = session_id();
				if (empty($sid)) session_start();
				$sid = session_id();
				$_SESSION[$sid]['username'] = $_POST['username'];
				$_SESSION[$sid]['password'] = $_POST['password'];
				$_SESSION[$sid]['userid'] = $ret['ID'];
				//找出用户角色对应的权限
				//$query = $this->db->query("select a.*, b.R_name from {$this->_Muserrole->_tableName} as a left join {$this->_Mrole->_tableName} as b on a.RID = b.R_ID where a.UID={$ret['ID']}");
				$query = $this->db->query("select a.*, b.* from {$this->_Muserrole->_tableName} as a left join {$this->_Mrolename->_tableName} as b on a.RID = b.role_id where a.UID={$ret['ID']}");
				$ret = $query->row_array();
				$_SESSION[$sid]['RID'] = $ret['role_id'];
				$_SESSION[$sid]['R_name'] = $ret['role_name'];
				$_SESSION["Km"]='1';
				$_SESSION["opuser"]='sa';
				// 跳转到监控页面
				//header("location:{$this->_baseUrl}/index.php?control=dashboard");
			}// if

		}
	}
	public function login1()
	{
		if (isset($_POST['username']) && isset($_POST['password']))
		{
			$this->db->where('username', $_POST['username']);
			$this->db->where('password', md5($_POST['password']));
			
			$query = $this->db->get($this->_Muser->_tableName);
			$ret = $query->row_array();
			
			if (count($ret))
			{
				$sid = session_id();
				if(empty($sid)) session_start();
				$sid = session_id();
				$_SESSION[$sid]['username'] = $_POST['username'];
				$_SESSION[$sid]['password'] = $_POST['password'];
				$_SESSION[$sid]['userid'] = $ret['ID'];
				
				
				//找出用户角色对应的权限
				$query = $this->db->query("select a.*, b.R_name from {$this->_Muserrole->_tableName} as a left join {$this->_Mrole->_tableName} as b on a.RID = b.R_ID where a.UID={$ret['ID']}");
				$ret = $query->row_array();
				
				$_SESSION[$sid]['RID'] = $ret['RID'];
				$_SESSION[$sid]['R_name'] = $ret['R_name'];
				
				// 跳转到监控页面
				//header("location:{$this->_baseUrl}/index.php?control=dashboard");
			}// if
			else
			{
				// 判断用户是否存在
				$this->db->where('username', $_POST['username']);
				//$this->db->where('password', md5($_POST['password']));
					
				$query = $this->db->get($this->_Muser->_tableName);
				$ret = $query->row_array();
				if (count($ret)){
					echo '请输入正确的密码.';
				}else {
					echo '该账号不存在,请输入正确的登录账号.';
				}
				// 判断用户密码是否正确
			}//
		}// if
		//$this->smarty->display('login.html');
	}// func
	
	public function loginout()
	{
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
		unset($_SESSION[$sid]);
		header("location:{$this->_baseUrl}/index.php?control=welcome");
	}// func
	
	// 设置默认语言
	public function setDefaultLang()
	{
		$lang = $_POST['lang'];
		$data=array(
			'visit'=>$lang,
		);
		$this->db->where('id', 1);
		$this->db->update('sys_flanguage', $data);

	}// func
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
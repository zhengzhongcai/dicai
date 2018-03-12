<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Institution extends CI_Controller {
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
		$this->load->model('Orgrizetree', '_Morgrizetree');
		$this->load->model('System', '_Msystem');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('Roleopt', '_Mroleopt');
		$this->load->model('UserAccessjg', '_UserAccessJG');
		$this->load->model('Adminlog', '_Madminlog');
		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');

		$this->load->model('Language','_Mlanguage');
		
		$this->_baseUrl = $this->config->item('base_url');
		//$this->smarty->assign("baseUrl", $this->_baseUrl);

		//$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		global $language;
		global $roleid;
		$roleid=$this->_roleId;
		$language=$this->_Mlanguage->getstr();
		
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->language(['COMMON']);
		$this->load->language(['ORG']);
		// 加载语言包
		load_lang('COMMON', $this->smarty, $this);
		load_lang('ORG', $this->smarty, $this);
		lang_list($this->smarty);
		
		// 控制器类型
		//$this->smarty->assign('control', 'institution');
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $fcodeArr;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $arr;
		
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid);
		$this->smarty->assign('optArr', $optArr);
		
		// 获取用户有权限查看的机构代号
		if ($this->_admin == 'admin') $this->_authJgStr = $this->_Morgrizetree->getAllOrg();
		else $this->_authJgStr = $this->_UserAccessJG->getOrgByUid($this->_userid);
		
		$orgTree = $this->_Morgrizetree->getOrgTree($this->_authJgStr);

		$this->_orgTreeStr = generateOrgTree($orgTree, 'getOrgInfo');
		$this->smarty->assign('orgTreeStr', $this->_orgTreeStr);

		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'orgtree'=>$this->_orgTreeStr,
			//	'timeControl'=> getDayTypeSelect($this),
				'optArr'=> $optArr,
				'roleId'=>$this->_roleId

		);
	}
	
	public function index()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		$this->load->view('header',$data);
		$this->load->view('institution/lefter');
		$this->load->view('institution/righter_list');
		$this->load->view('footer');
/*
		$this->smarty->display('header.html');
		$this->smarty->display('institution/lefter.html');
		$this->smarty->display('institution/righter_list.html');
		$this->smarty->display('footer.html');
*/
	}// func
	
	// 获取机构基本信息
	public function getOrgInfo()
	{
		$orgId = $_POST['orgId'];
		// 检查是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->result_array();
		if (count($spot))
		{
			$query = $this->db->query("select * from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		}
		else 
		{
			$query = $this->db->query("select a.*, b.JG_name as pname from {$this->_Morgrizetree->_tableName} a left join {$this->_Morgrizetree->_tableName} b on a.JG_PID=b.JG_ID where a.JG_ID='{$orgId}'");
		}	
		$ret = $query->row_array();
		$ret['isspot'] = count($spot);
		echo json_encode($ret);
	}// func
	
	// 保存机构信息的修改
	public function saveOrgInfo()
	{
		$info = $_POST;
		$isspot = $info['isspot'];
		unset($info['isspot']);
		$orgId = $info['orgId'];
		unset($info['orgId']);
		$query = $this->db->query("select a.*, b.JG_name as pname from {$this->_Morgrizetree->_tableName} a left join {$this->_Morgrizetree->_tableName} b on a.JG_PID=b.JG_ID where a.JG_ID='{$orgId}'");
		if ($isspot)
		{
			$info['sys_lasttime'] = date('Y-m-d H:i:s');
			$this->db->update($this->_Msystem->_tableName, $info, array('sysno'=>$orgId));
			
			// 同时修改机构树中的网点
			$info = array();
			$info['JG_ID'] = $_POST['sysno'];
			$info['JG_name'] = $_POST['sysname'];
			$this->db->update($this->_Morgrizetree->_tableName, $info, array('JG_ID'=>$orgId));
		}
		else
		{
			$info['JG_lasttime'] = date('Y-m-d H:i:s');
			$this->db->update($this->_Morgrizetree->_tableName, $info, array('JG_ID'=>$orgId));
		}// if
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改机构:{$orgId}");
	}// func
	
	// 添加下属机构
	public function addOrgInfo()
	{
		$info = $_POST;
		$orgId = $info['orgId'];
		unset($info['orgId']);
		if (isset($info['isspot']))
		{
			$isspot = 1;
			unset($info['isspot']);
		}
		else
		{
			$isspot = 0;
		}// if
		
		$info['JG_lasttime'] = date('Y-m-d H:i:s');
		$info['JG_lrtime'] = date('Y-m-d H:i:s');
		$info['JG_PID'] = $orgId;
		
		$this->db->insert($this->_Morgrizetree->_tableName, $info);
		
		$this->_Madminlog->add_log($this->_userid, "添加下属机构:".json_encode($info));
		
		if ($isspot && $this->db->affected_rows())
		{
			$sysInfo = array();
			$sysInfo['sys_lrtime'] = date('Y-m-d H:i:s');
			$sysInfo['sys_lasttime'] = date('Y-m-d H:i:s');
			$sysInfo['sysno'] = $info['JG_ID'];
			$sysInfo['sysname'] = $info['JG_name'];
			//print_r($sysInfo);
			$this->db->insert($this->_Msystem->_tableName, $sysInfo);
			
			echo $this->db->affected_rows();
			exit;
		}
		
		echo $this->db->affected_rows();
	}// func
	
	// 删除机构
	public function deleteOrgInfo()
	{
		// 如果该机构存在子节点，则不能删除
		$orgId = $_POST['orgId'];
		$this->db->where('JG_PID', $orgId);
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$ret = $query->result_array();
		if (count($ret))
		{
			echo 0;
			exit;
		}// func
		
		$isspot = $_POST['isspot'];
		$this->db->delete($this->_Morgrizetree->_tableName, array('JG_ID'=>$orgId));
		if ($isspot && $this->db->affected_rows()) 
		{
			$this->db->delete($this->_Msystem->_tableName, array('sysno'=>$orgId));
			echo $this->db->affected_rows();
			exit;
		}// if
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除机构:{$orgId}");
	}// func
	
	// 获取机构树形结构
	public function getOrgTreeStr()
	{
		echo $this->_orgTreeStr;
	}// func
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
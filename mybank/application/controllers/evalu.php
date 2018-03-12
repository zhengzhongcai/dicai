<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Evalu extends CI_Controller {
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
		$this->load->model('Param', '_Mparam');
		$this->load->model('System', '_Msystem');
		$this->load->model('Serial', '_Mserial');
		$this->load->model('Pfproject', '_Mpfproject');
		$this->load->model('Vip', '_Mvip');
		$this->load->model('Server', '_Mserver');
		$this->load->model('Counter', '_Mcounter');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('Roleopt', '_Mroleopt');
		$this->load->model('UserAccessjg', '_UserAccessJG');
		$this->load->model('Evalus', '_Mevalu');
		$this->load->model('Tpl', '_Mtpl');
		$this->load->model('User', '_Muser');
		
		$this->load->model('Adminlog', '_Madminlog');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
		
		$this->load->model('Task', '_Mtask');
		$this->load->model('Taskdetail', '_Mtaskdetail');

		$this->load->model('Language','_Mlanguage');

		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('upload');
		
		// 加载语言包
		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer']);
		load_lang('COMMON', $this->smarty, $this);
		load_lang('EVALU', $this->smarty, $this);
		lang_list($this->smarty);
		
		// 控制器类型
		$this->smarty->assign('control', 'evalu');
		
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		//$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid); 
		$this->smarty->assign('optArr', $optArr);

		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		global  $roleid;

		// 获取用户有权限查看的机构代号
		if ($this->_admin == 'admin') $this->_authJgStr = $this->_Morgrizetree->getAllOrg();
		else $this->_authJgStr = $this->_UserAccessJG->getOrgByUid($this->_userid);
		
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$itsOrgAr = $query->result_array();
		//$this->smarty->assign('itsOrgArr', $ret);

		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		$language=$this->_Mlanguage->getstr();
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		$roleid=$this->_roleId;

		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
			//	'orgtree'=>$this->_orgTreeStr,
				'timeControl'=> getDayTypeSelect($this),
				'roleId'=>$this->_roleId,

		);
	}
	
	public function index()
	{	
		$this->counterParam();
	}// func
	
	// 评价器清单管理
	public function counterParam()
	{
		//$this->smarty->assign('action', 'counterParam');
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);
	
		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_counter',$data);
		$this->load->view('footer',$data);
	}// func
	public function templateManagea()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		//$this->smarty->assign('action', 'counterParam');
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array('language'=>$language,
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'rolemenu'=>$retrolemenu,

		);

		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_counter',$data);
		$this->load->view('footer');
	}// func
	public function templateManage()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);
		//$this->smarty->assign('action', 'counterParam');
		//$this->smarty->assign('src', '/CI/index.php/c_templateManage/templateList');

		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_iframe',$data);
		$this->load->view('footer');
	}// func
	public function profileManage()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		//$this->smarty->assign('action', 'counterParam');
		//$this->smarty->assign('src', 'http://192.168.100.39/CI/index.php/c_profileInfo/getProfileInfo');
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);

		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_iframe',$data);
		$this->load->view('footer');
	}// func
	public function projectManage()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		//$this->smarty->assign('action', 'counterParam');
		//$this->smarty->assign('src', 'http://192.168.100.39/CI/index.php/c_playListManage/getAllPlayList');
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);

		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_iframe',$data);
		$this->load->view('footer');
	}// func
	public function fastManage()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);
		//$this->smarty->assign('action', 'counterParam');
		//$this->smarty->assign('src', 'http://192.168.100.39/CI/index.php/c_profileInfo/getFastProfileInfo');

		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_iframe',$data);
		$this->load->view('footer');
	}// func

	// 添加评价器
	public function addEvalu(){
		$this->smarty->assign('action', 'counterParam');
		// 找出全部机构
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$orgs = $query->result_array();
		$this->smarty->assign('orgInfos', $orgs);
		
		$query = $this->db->query("select a.*, b.username from {$this->_Mtpl->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID where a.status =1 order by a.create_time desc");
		$tpls = $query->result_array();
		$this->smarty->assign('tplInfos', $tpls);
		
		$this->smarty->display('header');
		$this->smarty->display('evalu/lefter.html');
		$this->smarty->display('evalu/righter_addevalu.html');
		$this->smarty->display('footer.html');

		
	}
	
	// 编辑评价器
	public function editEvalu(){
		$this->smarty->assign('action', 'counterParam');
		// 找出全部机构
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$orgs = $query->result_array();
		$this->smarty->assign('orgInfos', $orgs);
		
		$query = $this->db->query("select a.*, b.username from {$this->_Mtpl->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID where a.status = 1 order by a.create_time desc");
		$tpls = $query->result_array();
		$this->smarty->assign('tplInfos', $tpls);
		
		$eId = $_GET['eId'];
		$this->db->where('E_id', $eId);
		$query = $this->db->get($this->_Mevalu->_tableName);
		$evalu = $query->row_array();
		
		// 获取评价器所在机构对应的窗口信息
		$this->db->where('C_sysno', $evalu['JG_ID']);
		$query = $this->db->get($this->_Mcounter->_tableName);
		$cnos = $query->result_array();
		$this->smarty->assign('cnos', $cnos);
		
		$this->smarty->assign('evalu', $evalu);
		$this->smarty->assign('eId', $eId);
		
		$this->smarty->display('header');
		$this->smarty->display('evalu/lefter.html');
		$this->smarty->display('evalu/righter_editevalu.html');
		$this->smarty->display('footer.html');
		
	}
	
	// 保存评价器信息
	public function saveEvalu(){
		$eId = 0;
		if (isset($_POST['eId'])) $eId = $_POST['eId'];
		$info = array();
		$info['E_no'] = $_POST['no'];
		$info['E_series'] = $_POST['series'];
		$info['JG_ID'] = $_POST['JG_ID'];
		$info['T_id'] = $_POST['T_id'];
		//$info['E_update'] = $_POST['update'];
		$info['E_isuse'] = $_POST['isuse'];
		$info['C_no'] = $_POST['cno'];
		
		if ($eId){
			echo $this->db->update($this->_Mevalu->_tableName, $info, array('E_id'=>$eId));
			$this->_Madminlog->add_log($this->_userid, "修改评价器:{$eId}");
		}else{
			echo $this->db->insert($this->_Mevalu->_tableName, $info);
			$this->_Madminlog->add_log($this->_userid, "添加评价器:{$info['E_series']}");
		}
	}
	
	// 获取柜台信息
	public function getCounterParam()
	{
		$no = isset($_POST['no'])?$_POST['no']:'';
		$series = isset($_POST['series'])?$_POST['series']:'';
		$orgId = isset($_POST['orgId'])?$_POST['orgId']:'';
		$status = isset($_POST['status'])?$_POST['status']:'';
		$isuse = isset($_POST['isuse'])?$_POST['isuse']:'';
		
		if ($no != ''){
			$this->db->like('a.E_no', $no);
		}
		
		if ($series != ''){
			$this->db->like('a.E_series', $series);
		}
		
		if ($orgId != ''){
			$this->db->where('a.JG_ID', $orgId);
		}
		
		if ($status != ''){
			$this->db->where('a.E_status', $status);
		}
		
		if ($isuse != ''){
			$this->db->where('a.E_isuse', $isuse);
		}
		
		$this->db->select('a.E_id, a.E_no, a.E_series, a.E_status, a.*, a.E_isuse, b.JG_name, c.tpl_name');
		$this->db->from("{$this->_Mevalu->_tableName} as a");
		$this->db->join("{$this->_Morgrizetree->_tableName} as b", 'a.JG_ID = b.JG_ID', 'left');
		$this->db->join("{$this->_Mtpl->_tableName} as c", 'c.id = a.T_id', 'left');
		
		$query = $this->db->get();
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 删除评价器
	public function deleteCounterInfo()
	{
		$params = $_POST['params'];
		$this->db->where("E_id in ({$params})");
		$this->db->delete($this->_Mevalu->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除评价器:{$params}");
	}// func
	
	// 任务管理界面
	public function task(){
	//	$this->smarty->assign('action', 'task');
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid);
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,

		);
		$this->load->view('header',$data);
		$this->load->view('evalu/lefter',$data);
		$this->load->view('evalu/righter_task',$data);
		$this->load->view('footer',$data);
	}
	
	// 添加任务
	public function addTask(){
		$this->smarty->assign('action', 'task');
		$this->smarty->display('header');
		$this->smarty->display('evalu/lefter.html');
		$this->smarty->display('evalu/righter_addtask.html');
		$this->smarty->display('footer.html');
	}
	
	// 保存任务
	public function saveTask(){		
		$jgId = $_POST['jgId'];
		$updatetime = $_POST['updatetime'];
		// 保存任务记录
		$info = array();
		$info['JG_ID'] = $jgId;
		$info['updatetime'] = $updatetime;
		$info['createtime'] = date('Y-m-d H:i:s', time());
		$info['userid'] = $this->_userid;
		
		$this->_Madminlog->add_log($this->_userid, "添加信息包发布任务");
		
		if ($this->db->insert($this->_Mtask->_tableName, $info)){
			// 找出刚刚插入的任务id
			$this->db->select_max('id');
			$query = $this->db->get($this->_Mtask->_tableName);
			$ret = $query->row_array();
			$taskid = $ret['id'];
			
			// 记录该任务下所有的评价器更新情况
			$this->db->where('JG_ID', $jgId);
			$this->db->where('E_isuse', 1);
			$query = $this->db->get($this->_Mevalu->_tableName);
			$evalus = $query->result_array();
			
			foreach($evalus as $row){
				$evalu = array();
				$evalu['E_series'] = $row['E_series'];
				$evalu['updatetime'] = $updatetime;
				$evalu['task_id'] = $taskid;
				
				// 找出当前要更新的信息包版本
				$sql = "select b.version from {$this->_Mevalu->_tableName} a left join {$this->_Mtpl->_tableName} b on a.T_id=b.id where a.E_series='{$row['E_series']}'";
				$query = $this->db->query($sql);
				$ret = $query->row_array();
				$evalu['E_version'] = $ret['version'];
				
				if ($this->db->insert($this->_Mtaskdetail->_tableName, $evalu)){
					// 修改设备更新时间
					$setTime['E_update'] = $updatetime;
					$this->db->update($this->_Mevalu->_tableName, $setTime, array('E_series'=>$row['E_series']));
				}// if
			}
			echo 1;
			return;	
		}// if
		echo 0;
		return;
	}
	
	// 获取任务信息
	public function getTask(){
		if ($this->_admin == 'admin')
			$sql = "select b.JG_name, a.createtime, c.username, a.id from {$this->_Mtask->_tableName} a left join {$this->_Morgrizetree->_tableName} b on a.JG_ID=b.JG_ID left join {$this->_Muser->_tableName} c on a.userid=c.ID order by a.createtime desc";
		else
			$sql = "select b.JG_name, a.createtime, c.username, a.id from {$this->_Mtask->_tableName} a left join {$this->_Morgrizetree->_tableName} b on a.JG_ID=b.JG_ID left join {$this->_Muser->_tableName} c on a.userid=c.ID where a.userid={$this->_userid} order by a.createtime desc";
		
		$query = $this->db->query($sql);
		$tasks = $query->result_array();
		
		echo json_encode($tasks);
	}
	
	// 删除任务
	public function deleteTask(){
		$params = $_POST['params'];
		
		$this->_Madminlog->add_log($this->_userid, "删除信息包发布任务:{$params}");

		$this->db->where("id in ({$params})");
		$this->db->delete($this->_Mtask->_tableName);
		if ($this->db->affected_rows()){
			// 删除任务对应的详细记录
			$this->db->where("task_id in ({$params})");
			$this->db->delete($this->_Mtaskdetail->_tableName);
			
			echo 1;
			return;
		}
		echo 0;
	}// func
	
	// 查看任务详情
	public function taskdetail(){
		$taskid = $_GET['taskid'];
		
		$sql = "select a.E_series, b.E_no, b.C_no, a.status from {$this->_Mtaskdetail->_tableName} a left join {$this->_Mevalu->_tableName} b on a.E_series=b.E_series where a.task_id={$taskid}";
		$query = $this->db->query($sql);
		$details = $query->result_array();
		
		$this->smarty->assign('action', 'task');
		$this->smarty->assign('details', $details);
		
		$this->smarty->display('header');
		$this->smarty->display('evalu/lefter.html');
		$this->smarty->display('evalu/righter_taskdetail.html');
		$this->smarty->display('footer.html');
	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
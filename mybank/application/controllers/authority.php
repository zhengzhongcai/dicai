<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Authority extends CI_Controller {
	var $_userid;
	var $_roleId;
	var $_authM;
	
	function __construct()
	{
		parent::__construct();
		
		// 判断用户是否登录
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
		$this->_userid = $_SESSION[$sid]['userid'];
		//$this->smarty->assign('auths', $_SESSION[$sid]['auths']);
		$this->smarty->assign('admin', $_SESSION[$sid]['username']);
		$this->smarty->assign('roleName', $_SESSION[$sid]['R_name']);
		$this->_roleId = $_SESSION[$sid]['RID'];
		
		$fcode = isset($_GET['fcode'])?$_GET['fcode']:'';
		$opid = isset($_GET['opid'])?$_GET['opid']:'';
		/*
		if($fcode){
			$authM = AuthManager::getInstance();
			//$authM->setController($this); // $this的类型 为 Controller
			//echo $authM->hasAuthOnOperation($this->_userid, $fcode, $opid);
			if(!$authM->hasAuthOnOperation($this->_userid, $fcode, $opid)){
				$this->smarty->display('error/forbidden.html');
				exit;
			}
		}
		*/
		$this->load->model('User', '_Muser');
		$this->load->model('Func', '_Mfunc');
		$this->load->model('Role', '_Mrole');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('Userrole', '_Muserrole');
		$this->load->model('Roleopt', '_Mroleopt');
		$this->load->model('UserAccessjg', '_UserAccessJG');
		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
		$this->load->model('Orgrizetree', '_Morgrizetree');
		$this->load->model('Adminlog', '_Madminlog');
		$this->load->model('Language','_Mlanguage');




		//加载语言包
		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);
		//->load->language(['auth']);
		//$this->load->language(['common']);

		
		// 控制器类型
		$this->smarty->assign('control', 'authority');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
		
		$this->load->helper('common');
		
		load_lang('COMMON', $this->smarty, $this);
		load_lang('AUTH', $this->smarty, $this);
		lang_list($this->smarty);
		
		$this->_authM = AuthManager::getInstance();
		$this->_authM->setController($this);

		 global $roleid;
		$roleid=$this->_roleId;
		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		global $orgid1;
		$orgid=$_SESSION[$sid]['RID'];
		$orgid1=54;

		$ret = $this->_authM->getAuthedList();
		$authList = generateAuthList($ret);
		$this->smarty->assign('authlist', $authList);
		
		// 构造机构树
		$this->_orgTree = $this->_Morgrizetree->getOrgTree();
		$this->_orgTreeStr = generateOrgTreeCheck($this->_orgTree);
		//$this->smarty->assign('orgTreeStr', $this->_orgTreeStr);
		
		// 获取用户功能权限数组
	   // $fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		global $fcodeArr;
		global $arr;
		global $language;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		$language=$this->_Mlanguage->getstr();
		//echo $this->config->item('language');
		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'timeControl'=> getDayTypeSelect($this),
				'roleId'=>$this->_roleId,
		);

		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		//$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);



		// 根据功能id找出功能操作
		//$optArr = $this->_Mroleopt->getOptByRfid($fid);
		//$this->smarty->assign('optArr', $optArr);



	}
	
	// 获取机构数据
	public function getOrgTreeStr()
	{
		echo $this->_orgTreeStr = generateOrgTreeCheck($this->_orgTree);
	}//func

	function index()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		$this->db->where("role_id != 13");
		$query = $this->db->get($this->_Mrolename->_tableName);
		$roels = $query->result_array();
		$this->smarty->assign('roles', json_encode($roels));
		// 找出全部机构
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$orgs = $query->result_array();
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'orgInfos'=>$orgs,
				'roleInfos'=>$roels,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,
		);
		// 找出全部角色

		//$this->smarty->assign('orgInfos', $orgs);
		//$this->smarty->assign('roleInfos', $roels);
		//$this->smarty->assign('action', 'user');
		$this->load->view('header',$data);
		$this->load->view('authority/lefter',$data);
		$this->load->view('authority/righter_user',$data);
		$this->load->view('footer');
	}// func
	
	public function changePass()
	{
		$oldPass = $_POST['oldPass'];
		$newPass = $_POST['newPass'];
		$rePass = $_POST['rePass'];
	
		$this->db->where('ID', $this->_userid);
		$this->db->where('password', md5($oldPass));
		$query = $this->db->get($this->_Muser->_tableName);
		$ret = $query->row_array();
		if (!count($ret)) die($this->AUTH_SERVER_TIP1);
	
		$info = array();
		$info['password'] = md5($newPass);
		$this->db->update($this->_Muser->_tableName, $info, array('ID'=>$this->_userid));
		if ($this->db->affected_rows()) echo $this->AUTH_SERVER_TIP2;
		
		$this->_Madminlog->add_log($this->_userid, "修改密码");
	}// func
	
	function getUsers()
	{
	  $query = $this->db->query("select a.*, c.role_name as rname from {$this->_Muser->_tableName} a left join {$this->_Muserrole->_tableName} b on a.ID=b.UID left join {$this->_Mrolename->_tableName} c on c.role_id=b.RID");
		//$query = $this->db->query("select a.*, c.R_name as rname from {$this->_Muser->_tableName} a left join {$this->_Muserrole->_tableName} b on a.ID=b.UID left join {$this->_Mrole->_tableName} c on c.R_ID=b.RID");
		$ret = $query->result_array();
		//echo '<pre>';
		//print_r($ret);exit;
		echo json_encode($ret);
	}// func
	
	public function getUserInfo()
	{
		//$_POST['ID'] = 5;
		$uid = $_POST['ID'];
		$this->db->where('ID', $uid);
		$query = $this->db->get($this->_Muser->_tableName);
		$userInfo = $query->row_array();
		
		// 获取机构管辖树
		$this->db->where('UID', $uid);
		$query = $this->db->get($this->_UserAccessJG->_tableName);
		$ret = $query->result_array();
		$checkArr = array();
		foreach ($ret as $row)
		{
			$checkArr[] = $row['JG_ID']; 
		}// for
		//print_r($checkArr);
		$orgTreeStr = generateOrgTreeCheck($this->_orgTree, $checkArr);
		// 获取角色
		$this->db->where('UID', $uid);
		$query = $this->db->get($this->_Muserrole->_tableName);
		$userrole = $query->row_array();
		if (count($userrole)) $rid = $userrole['RID'];
		else $rid = 1;
		echo json_encode(array('userInfo'=>$userInfo, 'orgTreeStr'=>$orgTreeStr, 'R_ID'=>$rid));
	}// func
	
	function addParamInfo()
	{
		//print_r($_POST);exit;
		/*
		$_POST['username'] = 'binbin';
		$_POST['truename'] = 'binbin';
		$_POST['password'] = '111111';
		$_POST['JG_ID'] = '01';
		$_POST['org'] = '0101,010101';
		$_POST['R_ID'] = 11;
		*/
		$info = $_POST;
		$this->db->where('username', $info['username']);
		$query = $this->db->get($this->_Muser->_tableName);
		$ret = $query->row_array();
		if (count($ret)) 
		{
			//echo '该登录名已经被使用，请重新输入.';
			echo $this->AUTH_SERVER_TIP3;
			return;
		}// if
		unset($info['repassword']);
		$info['password'] = md5($info['password']);
		$info['lrUser'] = $this->_userid;
		$info['lastUser'] = $this->_userid;
		$info['lrtime'] = date('Y-m-d H:i:s');
		$info['lasttime'] = date('Y-m-d H:i:s');
		
		$org = '';
        if(isset($info['org'])){
            $org = $info['org'];
            unset($info['org']);
        }
		$rid = $info['R_ID'];
		unset($info['R_ID']);
		
		//print_r($info);exit;
		// 关联角色
		$this->db->insert($this->_Muser->_tableName, $info);
		$query = $this->db->query("select max(ID) as ID from {$this->_Muser->_tableName}");
		$ret = $query->row_array();
		$insertid = $ret['ID'];
		// 添加角色
		$roleInfo['UID'] = $insertid;
		$roleInfo['RID'] = $rid;
		$this->db->insert($this->_Muserrole->_tableName, $roleInfo);
		
		//添加到机构树
		$parts = explode(',', $org);
		foreach ($parts as $row)
		{
			$info = array(
					'UID' => $insertid,
					'JG_ID' => $row,
					'lrtime' => date('Y-m-d H:i:s'),
					'lrUser' => $this->_userid,
					'lasttime' => date('Y-m-d H:i:s'),
					'lastUser' => $this->_userid
			);
			$this->db->insert($this->_UserAccessJG->_tableName, $info);
		}// func
		
		$this->_Madminlog->add_log($this->_userid, "添加用户:{$insertid}");
	}// func
	
	// 保存参数的修改
	public function saveParamInfo()
	{
		//print_r($_POST);exit;
		/*
		$_POST['paramId'] = '5';
		$_POST['username'] = 'binbin';
		$_POST['truename'] = 'binbin';
		$_POST['JG_ID'] = '01';
		$_POST['org'] = '0101,010101';
		$_POST['R_ID'] = 11;
		*/
		$info = $_POST;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		
		$org = '';
        if(isset($info['org'])){
            $org = $info['org'];
            unset($info['org']);
        }
		$rid = $info['R_ID'];
		unset($info['R_ID']);
		
		$info['lastUser'] = $this->_userid;
		$info['lasttime'] = date('Y-m-d H:i:s');
		
		$this->db->where("ID != {$paramId}");
		$this->db->where('username', $info['username']);
		$query = $this->db->get($this->_Muser->_tableName);
		$ret = $query->row_array();
		if (count($ret))
		{
			//echo '该登录名已经被使用，请重新输入.';
			echo $this->AUTH_SERVER_TIP3;
			return;
		}// if
		
		$this->db->update($this->_Muser->_tableName, $info, array('ID'=> $paramId));
		
		// 修改用户角色
		$roleInfo['RID'] = $rid;
		$this->db->update($this->_Muserrole->_tableName, $roleInfo, array('UID'=>$paramId));
		// 修改机构数据
		$this->db->delete($this->_UserAccessJG->_tableName, array('UID'=>$paramId));
		//添加到机构树
		$parts = explode(',', $org);
		foreach ($parts as $row)
		{
			$info = array(
					'UID' => $paramId,
					'JG_ID' => $row,
					'lrtime' => date('Y-m-d H:i:s'),
					'lrUser' => $this->_userid,
					'lasttime' => date('Y-m-d H:i:s'),
					'lastUser' => $this->_userid
			);
			$this->db->insert($this->_UserAccessJG->_tableName, $info);
		}// for
		
		$this->_Madminlog->add_log($this->_userid, "修改用户:{$paramId}");
	}//func
	
	// 删除公共参数
	public function deleteParamInfo()
	{
		$params = $_POST['params'];
		//echo $params;exit;
		$parts = explode(',', $params);
		// 判断是否为当前用户，如果是则不可以删除
		if (in_array($this->_userid, $parts))
		{
			//echo '无法删除您本人账号，请联系管理员.';
			echo $this->AUTH_SERVER_TIP4;
			exit;
		}// 
		foreach ($parts as $row)
		{
			// 判断用户是否为超级管理员, 是则不删除
			$this->db->where('UID', $row);
			$query = $this->db->get($this->_Muserrole->_tableName);
			$ret = $query->row_array();
			if ($ret['RID'] == 9) continue;
			// 删除用户
			$this->db->delete($this->_Muser->_tableName, array('ID'=>$row));
			// 删除机构
			$this->db->delete($this->_UserAccessJG->_tableName, array('UID'=>$row));
			// 删除用户角色
			$this->db->delete($this->_Muserrole->_tableName, array('UID'=>$row));
		}// for
		
		$this->_Madminlog->add_log($this->_userid, "删除用户:{$params}");
	}// func
	//---------------------------------------------------------
	public function role()
	{
		// 找出所有功能
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,

		);

       //
		//$query = $this->db->get($this->_Mfunc->_tableName);
		//$funcs = $query->result_array();

		//$this->smarty->assign('rolemenu',$retrolemenu);
		//$this->smarty->assign('funcs', $funcs);
		//$this->smarty->assign('action', 'role');
		$this->load->view('header',$data);
		$this->load->view('authority/lefter',$data);
		$this->load->view('authority/righter_role',$data);
		$this->load->view('footer');

	}// func
	
	public function getRoles()
	{
		//$this->db->where("R_name != '超级管理员'");
		//$this->db->where("R_name != '默认角色'");
		$query = $this->db->get($this->_Mrolename->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	function addRoleInfo()
	{
		/*
		$_POST['R_name'] = '测试角色';
		$_POST['report'] = 'r,d,u,a';
		*/
		$rname = $_POST['R_name'];
		unset($_POST['R_name']);
		
		$funcWithOpt = array();
		foreach ($_POST as $key=>$val)
		{
			$parts = explode(',', $val);
			foreach ($parts as $row)
			{
				$funcWithOpt[$key][] = $row;
			}// for
		}// for
		
		echo $this->_authM->addRole($rname, $funcWithOpt, $this->_userid, $this->_userid);
		
		$this->_Madminlog->add_log($this->_userid, "添加用户角色");
	}// func
	
	// 保存参数的修改
	public function saveRoleInfo()
	{
		/*
		$_POST['R_name'] = '测试角色1';
		$_POST['report'] = 'r,d,u,c';
		$_POST['paramId'] = 32;
		*/
		$rname = $_POST['R_name'];
		unset($_POST['R_name']);
		$paramId = $_POST['paramId'];
		unset($_POST['paramId']);
		
		$funcWithOpt = array();
		foreach ($_POST as $key=>$val)
		{
			$parts = explode(',', $val);
			foreach ($parts as $row)
			{
				$funcWithOpt[$key][] = $row;
			}// for
		}// for
		
		$ret = $this->_authM->updateRoleWithAuth($paramId, $rname, $funcWithOpt, $this->_userid);
		if ($ret) echo 0;
		else echo 1; 
		
		$this->_Madminlog->add_log($this->_userid, "修改角色:{$paramId}");
	}//func
	
	// 获取角色信息
	public function getRoleInfo()
	{
		$rId = 40;
		$arr=array();
		$retrolemenu=$this->_Mrolemenu->getroleid($rId) ;
		foreach($retrolemenu as $key=>$val){
			$roleid=$val['menurole_id'];
			$rolename=$this->_Mrolemenu->getrolename($roleid);
			$arr[]=$rolename;
		}
		P($arr);
		die();
		//$auths = generateUpdateAuth($retrolemenu);

		/*
		//$_POST['R_ID'] = 32;
		$rId = 9;
		$this->db->where('R_ID', $rId);
		$query = $this->db->get($this->_Mrole->_tableName);
		$roleInfo = $query->row_array();
		$ret = $this->_authM->getAuthListOnRole($rId);
		$auths = generateUpdateAuth($this->_authM->getAuthedList(), $roleInfo['R_name'], $ret, $this);
		P($auths);
		die();
		echo json_encode(array('roleInfo'=>$roleInfo, 'auths'=>$auths));
		*/
	} // func
	
	// 删除角色
	public function deleteRoleInfo()
	{
		//$_POST['params'] = 37;
		$params = $_POST['params'];
		//echo $params;exit;
		$ret=$this->_Mrolename->del($params);
		return true;
		$this->_Madminlog->add_log($this->_userid, "删除角色:{$params}");
	}// func
	
	//---------------------------------------
	// 获取父节点ID
	public function getJgpid()
	{
		//$_POST['orgId'] = '010101';
		$orgId = $_POST['orgId'];
		echo trim($this->_getAllJgPid($orgId), ',');
		//echo $ret['JG_PID'];
	}// func
	
	private function _getAllJgPid($orgId)
	{
		$str = '';
		$this->db->where('JG_ID', $orgId);
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$ret = $query->row_array();
		if (count($ret)) 
		{
			$str .= $ret['JG_PID'].',';
			$str .= $this->_getAllJgPid($ret['JG_PID']);
		}
		return $str;
	}// func
	
	// 获取全部 子节点
	public function getJGcid()
	{
		$orgId = $_POST['orgId'];
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		echo $sysnoStr;
	}// func
	// ------------------------------------------------
	public function log()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		$limit = isset($_GET['limit'])?$_GET['limit']:15;
		$query = $this->db->get($this->_Madminlog->_tableName);
		$rows = $query->result_array();
		$total_pages = ceil(count($rows)/$limit);
		global $fcodeArr;
		global $arr;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'total_page'=>$total_pages,
				'language'=>$language,
				'rolemenu'=>$retrolemenu


		);
		//$this->smarty->assign('funcs', $funcs);

		
		//$this->smarty->assign('total_page', $total_pages);
		
		//$this->smarty->assign('action', 'log');
		$this->load->view('header',$data);
		$this->load->view('authority/lefter',$data);
		$this->load->view('authority/righter_log',$data);
		$this->load->view('footer');

	}// func
	
	public function getLogs(){
		// 找出所有日志
		$page = isset($_POST['page'])?$_POST['page']:1;
		$limit = isset($_POST['limit'])?$_POST['limit']:15;
		$page = ($page - 1) * $limit;
		
		$this->db->select('a.id, a.createtime, a.content, b.username');
		$this->db->from("{$this->_Madminlog->_tableName} as a");
		$this->db->join("{$this->_Muser->_tableName} as b", 'a.userid = B.ID');
		$this->db->limit($limit, $page);
		$this->db->order_by("a.createtime", "desc");
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		
		$logs = $query->result_array();
		
		foreach ($logs as $key=>$val){
			$logs[$key]['createtime'] = date('Y-m-d H:i:s', $val['createtime']);
		}
		
		echo json_encode($logs);
	}
	
	// 删除日志
	public function deleteLog(){
		$params = $_POST['params'];
		$parts = explode(',', $params);
		$this->db->where_in('id', $parts);
		
		$this->db->delete($this->_Madminlog->_tableName);
		
		echo 1;
	}
	
	// 快捷删除日志
	public function fastDeleteLog(){
		$fastDate = $_POST['fastdate'];
		
		$timestamp = 0;
		
		switch ($fastDate){
			case '1':	// 一周之前
				$timestamp = time() - 86400 * 7;
				break;
			case '2':	// 一个月之前
				$timestamp = time() - 86400 * 30;
				break;
			case '3':	//	三个月之前
				$timestamp = time() - 86400 * 90;
				break;
			case '4':	// 半年之前
				$timestamp = time() - 86400 * 180;
				break;
			case '5':	// 一年之前
				$timestamp = time() - 86400 * 365;
				break;
		}
		
		if ($fastDate) {
			$this->db->where("createtime < ", $timestamp);
			$this->db->delete($this->_Madminlog->_tableName);
			$result['status'] = 1;
		}else{
			$result['status'] = 0;
			$result['error_msg'] = '请选择正确的时间';
		}
		echo json_encode($result);
	}
	//更改权限
	public function saveRole(){
		$str=$_POST['id'];
		$rolename=$_POST['rolename'];
		$role_id=$_POST['roleid'];

		$arr=explode(',',$str);
		//echo json_encode($arr);
		//$arr=array(1,2,3,5);
		$ret=array();
		foreach($arr as $key=>$val){
			if($val!=null) {
				$ret[]['menurole_id'] = $val;
				$ret[$key]['visit_roleid'] = $role_id;
			}
		};
		$this->db->where_in('visit_roleid',$role_id);
		$this->db->delete($this->_Muservisitmenu->_tableName);
		$count=$this->db->insert_batch($this->_Muservisitmenu->_tableName,$ret);
		echo $role_id;
	}
	//多表查询
	public function json(){
		$query=$this->db->query("select a.*,b.visit_roleid from system_menu a left join system_uservisitmenu b on b.menu_id=a.menu_id ");
		$ret=$query->result_array();
		P($ret);
	}
	public function addRole(){
        $str=$_POST['menu_id'];
		$rolename=$_POST['rolename'];
		$ret= $this->_authM->addRole1($str,$rolename);
		$lastret=$this->db->insert_batch($this->_Muservisitmenu->_tableName,$ret);
		echo count($lastret);

	}
	//根据ID查看角色
	public function inforole(){

	    $id=$_POST["roleid"];
       //$query=$this->db->query("select * from system_role where role_id=$id");
	//	$ret=$query->row_array();
		$ret=$this->_Muservisitmenu->getroleid($id);

    echo json_encode($ret);
    //  echo $ret["role_name"];
	//	$retrolemenu=$this->_Mrolemenu->getRolemenu($id) ;
     // echo json_encode($retrolemenu);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
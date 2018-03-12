<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Basedata extends CI_Controller {
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

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
		
		$this->load->model('Adminlog', '_Madminlog');

		$this->load->model('Language','_Mlanguage');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);

		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('upload');
		
		// 加载语言包
		global $language;
		$language=$this->_Mlanguage->getstr();
		$flanguage=$this->_Mlanguage->getvstr();
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);
		load_lang('COMMON', $this->smarty, $this);
		load_lang('DATA', $this->smarty, $this);
		lang_list($this->smarty);
		
		// 控制器类型
		$this->smarty->assign('control', 'basedata');
		
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
/*
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		$this->smarty->assign('fcodeArr', $fcodeArr);
*/
		global $fcodeArr;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		global $roleid;
		$roleid=$this->_roleId;
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $arr;
		global $itsOrgAr;
		
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid);
		$this->smarty->assign('optArr', $optArr);
		// 获取用户有权限查看的机构代号
		if ($this->_admin == 'admin') $this->_authJgStr = $this->_Morgrizetree->getAllOrg();
		else $this->_authJgStr = $this->_UserAccessJG->getOrgByUid($this->_userid);
		
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$itsOrgAr = $query->result_array();;

		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'timeControl'=> getDayTypeSelect($this),
				'roleId'=>$this->_roleId,

		);
	}


	public function index()
	{
		$this->serialParam();
	}// func
	
	// 公共参数管理
	public function commonParam()
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
		//$this->smarty->assign('action', 'commonParam');
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_common');
		$this->load->view('footer');
		/*
		$this->smarty->display('header.html');
		$this->smarty->display('basedata/lefter.html');
		$this->smarty->display('basedata/righter_common.html');
		$this->smarty->display('footer.html');
		*/
	}// func
	
	// 获取公共参数信息
	public function getCommonParam()
	{
		$query = $this->db->get($this->_Mparam->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加公共参数
	public function addParamInfo()
	{
		$info = $_POST;
		$this->db->insert($this->_Mparam->_tableName, $info);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加公共参数:".json_encode($info));
	}// func
	
	// 保存参数的修改
	public function saveParamInfo()
	{
		$info = $_POST;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$this->db->update($this->_Mparam->_tableName, $info, array('PramsName'=> $paramId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改公共参数:{$paramId}");
	}//func
	
	// 删除公共参数
	public function deleteParamInfo()
	{
		$params = $_POST['params'];
		$this->db->where("PramsName in ({$params})");
		$this->db->delete($this->_Mparam->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除公共参数:{$params}");
	}// func
	
	//------------------------------------------------------------------------------------------
	
	// 业务清单管理
	public function serialParam()
	{
		//$this->smarty->assign('action', 'serialParam');
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $fcodeArr;
		global $arr;
		global $roleid;
		global $language;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'language'=>$language,
				'rolemenu'=>$retrolemenu,


		);
		//$this->smarty->assign('action', 'commonParam');
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_serial',$data);
		$this->load->view('footer');
	}// func
	
	// 获取业务信息
	public function getSerialParam()
	{
		$query = $this->db->get($this->_Mserial->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加业务信息
	public function addSerialInfo()
	{
		$info = $_POST;
		// 检查业务代码是否已经存在，如果存在则提示
		$this->db->where("S_serialno", $info['S_serialno']);
		$query = $this->db->get($this->_Mserial->_tableName);
		$ret = $query->row_array();
		if (count($ret)) 
		{
			echo '该业务代码已经存在.';
			exit;
		}// if
		$info['S_lrtime'] = date('Y-m-d H:i:s');
		$info['S_lasttime'] = date('Y-m-d H:i:s');
		$this->db->insert($this->_Mserial->_tableName, $info);
		
		$this->_Madminlog->add_log($this->_userid, "添加业务信息:".json_encode($info));
	}// func
	
	// 保存业务信息的修改
	public function saveSerialInfo()
	{
		$info = $_POST;
		// 检查业务代码是否已经存在，如果存在则提示
		/*
		$this->db->where("S_serialno", $info['S_serialno']);
		$query = $this->db->get($this->_Mserial->_tableName);
		$ret = $query->row_array();
		if (count($ret))
		{
			echo '该业务代码已经存在.';
			exit;
		}// if
		*/
		$info['S_lasttime'] = date('Y-m-d H:i:s');
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$this->db->update($this->_Mserial->_tableName, $info, array('S_serialno'=> $paramId));
		
		$this->_Madminlog->add_log($this->_userid, "修改业务信息:{$paramId}");
	}//func
	
	// 删除业务
	public function deleteSerialInfo()
	{
		$params = $_POST['params'];
		$this->db->where("S_serialno in ({$params})");
		$this->db->delete($this->_Mserial->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除业务:{$params}");
	}// func
	
	//------------------------------------------------------------------------------------------
	// 评价清单管理
	public function evaParam()
	{
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
		);
		//$this->smarty->assign('action', 'evaParam');
	
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_eva',$data);
		$this->load->view('footer');
	}// func
	
	// 获取评价信息
	public function getEvaParam()
	{
		$query = $this->db->get($this->_Mpfproject->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加评价信息
	public function addEvaInfo()
	{
		$info = $_POST;
		$info['PJ_lrtime'] = date('Y-m-d H:i:s');
		$info['PJ_lrUser'] = $this->_userid;
		$info['PJ_lasttime'] = date('Y-m-d H:i:s');
		$info['PJ_lastUser'] = $this->_userid;
		$this->db->insert($this->_Mpfproject->_tableName, $info);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加评价项:".json_encode($info));
	}// func
	
	// 保存评价信息的修改
	public function saveEvaInfo()
	{
		$info = $_POST;
		$info['PJ_lasttime'] = date('Y-m-d H:i:s');
		$info['PJ_lastUser'] = $this->_userid;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$this->db->update($this->_Mpfproject->_tableName, $info, array('PJ_ID'=> $paramId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改评价项:{$paramId}");
	}//func
	
	// 删除评价
	public function deleteEvaInfo()
	{
		$params = $_POST['params'];
		$this->db->where("PJ_ID in ({$params})");
		$this->db->delete($this->_Mpfproject->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除评价项:{$params}");
	}// func
	//------------------------------------------------------------------------------------------
	// vip客户资料管理
	public function vipParam()
	{
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		//$this->smarty->assign('action', 'vipParam');
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_vip');
		$this->load->view('footer');
	}// func
	
	// 获取评价信息
	public function getVipParam()
	{
		$orgId = $_POST['orgId'];
		$this->db->where('V_addFwt', $orgId);
		$query = $this->db->get($this->_Mvip->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加评价信息
	public function addVipInfo()
	{
		$info = $_POST;
		$info['V_addtime'] = date('Y-m-d H:i:s');
		$this->db->insert($this->_Mvip->_tableName, $info);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加vip:".json_encode($info));
	}// func
	
	// 保存评价信息的修改
	public function saveVipInfo()
	{
		$info = $_POST;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$this->db->update($this->_Mvip->_tableName, $info, array('V_cardNo'=> $paramId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改vip:{$paramId}");
	}//func
	
	// 删除评价
	public function deleteVipInfo()
	{
		$params = $_POST['params'];
		$this->db->where("V_cardNo in ({$params})");
		$this->db->delete($this->_Mvip->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除vip:{$params}");
	}// func
	
	//------------------------------------------------------------------------------------------
	// 柜员资料管理
	public function serverParam()
	{
		//$this->smarty->assign('action', 'serverParam');
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,
		);
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_server',$data);
		$this->load->view('footer');
	}// func
	
	// 获取柜员信息
	public function getServerParam()
	{
		$orgId = $_POST['orgId'];
		$this->db->where('S_sysno', $orgId);
		$query = $this->db->get($this->_Mserver->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加柜员信息
	public function addServerInfo()
	{
		$url=$this->_baseUrl;
		$info = $_POST;
		$info['S_lrtime'] = date('Y-m-d H:i:s');
		// 将图片名称修改为柜员工号
		$filename = TMPPATH.'portrait/'.$this->_userid.'.jpg';
		$destname =  TMPPATH.'portrait/'.$info['S_no'].'.jpg';
		if (file_exists($destname)) unlink($destname);
		if (file_exists($filename))
		{
			rename($filename, $destname);
			$info['S_photoPath'] =$url.'/'. $destname;
		}// if
		$this->db->insert($this->_Mserver->_tableName, $info);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加柜员:".json_encode($info));

	}// func
	public function look(){
       $url=$this->_baseUrl; //http://192.168.10.51:8082/dx1
		$urlimg= $url."/".TMPPATH."portrait/"."02.jpg";


	}
	// 保存柜员信息的修改
	public function saveServerInfo()
	{
		$info = $_POST;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		// 将图片名称修改为柜员工号
		$filename = TMPPATH.'portrait/'.$this->_userid.'.jpg';
		$destname = TMPPATH.'portrait/'.$info['S_no'].'.jpg';
		if (file_exists($destname)) unlink($destname);
		if (file_exists($filename))
		{
			rename($filename, $destname);
			$info['S_photoPath'] = $destname;
		}// if
		$this->db->update($this->_Mserver->_tableName, $info, array('S_no'=> $paramId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改柜员信息:{$paramId}");
	}//func
	
	// 删除柜员
	public function deleteServerInfo()
	{
		$params = $_POST['params'];
		$this->db->where("S_no in ({$params})");
		$this->db->delete($this->_Mserver->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除柜员:{$params}");
	}// func
	
	//------------------------------------------------------------------------------------------
	// 柜台清单管理
	public function counterParam()
	{
		//$this->smarty->assign('action', 'counterParam');
		global $roleid;
		$retrolemenu=$this->_Mrolemenu->getRolemenu($roleid) ;
		global $language;
		global $itsOrgAr;
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'itsOrgAr'=>$itsOrgAr,
				'rolemenu'=>$retrolemenu,
				'language'=>$language,

		);
		$this->load->view('header',$data);
		$this->load->view('basedata/lefter',$data);
		$this->load->view('basedata/righter_counter',$data);
		$this->load->view('footer');
	}// func
	
	// 获取柜台信息
	public function getCounterParam()
	{
		$orgId = $_POST['orgId'];
		$this->db->where('C_sysno', $orgId);
		$query = $this->db->get($this->_Mcounter->_tableName);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 添加柜台信息
	public function addCounterInfo()
	{
		$info = $_POST;
		$info['C_islogin'] = 0;
		$info['C_lrtime'] = date('Y-m-d H:i:s');
		$info['C_lasttime'] = date('Y-m-d H:i:s');
		//print_r($info);exit;
		$this->db->insert($this->_Mcounter->_tableName, $info);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加柜台:".json_encode($info));
	}// func
	
	// 保存柜台信息的修改
	public function saveCounterInfo()
	{
		$info = $_POST;
		$info['C_lasttime'] = date('Y-m-d H:i:s');
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$orgId = $_POST['C_sysno'];
		unset($_POST['C_sysno']);
		$this->db->update($this->_Mcounter->_tableName, $info, array('C_sysno'=>$orgId, 'C_no'=> $paramId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改柜台信息:{$paramId}");
	}//func
	
	// 删除柜台
	public function deleteCounterInfo()
	{
		$params = $_POST['params'];
		$C_sysno = $_POST['C_sysno'];
		$this->db->where('C_sysno', $C_sysno);
		$this->db->where("C_no in ({$params})");
		$this->db->delete($this->_Mcounter->_tableName);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除柜台:{$params}");
	}// func
	
	// 接受上传的员工照片
	public function uploadStaffPic(){
		// 构造封面保存位置
		$destPath = TMPPATH.'portrait/';
		if (!file_exists($destPath)) mkdir($destPath, 0777);
		$fileName = $this->_userid;
		uploadFile($destPath, $fileName, 'pic');
		echo TMPPATH.'portrait/'.$this->_userid.'.jpg';
	}// func
	
	// 获取柜员信息
	public function getServerInfo(){
		$sno = $_POST['sno'];
		$this->db->where('S_no', $sno);
		$query = $this->db->get($this->_Mserver->_tableName);
		$ret = $query->row_array();
		echo json_encode($ret);
	}// func
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
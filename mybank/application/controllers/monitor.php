<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Monitor extends CI_Controller {
	var $_userid;
	var $_roleId;
	var $_authJgStr;
	
	function __construct()
	{
		parent::__construct();

		$this->load->language(['header']);
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
		$this->load->model('Queue', '_Mqueue');
		$this->load->model('Markdate', '_Mmarkdate');
		$this->load->model('Hqueuedate', '_Mhqueuedate');
		$this->load->model('Hqueue', '_Mhqueue');
		$this->load->model('Serial', '_Mserial');
		$this->load->model('Markhist', '_Mmarkhist');
		$this->load->model('Pfproject', '_Mpfproject');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('UserAccessjg', '_UserAccessJG');
		$this->load->model('Sysserial', '_Msysserial');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
		
		$this->load->model('Server', '_Mserver');
		$this->load->model('Counter', '_Mcounter');
		$this->load->model('authority/Rolename','_Mrolename');

		$this->load->model('Language','_Mlanguage');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);

		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);

		global $language;
		global $roleid;
		global $sys_orgId;
		$roleid=$this->_roleId;
		$language=$this->_Mlanguage->getstr();
		
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('FusionCharts');
		
		// 加载语言包
		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);
		load_lang('COMMON', $this->smarty, $this);
		load_lang('MONITOR', $this->smarty, $this);

		// 控制器类型
		$this->smarty->assign('control', 'monitor');
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);

		// 获取用户有权限查看的机构代号
		if ($this->_admin == 'admin') $this->_authJgStr = $this->_Morgrizetree->getAllOrg();
		else $this->_authJgStr = $this->_UserAccessJG->getOrgByUid($this->_userid);

		$orgTree = $this->_Morgrizetree->getOrgTree($this->_authJgStr);
		$this->_orgTreeStr = generateOrgTree($orgTree, 'getOrgDetail', false);
		$this->smarty->assign('orgTreeStr', $this->_orgTreeStr);

		if (isset($_GET['orgId'])) $sys_orgId=$_GET['orgId'];
		else $sys_orgId= findFirstNoe($orgTree);
		 //默认显示第一个子节点

		$this->_currDate = date('Y-m-d');

		global $fcodeArr;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		$this->smarty->assign('fcodeArr', $fcodeArr);
		global $arr;
		$arr=array(
			'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'roleId'=>$this->_roleId,
				'sys_orgId'=>$sys_orgId,

		);

/*
		$this->config->set_item('language','eg');
		echo $this->config->item('language');
*/


		//$this->_currDate = '2013-05-14';
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
		$this->smarty->assign('action', 'report');
		//$this->smarty->display('header.html');
		$this->load->view('header',$data);
		$this->load->view('monitor/lefter',$data);
		$this->load->view('monitor/righter_tab');
		$this->load->view('monitor/righter_content');
		$this->load->view('monitor/righter_message');
		$this->load->view('footer');
		/*
		$this->smarty->display('monitor/lefter.html');
		$this->smarty->display('monitor/righter_tab.html');
		$this->smarty->display('monitor/righter_content.html');
		$this->smarty->display('monitor/righter_message.html');
		$this->smarty->display('footer.html');
		*/
	}// func
	
	public function map()
	{	
		$this->smarty->assign('action', 'map');
		$query = $this->db->query('select username from Sys_user');
		$ret = $query->result_array();//得到的是数组
  	    $this->smarty->assign("ret",$ret);
		$this->smarty->display('header');
		$this->smarty->display('monitor/lefter');
		$this->smarty->display('monitor/map');
		$this->smarty->display('footer');
	}// func
	
	// 获取机构基本信息
	public function getOrgInfo()
	{
		$orgId = $_POST['orgId'];
		$query = $this->db->query("select a.*, b.JG_name as pname from Sys_orgrizeTree a left join Sys_orgrizeTree b on a.JG_PID=b.JG_ID where a.JG_ID={$orgId}");
		$ret = $query->row_array();
		echo json_encode($ret);
	}// func
	
	// 获取业务办理数据
	// 柜台办理数据
	public function getBarInfo()
	{
		//$_POST['orgId'] = '010101';
		$orgId = $_POST['orgId'];
		
		// 查询此网点当前已登录柜台
		$query = $this->db->query("select a.C_no, a.C_loginTime, b.S_star, b.S_name from {$this->_Mcounter->_tableName} a left join {$this->_Mserver->_tableName} b on a.C_sno=b.S_no where a.C_sysno='{$orgId}' and C_islogin=1 and C_loginTime>='{$this->_currDate} 00:00:00' and C_loginTime<='{$this->_currDate} 23:59:59'");
		$ret = $query->result_array();
		
		//echo '<pre>';
		//print_r($ret);exit;
		
		$barInfoArr = array();
		foreach ($ret as $row)
		{
			$query = $this->db->query("select Q_cno, Q_serialname, sum(Q_zywl) as totle_zywl, sum(Q_ztime) as total_ztime from HQUEUEDATE where Q_date>='{$this->_currDate}' and Q_sysno='{$orgId}'  and Q_cno='{$row['C_no']}' group by Q_cno, Q_serialname");
			$ret2 = $query->result_array();
			if(empty($ret2)){
				$ret2 = array( 
							0 => array(
								'Q_cno' => $row['C_no'],
								'Q_serialname' => '',
								'totle_zywl' => 0,
								'total_ztime' => 0,
							)
						);
			}
			foreach($ret2 as $gyInfo){
				$barInfoArr[$gyInfo['Q_cno']]['bus'][] = array(
						'name' => $gyInfo['Q_serialname'],
						'cnt' => isset($gyInfo['totle_zywl'])?$gyInfo['totle_zywl']:0
						);
				
				if (!isset($barInfoArr[$gyInfo['Q_cno']]['ztime'])) $barInfoArr[$gyInfo['Q_cno']]['ztime'] = 0;
				if (!isset($barInfoArr[$gyInfo['Q_cno']]['zywl'])) $barInfoArr[$gyInfo['Q_cno']]['zywl'] = 0;
				$barInfoArr[$gyInfo['Q_cno']]['ztime'] += isset($gyInfo['total_ztime'])?$gyInfo['total_ztime']:0;
				$barInfoArr[$gyInfo['Q_cno']]['zywl'] += isset($gyInfo['totle_zywl'])?$gyInfo['totle_zywl']:0;
				
			}
			$barInfoArr[$row['C_no']]['S_name'] = $row['S_name'];
			$barInfoArr[$row['C_no']]['S_star'] = $row['S_star']*20;
			$barInfoArr[$row['C_no']]['C_loginTime'] = $row['C_loginTime'];
			$barInfoArr[$row['C_no']]['avgtm'] = @round($barInfoArr[$row['C_no']]['ztime']/$barInfoArr[$row['C_no']]['zywl']);
		}// for
		
		//echo '<pre>';
		//print_r($barInfoArr);exit;
		
		echo json_encode($barInfoArr);
	}// func
	
	// 获取实时等待数据
	public function getWaitInfo()
	{
		$waitInfo = array();
		$orgId = $_POST['orgId'];
		//$orgId = '010101';
		// 找出等待人数
		$query = $this->db->query("select count(*) as cnt from {$this->_Mqueue->_tableName} where Q_sysno='{$orgId}' and Q_cometime>='{$this->_currDate}'");
		$ret = $query->row_array();
		$waitInfo['Q_serialname'] = $this->MONITOR_RIGHTER_WAIT_CURR_NUMBER;//当前等候人数
		$waitInfo['cnt'] = $ret['cnt'];
		// 找出各个业务的等待人数
		$query = $this->db->query("select Q_serialname, count(*) as cnt from {$this->_Mqueue->_tableName} where Q_sysno='{$orgId}' and Q_cometime>='{$this->_currDate}' group by Q_serialname");
		$ret = $query->result_array();
		array_unshift($ret, $waitInfo);
		echo json_encode($ret);
	}// func
	
	// 获取最长等候号码
	public function getMaxWaitNum()
	{
		//$_POST['orgId'] = '010101';
		$orgId = 010101;
		$query = $this->db->query("select Q_number, Q_serialname from {$this->_Mqueue->_tableName} where Q_sysno='{$orgId}' and Q_cometime >= '{$this->_currDate}'");
		$ret = $query->result_array();
		$info = array();
		$info['maxWait'] = 0;
		$info['number'] = '';
		$info['serialname'] = '';
		foreach ($ret as $row)
		{
			if ($row['tm'] > $info['maxWait']) 
			{
				$info['maxWait'] = $row['tm'];
				$info['number'] = $row['Q_number'];
				$info['serialname'] = $row['Q_serialname'];
			}// if
		}// for
		
		$this->db->where('S_serialname', $info['serialname']);
		$query = $this->db->get($this->_Mserial->_tableName);
		$ret = $query->row_array();
		if(!empty($ret)){
			if ($info['maxWait'] > $ret['S_mintime'] && $ret['S_mintime']) $info['isover'] = 1;
			else $info['isover'] = 0;
		}
		echo json_encode($info);
	}// func
	
	// 获取预警信息
	public function getWarnInfo()
	{

		//$_POST['orgId'] = '0201';
		$orgId = $_POST['orgId'];
		// 获取网点预警清单
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$row = $query->row_array();
		
		// 获取网点的预警信息
		$warnInfos = array();

		if(!empty($row)){
			// 获取网点的等待人数
			$info = array();
			$this->db->where("Q_cometime >= '{$this->_currDate}'");
			$this->db->where('Q_sysno', $orgId);
			$query = $this->db->get($this->_Mqueue->_tableName);
			$waitCnt = $query->num_rows();
			if ($waitCnt >= $row['sysWaitMax3'] and $waitCnt < $row['SysBlCsMax2']) $level = 3;
			else if ($waitCnt >= $row['sysWaitMax2'] && $waitCnt < $row['sysWaitMax1']) $level = 2;
			else if ($waitCnt >= $row['sysWaitMax1'] && $row['sysWaitMax1']) $level = 1;
			else $level = 0;
			$info['cnt'] = $waitCnt?$waitCnt:0;
			$info['level'] = $level;
			$info['title'] ="排队等待人数" ;//排队等待人数
			$warnInfos[] = $info;
			// 获取网点的评价不满意数量
			$info = array();
			// 不满意键值
			$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
			$pjProArr = $query->result_array();
			$selectArr = array();

        foreach ($pjProArr as $item)
        {
            $key = "M_k{$item['PJ_ID']}num";
            if ($item['PJ_WARNNING']) $selectArr[] = "{$key}";
        }// for
        $selectStr = implode('+', $selectArr);
        //echo $selectStr;exit;
        $query = $this->db->query("select sum({$selectStr}) as cnt from {$this->_Mmarkdate->_tableName} where M_sysno='{$orgId}' and M_date >= '{$this->_currDate}'");
        $pjhcCnt = $query->row_array();
        if ($pjhcCnt['cnt'] >= $row['SysPjhcMax3'] && $pjhcCnt['cnt'] < $row['SysPjhcMax2']) $level = 3;
        else if ($pjhcCnt['cnt'] >= $row['SysPjhcMax2'] && $pjhcCnt['cnt'] < $row['SysPjhcMax1']) $level = 2;
        else if ($pjhcCnt['cnt'] >= $row['SysPjhcMax1'] && $row['SysPjhcMax1']) $level = 1;
        else $level = 0;

        $info['cnt'] = $pjhcCnt['cnt']?$pjhcCnt['cnt']:0;
        $info['level'] = $level;
        $info['title'] = "评价不满意数量";//评价不满意数量
        $warnInfos[] = $info;
        // 获取网点的业务受理超时数量
        $info = array();
       $query = $this->db->query("select sum(Q_csywl) as cnt from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$orgId}' and Q_date >= '{$this->_currDate}'");
        $cnt = $query->row_array();

        if ($cnt['cnt'] >= $row['SysBlCsMax3'] && $cnt['cnt'] < $row['SysBlCsMax2']) $level = 3;
        else if ($cnt['cnt'] >= $row['SysBlCsMax2'] && $cnt['cnt'] < $row['SysBlCsMax1']) $level = 2;
        else if ($cnt['cnt'] >= $row['SysBlCsMax1'] && $row['SysBlCsMax1']) $level = 1;
        else $level = 0;

        $info['cnt'] = $cnt['cnt']?$cnt['cnt']:0;
        $info['level'] = $level;
        $info['title'] = "受理业务超时数量";//受理业务超时数量
        $warnInfos[] = $info;
        // 获取网点的排队等待超时数量
       // $query = $this->db->query("select count(*) as cnt from {$this->_Mqueue->_tableName} a left join {$this->_Mserial->_tableName} b on a.Q_serialname=b.S_serialname where datediff(second, a.Q_cometime, getdate())>=b.S_mintime and a.Q_cometime >= '{$this->_currDate}' and Q_sysno='{$orgId}'");
        $cnt = $query->row_array();

        if ($cnt['cnt'] >= $row['SysWaitCsMax3'] && $cnt['cnt'] < $row['SysWaitCsMax2']) $level = 3;
        else if ($cnt['cnt'] >= $row['SysWaitCsMax2'] && $cnt['cnt'] < $row['SysWaitCsMax1']) $level = 2;
        else if ($cnt['cnt'] >= $row['SysWaitCsMax1'] && $row['SysWaitCsMax1']) $level = 1;
        else $level = 0;
        $info['cnt'] = $cnt['cnt']?$cnt['cnt']:0;
        $info['level'] = $level;
        $info['title'] = "排队等待超时数量";//排队等待超时数量
        $warnInfos[] = $info;
    }

    //echo '<pre>';
    //print_r($warnInfos);exit;

    echo json_encode($warnInfos);

	}// func

	
	// 获取营业厅清单列表
	public function getSystemList()
	{
		$query = $this->db->get($this->_Msystem->_tableName);
		$ret = $query->result_array();
		
		echo json_encode($ret);
	}// func
	
	// 等待排队人流量监控清单
	public function getWaitMaxList()
	{
		// 找出每个网点的设置
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$ret = $query->result_array();
		foreach ($ret as $key => $row)
		{
			// 找出每个网点的排队数量
			$this->db->where('Q_sysno', $row['sysno']);
			$this->db->where("Q_cometime >= '{$this->_currDate}'");
			$query = $this->db->get($this->_Mqueue->_tableName);
			$waitCnt = $query->num_rows();
			if ($waitCnt >= $row['sysWaitMax3'] && $waitCnt < $row['sysWaitMax2']) $ret[$key]['level'] = 3;
			else if ($waitCnt >= $row['sysWaitMax2'] && $waitCnt < $row['sysWaitMax1']) $ret[$key]['level'] = 2;
			else if ($waitCnt >= $row['sysWaitMax1']) $ret[$key]['level'] = 1;
			else $ret[$key]['level'] = 0;
			
			$ret[$key]['cnt'] = $waitCnt;
		}// func
		
		echo json_encode($ret);
	}// func
	
	// 评价很差数量监控清单
	public function getPjhcMaxList()
	{
		// 不满意键值
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$selectArr = array();
		foreach ($pjProArr as $item)
		{
			$key = "M_k{$item['PJ_ID']}num";
			if ($item['PJ_WARNNING']) $selectArr[] = "{$key}";
		}// for
		$selectStr = implode('+', $selectArr);
		
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$ret = $query->result_array();
		
		foreach ($ret as $key=>$row)
		{
			$query = $this->db->query("select sum({$selectStr}) as cnt from {$this->_Mmarkdate->_tableName} where M_sysno='{$row['sysno']}' and M_date >= '{$this->_currDate}'");
			$pjhcCnt = $query->row_array();
			if ($pjhcCnt['cnt'] >= $row['SysPjhcMax3'] && $pjhcCnt['cnt'] < $row['SysPjhcMax2']) $ret[$key]['level'] = 3;
			else if ($pjhcCnt['cnt'] >= $row['SysPjhcMax2'] && $pjhcCnt['cnt'] < $row['SysPjhcMax1']) $ret[$key]['level'] = 2;
			else if ($pjhcCnt['cnt'] >= $row['SysPjhcMax1']) $ret[$key]['level'] = 1;
			else $ret[$key]['level'] = 0;
			
			$ret[$key]['cnt'] = $pjhcCnt['cnt'];
		}// for
		echo json_encode($ret);
	}// func
	
	// 排队等待超时数量监控清单
	public function getWaitCsMaxList()
	{		
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$ret = $query->result_array();
		foreach ($ret as $key=>$row)
		{
			// 计算网点等待超时人数
			$query = $this->db->query("select sum(Q_wcsywl) as cnt from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$row['sysno']}' and Q_date >= '{$this->_currDate}'");
			$waitcsCnt = $query->row_array();
			if ($waitcsCnt['cnt'] >= $row['SysWaitCsMax3'] && $waitcsCnt < $row['SysWaitCsMax2']) $ret[$key]['level'] = 3;
			else if ($waitcsCnt['cnt'] >= $row['SysWaitCsMax2'] && $waitcsCnt < $row['SysWaitCsMax1']) $ret[$key]['level'] = 2;
			else if ($waitcsCnt['cnt'] >= $row['SysWaitCsMax1']) $ret[$key]['level'] = 1;
			else $ret[$key]['level'] = 0;
			
			$ret[$key]['cnt'] = $waitcsCnt['cnt'];
		}// for
		echo json_encode($ret);
	}// func
	
	// 排队受理超时数量监控清单
	public function getBlCsMaxList()
	{		
		$this->db->where("sysno in ({$this->_authJgStr})");
		$query = $this->db->get($this->_Msystem->_tableName);
		$ret = $query->result_array();
		foreach ($ret as $key=>$row)
		{
			// 计算网点办理超时笔数
			$query = $this->db->query("select sum(Q_csywl) as cnt from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$row['sysno']}' and Q_date >= '{$this->_currDate}'");
			$blcsCnt = $query->row_array();
			
			if ($blcsCnt['cnt'] < $row['SysBlCsMax3']) $ret[$key]['level'] = 0;
			else if ($blcsCnt['cnt'] >= $row['SysBlCsMax3'] && $blcsCnt < $row['SysBlCsMax2']) $ret[$key]['level'] = 3;
			else if ($blcsCnt['cnt'] >= $row['SysBlCsMax2'] && $blcsCnt < $row['SysBlCsMax1']) $ret[$key]['level'] = 2;
			else $ret[$key]['level'] = 1;
			
			$ret[$key]['cnt'] = $blcsCnt['cnt'];
		}// for
		echo json_encode($ret);
	}// func
	
	// 获取当天业务办理数据
	// 获取当天业务办理数据
	public function getCurrDateBusList()
	{
		//$_POST['orgId'] = '010101';
		$orgId = $_POST['orgId'];
		$query = $this->db->query("select Q_serialname as Qs_serialname, sum(Q_zywl) as zywl from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$orgId}' and Q_date>='{$this->_currDate}' group by Q_serialname");
		$ret = $query->result_array();
		$theadArr = array();
		$tbodyArr = array();
		$theadArr[] = "当前时间";//当前时间
		$tbodyArr[] = $this->_currDate;
		
		if (!count($ret))
		{
			$query = $this->db->query("select Qs_serialname, 0 as zywl from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$ret = $query->result_array();
			
			if (!count($ret))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
			
				$parts = explode(',', $sysInfo['sysYWtime']);
				foreach ($parts as $row)
				{
					$ret[] = array('Qs_serialname' => $row, 'zywl'=>0);
				}//
			}// if
		}// if
		
		
		
		foreach ($ret as $row)
		{
			$theadArr[] = trimEnword($row['Qs_serialname']);
			$tbodyArr[] = $row['zywl'];
		}// for		
		
		echo json_encode(array('thead'=>$theadArr, 'tbody'=>$tbodyArr));
	}// func
	
	// 获取当天图表数据
	public function getCurrDateBusChart()
	{
		//$_POST['orgId'] = '1001';
		$orgId = 9;
		
		$hourArray = array('08', '09', '10', '11', '12','13', '14', '15', '16', '17','18', '19', '20', '21', '22','23');
		$hourStr = implode(',', $hourArray);
		$query = $this->db->query("select Qs_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
		$ret = $query->result_array();
		if (!count($ret))
		{
			// 从sys_system中获取业务信息
			$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
			$sysInfo = $query->row_array();
	
			if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime']) 
			{
				$sysInfo = array('sysYWtime' => '-');
			}
			
			$parts = explode(',', $sysInfo['sysYWtime']);
			foreach ($parts as $row)
			{
				$ret[] = array('Qs_serialname' => $row);
			}//
		}// if
		$flowArr = array();
		foreach ($hourArray as $hour)
		{
			foreach ($ret as $row)
			{
				$flowArr[$hour][$row['Qs_serialname']] = '';
			}//
		}//
		$query_str = "select Q_serialname, COUNT(*) zywl from {$this->_Mhqueue->_tableName} where (Q_sysno='{$orgId}')and(Q_status=2) and Q_servertime>='{$this->_currDate}'  in ({$hourStr}) group by  Q_serialname";
		$query = $this->db->query($query_str);
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			if (strlen($row['hour']) > 1)
				$flowArr[$row['hour']][$row['Q_serialname']] = $row['zywl'];
			else
				$flowArr['0'.$row['hour']][$row['Q_serialname']] = $row['zywl'];
		}// func
		
		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
		}// for
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		$serial = array();
		$strCat = "<categories>";
		foreach ($flowArr as $key=>$val)
		{
			$strCat .= "<category label='" . $key . "'/>";
			foreach ($val as $key1=>$val1)
			{
				$serial[$key1][] = $val1;
			}// for
		}// for
		$strCat .= "</categories>";
		foreach ($serial as $key=>$val)
		{
			$strCat .= "<dataset seriesName='{$key}' >";
			foreach ($val as $item)
			{
				$strCat .= "<set value='" . $item . "'/>";
			}// for
			$strCat .= "</dataset>";
		}// for
		$strYearXML  = "<chart baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='当天各业务分时流量统计' XAxisName='小时' palette='2' animation='1' subcaption='' formatNumberScale='0' numbersuffix='笔' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		$chartStr = renderChart("assets/FusionCharts/MSColumn3D.swf?ChartNoDataText=nodata", "",$strYearXML,"SalesByCurDate_".$orgId, '100%', 405, false, true);
		//echo $chartStr;exit;
		echo json_encode(array('chartStr' => $chartStr));
	}// func
	
	// 获取最近本周业务数据
	public function getWeekDateBusList()
	{
		//获取本周第一天/最后一天的时间
		$firstday = date('Y-m-d', time()-86400*date('w')+(date('w')>0?86400:-6*86400));
		$lastday = date('Y-m-d', strtotime($firstday)+86400*6);
	
		//$_POST['orgId'] = '010101';
		$orgId = $_POST['orgId'];
		
		$theadArr = array();
		$tbodyArr = array();
		$theadArr[] = $this->MONITOR_RIGHTER_CURR_TIME;//当前时间
		
		$query = $this->db->query("select Qs_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
		$ret = $query->result_array();
		if (!count($ret))
		{
			// 从sys_system中获取业务信息
			$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
			$sysInfo = $query->row_array();
		
			if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
			{
				$sysInfo = array('sysYWtime' => '-');
			}
				
			$parts = explode(',', $sysInfo['sysYWtime']);
			foreach ($parts as $row)
			{
				$ret[] = array('Qs_serialname' => $row);
			}//
		}// if
		
		$flowArr = array();
		for ($i=0;$i<8;$i++)
		{
			$tmpDay = date('Y-m-d', strtotime($firstday)+84600*$i);
			foreach ($ret as $row)
			{
				$flowArr[$tmpDay][$row['Qs_serialname']] = 0;
			}
		}//
		
		$query = $this->db->query("select convert(varchar(10),Q_date,120) as day, Q_serialname, sum(Q_zywl) as zywl from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$orgId}' and Q_date>='{$firstday}' and Q_date<='{$lastday} 23:00:00' group by Q_serialname, convert(varchar(10),Q_date,120)");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			$flowArr[$row['day']][$row['Q_serialname']] = $row['zywl'];
			//$theadArr[] = $row['Q_serialname'];
		}// for
		
		foreach ($flowArr as $key=>$val)
		{
			$tbodyArr[$key][] = $key;
			foreach ($val as $key1=>$item){
				$tbodyArr[$key][] = $item;
				if(!in_array(trimEnword($key1), $theadArr)){
					$theadArr[] = trimEnword($key1);
				}
			}// for
		}// for
		
		//echo '<pre>';
		//print_r($tbodyArr);exit;
		
		echo json_encode(array('thead'=>$theadArr, 'tbody'=>$tbodyArr));
		
	}// func
	
	// 获取最近本周图表数据
	public function getWeekDateBusChart()
	{
		//获取本周第一天/最后一天的时间戳
		$firstday = date('Y-m-d', time()-86400*date('w')+(date('w')>0?86400:-6*86400));
		$lastday = date('Y-m-d', strtotime($firstday)+86400*6);
		
		// 获取该网点的业务数据
		//$_POST['orgId'] = '1001';
		$orgId = $_POST['orgId'];
		$query = $this->db->query("select Qs_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
		$ret = $query->result_array();
		if (!count($ret))
		{
			// 从sys_system中获取业务信息
			$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
			$sysInfo = $query->row_array();
	
			if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime']) 
			{
				$sysInfo = array('sysYWtime' => '-');
			}
			
			$parts = explode(',', $sysInfo['sysYWtime']);
			foreach ($parts as $row)
			{
				$ret[] = array('Qs_serialname' => $row);
			}//
		}// if
		
		$flowArr = array();
		for ($i=0;$i<8;$i++)
		{
			$tmpDay = date('Y-m-d', strtotime($firstday)+84600*$i);
			foreach ($ret as $row)
			{
				$flowArr[$tmpDay][$row['Qs_serialname']] = 0;
			}
		}//
		
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		//$orgId = $_POST['orgId'];
		$query = $this->db->query("select convert(varchar(10),Q_date,120) as day, Q_serialname, sum(Q_zywl) as zywl from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$orgId}' and Q_date>='{$firstday}' and Q_date<='{$lastday} 23:00:00' group by Q_serialname, convert(varchar(10),Q_date,120)");
		$ret = $query->result_array();
		//$flowArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['day']][$row['Q_serialname']] = $row['zywl'];
		}// func
		
		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
		}// for
		
		//echo '<pre>';
		//print_r($flowArr);exit;		
		$serial = array();
		$strCat = "<categories>";
		foreach ($flowArr as $key=>$val)
		{
			$strCat .= "<category label='" . $key . "'/>";
			foreach ($val as $key1=>$val1)
			{
				$serial[$key1][] = $val1;
			}// for
		}// for
		$strCat .= "</categories>";
		foreach ($serial as $key=>$val)
		{
			$strCat .= "<dataset seriesName='{$key}' >";
			foreach ($val as $item)
			{
				$strCat .= "<set value='" . $item . "'/>";
			}// for
			$strCat .= "</dataset>";
		}// for
		$strYearXML  = "<chart baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->MONITOR_RIGHTER_STAT_ALL_BUS_WEEK}' XAxisName='{$this->COMMON_DAY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numbersuffix='{$this->COMMON_BI}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		$chartStr = renderChart("assets/FusionCharts/FCF_MSSpline.swf?ChartNoDataText=nodata", "",$strYearXML,"SalesByWeek_".$orgId, '100%', 405, false, true);
		//echo $chartStr;exit;
		echo json_encode(array('chartStr' => $chartStr));
		
		//echo generateChartData($flowArr);
	}// func
	
	// 获取平均值
	public function getAvgInfo()
	{
		$orgId = $_POST['orgId'];
		//$orgId = '010101';
		
		$query = $this->db->query("select sum(Q_ztime)/sum(Q_zywl) as avg_ztime, sum(Q_wtime)/sum(Q_zywl) as avg_wtime from {$this->_Mhqueuedate->_tableName} where Q_sysno='{$orgId}' and Q_date>='{$this->_currDate}'");
		$ret = $query->row_array();
		
		foreach ($ret as $key=>$val)
		{
			$ret[$key] = $val?$val:0;
		}// for
		
		echo json_encode($ret);
	}// func
	
	// 导出网点地图监控数据
	public function exportMapData(){
		// 找出登录用户有权限的全部网点
		$sql = "select b.*, c.JG_name as pname, a.sysJd, a.sysWd from {$this->_Msystem->_tableName} a left join {$this->_Morgrizetree->_tableName} b on a.sysno=b.JG_ID left join {$this->_Morgrizetree->_tableName} c on b.JG_PID=c.JG_ID where b.JG_PID in ({$this->_authJgStr})";
		$query = $this->db->query($sql);
		$ret = $query->result_array();
		
		// 计算每个网点的排队人数,已处理业务量,平均办理时间
		$jgArr = array();
		foreach ($ret as $row){
			$jgArr[$row['JG_ID']] = array(
					'wd_id' => $row['JG_ID'],
					'wd_name' => $row['JG_name'],
					'pid' => $row['JG_PID'],
					'pname' => $row['pname']
					);
			
			$jgArr[$row['JG_ID']]['lot'] = isset($row['sysJd'])?$row['sysJd'] : '';
			$jgArr[$row['JG_ID']]['lat'] = isset($row['sysWd'])?$row['sysWd'] : '';
			// 计算排队人数
			$this->db->where('Q_sysno', $row['JG_ID']);
			$this->db->where("Q_cometime >= '{$this->_currDate}'");
			$query = $this->db->get($this->_Mqueue->_tableName);
			$waitCnt = $query->num_rows();
			$jgArr[$row['JG_ID']]['waitcnt'] = $waitCnt;
			// 计算已处理业务量
			$query = $this->db->query("select sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno = {$row['JG_ID']} and Q_date >= '{$this->_currDate}'");
			$ret = $query->row_array();
			if (count($ret) && $ret['total_yw'] > 0) $jgArr[$row['JG_ID']]['total_yw'] = $ret['total_yw'];
			else $jgArr[$row['JG_ID']]['total_yw'] = 0; 
			// 计算平均办理时间
			if (count($ret) && $ret['total_tm'] > 0) $jgArr[$row['JG_ID']]['total_tm'] = @round($ret['total_tm']/$ret['total_yw'], 1);
			else $jgArr[$row['JG_ID']]['total_tm'] = 0; 
		}// for
		
		foreach ($jgArr as $row){
			echo implode('|', $row)."\r\n";
		}// func
		
		// 写到临时文件
		/*
		$filename = 'jgMapData.txt';
		$tmpname = 'jgMapData.txt.tmp';
		if (file_exists($tmpname)) unlink($tmpname);	// 删除临时文件
		if (!file_exists($filename)) fopen($filename, "w+");
		foreach ($jgArr as $row){
			file_put_contents($tmpname, implode('|', $row)."\r\n", FILE_APPEND);
		}// func
		if (file_exists($filename)) unlink($filename);
		rename($tmpname, $filename);
		*/
	}// func
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

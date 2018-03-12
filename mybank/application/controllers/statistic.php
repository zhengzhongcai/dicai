<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Statistic extends CI_Controller {
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
		$this->load->model('statistic/Hqueuedate', '_Mhqueuedate');
		$this->load->model('System', '_Msystem');
		$this->load->model('Markdate', '_Mmarkdate');
		$this->load->model('Server', '_Mserver');
		$this->load->model('Pfproject', '_Mpfproject');
		$this->load->model('UserAccessjg', '_UserAccessJG');
		$this->load->model('Sysserial', '_Msysserial');		
		$this->load->model('Rolefunc', '_Mrolefunc');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');

		$this->load->model('Language','_Mlanguage');

		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);

		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		
		$this->_statList = $this->config->item('stat_list');
		
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('FusionCharts');
		
		// 加载语言包
		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);

		load_lang('COMMON', $this->smarty, $this);
		load_lang('STAT', $this->smarty, $this);
		lang_list($this->smarty);
		
		// 控制器类型
		$this->smarty->assign('control', 'statistic');
		
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $fcodeArr;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		$this->smarty->assign('fcodeArr', $fcodeArr);
		global $arr;
		global $language;
		global $roleid;
		$roleid=$this->_roleId;
		$language=$this->_Mlanguage->getstr();
      //加载语言
		$flanguage=$this->_Mlanguage->getvstr();
		//$this->config->set_item('language',$flanguage[0]['visit']);
		$this->config->set_item('language',$flanguage[0]['visit']);
		$this->load->language(['footer','auth','common']);
		
		// 获取用户有权限查看的机构代号
		if ($this->_admin == 'admin') $this->_authJgStr = $this->_Morgrizetree->getAllOrg();
		else $this->_authJgStr = $this->_UserAccessJG->getOrgByUid($this->_userid);
		
		$this->_orgTree = $this->_Morgrizetree->getOrgTree($this->_authJgStr);
		$this->_orgTreeStr = generateOrgTree($this->_orgTree, 'getOrgStat');
		//$this->smarty->assign('orgTreeStr', $this->_orgTreeStr);
		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'orgtree'=>$this->_orgTreeStr,
			'timeControl'=> getDayTypeSelect($this),
				'roleId'=>$this->_roleId,

		);


		// 总业务数组
		$query = $this->db->get('Sys_serial');
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			$this->_serials[] = $row['S_serialname'];
		}// for
		
		//$this->_getNotDisplaySerial('0201');	
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

		$this->smarty->assign('listNum', 9999);
		$this->load->view('header',$data);
		$this->load->view('statistic/lefter',$data);
		$this->load->view('statistic/righter_list',$data);
		$this->load->view('statistic/righter_table');
		$this->load->view('footer.php');
		/*
		$this->smarty->display('header.html');
		$this->smarty->display('statistic/lefter.html');
		$this->smarty->display('statistic/righter_list.html');
		$this->smarty->display('statistic/righter_table.html');
		$this->smarty->display('footer.html');
		*/




	}// func
	
	// 根据查询时间类型获取时间控件
	public function getTimeControl()
	{
		$type = $_POST['type'];
		switch($type)
		{
			case 'day':
				echo getDayTypeSelect($this);
				break;
			case 'month':
				echo getMonthTypeSelect($this);
				break;
			case 'season':
				echo getSeasonTypeSelect($this);
				break;
			case 'year':
				echo getYearTypeSelect($this);
				break;
		}// switch
	}// func
	
	// 获取机构基本信息
	public function getOrgInfo()
	{
		$orgId = $_POST['orgId'];
		// 检查是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->result_array();
		
		$query = $this->db->query("select a.*, b.JG_name as pname from Sys_orgrizeTree a left join Sys_orgrizeTree b on a.JG_PID=b.JG_ID where a.JG_ID='{$orgId}'");
		$ret = $query->row_array();
		if (count($spot)) $ret['isspot'] = 1;
		else $ret['isspot'] = 0;
		echo json_encode($ret);
	}// func
	
	// 0业务流量统计
	public function busFlow()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '1001';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-19';
		*/
		
		//echo '<pre>';
		//print_r($_POST);exit;
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
					"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
		}// for

		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();

			if (!count($serials))
			{

				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
				
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{	
					$sysInfo = array('sysYWtime' => '');
				}
				else 
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();

		}
		if (!count($serials)) $flowArr = array();
		foreach ($serials as $row)//$row（ [S_serialname] => 储蓄业务(Savings business)）
		{
			foreach ($flowArr as $key=>$val)//$val=array([机构代号]=>1001 [结构名称]=>武侯新城支行)$key=1001
			{
		 $flowArr[$key][$row['S_serialname']."({$this->COMMON_BI})"] = 0 ;//找出对应的显示项目（机构代号，机构名称，相关业务名称）

			}// for

		}// for

		// 设置总量
		foreach ($flowArr as $key=>$val)
		{
		//	$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = 0;//业务总量(笔)
		}// for
	 //$this->_authJgStr('0','01','0101','1001','1202','1802','2008','2907')
		$query = $this->db->query("select Q_sysno, Q_serialname, sum(Q_zywl) as total_yw from {$this->_Mhqueuedate->_tableName} where Q_sysno=1001 and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_serialname");
		//$ret = $query->result_array();
		 //$query = $this->db->query("select Q_sysno, Q_serialname, Q_zywl   from {$this->_Mhqueuedate->_tableName} where Q_sysno=2907 and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_serialname");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_serialname']."({$this->COMMON_BI})"])) $flowArr[$row['Q_sysno']][$row['Q_serialname']."({$this->COMMON_BI})"] = $row['total_yw'];

}// for
		// 取消那些没有业务的数据和计算总量
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			$i = 0;
			$totalBus = 0;
			foreach ($val as $key1=>$val1)
			{
				$i++;
				if ($i<3)continue;
				$parts = explode('(', $key1);
				if (isset($notDisplayArr[$parts[0]])) $flowArr[$key][$key1] = $notDisplayArr[$parts[0]];
				else $totalBus += $val1;
			}// 
			//$flowArr[$key]['业务总量(笔)'] = $totalBus;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = $totalBus;
		}// for
		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
			//$tmp = $flowArr[$key]['业务总量'];
			$tmp = $flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"];
			//unset($flowArr[$key]['业务总量']);
			unset($flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"]);
			//$flowArr[$key]['业务总量'] = $tmp;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"] = $tmp;
		}// for

		//echo '<pre>';
		//print_r($flowArr);exit;
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '业务量统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, "{$this->STAT_RIGHTER_SERVER_BUS_STAT}");
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr);
		//print_r($_POST);
		//exit;
		// 找出总行信息

		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID='{$orgId}'");
		$orgInfo = $query->row_array();
		// 找出总行数据
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		$query = $this->db->query("select Q_serialname, sum(Q_zywl) as total_yw from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_serialname");
		$ret = $query->result_array();

		// $total = array('机构代码'=>'总计', '机构名称'=>$orgInfo['JG_name']);
		// foreach ($serials as $row)
		// {
			// $total[$row['S_serialname'].'(笔)'] = 0;
		// }// for
		// foreach ($ret as $row)
		// {
			// $total[$row['Q_serialname'].'(笔)'] = $row['total_yw'];
		// }// for
		
		//echo '<pre>';
		//print_r($total);exit;
		
		// 构造tableStr
		// $tableStr = $this->_generateTableData($flowArr, $total);
		$tableStr = $this->_generateTableData($flowArr);
		//var_dump($tableStr); die();
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// 1业务效率统计
	public function busEff()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '1001';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-19';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();
		
		$flowArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					//'机构代号' => $row['JG_ID'],
					//'机构名称' => $row['JG_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
					"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
		}// for
		
		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
				else
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}
		
		if (!count($serials)) $flowArr = array();
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row['S_serialname']] = 0;
			}// for
		}// for		

		// 初始化平均办理时间列
		foreach ($flowArr as $key=>$val)
		{
			//$flowArr[$key]['平均办理时间'] = 0;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = 0;
		}// for
			
		$query = $this->db->query("select Q_sysno, Q_serialname, sum(Q_zywl) as total_yw, sum(Q_ztime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_serialname");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_serialname']])) $flowArr[$row['Q_sysno']][$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw']);
		}// for
		
		// 平均办理时间
		$query = $this->db->query("select Q_sysno, sum(Q_zywl) as total_yw, sum(Q_ztime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno");
		$ret = $query->result_array();

		foreach ($ret as $row)
		{
			//if (isset($flowArr[$row['Q_sysno']])) $flowArr[$row['Q_sysno']]['平均办理时间'] = @round($row['total_tm']/$row['total_yw']);
			if (isset($flowArr[$row['Q_sysno']])) $flowArr[$row['Q_sysno']]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = @round($row['total_tm']/$row['total_yw']);
		}// for
		// 取消那些没有业务的数据
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			$i = 0;
			foreach ($val as $key1=>$val1)
			{
				$i++;
				if ($i<3)continue;
		
				if (isset($notDisplayArr[$key1])) $flowArr[$key][$key1] = $notDisplayArr[$key1];
			}//
		}// for
		
		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
			/*
			$tmp = $flowArr[$key]['平均办理时间'];
			unset($flowArr[$key]['平均办理时间']);
			$flowArr[$key]['平均办理时间'] = $tmp;
			*/
			$tmp = $flowArr[$key]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"];
			unset($flowArr[$key]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"]);
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = $tmp;
		}// for
		
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '业务效率统计', 'time');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, $this->STAT_RIGHTER_SERVER_EFF_STAT, 'time');
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr, 'time');
		
		
		// 找出总行信息
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID='{$orgId}'");
		$orgInfo = $query->row_array();
		// 找出总行数据
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		$query = $this->db->query("select Q_serialname, sum(Q_zywl) as total_yw, sum(Q_ztime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_serialname");
		$ret = $query->result_array();
		
		// $total = array('机构代码'=>'总计', '机构名称'=>$orgInfo['JG_name']);
		// foreach ($serials as $row)
		// {
			// $total[$row['S_serialname']] = 0;
		// }// for
		// foreach ($ret as $row)
		// {
			// $total[$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw'], 2);
		// }// for
		
		// // 构造tableStr
		// $tableStr = $this->_generateTableData($flowArr, $total);		
		$tableStr = $this->_generateTableData($flowArr);		
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	public function pingjia(){

		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];

		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);

		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');

		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();

		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
					"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
		}// for

		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();

				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '');
				}
				else
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}

		if (!count($serials)) $flowArr = array();
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row['S_serialname']."({$this->COMMON_BI})"] = 0;
			}// for
		}// for

		// 设置总量
		foreach ($flowArr as $key=>$val)
		{
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = 0;//业务总量(笔)
		}// for

		$query = $this->db->query("select Q_sysno, Q_serialname, sum(Q_zywl) as total_yw from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_serialname");
		$ret = $query->result_array();

		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_serialname']."({$this->COMMON_BI})"])) $flowArr[$row['Q_sysno']][$row['Q_serialname']."({$this->COMMON_BI})"] = $row['total_yw'];
		}// for


		// 取消那些没有业务的数据和计算总量
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			$i = 0;
			$totalBus = 0;
			foreach ($val as $key1=>$val1)
			{
				$i++;
				if ($i<3)continue;
				$parts = explode('(', $key1);
				if (isset($notDisplayArr[$parts[0]])) $flowArr[$key][$key1] = $notDisplayArr[$parts[0]];
				else $totalBus += $val1;
			}//
			//$flowArr[$key]['业务总量(笔)'] = $totalBus;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = $totalBus;
		}// for

		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
			//$tmp = $flowArr[$key]['业务总量'];
			$tmp = $flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"];
			//unset($flowArr[$key]['业务总量']);
			unset($flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"]);
			//$flowArr[$key]['业务总量'] = $tmp;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"] = $tmp;
		}// for

		//echo '<pre>';
		//print_r($flowArr);exit;

		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '业务量统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, "{$this->STAT_RIGHTER_SERVER_BUS_STAT}");
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr);
		//print_r($_POST);
		//exit;
		// 找出总行信息
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID='{$orgId}'");
		$orgInfo = $query->row_array();
		// 找出总行数据
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		$query = $this->db->query("select Q_serialname, sum(Q_zywl) as total_yw from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_serialname");
		$ret = $query->result_array();

		// $total = array('机构代码'=>'总计', '机构名称'=>$orgInfo['JG_name']);
		// foreach ($serials as $row)
		// {
		// $total[$row['S_serialname'].'(笔)'] = 0;
		// }// for
		// foreach ($ret as $row)
		// {
		// $total[$row['Q_serialname'].'(笔)'] = $row['total_yw'];
		// }// for

		//echo '<pre>';
		//print_r($total);exit;

		// 构造tableStr
		// $tableStr = $this->_generateTableData($flowArr, $total);
		$tableStr = $this->_generateTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));
	}
	public function evaStat(){
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-04';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];

		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);

		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');

		//$query = $this->db->query("select * from {$this->_Mserver->_tableName} where S_sysno in ({$sysnoStr}) and S_sysno in ({$this->_authJgStr})");
		//$ret = $query->result_array();
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();

		$flowArr = array();
		$snoArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
				//'柜员代号' => $row['S_no'],
				//'柜员名称' => $row['S_name']
				//	"{$this->STAT_RIGHTER_SERVER_STAFF_CODE}" => $row['S_no'],
				//	"{$this->STAT_RIGHTER_SERVER_STAFF_NAME}" => $row['S_name']
					//"{$this->COMMON_AGENCY_CODE}" =>$row['S_no'],//机构代号
					//"{$this->COMMON_AGENCY_NAME}" => $row['S_name']//机构名称
				"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
				"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
			$snoArr[] = "'{$row['JG_ID']}'";
		}// for

		$snoStr = '';
		if(!empty($snoArr)){
			$snoStr = ' and M_sno in (' . implode(',', $snoArr) . ')';
		}

		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";//
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";

			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		$pjArr['M_zywl'] = "{$this->STAT_RIGHTER_SERVER_TOTAL_BUS}{$this->COMMON_BI})";
		$selectArr[] = "sum(M_zywl) as M_zywl";
		$pjArr['notGoodPer'] = "{$this->STAT_RIGHTER_SERVER_NOT_HAPPY_PER}(%)";

		foreach ($pjArr as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row] = 0;
			}// for
		}// for


		$selectStr = '';
		if(!empty($selectArr)){
			$selectStr = ',' . implode(',', $selectArr) . ' ';
		}
		$query = $this->db->query("select M_sno  {$selectStr} from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) {$snoStr} and M_date >= '{$starttime}' and M_date<='{$endtime}' group by M_sno");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			$totalSum = 0;
			$noGoodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				if (isset($flowArr[$row['M_sno']][$pjArr[$key]]))
				{
					$flowArr[$row['M_sno']][$pjArr[$key]] = $row[$key];
					$totalSum += $row[$key];
				}
				if ($item['PJ_WARNNING']) $noGoodSum += $row[$key];
			}// for

			if (isset($flowArr[$row['M_sno']][$pjArr['M_zywl']])) $flowArr[$row['M_sno']][$pjArr['M_zywl']] = $totalSum;
			if (isset($flowArr[$row['M_sno']][$pjArr['notGoodPer']])) $flowArr[$row['M_sno']][$pjArr['notGoodPer']] = @round($noGoodSum*100/$totalSum, 2);
		}// func

		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '柜员评价统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, $this->STAT_RIGHTER_SERVER_STAFF_EVA_STAT);
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr);
		//echo '<pre>';
		//print_r($flowArr);exit;

		// 构造tableStr
		$tableStr = $this->_generateTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));

	}
	// 2评价统计
	public function evaStat1()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_REQUEST['orgId'];
		$timeType = $_REQUEST['timeType'];
		$starttime = $_REQUEST['starttime'];
		$endtime = $_REQUEST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		echo $this->_Morgrizetree->_tableName.'<br>';
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();

		$flowArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					//'机构代号' => $row['JG_ID'],
					//'机构名称' => $row['JG_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
					"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
			$flowArr[] = "'{$row['JG_ID']}'";
		}// for
		
		//echo '<pre>';
		//print_r($flowArr);exit;
		echo $this->_Mpfproject->_tableName.'<br>';
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		//$pjArr['M_zywl'] = "总业务量({$this->COMMON_BI})";
		$pjArr['M_zywl'] = "{$this->STAT_RIGHTER_SERVER_TOTAL_BUS}({$this->COMMON_BI})";
		$selectArr[] = "sum(M_zywl) as M_zywl";
		//$pjArr['notGoodPer'] = '不满意比例(%)';
		$pjArr['notGoodPer'] = "{$this->STAT_RIGHTER_SERVER_NOT_HAPPY_PER}(%)";
		
		foreach ($pjArr as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row] = 0;
			}// for
		}// for
		
		$selectStr = implode(',', $selectArr);
		echo $this->_Mmarkdate->_tableName.'<br>';
		$query = $this->db->query("select M_sysno, {$selectStr} from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}' group by M_sysno");
		$ret = $query->result_array();
		
		foreach ($ret as $row)
		{
			$totalSum = 0;
			$noGoodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				if (isset($flowArr[$row['M_sysno']][$pjArr[$key]])) 
				{
					$flowArr[$row['M_sysno']][$pjArr[$key]] = $row[$key];
					$totalSum += $row[$key];
				}
				if ($item['PJ_WARNNING']) $noGoodSum += $row[$key];
			}// for
				
			if (isset($flowArr[$row['M_sysno']][$pjArr['M_zywl']])) $flowArr[$row['M_sysno']][$pjArr['M_zywl']] = $totalSum;
			if (isset($flowArr[$row['M_sysno']][$pjArr['notGoodPer']])) $flowArr[$row['M_sysno']][$pjArr['notGoodPer']] = @round($noGoodSum*100/$totalSum, 2);
		}// for
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '评价统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, "{$this->STAT_RIGHTER_SERVER_EVA_STAT}");
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr);
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		// 找出总行信息
                echo $this->_Morgrizetree->_tableName.'<br>';
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID='{$orgId}'");
		$orgInfo = $query->row_array();
		// 找出总行数据
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
                echo $this->_Mmarkdate->_tableName.'<br>';
		$query = $this->db->query("select {$selectStr} from {$this->_Mmarkdate->_tableName} where M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}'");
		$ret = $query->result_array();
		
		// $total = array('机构代码'=>'总计', '机构名称'=>$orgInfo['JG_name']);
		// foreach ($pjArr as $row)
		// {
			// $total[$row] = 0;
		// }// for
		// // var_dump($pjProArr);
		// // exit;
		// foreach ($ret as $row)
		// {
			// $noGoodSum = 0;
			// foreach ($pjProArr as $item)
			// {
				// $key = "M_k{$item['PJ_ID']}num";
				// $total[$pjArr[$key]] = $row[$key];
				// if ($item['PJ_WARNNING']) $noGoodSum += $row[$key];
			// }// for
				
			// $total[$pjArr['M_zywl']] = $row['M_zywl'];
			// $total[$pjArr['notGoodPer']] = @round($noGoodSum*100/$row['M_zywl'], 2);
		// }// for
		
		// //echo '<pre>';
		// //print_r($total);exit;
		
		// // 构造tableStr
		// $tableStr = $this->_generateTableData($flowArr, $total);
		$tableStr = $this->_generateTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// 办理等待时间统计
	public function busWait()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
	
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$sysnoStr}) and JG_ID in ({$this->_authJgStr})");
		$ret = $query->result_array();
		
		$flowArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					//'机构号' => $row['JG_ID'],
					//'机构名称' => $row['JG_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['JG_ID'],//机构代号
					"{$this->COMMON_AGENCY_NAME}" => $row['JG_name']//机构名称
			);
		}// for
		
		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
				else
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}
		
		if (!count($serials)) $flowArr = array();
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row['S_serialname']] = 0;
			}// for
		}// for
		
		// 初始化 总平均等待时间
		foreach ($flowArr as $key=>$val)
		{
			//$flowArr[$key]['总平均等待时间'] = 0;
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_TOTAL_AVG_WAIT}"] = 0;
		}// for
		
		$query = $this->db->query("select Q_sysno, Q_serialname, sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_serialname");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_serialname']]))$flowArr[$row['Q_sysno']][$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw'], 0);
		}// func
		
		// 计算总平均等待时间
		$query = $this->db->query("select Q_sysno, sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			//if (isset($flowArr[$row['Q_sysno']])) $flowArr[$row['Q_sysno']]['总平均等待时间'] = @round($row['total_tm']/$row['total_yw'], 0);
			if (isset($flowArr[$row['Q_sysno']])) $flowArr[$row['Q_sysno']]["{$this->STAT_RIGHTER_SERVER_TOTAL_AVG_WAIT}"] = @round($row['total_tm']/$row['total_yw'], 0);
		}// for

		// 取消那些没有业务的数据
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			$i = 0;
			foreach ($val as $key1=>$val1)
			{
				$i++;
				if ($i<3)continue;
				if (isset($notDisplayArr[$key1])) $flowArr[$key][$key1] = $notDisplayArr[$key1];
			}//
		}// for
		
		// 去除业务名中的英文
		foreach ($flowArr as $key=>$val)
		{
			foreach($val as $vk=>$row)
			{
				$newVk = trimEnword($vk);
				$flowArr[$key][$newVk] = $row;
				if ($newVk != $vk) unset($flowArr[$key][$vk]);
			}// for
			/*
			$tmp = $flowArr[$key]['总平均等待时间'];
			unset($flowArr[$key]['总平均等待时间']);
			$flowArr[$key]['总平均等待时间'] = $tmp;
			*/
			$tmp = $flowArr[$key]["{$this->STAT_RIGHTER_SERVER_TOTAL_AVG_WAIT}"];
			unset($flowArr[$key]["{$this->STAT_RIGHTER_SERVER_TOTAL_AVG_WAIT}"]);
			$flowArr[$key]["{$this->STAT_RIGHTER_SERVER_TOTAL_AVG_WAIT}"] = $tmp;
		}// for
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '平均等待时间统计', 'time');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, $this->STAT_RIGHTER_SERVER_AVG_WAIT_STAT, 'time');
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr, 'time');
		//echo '<pre>';
		//print_r($flowArr);exit;
		// 找出总行信息
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID='{$orgId}'");
		$orgInfo = $query->row_array();
		// 找出总行数据
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		$query = $this->db->query("select Q_serialname, sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_serialname");
		$ret = $query->result_array();
		
		// $total = array('机构代码'=>'总计', '机构名称'=>$orgInfo['JG_name']);
		// foreach ($serials as $row)
		// {
			// $total[$row['S_serialname']] = 0;
		// }// for
		// foreach ($ret as $row)
		// {
			// $total[$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw'], 0);
		// }// for
		
		// //echo '<pre>';
		// //print_r($total);exit;
		
	
		// // 构造tableStr
		// $tableStr = $this->_generateTableData($flowArr, $total);
		$tableStr = $this->_generateTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// -----------------------------------------------------------------------------------
	
	// 3柜员业务量统计
	public function staffBusFlow()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '1001';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-14';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select * from {$this->_Mserver->_tableName} where S_sysno in ({$sysnoStr}) and S_sysno in ({$this->_authJgStr})");
		$ret = $query->result_array();
		
		$flowArr = array();
		$snoArr = array();
		$sysnoArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['S_sysno']][$row['S_no']] = array(
					//'机构号' => $row['S_sysno'],
					//'柜员代号' => $row['S_no'],
					//'柜员名称' => $row['S_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['S_sysno'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_CODE}" => $row['S_no'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_NAME}" => $row['S_name']
			);
			$snoArr[] = "'{$row['S_no']}'";
		}// for
		
		$snoStr = '';
		if(!empty($snoArr)){
			$snoStr = ' and Q_sno in (' . implode(',', $snoArr) . ') ';
		}
		
		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
				else 
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				foreach ($val as $key1=>$val1)
				{
					$flowArr[$key][$key1][$row['S_serialname']."({$this->COMMON_BI})"] = 0;
				}
			}// for
		}// for
		
		// 初始化业务总量
		foreach ($flowArr as $key=>$val)
		{
			foreach ($val as $vk=>$row)
			{
				//$flowArr[$key][$vk]['业务总量(笔)'] = 0;
				$flowArr[$key][$vk]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = 0;
			}// for
		}// for
		
		$query = $this->db->query("select Q_sysno, Q_sno, Q_serialname, sum(Q_zywl) as total_yw from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) {$snoStr} and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_sno, Q_serialname");
		$ret = $query->result_array();
		
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']."({$this->COMMON_BI})"])) $flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']."({$this->COMMON_BI})"] = $row['total_yw'];
		}// func
		
		// 取消那些没有业务的数据
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			foreach ($val as $vk=>$row)
			{
				$i = -1;
				$totalBus = 0;
				foreach ($row as $key1=>$val1)
				{
					$i++;
					if ($i<3)continue;
					$parts = explode('(', $key1);
					if (isset($notDisplayArr[$parts[0]])) $flowArr[$key][$vk][$key1] = $notDisplayArr[$parts[0]];
					else $totalBus += $val1;
				}//
				//$flowArr[$key][$vk]['业务总量(笔)'] = $totalBus;
				$flowArr[$key][$vk]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}({$this->COMMON_BI})"] = $totalBus;
			}// for
		}// for
		
		foreach ($flowArr as $key=>$val){
			foreach ($val as $key1=>$val1){
				foreach ($val1 as $vk=>$row){
					$newVk = trimEnword($vk);
					$flowArr[$key][$key1][$newVk] = $row;
					if ($newVk != $vk) unset($flowArr[$key][$key1][$vk]);
				}// for
				/*
				$tmp = $flowArr[$key][$key1]['业务总量'];
				unset($flowArr[$key][$key1]['业务总量']);
				$flowArr[$key][$key1]['业务总量'] = $tmp;
				*/
				$tmp = $flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"];
				unset($flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"]);
				$flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_BUS_TOTAL}"] = $tmp;
			}// for
		}// for
		
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, '柜员业务量统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, $this->STAT_RIGHTER_SERVER_STAFF_BUS_STAT);
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printGyTable($flowArr);
				
		// 构造tableStr
		$tableStr = $this->_generateGyTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// 4柜员业务效率统计
	public function staffBusEff()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-14';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select * from {$this->_Mserver->_tableName} where S_sysno in ({$sysnoStr}) and S_sysno in ({$this->_authJgStr})");
		$ret = $query->result_array();
		$flowArr = array();
		$snoArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['S_sysno']][$row['S_no']] = array(
					//'机构号' => $row['S_sysno'],
					//'柜员代号' => $row['S_no'],
					//'柜员名称' => $row['S_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['S_sysno'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_CODE}" => $row['S_no'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_NAME}" => $row['S_name']
			);
			$snoArr[] = "'{$row['S_no']}'";
		}// for
		
		$snoStr = '';
		if(!empty($snoArr)){
			$snoStr = ' and Q_sno in (' . implode(',', $snoArr) . ')';
		}
		
		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
				else
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				foreach ($val as $key1=>$val1)
				{
					$flowArr[$key][$key1][$row['S_serialname']] = 0;
				}// for
			}// for
		}// for
		
		// 初始化平均办理时间列
		foreach ($flowArr as $key=>$val)
		{
			foreach ($val as $vk=>$row)
			{
				//$flowArr[$key][$vk]['平均办理时间'] = 0;
				$flowArr[$key][$vk]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = 0;
			}// for
		}// for
		
		$query = $this->db->query("select Q_sysno, Q_sno, Q_serialname, sum(Q_zywl) as total_yw, sum(Q_ztime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) {$snoStr} and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_sno, Q_serialname");
		$ret = $query->result_array();
		
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']])){
				if($row['total_yw'] == 0) $flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']] = 0;
				else $flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw']);
			}
		}// func
		
		// 计算平均办理时间
		$query = $this->db->query("select Q_sysno, Q_sno, sum(Q_zywl) as total_yw, sum(Q_ztime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) {$snoStr} and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_sno");
		$ret = $query->result_array();
		
		foreach ($ret as $row)
		{
			if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']])) $flowArr[$row['Q_sysno']][$row['Q_sno']]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = @round($row['total_tm']/$row['total_yw']);
		}// for
		
		// 取消那些没有业务的数据
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			foreach ($val as $vk=>$row)
			{
				$i = -1;
				foreach ($row as $key1=>$val1)
				{
					$i++;
					if ($i<3)continue;
					if (isset($notDisplayArr[$key1])) $flowArr[$key][$vk][$key1] = $notDisplayArr[$key1];
				}//
			}//
		}// for
		
		foreach ($flowArr as $key=>$val){
			foreach ($val as $key1=>$val1){
				foreach ($val1 as $vk=>$row){
					$newVk = trimEnword($vk);
					$flowArr[$key][$key1][$newVk] = $row;
					if ($newVk != $vk) unset($flowArr[$key][$key1][$vk]);
				}// for
				/*
				$tmp = $flowArr[$key][$key1]['平均办理时间'];
				unset($flowArr[$key][$key1]['平均办理时间']);
				$flowArr[$key][$key1]['平均办理时间'] = $tmp;
				*/
				$tmp = $flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"];
				unset($flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"]);
				$flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}"] = $tmp;
			}// for
		}// for
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, '柜员业务效率统计', 'time');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, $this->STAT_RIGHTER_SERVER_STAFF_EFF, 'time');
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printGyTable($flowArr, 'time');
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		// 构造tableStr
		$tableStr = $this->_generateGyTableData($flowArr);	
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// 柜员办理等待时间统计
	public function staffBusWait()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-04';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
	
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
	
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
	
		$query = $this->db->query("select * from {$this->_Mserver->_tableName} where S_sysno in ({$sysnoStr}) and S_sysno in ({$this->_authJgStr})");
		$ret = $query->result_array();
	
		$flowArr = array();
		$snoArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['S_sysno']][$row['S_no']] = array(
					//'机构号' => $row['S_sysno'],
					//'柜员代号' => $row['S_no'],
					//'柜员名称' => $row['S_name']
					"{$this->COMMON_AGENCY_CODE}" => $row['S_sysno'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_CODE}" => $row['S_no'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_NAME}" => $row['S_name']
			);
			$snoArr[] = "'{$row['S_no']}'";
		}// for
	
		$snoStr = '';
		if(!empty($snoArr)){
			$snoStr = ' and Q_sno in (' . implode(',', $snoArr) . ')';
		}
	
		// 找出所有业务
		// 判断是否为网点
		$query = $this->db->query("select sysno from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
		$spot = $query->row_array();
		if (count($spot))
		{
			$query = $this->db->query("select Qs_serialname as S_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
			$serials = $query->result_array();
			if (!count($serials))
			{
				// 从sys_system中获取业务信息
				$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
				$sysInfo = $query->row_array();
			
				if (!isset($sysInfo['sysYWtime']) || !$sysInfo['sysYWtime'])
				{
					$sysInfo = array('sysYWtime' => '-');
				}
				else
				{
					$parts = explode(',', $sysInfo['sysYWtime']);
					foreach ($parts as $row)
					{
						$serials[] = array('S_serialname' => $row);
					}//
				}
			}// if
		}//
		else 
		{
			$query = $this->db->get('Sys_serial');
			$serials = $query->result_array();
		}
		foreach ($serials as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				foreach ($val as $key1=>$val1)
				{
					$flowArr[$key][$key1][$row['S_serialname']] = 0;
				}// for
			}// for
		}// for
		
		// 初始化总平均等待时间
		foreach ($flowArr as $key=>$val)
		{
			foreach ($val as $vk=>$row)
			{
				//$flowArr[$key][$vk]['总平均等待时间'] = 0;
				$flowArr[$key][$vk]["{$this->STAT_RIGHTER_SERVER_TOTAL_WAIT_AVG_TIME}"] = 0;
			}// for
		}// for
	
		$query = $this->db->query("select Q_sysno, Q_sno, Q_serialname, sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) {$snoStr} and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_sno, Q_serialname");
		$ret = $query->result_array();
	
		foreach ($ret as $row)
		{
			
			if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']])){
				if($row['total_yw']==0)$flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']]=0;
				else $flowArr[$row['Q_sysno']][$row['Q_sno']][$row['Q_serialname']] = @round($row['total_tm']/$row['total_yw']);
			}
		}// func
	
		// 计算总平均等待时间
		$query = $this->db->query("select Q_sysno, Q_sno, sum(Q_zywl) as total_yw, sum(Q_wtime) as total_tm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) {$snoStr} and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by Q_sysno, Q_sno");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			//if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']])) $flowArr[$row['Q_sysno']][$row['Q_sno']]['总平均等待时间'] = @round($row['total_tm']/$row['total_yw'], 0);
			if (isset($flowArr[$row['Q_sysno']][$row['Q_sno']])) $flowArr[$row['Q_sysno']][$row['Q_sno']]["{$this->STAT_RIGHTER_SERVER_TOTAL_WAIT_AVG_TIME}"] = @round($row['total_tm']/$row['total_yw'], 0);
		}// for
	
		// 取消那些没有业务的数据
		foreach ($flowArr as $key=>$val)
		{
			$notDisplayArr = $this->_getNotDisplaySerial($key);
			foreach ($val as $vk=>$row)
			{
				$i = -1;
				foreach ($row as $key1=>$val1)
				{
					$i++;
					if ($i<3)continue;
						
					if (isset($notDisplayArr[$key1])) $flowArr[$key][$vk][$key1] = $notDisplayArr[$key1];
				}//
			}//
		}// for
		
		foreach ($flowArr as $key=>$val){
			foreach ($val as $key1=>$val1){
				foreach ($val1 as $vk=>$row){
					$newVk = trimEnword($vk);
					$flowArr[$key][$key1][$newVk] = $row;
					if ($newVk != $vk) unset($flowArr[$key][$key1][$vk]);
				}// for
				/*
				$tmp = $flowArr[$key][$key1]['总平均等待时间'];
				unset($flowArr[$key][$key1]['总平均等待时间']);
				$flowArr[$key][$key1]['总平均等待时间'] = $tmp;
				*/
				$tmp = $flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_TOTAL_WAIT_AVG_TIME}"];
				unset($flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_TOTAL_WAIT_AVG_TIME}"]);
				$flowArr[$key][$key1]["{$this->STAT_RIGHTER_SERVER_TOTAL_WAIT_AVG_TIME}"] = $tmp;
			}// for
		}// for
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, '柜员平均等待时间统计', 'time');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportGyExcel($flowArr, $this->STAT_RIGHTER_SERVER_STAFF_AVG_WAIT_TIME, 'time');
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printGyTable($flowArr, 'time');
		//echo '<pre>';
		//print_r($flowArr);exit;
	
		// 构造tableStr
		$tableStr = $this->_generateGyTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));
	}// func
	
	// 5柜员评价统计
	public function staffEvaStat()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-04';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];

		
		$starttime = formateStarttime($timeType, $starttime);




		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');

		$query = $this->db->query("select * from {$this->_Mserver->_tableName} where S_sysno in ({$sysnoStr}) and S_sysno in ({$this->_authJgStr})");
		$ret = $query->result_array();

		$flowArr = array();
		$snoArr = array();
		foreach ($ret as $row)
		{
			$flowArr[$row['S_no']] = array(
					//'柜员代号' => $row['S_no'],
					//'柜员名称' => $row['S_name']
					"{$this->STAT_RIGHTER_SERVER_STAFF_CODE}" => $row['S_no'],
					"{$this->STAT_RIGHTER_SERVER_STAFF_NAME}" => $row['S_name']
			);
			$snoArr[] = "'{$row['S_no']}'";
		}// for
		
		$snoStr = '';
		if(!empty($snoArr)){
			$snoStr = ' and M_sno in (' . implode(',', $snoArr) . ')';
		}
		
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		$pjArr['M_zywl'] = "{$this->STAT_RIGHTER_SERVER_TOTAL_BUS}{$this->COMMON_BI})";
		$selectArr[] = "sum(M_zywl) as M_zywl";
		$pjArr['notGoodPer'] = "{$this->STAT_RIGHTER_SERVER_NOT_HAPPY_PER}(%)";
		
		foreach ($pjArr as $row)
		{
			foreach ($flowArr as $key=>$val)
			{
				$flowArr[$key][$row] = 0;
			}// for
		}// for
		
		
		$selectStr = '';
		if(!empty($selectArr)){
			$selectStr = ',' . implode(',', $selectArr) . ' ';
		}
		$query = $this->db->query("select M_sno  {$selectStr} from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) {$snoStr} and M_date >= '{$starttime}' and M_date<='{$endtime}' group by M_sno");
		$ret = $query->result_array();
		foreach ($ret as $row)
		{
			$totalSum = 0;
			$noGoodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				if (isset($flowArr[$row['M_sno']][$pjArr[$key]])) 
				{
					$flowArr[$row['M_sno']][$pjArr[$key]] = $row[$key];
					$totalSum += $row[$key];
				}
				if ($item['PJ_WARNNING']) $noGoodSum += $row[$key];
			}// for
				
			if (isset($flowArr[$row['M_sno']][$pjArr['M_zywl']])) $flowArr[$row['M_sno']][$pjArr['M_zywl']] = $totalSum;
			if (isset($flowArr[$row['M_sno']][$pjArr['notGoodPer']])) $flowArr[$row['M_sno']][$pjArr['notGoodPer']] = @round($noGoodSum*100/$totalSum, 2);
		}// func
		
		//if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, '柜员评价统计');
		if (isset($_POST['exportFlag']) && $_POST['exportFlag']) $this->_exportExcel($flowArr, $this->STAT_RIGHTER_SERVER_STAFF_EVA_STAT);
		if (isset($_POST['printFlag']) && $_POST['printFlag']) $this->_printTable($flowArr);
		//echo '<pre>';
		//print_r($flowArr);exit;
		
		// 构造tableStr
		$tableStr = $this->_generateTableData($flowArr);
		echo json_encode(array('tableStr' => $tableStr));

	}// func
	
	// 6业务流量分布分析
	public function busFlowDistr()
	{
		// 找出下属机构
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
		
		$childJgs = array();
		if (count($spot))
		{
			$this->spotBusFlowDistr();
		}
		else
		{
			$this->notSpotBusFlowDistr();
		}// if
	}// func
	
	// 分行业务流量分布分析
	public function notSpotBusFlowDistr()
	{
		// 找出下属机构
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
	
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
	
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
	
		$childJgs = array();

		// 非网点，获取下属机构数据
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$this->_authJgStr}) and JG_PID='{$orgId}'");
		$childJgs = $query->result_array();

	
		$strCat = "<categories>";
		/*
		$strpd = "<dataset seriesName='排队人数' parentYAxis='S'>";
		$stryw = "<dataset seriesName='业务办理数' parentYAxis='S'>";
		$strAvgWait = "<dataset seriesName='平均等待时间' parentYAxis='S'>";
		$strAvgBl = "<dataset seriesName='平均办理时间' parentYAxis='S'>";
		*/
		$strpd = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_QUEUE_NUMBER}' parentYAxis='S'>";
		$stryw = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_QUEUE_NUMBER}' parentYAxis='S'>";
		$strAvgWait = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_WAIT_AVG_TIME}' parentYAxis='S'>";
		$strAvgBl = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}' parentYAxis='S'>";
		
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					//'机构代号' => $row['JG_ID'],
					'JG_name' => $row['JG_name']
			);
				
			$strCat .= "<category label='" . $row['JG_name'] . "'/>";
		}// for
		$strCat .= "</categories>";
	
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
			$query = $this->db->query("select sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}'");
			$row1 = $query->row_array();
				
			$strpd .= "<set value='" . ($row1['total_yw']+$row1['total_no']) . "'/>";
			$stryw .= "<set value='" . $row1['total_yw'] . "'/>";
			$strAvgWait .= "<set value='" . @round(@round($row1['total_wtm']/$row1['total_yw'],2)/60,2) . "'/>";
			$strAvgBl .= "<set value='" . @round(@round($row1['total_ztm']/$row1['total_yw'],2)/60,2) . "'/>";
	
		}// for
	
		$strpd .= "</dataset>";
		$stryw .= "</dataset>";
		$strAvgWait .= "</dataset>";
		$strAvgBl .= "</dataset>";
	
		$strYearXML  = "<chart YAxisName='{$this->COMMON_AMOUNT}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_UNDER_BUS_NUMBER}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_BI}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strpd.$stryw;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
	
		//echo $strYearXML;exit;
		$chartStr1 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);
		//echo $chartStr;exit;
		
		//$strYearXML  = "<chart YAxisName='时间(分钟)' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='下属机构业务时间' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='分' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_TIME}({$this->COMMON_ALL_MIN})' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_UNDER_BUS_TIME}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='分' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strAvgWait.$strAvgBl;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo $strYearXML;exit;
		$chartStr2 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		//echo $chartStr;exit;
		echo json_encode(array('chartStr' => $chartStr1.'<p style="height:20px;"></p>'.$chartStr2));
		exit;
	
	}// func
	
	// 网点业务流量分布分析
	public function spotBusFlowDistr()
	{
		// 找出下属机构
		/*
		$_POST['orgId'] = '1001';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-19';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
	
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
	
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
	
		$childJgs = array();
		$childJgs[] = array('JG_ID'=>$spot['sysno'], 'JG_name'=>$spot['sysname']);
	
		$strCat = "<categories>";
		/*
		$strpd = "<dataset seriesName='排队人数'>";
		$stryw = "<dataset seriesName='业务办理数'>";
		$strAvgWait = "<dataset seriesName='平均等待时间'>";
		$strAvgBl = "<dataset seriesName='平均办理时间'>";
		*/
		$strpd = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_QUEUE_NUMBER}'>";
		$stryw = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_BUS_HANDLE_NUMBER}'>";
		$strAvgWait = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_WAIT_AVG_TIME}'>";
		$strAvgBl = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}'>";
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					//'机构代号' => $row['JG_ID'],
					'JG_name' => $row['JG_name']
			);
				
			$strCat .= "<category label='" . $row['JG_name'] . "'/>";
		}// for
		$strCat .= "</categories>";
	
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
			$query = $this->db->query("select sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}'");
			$row1 = $query->row_array();
				
			$strpd .= "<set value='" . ($row1['total_yw']+$row1['total_no']) . "'/>";
			$stryw .= "<set value='" . $row1['total_yw'] . "'/>";
			$strAvgWait .= "<set value='" . @round(@round($row1['total_wtm']/$row1['total_yw'],2)/60,2) . "'/>";
			$strAvgBl .= "<set value='" . @round(@round($row1['total_ztm']/$row1['total_yw'],2)/60,2) . "'/>";
	
		}// for
	
		$strpd .= "</dataset>";
		$stryw .= "</dataset>";
		$strAvgWait .= "</dataset>";
		$strAvgBl .= "</dataset>";
	
		//$strYearXML  = "<chart YAxisName='数量' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='网点业务数量' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='笔' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_AMOUNT}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_NODE_BUS_NUMBER}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_BI}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strpd.$stryw;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
	
		//echo $strYearXML;exit;
		$chartStr1 = renderChart("assets/FusionCharts/MSColumn3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);
		//echo $chartStr;exit;
		
		//$strYearXML  = "<chart YAxisName='时间(分钟)' baseFontSize='14' baseFont='黑体' baseFontSize='16'  caption='网点业务时间' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='分' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_TIME}({$this->COMMON_ALL_MIN})' baseFontSize='14' baseFont='黑体' baseFontSize='16'  caption='{$this->STAT_RIGHTER_SERVER_NODE_BUS_TIME}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='分' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strAvgWait.$strAvgBl;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo $strYearXML;exit;
		$chartStr2 = renderChart("assets/FusionCharts/MSColumn3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		//echo $chartStr;exit;
		echo json_encode(array('chartStr' => $chartStr1.$chartStr2));
		exit;
	
	}// func
	
	// 业务趋势分析
	public function busFlowTrend()
	{
		/*
		$_POST['orgId'] = '1001';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-14';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		switch($timeType)
		{
			case 'day':
				$query = $this->db->query("select CONVERT(varchar(10), Q_date, 120) as tm, sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by CONVERT(varchar(10), Q_date, 120)");
				break;
			case 'month':
				$query = $this->db->query("select CONVERT(varchar(7), Q_date, 120) as tm, sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by CONVERT(varchar(7), Q_date, 120)");
				break;
			case 'season':
				$query = $this->db->query("select datepart(quarter, Q_date) as tm, sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by datepart(quarter, Q_date)");
				break;
			case 'year':
				$query = $this->db->query("select CONVERT(varchar(4), Q_date, 120) as tm, sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no, sum(Q_wtime) as total_wtm, sum(Q_ztime) as total_ztm from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}' group by CONVERT(varchar(4), Q_date, 120)");
				break;
		}// switch
		$ret = $query->result_array();
		
		$strCat = "<categories>";
		/*
		$strpd = "<dataset seriesName='排队人数'>";
		$stryw = "<dataset seriesName='业务办理数'>";
		$strAvgWait = "<dataset seriesName='平均等待时间'>";
		$strAvgBl = "<dataset seriesName='平均办理时间'>";
		*/
		$strpd = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_QUEUE_NUMBER}'>";
		$stryw = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_BUS_HANDLE_NUMBER}'>";
		$strAvgWait = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_WAIT_AVG_TIME}'>";
		$strAvgBl = "<dataset seriesName='{$this->STAT_RIGHTER_SERVER_HANDLE_AVG_TIME}'>";
		foreach ($ret as $row)
		{
			$strCat .= "<category label='" . $row['tm'] . "'/>";
			$strpd .= "<set value='" . ($row['total_yw']+$row['total_no']) . "'/>";
			$stryw .= "<set value='" . $row['total_no'] . "'/>";
			$strAvgWait .= "<set value='" . @round(@round($row['total_wtm']/$row['total_yw'],2)/60,2) . "'/>";
			$strAvgBl .= "<set value='" . @round(@round($row['total_ztm']/$row['total_yw'],2)/60,2) . "'/>";
		}// for
		
		$strCat .= "</categories>";
		$strpd .= "</dataset>";
		$stryw .= "</dataset>";
		$strAvgWait .= "</dataset>";
		$strAvgBl .= "</dataset>";
		
		switch($timeType){
			case 'day':
				//$timeTypeLabel = '日期';
				$timeTypeLabel = $this->COMMON_ALL_DATE;
				break;
			case 'month':
				//$timeTypeLabel = '月份';
				$timeTypeLabel = $this->COMMON_ALL_MONTH;
				break;
			case 'season':
				//$timeTypeLabel = '季度';
				$timeTypeLabel = $this->COMMON_ALL_SEASON;
				break;
			case 'year':
				//$timeTypeLabel = '年份';
				$timeTypeLabel = $this->COMMON_ALL_YEAR;
				break;
			default:
				$timeTypeLabel = '';
		}
		
		//$strYearXML  = "<chart YAxisName='数量' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='业务数量趋势' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='笔' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_AMOUNT}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_BUS_NUMBER_TREND}' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_BI}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strpd.$stryw;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		$chartStr1 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);
		//echo $chartStr;exit;
		
		//$strYearXML  = "<chart YAxisName='时间(分钟)' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='业务时间趋势' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='分' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_TIME}({$this->COMMON_ALL_MIN})' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_BUS_TIME_TREND}' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_MIN}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strAvgWait.$strAvgBl;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		$chartStr2 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		//echo $chartStr;exit;
		echo json_encode(array('chartStr' => $chartStr1.'<p style="height:20px;"></p>'.$chartStr2));
	}// func
	
	// 业务量和人流量饼图
	public function busPieDistr()
	{
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
		
		$childJgs = array();
		if (count($spot))
		{
			// 网点，获取该网点数据
			$childJgs[] = array('JG_ID'=>$spot['sysno'], 'JG_name'=>$spot['sysname']);
		}
		else
		{
			// 非网点，获取下属机构数据
			$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$this->_authJgStr}) and JG_PID='{$orgId}'");
			$childJgs = $query->result_array();
		}// if
		
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$flowArr[$row['JG_ID']] = array(
					'JG_name' => $row['JG_name']
			);
		}// for
		
		$totalArr = array('total_yw'=>0, 'total_no'=>0);
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
			$query = $this->db->query("select sum(Q_zywl) as total_yw, sum(Q_noywl) as total_no from {$this->_Mhqueuedate->_tableName} where Q_sysno in ({$sysnoStr}) and Q_sysno in ({$this->_authJgStr}) and Q_date >= '{$starttime}' and Q_date<='{$endtime}'");
			$ret = $query->result_array();
				
			foreach ($ret as $row1)
			{
				$flowArr[$row['JG_ID']]['total_yw'] = $row1['total_yw'];
				$flowArr[$row['JG_ID']]['total_no'] = $row1['total_no'];
				$totalArr['total_yw'] += $row1['total_yw'];
				$totalArr['total_no'] += $row1['total_no'];
			}// for
		}// for
		//echo '<pre>';
		//print_r($flowArr);exit;
		// 人流量
		$strXML = '';
		foreach ($flowArr as $row)
		{
			$strXML .= "<set label='" . $row['JG_name']  . "' value='" . ($row['total_yw']+$row['total_no']) . "' isSliced='0' />";
		}// for
		
		//$strEmployeeXML  = "<chart baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='下属机构人流量占比' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved' yAxisName='Quantity' showValues='0' numberPrefix='' formatNumberScale='0' showPercentInToolTip='0'>";
		$strEmployeeXML  = "<chart baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_UNDER_PEOPLE_PER}' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved' yAxisName='Quantity' showValues='0' numberPrefix='' formatNumberScale='0' showPercentInToolTip='0'>";
		$strEmployeeXML .= $strXML;
		//Add some styles to increase caption font size
		$strEmployeeXML .= "<styles><definition><style type='font' name='CaptionFont' color='666666' size='15' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strEmployeeXML .= "</chart>";
		
		$chartStr1 = renderChart("assets/FusionCharts/Pie3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strEmployeeXML, "TopEmployees1", 500, 300, false, true);
		
		// 业务量
		$strXML = '';
		foreach ($flowArr as $row)
		{
			$strXML .= "<set label='" . $row['JG_name'] . "' value='" . $row['total_yw'] . "' isSliced='0' />";
		}// for
		
		//$strEmployeeXML  = "<chart PYAxisName='数量' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='时间(分钟)' caption='下属机构业务量占比' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved1' yAxisName='Quantity' showValues='01' numberPrefix='' formatNumberScale='0' showPercentInToolTip='0'>";
		$strEmployeeXML  = "<chart PYAxisName='{$this->COMMON_AMOUNT}' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='{$this->COMMON_TIME}({$this->COMMON_ALL_MIN})' caption='{$this->STAT_RIGHTER_SERVER_UNDER_BUS_PER}' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved1' yAxisName='Quantity' showValues='01' numberPrefix='' formatNumberScale='0' showPercentInToolTip='0'>";
		$strEmployeeXML .= $strXML;
		//Add some styles to increase caption font size
		$strEmployeeXML .= "<styles><definition><style type='font' name='CaptionFont' color='666666' size='15' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strEmployeeXML .= "</chart>";
		
		$chartStr2 = renderChart("assets/FusionCharts/Pie3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strEmployeeXML, "TopEmployees2", 500, 300, false, true);
		
		echo json_encode(array('chartStr' => $chartStr1.$chartStr2));
	}// func
	
	// 7评价分布分析
	public function evaLevelDistr()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
		
		$childJgs = array();
		if (count($spot))
		{
			$this->spotEvaLevelDistr();
			// 网点，获取该网点数据
		}
		else
		{
			$this->notSpotEvaLevelDistr();
			// 非网点，获取下属机构数据
			$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$this->_authJgStr}) and JG_PID='{$orgId}'");
			$childJgs = $query->result_array();
		}// if
		
		$strCat = "<categories>";
		
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			${$key} = "<dataset seriesName='{$row['PJ_NAME']}'>";
				
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		
		//$strHapy = "<dataset seriesName='满意度' parentYAxis='S'>";
		$strHapy = "<dataset seriesName='{$this->COMMON_DEGRESS_OF_HAPPY}' parentYAxis='S'>";
		
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$strCat .= "<category label='" . $row['JG_name'] . "'/>";
		}// for
		$strCat .= "</categories>";
		
		$strPj = '';
		
		$selectStr = implode(',', $selectArr);
		
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
			
			$query = $this->db->query("select {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}'");
			$row1 = $query->row_array();
			
			$totalSum = 0;
			$goodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				${$key} .= "<set value='" . $row1[$key] . "'/>";
				
				if ($item['PJ_isCaluMyl']) $goodSum += $row1[$key];
				$totalSum += $row1[$key];
			}// for
			$strHapy .= "<set value='" . @round($goodSum*100/$totalSum, 2) . "'/>";
		}// for
		
		foreach ($pjProArr as $item)
		{
			$key = "M_k{$item['PJ_ID']}num";
			${$key} .= "</dataset>";
			$strPj .= ${$key};
		}// for
		$strHapy .= "</dataset>";
		

		//$strYearXML  = "<chart PYAxisName='次数' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='满意率(百分比)' caption='' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberPrefix='' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart PYAxisName='{$this->COMMON_FRE}' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='{$this->COMMON_PER_OF_HAPPY}({$this->COMMON_PER})' caption='' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberPrefix='' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strPj.$strHapy;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr = renderChart("assets/FusionCharts/MSColumn3DLineDY.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear", '80%', 405, false, true);	
		
		
		echo json_encode(array('chartStr' => $chartStr));
	}// func
	
	// 分行评价分布分析
	public function notSpotEvaLevelDistr()
	{
		// 找出该机构下的全部网点
		/*
			$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
	
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
	
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
	
		$childJgs = array();
		// 非网点，获取下属机构数据
		$query = $this->db->query("select * from {$this->_Morgrizetree->_tableName} where JG_ID in ({$this->_authJgStr}) and JG_PID='{$orgId}'");
		$childJgs = $query->result_array();
	
		$strCat = "<categories>";
	
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			${$key} = "<dataset seriesName='{$row['PJ_NAME']}'>";
	
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
	
		//$strHapy = "<dataset seriesName='满意度' parentYAxis='S'>";
		$strHapy = "<dataset seriesName='{$this->COMMON_DEGRESS_OF_HAPPY}' parentYAxis='S'>";
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$strCat .= "<category label='" . $row['JG_name'] . "'/>";
		}// for
		$strCat .= "</categories>";
	
		$strPj = '';
	
		$selectStr = implode(',', $selectArr);
	
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
				
			$query = $this->db->query("select {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}'");
			$row1 = $query->row_array();
				
			$totalSum = 0;
			$goodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				if (!$row1[$key]) $row1[$key] = 0;
				${$key} .= "<set value='" . $row1[$key] . "'/>";
	
				if ($item['PJ_isCaluMyl']) $goodSum += $row1[$key];
				$totalSum += $row1[$key];
			}// for
			$strHapy .= "<set value='" . @round($goodSum*100/$totalSum, 2) . "'/>";
		}// for
	
		foreach ($pjProArr as $item)
		{
			$key = "M_k{$item['PJ_ID']}num";
			${$key} .= "</dataset>";
			$strPj .= ${$key};
		}// for
		$strHapy .= "</dataset>";
	
	
		//$strYearXML  = "<chart YAxisName='次数' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='下属机构各评价项目分布' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='次' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_FRE}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_UNDER_EVA_ITEM_DST}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='次' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strPj;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr1 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);	
		
		//$strYearXML  = "<chart PYAxisName='满意率(百分比)' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='下属机构满意度' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='%' yAxisMaxValue='100' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart PYAxisName='{$this->COMMON_PER_OF_HAPPY}({$this->COMMON_PER})' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_UNDER_EVA_DEGREE_OF_HAPPY}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='%' yAxisMaxValue='100' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strHapy;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr2 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		
		
		echo json_encode(array('chartStr' => $chartStr1.'<p style="height:20px;"></p>'.$chartStr2));
		exit;
	}// func
	
	// 网点评价分布分析
	public function spotEvaLevelDistr()
	{
		// 找出该机构下的全部网点
		/*
		$_POST['orgId'] = '0';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-09';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		// 判断是否为网点
		$this->db->where('sysno', $orgId);
		$query = $this->db->get($this->_Msystem->_tableName);
		$spot = $query->row_array();
		//print_r($spot);
		
		$childJgs = array();

		// 网点，获取该网点数据
		$childJgs[] = array('JG_ID'=>$spot['sysno'], 'JG_name'=>$spot['sysname']);

		
		$strCat = "<categories>";
		
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			${$key} = "<dataset seriesName='{$row['PJ_NAME']}'>";
				
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		
		$strHapy = "<dataset seriesName='{$this->COMMON_DEGRESS_OF_HAPPY}' parentYAxis='S'>";
		
		$flowArr = array();
		foreach ($childJgs as $row)
		{
			$strCat .= "<category label='" . $row['JG_name'] . "'/>";
		}// for
		$strCat .= "</categories>";
		
		$strPj = '';
		
		$selectStr = implode(',', $selectArr);
		
		foreach ($childJgs as $row)
		{
			$spotArr = findSpotFromJg($row['JG_ID'], $this->_orgTree);
			$sysnoStr = getAllSpotFromJg($spotArr);
			$sysnoStr = trim($sysnoStr,',');
			
			$query = $this->db->query("select {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}'");
			$row1 = $query->row_array();
			
			$totalSum = 0;
			$goodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				${$key} .= "<set value='" . $row1[$key] . "'/>";
				
				if ($item['PJ_isCaluMyl']) $goodSum += $row1[$key];
				$totalSum += $row1[$key];
			}// for
			$strHapy .= "<set value='" . @round($goodSum*100/$totalSum, 2) . "'/>";
		}// for
		
		foreach ($pjProArr as $item)
		{
			$key = "M_k{$item['PJ_ID']}num";
			${$key} .= "</dataset>";
			$strPj .= ${$key};
		}// for
		$strHapy .= "</dataset>";
		

		//$strYearXML  = "<chart YAxisName='次数' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='网点评价项目情况' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='次' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_FRE}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_NODE_EVA_ITEM}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_FRE}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strPj;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr1 = renderChart("assets/FusionCharts/MSColumn3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);	
		
		//$strYearXML  = "<chart PYAxisName='满意率(百分比)' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='网点满意度' XAxisName='机构' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='%' yAxisMaxValue='100' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart PYAxisName='{$this->COMMON_PER_OF_HAPPY}({$this->COMMON_PER})' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_NODE_DEGREE_OF_HAPPY}' XAxisName='{$this->COMMON_AGENCY}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='%' yAxisMaxValue='100' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strHapy;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr2 = renderChart("assets/FusionCharts/MSColumn3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		
		
		echo json_encode(array('chartStr' => $chartStr1.$chartStr2));
		exit;
	}// func
	
	// 评价趋势分析
	public function evaLevelTrend()
	{
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'season';
		$_POST['starttime'] = '2013-01';
		$_POST['endtime'] = '2013-03';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		// 找出所有评价项目
		$strCat = "<categories>";
		$strPj = '';
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME']."({$this->COMMON_BI})";
			${$key} = "<dataset seriesName='{$row['PJ_NAME']}'>";
		
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		
		$strHapy = "<dataset seriesName='{$this->COMMON_DEGRESS_OF_HAPPY}'>";
		
		$selectStr = implode(',', $selectArr);
		
		switch($timeType)
		{
			case 'day':
				$query = $this->db->query("select CONVERT(varchar(10), M_date, 120) as tm, {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}' group by CONVERT(varchar(10), M_date, 120)");
				break;
			case 'month':
				$query = $this->db->query("select CONVERT(varchar(7), M_date, 120) as tm, {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}' group by CONVERT(varchar(7), M_date, 120)");
				break;
			case 'season':
				$query = $this->db->query("select datepart(quarter, M_date) as tm, {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}' group by datepart(quarter, M_date)");
				break;
			case 'year':
				$query = $this->db->query("select CONVERT(varchar(4), M_date, 120) as tm, {$selectStr}, sum(M_zywl) as M_zywl from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}' group by CONVERT(varchar(4), M_date, 120)");
				break;
		}// switch
		$ret = $query->result_array();
		
		foreach ($ret as $row)
		{
			$strCat .= "<category label='" . $row['tm'] . "'/>";
			$totalSum = 0;
			$goodSum = 0;
			foreach ($pjProArr as $item)
			{
				$key = "M_k{$item['PJ_ID']}num";
				${$key} .= "<set value='" . $row[$key] . "'/>";
				if ($item['PJ_isCaluMyl']) $goodSum += $row[$key];
				$totalSum += $row[$key];
			}// for
			$strHapy .= "<set value='" . @round($goodSum*100/$totalSum, 2) . "'/>";
		}// for
		
		$strCat .= "</categories>";
		
		foreach ($pjProArr as $item)
		{
			$key = "M_k{$item['PJ_ID']}num";
			${$key} .= "</dataset>";
			$strPj .= ${$key};
		}// for
		
		switch($timeType){
			case 'day':
				//$timeTypeLabel = '日期';
				$timeTypeLabel = $this->COMMON_ALL_DATE;
				break;
			case 'month':
				//$timeTypeLabel = '月份';
				$timeTypeLabel = $this->COMMON_ALL_MONTH;
				break;
			case 'season':
				//$timeTypeLabel = '季度';
				$timeTypeLabel = $this->COMMON_ALL_SEASON;
				break;
			case 'year':
				//$timeTypeLabel = '年份';
				$timeTypeLabel = $this->COMMON_ALL_YEAR;
				break;
			default:
				$timeTypeLabel = '';
		}
		
		$strHapy .= "</dataset>";
		
		//$strYearXML  = "<chart YAxisName='次数' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='评价项目趋势' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='次' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML  = "<chart YAxisName='{$this->COMMON_FRE}' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_EVA_ITEM_TREND}' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='{$this->COMMON_FRE}' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strPj;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr1 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear1", '80%', 405, false, true);
		
		$strYearXML  = "<chart YAxisName='{$this->COMMON_PER_OF_HAPPY}($this->COMMON_PER)' baseFontSize='14' baseFont='黑体' baseFontSize='16' caption='{$this->STAT_RIGHTER_SERVER_DEGREE_OF_HAPPY_TREND}' XAxisName='{$timeTypeLabel}' palette='2' animation='1' subcaption='' formatNumberScale='0' numberSuffix='%' yAxisMaxValue='100' showValues='0' seriesNameInToolTip='0'>";
		$strYearXML .= $strCat.$strHapy;
		//Add some styles to increase caption font size
		$strYearXML .= "<styles><definition><style type='font' color='666666' name='CaptionFont' size='20' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strYearXML .= "</chart>";
		
		//echo '<pre>';
		//print_r($strYearXML);exit;
		
		$chartStr2 = renderChart("assets/FusionCharts/MSLine.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strYearXML,"SalesByYear2", '80%', 405, false, true);
		
		
		echo json_encode(array('chartStr' => $chartStr1.'<p style="height:20px;"></p>'.$chartStr2));
	}// func
	
	// 评价分布饼图
	public function evaPieDistr()
	{
		/*
		$_POST['orgId'] = '0101';
		$_POST['timeType'] = 'day';
		$_POST['starttime'] = '2013-04-05';
		$_POST['endtime'] = '2013-05-04';
		*/
		$orgId = $_POST['orgId'];
		$timeType = $_POST['timeType'];
		$starttime = $_POST['starttime'];
		$endtime = $_POST['endtime'];
		
		$starttime = formateStarttime($timeType, $starttime);
		$endtime = formateEndtime($timeType, $endtime);
		
		
		// 找出所有评价项目
		$query = $this->db->query("select * from {$this->_Mpfproject->_tableName}");
		$pjProArr = $query->result_array();
		$pjArr = array();
		$selectArr = array();
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$pjArr[$key] = $row['PJ_NAME'];
			// 构造select 字段
			$selectArr[] = "sum({$key}) as {$key}";
		}// for
		
		$selectStr = implode(',', $selectArr);
		
		$spotArr = findSpotFromJg($orgId, $this->_orgTree);
		$sysnoStr = getAllSpotFromJg($spotArr);
		$sysnoStr = trim($sysnoStr,',');
		
		$query = $this->db->query("select {$selectStr} from {$this->_Mmarkdate->_tableName} where M_sysno in ({$sysnoStr}) and M_sysno in ({$this->_authJgStr}) and M_date >= '{$starttime}' and M_date<='{$endtime}'");
		$ret = $query->row_array();
		$strXML = '';
		foreach ($pjProArr as $row)
		{
			$key = "M_k{$row['PJ_ID']}num";
			$strXML .= "<set label='" . $pjArr[$key] . " ," . $ret[$key] . "' value='" . $ret[$key] . "' isSliced='0' />";
		}// for
		
		//$strEmployeeXML  = "<chart showPercentValues='1' PYAxisName='数量' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='时间(分钟)' caption='评价占比' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved' yAxisName='Quantity' showValues='0' numberPrefix='' formatNumberScale='0' showPercentInToolTip='1'>";
		$strEmployeeXML  = "<chart showPercentValues='1' PYAxisName='{$this->COMMON_AMOUNT}' baseFontSize='14' baseFont='黑体' baseFontSize='16' SYAxisName='{$this->COMMON_TIME}({$this->COMMON_ALL_MIN})' caption='{$this->STAT_RIGHTER_SERVER_EVA_PER}' palette='2' animation='1' subCaption='' xAxisName='Sales Achieved' yAxisName='Quantity' showValues='0' numberPrefix='' formatNumberScale='0' showPercentInToolTip='1'>";
		$strEmployeeXML .= $strXML;
		//Add some styles to increase caption font size
		$strEmployeeXML .= "<styles><definition><style type='font' name='CaptionFont' color='666666' size='25' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>";
		$strEmployeeXML .= "</chart>";
		
		$chartStr = renderChart("assets/FusionCharts/Pie3D.swf?ChartNoDataText={$this->COMMON_NO_DATA_DISPLAY}&t=" . time(), "",$strEmployeeXML, "TopEmployees1", 500, 305, false, true);

		echo json_encode(array('chartStr' => $chartStr));
	}// func
	
	// 生成图表数据
	private function _generateChartData($data)
	{
		$theadArr = array();
		$tbodyArr = array();
		foreach ($data as $row)
		{
			$i = 1;
			foreach ($row as $key=>$val)
			{
				if ($i == 1) 
				{
					$i++;
					continue;
				}
				else if ($i == 2) $theadArr[] = $val;
				else $tbodyArr[$key][] = $val;
				$i++;
			}// for
		}// for

		$thead = "<thead><tr><td></td>";
		foreach ($theadArr as $row)
		{
			$thead .= "<th scope='col'>{$row}</th>";
		}// for
		$thead .= "</tr></thead>";
		
		$tbody = "<tbody>";
		foreach ($tbodyArr as $key=>$val)
		{
			$tbody .= "<tr><th scope='row'>{$key}</th>";
			foreach ($val as $row)
			{
				$tbody .= "<td>{$row}</td>";
			}// for
			$tbody .= "</tr>";
		}// for
		$tbody .= "</tbody>";
		
		return "<table  class='data' data-chart='bar'>{$thead}{$tbody}</table>";
	}// func
	
	// 生成柜员业务报表数据
	private function _generateGyTableData($data)
	{
		$i = 1;
		$tbody = "<tbody>";
		foreach ($data as $row)
		{
			foreach ($row as $key=>$val)
			{
				if ($i == 1)
				{
					$thead = "<thead><tr>";
					foreach ($val as $key1=>$val1)
					{
						$thead .= "<td>{$key1}</td>";
					}// for
					$thead .= "</tr></thead>";
				}//if
				$tbody .= "<tr>";
				foreach ($val as $row1)
				{
					$tbody .= "<td>{$row1}</td>";
				}// for
				$tbody .= "</tr>";
				$i++;
			}// for	
		}// for
		$tbody .= "</tbody>";
		if(!isset($thead)){
			return "<span>{$this->COMMON_NO_DATA_DISPLAY}</span>";
		}
		return "<table>{$thead}{$tbody}</table>";
	}// func
	
	// 生成业务报表数据
	private function _generateTableData($data, $total = array())
	{
		$i = 1;		
		$tbody = "<tbody>";
		foreach ($data as $row)
		{
			if ($i == 1)
			{
				$thead = "<thead><tr>";
				foreach ($row as $key=>$val)
				{
					$thead .= "<td>{$key}</td>";
				}// for
				$thead .= "</tr></thead>";
			}// if
			$tbody .= "<tr>";
			foreach ($row as $row1)
			{
				$tbody .= "<td>{$row1}</td>";
			}// for
			$tbody .= "</tr>";
			$i++;
		}// for
		$tbody .= "</tbody>";
		
		$tfoot = '';
		if (count($total))
		{
			$tfoot = '<tfoot><tr>';
			foreach ($total as $row)
			{
				$tfoot .= "<td>{$row}</td>";
			}// for
			$tfoot .= '</tr></tfoot>';
		}// if
		//echo "<table>{$thead}{$tbody}{$tfoot}</table>";exit;
		if(!isset($thead)){
			return "<span>{$this->COMMON_NO_DATA_DISPLAY}</span>";
		}
		return "<table>{$thead}{$tbody}{$tfoot}</table>";
	}// func
	
	// 找出网点中不需要显示的业务
	private function _getNotDisplaySerial($orgId)
	{
		$serialArr = array();
		$query = $this->db->query("select Qs_serialname from {$this->_Msysserial->_tableName} where Qs_sysno='{$orgId}'");
		$ret = $query->result_array();
		if (!count($ret))
		{
			// 从sys_system中获取业务信息
			$query = $this->db->query("select sysYWtime from {$this->_Msystem->_tableName} where sysno='{$orgId}'");
			$sysInfo = $query->row_array();
				
			if (isset($sysInfo['sysYWtime']) && $sysInfo['sysYWtime'])
			{
				$parts = explode(',', $sysInfo['sysYWtime']);
				foreach ($parts as $row)
				{
					$serialArr[] = $row;
				}//
			}
		}// if
		else
		{
			foreach ($ret as $row)
			{
				$serialArr[] = $row['Qs_serialname'];
			}// for
		}// 
		
		$tmpArr = array_diff($this->_serials, $serialArr);
		$notDisplayArr = array();
		foreach ($tmpArr as $row)
		{
			$notDisplayArr[$row] = '-';
		}// for
		//echo '<pre>';
		//print_r($notDisplayArr);exit;
		return $notDisplayArr;
	}// func
	
	private function _exportExcel($flowArr, $title, $type='')
	{		
		//echo '<pre>';
		//print_r($flowArr);exit;
		ob_clean();
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
		
		// Add some data
		$item = array_slice($flowArr, 0, 1);
		$columnStart = 65;
		$i = 0;
        foreach ($item as $k=>$v)
        {
            foreach($v as $key=>$val)
            {
            	$prefix = '';
            	if ($i>25) $prefix = 'A';
            	$tmp = $i%26;
                $idx = $columnStart + $tmp;
                $i++;
                $idx = chr($idx);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$prefix}{$idx}1", $key);
                // $objPHPExcel->getActiveSheet()->getColumnDimension($idx)->setAutoSize(true); 
                // $objPHPExcel->getActiveSheet()->getColumnDimension($idx)->setWidth(50); 
                $objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setName('微软雅黑');
                $objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFill()->getStartColor()->setARGB('FF94BCE0');
            }
        }// func
		
		// Miscellaneous glyphs, UTF-8
		$columnStart = 65;
		$j = 2;
		foreach ($flowArr as $key=>$val)
		{
			$i = 0;
			foreach ($val as  $row)
			{
				$prefix = '';
				if ($i > 25) $prefix = 'A';
				if ($i > 1 && $type == "time" && $row != '-' && $row != '0') $row = formatTiemStr($row);
				$tmp = $i%26;
				$idx = $columnStart + $tmp;
				$i++;
				$idx = chr($idx);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$prefix}{$idx}{$j}", " ".$row);
			}// func
			$j++;
		}// for
		
		// Rename worksheet
		//$objPHPExcel->getActiveSheet()->setTitle('统计数据');
		$objPHPExcel->getActiveSheet()->setTitle($this->COMMON_STAT_DATA);
		
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
		header('Content-Disposition: attachment;filename='. urlencode($title.'_'.date('YmdHis').'.xls'));
		header('Cache-Control: max-age=0');
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}// func
	
	private function _exportGyExcel($flowArr, $title, $type='')
	{
		//echo '<pre>';
		//print_r($flowArr);exit;
		ob_clean();
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
	
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
		->setLastModifiedBy("Maarten Balliauw")
		->setTitle("Office 2007 XLSX Test Document")
		->setSubject("Office 2007 XLSX Test Document")
		->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")
		->setCategory("Test result file");
	
		// Add some data
		$item = array_slice($flowArr, 0, 1);
		foreach($item as $k=>$v){
			$item = array_slice($v, 0, 1);
		}
		$columnStart = 65;
		$i = 0;
        foreach ($item as $k=>$v)
        {
            foreach($v as $key=>$val)
            {
            	$prefix = '';
            	if ($i > 25) $prefix = 'A';
            	$tmp = $i%26;
				$idx = $columnStart + $tmp;
				$i++;
				$idx = chr($idx);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$prefix}{$idx}1", $key);
				$objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setName('微软雅黑');
				$objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setSize(10);
				$objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFont()->setBold(true);
				$objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle("{$idx}1")->getFill()->getStartColor()->setARGB('FF94BCE0');
			}
		}// func
	
		// Miscellaneous glyphs, UTF-8
		$columnStart = 65;
		$j = 2;
		foreach ($flowArr as $key=>$val)
		{
			foreach ($val as $key1=>$val1)
			{
				$i = 0;
				foreach ($val1 as $row)
				{
					$prefix = '';
					if ($i > 25) $prefix = 'A';
					if ($i > 2 && $type == "time" && $row != '-' && $row != '0') $row = formatTiemStr($row);
					$tmp = $i%26;
					$idx = $columnStart + $tmp;
					$i++;
					$idx = chr($idx);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue("{$prefix}{$idx}{$j}", " ".$row);
				}
				$j++;
			}// for
		}// for
	
		// Rename worksheet
		//$objPHPExcel->getActiveSheet()->setTitle('统计数据');
		$objPHPExcel->getActiveSheet()->setTitle($this->COMMON_STAT_DATA);
	
	
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
	
	
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$title.'_'.date('YmdHis').'.xls"');
		header('Cache-Control: max-age=0');
	
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}// func
	
	// 显示打印数据
	private function _printTable($flowArr, $type='')
	{
		$item = array_slice($flowArr, 0, 1);
		$thead = "<thead><tr>";
		foreach ($item[0] as $key=>$val)
		{
			$thead .= "<td style='border:1px solid #000'>{$key}</td>";
		}// func
		$thead .= "</tr></thead>";
		
		$tbody = "<tbody>";
		foreach ($flowArr as $key=>$val)
		{
			$tbody .= "<tr>";
			$i = 0;
			foreach ($val as  $row)
			{
				if ($i > 1 && $type == "time" && $row != '-' && $row != '0') $row = formatTiemStr($row);
				$i++;
				$tbody .= "<td style='border:1px solid #000'>{$row}</td>";
			}// func
			$tbody .= "</tr>";
		}// for
		$tbody .= "</tbody>";
		
		echo "<table style='border:1px solid #000'>{$thead}{$tbody}</table>";
		exit;
	}// func
	
	// 显示柜员打印
	private function _printGyTable($flowArr, $type='')
	{
		// Add some data
		$item = array_slice($flowArr, 0, 1);
		$item = array_slice($item[0], 0, 1);
		
		$thead = "<thead><tr>";
		foreach ($item[0] as $key=>$val)
		{
			$thead .= "<td style='border:1px solid #000'>{$key}</td>";
		}// func
		$thead .= "</tr></thead>";
		
		$tbody = "<tbody>";
		foreach ($flowArr as $key=>$val)
		{
			foreach ($val as $key1=>$val1)
			{
				$i = 0;
				$tbody .= "<tr>";
				foreach ($val1 as $row)
				{
					if ($i > 2 && $type == "time" && $row != '-' && $row != '0') $row = formatTiemStr($row);
					$i++;
					$tbody .= "<td style='border:1px solid #000'>{$row}</td>";
				}
				$tbody .= "</tr>";
			}// for
		}// for
		$tbody .= "</tbody>";
		
		echo "<table style='border:1px solid #000'>{$thead}{$tbody}</table>";
		exit;
	}// func
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__).'/../../authed_list.php');

class Device extends CI_Controller {
    var $_userid;
    var $_roleId;

	function __construct()
	{
		parent::__construct();
		$this->load->language(['footer']);
		// 判断用户是否登录
	//	echo 'start:'.microtime();
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
        $this->_userid = $_SESSION[$sid]['userid'];
        //$this->smarty->assign('auths', $_SESSION[$sid]['auths']);
        $this->smarty->assign('admin', $_SESSION[$sid]['username']);
        $this->smarty->assign('roleName', $_SESSION[$sid]['R_name']);
        $this->_roleId = $_SESSION[$sid]['RID'];

		global $roleid;
		$roleid=$this->_roleId;
        
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
		$this->load->model('device/Dmpdj', '_Mdmpdj');
		$this->load->model('device/Pad', '_Mpad');
		$this->load->model('device/Cled', '_Mcled');
		$this->load->model('device/Mled', '_Mmled');
		$this->load->model('device/Adv', '_Madv');
		$this->load->model('Rolefunc', '_Mrolefunc');
		$this->load->model('Roleopt', '_Mroleopt');
		
		$this->load->model('Adminlog', '_Madminlog');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');

		$this->load->model('Language','_Mlanguage');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);
		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		// 加载辅助函数
		$this->load->helper('common');
		
		// 加载语言包
		load_lang('COMMON', $this->smarty, $this);
		load_lang('DEVICE', $this->smarty, $this);
		lang_list($this->smarty);
		
		$orgTree = $this->_Morgrizetree->getOrgTree();

		$this->_orgTreeStr = generateOrgTree($orgTree, 'getDeviceInfo');
		$this->_orgTreeStrCheck = generateOrgTreeCheck($orgTree);
		$this->_orgTreeStrRadio = generateOrgTreeRadio($orgTree,'org_radio');
		$this->smarty->assign('orgTreeStr', $this->_orgTreeStr);
		$this->smarty->assign('orgTreeStrCheck', $this->_orgTreeStrCheck);
		$this->smarty->assign('orgTreeStrRadio', $this->_orgTreeStrRadio);

		// 控制器类型
		$this->smarty->assign('control', 'device');
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		//$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $fcodeArr;
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		global $arr;
		global $language;
		$language=$this->_Mlanguage->getstr();
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid);
		$this->smarty->assign('optArr', $optArr);

		$arr=array(
				'username'=>$_SESSION[$sid]['username'],
				'rolename'=>$_SESSION[$sid]['R_name'],
				'baseurl'=>$this->config->item('base_url'),
				'orgtree'=>$this->_orgTreeStr,
				'timeControl'=> getDayTypeSelect($this),
				'optArr'=>$optArr,
				'orgTreeStrRadio'=>$this->_orgTreeStrRadio,
				'roleId'=>$this->_roleId

		);
		
		if (isset($_GET['type']))
			$this->smarty->assign('type', $_GET['type']);
		else 
			$this->smarty->assign('type', '');
		//echo '  end:'.microtime();
	}
	function getUpgradeFileList()
	{
		$fileList=$this->Client->getUpgradeFile();
		if($fileList[0]["URL"]!="")
		{
			$str='
				<label for="upgratefile">
				终端升级:<select name="upgratefile" id="upgratefile">';
			for($i=0,$n=count($fileList); $i<$n; $i++)
			{
				$str.= '<option value="'.$this->getFtpPath('/'.$fileList[$i]["URL"]).'"';
				if($i==0)
				{
					$str.= 'selected = "selected"';
				}
				$str.= '>'.$fileList[$i]["FileName"].'</option>';
			}
			$str.='
				</select>
			</label>
			<a href="javascript:void(0)"  onclick="controlAjax(\'upgrate\')" class="sbtn_left"><span class="sbtn_right">发送</span></a>
			';
		}
		else { $str = '如果您需要升级终端,请在"资源管理"中上传升级包,O(∩_∩)O谢谢!';}
		return $str;
	}
	public function adMachine(){
		$this->load->model('m_playlist','playlist');
		$this->load->model('m_client','Client');
		$this->load->model('m_userLog','userLog');
		$allClientInfo=$this->Client->getClientInfo();
		//print_r($allClientInfo);
		if(count($allClientInfo))
		{
			for($i=0,$n=count($allClientInfo); $i<$n; $i++)
			{
				foreach($allClientInfo[$i] as $k=>$v)
				{

					if($v==""||$v=="null")
					{
						$emptyList[]=$k;
						$allClientInfo[$i][$k]=" ";

					}
				}
			}
		}
		$data['title']="终端信息";
		$data['clientInfo']=$allClientInfo;
		$data['playList']=$this->playlist->getSendPlayList();
		$data['profile']=$this->Client->getProfile();
		$ftpInfo=$this->db->query("select * from ftp_info group by HostIP")->result_array();
		$inf='';
		$inff='<option value="0">所有FTP</option>';
		$i=0;
		foreach($ftpInfo as $k=>$v)
		{
			$inf.= $i==0?'<option value="'.$v["Extend4"].'" selected="selected">'.$v["Extend1"].'</option>':'<option value="'.$v["Extend4"].'" >'.$v["Extend1"].'</option>';
			$inff.= '<option value="'.$v["Extend4"].'" >'.$v["Extend1"].'</option>';
			$i++;
		}
		//$inf.='</select>';
		$data['ftpInfo'] = $inf ;
		$data['ftpInfoselect']= $inff;
		$data['client']=$this->Client->getAllClient(1);
		$data['clientGroup']=$this->Client->getUserGroup();
		//print_r($data['clientGroup']);
		//孙国安获取升级包
		$data["upgradeFileList"]=$this->getUpgradeFileList();
		$clientID='';
		if(isset($_POST['clientID']) && $_POST['clientID']!=''){
			$clientID=$_POST['clientID'];
		}
		$data['playListID']='';
		$data['shutOnTime']='';
		$data['shutOffTime']='';
		$data['screenResolution']='';
		$data['rotateDirection']='';
		$data['volume']='';

		if($clientID!=''){
			$clientInfo=$this->Client->getClientInfo($clientID);

			$data['playlist']=$clientInfo['clientPlayListID'];
			$data['shutOnTime']=$clientInfo['clientShutOnTime'];;
			$data['shutOffTime']=$clientInfo['clientShutOffTime'];;
			$data['screenResolution']=$clientInfo['clientScreenResolution'];;
			$data['rotateDirection']=$clientInfo['clientRotateDirection'];;
			$data['volume']='';
		}
		global $fcodeArr;
		global $arr;
		$data['www']=$fcodeArr;
		$data['session']=$arr;

		$this->load->view('header',$data);
		$this->load->view('device/lefter_adv');
		$this->load->view('device/righter_adv_ci',$data);
		$this->load->view('footer');

	}
	public function a(){
		$orgIds=$this->_Morgrizetree->getOrgArr(0);
		print_r($orgIds);
		/*foreach($orgIds as $k => $v){
			echo $v."<br>";
			for ($i=0;$i<10;$i++) {
				echo $i;
				$info['PAD_mac'] = $v.rand();
				$info['PAD_sysno'] = $v;
				$info['PAD_addr'] = 1;
				$info['PAD_zzsname'] = 1;
				$info['PAD_zzsPhone'] = 4;
				$info['PAD_fze'] = 0;
				$info['PAD_bz'] = 1;
				//$info['PDJ_type'] = 0;
				$info['PAD_lasttime'] = date('Y-m-d H:i:s');
				$info['PAD_lrtime'] = date('Y-m-d H:i:s');
				//$info['PDJ_lasttime'] = date('Y-m-d H:i:s');
				$this->db->insert($this->_Mpad->_tableName, $info);
			}
			for ($i=0;$i<10;$i++) {
				echo $i;
				$info_PDJ['PDJ_mac'] = $v.rand();
				$info_PDJ['PDJ_sysno'] = $v;
				$info_PDJ['PDJ_ip'] = 1;
				$info_PDJ['PDJ_zzsname'] = 1;
				$info_PDJ['PDJ_zzsPhone'] = 4;
				$info_PDJ['PDJ_fze'] = 0;
				$info_PDJ['PDJ_bz'] = 1;
				//$info['PDJ_type'] = 0;
				$info_PDJ['PDJ_lasttime'] = date('Y-m-d H:i:s');
				$info_PDJ['PDJ_lrtime'] = date('Y-m-d H:i:s');
				//$info['PDJ_lasttime'] = date('Y-m-d H:i:s');
				$this->db->insert($this->_Mdmpdj->_tableName, $info_PDJ);
			}
			for ($i=0;$i<10;$i++) {
				echo $i;
				$info_cled['cLed_mac'] = $v.rand();
				$info_cled['cLed_sysno'] = $v;
				$info_cled['cLed_addr'] = 1;
				$info_cled['cLed_counterNo'] = 1;
				$info_cled['cLed_lineWordNum'] = 4;
				$info_cled['cLed_com'] = 0;
				$info_cled['cLed_LineNum'] = 1;
				$info_cled['cLed_type'] = 0;
				$info_cled['cled_lastHtime'] = date('Y-m-d H:i:s');
				$info_cled['cled_lrtime'] = date('Y-m-d H:i:s');
				$info_cled['cled_lasttime'] = date('Y-m-d H:i:s');
				$this->db->insert($this->_Mcled->_tableName, $info_cled);
			}
			for ($i=0;$i<10;$i++) {
				echo $i;
				$info_mled['mLed_mac'] = $v.rand();
				$info_mled['mLed_sysno'] = $v;
				$info_mled['mLed_addr'] = 1;
				$info_mled['mLed_counterNoArray'] = 1;
				$info_mled['mLed_lineWordNum'] = 4;
				$info_mled['mLed_com'] = 0;
				$info_mled['mLed_LineNum'] = 1;
				$info_mled['mLed_type'] = 0;
				$info_mled['mled_lastHtime'] = date('Y-m-d H:i:s');
				$info_mled['mled_lrtime'] = date('Y-m-d H:i:s');
				$info_mled['mled_lasttime'] = date('Y-m-d H:i:s');
				$this->db->insert($this->_Mmled->_tableName, $info_mled);
			}
		}*/
		//echo ' echo :'.microtime();;
		$this->load->view('welcome_message');
		$this->smarty->display('device/lefter.html');
	}
	public function index()
	{
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
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_list');
		$this->load->view('footer');
		//$this->smarty->display('footer.html');
	}// func
	public function getAdvList(){
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,

		);
		$tabs = $_GET['tabs'];
		$orgId = $_GET['orgId'];	// 网点id
		/*$this->db->where('PDJ_sysno', $orgId);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
        $this->smarty->assign($ret);*/
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$tabs,
				'orgId'=>$orgId,
				//'ret'=>$ret
		);

		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_adv',$data);
		$this->load->view('footer');
	}
	public function getAdvinfos(){
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$this->db->select("`client_tree.TreeNodeSerialID`, `MacAddress`, `client_info.WeekPlaylistID`, `EnableBgTemplate`,
`Volume`, `ShutOnTime`, `ShutOffTime`, `ShutOnTime2`, `ShutOffTime2`,
`ShutOnTime3`, `ShutOffTime3`, `DownLoadTime`, `NetTypeCode`, `FileSaveDirectory`,
`DiskSize`, `DiskFreeSize`, `VMSVersion`, `URL`, `ScreenResolution`, `ResolutionList`,
`ScreenRotation`, `ClientModel`,  `Extend5`,
`Extend6`, `Extend7`, `Screenshot`, `Remark`, `DisPlaySize`, `UserID`, `ClientAddress`,
`Extend10`, `Extend12`, `MachineCode`, `RegCode`, `Extend8`, `SysVersion`, `adv_sysno`,
`Name`, `TreeNodeCode`, `IsClient`,`client_type_id`, `client_type_name`, `WeekPlaylistName`,
`WeekPlaylistType`, `StartDate`, `EndDate`, `PlaylistModel`, `IsChecked`,
 `OwnerUser`, `IP`, `IPType`, `SubnetMask`, `Gateway`, `DNS`,
`ServerIP`, `ServerPort`,
`JG_ID`, `JG_name`, `JG_PID`, `JG_fzr`, `JG_phone`, `JG_lrtime`, `JG_lrUser`, `JG_lasttime`,
`JG_lastUser`, `JG_bz`");
		$this->db->from("client_info");
		$this->db->join('client_tree','client_info.TreeNodeSerialID=client_tree.TreeNodeSerialID','left');
		$this->db->join('client_type','client_type.client_type_id=client_info.ClientModel','left');
		$this->db->join('week_playlist','week_playlist.WeekPlaylistID=client_info.WeekPlaylistID','left');
		$this->db->join('lan_conf','lan_conf.TreeNodeSerialID=client_info.TreeNodeSerialID','left');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=client_info.adv_sysno');
		$this->db->where_in('client_info.adv_sysno', $orgIds);
		//echo $this->db->last_query();
		$query=$this->db->get();
		$ret = $query->result_array();
		//echo $this->db->last_query();
		echo json_encode($ret);
	}
	// 获取网点数据
	public function getOrgInfo()
	{
		$orgId = $_POST['orgId'];
		$this->db->where('JG_ID', $orgId);
		$query = $this->db->get($this->_Morgrizetree->_tableName);
		$ret = $query->row_array();
		
		echo json_encode($ret);
	}// func
	
	// 网点排队机管理首页
	public function getDmpdjList()
	{
		$this->db->where('PDJ_sysno', $_GET['orgId']);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$_GET['tabs'],
				'orgId'=>$_GET['orgId'],
				'ret'=>$ret,
		);
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_dmpdj',$data);
		$this->load->view('footer');
	}// func
//排队机业务管理
	public function getDmpdjmanage()
	{
		$this->db->where('PDJ_sysno', $_GET['orgId']);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$_GET['tabs'],
				'orgId'=>$_GET['orgId'],
				'ret'=>$ret,
		);
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_dmpdjmanage',$data);
		$this->load->view('footer');
	}// func

	//排队机vip客户资料管理
	public function getVipmanage(){
		$this->db->where('PDJ_sysno', $_GET['orgId']);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$_GET['tabs'],
				'orgId'=>$_GET['orgId'],
				'ret'=>$ret,
		);
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/right_vip',$data);
		$this->load->view('footer');
	}

	//获取取号模版
	public function getProfileInfo(){
		$this->db->where('PDJ_sysno', $_GET['orgId']);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
		global $fcodeArr;
		global $arr;
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$_GET['tabs'],
				'orgId'=>$_GET['orgId'],
				'ret'=>$ret,
		);
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_fastProfieInfo',$data);
		$this->load->view('footer');
	}
	
	// 获取排队机设备数据
	public function getDmpdjInfos()
	{
		#echo microtime();
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_dmpdj.PDJ_sysno');
		$this->db->where_in('PDJ_sysno', $orgIds);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$ret = $query->result_array();
		
		echo json_encode($ret);
		//echo time();
	}// func
	
	// 添加排队机数据
	public function addDmpdjInfo()
	{
		$info = $_POST;
		$mac=$_POST['PDJ_mac'];
		$isDrvice=$this->_Mdmpdj->isDevice($mac);
		//echo $this->db->last_query();
		if (!is_bool($isDrvice)){
			$has_JG= $this->_Mdmpdj->has_JG($mac,$isDrvice);
				if (is_bool($has_JG)) {
					$res=$this->_Mdmpdj->updateSysno($mac,$_POST['orgId']);
						if ($res){
							showInfo(true,'','更新成功');
						} else {
							showInfo(false,'','更新失败');
						}
				} else {
					//这里增加机构的查询，提示存在的机构

					showInfo(false,'','该设备已存在机构：'.$isDrvice['JG_name'].
							"\n\r".'你不能添加已存在机构的设备，因为一台设备不可能出现在两个机构'.
							"\n\r".'请联系相关工作人员对设备进行删除后再添加'
					);
				}
		} else {
			showInfo(false,'','不存在的机器');
		}
		$this->_Madminlog->add_log($this->_userid, "添加排队机:".json_encode($info));
	}// func
	
	// 保存保存对排队机设备信息的修改
	public function saveDmpdjInfo(){
		$info = $_POST;
		try{
			$paramId = $info['paramId'];
			unset($info['paramId']);
			$orgId = $info['orgId'];
			unset($info['orgId']);
			$info['PDJ_lasttime'] = date('Y-m-d H:i:s');
			$info['PDJ_sysno'] = $info['new_sysno'];
			unset($info['new_sysno']);
			$this->db->update($this->_Mdmpdj->_tableName, $info, array('PDJ_mac'=> $paramId, 'PDJ_sysno'=>$orgId));
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		
		$this->_Madminlog->add_log($this->_userid, "修改排队机:{$paramId}");
	}// func
	
	// 删除排队机设备的信息
	public function deleteDmpdjInfo()
	{
		$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$res=$this->_Mdmpdj->clearSysno(explode(',',$params));
		if ($res){
			showInfo(true,'','删除成功');
		}else{
			showInfo(false,'','删除失败');
		}
		$this->_Madminlog->add_log($this->_userid, "删除排队机:{$params}");
	}// func
	// -------------------------------------------------------------------------------------------
	// 网点呼叫器管理首页
	public function getPadList()
	{
		global $fcodeArr;
		global $arr;
		$tabs = $_GET['tabs'];
		$orgId = $_GET['orgId'];
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$tabs,
				'orgId'=>$orgId,// 网点id
		);


		$this->db->where('PAD_sysno', $orgId);
		$query = $this->db->get($this->_Mpad->_tableName);
		$ret = $query->result_array();
	
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_pad');
		$this->load->view('footer');
	}// func
	
	// 获取呼叫器设备数据
	public function getPadInfos()
	{
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_pad.PAD_sysno');
		$this->db->where_in('PAD_sysno', $orgIds);
		$query = $this->db->get($this->_Mpad->_tableName);
		$ret = $query->result_array();
	
		echo json_encode($ret);
	}// func
	
	// 添加呼叫器数据
	public function addPadInfo()
	{
		$info = $_POST;
		$mac=$_POST['PAD_mac'];
		$isDrvice=$this->_Mpad->isDevice($mac);
		if (!is_bool($isDrvice)){
			$has_JG= $this->_Mpad->has_JG($mac,$isDrvice);
			if (is_bool($has_JG)) {
				$res=$this->_Mpad->updateSysno($mac,$_POST['orgId']);
				if ($res){
					showInfo(true,'','更新成功');
				} else {
					showInfo(false,'','更新失败');
				}
			} else {
				//这里增加机构的查询，提示存在的机构
				showInfo(false,'','该机构已存在机构');
			}
		} else {
			showInfo(false,'','不存在的机器');
		}
		/*try{
			$info['PAD_sysno'] = $_POST['orgId'];
			unset($info['orgId']);
			$info['PAD_counterNo'] = 1;
			$info['PAD_com'] = 0;
			$info['PAD_LineNo'] = 1;
			$info['PAD_type'] = 0;
			$info['PAD_lastHtime'] = date('Y-m-d H:i:s');
			$info['PAD_lrtime'] = date('Y-m-d H:i:s');
			$info['PAD_lasttime'] = date('Y-m-d H:i:s');
			$this->db->insert($this->_Mpad->_tableName, $info);
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		*/
		$this->_Madminlog->add_log($this->_userid, "添加呼叫器:".json_encode($info));
	}// func
	
	// 保存保存对呼叫器设备信息的修改
	public function savePadInfo(){
		$info = $_POST;
		$paramId = $info['paramId'];
		unset($info['paramId']);
		$orgId = $info['orgId'];
		unset($info['orgId']);
		$info['PAD_sysno'] = $info['new_sysno'];
		unset($info['new_sysno']);
		$info['PAD_lrtime'] = date('Y-m-d H:i:s');
		$this->db->update($this->_Mpad->_tableName, $info, array('PAD_mac'=> $paramId, 'PAD_sysno'=>$orgId));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改呼叫器:{$paramId}");
	}// func
	
	// 删除呼叫器设备的信息
	public function deletePadInfo()
	{

		$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$res=$this->_Mpad->clearSysno(explode(',',$params));
		if ($res){
			showInfo(true,'','删除成功');
		}else{
			showInfo(false,'','删除失败');
		}
		/*
		$this->db->where('PAD_sysno', $orgId);
		$this->db->where("PAD_mac in ({$params})");
		$this->db->delete($this->_Mpad->_tableName);
		echo $this->db->affected_rows();
		*/
		$this->_Madminlog->add_log($this->_userid, "删除呼叫器:{$params}");
	}// func
	
	// -------------------------------------------------------------------------------------------
	// 网点窗口LED管理首页
	public function getCledList()
	{
		global $fcodeArr;
		global $arr;
		$tabs = $_GET['tabs'];
		$orgId = $_GET['orgId'];	// 网点id
		$this->db->where('cLed_sysno', $orgId);
		$query = $this->db->get($this->_Mcled->_tableName);
		$ret = $query->result_array();
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$tabs,
				'orgId'=>$orgId,
				'ret'=>$ret
		);
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_cled',$data);
		$this->load->view('footer');
	}// func
	
	// 获取呼叫器设备数据
	public function getCledInfos()
	{
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_cLed.cLed_sysno');
		$this->db->where_in('cLed_sysno', $orgIds);
		$query = $this->db->get($this->_Mcled->_tableName);
		$ret = $query->result_array();
	
		echo json_encode($ret);
	}// func
	
	// 添加呼叫器数据
	public function addCledInfo()
	{
		$info = $_POST;
		$mac=$_POST['cLed_mac'];
		$isDrvice=$this->_Mcled->isDevice($mac);
		if (!is_bool($isDrvice)){
			$has_JG= $this->_Mcled->has_JG($mac,$isDrvice);
			if (is_bool($has_JG)) {
				$res=$this->_Mcled->updateSysno($mac,$_POST['orgId']);
				if ($res){
					showInfo(true,'','更新成功');
				} else {
					showInfo(false,'','更新失败');
				}
			} else {
				//这里增加机构的查询，提示存在的机构
				showInfo(false,'','该机构已存在机构');
			}
		} else {
			showInfo(false,'','不存在的机器');
		}
		/*$info = $_POST;
		$info['cLed_sysno'] = $_POST['orgId'];
		try{
			unset($info['orgId']);
			$info['cLed_counterNo'] = 1;
			$info['cLed_com'] = 0;
			$info['cLed_LineNo'] = 1;
			$info['cLed_type'] = 0;
			$info['cled_lastHtime'] = date('Y-m-d H:i:s');
			$info['cled_lrtime'] = date('Y-m-d H:i:s');
			$info['cled_lasttime'] = date('Y-m-d H:i:s');
			$this->db->insert($this->_Mcled->_tableName, $info);
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		*/
		$this->_Madminlog->add_log($this->_userid, "添加窗口LED:".json_encode($info));
	}// func
	
	// 保存保存对呼叫器设备信息的修改
	public function saveCledInfo(){
		$info = $_POST;
		$paramId = $info['paramId'];
		try{
			unset($info['paramId']);
			$orgId = $info['orgId'];
			unset($info['orgId']);
			$info['cLed_sysno'] = $info['new_sysno'];
			unset($info['new_sysno']);
			$info['cled_lrtime'] = date('Y-m-d H:i:s');
			$this->db->update($this->_Mcled->_tableName, $info, array('cLed_mac'=> $paramId, 'cLed_sysno'=>$orgId));
			echo $this->db->last_query();
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		
		$this->_Madminlog->add_log($this->_userid, "修改窗口LED:{$paramId}");
	}// func
	
	// 删除呼叫器设备的信息
	public function deleteCledInfo()
	{
		$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$res=$this->_Mcled->clearSysno(explode(',',$params));
		if ($res){
			showInfo(true,'','删除成功');
		}else{
			showInfo(false,'','删除失败');
		}
		/*$params = $_POST['params'];
		$orgId = $_POST['orgId'];

		/*$this->db->where('cLed_sysno', $orgId);
		$this->db->where("cLed_mac in ({$params})");
		$this->db->delete($this->_Mcled->_tableName);
		echo $this->db->affected_rows();*/
		//由于设备将更改为主动上线，该处更改为去除设备的机构ID达到不显示的效果

		$this->_Madminlog->add_log($this->_userid, "删除窗口LED:{$params}");
	}// func
	
	// -------------------------------------------------------------------------------------------
	// 网点主LED管理首页
	public function getMledList()
	{
		global $fcodeArr;
		global $arr;

		$tabs = $_GET['tabs'];
		$orgId = $_GET['orgId'];	// 网点id
		$this->db->where('mLed_sysno', $orgId);
		$query = $this->db->get($this->_Mmled->_tableName);
		$ret = $query->result_array();
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$tabs,
				'orgId'=>$orgId,
				'ret'=>$ret

		);
	
		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_mled',$data);
		$this->load->view('footer');
	}// func
	
	// 获取呼叫器设备数据
	public function getMledInfos()
	{
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_mLed.mLed_sysno');
		$this->db->where_in('mLed_sysno', $orgIds);
		$query = $this->db->get($this->_Mmled->_tableName);
		$ret = $query->result_array();
	
		echo json_encode($ret);
	}// func
	
	// 添加呼叫器数据
	public function addMledInfo()
	{
		$info = $_POST;
		$mac=$_POST['mLed_mac'];
		$isDrvice=$this->_Mmled->isDevice($mac);
		if (!is_bool($isDrvice)){
			$has_JG= $this->_Mmled->has_JG($mac,$isDrvice);
			if (is_bool($has_JG)) {
				$res=$this->_Mmled->updateSysno($mac,$_POST['orgId']);
				if ($res){
					showInfo(true,'','更新成功');
				} else {
					showInfo(false,'','更新失败');
				}
			} else {
				//这里增加机构的查询，提示存在的机构
				showInfo(false,'','该机构已存在机构');
			}
		} else {
			//echo $this->db->last_query();
			showInfo(false,'','不存在的机器');
		}
		/*$info = $_POST;
		$info['mLed_sysno'] = $_POST['orgId'];
		unset($info['orgId']);
		try{
			$info['mLed_lineWordNum'] = 4;
			$info['mLed_com'] = 0;
			$info['mLed_LineNum'] = 1;
			$info['mLed_type'] = 0;
			$info['mled_lastHtime'] = date('Y-m-d H:i:s');
			$info['mled_lrtime'] = date('Y-m-d H:i:s');
			$info['mled_lasttime'] = date('Y-m-d H:i:s');
			$this->db->insert($this->_Mmled->_tableName, $info);
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		*/
		$this->_Madminlog->add_log($this->_userid, "添加主LED:".json_encode($info));
	}// func
	
	// 保存保存对呼叫器设备信息的修改
	public function saveMledInfo(){
		$info = $_POST;
		$paramId = $info['paramId'];
		try{
			unset($info['paramId']);
			$orgId = $info['orgId'];
			unset($info['orgId']);
			$info['mLed_sysno'] = $info['new_sysno'];
			unset($info['new_sysno']);
			$info['mled_lrtime'] = date('Y-m-d H:i:s');
			$this->db->update($this->_Mmled->_tableName, $info, array('mLed_mac'=> $paramId, 'mLed_sysno'=>$orgId));
			echo $this->db->affected_rows();
		}catch(Exception $e){
			echo 0;
		}
		
		$this->_Madminlog->add_log($this->_userid, "修改主LED:{$paramId}");
	}// func
	
	// 删除呼叫器设备的信息
	public function deleteMledInfo()
	{
		$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$res=$this->_Mmled->clearSysno(explode(',',$params));
		if ($res){
			showInfo(true,'','删除成功');
		}else{
			showInfo(false,'','删除失败');
		}
		/*$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$this->db->where('mLed_sysno', $orgId);
		$this->db->where("mLed_mac in ({$params})");
		$this->db->delete($this->_Mmled->_tableName);
		echo $this->db->affected_rows();*/
		
		$this->_Madminlog->add_log($this->_userid, "删除主LED:{$params}");
	}// func

	public function addAdvInfo()
	{
		$info = $_POST;
		$mac=$_POST['MachineCode'];
		$isDrvice=$this->_Madv->isDevice($mac);
		if (!is_bool($isDrvice)){
			$has_JG= $this->_Madv->has_JG($mac,$isDrvice);
			if (is_bool($has_JG)) {
				$res=$this->_Madv->updateSysno($mac,$_POST['orgId']);
				if ($res){
					showInfo(true,'','更新成功');
				} else {
					showInfo(false,'','更新失败');
				}
			} else {
				//这里增加机构的查询，提示存在的机构
				showInfo(false,'','该机构已存在机构');
			}
		} else {
			showInfo(false,'','不存在的机器');
		}
		$this->_Madminlog->add_log($this->_userid, "添加主LED:".json_encode($info));
	}// func
	function deleteAdvInfo(){
		$params = $_POST['params'];
		$orgId = $_POST['orgId'];
		$res=$this->_Madv->clearSysno(explode(',',$params));
		if ($res){
			showInfo(true,'','删除成功');
		}else{
			showInfo(false,'','删除失败');
		}
		$this->_Madminlog->add_log($this->_userid, "删除广告机:{$params}");
	}
	function saveAdvInfo(){
		$orgId = $_POST['orgId'];
		$res=$this->_Madv->updateNameByMachineCode($_POST['MachineCode'],$_POST['name']);
		if ($res){
			showInfo(true,'','修改成功');
		}else{
			showInfo(false,'','修改失败');
		}
		$this->_Madminlog->add_log($this->_userid, "修改广告机:{$_POST['MachineCode']}");
	}
	function getAllList(){
		global $fcodeArr;
		global $arr;

		$tabs = $_GET['tabs'];
		$orgId = $_GET['orgId'];	// 网点id
		$data=array(
				'www'=>$fcodeArr,
				'session'=>$arr,
				'tabs'=>$tabs,
				'orgId'=>$orgId,

		);

		$this->load->view('header',$data);
		$this->load->view('device/lefter',$data);
		$this->load->view('device/righter_all',$data);
		$this->load->view('footer');
	}
	function getAllInfo(){
		$orgId = $_POST['orgId'];
		$orgIds=$this->_Morgrizetree->getOrgArr($orgId);
		$i=0;
		$res=array();
		$this->db->select('mLed_mac as deviceKey , mLed_addr as addr , mLed_bz as bz, JG_ID as sysno ,JG_name');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_mLed.mLed_sysno');
		$this->db->where_in('mLed_sysno', $orgIds);
		$query = $this->db->get($this->_Mmled->_tableName);
		$mLed_ret = $query->result_array();
		foreach ($mLed_ret as $k=>$v){
			$v['deviceType']='主LED';
			array_push($res,$v);
		}
		//adv
		//$this->db->select("*");
		$this->db->select('MachineCode as deviceKey , IP as addr , Name as bz , JG_ID as sysno,JG_name');
		$this->db->from("client_info");
		$this->db->join('client_tree','client_info.TreeNodeSerialID=client_tree.TreeNodeSerialID','left');
		$this->db->join('client_type','client_type.client_type_id=client_info.ClientModel','left');
		$this->db->join('week_playlist','week_playlist.WeekPlaylistID=client_info.WeekPlaylistID','left');
		$this->db->join('lan_conf','lan_conf.TreeNodeSerialID=client_info.TreeNodeSerialID','left');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=client_info.adv_sysno');
		$this->db->where_in('client_info.adv_sysno', $orgIds);
		$query=$this->db->get();
		$adv_ret = $query->result_array();
		foreach ($adv_ret as $k=>$v){
			$v['deviceType']='广告机';
			array_push($res,$v);
		}

		$this->db->select('PDJ_mac as deviceKey , PDJ_ip as addr , PDJ_bz as bz , JG_ID as sysno,JG_name');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_dmpdj.PDJ_sysno');
		$this->db->where_in('PDJ_sysno', $orgIds);
		$query = $this->db->get($this->_Mdmpdj->_tableName);
		$PDJ_ret = $query->result_array();
		foreach ($PDJ_ret as $k=>$v){
			$v['deviceType']='排队机';
			array_push($res,$v);
		}

		$this->db->select('PAD_mac as deviceKey , PAD_addr as addr , PAD_bz as bz , JG_ID as sysno,JG_name');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_pad.PAD_sysno');
		$this->db->where_in('PAD_sysno', $orgIds);
		$query = $this->db->get($this->_Mpad->_tableName);
		$PAD_ret = $query->result_array();
		foreach ($PAD_ret as $k=>$v){
			$v['deviceType']='呼叫器';
			array_push($res,$v);

		}

		$this->db->select('cLed_mac as deviceKey , cLed_addr as addr , cLed_bz as bz , JG_ID as sysno,JG_name');
		$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_cLed.cLed_sysno');
		$this->db->where_in('cLed_sysno', $orgIds);
		$query = $this->db->get($this->_Mcled->_tableName);
		$cLedret = $query->result_array();
		foreach ($cLedret as $k=>$v){
			$v['deviceType']='窗口LED';
			array_push($res,$v);

		}

		echo json_encode($res);

	}

	//测试获取机构列表
	function getAll(){
		/*$res=$this->_Morgrizetree->getOrgTree();
		print_r($res);*/
		//$this->db->select('JG_PID');
		$this->db->order_by('JG_PID', 'asc');
		$query = $this->db->get('Sys_orgrizeTree');
		$res = $query->result_array();
		$ids=array();
		$ids[]='01';
		$jg=array();
		$jgp=array();
		//preg_grep($res[$key]['JG_PID']);
		foreach ($res as $key => $val){
			$jg[]=$res[$key]['JG_ID'];
			$jgp[]=$res[$key]['JG_PID'];
			$ff=$res[$key]['JG_PID'];
			$res2=preg_grep("/^$ff$/",$ids);
			if (count($res2)>0){
				$ids[]=$res[$key]['JG_ID'];
				//echo 'ids'.print_r($ids,true).'ss';
			}
			//echo $res[$key]['JG_PID'].' ';
		}
		echo 'ids'.print_r($ids,true).'ss';
	/*	foreach ($jgp as $v){

		}*/
		//print_r($jg);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
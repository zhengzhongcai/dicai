<?php
class Client extends CI_Controller{
	function __construct(){
		parent::__construct();
		//$this->load->model('m_socket','cc');
		$this->load->model('m_playlist','playlist');
		$this->load->model('m_client','Client');
		$this->load->model('m_userLog','userLog');
	}
	function a(){ 
	$info=$this->Client->allClientTreea();
	echo Information("----------",$info);
	}
	/*function index(){
		$data['title']='终端树';
		$data['client']=$this->Client->getAllClient(1);
		$data['clientGroup']=$this->Client->getAllClient(0);
		//exit();
		$this->load->view('clientTree_V',$data);
	}*/
	//---------------------------------------
	//
	//	查询用户当前的FTP信息
	//
	//---------------------------------------
	function getFtpPath($file=""){	
		
		@session_start();
		$wher=array("PrimaryFTP"=>"1","UserID"=>$_SESSION["opuserID"]);
		//echo Information("getFtpPath shere",$wher);
		$this->db->select("*");
		$this->db->where($wher);
		$info=$this->db->get("ftp_info")->result_array();
		//echo Information("getFtpPath result",$info);
		//exit();
		$ftpUser=$info[0]["UserName"];
		$ftpPwd=$info[0]["Password"];
		$ftpServer=$info[0]["HostIP"];
		$ftp="ftp://$ftpUser:$ftpPwd@$ftpServer";	
		$ftppath=$ftp.$file;
		return $ftppath;
	}
	function extTree(){
		$id=$this->uri->segment(4, 0);
		$this->Client->createExtTree($id);
	}
	function index2(){
		//$this->Client->showClientTree2();
		//$data['treeNode']=$this->Client->treeNode;
		//$data['groupNode']=$this->Client->groupNode;
		//echo $this->Client->treeNode;
		//pArr($data);
		$this->load->view('treeNode');
	}
	//对终端组进行操作之后刷新
	function showClientTree2(){
		$this->Client->showClientTree2();
		echo $this->Client->treeNode2;
		//echo "###";
		//echo $this->Client->groupNode;
	}
	//从某一个组中注销终端
	function logoutClient()
	{
		$this->Client->logoutClient($_POST['clientID']);
	}
	function showClientTree(){
		echo ('<ul><a href=# id="0001">root</a>');
		$this->Client->showClientTree();
		echo ("</ul>");
	}
		//孙国安
	function updateClientName(){
		$state=$this->Client->updateClientName($_POST['clientID'],$_POST['Name']);
		//print_r($state);
		if($state[0]=="true") 
		{
			echo 1;
			//$this->userLog->updateClientNameLog($state,1);
		}
		else { 
		//$this->userLog->updateClientNameLog($state,0);
		echo 0;}
	}
	function updateName(){
		$this->Client->updateName($_POST['clientID'],$_POST['newName']);
	}
	function addGroup(){		
		$res=$this->Client->addGroup($_POST['clientID'],$_POST['newName']);
		echo $res;

	}
	function deleteGroup(){		
		$this->Client->deleteGroup($_POST['clientID']);
	}
/**	//zhangli
	function forDelete(){
		$this->Client->forDelete($_POST['clientID']);
	}
**/
	function deleteClient(){		
		$this->Client->deleteClient($_POST['clientID']);
	}
	function moveGroup(){
		$this->Client->moveGroup($_POST['groupNode'],$_POST['newGroupNode']);
		//$this->Client->moveGroup();
	}
	//dsy---$_POST['groupName']
	function moveClients(){
		$this->Client->moveClients($_POST['clients'],$_POST['groupNode'],$_POST['clientName'],$_POST['groupName']);
	}
	
				
	function getClientInfoJson(){
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

		//$data['clientInfo']=json_encode($data['clientInfo']);
		//$data['clientGroup']=json_encode($data['clientGroup']);
		$data['state']=true;
		echo json_encode($data);
		//echo json_encode($data);
	}
	function getClientInfo(){
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

		//print_r($allClientInfo);
		//echo 'aa'.json_encode($allClientInfo,true);
		//echo json_last_error();
		//exit();
		
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
		//echo json_encode($data);
		$this->load->view('clientInfo',$data);
	}
	//sunguoan
	function getClientInfo_s(){
		@session_start();		
		
		$allClientInfo=$this->Client->getClientInfo();		
		$data['title']="终端信息";
		$data['clientInfo']=$allClientInfo;
		$data['playList']=$this->Client->getPlayList();
		$data['profile']=$this->Client->getProfile();

		$data['client']=$this->Client->getAllClient(1);
		$data['clientGroup']=$this->Client->getUserGroup();

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
		$this->load->view('clientInfo_s',$data);
	}
	//结束
	function getClientInfoAjax(){
		$allClientInfo=$this->Client->getClientInfo();
		$output=
		'<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td width="8%" height="20" bgcolor="d3eaef" class="STYLE10"><div align="center">
          <!--input type="checkbox" name="checkbox" id="checkbox" onchange="checkAll(this.name,clientID)"--/>终端编号
        </div></td>
        <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">分组</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">终端描述</span></div></td>
        <td width="8%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放计划</span></div></td>
        <td width="6%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">终端类型</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">Mac地址</span></div></td>
         <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">终端IP</span></div></td>
        <td width="5%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">状态</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">上下线时间</span></div></td>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">基本操作</span></div></td>
      </tr>';
         $tds='<td height="20" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
		 $tde='</div></td>';
		foreach($allClientInfo as $client){
		$status=$client['clientStatus']>0?'上线':'下线';
		$img=$client['clientStatus']>0?'<img src="images/on.gif">':'';

       $output.='<tr><td height="20" bgcolor="#FFFFFF" id="'.$client['clientNum'].'"><div align="center"><input type="checkbox" name="clientID" value="'.$client['clientNum'].'"/>'.$client['clientNum'].$img.
        $tde;
         $output.= $tds. $client['clientNode'].$tde;
		 $output.= $tds. $client['clientName'].$tde;
		 $output.= $tds. $client['clientProfile'].$tde;
		 $output.= $tds. $client['clientType'].$tde;
		 $output.= $tds. $client['clientMac'].$tde;
		 $output.= $tds. $client['clientIP'].$tde;
		 $output.= $tds. $status.$tde;
		 $output.= $tds. '00-00-00,00:00:00'.$tde;
		 $output.= $tds.'<a href=/CI/index.php/socket/getFilesInfo/'.$client['clientNum'].' target=_blank>文件</a> | <a href=/CI/index.php/client/getClientLogs/'.$client['clientNum'].' target=_blank>日志</a>'.$tde.'</tr>';
		}
		$output.='</table>';
		echo $output;
	}
	function getClientLogs($of=0,$page=0){
		//echo "p".$page;

		//$clientID=$this->uri->segment(3, 0);
		$clientID=$this->input->get('client_id');
		$per_page=$this->input->get('per_page');
		if (isset($per_page)){$page=$per_page;};
		//echo "p2".$per_page;
		//$of=$this->uri->segment(4, 0);
		//分页
		$this->load->library('pagination');
		$config['base_url'] = site_url('control=client&action=getClientLogs&client_id='.$clientID);
		$config['total_rows'] = $this->Client->getClientLogs($clientID,"1");
		$config['per_page'] = '22';
		$config['num_links'] = 2;
		//$config['uri_segment'] = 4;
		$this->pagination->initialize($config);
		$clientLogs=$this->Client->getClientLogs($clientID,"0",$page,$config['per_page']);
		//分页

		//$userInfo=$this->User->getUserInfo($condition,$of,$config['per_page']);

		$data['pagination'] = $this->pagination->create_links()?$this->pagination->create_links():'共1页 '.$config['total_rows'].'条记录';
		$data['version']=$this->Client->getClientVersion($clientID);
		$data['clientID']=$clientID;
		$data['title']='日志信息-'.$clientID;
		$data['of']=$of;
		$data['page']=$page;
		$data['clientLogs']=$clientLogs;

		$this->load->view('clientLogs',$data);
	}
	//--------------------------------------------------------
	//-- 终端日志
	//-- update by mobo 2011年1月17日10:39:24
	//--------------------------------------------------------
	function getClientLog($arg)
	{
		//-- $where["clientID"] string 终端ID
		//-- $where["InfoType"] int 信息编号
		//-- $where["startTime"] string 开始时间
		//-- $where["endTime"] string 结束时间
		//-- $where["info"] string 日志内容
		//-- $where["name"] string 终端名称
		$arg=explode("&",$arg);
		$arg=implode('","',$arg);
		$arg=explode("=",$arg);
		$arg=implode('":"',$arg);
		$arg='{"'.$arg.'"}';
		$arg=json_decode($arg,true);
		//echo print_r($arg);exit();
		//var_dump($arg);exit();
		$where["clientID"]=$arg["cid"];
		$where["InfoType"]=$arg["ity"]!="a"?$arg["ity"]:"";
		$where["startTime"]=$arg["stm"];
		$where["endTime"]=$arg["etm"];
		$where["info"]=$arg["txt"];
		$where["clientName"]=$arg["nm"];
		$where["maintainer"]=$arg["maintainer"];
		$where["excel"]="0";//不是导出Excel
		$where["pageSize"]="19";
		$where["pageStart"]=($arg["current"]*1-1)*19;
		$DATA["data"]=$this->Client->getClientLog($where);
		$DATA["data"]["pageSize"]=$where["pageSize"];
		$this->load->view("clientLogSouce",$DATA);
	}
	
    //--------------------------------------------------------
	//-- 终端日志Excel
	//-- update by mobo 2011年1月17日10:39:24
	//--------------------------------------------------------
	function OutExcelClientLog($arg)
	{
		//-- $where["clientID"] string 终端ID
		//-- $where["InfoType"] int 信息编号
		//-- $where["startTime"] string 开始时间
		//-- $where["endTime"] string 结束时间
		//-- $where["info"] string 日志内容
		//-- $where["name"] string 终端名称
		
		$arg=explode("&",$arg);
		$arg=implode('","',$arg);
		$arg=explode("=",$arg);
		$arg=implode('":"',$arg);
		$arg='{"'.$arg.'"}';
		$arg=json_decode($arg,true);
		
		$where["clientID"]=$arg["cid"];
		$where["InfoType"]=$arg["ity"]!="a"?$arg["ity"]:"";
		$where["startTime"]=$arg["stm"];
		$where["endTime"]=$arg["etm"];
		$where["info"]=$arg["txt"];
		$where["name"]=$arg["nm"];
		$where["excel"]="1";//导出Excel
		//$where["pageSize"]="19";
		//$where["pageStart"]=($arg["current"]*1-1)*19;
		$DATA["data"]=$this->Client->getClientLog($where);
		//$DATA["data"]["pageSize"]=$where["pageSize"];
		$this->load->view("outExcelClientLog",$DATA);
	}
	
	/// <summary>
    /// 读取终端日志
    /// </summary>
    /// <param name="s"></param>
    /// <param name="i"></param>
    /// <returns></returns>
	function goToClientLogUI()
	{
		$zTpArr=clientLog();
		
		$cZuoType='';
		$i=0;
		foreach($zTpArr as $k=>$v)
		{
			$cZuoType.="{title:'$v',value:'$k'}";
			
			if($i!=count($zTpArr)-1)
			{$cZuoType.=",";}
			$i++;
		}
		$DATA["TP"]="[$cZuoType]";
		$this->load->view("clientLog",$DATA);
	}
	
	
	function deleteLogs(){
		$action=$_POST['actions']; //action被CI系统应用了
		if($action=='deleteAll'){
			$this->Client->deleteLogs($_POST['clientID']);
		}else{
			$this->Client->deleteLogsByTime($_POST['clientID'],$_POST['startTime'],$_POST['endTime']);
		}
	}
	function getClientLogsAjax($page=0){
		$clientID=$_POST['clientID'];
		$clientLogs=$this->Client->getClientLogs($clientID,"0",$page,25);
		echo header("Content-type: text/html; charset=utf-8");
		$output='<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
      <tr>
        <td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">消息类型</span></div></td>
        <td width="40%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">日志信息</span></div></td>
        <td width="20%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">时间</span></div></td>
       <tr>';
	   	$tds='<td height="20" align="left" bgcolor="#FFFFFF" class="STYLE19"><div align="center">';
		$tde='</div></td>';
	   	foreach($clientLogs as $log){
		 	$txt=$log['text'];
			$info=$log['infoType'];
		 	$output.='<tr>';
			$output.=$tds.$info.$tde;
			$output.='<td height="20" align="left" bgcolor="#FFFFFF" class="STYLE19"><div>'.$txt.$tde;
			$output.=$tds.$log['time'].$tde;
			$output.='</tr>';
		}
		$output.='</table>';
		echo $output;
	}
	function setDownLoadTime(){
		$this->Client->setDownLoadTime($_POST['clientIDs'],$_POST['dTime']);
	}

	function insertled()
	{
		$iPicColor = 3;			//灯色彩
		$newfileName = substr(time(),-7,7).rand(0,9).'.R01'; //生成的文件名
		$saveFolder = 'FileLib';
		$astr = array();
		$str = iconv('utf-8','gb2312',$this->input->post('txt'));	//文本
		$scroll = $this->input->post('direction');	//播放类型
		$speed = $this->input->post('scrollamount');	//滚动速度
		$delaytime = $this->input->post('delayTime');   //停留时间
		$playtime = $this->input->post('repalyCount');  //播放时长
		$width = $this->input->post('width');  //宽
		$height = $this->input->post('height');	//高
		$str = str_replace(array("\r\n", "\n", "\r"),"",$str);//过滤换行符
		$params = array();
		$params['str'] = $str;
		$params['fontsize'] = $this->input->post('fontsize');	//字体大小
		$params['width'] = $width;	//led长
		$params['height'] = $height;	//len宽
		$params['font'] = iconv('utf-8','gb2312',$this->input->post('font'));	//字体
		$this->load->library('txtsplit', $params);
		if($scroll=="3")//左滚动
		{
			$w = $this->txtsplit->imageboxw();//获取宽
			$iPictures = ceil($w/$width);
			$astr[0] = $str;
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
		}
		else//上滚动
		{
			$this->txtsplit->split();
			$astr = $this->txtsplit->datas;
			$iPictures = count($astr);
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
			//echo var_dump($astr);
		}
		//上传
		$fileFullPath=FILELIB.$newfileName;
		$ftpfileFullPath=FTPLED.$newfileName;
		//echo "<br>".$fileFullPath."<br>";
		//echo $ftpfileFullPath;
		$this->load->library('ftp');
		$config['hostname'] = $this->config->item('ftpServer');
		$config['username'] = $this->config->item('ftpUser');
		$config['password'] = $this->config->item('ftpPwd');
		$config['debug'] = TRUE;
		$this->ftp->connect();
		$this->ftp->upload($fileFullPath,$ftpfileFullPath);//本地地址，ftp地址
		//删除led字幕包
		//$md5=md5_file($fileFullPath);
		unlink($fileFullPath);

		$ftpfileFullPath='ftp://'.$config['username'].':'.$config['password'].'@'.$config['hostname'].":21".$ftpfileFullPath;
		$this->load->model('m_socket','Socket');
		$clientID=$this->input->post('clientID');
		$postArr=array("params"=>array("TextFileURL"=>$ftpfileFullPath,
									   "InsertPlayTimes"=>$playtime,
									   "Rect"=>array($width,$height,$speed,$delaytime),
									   "FontStyle"=>'',
									   "FontSize"=>$scroll,
									   "BackGroundColer"=>0,
									   "ForeGroundColer"=>0,
									   "ScrollSpeed"=>0),
					   "clientID"=>$clientID,
					   "command"=>"ledTxt"); //socket命令
		$this->Socket->controlClients($postArr);
		//return $md5;
	}
	//终端升级 文件列表
	// 2010年11月27日18:47:39 by 莫波  ---> 修改于 孙国安
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
	//方法已转移到 playlist.php中
	//将临时表数据复制到正式表里
	function upTemPlayList()
	{
	   // var_dump($_POST["PlayListID"]);exit;
		$playlistid = $_POST["PlayListId"];
        $this->Client->upTemPlayList($playlistid);
	}
	
	//添加终端播放计划
	function AddClientPlayList()
	{
	    $playlistid = $_POST["PlayListId"];
	    $clientid = $_POST["ClientID"];
        $this->Client->AddClientPlayList($playlistid,$clientid);
	}
	
	// //清除终端播放计划
	// function deleteclientplaylist()
	// {
	    // $clientid = $_POST["ClientID"];
        // $this->Client->deleteclientplaylist($clientid);
	// }
	
	function getClientID()
	{
	    $clientcode = $_POST["clientcode"];
        echo $this->Client->getClientID($clientcode);
	}
	
	function getClientByID()
	{
	    $id = $_POST["id"];
        echo $this->Client->getClientByID($id);
	}
	
	function getClientMaintainerList()
	{
         $this->Client->getClientMaintainerList();
	}
	
	//添加或修改终端维护人员,终端地址,尺寸,备注
	function updateClientMaintainer()
	{
	     $id = $_POST['id'];
		 $address = $_POST['address'];
		 $name = $_POST['name'];
		 $displaysize = $_POST['displaysize'];
		 $remark = $_POST['remark'];
	     $this->Client->updateClientMaintainer($id,$address,$name,$displaysize,$remark);
	}
	
	//设置终端ftp服务器
	function setclientftp()
	{
	     $ftp = $_POST['ftp'];
		 $clients = $_POST['clientID'];
		 $this->Client->setclientftp($clients,$ftp);
		 
	}
	
	//获取终端播放文件信息
    //及终端在线情况信息
	function getclientplayinfo()
	{
	     $clientid = $_POST['clientid'];
		 $clientname = $_POST['clientname'];
		 $starttime = $_POST['starttime'];
		 $endtime = $_POST['endtime'];
		 $where['clientid']=$clientid;
		 $where['name']=$clientname;
		 $where['startTime']=$starttime;
		 $where['endTime']=$endtime;
		 $clientLogsInfo = $this->Client->getclientplayinfo($where);
		
		 if($clientLogsInfo == '')
		 {
		     echo '';
		 }
		 else
		 {
		    echo json_encode($clientLogsInfo);
		 }
	}
	
	
	function loadclientplayinfo()
	{
         $this->load->view("clientPlayInfo");
	}
	
	function getclientplayfileinfo()
	{
	     $clientid = $_POST['clientid'];
		 $endtime = $_POST['endtime'];
		 $starttime = $_POST['starttime'];
		 $clientLogsInfo = $this->Client->getclientplayfileinfo($clientid,$starttime,$endtime);
		 
		 echo $clientLogsInfo;
	}
	
	//获取终端播放文件信息
    //及终端在线情况信息
    //导出EXClE
    function outClientRunningLogToExc($arg)
    {
        $arg=explode("&",$arg);
		$arg=implode('","',$arg);
		$arg=explode("=",$arg);
		$arg=implode('":"',$arg);
		$arg='{"'.$arg.'"}';
		$arg=json_decode($arg,true);
        $clientid = $arg['clientid'];
		 $clientname = $arg['clientname'];
		 $starttime = $arg['starttime'];
		 $endtime = $arg['endtime'];
		 $where['clientid']=$clientid;
		 $where['name']=$clientname;
		 $where['startTime']=$starttime;
		 $where['endTime']=$endtime;
		 $data=array("data"=>$clientLogsInfo = $this->Client->getclientplayinfo($where));
		 if($clientLogsInfo == '')
		 {
		     echo '';
		 }
		 else
		 {
		  $this->load->view("v_ClientRunTimeToExc",$data);
		    
		 }
    }
}
?>
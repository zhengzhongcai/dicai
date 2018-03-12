<?php

class M_socket extends CI_Model{
	public $socketUser="";
	public $socketPwd="";
	public $socketHost="";
	function __construct(){
		parent::__construct();
		$this->load->library('Mysocket');
		//$this->load->model("m_checkSession","Cks");
		$this->load->model("m_remind","R");
		$this->load->model("m_client","Client");
		$this->load->model("m_clientext","ClientExt");
		$this->load->model("m_userLog","userLog");
	}
	public $socketCObj;
	function register(){
		@session_start();
		$this->load->model('m_userEntity','userEntity');
		$socketUser=$this->userEntity->userName;
		$socketPwd=$this->userEntity->userPassword;
		
		// echo $socketUser ."------------".$socketPwd."<hr>";
		// exit();
		
		if(isset($_SESSION['opuserN']))
		{
			$this->socketUser=$_SESSION['opuserN'];
			$this->socketPwd=$_SESSION['opuserPwdN'];
			$this->socketHost=$_SESSION['socketHostN'];
		}
	
		//echo "注册准备消息<br>";
		//注册准备消息		
		$typeRegister=SCT_Register;
		$subtypeRegister=SCT_Register_Requ;
		$funcionNameRegister=getFunctionName($typeRegister,$subtypeRegister); 
		$contArrRegister=$funcionNameRegister($socketPwd,$socketUser); 
		$comandArrRegister=Msg($typeRegister,$subtypeRegister,$contArrRegister); 
		$amsServer=$this->socketHost==""?$this->config->item('amsServer'):$this->socketHost; 
		$socketCObj=new Mysocket();
		$socketCObj->loadSocket($amsServer,'1234');
		$this->socketCObj=$socketCObj; 
		$socketCObj->sendCommand($comandArrRegister); 
		$RegisterArr=$socketCObj->recvMsg($socketCObj->socket);

		return $RegisterArr;
	}

	/**
	 * @return array
     */
	function getClientStatus(){
		$sqlStr='';
		$RegisterArr=$this->register();
            //echo "<pre>";
            //echo print_r($RegisterArr);
           // echo "</pre>";
          
		$socketCObj=$this->socketCObj;
		$typeCommand=6;//SCT_Init;
		$subtypeCommand=SCT_Get_Clients_Status_Requ;
		$functionName=getFunctionName($typeCommand,$subtypeCommand);
		$contArr=$functionName(); 
		$comandArr=Msg($typeCommand,$subtypeCommand,$contArr); 
		$clientStatusArr=array();
		if($RegisterArr['Cont']['IsSuccess']==0){
		 // echo "<hr>start get client online state";
			$socketCObj->sendCommand($comandArr); 
			$clientSatusInfo=$socketCObj->recvMsg($socketCObj->socket);
                //echo "<hr><pre>";
                //echo print_r($clientSatusInfo);
                //echo "</pre>";
			$clientStatus=$clientSatusInfo['Cont'];
			for($i=0;$i<$clientStatus['ClientsNum'][1];$i++)
			{
				$clientStatusArr[$i]['clientID']=$clientStatus[$i]['ClientID'][1];
				$clientStatusArr[$i]['status']=$clientStatus[$i]['Status'][1];
			}
			echo 'Register OK';
		}else{
			echo 'Register fail';	
		}
		//pArr($clientStatusArr);
		return $clientStatusArr;	
	}
	function getDiskInfo($clientID=''){		
		$RegisterArr=$this->register();
		$socketCObj=$this->socketCObj;
		//$clientID=16;
		$typeCommand=SCT_Instruction;
		$subtypeCommand=SCT_Get_Client_Disk_Info_Requ;
		$functionName=getFunctionName($typeCommand,$subtypeCommand);
		$contArr=$functionName($clientID);
		$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);	
		$diskInfoArr=array();
		if($RegisterArr['Cont']['IsSuccess']==0){
			//echo 'Register OK!';
			$socketCObj->sendCommand($comandArr);
			$diskArr=$socketCObj->recvMsgStatus($socketCObj->socket);
			$diskInfo=$diskArr[0]['Cont'];	
			$filesInfo=$diskArr[1]['Cont'];	
			//echo Information("------",$filesInfo);
			//exit();
			$diskSize=$diskInfo['DiskSize'][1]/(1024*1024);
			$diskFreeSize=$diskInfo['DiskFreeSize'][1]/(1024*1024);
			$diskInfoArr=array('diskSize'=>number_format($diskSize, 2, '.', '').'&nbsp;G','diskFreeSize'=>number_format($diskFreeSize, 2, '.', '').'&nbsp;G');
			for($i=0;$i<$filesInfo['RecordNum'][1];$i++){
				$filesInfoArr[$i]['fileSize']=$filesInfo[$i]['Size'][1];
				
				$filesInfoArr[$i]['filePath']=iconv("gbk","utf-8",$filesInfo[$i]['PathStr'][1]);
				$filesInfoArr[$i]['fileModiTime']=$filesInfo[$i]['ModifyTime'][1];	
				$filesInfoArr[$i]['fileCount']='';	
			}
		}else{
			echo 'Register fail';	
		}
		$diskInfoArr=array($diskInfoArr,$filesInfoArr);
		return $diskInfoArr;
	}
	function getClientInfo($clientId)
	{
		$state=$this->Client->getOneOfClientInfo($clientId);
		if($state[0]!="false")
		{
			return $state[1][0];
		}
	}
	function controlClients($postArr=array())
	{
		$infoLog=array();
		if(count($postArr)==1)
		{
			$postArr=$this->input->post("data");
		}
			
		
		//审批
		if($postArr['command']=='shengpi')
		{	
			$this->R->getUpUser();
			exit(0);
		}
		$RegisterArr=$this->register();
		if($RegisterArr['Cont']['IsSuccess']==0){
			echo '<br>Register OK!<br>';
			
		}else{
			echo '<br>Register fail<br>';	
		}
		$ClientsID=24;
		$command='reboot'; 
		$ClientsID=$postArr['clientID'];
		$infoLog["clientMAC"]=$this->getClientInfo($ClientsID);
		$command=$postArr['command'];
		$ClientsIDArr=explode(",",$ClientsID);
		//下载速度限制
		if($postArr['command']=='setClientDownload')
		{	
			$this->Client->setClientDownLoad($ClientsIDArr,$postArr['clientSpeed']);
		}
		//$ClientsIDArr=array($ClientsID);
		//var_dump($ClientsIDArr);
		$clientIDStr=$ClientsID;
		$sqlStr='';
		
		//终端控制
		switch($command){
			case 'screen':
			//分辨率设置
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Regulate_Client_Screen_Resolution_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$screenResolution=$postArr['screenResolution'];//分辨率
				$screenDirection=$postArr['rotateDirection'];//旋转
				//$screenDirection='left';
				$screen=array('resolution'=>$screenResolution,'rotateDirection'=>$screenDirection); //normal,inverted旋转180 ,左：left 右：right
				$sqlStr="update client_info set `ScreenResolution`='".$screen['resolution']."',`ScreenRotation`='".$screen['rotateDirection']."' where TreeNodeSerialID in (".$clientIDStr.")";
				$contArr=$functionName($screen,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("515"=>$screenResolution,"513"=>$screenDirection);
			break;
			case 'play':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				//echo $functionName;
				$contArr=$functionName(PLAY_COMM,$ClientsIDArr); 
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("501"=>"501");
			break;
			case 'pause':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				//echo $functionName;
				$contArr=$functionName(PAUSE_COMM,$ClientsIDArr); 
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("502"=>"502");
			break;
			case 'stop':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$contArr=$functionName(STOP_COMM,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("503"=>"503");
			break;
			case 'reboot':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$contArr=$functionName(REBOOT_COMM,$ClientsIDArr); //重启
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("504"=>"504");
			break;
			case 'stopInsert':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
			//	echo $functionName;
				$contArr=$functionName(INSERT_PLAY_STOP_COMM,$ClientsIDArr); //停止插播
				//$contArr=$functionName(10,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("505"=>"505");
			break;
			//关机
			case 'shutDown':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Control_Command_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$contArr=$functionName(SHUT_OFF_COMM,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("505"=>"505");
			break;
			case 'shutTime':
				//定时开关机
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Time_Switch_Client_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$shutTime=array('shutOnTime'=>$postArr['shutOnTime'],'shutOffTime'=>$postArr['shutOffTime']);
				$str_shutime=array();
				
				//单时间段兼容多时段Windows终端
				for($_i=1,$_n=7; $_i<=$_n;$_i++){
					$str_shutime[]=$_i.";".$shutTime['shutOnTime'].",".$shutTime['shutOffTime'].";&";
				}
				$str_shutime=implode("", $str_shutime);
				
				$clients_info=$this->ClientExt->getClientById($ClientsIDArr);
				//先发送Android与window终端
				$ClientsID_AW=array();
				foreach($clients_info as $k=>$v){
					if($v["clientType"]==5||$v["clientType"]==6)
					{
						$ClientsID_AW[]=$v["clientID"];
					}
				}
				
				if(count($ClientsID_AW)){
					$sqlStr="update client_info set shutOnTime='',shutOffTime='',Extend2='".$str_shutime."' where TreeNodeSerialID in (".implode(",", $ClientsID_AW).")";
					$this->db->query($sqlStr);
					$contArr=$functionName(array("MultiTime"=>$str_shutime),$ClientsID_AW);
					$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
					$this->sendCommand($comandArr,false);
				}
				//然后发送Gentoo终端
				$ClientsID_G=array();
				foreach($clients_info as $k=>$v){
					if($v["clientType"]==0)
					{
						$ClientsID_G[]=$v["clientID"];
					}
				}
				if(count($ClientsID_G)){
					$sqlStr="update client_info set shutOnTime='".$shutTime['shutOnTime']."',shutOffTime='".$shutTime['shutOffTime']."',Extend2='' where TreeNodeSerialID in (".implode(",", $ClientsID_G).")";
					$this->db->query($sqlStr);
					$sqlStr="";
					$contArr=$functionName($shutTime,$ClientsID_G);
					$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
					$this->sendCommand($comandArr);
				}
				$infoLog["command"]=array("599"=>"关机时间:".$postArr['shutOffTime']."   开机时间:".$postArr['shutOnTime']);
			break;
			case 'volume':
				//声音
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Regulate_Client_Volume_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$volume=$postArr['volume'];
				$sqlStr="update client_info set `Volume`=".$volume." where TreeNodeSerialID in (".$clientIDStr.")";
				$contArr=$functionName($volume,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("507"=>$volume);
			break;
			//终端升级
			case 'upgrate':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Upgrade_Client_System_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$fileUrl=$postArr['upgratefile'];
				$contArr=$functionName($fileUrl,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("514"=>$fileUrl);
			break;
			//插播profile
			case 'profile':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_InsertPlay_Profile_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$profileID=$postArr['profileID'];
				//$profileID=7;
				$contArr=$functionName($profileID,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("508"=>$profileID);
			break;
				//插播滚动字幕
			case 'scrollTxt':
				$infoLog["command"]=array("509"=>'scrollTxt');
			break;
			//插播LED字幕
			case 'ledTxt':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_InsertPlay_ScrollText_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$params=$postArr['params'];
				//$profileID=7;
				$contArr=$functionName($params,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("510"=>$params);
			break;
			//更改播放列表
			case 'playlist':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Change_WeekPlayList_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$weekplayListID=1;
				$weekplayListID=$postArr['playListID'];
				$sqlStr="update client_info set weekplayListID=".$weekplayListID." where TreeNodeSerialID in (".$clientIDStr.")";
				$contArr=$functionName($profileID=NULL,$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
				$infoLog["command"]=array("511"=>$weekplayListID);
			break;
			case 'wakeup'://远程开机
				$typeCommand=SCT_Instruction; //SCT_Instruction=7
				$subtypeCommand=SCT_Wakeup_Client_Requ; //SCT_Wakeup_Client_Requ_Body
				$functionName=getFunctionName($typeCommand,$subtypeCommand); //subType_SCT_Instruction($subtypeCommand)
				$contArr=$functionName($ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$infoLog["command"]=array("512"=>"512");
				$this->sendCommand($comandArr);
			break;
			
			case 'setClientDownload':
				$typeCommand=SCT_Instruction;
				$subtypeCommand=SCT_Set_Download_Speed_Requ;
				$functionName=getFunctionName($typeCommand,$subtypeCommand);
				$contArr=$functionName($postArr['clientSpeed'],$ClientsIDArr);
				$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
				$this->sendCommand($comandArr);
			break;
		}
		 if($sqlStr!='')
		 {
			$this->db->query($sqlStr);
		 }
		 
		@fclose($this->socketCObj);
		$this->userLog->clientContr($infoLog);
	}
	function sendCommand($comandArr,$closeSocket=true){
		$this->socketCObj->sendCommand($comandArr);
	}
	function bakupDB($bak=''){
		if($bak=='') die('数据备份参数传递错误');
		$sqlStr='';
		$RegisterArr=$this->register();
		$socketCObj=$this->socketCObj;
		$typeCommand=System_Command;
		$subtypeCommand=SCT_Database_SystemComm_Requ;
		$functionName=getFunctionName($typeCommand,$subtypeCommand);
		//echo $functionName;
		$contArr=$functionName($bak);
		$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
		$clientStatusArr=array();
		if($RegisterArr['Cont']['IsSuccess']==0){
			//echo 'Register OK!';
			$socketCObj->sendCommand($comandArr);
			$bakInfo=$socketCObj->recvMsg($socketCObj->socket);	
			$bakStatus=$bakInfo['Cont']['Result'][1];
			switch($bakStatus){
				case 0:
					$bakResult='成功';
					break;
				case 1:
					$bakResult='未找到执行文件';
					break;
				case 2:
					$bakResult='创建备份文件失败';
					break;
				case 3:
					$bakResult='备份数据库失败';
					break;
				case 100:
					$bakResult='未找到数据库备份文件';
					break;
				case 101:
					$bakResult='恢复数据库失败';
					break;
				default:
					$bakResult='数据库未知错误';
					break;
			}
		}else{
			echo 'Register fail';	
			$bakResult="数据库管理操作失败";
		}
			echo $bakResult;
		return $bakResult;				
	}
	
	
	function delclientfile($id,$param){
		if(!$param)die("error_param");
		
		$RegisterArr=$this->register();
		$socketCObj=$this->socketCObj;
		
		$typeCommand=SCT_Instruction;
		$subtypeCommand=SCT_Delete_Client_Files_Requ;
		$functionName=getFunctionName($typeCommand,$subtypeCommand);
		$clientID = intval($id);
		$filesInfoArr = array();
		
		
		$filesinfo = json_decode($param,true);
		if(is_array($filesinfo)==false)die("error_param_array");
		
		$filesinfo = array_unique($filesinfo);
		$recordNum = count($filesinfo);
		for ($i=0;$i<count($filesinfo);$i++){
			$filesInfoArr[$i]['FilePathOffline']=strlen($filesinfo[$i]);
			$filesInfoArr[$i]['PathStr']=iconv("utf-8","gbk",$filesinfo[$i]);
			$filesInfoArr[$i]['FilePathLen']=strlen($filesinfo[$i]);
		}
		
		$contArr=$functionName($clientID,$recordNum,$filesInfoArr);
		$comandArr=Msg($typeCommand,$subtypeCommand,$contArr);
		if($RegisterArr['Cont']['IsSuccess']==0){
			
			$socketCObj->sendCommand($comandArr);			
			@fclose($socketCObj);
			return "success";
		}
		return "error_remove";
		
	}
}	
?>
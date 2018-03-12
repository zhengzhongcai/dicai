<?php
class Mysocket{
	public $protocal="tcp";
	public $domain;//服务器
	public $port;//端口号
	public $socket;
	public $response;
	function __construct(){
		
	}
	function loadSocket($ip='',$port='1234'){
		$this->socket=stream_socket_client("$this->protocal://$ip:$port",$errno,$errstr,300);
		if(!$this->socket){
			//$this->showMessage("建立socket连接失败:$errstr ($errno)<br />\n");	
		}else{
			//$this->showMessage("create socket ok");
		}
	}
	function listenclient(){
		$port=$this->port;
		$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
 		socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1);
   		socket_bind($sock, 0, $port);
		$clients = array($sock);
		while(true){
			$read=$clients;
			if(socket_select($read,$write=NULL,$except=NULL,0)<1){
				continue;
			}
			//check if there is a client trying to connect()
			if(in_array($sock,$read)){
				$clients[]=$newsock=socket_accept(sock);
				$key=array_search($sock,$read);
				unset($read[$key]);
			}
			// loop through all the clients that have data to read from
			foreach($read as $read_sock){
			
			}
		}
	}
	function sendCommand($commandArr){
		if (fwrite($this->socket, $commandArr['Body'],$commandArr['Len']) === FALSE) {
		//if(fwrite($this->socket, '96 51 1 0#00:11:22:33:44:55||X845||1024||1024x768||vertical||#')===false){
			$this->showMessage("send command failed"); 
    	}else{
			//$this->showMessage("send command ok");
		}
		return "There's no message reply from server!";
	}
	function sendmsg($msg){
		socket_write($this->socket,$msg,strlen($msg));
		$result = socket_read($this->socket,100);
		$this->response = $result;
		if($this->debug == 1){
			  printf("<font color=#CCCCCC>%s $msg</fon><br>",$this->sendflag);
			  printf("<font color=blue>%s $result</font><br>",$this->recvflag);
		}
		return $result;
	}
	function recvMsg($handle){
		
		
		
		$Msg=array();
		$Msg['MsgLen']=@unpack('S',fread($handle,2));
		//echo print_r($Msg['MsgLen']); 
		$Msg['Redundance']=@unpack('a10',fread($handle,10));
		$Msg['Type']=@ord(fread($handle,1));
		$Msg['Subtype']=@unpack('S',fread($handle,2));
		$functionName=getFunctionName($Msg['Type'],$Msg['Subtype'][1]);
		
		if($functionName=="NoFunction")
		{
			fclose($handle);
			unset($handle);
			exit();
		}
		$Msg['Cont']=$functionName($handle);	
		return $Msg;
	} 
	function recvMsgStatus($handle){
		$Msg=array();	
		$Msg['MsgLen']=unpack('S',fread($handle,2));
		$Msg['Redundance']=unpack('a10',fread($handle,10));
		$Msg['Type']=ord(fread($handle,1));
		$Msg['Subtype']=unpack('S',fread($handle,2));
		$functionName=getFunctionName($Msg['Type'],$Msg['Subtype'][1]);
		
		$Msg['Cont']=$functionName($handle);
	
		
		$Msg2=array();	
		$Msg2['MsgLen']=unpack('S',fread($handle,2));
		$Msg2['Redundance']=unpack('a10',fread($handle,10));
		$Msg2['Type']=ord(fread($handle,1));
		$Msg2['Subtype']=unpack('S',fread($handle,2));
		$functionName=getFunctionName($Msg2['Type'],$Msg2['Subtype'][1]);
		
		$Msg2['Cont']=$functionName($handle);
		
		$returnArr=array($Msg,$Msg2);
		return $returnArr;
	}
	
	function __destruct(){
		//fclose($this->socket);	
	}
	function showMessage($msg){
		echo "<li>$msg</li>";
	}	
}
//定义常量
//net message type

/*---new protocal
define('Client_Regist',1);
define('Client_Init',2);
define('Client_Pulse',3);
define('Client_Command',4);
define('SCT_Register',5);
define('SCT_Init',6);
define('SCT_Pulse',7);
define('SCT_Instruction',8);
define('SCT_System',9);*/
define('SCT_Register',5);
define('SCT_Init',6);
define('SCT_Instruction',7);

define('System_Command',8);
define('SCT_Pulse',9);
//message type:SCT_Register
define('SCT_Register_Requ',1);
define('SCT_Register_Answ',2);
//message type:SCT_Init
define('SCT_Get_Clients_Status_Requ',1);
define('SCT_Get_Clients_Status_Answ',2);
/*new SCT_Init
define('SCT_Fetch_Online_Users_Requ',1);
define('SCT_Fetch_Online_Users_Answ',2);
*/
//message type:SCT_Pulse
define('SCT_Connect_Repo',1);
define('SCT_Connect_Resp',2);
//message type:SCT_Instruction
define('SCT_Change_WeekPlayList_Requ',1);
define('SCT_Control_Command_Requ',2);
define('SCT_Time_Switch_Client_Requ',5);
define('SCT_Upgrade_Client_System_Requ',6);
define('SCT_Regulate_Client_Volume_Requ',7);
define('SCT_Regulate_Client_Screen_Resolution_Requ',8);
define('SCT_Get_Client_Disk_Info_Requ',17);  //sct获取磁盘信息
define('SCT_Get_Client_Disk_Info_Answ',18);  //sct获取磁盘信息返回
define('SCT_Get_Client_Directory_Info_Requ',19); //sct获取终端制定文件夹信息
define('SCT_Get_Client_Directory_Info_Answ',20);	//sct获取终端制定文件夹信息返回
define('SCT_Delete_Client_Files_Requ',21); //sct删除终端文件
define('SCT_InsertPlay_Profile_Requ',24);//插播profile
define('SCT_InsertPlay_ScrollText_Requ',25);
define('SCT_Wakeup_Client_Requ',27);//远程开机
define('SCT_Set_Download_Speed_Requ',39);

/*new SCT_Instruction
define('SCT_Control_Command_Requ',1);
define('SCT_Insertion_Requ',2);
define('SCT_Delete_ClientFiles_Requ',3);
define('SCT_GetClient_Status_Answ',4);
define('SCT_GetClient_BasicInfo_Answ',5);
define('SCT_GetClient_FileList_Answ',6);

new SCT_Instruction */

//message type:SCT_System
define('SCT_Database_SystemComm_Requ',8);
define('SCT_Database_SystemComm_Answ',9);
//define('SCT_ReFetch_Clients_Noti',3);
//define('SCT_Exit_Noti',4);

//常量
define('RESERVE_SIZE',64);

//Msg中的常量
define('HeadRedun',10);
//HeadLen sizeof(unsigned short)+HeadRedun*sizeof(char)=2+10*1=12
define('HeadLen',2+HeadRedun*1);
define('FarTypeLen',1); //sizeof(Type) byte
define('SubTypeLen',2);//sizeof(Type) short
define('TypeLen',3);  //FarTypeLen+SubTypeLen
define('MaxSize',4*1024);
define('MsgBodyLen',MaxSize - HeadLen - TypeLen);

function Msg($type,$subType,$ContArr){
	$Msg=array();
	//消息头不变
	$MsgHead['Redundance']=pack('a10','0000000000');
	$MsgHead['Type']=chr($type);
	$MsgHead['SubType']=pack('S',$subType); 
	//print_r($MsgHead['SubType']);
	$MsgBodyLen=strlen($MsgHead['Type'].$MsgHead['SubType'])+$ContArr['Len'];
	$Msg['BodyLen']=pack('S',$MsgBodyLen);
	$Msg['Head']=implode('', $MsgHead);
	$Msg['Cont']=$ContArr['Body'];
	$MsgBody=implode('', $Msg);
	$returnArr['Len']=strlen($Msg['BodyLen'].$Msg['Head'])+$ContArr['Len'];//$MsgBodyLen;
	//echo $MsgBodyLen;
	$returnArr['Body']=$MsgBody;
	return $returnArr;	
}
function recvMsg($handle){
	$Msg=array();
	$Msg['MsgLen']=unpack('S',fread($hanle,2));
	$Msg['Redundance']=unpack('a10',fread($handle,10));
	$Msg['Type']=ord(fread($handle,1));
	$Msg['Subtype']=unpack('S',fread($handle,2));
	$Msg['Cont']=fread($handle,$Msg['MsgLen']);
	return $Msg;
}
function FileInfo($FileSize,$ModifyTime,$FileName){
	$FileInfo=array();
	$FileInfo['FileSize']=pack('L',$FileSize);
	$FileInfo['ModifyTime']=pack('a32',$ModifyTime);
	$FileInfo['FileName']=pack('a128',$FileName);
	$FileInfo['Reserve']=pack('a'.RESERVE_SIZE,'0');
	$FileInfos=implode('', $FileInfo);
	$FileInfoLen=strlen($FileInfos);
	$returnArr['Len']=$FileInfoLen;
	$returnArr['Body']=$FileInfos;
	//return $returnArr;		
}
define('FileInfoLen',228);
//add by Jesscia @2009-12-19 15:17 start
//获取指定终端的指定文件
function SCT_Get_Client_Directory_Info_Requ_Body($clientID){
	$Requ=array();
	$clientID=3;
	$Requ['ClientID']=pack('L',16);
	$Requ['DirectoryPathLen']=pack('i',0);
	$Requ['Path']=pack('a256','');
	$Requ_Body=implode('', $Requ);
	//$Requ_BodyLen=strlen($Requ_Body);
	$Requ_BodyLen=4+4+1;
	$returnArr['Len']=$Requ_BodyLen;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;		
}
function SCT_Get_Client_Directory_Info_Answ_Body($handle){
	$Answ=array();
	$max=30;
	$filesInfolen=4+4+4+1+32;
	$Answ['RecordNum']=unpack('i',fread($handle,4));
	$Answ['IsEnd']=ord(fread($handle,1));
	for($i=0;$i<$max;$i++){		
		$Answ[$i]['FilePathOffline']=unpack('i',fread($handle,4));
		$Answ[$i]['FilePathLen']=unpack('i',fread($handle,4)); 
		$Answ[$i]['Size']=unpack('L',fread($handle,4));
		$Answ[$i]['IsFolder']=ord(fread($handle,1));
		$Answ[$i]['ModifyTime']=unpack('a32',fread($handle,32));	
	}
	for($i=0;$i<$Answ['RecordNum'][1];$i++){
		$lenth=$Answ[$i]['FilePathLen'][1]+1;	
		$Answ[$i]['PathStr']=unpack('a'.$lenth,fread($handle,$lenth));	
	}
	//$Answ['PathStr']=unpack('a638',fread($handle,638)); 
	return $Answ;
}
function SCT_Delete_Client_Files_Requ_Body($clientID,$recordNum,$filesInfoArr){
	
	$Requ=array();
	$max=40;
	$Requ['ClientID']=pack('L',$clientID);
	$Requ['RecordNum']=pack('i',$recordNum);
	$Requ['FilesInfo']='';
	$recordNum = $recordNum>$max?$max:$recordNum;
	$fLen=0;
	for($i=0;$i<$max;$i++){
		//$filePathOffline = isset($filesInfoArr[$i-1]['FilePathOffline'])?strlen(pack('i',($filesInfoArr[$i-1]['FilePathOffline'])))+1:0;
		$filePathOffline = isset($filesInfoArr[$i-1]['FilePathOffline'])?($filesInfoArr[$i-1]['FilePathOffline']):0;
		$filePathLen     = isset($filesInfoArr[$i]['FilePathOffline'])?($filesInfoArr[$i]['FilePathOffline']):0;	
		$fLen +=$filePathOffline;
		if($filePathOffline<1)$filePathOffline=0;else $filePathOffline=$fLen+$i;
		if($filePathLen==0)$filePathOffline=0;
		$Requ['FilesInfo'].=pack('i',($filePathOffline));
		$Requ['FilesInfo'].=pack('i',$filePathLen);
	}
	$Requ['PathStr']='';
	$filesLen=0;
	for($i=0;$i<$recordNum;$i++){
		$j = $filesInfoArr[$i]['FilePathLen']+1;
		$Requ['PathStr'].=pack('a'.$j,$filesInfoArr[$i]['PathStr']);
		$filesLen += $filesInfoArr[$i]['FilePathLen'] + 1;
	}
	$Requ_Body=implode('', $Requ);
//	$Requ_BodyLen=strlen($Requ_Body);
	$Requ_BodyLen=4+4+(8*$max)+$filesLen;
	
	//echo $Requ_BodyLen;
	$returnArr['Len']=$Requ_BodyLen;
	$returnArr['Body']=$Requ_Body;
	
	return $returnArr;	
}

//获取磁盘信息
function SCT_Get_Client_Disk_Info_Requ_Body($clientID){
	$Requ=array();
	$Requ['ClientID']=pack('L',$clientID);
	$Requ_Body=implode('', $Requ);
	//$Requ_BodyLen=strlen($Requ_Body);
	$Requ_BodyLen=4;
	$returnArr['Len']=$Requ_BodyLen;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
function SCT_Get_Client_Disk_Info_Answ_Body($handle){
	$Answ=array();
	$Answ['DiskSize']=unpack('L',fread($handle,4));
	$Answ['DiskFreeSize']=unpack('L',fread($handle,4));
	return $Answ;
}

//add by Jesscia @2009-12-19 15:17 end 
function SCT_Register_Requ_Body($UserPsw,$UserName){
	$Requ=array();
	$Requ['UserPSW']=pack('a16',$UserPsw);
	$Requ['UserName']=pack('a32',$UserName);
	$Requ_Body=implode('', $Requ);
	//$Requ_BodyLen=strlen($Requ_Body);
	$Requ_BodyLen=strlen($Requ['UserPSW'])+strlen($UserName)+1;
	$returnArr['Len']=$Requ_BodyLen;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;
}
function SCT_Register_Answ_Body($handle){
	$Answ=array();
	$Answ['IsSuccess']=ord(fread($handle,1));
	$Answ['DBIP']=unpack('a32',fread($handle,32));
	$Answ['DBUserName']=unpack('a16',fread($handle,16)); 
	$Answ['DBPassword']=unpack('a16',fread($handle,16));
	return $Answ;
}
function SCT_Register_Requ_Body_NEW($UserPsw,$UserName,$DateTime='',$Reserve='0'){
	$Requ=array();
	$Requ['UserPSW']=pack('a32',$UserPsw);
	$Requ['UserName']=pack('a32',$UserName);
	$Requ['DateTime']=pack('L',$DateTime); //long 4 byte;
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ_Body=implode('', $Requ);
	$Requ_BodyLen=strlen($Requ_Body);
	$returnArr['Len']=$Requ_BodyLen;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;
}
define('SUCCESS',0);
define('USER_NOT_EXIST',1);
define('MORE_THAN_ONE_USER',2);
define('PASSWORD_ERROR',3);
define('HAS_NO_ACCESS',4);
define('DATE_TIME_WARNING',5);
function SCT_Register_Answ_Body_NEW($handle){
	$Answ=array();
	//IsSucess 枚举类型
	/*enum Code{
		SUCCESS, USER_NOT_EXIST, MORE_THAN_ONE_USER, PASSWORD_ERROR, HAS_NO_ACCESS, DATE_TIME_WARNING
	};*/
	$Answ['IsSuccess']=unpack('i',fread($handle,4));
	$Answ['DBIP']=unpack('a32',fread($handle,32));
	$Answ['DBUserName']=unpack('a32',fread($handle,32)); 
	$Answ['DBPassword']=unpack('a32',fread($handle,32));
	$Answ['Reserve']=pack('a'.RESERVE_SIZE,fread($handle,RESERVE_SIZE));
	return $Answ;
}
function SCT_Fetch_Online_Users_Requ_Body($Reserve=''){
	$Requ=array();
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;
}
function SCT_Fetch_Online_Users_Answ_Body($handle){
	$Answ=array();
	$Answ['IsEnd']=unpack('I',fread($handle,4));
	$Answ['Reserve']=unpack('a'.RESERVE_SIZE,fread($handle,RESER_SIZE));
	$Answ['UsersNum']=unpack('i',fread($handle,4));//int
	$Answ['UsersId']=unpack('L',fread($handle,4));//unsigend long
	return $Answ;
}
function SCT_Connect_Repo_Body($Reserve=''){
	$Requ=array();
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body);
	$returnArr['Body']=$Requ_Body;
	return $$returnArr;	
}
function SCT_Connect_Resp_Body($Reserve=''){
	$Requ=array();
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body);
	$returnArr['Body']=$Requ_Body;
	return $$returnArr;		
}
//终端状态
define('PLAY_STATUS',0);
define('PAUSE_STATUS',1);
define('STOP_STATUS',2);
define('REBOOT_STATUS',3);//
define('IN_LINE_STATUS',4);//上线
define('OUT_LINE_STATUS',5);
define('UPDATE_STATUS',6);
define('DOWNLOAD_STATUS',7);
define('INSERT_PLAY_STATUS',8);
//获取终端状态发指令
function SCT_Get_Clients_Status_Requ_Body(){
	$returnArr['Len']=1;
	$returnArr['Body']=chr(0);
	return $returnArr;	
}
//ams服务器返回指令
function SCT_Get_Clients_Status_Answ_Body($handle){
	$Answ=array();
	$Answ['ClientsNum']=unpack('i',fread($handle,4));
	//print_r ($Answ['ClientsNum']);
	for($i=0;$i<$Answ['ClientsNum'][1];$i++){
		$Answ[$i]['ClientID']=unpack('L',fread($handle,4));
		$Answ[$i]['Status']=unpack('i',fread($handle,4));
	} 
	return $Answ;
}
//更改播放列表
function SCT_Change_WeekPlayList_Requ_Body($weekPlayListID,$ClientsIDArr){
	$Requ=array();
	$Requ['WeekPlayListID']=pack('i',$weekPlayListID);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	$Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=4+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;		
}
//插播profile
function SCT_InsertPlay_Profile_Requ_Body($profileID,$ClientsIDArr){
	$Requ=array();
	$Requ['ProfileID']=pack('L',$profileID);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	//echo strlen($Requ_Body);	
	$returnArr['Len']=4+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
//插播滚动字幕
function SCT_InsertPlay_ScrollText_Requ_Body($paramsArr,$ClientsIDArr){
	$Requ=array();
	$Requ['TextFileURL']=pack('a256',$paramsArr['TextFileURL']);
	$Requ['InsertPlayTimes']=pack('i',$paramsArr['InsertPlayTimes']);
	list($x,$y,$w,$h)=$paramsArr['Rect'];
	$Requ['Rect']=pack('i',$x).pack('i',$y).pack('i',$w).pack('i',$h);
	$Requ['FontStyle']=pack('a20',$paramsArr['FontStyle']);
	$Requ['FontSize']=pack('i',$paramsArr['FontSize']);
	$Requ['BackGroundColer']=pack('i',$paramsArr['BackGroundColer']);
	$Requ['ForeGroundColer']=pack('i',$paramsArr['ForeGroundColer']);
	$Requ['ScrollSpeed']=pack('i',$paramsArr['ScrollSpeed']);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	//echo strlen($Requ_Body);	
	$returnArr['Len']=256+4+4*4+20+4+4+4+4+4+4*700-(700-$ClientsNum)*4;
	//return sizeof(*this) - (MAX - ClientsNum) * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;			
}
//插播文件
function SCT_InsertPlay_File_Requ_Body($paramsArr,$ClientsIDArr){
	$Requ=array();
	$Requ['FileURL']=pack('a256',$paramsArr['fileURL']);
	$Requ['ExtendStr']=pack('a512',$paramsArr['ExtendStr']);
	list($x,$y,$w,$h)=$paramsArr['ExtendInt'];
	$Requ['ExtendInt']=pack('i',$x).pack('i',$y).pack('i',$w).pack('i',$h);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	//echo strlen($Requ_Body);	
	$returnArr['Len']=256+512+700*4-(700-$ClientsNum)*4;
	//return return sizeof(*this) - (MAX - ClientsNum) * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
//-------command------------*/
define('PLAY_COMM',0);//播放
define('PAUSE_COMM',1);//暂停
define('STOP_COMM',2);//停止
define('REBOOT_COMM',10);//重启
define('SHUT_OFF_COMM',11);//关机
define('LOCK_COMM',12);//锁定
define('INSERT_PLAY_STOP_COMM',13);//停止插播
//-------------------*/
define('TURN_ON',0);
define('TURN_OFF',1);
define('REBOOT',2);
define('UPDATE_SYSTEM',3);
define('CANCEL_INSERTION',4);
define('FILES_LIST',5);
define('CLEAR_ALLFILES',6);
define('CHANGE_CONFIG',7);
define('UPLOAD_STATUS',8);
define('UPLOAD_BASICINFO',9);
//终端控制
function SCT_Control_Command_Requ_Body($Command,$ClientsIDArr){
	$Requ=array();
	echo $Command;
	//MAX = ( Msg::MsgBodyLen - 6 * RESERVE_SIZE ) / sizeof (long)
	$Requ['Command']=pack('i',$Command);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	//echo strlen($Requ_Body);	
	$returnArr['Len']=4+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;			
}
//定时开关机
function SCT_Time_Switch_Client_Requ_Body($shutTimeArr,$ClientsIDArr){
	$Requ=array();
	if(count($shutTimeArr)==2){
		$Requ['ShutOnTime']=pack('a32',$shutTimeArr['shutOnTime']);
		$Requ['ShutoffTime']=pack('a32',$shutTimeArr['shutOffTime']);
	}
	if(count($shutTimeArr)==1){
		//echo "------------多时段定时开关机";
		$Requ['ShutOnTime']=pack('a32',"1");
		$Requ['ShutoffTime']=pack('a32',"1");
	}
	$Requ['DownLoadTime']=pack('a32','');
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
    $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) 
	{
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=32*3+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}


//终端升级
function SCT_Upgrade_Client_System_Requ_Body($fileUrl,$ClientsIDArr){
	$Requ=array();
	$Requ['FileUrl']=pack('a256',$fileUrl);
	$Requ['CheckSum']=pack('a10','');
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=256+10+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
	
}
//终端分辨率修改
function SCT_Regulate_Client_Screen_Resolution_Requ_Body($screenResolutionArr,$ClientsIDArr){
	$Requ=array();
	$Requ['Resolution']=pack('a32',$screenResolutionArr['resolution']);
	$Requ['RotateDirection']=pack('a32',$screenResolutionArr['rotateDirection']);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=32*2+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
//声音控制
function SCT_Regulate_Client_Volume_Requ_Body($volume,$ClientsIDArr){
	$Requ=array();
	$Requ['volume']=pack('S',$volume);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=2+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
//远程开机
function SCT_Wakeup_Client_Requ_Body($ClientsIDArr){
	$Requ=array();
	$Requ['Time']=pack('a32','');
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
    $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=32+4+800*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;
		
}
function SCT_Control_Command_Requ_Body_NEW($Command,$ControlPara1,$ControlPara2,$ClientsNum,$ClientsID,$Reserve=''){
	$Requ=array();
	//Command 枚举类型
	/*enum COMMAND
{
	TURN_ON, TURN_OFF, REBOOT, UPDATE_SYSTEM, CANCEL_INSERTION, FILES_LIST, CLEAR_ALLFILES, CHANGE_CONFIG, UPLOAD_STATUS, 

UPLOAD_BASICINFO
};*/
	define('MAX',(MsgBodyLen-6*RESERVE_SIZE)/4);
	//MAX = ( Msg::MsgBodyLen - 6 * RESERVE_SIZE ) / sizeof (long)
	$Requ['Command']=pack('i',$Command);
	$Requ['ControlP1']=pack('i',$ControlPara1);
	$Requ['ControlP2']=pack('a256',$ControlPara2);
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	$Requ['ClientsID']=pack('L',$ClientsID);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body)-(MAX-$ClientsNum)*4;
	$returnArr['Body']=$Requ_Body;
	//sizeof(*this) - ( MAX - ClientsNum ) * sizeof(unsigned long);
	return $returnArr;			
}
define('PROFILE',0);
define('SCROLL_AREA',1);
define('MAIN_AREA',2);
function SCT_Insertion_Requ_Body($IsEnd,$InsertionType,$X,$Y,$Width,$Height,$FilesNum,$FilesUrl,$ClientNum,$ClientIDs,$UrlStr,$Reserve){
	$Requ=array();
	define('MAX',MsgBodyLen-300*4-2*RESERVE_SIZE);
	//MAX = Msg::MsgBodyLen - 300 * sizeof(long) - 2 * RESERVE_SIZE 
	$Requ['IsEnd']=pack('I',$IsEnd); //bool 
	/*enum INSERTION
{
	PROFILE, SCROLL_AREA, MAIN_AREA 
};*/
	$Requ['InsertionaType']=pack('i',$InsertionType); //枚举类型
	
	$Requ['X']=pack('i',$X);
	$Requ['Y']=pack('i',$Y);
	$Requ['Width']=pack('i',$Width);
	$Requ['Height']=pack('i',$Height);
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ['FilesNum']=pack('i',$FilesNum);
	$Requ['FilesUrl']=pack('a100',$FilesUrl);
	$Requ['ClientNum']=pack('i',$ClientNum);
	$Requ['ClientIDs']=pack('L200',$ClientsIDs);
	$Requ['UrlStr']=pack('a'.MAX,$UrlStr);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;			
}

function SCT_Delete_ClientFiels_Requ_Body($ClientID,$FileNum,$FilesName){
	$Requ=array();
	define('MAX',(MsgBodyLen-2*RESERVE_SIZE)/128);
	$Requ['ClientID']=pack('i',$ClientID);
	$Requ['FileNum']=pack('i',$FileNum);
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	//-------------转二维数组------正确与否未知----------------------
	//用循环 用来确定每个文件名占128个字节
	$num=MAX*128; //本来是二维数组的，到时传参过来转成一个字串就行了；
	$Requ['FilesName']=pack('a'.$num,$FilesName);
	//-------------转二维数组----------------------------
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=strlen($Requ_Body)-(MAX-FileNum)*128;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;		
}
define('ONLINE',0);
define('OFFLINE',1);
define('QUERYING',2);
define('PLAYING',3);
define('DOWNLOADING',4);
define('INSERTION',5);
define('IDLE',6);
define('UPDATING',7);
define('DISKSPACE_WARN',8);
define('INIT_FATAL',9);
define('RUN_FATAL',10);
function SCT_GetClient_Status_Answ_Body($handle){
	$Answ=array();
	/*enum CLIENT_STATUS
{ 
	ONLINE, OFFLINE, QUERYING, PLAYING, DOWNLOADING, INSERTION, IDLE, UPDATING, DISKSPACE_WARN, INIT_FATAL, RUN_FATAL 
};*/
	$Answ['Status']=unpack('i',fread($handle,4)); //enum
	$Answ['Reserve']=unpack('a'.RESERVE_SIZE,fread($handle,RESERVE_SIZE));
	return $Answ;
}
define('NORMAL',0);
define('R90',1);
define('R180',2);
define('R270',3);
function SCT_GetClient_BasicInfo_Answ_Body($handle){
	$Answ=array();
	$Answ['PlayList']=unpack('a64',fread($handle,64));
	$Answ['Resolution']=unpack('a32',fread($handle,32));
	/*enum ROTATION 
{
	NORMAL, R90, R180, R270 
};*/

	$Answ['Retation']=unpack('i',fread($handle,4));//enum
	$Answ['RemanentDist']=unpack('L',fread($handle,4));
	$Answ['Reserve']=unpack('a'.RESERVE_SIZE*2,fread($handle,RESERVE_SIZE*2));
	return $Answ;
}
function SCT_GetClient_FileList_Answ_Body($handle){
	$Answ=array();
	define('MAX',MsgBodyLen-2*RESERVE_SIZE); //不对
	$Answ['IsEnd']=unpack('I',fread($handle,4));
	$Answ['FileNum']=unpack('i',fread($handle,4));
	$Answ['Reserve']=unpack('a'.RESERVE_SIZE,fread($handle,RESERVE_SIZE));
	//$Answ['FileInfo']=unpack();  //struct类型
	
	return $Answ;
}
function SCT_ReFetch_Clients_Noti_Body($Reserve='0'){
	$Requ=array();
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	$Requ_Body=implode('', $Requ);
	return $Requ_Body;	
}
//SCT_Database_SystemComm_Requ 数据库备份
function SCT_Database_SystemComm_Requ_Body($Command){
	$Requ=array();
	$Requ['Command']=pack('i',$Command);
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=4;
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}

//终端下载速度
function SCT_Set_Download_Speed_Requ_Body($ClientDownSpeed,$ClientsIDArr){
	$Requ=array();
	$Requ['speed']=pack('a32',$ClientDownSpeed['clientSpeed']);
	//$Requ['RotateDirection']=pack('a32',$screenResolutionArr['rotateDirection']);
	$ClientsNum=count($ClientsIDArr);
	$Requ['ClientsNum']=pack('i',$ClientsNum);
	//change by 莫波 2010年12月5日21:22:27
        $Requ['ClientsID']="";
	foreach ($ClientsIDArr as $k=>$value) {
   		 $Requ['ClientsID'].=pack('L',$value);
	}
	$Requ_Body=implode('', $Requ);
	$returnArr['Len']=32+4+$ClientsNum*4;
	//sizeof(COMMAND) + sizeof(int) + ClientsNum * sizeof(unsigned long);
	$returnArr['Body']=$Requ_Body;
	return $returnArr;	
}
//Result_Code enum
define('Success',0);
define('Excute_File_Not_Found',1);
define('Create_File_Fail',2);
define('Backup_Database_Fail',3);
define('Backup_File_Not_Found',100);
define('Restore_Database_Fail',5);
function SCT_Database_SystemComm_Answ_Body($handle){
	$Answ=array();
	$Answ['Result']=unpack('i',fread($handle,4));
	//$Answ['Reserve']=unpack('a'.RESERVE_SIZE,fread($handle,RESERVE_SIZE));
	return $Answ;
}
function SCT_Exit_Noti_Body($Reserve='0'){
	$Requ=array();
	$Requ['Reserve']=pack('a'.RESERVE_SIZE,$Reserve);
	//$Answ['FileInfo']=unpack();  //struct类型
	$Requ_Body=implode('', $Requ);
	return $Requ_Body;	
}


function getFunctionName($type,$subtype){
	switch ($type){
		case SCT_Register:
			$functionName=subType_SCT_Register($subtype);
			break;
		case SCT_Init:
			$functionName=subType_SCT_Init($subtype);
			break;
		case SCT_Pulse:
			$functionName=subType_SCT_Pulse($subtype);
			break;
		case SCT_Instruction:
			$functionName=subType_SCT_Instruction($subtype);
			break;
		case System_Command://SCT_System
			$functionName=subType_SCT_System($subtype);
			break;
		default:
			$functionName='NoFunction';
			break;
	}
	return $functionName;
}

function subType_SCT_Register($subType){
	switch($subType){
		case SCT_Register_Requ:
			$functionName='SCT_Register_Requ_Body';
			break;
		case SCT_Register_Answ:
			$functionName='SCT_Register_Answ_Body';
			break;
		default:
			break;
	}
	return $functionName;
}
/*new SCT_Init
function subType_SCT_Init($subType){
	switch($subType){
		case SCT_Fetch_Online_Users_Requ:
			$functionName='SCT_Fetch_Online_Users_Requ_Body';
			break;
		case SCT_Fetch_Online_Users_Answ:
			$functionName='SCT_Fetch_Online_Users_Answ_Body';
			break;
		default:
			break;
	}
	return $functionName;
}*/
function subType_SCT_Init($subType){
	switch($subType){
		case SCT_Get_Clients_Status_Requ:
			$functionName='SCT_Get_Clients_Status_Requ_Body';
			break;
		case SCT_Get_Clients_Status_Answ:
			$functionName='SCT_Get_Clients_Status_Answ_Body';
			break;
		default:
			break;
	}
	return $functionName;
}
function subType_SCT_Pulse($subType){
	switch($subType){
		case SCT_Connect_Repo:
			$functionName='SCT_Connect_Repo_Body';
			break;
		case SCT_Connect_Resp:
			$functionName='SCT_Connect_Resp_Body';
			break;
		default:
			break;
	}
	return $functionName;
}
function subType_SCT_Instruction($subType){
	switch($subType){
		//更改播放列表
		case SCT_Change_WeekPlayList_Requ:
			$functionName='SCT_Change_WeekPlayList_Requ_Body';
			break;
		//终端
		case SCT_Control_Command_Requ:
			$functionName='SCT_Control_Command_Requ_Body';
			break;
		//声音
		case SCT_Regulate_Client_Volume_Requ:
			$functionName='SCT_Regulate_Client_Volume_Requ_Body';
			break;
		//定时开关机
		case SCT_Time_Switch_Client_Requ:
			$functionName='SCT_Time_Switch_Client_Requ_Body';
			break;
		//插播profile
		case SCT_InsertPlay_Profile_Requ:
			$functionName='SCT_InsertPlay_Profile_Requ_Body';
			break;
		case SCT_Upgrade_Client_System_Requ:
			$functionName='SCT_Upgrade_Client_System_Requ_Body';
			break;
		case SCT_Regulate_Client_Screen_Resolution_Requ:
			$functionName='SCT_Regulate_Client_Screen_Resolution_Requ_Body';
			break;
		case SCT_Wakeup_Client_Requ:
			$functionName='SCT_Wakeup_Client_Requ_Body';
			break;
		//add by Jessica @2009-12-21 14:09 start
		case SCT_Get_Client_Disk_Info_Requ:
			$functionName='SCT_Get_Client_Disk_Info_Requ_Body';
			break;
		case SCT_Get_Client_Disk_Info_Answ:
			$functionName='SCT_Get_Client_Disk_Info_Answ_Body';
			break;
		case SCT_Get_Client_Directory_Info_Requ:
			$functionName='SCT_Get_Client_Directory_Info_Requ_Body';
			break;
		case SCT_Get_Client_Directory_Info_Answ:
			$functionName='SCT_Get_Client_Directory_Info_Answ_Body';
			break;
		case SCT_Delete_Client_Files_Requ:
			$functionName='SCT_Delete_Client_Files_Requ_Body';
			break;
		//插播led字幕
		case SCT_InsertPlay_ScrollText_Requ:
			$functionName='SCT_InsertPlay_ScrollText_Requ_Body';
			break;
		case SCT_Set_Download_Speed_Requ:
			$functionName='SCT_Set_Download_Speed_Requ_Body';
			break;
		//add by Jessica @2009-12-21 14:09 end
		case SCT_Insertion_Requ:
			$functionName='SCT_Insertion_Requ_Body';
			break;
		case SCT_Delete_ClientFiles_Requ:
			$functionName='SCT_Delete_ClientFiles_Requ_Body';
			break;
		case SCT_GetClient_Status_Answ:
			$functionName='SCT_GetClient_Status_Answ_Body';
			break;
		case SCT_GetClient_BasicInfo_Answ:
			$functionName='SCT_GetClient_BasicInfo_Answ';
			break;
		case SCT_GetClient_FileList_Answ:
			$functionName='SCT_GetClient_FileList_Answ_Body';
			break;
			//控制终端下载速度
		
		default:
			break;
	}
	return $functionName;
}
function subType_SCT_System($subType){
	switch($subType){
		case SCT_Database_SystemComm_Requ:
			$functionName='SCT_Database_SystemComm_Requ_Body';
			break;
		case SCT_Database_SystemComm_Answ:
			$functionName='SCT_Database_SystemComm_Answ_Body';
			break;
		case SCT_ReFetch_Clients_Noti:
			$functionName='SCT_ReFetch_Clients_Noti_Body';
			break;
		case SCT_Exit_Noti:
			$functionName='SCT_Exit_Noti_Body';
			break;
		default:
			break;
	}
	return $functionName;
}

?>
<?php
class M_userLog extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model('m_userEntity','userEntity');
	}

	/**
	*日志写入  OprTyp:操作类型  itm:关键字 obj:被操作对象  con:操作的详细信息 State:操作的状态
	*@deprecate   此函数已经废弃使用
	*/
	function loginLogX($OprTyp,$itm,$obj,$con,$State)
	{
		//@session_start();
		//$usr=$_SESSION["Km"];
		//$userName=$_SESSION["opuser"];
		$userName=$this->userEntity->userName;
		$usr=$this->userEntity->userID;
		$sql="INSERT INTO `userlog` (`User`, `Time`, `Type`, `Key`, `Object`, `Con`, `State`, `Ext1`, `Ext2`) VALUES
('".$usr.",".$userName."', NOW(), '".$OprTyp."', '".$itm."', '".$obj."', '".$con."', '".$State."', NULL, NULL)";
		$this->db->query($sql);
		if($this->db->affected_rows())
		{
			//错误处理
		}
	}	

	/**
	*写入日志到数据库中
	*
	*@param  int  $Oprtyp  操作类型
	*@deprecate  param  string  $itm   
	*@param  strig  $obj  被操作对象
	*@param  string  $con  操作的详细信息
	*@param  int   $State  操作的状态
	*@return  void
	*/
	function loginLog($OprTyp, $itm, $obj, $con, $State){
		//@session_start();
		//$usr=$_SESSION["Km"];
		$usr=$this->userEntity->userID;
		$sql = "insert into `user_operation_log` (`Time`,`UserID`,`TreeNodeSerialID`,`WeekPlaylistID`,`ProfileID`,`BroadcastSchemeID`,`Operation`,`OperationID`,`Comment`,`OptionName`,`State`,`Extend1`,`Extend2`,`Extend3`,`Extend4`,`Extend5`) values (NOW(),'".$usr."',NULL,NULL,NULL,NULL,NULL,'".$OprTyp."',".$this->db->escape($con).",'".$obj."','".$State."',NULL,NULL,NULL,NULL,NULL)";
		$this->db->query($sql);
		if($this->db->affected_rows())
		{
			//错误处理
		}
	}
	
	
		//播放计划查看-节目单移除操作dsy
	function deleteDescribe($OprTyp,$itm,$obj,$state,$playname,$prosum){
	//	echo $obj."<br>";
		
		if($obj[0]=="array"){
		
		 $str="";
		 for($i=0;$i < count($obj[1]);$i++){
			
			 $str .= proDecodeName($obj[1][$i]).",";
			 
			}
			$str1 = substr($str,0,(strlen($str)-1));
			
		}else{
			
			$str1=proDecodeName($obj[1]);
			
			
		 }
		$con=opitem($itm)."播放计划:".$playname."移除播放单元:".$str1.",数量:".$prosum;
	
		$this->loginLog($OprTyp,$itm,$str1,$con,$state);
	
	} 
	//dsy
	function getFileName($profileID){
		$sql="select profilename from profile where profileID=".$profileID;
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $row){
			return 	$row->profilename;
						
			}
		}
	}
	
	//保存播放计划dsy
	function savePlaylist($OprTyp,$itm,$playlistName='',$playDataStr='',$state){
	
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			 // if($i==$num-1){
				 // $playDataInfo.='.$startTime.','.$endTime.','.$this->getFileName($profileID).';
			 // }else{
				 // $playDataInfo.='.$startTime.','.$endTime.','.$this->getFileName($profileID).'.',';
			 // }
			 $playDataInfo.="播放单元：".proDecodeName($this->getFileName($profileID)).",开始时间：".$startTime.",结束时间：".$endTime.",";
		}
		$playDataInfo = substr($playDataInfo,0,(strlen($playDataInfo)-1));
		$obj=iconv('gb2312','utf-8',$playlistName);
		//$obj=$playlistName;
	    $this->loginLog($OprTyp,$itm,$obj,$playDataInfo,$state);
	} 
	//移除播放计划dsy
	function deletePlaylist($OprTyp,$itm,$obj,$pro,$state,$prosum){
	//$obj=iconv('utf-8','gb2312',$obj);
		$str="";
		for($i=0,$n=count($pro);$i<$n;$i++){
			$str.=proDecodeName($pro[$i]);
			if($i!=$n-1)
			{$str.=",";}
		}
		if($str==""){
		 $con=opitem($itm)." 移除播放计划:".$obj;
		}else{
	    $con=opitem($itm)." 移除播放计划:".$obj." 包含播放单元:".$str.",数量:".$prosum;
		}
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
		
	}
	//播放计划查看-修改dsy
	function saveEditPlaylist($OprTyp,$itm,$playlistName='',$playDataStr='',$state){
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			 // if($i==$num-1){
				 // $playDataInfo.='.$startTime.','.$endTime.','.$this->getFileName($profileID).';
			 // }else{
				 // $playDataInfo.='.$startTime.','.$endTime.','.$this->getFileName($profileID).'.',';
			 // }
			  $playDataInfo.="播放单元：".proDecodeName($this->getFileName($profileID)).",开始时间：".$startTime.",结束时间：".$endTime.",";
			 
		}
		$playDataInfo = substr($playDataInfo,0,(strlen($playDataInfo)-1));
		$obj=$playlistName;
	    $this->loginLog($OprTyp,$itm,$obj,$playDataInfo,$state);
		
		
		
	}
	
	//终端组-移动终端dsy
	function moveClients1($OprTyp,$itm,$obj,$conStr,$state)
	{
		
		$con="终端:".$obj." 复制到:".$conStr."组";
		
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
	
	}
	
	//终端组-移除终端dsy
	function deleteClient($OprTyp,$itm,$obj,$state,$noclient){
		$con=opitem($itm)." 的终端组:".$noclient." 移除终端:".$obj;
		
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
	
	
	}
//终端组-移除组
	function deleteGroup($OprTyp,$itm,$obj,$state,$root){
//	echo $client."<br>";
/*
Array
(
    [0] => Array
        (
            [GroupNode] => 00010016
        )

    [1] => Array
        (
            [GroupNode] => 000100160001
            [clinets] => Array
                (
                    [0] => Array
                        (
                            [name] => clientAA
                            [TreeNodeCode] => 0001001600010002
                            [isClient] => 1
                        )

                )

        )

    [2] => Array
        (
            [GroupNode] => 0001001600010001
            [clinets] => Array
                (
                    [0] => Array
                        (
                            [name] => clientBB
                            [TreeNodeCode] => 00010016000100010001
                            [isClient] => 1
                        )

                )

        )

)

*/
		$noclient="";
		$client="";
		$noclient1="";
		for($i=0;$i<count($obj);$i++){
			$noclient=$obj[$i]['name'];
			if(count($obj[$i])>2)
			{
				for($j=0;$j<count($obj[$i]['clinets']);$j++){
						$client.=$obj[$i]['clinets'][$j]['name'].",";
						
				}
				$client = substr($client,0,(strlen($client)-1));	
			
			}
			
			$noclient1.="终端组:".$noclient."-->终端:".$client.",";
			
			$client="";
		}
		

		$noclient1 = substr($noclient1,0,(strlen($noclient1)-1));
	
		$con=opitem($itm)."移除组及其终端".$noclient1.",上一级是".$root;
	
		$this->loginLog($OprTyp,$itm,$noclient1,$con,$state);
	
	}
	
	//终端组-新增组dsy
	function addGroup($OprTyp,$itm,$obj,$state,$noclient){
		
		$con=opitem($itm)." 的:".$noclient." 组新增:".$obj."组";
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
	}
	
	//终端组-重命名dsy
	function updateName($OprTyp,$itm,$obj,$conStr,$state){
		$con=opitem($itm)." 的终端组:".$obj."修改成:".$conStr;
		
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
	}
	
	//终端组-注销dsy
	function logoutClient($OprTyp,$itm,$obj,$state,$noclient){
		
		$con=opitem($itm)." 的终端组:".$noclient." 注销终端:".$obj;
		$this->loginLog($OprTyp,$itm,$obj,$con,$state);
	}
	
	//修改组
	function moveGroup($OprTyp,$itm,$obj,$state,$root,$group){
		$noclient="";
		$client="";
		$noclient1="";
		for($i=0;$i<count($obj);$i++){
			$noclient=$obj[$i]['name'];
			if(count($obj[$i])>2 )
			{
				for($j=0;$j<count($obj[$i]['clinets']);$j++){
						$client.=$obj[$i]['clinets'][$j]['name'].",";
						
				}
				$client = substr($client,0,(strlen($client)-1));	
			
			}
			
			$noclient1.="终端组:".$noclient."-->终端:".$client.",";
			
			$client="";
		}
		

		$noclient1 = substr($noclient1,0,(strlen($noclient1)-1));
	
		$con=opitem($itm)."终端组:".$root."将".$noclient1."移动到组:".$group;
	
		$this->loginLog($OprTyp,$itm,$noclient1,$con,$state);
	
	
	
	
	
	}

	
	
	
	//创建Profile成功记录
	function createProfileLogok($globalInfo,$profileTemplateInfo,$profileInfo)
	{
		
		
		$state=1; //profile create state
		$proName=$globalInfo["profileName"]; //profile Name
		$proType=$globalInfo["profileType"]; //profile Type
		$proTime=$globalInfo["profilePeriod"]; //profile play time
		$proJumpUrl=trim($globalInfo["touchJumpUrl"])==""?"空":$globalInfo["touchJumpUrl"]; //profile jump url
		$proFB=$globalInfo["tempWidth"]."x".$globalInfo["tempHeight"]; //profile 分辨率
		$areaCout=count($profileInfo); //profile total of area
		$areaInfo="";
		$i=0;
		$f_i=0;
		foreach($profileInfo as $v)
		{
			$areaInfo.="
				区域$i:<br />
					类型:".$v["type"].";
					宽度:".$v["location"]["width"].";
					高度:".$v["location"]["height"].";
					X轴:".$v["location"]["left"].";
					Y轴:".$v["location"]["top"].";<br />";
					foreach($v["files"] as $fl)
					{
						$f_i++;
						$areaInfo.="&nbsp&nbsp&nbsp&nbsp文件".$f_i.":
						名称:".$fl["fileInfo"]["fileName"].";
						类型:".$fl["fileInfo"]["fileType"].";
						大小:".$fl["fileInfo"]["fileSize"].";
						播放时长:".isset($fl["playInfo"]["playTime"])?$fl["playInfo"]["playTime"]:"0".";<br />";
					}
		$f_i=0;
		$i++;
		}
		
		$pro_Name=opitem("200"); //profile 的别称
		$con=$pro_Name."信息:<br />
			名称:$proName;
			类型:$proType;
			时长:$proTime;
			分辨率:$proFB;
			触摸屏跳转页面:$proJumpUrl;
		".$pro_Name."区域以及文件信息:<br />
			区域个数:$areaCout;<br />
			每个区域详情:<br />
			$areaInfo
		";
		$this->writeLog("1","201",$proName,$con,$state);
	}
	//创建Profile失败记录
	function createProfileLogError($error)
	{
		
	}
	
	//移除Profile
	function delProLog($info)
	{
		$str="";
		$pro=$info["data"];
		$con="从".opitem("200")."表中移除数据成功,移除".opitem("200")."资源文件夹成功,移除".opitem("200")."包成功!";
		$this->writeLog("3","202",proDecodeName($pro["proName"]),$con,1);
	}
	//终端控制
	function clientContr($info)
	{
		$obj="";
		$node=array();
		$clGr=array();
		$itm="";
		$cln=$info["clientMAC"];
		for($i=0,$n=count($cln); $i<$n; $i++)
		{
			$itm=substr($cln[$i]["TreeNodeCode"],0,strlen($cln[$i]["TreeNodeCode"])-4);
			$node[$i]="".$itm."";
			$clGr[$i]["G"]=$itm;
			$clGr[$i]["C"]=$cln[$i];
		}
		if(count($node))
		{
			$node=array_unique($node);
			$node=implode(",",$node);
			$this->db->select("Name,TreeNodeCode");
			$this->db->where_in("TreeNodeCode",$node);
			$rs=$this->db->get("client_tree")->result_array();
			
			$clientInfo="";
			if(count($rs)>0)
			{
				count($rs)>1?$obj="多个终端组":$obj=$cln[0]["Name"];
				for($i=0,$n=count($clGr); $i<$n; $i++)
				{
					for($a=0,$b=count($rs); $a<$b; $a++)
					{
						if($rs[$a]["TreeNodeCode"]==$clGr[$i]["G"])
						{
							$rs[$a]["Client"][]=$clGr[$i]["C"];
						}
					}
				}
				foreach($rs as $v)
				{
					$clientInfo.="终端组:".$v["Name"]."<br>";
					foreach($v["Client"] as $c)
					{
						$clientInfo.="&nbsp;&nbsp;&nbsp;&nbsp;终端:".$c["Name"]."&nbsp;&nbsp;Mac地址:".$c["MacAddress"]."<br />";
					}
				}
			}
		}
		
		$comand="";
		foreach($info["command"] as $key=>$v)
		{
			
			if($key=="511")//播放计划
			{
				$this->db->select("WeekPlaylistName");
				$this->db->where("WeekPlaylistID",$v);
				$rs=$this->db->get("week_playlist")->result_array();
				if(count($rs)>0)
				{
					$comand.=areaItem($key).":".$rs[0]["WeekPlaylistName"].";";
				}
				else
				{
					$comand.=areaItem($key).":不存在此播放计划;";
				}
				
			}
			else if($key=="508")//插播Profile
			{
				$this->db->select("ProfileName");
				$this->db->where("ProfileID",$v);
				$rs=$this->db->get("profile")->result_array();
				if(count($rs)>0)
				{
					$comand.=areaItem($key).":".proDecodeName($rs[0]["ProfileName"]).";";
				}
				else
				{
					$comand.=areaItem($key).":不存在此Profile;";
				}
			}
			else
			{
				if(is_numeric($v))
				{
					$comand.=areaItem($key).":".areaItem($v).";";
				}
				else
				{
					$comand.=areaItem($key).":".$v.";";
				}
			}
		}
		$con=$clientInfo."<br>发送的命令->".$comand;
		$this->writeLog("2","500",$obj,$con,1);
		
	}
	function updateClientNameLog($info,$state)
	{
		if($state)
		{
			$trueClient=$info[1]["trueClientName"];
			$str="真实终端:<br />&nbsp;&nbsp;&nbsp;&nbsp;名称:".$trueClient["Name"]."; 节点编号:".$trueClient["TreeNodeCode"]."; 改名为:".$trueClient["postName"]."<br />";
			$copyClient=$info[1]["copyClientName"];
			//echo Information("----------------",$copyClient);
			
			for($i=0,$n=count($copyClient); $i<$n; $i++)
			{
				$str.="复制的终端:<br />&nbsp;&nbsp;&nbsp;&nbsp;名称:".$copyClient[$i]["Name"]."; 节点编号:".$copyClient[$i]["TreeNodeCode"]."; 改名为:".$copyClient[$i]["postName"]."<br />";
			}
			$this->writeLog("2","500",$trueClient["Name"],$str,$state);
		}else
		{
			$trueClient=$info[2]["trueClientName"];
			$str="真实终端:<br />&nbsp;&nbsp;&nbsp;&nbsp;名称:".$trueClient["Name"]."; 节点编号:".$trueClient["TreeNodeCode"]."; 改名为:".$trueClient["postName"]."<br />";
			$this->writeLog("2","500",$trueClient["Name"],"终端名称修改失败!<br />".$str,$state);
		}
	}

	/**
	*日志写入  OprTyp:操作类型  itm:关键字 obj:被操作对象  con:操作的详细信息 State:操作的状态
	*@deprecate   此函数已经废弃使用
	*/
	function writeLogX($OprTyp,$itm,$obj,$con,$State)
	{
		@session_start();
		$usr=$_SESSION["Km"];
		$userName=$_SESSION["opuser"];
		$sql="INSERT INTO `userlog` (`User`, `Time`, `Type`, `Key`, `Object`, `Con`, `State`, `Ext1`, `Ext2`) VALUES
('".$usr.",".$userName."', NOW(), '".$OprTyp."', '".$itm."', '".$obj."', ".$this->db->escape($con).", '".$State."', NULL, NULL)";
		$this->db->query($sql);
		if($this->db->affected_rows())
		{
			//错误处理
		}
	}
	
	/**
	*写入日志
	*
	*@param  int  $Oprtyp  操作类型
	*@deprecate  param  string  $itm   
	*@param  strig  $obj  被操作对象
	*@param  string  $con  操作的详细信息
	*@param  int   $State  操作的状态
	*/
	function writeLog($OprTyp, $itm, $obj, $con, $State){
		//@session_start();
		//$usr=$_SESSION["Km"];
		$usr=$this->userEntity->userID;
		$sql = "insert into `user_operation_log` (`Time`,`UserID`,`TreeNodeSerialID`,`WeekPlaylistID`,`ProfileID`,`BroadcastSchemeID`,`Operation`,`OperationID`,`Comment`,`OptionName`,`State`,`Extend1`,`Extend2`,`Extend3`,`Extend4`,`Extend5`) values (NOW(),'".$usr."',NULL,NULL,NULL,NULL,NULL,'".$OprTyp."',".$this->db->escape($con).",'".$obj."','".$State."',NULL,NULL,NULL,NULL,NULL)";
		$this->db->query($sql);
		if($this->db->affected_rows())
		{
			//错误处理
		}
	}
	/**
	*从数据库中读取用户日志
	*
	*@param  string  $where  查询条件
	*@return  Array  array   返回数组结果
	*@version  用户日志2.0
	*@auther   kycool
	*/
	function readUserLog($where){
		//$sql = "select  `OperationName`,`RecordID`,`Time`,`UserID`,`Comment`,`OptionName`,`State` from `user_operation_type` as  a  join `user_operation_log` as  b    where  a.OperationID = b.State    and  ";
		$sql = "select a.OperationName,b.RecordID,b.Time,b.Comment,b.OptionName,b.State,c.UserID,c.UserName from user_operation_type as a join user_operation_log as b join user as c where a.OperationID = b.State and b.UserID = c.UserID and ";
		 $sql.=" unix_timestamp(b.Time) BETWEEN unix_timestamp('".$where["startTime"]." 00:00:00') and unix_timestamp('".$where["endTime"]." 23:59:59')";
		if($where["KM"] != ''){
			$sql.=" and  `b.UserID`  like `%".$where["KM"]."%'";}
		if($where["User"]!=""){
		$sql.=" and c.UserName like '%".$where["User"]."%'";}		
		if($where["Object"]!=""){
			$sql.=" and  b.OptionName  like '%".$where["Object"]."%' ";}
		if($where["con"]!=""){
		$sql.=" and  b.Comment like '%".$where["con"]."%'";}
		
		$data = $this->db->query($sql)->result_array();

//		var_dump($data);
//		exit();
	    if($where["excel"]=='1')
		{
			return $data;
		}
		$count=count($data);
		
		$sql.=" LIMIT ".$where["pageStart"]." , ".$where["pageSize"];
		$data=$this->db->query($sql)->result_array();
		
		//echo $sql;
		return array($count,$data);

	}
   //查询userlog
	function readUserLogX($where)
	{
		$sql="SELECT * FROM `userlog` WHERE ";
		$sql.="unix_timestamp(`Time`) BETWEEN unix_timestamp('".$where["startTime"]." 00:00:00') and unix_timestamp('".$where["endTime"]." 23:59:59')";
		if($where["User"]!=""){
		$sql.=" and `User` like '%".$where["User"]."%'";}
		if($where["KM"]!=""){
		$sql.=" and `User` like '%".$where["KM"]."%'";}
		if($where["Key"]!=""){
		$sql.=" and `Key` ='".$where["Key"]."'";}
		if($where["Type"]!=""){
		$sql.=" and `Type` ='".$where["Type"]."'";}
		if($where["Object"]!=""){
			$sql.=" and `Object` like '%".$where["Object"]."%' ";}
		if($where["con"]!=""){
		$sql.=" and `con` like '%".$where["con"]."%'";}
	    
		$data=$this->db->query($sql)->result_array();
	    if($where["excel"]=='1')
		{
			return $data;
		}
		$count=count($data);
		
		$sql.=" LIMIT ".$where["pageStart"]." , ".$where["pageSize"];
		$data=$this->db->query($sql)->result_array();
		
		//echo $sql;
		return array($count,$data);
	}
	
	function readUserLogAddUser($data)
	{
//		for($i=0,$n=count($data[1]); $i<$n; $i++)
//		{
//			$s=explode(",",$data[1][$i]["UserName"]);
//			if(count($s)>1)
//			{
//				$data[1][$i]["UserName"]=$s[1]."&nbsp;<em style=\'color:#ccc;\'>".$s[0]."</em>";
//			}
//			else
//			{$data[1][$i]["User"]=$s[0];}
//		}
		return $data;
	}
	
}
?>
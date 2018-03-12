<?php
class M_remind extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model("m_checkSession","Cks");
		$this->load->model('m_userEntity','userEntity');
	}
	function sqlQuotes($content)
	 {
		 //echo "get_magic_quotes_gpc:".get_magic_quotes_gpc()."<br>content:".is_array($content);
		 //如果magic_quotes_gpc=Off，那么就开始处理
		 if (!get_magic_quotes_gpc()) 
		 { 
		 
			 //判断$content是否为数组
			 if (is_array($content)) {
				 //如果$content是数组，那么就处理它的每一个单无
				 foreach ($content as $key=>$value) {
					$content[$key] = addslashes($value);
				 }
			 } else {
				 //如果$content不是数组，那么就仅处理一次
				$content= addslashes($content);
			 }
		 } else {
		 //如果magic_quotes_gpc=On，那么就不处理
		 }
		 //返回$content
		 return $content;
	 }
	 
	//审批表表插入数据
	function insertRemind($arr)
	{
		$arr=$this->sqlQuotes($arr);
			$sql="INSERT INTO `approver` (
				`id` ,
				`playListId` ,
				`clientId` ,
				`step` ,
				`Type` ,
				`Title` ,
				`ApproverDes` ,
				`AppYesUserInfo` , 
				`AppNoUserInfo` ,
				`State` ,
				`StartTime` ,
				`OverTime` 
				)
				VALUES (
				NULL , '".$arr["playListId"]."','".$arr["clientID"]."', '".$arr["step"]."','".$arr["Type"]."', '".$arr["Title"]."', '".$arr["ApproverDes"]."', '".$arr["AppYesUserInfo"]."', NULL , 0,'".$arr["StartTime"]."', NULL)";
			$this->db->query($sql);
			if($this->db->affected_rows())
			{
				return array("state"=>true,"data"=>$this->db->insert_id(),"sql"=>$sql);
			}
			else 
			{return array("state"=>false,"data"=>"您的输入有误!","sql"=>$sql);}
	}
	function updateApprover($info)
	{
		$ifo=array();
		if(is_array($info))
		{
			//echo Information("-----------------",$info);
			if(is_array($info["setValue"]))
			{
				foreach($info["setValue"] as $k=>$v)
				{
					$ifo[$k]=$v;
				}
			}
			if(isset($info["where"]))
			{
				$where = $info["where"]; 
				//echo $this->db->update_string('approver', $ifo, $where);
				$sql=$this->db->update_string('approver', $ifo, $where);
				$this->db->query($sql); 
				return array("state"=>true,"data"=>"","sql"=>$sql);
			}
			
		}
		
	}
	//审批表表查询数据
	function getRemind($arr)
	{
		$sql="select * from approver where id=".$arr["id"];
		return $this->db->query($sql)->result_array();
	}
	//向审批消息表插入数据
	function insertAppInfo($arr)  
	{
		$timeoffset   =   8;
		$sql=" INSERT INTO `app_info` (
				`id` ,
				`title` ,
				`collectionId` ,
				`sendId` ,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime`,
				`indexB`,
				`versionB`
				)
				VALUES (
				NULL , '".mysql_escape_string($arr["title"])."', '".$arr["collectionId"]."', '".$arr["sendId"]."', '".$arr["showUrl"]."', '".mysql_escape_string($arr["content"])."', '".$arr["state"]."', '".$arr["listId"]."', '".$arr["direction"]."', '".$arr["sendTime"]."','NULL', '".$arr["indexB"]."','".$arr["version"]."')";
		$this->db->query($sql);
		$id=$this->db->insert_id();
		if($this->db->affected_rows())
		{
			return array("state"=>true,"data"=>$id,"sql"=>$sql);
		}
		else
		{return array("state"=>false,"data"=>"您的输入有误!","sql"=>$sql);}
	}
	
	//查询用户的未读消息
	function selectUserRemind($uid,$start=0,$end=20)
	{
		$sql="select `id` ,
				`title` ,
				`collectionId` ,
				 (select UserName from user where UserID=`sendId`) as `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime` from app_info where indexB='0' and collectionId=".$uid." order by id desc limit ".$start.",".$end;
		return $this->db->query($sql)->result_array();
	}
	
	//查询用户提交后的未上级未处理消息
	//$uid --->  1,2,3,4
	function selectUpUserRemind($uid,$start=0,$end=20)
	{
		$sql="select title,Dept from user where UserID=".$uid;
		$rs=$this->db->query($sql)->result_array(); //查询用户的部门和审批位置
		$sql=" SELECT * FROM `accessflow` ";
		$rsa=$this->db->query($sql)->result_array(); //查询用户所在的审批流程  (当前只有一个审批流程---->北京阳光)
		$step=explode("|",$rsa[0]["step"]);
		$stp="NULL";
		for($i=0,$n=count($step); $i<$n; $i++)
		{
			if($step[$i]==$rs[0]["title"])
			{
				if($i!=$n-1)
				{
					$stp=$step[$i+1];  //找到用户的上级流程的代号
				}
			}
		}
		$sql="select UserID from user where Dept='".$rs[0]["Dept"]."' and title=".$stp; //查询用户的上级流程的 用户ID
		//$rsa=$this->db->query($sql)->result_array(); 
		$sql="select  `id` ,
				`title` ,
				(select UserName from user where UserID=`sendId`) as `sendId` ,
				 `collectionId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime`  from app_info where indexB='0' and collectionId in(".$sql.") and sendId=".$uid." limit ".$start.",".$end; //查询提交给上级用户,未处理的消息消息
		$rsa=$this->db->query($sql)->result_array(); 
		return $rsa;
	}
	
	//获取上级用户
function getUpUser()
{
		$sql_="select `UGroupID`,`RoleID` from user where  `UserID` =".$this->userEntity->userID; //获取流程位置
		$rs=$this->db->query($sql_)->result_array();

		$k="NULL";
		$dp = "NULL";
		$dp = $rs[0]["UGroupID"];
		$k=$rs[0]["RoleID"];		
		$sk = iconv("utf-8","utf-8",$dp);
		
//      -------- Begin ------	

		$mysql = "";	
		
		if($k == 4){
			if($dp == "市场经营部")
				$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE  RoleID ='23'";
			else
				$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE UGroupID='".$dp."' and RoleID ='33'";
		}
		if($k == 3){
			$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE UGroupID='".$dp."' and RoleID ='33'";
		}
		if($k == 33){
			$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE UGroupID='".$dp."' and RoleID ='32'";
		}
		if($k == 32){
			$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE RoleID ='2'";
		}		
		if($k == 2){ 
		    $mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE RoleID ='23'";			  
		}
		if($k == 23){
			$mysql = "SELECT UserName,UserID,IsCheck FROM user WHERE  RoleID ='22'";
		}		
		if($k == 22 || $k == 1){
			echo "shengpi__#@#__over";
			exit();	
		}		
		$rs=$this->db->query($mysql)->result_array();
		if(count($rs)==0)
		{
			echo "shengpi__#@#__over";
			exit();	
		}		
		echo "shengpi__#@#__".json_encode($rs);
}	
	
		
/*	function getUpUserBak()
	{
		//自定义提交方向
		$sql_="SELECT `accessFlowId`,`id`,`nextApprover`,`ext1` FROM acessinfo WHERE accessFlowId=1 and approverName='".$k."'";		
		$rs=$this->db->query($sql_)->result_array();
		
		
		$m=array();
		foreach($rs as $v)
		{
			$m[]=$v["nextApprover"];
		}		
		if(count($rs)>0)
		{			
			//$sql_="SELECT `UserName`,`UserID` FROM `user` WHERE `Dept`='".$dp."' and `Title` in(".implode(",",$m).")";
			$sql_="SELECT UserName,UserID FROM user WHERE Dept='".$dp."' and Rid in(".implode(",",$m).")";				
			$rs=$this->db->query($sql_)->result_array();		
			echo "shengpi__#@#__".json_encode($rs);
			exit();			
		}
		else		
		{
		   if($sk == '市场经营部')
		   {
			 echo "shengpi__#@#__over";
			 exit();	
		   }
		   else
		   {
			$sql_="SELECT `UserName`,`UserID` FROM `user` WHERE `Dept` ='市场经营部' and `Rid` in(4)";
			//echo "$sql_";
			$rs=$this->db->query($sql_)->result_array();
			echo "shengpi__#@#__".json_encode($rs);
			exit();
		   }
			
		}
		
		//默认方向
		$sql_="SELECT `step` FROM `accessflow` LIMIT 1";
		$rs=$this->db->query($sql_)->result_array();
		$s=explode("|",$rs[0]["step"]);
		
		for($i=0,$n=count($s); $i<$n; $i++)
		{
			if($s[$i]==$k)
				{
					if($i==$n-1)
					{
						$k="'over'"; //流程最末端
						break;
					}
					else
					{
						$k= $s[$i+1];
						break;
					}
					
				}
		}		
		if($k=="'over'")
		{				
			echo "shengpi__#@#__over";
			exit();				
		}
	}  
*/
	//设置读取后的消息   孙国安
	function readRemind($id){
		
		$sql="UPDATE `app_info` SET  `indexB` =  '1' , `state`='1' WHERE `id`=".$id." LIMIT 1";//, `state`='1'
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	function readRemindBohui($id)
	{
		$sql="UPDATE `app_info` SET  `indexB` =  '1' , `state`='2' WHERE `id`=".$id." LIMIT 1";//, `state`='1'
		$this->db->query($sql);
		return $this->db->affected_rows();
	}


	
	//获取驳回信息的用户  ----> 同意被驳回的信息驳回
	function getDUsers($id,$uid,$listId) 
	{
		$sql="SELECT `id` , `sendId` , (
		SELECT UserName
		FROM user
		WHERE UserId = `sendId`
		) AS sendName
		FROM `app_info`
		WHERE `collectionId` =".$uid."  
		AND `state` ='1'
		AND `id` <>".$id."
		AND `listId` =".$listId."
		AND `direction` = 'U'
		AND `indexB` = '1'"; //查询上级驳回的用户
		//echo $sql;
		$rsa=$this->db->query($sql)->result_array(); 
		return $rsa;
	}
	
	//获取驳回信息的用户 -----> 不同意 禁止通过
	function getDUser($id)
	{
		$info=$this->oneOfApprover(" id=".$id);
		if($info["state"])
		{
			$uid=$this->Cks->check();
			$users=json_decode($info["data"][0]["AppYesUserInfo"],true);
			//echo Information("getDUser",$users);
			
			$ida=0;
			$i=0;
			foreach($users as $k=>$v)
			{
				
				if($k!=$uid)
				{
					$ida=$k;
				}
				else{break;}
				$i++;
			}
			//echo Information("getDUser","i: ".$i);
			//exit();
			if($i==0)
			{
				return array("state"=>true,"data"=>"start","info"=>$info);
			
			}
			if($ida!=0)
			{
				$data=$this->getUserById($ida);
				if(count($data)>0)
				{
					return array("state"=>true,"data"=>array("uid"=>$ida,"uname"=>$data[0]["UserName"]),"info"=>"");
				}
				else
				{
					return array("state"=>false,"data"=>"编号为 $ida 用户的信息已丢失!","info"=>"");
				}
			}
			else 
			{
				return array("state"=>false,"data"=>"没有任何人给你提交此条信息","info"=>"");
			}
		}
		else{	return array("state"=>false,"data"=>"没有此条信息!","info"=>"");}
		//$sql="select  *,(select UserName from user where UserID=`sendId`) as sendName  from app_info where indexB='0' and id=".$id;
		//$rsa=$this->db->query($sql)->result_array(); 
		//return $rsa;
		
	}
	
	//获取被驳回的信息
	function selectBoHui($uid,$start=0,$end=20)
	{
		$sql="select `id` ,
				`title` ,
				`collectionId` ,
				 (select UserName from user where UserID=`sendId`) as `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime` from app_info where state='2' and indexB = '2' and collectionId=".$uid." order by id desc limit ".$start.",".$end;
		return $this->db->query($sql)->result_array();
	}
	//sga获取通过完成的信息
	function selectOverWork($uid,$start=0,$end=20){
		$sql="select `id` ,
				`title` ,
				`collectionId` ,
				 (select UserName from user where UserID=`sendId`) as `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime` from app_info where indexB ='1' and state ='1' and collectionId=".$uid." order by id desc limit ".$start.",".$end;
		return $this->db->query($sql)->result_array();
	}
	//sga获取驳回完成的信息
	function selectBohuiOverWork($uid,$start=0,$end=20){
		$sql="select `id` ,
				`title` ,
				`collectionId` ,
				 (select UserName from user where UserID=`sendId`) as `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime` from app_info where indexB='1' and state = '2' and collectionId=".$uid." order by id desc limit ".$start.",".$end;
		return $this->db->query($sql)->result_array();
	}
	//sga
	function selectOverWorkSend($uid,$start=0,$end=20){
		$sql="select `id` ,
				`title` ,
				`collectionId` ,
				 (select UserName from user where UserID=`sendId`) as `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime` from app_info where indexB='1' and state = '1' and sendId=".$uid." order by id desc limit ".$start.",".$end;

		return $this->db->query($sql)->result_array();
	}
	//消息结束 -->  被驳回到起始端sga
	function infoOver($id){
		$sql = "select  state  from app_info where id=".$id;
		$query = $this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$s = $row->state;
				if($s == "1"){
					return $this->readRemind($id);
				}else if($s == "2"){
					return $this->readRemindBohui($id);
				}else if($s == "0"){
					return $this->readRemind($id);
				}
			}
		}
	}
	function getUserById($id)
	{
		if($id != '')
		{
			$sql = "select Km,UserName, UserID from user where UserID=".$id;
			return $this->db->query($sql)->result_array();
		}
	}
	function getAppInfo($RmId)
	{
		if($RmId==""){return array();}
		$sql="select listId,content,state,sendTime,indexB,(select UserName from user where UserID=sendId) as sendUser,(select UserName from user where UserID=collectionId) as collectionUser from app_info where id in(".$RmId.")";
		$data=$this->db->query($sql)->result_array();
		//echo Information("-------------",$data);
		return $data;
	}
		//查询某一条被审批对象的所有审批人员的意见,及内容
		function getOneOfRemind($id)
		{
			$sql="SELECT * FROM  `approver` where id=".$id."";
			$res=$this->db->query($sql)->result_array();
			if(count($res)>0)
			{
				$v=$res[0];
				if($v["AppYesUserInfo"]!="")
				{
					$info=json_decode($v["AppYesUserInfo"],true);
					//echo Information("getOneOfRemind",$info);
					
					foreach($info as $id=>$av)
					{
						$user_ids[]=$id;
						if($av["appId"]!="")
						{
							$app_ids[]=$av["appId"];
						}
					}
					
					$uInf=$this->getUserInfo($user_ids);
					if(count($uInf))
					{
						$i=0;
						foreach($info as $id=>$av)
						{
							//补充用户信息
							foreach($uInf as $uv)
							{
								if($id==$uv["UserID"])
								{
									$info[$id]["userName"]=$uv["UserName"];
								}
								
							}
							$i++;
						}
					}
					$res[0]["AppYesUserInfo"]=$info;
					
					$app_info=$this->getAppInfo(implode(",",$app_ids));
					if(count($app_info))
					{
						//echo Information("app_ids",$app_ids);
						$i=0;
						foreach($info as $id=>$av)
						{
							//补充用户信息
							if($i<count($app_info)||$av["appId"]!="")
							{
								$info[$id]["appInfo"]=$app_info[$i];
							}
							
							$i++;
						}
					}
					$res[0]["AppYesUserInfo"]=$info;
					
					unset($app_info);
					unset($uInf);
					unset($user_ids);
				}
				
				
				
				
				$v=$res[0];
				$user_ids=array();
				$app_ids=array();
				if($v["AppNoUserInfo"]!="")
				{
					$i=100;
					$info=json_decode($v["AppNoUserInfo"],true);
					foreach($info as $id=>$av)
					{
						$user_ids[$i]=$id;
						$i--;
						if($av["appId"]!="")
						{
							$app_ids[]=$av["appId"];
						}
					}
					
//					echo Information("user_ids顺序",$user_ids); 
					$uInf=$this->getUserInfo($user_ids);
				//echo Information("顺序不变",$uInf);
				
					//krsort($uInf); 
					//echo Information("顺序已变",$uInf);
					if(count($uInf))
					{
						$i=0;
						foreach($info as $id=>$av)
						{
							//补充用户信息
							//echo $id."=====>".$uInf[$i]["UserName"]."<br>";
							foreach($uInf as $uv)
							{
								if($id==$uv["UserID"])
								{
									$info[$id]["userName"]=$uv["UserName"];
								}
								
							}
							
							$i++;
						}
					}
					
					$res[0]["AppNoUserInfo"]=$info;
					$app_info=$this->getAppInfo(implode(",",$app_ids));
					if(count($app_info))
					{
						$i=0;
						foreach($info as $id=>$av)
						{
							//补充用户信息
							if($i<count($app_info))
							{
								$info[$id]["appInfo"]=$app_info[$i];
							}
							$i++;
						}
					}
					$res[0]["AppNoUserInfo"]=$info;
				
				}
				return array("state"=>true,"data"=>$res,"sql"=>$sql);
			}
			else
			{return array("state"=>false,"data"=>$id,"sql"=>$sql);}
		}
	//function getOneOfRemind($RmId)
	//{
		//$sql="select listId,content,state,indexB,(select UserName from user where UserID=sendId) as sendUser,(select UserName from user where UserID=collectionId) as collectionUser from app_info where listId=".$RmId;
		//$data=$this->db->query($sql)->result_array();
		//return $data;
	//}
	function getUserRemindInfo($other,$page,$pageSize,$count=0)
	{
		$sql=" SELECT  `id` ,  `playListId` , `clientId` ,  `step` ,  `Type` ,  `Title` ,  `ApproverDes` ,  `AppYesUserInfo` ,  `AppNoUserInfo` ,  `State` ,  `StartTime` ,  `OverTime` 
FROM  `approver` WHERE  ".$other; 
		
		if($count<=0)
		{
			$totalRows=$this->db->query($sql)->num_rows;
			$totalPages = ceil($totalRows/$pageSize);
		}
		else{$totalPages=$count;}
		$sql.=" ORDER BY id DESC";
		$sql.=" LIMIT ".$page." , ".$pageSize;
		
		
		$Recordset=$this->db->query($sql)->result_array();
		
		$res["totalPage"]=$totalPages;
		$res["data"]=$Recordset; 
		$res["sql"]=$sql;
		return $res;
	}
	function getUserInfo($id_array)
	{
		$this->db->select("UserName,UserID");
		$this->db->where_in('UserID',$id_array);
		return $this->db->get("user")->result_array();

	}

	/*function getHistoryInfo__bak($other,$page,$pageSize,$count=0)
	{
		$sql="select  `id` ,
				`title` ,
				`collectionId`,
				(select UserName from user where UserID=`collectionId`) as `userName` ,
				(select UserName from user where UserID=`sendId`) as `sendUserName` ,
				 `sendId`,
				`showUrl` ,
				`content` ,
				`state` ,
				`listId` ,
				`direction`,
				`sendTime`,
				`readTime`,indexB  from app_info where   ".$other; 
		
		if($count<=0)
		{
			$totalRows=$this->db->query($sql)->num_rows;
			$totalPages = ceil($totalRows/$pageSize);
		}
		else{$totalPages=$count;}
		$sql.=" ORDER BY id DESC";
		$sql.=" LIMIT ".$page." , ".$pageSize;
		
		$Recordset=$this->db->query($sql)->result_array();
		
		$res["totalPage"]=$totalPages;
		$res["data"]=$Recordset; 
		$res["sql"]=$sql;
		return $res;
	}*/
	//孙国安 悲观锁控制审批事务
	function checkExcelName(){
		//从session中拿到部门信息，组成excel播放计划名称
		@session_start();
		$playlistName = $this->userEntity->userGroupID."_Excel";
		//查询此播放计划的id
		$this->db->select("WeekPlaylistID");
		$this->db->where("WeekPlaylistName" ,$playlistName);
		$WeekPlaylistIDs = $this->db->get("week_playlist")->result_array();
		//echo Information("checkExcelName",$WeekPlaylistIDs);
		//	exit();
		if($WeekPlaylistIDs != null){
			$WeekPlaylistID = $WeekPlaylistIDs[0]["WeekPlaylistID"];		
			//echo "播放计划ID=".$WeekPlaylistID;
			$this->db->select("max(id)");
			$this->db->where("showUrl" ,$WeekPlaylistID);
			$ids = $this->db->get("app_info")->result_array();
			$id = $ids[0]["max(id)"];
			//根据播放计划最后的id查询该播放计划是否完成审批流
			//echo Information("checkExcelName",$ids);
			//exit();
			if($id != null){
			
				$this->db->select("versionB");
				$this->db->where("id" ,$id);
				$VersionBs = $this->db->get("app_info")->result_array();
				$versionB = $VersionBs[0]["versionB"];	
				//echo Information("checkExcelName",$VersionBs);
				//exit();
				//逻辑判断，返回
				if($versionB == "1"){
					return 1;
				}elseif($versionB == "0"){
					return 0;
				}
				return 2;
			}
			return 3;
		}
		return 4;
	}
	//判断播放计划是否被锁定
	function importcheck()
	{
		$palyname = $this->userEntity->userGroupID."_Excel";
		//$palyname = iconv("gbk","utf-8",$_SESSION["Dept"]."_Excel");		
		$this->db->select("Extend3");
				$this->db->where("weekplaylistname" ,$palyname);
				$Extend3s = $this->db->get("week_playlist")->result_array();
	    if(count($Extend3s)>0)
	    {
	       $Extend3 = $Extend3s[0]["Extend3"];
	       if($Extend3==1)
	       {
	     	  return false;
	       }
	       else {               
	       	  return true;
	       }
	    }
	    else 
	    {
	    	return true;
	    }
	}
	
	// 在 approver 获取一条信息
	function oneOfApprover($where)
	{
		$sql="select * from approver where ".$this->sqlQuotes($where);
		$Info=$this->db->query($sql)->result_array();
		if(count($Info)>0)
		{
			 return array("state"=>true,"data"=>$Info,"sql"=>$sql);
		}
		else
		{
			 return array("state"=>false,"data"=>"","sql"=>$sql);
		}
	}
	

}
?>
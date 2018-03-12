<?php
class M_client extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->model('m_userEntity','userEntity');
		$this->load->model('m_userlog','UserLog');
		$this->load->model('m_clientext','clientExt');
        $this->load->model('m_clientLog','ClientLog');
		
	}
	function allClientTreea(){
		//return array( "getUsersTree" => $this->clientExt-> getUsersTree(), "allClientTree" => $this->clientExt->allClientTree(), "g_etClientInfo" => $this->clientExt->getUserAllTreeInfo());
		
		return $this->clientExt->allClientTree();
		}
	function allClientTree(){
		//return array( "getUsersTree" => $this->clientExt-> getUsersTree(), "allClientTree" => $this->clientExt->allClientTree(), "g_etClientInfo" => $this->clientExt->getUserAllTreeInfo());
		
		return $this->clientExt->allClientTree();
		}
	
	function getUserGroup()
	{
		return $this->clientExt->getUserAllTreeInfo();
		//@session_start();
//		if($_SESSION['opuserID']=="1")
//		{
//			$sql="SELECT TreeNodeCode,Name from client_tree where IsClient=0";
//		}
//		else 
//		{
//			$sql="SELECT TreeNodeCode,Name from client_tree where TreeNodeSerialID in (select TreeNodeSerialID from user_client where UserID=".$_SESSION['opuserID'].")";
//		}
//		$query=$this->db->query($sql);
//		if($query->num_rows>0)
//		{
//			$clientInfo=array();
//			$i=0;
//			foreach($query->result() as $row)
//			{
//				if($_SESSION['opuserID']=="1")
//				{
//					$clientInfo[$i]['groupName']=$row->Name;
//					$clientInfo[$i]['groupCode']=$row->TreeNodeCode;
//					$i++;
//				}
//				else
//				{
//					if($row->Name!="root")
//					{
//						$clientInfo[$i]['groupName']=$row->Name;
//						$clientInfo[$i]['groupCode']=$row->TreeNodeCode;
//						$i++;
//					}
//				}
//			}
//			return $clientInfo;
//		}
	}
	

	function getClientInfo($clientID=''){
		
		return $this->clientExt->getClientInfo($clientID);
	}
	function showClientTree_ajax($item=''){
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
		client_tree ";
		$sql.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by IsClient";
		//echo $sql;
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
			echo "<table cellpading='0' cellspacing='0' border='0'>";
			foreach($query->result() as $row){
				$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
				$ClientTree[$i]['TreeName']=$row->Name;
				$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$ClientTree[$i]['TreeIsClient']=$row->IsClient;
				echo "<tr>";
				if($ClientTree[$i]['TreeIsClient']==0){//是组的话进行下一轮循环

					echo "<td width='20'>group".$row->Name."</td>";
					echo "<td onClick='javascript:showTree(".$row->TreeNodeCode.")'>";
					//$this->showClientTree($row->TreeNodeCode);

				}else{
					echo "<td width='20'>client".$row->Name."</td>";
					echo "<td>";

				}
				echo "</td></tr>";

				$i++;
			}//forech end
			echo ("</ul>");
		}		
	}

	function createExtTree($treeNode=''){
		$item=$treeNode;
		$returnArr='';
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
		client_tree ";
		$sql.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by IsClient";
		//echo $sql;
		$query=$this->db->query($sql);
		$i=0;
		$treeStr='';
		if($query->num_rows>0){
			$treeStr="[";
			//$returnArr="<ul><a href=#>$item</a>";
			foreach($query->result() as $row){
				$treeStr.='{';
				$treeStr.="text:'".$row->Name."',";
				$treeStr.="id:'".$row->TreeNodeCode."',";
				$treeStr.="checked:false,";

				$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
				$ClientTree[$i]['TreeName']=$row->Name;
				$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$ClientTree[$i]['TreeIsClient']=$row->IsClient;
				if($ClientTree[$i]['TreeIsClient']==0){//是组的话进行下一轮循环
					//sb.Append("href:'" + dr["href"].ToString() + "',");
                    //sb.Append("hrefTarget:'" + dr["hrefTarget"].ToString() + "',");	外部链接
					$treeStr.='leaf:false';
				}else{
					$treeStr.='leaf:true';
				}
				$treeStr.='}';


			}//forech end
			$treeStr.=']';
			//echo $treeStr;
		}
		$treeStr2=str_replace("}{","},{",$treeStr);
		echo $treeStr2;
	}
	function showClientTree($item=''){
		$returnArr='';
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
		client_tree ";
		$sql.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by IsClient";
		//echo $sql;
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){

			//$returnArr="<ul><a href=#>$item</a>";
			foreach($query->result() as $row){
				$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
				$ClientTree[$i]['TreeName']=$row->Name;
				$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$ClientTree[$i]['TreeIsClient']=$row->IsClient;
				if($ClientTree[$i]['TreeIsClient']==0){//是组的话进行下一轮循环
					echo ("<li><ul><a href=# id=".$row->TreeNodeCode.">group:".$row->Name."</a>");
					$returnArr.="<li><ul><a href=# id=".$row->TreeNodeCode.">group:".$row->Name."</a>";
					$this->showClientTree($row->TreeNodeCode);
					$returnArr.="</ul></li>";
					echo ("</ul></li>");


				}else{
					echo ("<li><a href=# id=".$row->TreeNodeCode.">".$row->Name."</a></li>");
					$returnArr.="<li><a href=#>".$row->Name."</a></li>";
				}
				$i++;
			}//forech end
			$returnArr.="</ul>";
		}

	}
	public $treeNode='';
	public $groupNode='';
	public $treeNode2='';
	public $groupNode2='';
	public $nodeId=0;
	function showClientTree2($item='',$isGroup=0){
		//$treeNode="d.add(0001,-1,'My example tree','_blank','folder.gif');\n";
		@session_start ();
		$Rid =  $this->userEntity->userRoleID;
		
		$treeNode='';
		$groupNode='';
		$treeNode2='';
		$groupNode2='';
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql = '';		
		if($Rid == 1){			
			$sql = "select TreeNodeSerialID,Name,TreeNodeCode,IsClient from client_tree  where length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by IsClient";			
		}
		if($Rid == 2){
			$sql = "select TreeNodeSerialID,Name,TreeNodeCode,IsClient from client_tree  where Extend1 !='sa' and length(TreeNodeCode)=$len and TreeNodeCode like '$item%' order by IsClient";		
		}
		
		//echo $sql."<br>";
		$query=$this->db->query($sql);
		
		$i=0;
		$returnStr='';
		if($query->num_rows>0){

			//$returnArr="<ul><a href=#>$item</a>";
			foreach($query->result() as $row){
				$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
				$ClientTree[$i]['TreeName']=$row->Name;
				$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$ClientTree[$i]['TreeIsClient']=$row->IsClient;
				$lastNode=substr($row->TreeNodeCode,0,strlen($row->TreeNodeCode)-4);
				if($ClientTree[$i]['TreeIsClient']==0){//是组的话进行下一轮循环
				//mytree.add(1, 0, 'My node', 'node.html', 'node title', 'mainframe', 'img/musicfolder.gif');
				//<a id="111" oncontextmenu=al(event)>
					$treeNode.="d.add(".$row->TreeNodeCode.",".$lastNode.",'<a id=$row->TreeNodeCode title=0 name=".$this->nodeId." oncontextmenu=\"al(event)\")>".$row->Name."</a>','','','','img/folder.gif');\n" ;

					$groupNode.="ds.add(".$row->TreeNodeCode.",".$lastNode.",'<a id=$row->TreeNodeCode title=0 name=".$row->Name." onclick=\"move(this)\")>".$row->Name."</a>','','','','img/folder.gif');\n" ;
					$treeNode2.=$row->TreeNodeCode.','.$lastNode.',0,'.$row->Name.'|';
					$groupNode2.=$row->TreeNodeCode.','.$lastNode.',0,'.$row->Name.'|';
					//d.add(14,13,'Jessica2','','node Title','_blank','img/folder.gif');
					$this->showClientTree2($row->TreeNodeCode);
					if($isGroup==1) continue;
				}else{
					$treeNode.="d.add(".$row->TreeNodeCode.",".$lastNode.",'<a id=$row->TreeNodeCode title=1 name=".$this->nodeId." oncontextmenu=\"al(event)\")>".$row->Name."</a>');\n";
					$treeNode2.=$row->TreeNodeCode.','.$lastNode.',1,'.$row->Name.'|';
				}
				$i++;
				$this->nodeId++;
			}//forech end

		}
		$this->groupNode.=$groupNode;
		$this->treeNode.=$treeNode;
		$this->treeNode2.=$treeNode2;

	}

	function getAllClient($isClient){
		$client=array();
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from client_tree";
		$sql.=" where IsClient=".$isClient;
		//echo $sql;
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$client[$i]['clientNum']=$row->TreeNodeSerialID;
				$client[$i]['clientName']=$row->Name;
				$client[$i]['clientNodeCode']=$row->TreeNodeCode;
				$i++;
			}//forech end
		}
		return $client;
	}
	function getPlayList(){
		$this->db->where("Extend1", $this->userEntity->userGroupID);
		$this->db->order_by('WeekPlaylistID','desc');
		$query=$this->db->get('week_playlist');
		$i=0;
		$playList=array();
		foreach($query->result() as $row){
			$playList[$i]['playListID']=$row->WeekPlaylistID;
			$playList[$i]['playListName']=$row->WeekPlaylistName;
			$playList[$i]['playListType']=$row->WeekPlaylistType;
			$playList[$i]['lastTime']=$this->getPlayListLastTime($row->WeekPlaylistID);
			$i++;
		}
		return $playList;
	}
	//获取播放日期，判断是否过期用
	function getPlayListLastTime($weekPlaylistID=''){
		$sql="select EndTime from week_playlist_describe where WeekPlaylistID=$weekPlaylistID order by EndTime desc limit 1";
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$lastTime=$row->EndTime;
				return $lastTime;
			}//forech end
		}else{
			return;
		}

	}
	function checkIsExistsPlaylistName($playlistName){
		$sql="select WeekPlayListName from week_playlist where WeekPlaylistName='".$playlistName."'";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			//echo '播放计划名已存在，请重新输入';
			echo '1';
		}else{
			//echo '播放计划名可用';
			echo '0';
		}
	}
	//dsy---------------------------------------添加播放计划
	function addPlaylist($playlistName='',$playDataStr='',$playlistType='X86'){		
		$playlistName=iconv("GB2312","UTF-8",urldecode($playlistName));
		
		$playlistData=array(
					'WeekPlayListName'=>$playlistName,
					'WeekPlayListType'=>$playlistType,
					"Extend1"=> $this->userEntity->userGroupID,
					"Extend2"=> $this->userEntity->userID
							);
		$this->db->insert('week_playlist', $playlistData);
		$playlistID=$this->db->insert_id();

		//操作日志
		//$this->M_common->saveEventLog('playlist','add',$playlistID);
		//添加到week_playlsit_describe
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			if($i==$num-1){
				$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior);
			}else{
				$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior).',';
			}
		}
		$sqlStr="insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime) values".$playDataInfo;

		$query=$this->db->query($sqlStr);

		$rows=$this->db->affected_rows();
		if($rows<=0){
		
			$this->UserLog->savePlaylist('1','102',null,null,0);
			echo '播放计划保存失败';
		}else{
			$this->UserLog->savePlaylist('1','102',iconv("utf-8","gb2312",$playlistName),$playDataStr,1);
			echo '0';
		}

	}
	//-----------------------添加到临时播放列表
    function addTemPlaylist($playlistName='',$playDataStr='',$playlistType='X86'){		
		$playlistName=iconv("GB2312","UTF-8",urldecode($playlistName));
		@session_start();
		$playlistData=array(
					'WeekPlayListName'=>$playlistName,
					'WeekPlayListType'=>$playlistType,
					"Extend1"=> $this->userEntity->userGroupID,
					"Extend2"=> $this->userEntity->userID
							);
		$this->db->insert('week_templaylist', $playlistData);
		$playlistID=$this->db->insert_id();

		//操作日志
		//$this->M_common->saveEventLog('playlist','add',$playlistID);
		//添加到week_playlsit_describe
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			if($i==$num-1){
				$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior);
			}else{
				$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior).',';
			}
		}
		$sqlStr="insert into week_Templaylist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime) values".$playDataInfo;

		$query=$this->db->query($sqlStr);

		$rows=$this->db->affected_rows();
		if($rows<=0){
		
			$this->UserLog->savePlaylist('1','102',null,null,0);
			echo '播放列表保存失败';
		}else{
			$this->UserLog->savePlaylist('1','102',iconv("utf-8","gb2312",$playlistName),$playDataStr,1);
			echo '0';
		}

	}
	//dsy----------------------------------修改播放计划
	function updatePlaylist($playlistID,$playDataStr,$playlistName){
		//添加到week_playlsit_describe
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		for($i=0,$num=count($playDataArr);$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			if($i==$num-1){
			$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior);
			}
			else
			{$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior).",";}
		}

		$sqlStr="insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime) values".$playDataInfo;

		$query=$this->db->query($sqlStr);
		$rows=$this->db->affected_rows();
		//$this->M_common->saveEventLog('playlist','edit',$playlistID);
		if($rows<=0){
			$this->UserLog->saveEditPlaylist('2','103',null,null,0);
			echo '播放计划保存失败';
		}else{
			$this->UserLog->saveEditPlaylist('2','103',$playlistName,$playDataStr,1);
			echo '0';
		}

	}
	function updateTemPlaylist($playlistID,$playDataStr,$playlistName){
		//添加到week_playlsit_describe
		$playDataArr=json_decode($playDataStr,true);
		$playDataInfo='';
		for($i=0,$num=count($playDataArr);$i<$num;$i++){
			$startTime=$playDataArr[$i]['startTime'];
			$endTime=$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['profileID'];
			$prior=$playDataArr[$i]['prior'];
			if($i==$num-1){
			$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior);
			}
			else
			{$playDataInfo.=$this->getPlayDataInfo($startTime,$endTime,$playlistID,$profileID,$prior).",";}
		}

		$sqlStr="insert into week_templaylist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime) values".$playDataInfo;

		$query=$this->db->query($sqlStr);
		$rows=$this->db->affected_rows();
		//$this->M_common->saveEventLog('playlist','edit',$playlistID);
		if($rows<=0){
			$this->UserLog->saveEditPlaylist('2','103',null,null,0);
			echo '播放计划保存失败';
		}else{
			$this->UserLog->saveEditPlaylist('2','103',$playlistName,$playDataStr,1);
			echo '0';
		}

	}
	//方法已转移到 m_playlist.php中 2012-1-17 22:03:40
	//将临时表数据复制到正式表里
	function upTemPlayList($playlistid='')
	{
		
		$sqlstr = "select * from week_Templaylist_describe where weekPlayListId = '".$playlistid."'";
		$sqlstr1 = "select * from week_Templaylist where weekPlayListId = '".$playlistid."'";
		$sqlstr2 = "select * from week_playlist where weekPlayListId = '".$playlistid."'";
		$rs=$this->db->query($sqlstr)->result_array();
		$rs1=$this->db->query($sqlstr1)->result_array();	
		$rs2=$this->db->query($sqlstr2)->result_array();	
	    if(count($rs)>0)
		{
		        // 将临时表数据复制到正式表里
				foreach($rs as $v)
			    {
				   $insertsql = "insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime)
				   values(".$v["WeekPlaylistID"].",".$v["ProfileID"].",".$v["ProfilePrior"].",'".$v["StartTime"]."','".$v["EndTime"]."')";
				   $this->db->query("$insertsql");
			    }
			    //删除已复制完的临时数据
			    $this->db->query("delete from week_Templaylist_describe where WeekPlaylistID = ".$playlistid);
		        if(count($rs2)==0)
		        {
		        	$insertsql1 = "insert into week_playList (WeekPlaylistName,WeekPlaylistType,IsChecked,Extend1,Extend2,Extend3) values('".$rs[0]["WeekPlaylistName"]."','".$rs[0]["WeekPlaylistType"]."','".$rs[0]["IsChecked"]."','".$rs[0]["Extend1"]."','".$rs[0]["Extend2"]."',NULL)";
		            $this->db->query("$insertsql1");
		        }
		        //else {
		       // 	$insertsql2 = "update week_playList set Extend3 is null where WeekPlayListId = ".$playlistid;
		      //      $this->db->query("$insertsql2");
		       // }
		}
		
	}
	//方法已转移到 m_playlist.php中 2012-1-17 22:03:40
	/*function getPlayDataInfo($start,$end,$weekPlaylistID='',$profileID='',$prior='1'){
		list($startDate,$startTime)=split(',',$start);
		list($endDate,$endTime)=split(',',$end);
		list($sYear,$sMonth,$sDay)=split('-',$startDate);
		$sTime=mktime(0,0,0,$sMonth,$sDay,$sYear);
		list($eYear,$eMonth,$eDay)=split('-',$endDate);
		$eTime=mktime(0,0,0,$eMonth,$eDay,$eYear);
		$days=($eTime-$sTime)/(24*3600);
		$playDataInfo="";
		for($i=0;$i<=$days;$i++){
			$sDate=date("Y-m-d",$sTime).",".$startTime;
			$eDate=date("Y-m-d",$sTime).",".$endTime;
			if($i==$days){
				$playDataInfo.='('.$weekPlaylistID.','.$profileID.','.$prior.',\''.$sDate.'\',\''.$eDate.'\')';
			}else{
				$playDataInfo.='('.$weekPlaylistID.','.$profileID.','.$prior.',\''.$sDate.'\',\''.$eDate.'\'),';
			}
			$sTime=$sTime+24*3600;
		}
		return $playDataInfo;
	}*/
	
	function getProfile(){
		@session_start();
		$this->db->where('Extend5', $this->userEntity->userGroupID);
		$this->db->order_by('ProfileID','desc');
		$query=$this->db->get('profile');
		$i=0;
		$profile=array();
		foreach($query->result() as $row){
			$profile[$i]['profileID']=$row->ProfileID;
			$profile[$i]['profileName']=$row->ProfileName;
			$profile[$i]['profileType']=$row->ProfileType;
			$i++;
		}
		//print_r($profile);
		return $profile;
	}
	//dsy--------------------------------------------删除播放计划
	
	//已转移到 m_playlist.php中 2012-1-17 22:09:48
	function deletePlaylist($playlistID=''){
		//查播放计划名
		$sql=" select weekplaylistname from week_playlist where WeekPlaylistID = ".$playlistID;
		
		$query=$this->db->query($sql);
		
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$temp=$row->weekplaylistname;
						
			}
		}
		//查profile的name
		$sqlPro="select profilename from profile where ProfileID in (select ProfileID from week_playlist_describe where WeekPlaylistID = '".$playlistID."')";
		$query=$this->db->query($sqlPro);
		
		$pro=array();
		$i=0;
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$pro[$i]=$row->profilename;
				$i++;		
			}
		}
		//查profile数量
		$sqlPro="select count(ProfileID) as sum from week_playlist_describe where WeekPlaylistID = '".$playlistID."'";
		$query=$this->db->query($sqlPro);
		
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$prosum=$row->sum;
				
			}
		}
	
		
		if($playlistID!=''){
			$this->db->delete('week_playlist_describe',array('WeekPlaylistID'=>$playlistID));
			$this->db->delete('week_playlist',array('WeekPlaylistID'=>$playlistID));
			//$this->M_common->saveEventLog('playlist','delete',$playlistID);
		}
		
		if($this->db->affected_rows())
		{
				$this->UserLog->deletePlaylist('3','103',$temp,$pro,1,$prosum);	
			
		}else
		{
				$this->UserLog->deletePlaylist('3','103',null,null,0,null);	
		
		exit(0);}

	}
	//此方法已经转移到 m_playlist.php 中 2012-1-17 22:07:14
	function deleteMulpPlaylist($playlistIDStr=''){
		$playlistIDArr=explode (',',$playlistIDStr);
		foreach($playlistIDArr as $playlistID){
			$this->deletePlaylist($playlistID);
		}
	}
	function getPlayInfo($playListID){
		$playInfo=array();
		$sql="select ProfilePrior,StartTime,EndTime,ProfileName,b.Extend2 from week_playlist_describe as b left join profile on profile.profileID=b.profileID
where b.weekplaylistID=".$playListID;

		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//$playInfo[$i]['profilePrior']=$row->ProfilePrio;
				$playInfo[$i]['profileName']=$row->ProfileName;
				$playInfo[$i]['startTime']=$row->StartTime;
				$playInfo[$i]['endTime']=$row->EndTime;
				$playInfo[$i]['describeID']=$row->Extend2;
				switch($row->ProfilePrior){
					case 1:
						$pre="低优先级";
						break;
					case 2:
						$pre="高优先级";
						break;
					default:
						$pre="低优先级";
				}
				$playInfo[$i]['playListPre']=$pre;
				$i++;
			}
		}
		/*echo "<pre>";
		print_r($playInfo);
		echo "</pre>";*/
		return $playInfo;
	}
	function deletePlayList_Describe($ProfileID)
	{
		$this->db->delete('week_playlist_describe',array('ProfileID'=>$ProfileID));
		$this->db->delete('week_Templaylist_describe',array('ProfileID'=>$ProfileID));
	}
	//---------------------------------------------------dsy删除节目单
	function deleteDescribe($playlistID='',$isDelAll='0'){
		if($isDelAll=='1'){	
			//查播放计划名称
			//$sql="select WeekPlaylistName from week_playlist where WeekPlaylistID=".$playlistID;
			$sql="select WeekPlaylistName from week_templaylist where WeekPlaylistID=".$playlistID;
			 $query=$this->db->query($sql);
			 if($query->num_rows>0){
				 foreach($query->result() as $row){
					 $playname=$row->WeekPlaylistName;
					
				 }
			 }
			
				//查节目单名称 WeekPlaylistID=playlistID
				//$sql="select profilename from profile  where profileid in (SELECT profileid from week_playlist_describe where WeekPlaylistID=".$playlistID.")";
				$sql="select profilename from profile  where profileID in (SELECT profileID from week_templaylist_describe where WeekPlaylistID=".$playlistID.")";
				 $query=$this->db->query($sql);
					$i=0;
					$temp=array();
				 if($query->num_rows>0){
					 foreach($query->result() as $row){
						 $temp[$i]=$row->profilename;
						$i++;
					 }
					 $temp=array("array",$temp);
				 }
		 
			//查profile数量
		//$sqlPro="select count(ProfileID) as sum from week_playlist_describe where WeekPlaylistID = '".$playlistID."'";
		$sqlPro="select count(ProfileID) as sum from week_templaylist_describe where WeekPlaylistID = '".$playlistID."'";
		$query=$this->db->query($sqlPro);
		
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$prosum=$row->sum;
				
			}
		}

			//$this->db->delete('week_playlist_describe',array('WeekPlaylistID'=>$playlistID));
			$this->db->delete('week_templaylist',array('WeekPlaylistID'=>$playlistID));
		}else{
		
			
			//查播放计划名称
				$sql="select WeekPlaylistName from week_playlist where WeekPlaylistID=(SELECT WeekPlaylistID from week_playlist_describe where Extend2=".$playlistID.")";
				 $query=$this->db->query($sql);
			 if($query->num_rows>0){
				 foreach($query->result() as $row){
					 $playname=$row->WeekPlaylistName;
					
				 }
			 }
		
			//查节目单名称 Extend2=playlistID
			$sql="select profilename from profile  where profileid=(SELECT profileid from week_playlist_describe where Extend2=".$playlistID.")";
		 $query=$this->db->query($sql);
		 if($query->num_rows>0){
			 foreach($query->result() as $row){
				 $temp=array("string",$row->profilename);
			 }
		 }
		 	//查profile数量
		$sqlPro="select count(ProfileID) as sum from week_playlist_describe where Extend2 = '".$playlistID."'";
		$query=$this->db->query($sqlPro);
		
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$prosum=$row->sum;
				
			}
		}
			$this->db->delete('week_playlist_describe',array('Extend2'=>$playlistID));
		}
		if($this->db->affected_rows())
		{
				$this->UserLog->deleteDescribe('3','103',$temp,1,$playname,$prosum);
			
		}else
		{
				$this->UserLog->deleteDescribe('3','103',null,0,null,null);
		
		exit(0);}
	}
	/**
	 *   zhangli 
	**/
	//-----------------------------------------------------添加终端组dsy
	function addGroup($parentNode="0001",$groupName=''){
		$strNode=$this->getMaxNode($parentNode);
		$newNode=$parentNode.$strNode;
		$groupName=$groupName;
		//查上一级文件夹
		$noclient = substr($newNode,0,(strlen($newNode)-4));
		$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$noclient."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$noclient=$row->name;
						
					}
				}
		
		//检测是否同一级有相同的名字
		$isExists=$this->checkNameExists($parentNode,$groupName);
		if($isExists){
			//echo '-1'; //同级下名称已经在
			return '-1';
			return false;
		}	
		$Rid =  $this->userEntity->userRoleID;

		
	/*	$sql_ = "select Km,Dept from user where UserID =".$id;
		$rs=$this->db->query($sql_)->result_array();
		$_km = null;		
		$_km = $rs[0]['Km'];
		$_dept = $rs[0]['Dept'];
	*/	
		if($Rid == 1){
			$data=array(
					'Name'=>$groupName,
					'TreeNodeCode'=>$newNode,
					'IsClient'=>0,
					'Extend1'=>'sa',
					);				
		}else{
			$data=array(
						'Name'=>$groupName,
						'TreeNodeCode'=>$newNode,
						'IsClient'=>0,
						'Extend1'=>$Km,
						);					
		}		
		$this->db->insert('client_tree', $data);
		//sga 取得新加组的id
		//$GroupID=$this->db->insert_id();
		//$this->adminAddNewGroupGivePower($GroupID);		

		
		if($this->db->affected_rows())
		{
				$this->UserLog->addGroup('1','106',$groupName,'1',$noclient);

			
		}else
		{
				$this->UserLog->addGroup('1','106',null,'0',null);
				//exit(0);
		}
		return $this->db->affected_rows();

	}
	function checkNameExists($parentNode='',$newName=''){
		$len=(strlen($parentNode)+4);
		$sql="select Name from client_tree where TreeNodeCode like '$parentNode%' and length(TreeNodeCode)=$len";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$treeName=$row->Name;
				if($treeName==$newName){
					return true;
				}
			}
		}else{
			return false;
		}

	}
	/**
	 * zhangli	 
	*/
		//-----------------------------------------------------删除组dsy
	
	//查终端组的名字
	function foecho($groupNodeCode){
	
		        // $sql=" select name, TreeNodeCode from client_tree where   TreeNodeCode like '".$groupID."____'";
				// $query =$this->db->query($sql);
					// $i=0;
					// $noclient=array();
				// if ($query->num_rows() > 0)
				// {	
					// foreach($query->result() as $row){
						// $noclient[$i]=$row->name;
						// $groupID[$i]=$row->TreeNodeCode;
						// $i++;
						// if($groupID[$i]!=""){
						// $this->foecho($groupID[$i]);
						// }
						// return $noclient[$i];
					// }
					
				// }
	
	$groupArray=array();
	$this->db->select("name, TreeNodeCode, isClient");
	$this->db->like("TreeNodeCode",$groupNodeCode);
	$rs=$this->db->get("client_tree")->result_array();
//	echo Information("ZhongDuanZu",print_r($rs,true));
	if(count($rs)>0)
	{
		foreach($rs as $v)
		{
			if($v["isClient"]=="0")
			{
				$groupArray[]=array("GroupNode"=>$v["TreeNodeCode"],"name"=>$v["name"]);
			}
		}

	//	echo Information("ZhongDuanZu2",print_r($groupArray,true));
		foreach($rs as $v)
		{
			if($v["isClient"]=="1")
			{
				$treNode=substr($v["TreeNodeCode"],0,strlen($v["TreeNodeCode"])-4);
				for($i=0,$n=count($groupArray); $i<$n; $i++)
				{
			//		echo($groupArray[$i]["GroupNode"].'<--->'.$treNode."<br>");
					if($groupArray[$i]["GroupNode"]==$treNode)
					{
						// if(!is_array($groupArray[$i]["clinets"]))
						// {$groupArray[$i]["clinets"]=array();}
						$groupArray[$i]["clinets"][]=$v;
					}
				}
			}
		}
	}
	//echo Information("ZhongDuanZu","<pre>".print_r($groupArray,true)."</pre>");
	return $groupArray;
	
	}
	
	
	
	function deleteGroup($groupID=''){	
		@session_start ();
		$Rid =  $this->userEntity->userRoleID;
			
			
				//查上一级文件夹
			$noclient = substr($groupID,0,(strlen($groupID)-4));
			$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$noclient."'";
					$query =$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						foreach($query->result() as $row){
							$root=$row->name;
							
						}
					}
					
					$noclient=$this->foecho($groupID);
			
			
				// //查终端的名字
				// $sql="select name from client_tree where isClient = 1 and TreeNodeCode like  '".$groupID."%'";
				 // $query=$this->db->query($sql);
					// $i=0;
					// $client=array();
				 // if($query->num_rows>0){
					 // foreach($query->result() as $row){
						 // $client[$i]=$row->name;
						// $i++;
					 // }
				 // }
		$sql_ = "select Extend1 from client_tree where TreeNodeCode =".$groupID;
		$query = $this->db->query($sql_);
		$row = $query->row(0);
		
		$sql = '';
		if($Rid == '' ){
			echo 0;
			exit();
		}
		if($Rid == 1){
			$sql="select TreeNodeSerialID from client_tree where TreeNodeCode like '".$groupID."%'";			
		}
		if($Rid == 2){
			if($row->Extend1 == 'sa'){
				echo 0;
				exit();
			}		
			$sql="select TreeNodeSerialID from client_tree where Extend1 != 'sa' and TreeNodeCode like '".$groupID."%'";		
		}
			
		$query =$this->db->query($sql);
		if ($query->num_rows() > 0)
		{			
			foreach ($query->result() as $row)
			{
				$sql="DELETE FROM `client_tree` WHERE `TreeNodeSerialID` =".$row->TreeNodeSerialID;
				$this->db->query($sql);
			}
		}
		echo $this->db->affected_rows();
						if($this->db->affected_rows())
				{
						$this->UserLog->deleteGroup('3','106',$noclient,'1',$root);
					
					
				}else
				{
						$this->UserLog->deleteGroup('3','106',null,'0',null);
				
				exit(0);}
	} 
	
	//dsy---移动组
	function moveGroup($groupID='',$newGroupID="0001"){
	
		$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$newGroupID."'";
					$query =$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						foreach($query->result() as $row){
							$group=$row->name;
							
						}
					}
		
			//查上一级文件夹
			$noclient = substr($groupID,0,(strlen($groupID)-4));
			$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$noclient."'";
					$query =$this->db->query($sql);
					if ($query->num_rows() > 0)
					{
						foreach($query->result() as $row){
							$root=$row->name;
							
						}
					}
			$noclient=$this->foecho($groupID);
	
	
		if($groupID=="0001" || $groupID==""){
			echo "This Client cann't move";
			return;
		}
		$sql="select TreeNodeCode from client_tree ";
		$sql.= "where TreeNodeCode like '$groupID%'";
		//echo $sql;
			//获得最新组的最大id号
		$strNode=$this->getMaxNode($newGroupID);

		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			$lenGroupID=strlen($groupID);
			foreach($query->result() as $row){

				if($row->TreeNodeCode==$groupID) //如果是他本身移动的组节点，就是最大节点
				{
					$groupID=$strNode;
				}else{
					$lenNode=strlen($row->TreeNodeCode);
					$lenM=$lenNode-$lenGroupID;
					$groupID=$strNode.substr($row->TreeNodeCode, -$lenM, $lenM);
				}

				$data=array('TreeNodeCode'=>$newGroupID.$groupID
					  );
				$this->db->where('TreeNodeCode',$row->TreeNodeCode);
				$this->db->update('client_tree', $data);
			}
			
				
				 if($this->db->affected_rows())
			 {
				
				 $this->UserLog->moveGroup('2','106',$noclient,'1',$root,$group);
				
				 echo 1;
			 }else { 
				 $this->UserLog->moveGroup('2','106',null,'0',null,null);
				 echo 0;
				 exit(0);
			 }
		}
	
		
	}
	
	function getMaxNode($NodeCode){
		$len=(strlen($NodeCode)+4);
		$maxArr=array();
		$sqlStr="select TreeNodeCode from client_tree ";
		$sqlStr.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$NodeCode%'";
		$queryMax=$this->db->query($sqlStr);
		if($queryMax->num_rows>0){
			$i=0;
			foreach($queryMax->result() as $row){
				$maxArr[$i]=substr($row->TreeNodeCode, -4, 4)*1;
				$i++;
			}
			$max=max($maxArr)+1;
		}else{
			$max=1;
		}

		$strNode=str_repeat('0',4-strlen($max)).$max;
		return $strNode;
	}
	//dsy-------------------------移动终端
	function moveClients($clientStr,$parentNode="0001",$clientName,$groupName){
		$clientArr=explode(",",$clientStr);
		$strNode=$this->getMaxNode($parentNode);
		$arrNum=count($clientArr);
		for($i=0;$i<$arrNum;$i++){
			$data=array(
					'TreeNodeCode'=>$parentNode.$strNode
					);
		//判断是否为已经移动过的终端  Extend4为空的时候便是未移动过的
		$sql="select Extend4 from client_tree where TreeNodeCode='".$clientArr[$i]."'";
		$rs=$this->db->query($sql)->result_array();
		if($rs[0]["Extend4"]=="")
		{
			$old_code=$clientArr[$i];//echo $clientArr[$i];exit;
		}
		else
		{
			$old_code=$rs[0]["Extend4"]; //echo $clientArr[$i];exit;
		}
		$sql = "update `client_tree` set TreeNodeCode = '".$parentNode.$strNode."' where TreeNodeCode = '".$clientStr."'";
		
		//$sql="INSERT INTO `client_tree` (`TreeNodeSerialID`, `Name`, `TreeNodeCode`, `IsClient`, `Extend1`, `Extend2`, `Extend3`, `Extend4`) VALUES
//(null, '".$clientName."', '".$parentNode.$strNode."', 1, '', 0, 0, '".$old_code."')";
			$this->db->query($sql);
			$lastNode=substr($strNode,-4,4)*1+1;
			$strNode=str_repeat('0',4-strlen($lastNode)).$lastNode;
		}
		if($this->db->affected_rows())
		{
			
			$this->UserLog->moveClients1('1','106',$clientName,$groupName,'1');
			//$this->db->query($sqldelete);
			echo "1";
		}else { 
			$this->UserLog->moveClients1('1','106',null,null,'0');
			echo 0; 
			exit(0);
		}
	}
	//dsy-----------------------------------------------------------------从某一个组中注销终端
	function logoutClient($clientId)
	{
		//查上一级文件夹
		$noclient = substr($clientId,0,(strlen($clientId)-4));
		$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$noclient."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$noclient=$row->name;
						
					}
				}
		//查终端姓名
		$sql=" select name from client_tree where  TreeNodeCode = '".$clientId."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$temp=$row->name;
						
					}
				}
		
		$Rid = $this->userEntity->userRoleID;
		
		$tables = array('client_tree');
		$this->db->where('TreeNodeCode', $clientId);
		$this->db->delete($tables);
		if($this->db->affected_rows())
		{
				$this->UserLog->logoutClient('9','106',$temp,1,$noclient);
			echo "1";
			
		}else
		{
				$this->UserLog->logoutClient('9','106',null,0,null);
		echo 0;
		exit(0);}
	}

	//----------------------------------------------删除终端dsy
	function deleteClient($clientID){
		//查上一级文件夹
		$noclient = substr($clientID,0,(strlen($clientID)-4));
		$sql=" select name from client_tree where IsClient= 0  and TreeNodeCode = '".$noclient."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$noclient=$row->name;
						
					}
				}
		
		//查终端的名字
		$sql=" select name from client_tree where  TreeNodeCode = '".$clientID."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$temp=$row->name;
						
					}
				}
			
		$treeID=$this->getTreeID($clientID);
		
		$tables = array('client_info', 'client_tree', 'user_client');
		$this->db->where('TreeNodeSerialID', $treeID);
		$this->db->delete($tables);
				if($this->db->affected_rows())
		{
				$this->UserLog->deleteClient('3','106',null,0,null);
		
			
		}else
		{
				$this->UserLog->deleteClient('3','106',$temp,1,$noclient);
	
		exit(0);}
	}
	function getTreeID($nodeCode){
		$this->db->select('TreeNodeSerialID');
		$this->db->where('TreeNodeCode',$nodeCode);
		$query = $this->db->get('client_tree');
		$treeID=0;
		foreach($query->result() as $row){
			$treeID=$row->TreeNodeSerialID;
		}
		return $treeID;
	}
	
		//sga   clientID     name
		//sga   clientID     name
	function updateClientName(){
		$logOkInfo=array();
		$logInfo=array();
		$sql = "select TreeNodeCode,Name from client_tree where TreeNodeSerialID = '".$_POST["clientID"]."'";
		$tnc = $this->db->query($sql)->result_array();
		$sql2 = "update client_tree set name = '".$_POST["Name"]."' where `TreeNodeSerialID` = '".$_POST["clientID"]."';";
		$this->db->query($sql2);
		if($this->db->affected_rows()>0)
		{
			$logInfo["trueClientName"]=array("Name"=>$tnc[0]["Name"],"TreeNodeCode"=>$tnc[0]["TreeNodeCode"],"postName"=>$_POST["Name"]);
		}
		else
		{
			$logOkInfo["trueClientName"]=array("Name"=>$tnc[0]["Name"],"TreeNodeCode"=>$tnc[0]["TreeNodeCode"],"postName"=>$_POST["Name"]);
		}
		
		//print_r($tnc);
		
		$sql3 = "select TreeNodeSerialID,Name,TreeNodeCode from client_tree where Extend4 = '".$tnc[0]["TreeNodeCode"]."'";
		$ids = $this->db->query($sql3);
		//print_r($ids);
		
		if($ids->num_rows() > 0){
			$i=0;
			foreach($ids->result() as $k=>$row){
				$id = $row->TreeNodeSerialID;
				$sql4 = "update client_tree set name = '".$_POST["Name"]."' where TreeNodeSerialID = '".$id."'";
				$this->db->query($sql4);
				if($this->db->affected_rows()>0)
				{
					$logInfo["copyClientName"][$i]=array("Name"=>$row->Name,"TreeNodeCode"=>$row->TreeNodeCode,"postName"=>$_POST["Name"]);
				}
				
				$i++;
			}
		}
		return count($logInfo)>0?okInfo($logInfo):falseInfo(2002,$logOkInfo); 
		
	}
	//----------------------------------------------修改终端组名称dsy
	function updateName($clientNode,$newName){
		//查终端姓名
		$sql=" select name from client_tree where  TreeNodeCode = '".$clientNode."'";
				$query =$this->db->query($sql);
				if ($query->num_rows() > 0)
				{
					foreach($query->result() as $row){
						$temp=$row->name;
						
					}
				}
	
		$newName=$newName;
		$parentNode=substr($clientNode,0,strlen($clientNode)-4);
		$isExists=$this->checkNameExists($parentNode,$newName);
		if($isExists){
			echo '-1'; //同级下名称已经在
			return false;
		}
		$data=array('Name'=>$newName); 
		$this->db->where('TreeNodeCode',$clientNode);
		$this->db->update('client_tree', $data);
		echo $this->db->affected_rows();
			if($this->db->affected_rows())
		{
				$this->UserLog->updateName('2','106',$temp,$newName,1);
		
			
		}else
		{
				$this->UserLog->updateName('2','106',null,null,0);
		exit(0);}
		
		
	}
	function isInTime($weekPlaylistID,$profileID,$startTime=0,$endTime=0){
		$sqlStr="select ProfileID from week_playlist_describe where WeekPlayListID = ".$weekPlaylistID." and StartTime <= '".$startTime."' and EndTime >= '".$endTime."'";
		//echo $sqlStr;
		$query=$this->db->query($sqlStr);
		$isInTime="0";
		if($query->num_rows>0){
			foreach($query->result() as $row){
				if($profileID==$row->ProfileID){
					$isInTime="1";
					break;
				}
			}
		}
		echo $isInTime;
	}
	//终端日志表
	function getClientLogs($clientID='',$isNumber=0,$offset='',$limit=''){
		//$sqlStr='select InfoType,Text,Time from client_log where TreeNodeSerialID='.$clientID;
		//$sqlStr.=" order by Time desc ";
		//if($limit) $sqlStr="limit $limit,$off";

		$this->db->select('InfoType,Text,Time');
		$this->db->where('TreeNodeSerialID',$clientID);
		$this->db->order_by("Time", "desc");
		if($limit)	$query = $this->db->get('client_log',$limit,$offset);
		else	$query = $this->db->get('client_log');
		//$query=$this->db->query($sqlStr);
		$clientLogsInfo=array();
		$typeText='';
		$num=$query->num_rows;
		if($isNumber==1) return $num;
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				switch($row->InfoType){
					case 0:
					   $typeText='未知';
					   break;
					case 1:
					   $typeText='下载成功';
					   break;
					case 2:
					   $typeText='下载失败';
					   break;
					case 3:
					   $typeText='磁盘信息';
					   break;
					case 4:
					   $typeText='打开URL成功';
					   break;
					case 5:
					   $typeText='打开URL失败';
					   break;
					case 6:
					   $typeText='播放计划空';
					   break;
					case 7:
					   $typeText='XAWTV失败';
					   break;
					case 8:
					   $typeText='开始下载';
					   break;
					case 9:
					   $typeText='播放失败';
					   break;
					case 10:
					   $typeText='播放状态';
					   break;
					case 11:
					   $typeText='开始播放';
					   break;
					case 12:
					   $typeText='播放结束';
					   break;
					case 13:
					   $typeText='下载消息';
					   break;
					case 14:
					   $typeText='更新消息';
					   break;
					case 15:
					   $typeText='终端上线';
					   break;
					case 16:
					   $typeText='终端下线';
					   break;
					case 17:
					   $typeText='停止播放';
					   break;
					case 18:
					   $typeText='播放文件';
					   break;
					default:
						$typeText='未知';
						break;
				}
				$clientLogsInfo[$i]['typeID']=$row->InfoType;
				
				$clientLogsInfo[$i]['infoType']=$typeText;
				$clientLogsInfo[$i]['text']=$this->ClientLog->getProfileNameForLog($row->InfoType,$row->Text,$typeText);
				$clientLogsInfo[$i]['time']=$row->Time;
				$i++;
			}
		}
		return $clientLogsInfo;
	}
	
//-------------------------------------------------------
	//-- 终端日志
	//-- update by mobo 二〇一一年一月十七日 11:41:43
	//-- params $where array 查询条件
	//-- $where["clientID"] string 终端ID
	//-- $where["InfoType"] int 信息编号
	//-- $where["startTime"] string 开始时间
	//-- $where["endTime"] string 结束时间
	//-- $where["info"] string 日志内容
	//-- $where["name"] string 终端名称
	//-- $where["excel"] string 是否导出excel
	//-- return Array
	//-------------------------------------------------------
	function getClientLog($where)
	{
		if($where["startTime"]=='')
		{
			$startTime=date("YYYY-mm-dd",time());
			$endTime=date("YYYY-mm-dd",time());
		}
		else{$startTime=$where["startTime"];
		$endTime=$where["endTime"];}
		$sqlStr='select InfoType,Text,Time,TreeNodeSerialID from client_log where';
		$sqlStr.=" unix_timestamp(`Time`) BETWEEN unix_timestamp('".$startTime." 00:00:00') and unix_timestamp('".$endTime." 23:59:59')";
		$where["clientID"]!=''?$sqlStr.=" AND TreeNodeSerialID in ('".$where["clientID"]."')":'';
		if($where["clientName"]!=""||$where["maintainer"]!="")
		{
			       $sqlStr.=" AND TreeNodeSerialID in (".$this->getClientInfoIdByClientTree($where["clientName"],$where["maintainer"]).")";     
	    }
		$where["InfoType"]!=''?$sqlStr.=" AND InfoType =".$where["InfoType"]:'';
		$where["info"]!=''?$sqlStr.=" AND Text like '%".$where["clientID"]."%'":'';
		$sqlStr.=" order by `Time` desc ";//var_dump($sqlStr);
		$query=$this->db->query($sqlStr)->result_array();
		$num=count($query);
		
		//判断是否要分页..  导出excel 不需要分页
		if($where["excel"]=='0')
		{
			$sqlStr.=" LIMIT ".$where["pageStart"]." , ".$where["pageSize"];
		}
		
		//echo Information("SQL",$sqlStr);
		$query=$this->db->query($sqlStr);
		$clientLogsInfo=array();
		if($query->num_rows>0){

			$i=0;
			foreach($query->result() as $row){
				$ty=clientLog($row->InfoType);
				$ty==''?$ty=clientLog(0):'';
				$clientLogsInfo[$i]['TreeNodeSerialID']=$row->TreeNodeSerialID;
				$clientLogsInfo[$i]['typeID']=$row->InfoType;
				$clientLogsInfo[$i]['infoType']=$ty;
				$clientLogsInfo[$i]['text']=$this->ClientLog->getProfileNameForLog($row->InfoType,$row->Text,$ty);
				$clientLogsInfo[$i]['time']=$row->Time;
				$i++;
			}
		}
		
		return array("count"=>$num,"data"=>$clientLogsInfo);
	}
	
	//-------------------------------------------------------
	//-- 终端日志
	//-- update by mobo 二〇一一年一月十七日 11:41:43
	//-- params $where array 查询条件
	//-- $where["clientID"] string 终端ID
	//-- $where["InfoType"] int 信息编号
	//-- $where["startTime"] string 开始时间
	//-- $where["endTime"] string 结束时间
	//-- $where["info"] string 日志内容
	//-- $where["name"] string 终端名称
	//-- $where["excel"] string 是否导出excel
	//-- return Array
	//-------------------------------------------------------
	function getClientLogjiejie($where)
	{
		if($where["startTime"]=='')
		{
			$startTime=date("YYYY-mm-dd",time());
			$endTime=date("YYYY-mm-dd",time());
		}
		else{$startTime=$where["startTime"];
		$endTime=$where["endTime"];}
		$sqlStr='select InfoType,Text,Time,TreeNodeSerialID from client_log where';
		$sqlStr.=" unix_timestamp(`Time`) BETWEEN unix_timestamp('".$startTime." 00:00:00') and unix_timestamp('".$endTime." 23:59:59')";
		$where["clientID"]!=''?$sqlStr.=" AND TreeNodeSerialID in ('".$where["clientID"]."')":'';
		if($where["clientName"]!=""||$where["maintainer"]!="")
		{
			       $sqlStr.=" AND TreeNodeSerialID in (".$this->getClientInfoIdByClientTree($where["clientName"],$where["maintainer"]).")";     
	    }
		$where["InfoType"]!=''?$sqlStr.=" AND InfoType =".$where["InfoType"]:'';
		$where["info"]!=''?$sqlStr.=" AND Text like '%".$where["clientID"]."%'":'';
		$sqlStr.=" order by `Time` desc ";//var_dump($sqlStr);
		$query=$this->db->query($sqlStr)->result_array();
		$num=count($query);
		
		//判断是否要分页..  导出excel 不需要分页
		if($where["excel"]=='0')
		{
			$sqlStr.=" LIMIT ".$where["pageStart"]." , ".$where["pageSize"];
		}
		
		//echo Information("SQL",$sqlStr);
		$query=$this->db->query($sqlStr);
		$clientLogsInfo=array();
 
		if($query->num_rows>0){

			$i=0;
			foreach($query->result() as $row){
				$ty=clientLog($row->InfoType);
				$ty==''?$ty=clientLog(0):'';
				$clientLogsInfo[$i]['TreeNodeSerialID']=$row->TreeNodeSerialID;
				$clientLogsInfo[$i]['typeID']=$row->InfoType;
				$clientLogsInfo[$i]['infoType']=$ty;
				$clientLogsInfo[$i]['text']=$this->formartInfo($row->Text);
				$clientLogsInfo[$i]['time']=$row->Time;
				$i++;
			}
		}
		return array("count"=>$num,"data"=>$clientLogsInfo);
	}
	
//-------------------------------------------------------
	//-- 用终端名称查终端真实ID
	//-- params $name 终端的名称
	//-- BY 莫波
	//-- 二〇一一年一月十七日 18:30:36
	//-------------------------------------------------------
	function getClientInfoIdByClientTree($name,$null="")
	{
		$sql="SELECT (SELECT TreeNodeSerialID from client_tree as cc WHERE  cc.TreeNodeCode=c.Extend4) AS TreeNodeSerialID,Name FROM client_tree as c WHERE c.Name like '%".$name."%' AND c.IsClient=1 AND c.Extend4 <>''  GROUP BY c.Extend4";
		$query=$this->db->query($sql)->result_array();
		$sql1="SELECT `TreeNodeSerialID`,`Name` from `client_tree` WHERE `Name` like '%".$name."%' AND `IsClient`=1 AND `Extend4` =''";
		$query_a=$this->db->query($sql1)->result_array();
		foreach($query as $k=>$v)
		{
			$i=0;
			foreach($query_a as $a=>$b)
			{
				if($b["TreeNodeSerialID"]==$v["TreeNodeSerialID"])
				{
					unset($query_a[$i]);
				}
				$i++;
			}
		}
		$result =array_merge($query,$query_a);
		//echo Information("用终端名称查终端ID",$result);
		return $result;
	
	}
	
	function deleteLogs($clientID=0){
		if($clientID!=0){
			$this->db->delete('client_log',array('TreeNodeSerialID'=>$clientID));
		}
	}
	function deleteLogsByTime($clientID=0,$startTime='',$endTime=''){
		if($clientID!=0){
			$sTime=$startTime." 00:00:00";
			$eTime=$endTime." 23:59:59";
			//delete from client_logs where TreeNodeSerialID=10 and Time between2009-12-18 00:00:00and2009-12-18 23:59:59
			$sqlStr='delete from client_log where TreeNodeSerialID='.$clientID.' and Time between \''.$sTime.'\'and \''.$eTime."'";
			$this->db->query($sqlStr);
			if($this->db->affected_rows()<=0){
				errStr("删除失败");
			}
		}
	}
	function getClientVersion($clientID){
		$this->db->select('VMSVersion');
		$this->db->where('TreeNodeSerialID',$clientID);
		$query = $this->db->get('client_info');
		$vession="null";
		foreach($query->result() as $row){
			$vession=$row->VMSVersion;
			break;
		}
		return $vession;
	}
	function setDownLoadTime($clientIDs='',$dTime=''){
		$clientIDArr=array($clientIDs);
		foreach($clientIDArr as $clientID){
			$data=array('DownLoadTime'=>$dTime);
			$this->db->where('TreeNodeSerialID',$clientID);
			$this->db->update('client_info', $data);
		}
	}
	function getGroup($clientNode){
		$parentClientNode=substr($clientNode,0,strlen($clientNode)-4);
		$this->db->select("Name");
		$this->db->where('TreeNodeCode',$parentClientNode);
		$query=$this->db->get("client_tree");
		$groupName="root";
		foreach($query->result() as $row){
			$groupName=$row->Name;
			break;
		}
		return $groupName;
	}
	
	//sga 获取终端升级文件
	//终端升级文件查询
	// 2010年11月27日18:36:14 by 莫波 ---> 修改于 孙国安
	function getUpgradeFile()
	{
		$this->db->select("URL,FileName");
		$this->db->where("fileType",7);
		$this->db->order_by("PlayFileID","desc");
		$this->db->limit(10);
		$query=$this->db->get("play_file_property");
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return array("0"=>array("URL"=>"","Name"=>"没有升级包!"));
		}
	}
	
	//sga 管理员添加分组给自己添加的分组授权
	function adminAddNewGroupGivePower($GroupID){
		
		$UserID=$this->userEntity->userID;
		$sql="insert into user_client (UserID, TreeNodeSerialID, PriorityID)values('".$UserID."', '".$GroupID."', '1')";
		$this->db->query($sql);
	}
		//--------------------------
	//获取单个终端的信息
	function getOneOfClientInfo($clientId)
	{
		$sql="select a.TreeNodeSerialID,b.TreeNodeCode,MacAddress,Name,TreeNodeCode from client_info as a left join client_tree as b on a.TreeNodeSerialID=b.TreeNodeSerialID";
		$sql.=' where a.TreeNodeSerialID in('.$clientId.')';
		//$this->db->select("MacAddress");
		//$this->db->where_in("TreeNodeSerialID",$clientId);
		//$rs=$this->db->get("client_info")->result_array();
		$rs=$this->db->query($sql)->result_array();
		if(count($rs)>0)
		{
			return okInfo(array($rs));
		}
		else
		{
			return falseInfo(2001);
		}
	}             
	
	//终端下载速度限制
	function setClientDownLoad($clientArr,$speed)
	{
		//"UPDATE `ams`.`client_info` SET `Extend3` = '100KB' WHERE `client_info`.`TreeNodeSerialID` =2;";
		foreach($clientArr as $v)
		{
			$this->db->where('TreeNodeSerialID', $v);
			$this->db->update('client_info',array("Extend3"=>$speed)); 
		}

	}
	
	//添加终端播放计划
	function AddClientPlayList($playlistid,$clientid)
	{
	        $arr = explode(",",$clientid);
		    $arrNum=count($arr);
		    for($i=0;$i<$arrNum;$i++){
			        $sql="select * from client_playlist where clientID =".$arr[$i]." and  weekPlayListID =$playlistid";
					$rs=$this->db->query($sql)->result_array();
					if(count($rs)==0)
					{
					  $sql="insert into client_playlist (clientID, weekPlayListID)values(".$arr[$i].",$playlistid)";
					  $this->db->query($sql);
					}
			}
	        
	}
	
	//删除终端播放计划
	// function deleteclientplaylist($clientid)
	// {
	      // $arr = explode(",",$clientid);
		  // $arrNum=count($arr);
		  // for($i=0;$i<$arrNum;$i++){
		       // $sql="delete from client_playlist where clientID=".$arr[$i];
			   // $this->db->query($sql);
		  // }
	// }
	
	function getClientID($clientcode)
	{
	     $sql="SELECT TreeNodeSerialID  FROM client_tree where TreeNodeCode = ".$clientcode;
		 $rs = $this->db->query($sql)->result_array();
		 $id = "";
		 if(count($rs)==1)
		 {
			   $id = $rs[0]['TreeNodeSerialID'];
	   	 }
		 return $id;
	}
	
	//根据终端id 获取信息
	function getClientByID($id)
	{
	     $sql="SELECT ClientAddress,UserID,DisPlaySize,Remark  FROM client_info where TreeNodeSerialID = ".$id;
		 $rs = $this->db->query($sql)->result_array();
		 $retstr = "";
		 
		 if(count($rs)==1)
		 {
			   $retstr = $rs[0]['ClientAddress']."##";
			   $retstr .= $rs[0]['UserID']."##";
			   $retstr .= $rs[0]['DisPlaySize']."##";
			   $retstr .= $rs[0]['Remark'];
	   	 }
		 return $retstr;
	}
	
	//获取终端维护人员信息
	function getClientMaintainerList(){	
	    $sqlstr = "select * from client_maintainer ";
		$query = $this->db->query($sqlstr);
		$MaintainerInfo =  array();
		echo "<select id='MaintainerName'>";
		echo "<option value='0'>请选择</option>";
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//$MaintainerInfo .=$row->ID."##";
				//$MaintainerInfo .=$row->Name."|";
				echo "<option value='".$row->ID."'>".$row->Name."</option>";
				
			}//循环结束

		}
		echo "</select>";
		//return $MaintainerInfo;
	}
	
	//修改终端维护人员信息
	function updateClientMaintainer($id='',$address='',$name='',$displaysize='',$remark='')
	{
	      if($id!='')
		  {
		      $this->db->where('TreeNodeSerialID', $id);
			  $this->db->update('client_info',array("ClientAddress"=>$address,
			  "UserID"=>$name,
			  "DisPlaySize"=>$displaysize,
			  "Remark"=>$remark
			   )); 
			   echo '1';
		  }
	        
	} 
	
	//设置终端ftp服务器
	function setclientftp($clientid,$ftp)
	{
	    $arr = explode(",",$clientid);
		$arrNum=count($arr);
		for($i=0;$i<$arrNum;$i++){
			   $this->db->where('TreeNodeSerialID', $arr[$i]);
			   $this->db->update('client_info',array("Extend1"=>$ftp)); 
		}
		echo '发送成功!';
	}
	
	//统计上线下线时间
	function getClientLogTimeInfo($clientID,$startTime,$endTime)
	{    
		$int_start_time=strtotime($startTime." 00:00:00");
		$int_end_time=strtotime($endTime." 23:59:59");
		$sql = "select Time,InfoType from client_log where TreeNodeSerialID = $clientID and InfoType in(15,16) and unix_timestamp(`Time`) BETWEEN unix_timestamp('".$startTime." 00:00:00') and unix_timestamp('".$endTime." 23:59:59')";
		$rs=$this->db->query($sql)->result_array();
		//echo Information("111",$rs);
		if(count($rs)<=0)
		{
			$sql = "select Time,InfoType,max(Number) from client_log where TreeNodeSerialID = $clientID and unix_timestamp(`Time`)< unix_timestamp('".$startTime." 00:00:00') group by Number";
			$rs=$this->db->query($sql)->result_array();
			$rss=array();
			if(count($rs)<=0)
			{
			}
			else
			{
				
				
				//上线
				if($rs[0]["InfoType"]=="15")
				{
					$rss[0]=array("Time"=>$startTime." 00:00:00","InfoType"=>"15");
					$rss[1]=array("Time"=>$endTime." 23:59:59","InfoType"=>"16");
				}
				//下线
				if($rs[0]["InfoType"]=="16")
				{$rss[0]=array("Time"=>$startTime." 23:59:59","InfoType"=>"16");}
			}
			$rs=$rss;
		}
		
		$int_last_type=1; // 1 表示上线
		$int_utime=0; //上线时间点
		$int_ntime=0; //下线时间点
		$time_length=0;
		//echo Information("222",$rs);
		
		for($i=0,$n=count($rs); $i<$n; $i++)
		{
			$nm=$rs[$i]["InfoType"];
			// 当是第一个的时候判断是  上线  还是下线 来取得 开始的上线时间
			if($i==0)
			{
				//下线
				if($nm=="16")
				{
					$int_ntime=strtotime($rs[$i]["Time"]);
					if($int_ntime>=$int_start_time)
					{
						$time_length+=$int_ntime-$int_start_time;
					}
					
					$int_last_type=0;
				}
				//上线
				if($nm=="15")
				{
					$int_utime=strtotime($rs[$i]["Time"]);
					$str_time=$rs[$i]["Time"];
				}
			}
			if($i>0)
			{
				if($nm=="16"&&$int_last_type==1)
				{
					$int_ntime=strtotime($rs[$i]["Time"]);
				    $time_length+=$int_ntime-$int_utime;
					$int_last_type=0;
				}
				if($nm=="15"&&$int_last_type==0)
				{
					$int_utime=strtotime($rs[$i]["Time"]);
					$int_last_type=1;
				}
			}
			if($i==$n-1)
			{
				if($nm=="15"&&$int_last_type==1)
				{
					$time_length+=$int_end_time-strtotime($rs[$i]["Time"]);
					
				}
			}
		}
		$time_zone_length=$int_end_time-$int_start_time;
		if($int_end_time - $int_start_time < $time_length)$time_length=0;
		$data=array();
		$data['up'] = $this->shifenmiao($time_length);
		//echo $time_length."  ----  ".$data['up'];
		//exit();
		$ntime=$time_zone_length-$time_length; //下线时间
		if($time_zone_length-$time_length<0)$ntime=0;
		$data['down'] = $this->shifenmiao($ntime);
		$data['up_bfb'] = round(($time_length*100/$time_zone_length),2).'%';
		return $data;
	}

	//获取终端播放文件信息 及终端在线情况信息
	function getclientplayinfo($where)
	{
	    $clientLogsInfo = array();
	    if($where["startTime"]=='')
		{
			$startTime=date("YYYY-mm-dd",time());
			$endTime=date("YYYY-mm-dd",time());
		}
		else{
		    $startTime = $where["startTime"];
			$endTime = $where["endTime"];
			
		}
        $arr = $this->getClientInfoIdByClientTree($where["name"]);
		//print_r($arr);
//		exit();
		if($arr)
		{
			 $i=0;
			 foreach($arr as $v)
			 {
				if($v["TreeNodeSerialID"]!='')
				{
				   if($where['clientid']!='')
				   {
				      if($where['clientid'] == $v["TreeNodeSerialID"])
					  {
							$datas = $this->getClientLogTimeInfo($v["TreeNodeSerialID"],$startTime,$endTime);
							$clientLogsInfo[$i]['clientid'] = $v["TreeNodeSerialID"];
							$clientLogsInfo[$i]['clientname'] = $v["Name"];
							$clientLogsInfo[$i]['uptime']=$datas['up'];
							$clientLogsInfo[$i]['downtime']=$datas['down'];
							$clientLogsInfo[$i]['up_bfb'] = $datas['up_bfb'];
							$i++;
					  }
				   }
				   else
				   {
		                    $datas = $this->getClientLogTimeInfo($v["TreeNodeSerialID"],$startTime,$endTime);
							$clientLogsInfo[$i]['clientid'] = $v["TreeNodeSerialID"];
							$clientLogsInfo[$i]['clientname'] = $v["Name"];
							$clientLogsInfo[$i]['uptime']=$datas['up'];
							$clientLogsInfo[$i]['downtime']=$datas['down'];
							$clientLogsInfo[$i]['up_bfb'] = $datas['up_bfb'];
							$i++;    				   
				   }

				}
			  }
			 }
//			 print_r($clientLogsInfo);die();
		    if(count($clientLogsInfo)==0)
		    {
		    	return '';
		    }
			return $clientLogsInfo;
      }
	  
	  //获取终端播放文件信息
	  function getclientplayfileinfo($clientid,$startTime,$endTime)
	  {
	        $sql1 = "SELECT pd.ProfileID,pd.StartTime,pd.EndTime FROM `client_info` as c left join week_playlist_describe as pd on c.WeekPlaylistID = pd.WeekPlaylistID where c.TreeNodeSerialID = ".$clientid." and unix_timestamp(pd.StartTime) >= unix_timestamp('".$startTime." 00:00:00') and unix_timestamp(pd.EndTime) <= unix_timestamp('".$endTime." 23:59:59')";
            $rs1 = $this->db->query($sql1)->result_array();
			
			$PlayFileInfo = '';
			if(count($rs1)>0)
			{
                 foreach($rs1 as $v)			
				 {
				     $sql2 = "select pf.FileName,pf.URL,pf.Extend3 from  profile_describe as pd left join playlist_describe as pld on pd.PlaylistID = pld.PlaylistID  left join play_file_property as pf on pld.PlayFileID = pf.PlayFileID where  ProfileID = '".$v['ProfileID']."'";
					 $rs2 = $this->db->query($sql2)->result_array();
					 $PlayFileInfo .= '<samp style="color:red">'.$v['StartTime'].'~~~'.$v['EndTime'].':  </samp><br/>';
					 foreach($rs2 as $d)
					 {
						
					     if(strrpos($d['URL'],'/')!=false)
						 {
						    //echo strlen($d['URL']);
							//echo '<BR>';
					        $PlayFileInfo .= substr($d['URL'],strrpos($d['URL'],'/')+1,strlen($d['URL'])-strrpos($d['URL'],'/')) .' ';
							$sql3 = "select Time from  client_log where Text like '%".$d['FileName']."%' order by Time ASC limit 1";
							$rs3 = $this->db->query($sql3)->result_array();
							$sql4 = "select Time from  client_log where Text like '%".$d['FileName']."%' order by Time DESC limit 1";
							$rs4 = $this->db->query($sql4)->result_array();
							if($rs3 && $rs4){
								if(strtotime($rs3[0]['Time'])-strtotime($v['StartTime'])>0)$stime=$rs3[0]['Time'];
								else $stime=$v['StartTime'];
								if(strtotime($rs4[0]['Time'])-strtotime($v['EndTime'])<0)$etime=$rs4[0]['Time'];
								else $etime=$v['EndTime'];
								$strtotime=strtotime($etime)-strtotime($stime);
							}
							
							$strtotime = $strtotime?$strtotime:0;
							if(!$d['Extend3']){
								$num=1;
							}else{
								$num = intval($strtotime/$d['Extend3'])?intval($strtotime/$d['Extend3']):1;
							}
							
							$PlayFileInfo .= ' 播放次数：'.$num.' --  <BR>';
						 }
					 }
				 }
			}
			echo $PlayFileInfo;
			//exit();

	  }
	  
	  
	//将多少秒转成 时分秒 格式
	function shifenmiao($miao)
	{
	    $up_xiaoshi = intval($miao/3600);
		$up_fen = intval(($miao-$up_xiaoshi*3600)/60);
		$up_miao = intval($miao - ($up_xiaoshi*3600+$up_fen*60));
		return $up_xiaoshi.'小时 '.$up_fen.'分 '.$up_miao.'秒';
	}
	
	
}
?>
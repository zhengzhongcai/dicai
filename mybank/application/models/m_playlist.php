<?php
class M_playList extends CI_Model
{
	
	function __construct(){
		parent::__construct();
		 /* $this->load->helper(array('form', 'url'));
		  $this->load->model('m_userEntity','userEntity');
		  $this->load->model('m_userlog','UserLog');
		 $this->load->library('Spreadsheet_Excel_Reader');*/
	}
	 
	 function getFileName($fname)
	 {
		$this->db->select("FileViewURL,FileType");
		$this->db->like("FileName",$fname,"after");
		$this->db->from("play_file_property");
		$row=$this->db->get()->row(0);
		return array($row->FileType,$row->FileViewURL);
		
	 }
	 
	 //dsy 查文件的类型(视屏)
	 function getNodeName($filetype){
		if($filetype==''){
			return ;
		}
		$sql="SELECT nodeName from userFileType where stem =1 and id = ".$filetype."  limit  1";
		$query=$this->db->query($sql);
		//echo $query->num_row;
		//if($query->num_row>0){
			foreach($query->result() as $row){
				
				return $row->nodeName;
		//	}
		
		}
	//	echo $nodeName;
	//	return $nadeName;
	 }
	 //导出播放列表
	 //2011年6月8日17:49:43 by 莫波
	 function getPlistInfoToExport($info)
	 {
		 $sql = "SELECT * FROM `week_playlist` WHERE  `WeekPlaylistID` in(".$info['id'].")";
		 $rs=$this->db->query($sql)->result_array();
		 for($p=0,$pn=count($rs); $p<$pn; $p++)
		 {
			 $sql = "SELECT * FROM `week_playlist_describe` WHERE `WeekPlaylistID` in(".$rs[$p]['WeekPlaylistID'].")";
			 $rsPlDe=$this->db->query($sql)->result_array();
			 $rs[$p]["week_playlist_describe"]= $rsPlDe;
			 
			 
			 $sql = "SELECT * FROM `week_playlist_describe` WHERE `WeekPlaylistID` =".$rs[$p]['WeekPlaylistID']." GROUP BY ProfileID";
			 $rsPlDes=$this->db->query($sql)->result_array();
			 $rs[$p]["weekPlaylistDescribe"]= $rsPlDes;
			 foreach($rsPlDes as $l=>$t)
		 	 {
				 $sql = "SELECT * FROM `profile` WHERE ProfileID = ".$t['ProfileID'];
				 $rsPro=$this->db->query($sql)->result_array();
				 $rs[$p]["weekPlaylistDescribe"][$l]["profile"]=$rsPro;
				 foreach($rsPro as $pro=>$f)
				 {
					 //查询profile 的tar包
					 $sql="SELECT URL,CheckSum FROM `play_file_property` WHERE PlayFileID=".$f['TemplateFileID'];
					 $rsPf=$this->db->query($sql)->result_array();
					 $rs[$p]["weekPlaylistDescribe"][$l]["profile"]["allTarInfo"]=$rsPf;
					 
					 $sql = "SELECT * FROM `profile_describe` WHERE ProfileID = ".$f['ProfileID'];
					 echo $sql."<br>";
					 $rsProDes=$this->db->query($sql)->result_array();
				 	 $rs[$p]["weekPlaylistDescribe"][$l]["profile"][$pro]["profile_describe"]=$rsProDes;
					 foreach($rsProDes as $pd=>$pds)
				 	 {
						 $sql="SELECT *  FROM `playlist_describe` WHERE PlaylistID=".$pds["PlaylistID"];
						 echo $sql."<br>";
						 $rsPlsDs=$this->db->query($sql)->result_array();
				 	     $rs[$p]["weekPlaylistDescribe"][$l]["profile"][$pro]["profile_describe"][$pd]["playlist_describe"]=$rsPlsDs;
						 foreach($rsPlsDs as $pls=>$plds)
				 	 	 {
							 $sql="SELECT * FROM `play_file_property` WHERE PlayFileID=".$plds['PlayFileID'];
							 echo $sql."<br>";
							 $rsPf=$this->db->query($sql)->result_array();
							 $rs[$p]["weekPlaylistDescribe"][$l]["profile"][$pro]["profile_describe"][$pd]["playlist_describe"][$pls]["profilePlaylist_describe"]=$rsPf;
							 
							 if($plds['ControlPara9']!="0")
							 {
								  $sql="SELECT * FROM `play_file_property` WHERE PlayFileID=".$plds['ControlPara9'];
								  echo $sql."<br>";
								 $rsPf=$this->db->query($sql)->result_array();
								 $rs[$p]["weekPlaylistDescribe"][$l]["profile"][$pro]["profile_describe"][$pd]["playlist_describe"][$pls]["profilePlaylist_describe"]["tar"][]=array("fileId"=>$plds['PlayFileID'],"tarFile"=>$rsPf);
							 }
						 }
					 }
				 }
			 }
		 }
		 return $rs;
		 
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
	//通过播放计划的ID 查询 单条播放计划数据信息
	function getPlistInfo($id)
	{	
		//dsy通过播放计划id得到列表名称
		$sql_group="select Extend2,WeekPlaylistName from `week_playlist` where WeekPlaylistID=".$id;
			$query=$this->db->query($sql_group);
			if($query->num_rows>0){
				foreach($query->result() as $row){
					$dapt=$row->WeekPlaylistName;
					$dapt1=$row->Extend2;
				}
			}
			
		//@session_start();
		//$dapt1=$_SESSION['Dept'];
		
		//echo $dapt."<br>";
		if($dapt1."_Excel"==$dapt){
		$logfile = "uploads\\".iconv('gbk','utf-8',$dapt).".xls";
		}else{
		$logfile = "uploads\\".iconv('utf-8','gb2312',$dapt).".xls";
		}
		//$logfile = "uploads\\".$dapt.".xls";
		//echo $logfile;
		//var_dump(file_exists($logfile));
		// 通过 Excel 获取数据
		if(file_exists($logfile))
		{
			$sql_group="select (select CONCAT(WeekPlaylistName,'__bx__',WeekPlaylistType,'__bx__',Extend1,'__bx__',Extend2) as plistInfo  from `week_playlist` where WeekPlaylistID=".$id.") as plistInfo,ProfileID from week_playlist_describe where WeekPlaylistID=".$id." group by ProfileID";
			$profile_group=$this->db->query($sql_group)->result_array();
			if(count($profile_group)>0)
			{
				//查询user 名称
				$wk=explode("__bx__",$profile_group[0]["plistInfo"]);
				$u_sql="select UserName from user where UserID=".$wk[count($wk)-1];
				$user_info=$this->db->query($u_sql);
				if($user_info->num_rows()>0)
				{
					$name=$user_info->row_array();
					$WeekPlayList="['".$wk[0]."','".$wk[1]."','".$wk[2]."','".$wk[3]."','".$name["UserName"]."',[";	
				}
				else
				{
					$WeekPlayList="['".$wk[0]."','".$wk[1]."','".$wk[2]."','".$wk[3]."','<b style=\"color:red;\">此用户已被删除!</b>',[";
					
				}
				
				//开始解析Excel
				$data = new Spreadsheet_Excel_Reader();
				$data->setOutputEncoding('UTF-8');
				$data->read($logfile);
				error_reporting(E_ALL ^ E_NOTICE);
				$f=$data->sheets[0]['cells'][2][4]; //分辨率
				$z=1;
				for ($i = 2, $pf = $data->sheets[0]['numRows']; $i<=$pf; $i++) 
				{
					if($data->sheets[0]['cells'][$i][1]!=""&&$data->sheets[0]['cells'][$i][3]!="")
					{
						$f_n=explode(".",$data->sheets[0]['cells'][$i][1]);
						$f_info=$this->getFileName($f_n[0]);
						$f_playFileType=$this->getNodeName($f_info[0]);
					//	if($i!=$pf)
					//	{
					
							$WeekPlayList.="['".($i-1)."','".$data->sheets[0]['cells'][$i][1]."','".$f_info[0]."','".date("Y-m-d",$this->getTimeSecond($data->sheets[0]['cells'][$i][2])*1-24*60*60)
."','".date("Y-m-d",$this->getTimeSecond($data->sheets[0]['cells'][$i][3])*1-24*60*60)
."','".$f."','".$f_info[1]."','".$f_playFileType."'],";
				//		}
				//		else 
				//		{
							// $WeekPlayList.="['".$i."','".$data->sheets[0]['cells'][$i][1]."','".$f_info[0]."','".date("Y-m-d H:i:s",$this->getTimeSecond($data->sheets[0]['cells'][$i][2])*1-24*60*60)."','".date("Y-m-d H:i:s",$this->getTimeSecond($data->sheets[0]['cells'][$i][3])*1-24*60*60)."','".$f."','".$f_info[1]."','".$f_playFileType."']";
				//		}
					}
				}
				$WeekPlayList=substr($WeekPlayList,0,-1);	
				$WeekPlayList.="]]"; 
				echo "Excel__bx__".$WeekPlayList;
			}
			else{ echo "Error__bx__不存在此播放计划!";}
		}
		else
		{
		
			$sql_group="select (select CONCAT(WeekPlaylistName,'__bx__',WeekPlaylistType,'__bx__',Extend1,'__bx__',Extend2) as plistInfo  from `week_playlist` where WeekPlaylistID=".$id.") as plistInfo,ProfileID from week_playlist_describe where WeekPlaylistID=".$id." group by ProfileID";
			$profile_group=$this->db->query($sql_group)->result_array();
			if(count($profile_group)>0)
			{
				//查询user 名称
				$wk=explode("__bx__",$profile_group[0]["plistInfo"]);
				$u_sql="select UserName from user where UserID=".$wk[count($wk)-1];
				$user_info=$this->db->query($u_sql);
				if($user_info->num_rows()>0)
				{
					$name=$user_info->row_array();
					$WeekPlayList="['".$wk[0]."','".$wk[1]."','".$wk[2]."','".$wk[3]."','".$name["UserName"]."',[";	
				}
				else
				{
					$WeekPlayList="['".$profile_group[0]["plistInfo"]."','<b style=\"color:red;\">此用户已被删除!</b>',[";
				}
				
				for($p=0,$pf=count($profile_group); $p<$pf; $p++)
				{
					//播放计划详情
					$sql_p="select (select UserName from user where UserID in (select Extend4 from profile where ProfileID=".$profile_group[$p]["ProfileID"].")) as UserName,(select Extend5 from profile where ProfileID=".$profile_group[$p]["ProfileID"].") as Dept, (select ProfileName from profile where ProfileID=".$profile_group[$p]["ProfileID"].") as profileName,ProfileID,ProfilePrior,StartTime ,EndTime,Extend2 from week_playlist_describe where WeekPlaylistID=".$id." and ProfileID=".$profile_group[$p]["ProfileID"]." order by Extend2 asc";
					$wPDlist=$this->db->query($sql_p)->result_array();
					$f=$wPDlist[0];
					$e=$wPDlist[count($wPDlist)-1];
	
					$wPDlist=$this->db->query($sql_p)->result_array();
					if($p!=$pf-1)
					{
						$WeekPlayList.="['".$f["ProfileID"]."','".iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$f['profileName'])))."','".$f["StartTime"]."','".$e["EndTime"]."','".iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$f['profileName'])))."','".$f['UserName']."','".$f['Dept']."','".$id."'],";
					}
					else 
					{
						$WeekPlayList.="['".$f["ProfileID"]."','".iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$f['profileName'])))."','".$f["StartTime"]."','".$e["EndTime"]."','".iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$f['profileName'])))."','".$f['UserName']."','".$f['Dept']."','".$id."']";
					}
	
				}
				$WeekPlayList.="]]";
				echo "DataBase__bx__".$WeekPlayList;
			}
		}
	}
	
	
		function getProfileInfo($listName,$stime,$etime,$listId,$pr_id,$profileName)
		{	
			//判断是否是ff浏览器或者是ie
			if(stripos($_SERVER["HTTP_USER_AGENT"],"firefox")){
			
			 $profileName1=$profileName;
			
			}else{
			$profileName1=	iconv('gb2312','utf-8',$profileName);
				
			}
		
		
		//echo $profileName."过放电".$stime."地方化".$etime."热都是".$listId;
	
		$id=$listId;
	$sql_group="select (select CONCAT(WeekPlaylistName,'__bx__',WeekPlaylistType,'__bx__',Extend1,'__bx__',Extend2) as plistInfo  from `week_playlist` where WeekPlaylistID=".$id.") as plistInfo,ProfileID from week_playlist_describe where WeekPlaylistID=".$id." group by ProfileID";
			$profile_group=$this->db->query($sql_group)->result_array();
			if(count($profile_group)>0)
			{
				//查询user 名称
				$wk=explode("__bx__",$profile_group[0]["plistInfo"]);
				$u_sql="select UserName from user where UserID=".$wk[count($wk)-1];
				$user_info=$this->db->query($u_sql);
				
				if($user_info->num_rows()>0)
				{
					$name=$user_info->row_array();
					$WeekPlayList="['".$profileName1."','".$wk[1]."','".$wk[2]."','".$wk[3]."','".$name["UserName"]."',[";	
				}
				else
				{
					$WeekPlayList="['".$profile_group[0]["plistInfo"]."','<b style=\"color:red;\">此用户已被删除!</b>',[";
					
				}
		
	//	echo $pr_id."343".$stime."jdfgk".$etime;
		$stt=explode(",",$stime);
		$ett=explode(",",$etime);
		$sql=" select FileType,FileSize,FileViewURL,FileName,(SELECT `nodeName` from userFileType where stem =1 and `id`=FileType) as playFileType from play_file_property where FileName<>'' and CheckSum in (SELECT CheckSum
FROM play_file_property
WHERE PlayFileID
IN (SELECT PlayFileID FROM playlist_describe WHERE PlaylistID IN ( SELECT PlaylistID FROM profile_describe WHERE ProfileID =".$pr_id.")))";
		$profile_group=$this->db->query($sql)->result_array();
		//$query=$this->db->query($sql);
		//$i=0;
		//$file=array();
		// foreach($query->result() as $row){
		
			// $file[$i]['FileName']=$row->FileName;
			// $file[$i]['playFileType']=$row->playFileType;
			// $file[$i]['FileType']=$row->FileType;
			// $file[$i]['FileViewURL']=$row->FileViewURL;
			// $file[$i]['FileSize']=(int)(($row->FileSize)/1024);
			// $file[$i]['stime']=$stt[0];
			// $file[$i]['etime']=$ett[0];
			// $i++;
				for($p=0,$pf=count($profile_group); $p<$pf; $p++)
				{
			
					if($p!=$pf-1)
					{
						$WeekPlayList.="['".($p+1)."','".$profile_group[$p]["FileName"]."','".$stt[0]."','".$ett[0]."','".(int)(($profile_group[$p]["FileSize"])/1024)."KB','".$profile_group[$p]["playFileType"]."','".$profile_group[$p]["FileType"]."','".$profile_group[$p]["FileViewURL"]."'],";
					}
					else 
					{
						$WeekPlayList.="['".($p+1)."','".$profile_group[$p]["FileName"]."','".$stt[0]."','".$ett[0]."','".(int)(($profile_group[$p]["FileSize"])/1024)."KB','".$profile_group[$p]["playFileType"]."','".$profile_group[$p]["FileType"]."','".$profile_group[$p]["FileViewURL"]."']";
					}
			
				}
			
		//}
		
				$WeekPlayList.="]]";
				echo "File__bx__".$WeekPlayList;
		}
	}
	
	
		// //转化成秒
		// function getTimeSecond($timeString)
	// {
		// //echo $timeString;
		// date_default_timezone_set("Asia/Hong_Kong");
		// $timeString=explode(" ",$timeString);
		// $dt=explode("/",$timeString[0]);
		// $tm=explode(":",$timeString[1]);
		// $h=$tm[0]; 
		// $f=$tm[1];
		// $s=$tm[2];
		// $m=$dt[1]; //月
		// $d=$dt[0]; //天
		// $y=$dt[2]; //年
		// return mktime($h,$f,$s,$m,$d,$y);
	// }
	
	function getTimeSecond($timeString)
	{
		date_default_timezone_set("Asia/Hong_Kong");
		$timeString=preg_replace("/\+/"," ",$timeString);
		$timeString=explode(" ",$timeString);
		$dt=explode("/",$timeString[0]);
		$m=$dt[1]; //月
		$d=$dt[0]; //天
		$y=$dt[2]; //年
		return mktime(0,0,0,$m,$d,$y);
	}
	
	function deleteDescribeInfo($DescribeId)
	{
	    $sql = "delete from week_playlist_describe where Extend2 =".$DescribeId;
		$this->db->query($sql);
	}
    
    //---------------------------------------------------------------
    //  功能说明:
    //            从数据库中查询Profile的播放时间段,
    //            并格式化为一条数据 "开始时间" 到 "结束时间"
    //  参    数:
    //            playListId: int 播放列表的ID
    //  时    间: 2011-9-26 22:49:42
    //  作    者: BOBO
    //---------------------------------------------------------------
    function getPlayListProfileTimeEare($playListId)
    {
        $sql="SELECT  `ProfileID` ,  `StartTime` ,  `EndTime` 
            FROM  `week_playlist_describe` 
            WHERE  `WeekPlaylistID` =".$playListId."
            ORDER BY  `Extend2` ASC ";
            $rs=$this->db->query($sql)->result_array();
            $profileGroup=array();
            if(count($rs))
            {
                for($i=0,$n=count($rs); $i<$n; $i++)
                {
                    //
                    if($i==0)
                    {
                       $profileGroup[$rs[$i]["ProfileID"]."_"]["start"]=$rs[$i]["StartTime"];
                    }
                    else if($i<$n-1&&$rs[$i-1]["ProfileID"]!=$rs[$i]["ProfileID"])
                    {
                       $profileGroup[$rs[$i-1]["ProfileID"]."_"]["end"]=$rs[$i-1]["EndTime"];
                       $profileGroup[$rs[$i]["ProfileID"]."_"]["start"]=$rs[$i]["StartTime"];
                    }
                    
                   if($i==$n-1)
                    {
                        $profileGroup[$rs[$i]["ProfileID"]."_"]["end"]=$rs[$i]["EndTime"];
                    }
                }
            } 
            return $profileGroup;
    }
	function getPlayListPage($pageInfo)
	{
		@session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
		$username = $this->userEntity->userName;
		$var_dept=$this->areaAccess();
		$sql="";
		
		if(!is_bool($var_dept))
		{
			$sql.=" Extend2 in (".$var_dept.")";
		}
		$sql.=" order by WeekPlaylistID desc";
		
		$sql_count="select count(*) as resultCount from week_playlist where ".$sql;
		$query=$this->db->query($sql_count)->result_array();
		
		$data=array();
		$data["totalRows"]=$query[0]["resultCount"];
		
		$sql_content="select *  from week_playlist where ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		$query=$this->db->query($sql_content);
		$i=0;
		$playList=array();
		foreach($query->result() as $row){
			$playList[$i]['playListID']=$row->WeekPlaylistID;
			$playList[$i]['playListName']=$row->WeekPlaylistName;
			$playList[$i]['playListType']=$row->WeekPlaylistType;
			// if($username=='sa')
			// {
				// $playList[$i]['startTime']=$this->getPlayListStartTime($row->WeekPlaylistID);
				// $playList[$i]['lastTime']=$this->getPlayListLastTime($row->WeekPlaylistID);
			// }
			// else
			// {
				$playList[$i]['startTime']=$this->getTemPlayListStartTime($row->WeekPlaylistID);
				$playList[$i]['lastTime']=$this->getTemPlayListLastTime($row->WeekPlaylistID);
			//}
			$i++;
		}
		$data["result"]=$playList;
		return $data;
	}
	function getSendPlayList()
	{
		@session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
		$username = $this->userEntity->userName;
		$var_dept=$this->areaAccess();
		$sql="";
		
		if(!is_bool($var_dept))
		{
			$sql.="where Extend2 in (".$var_dept.")";
		}
		$sql.=" order by WeekPlaylistID desc";
		
		$sql_count="select * from week_playlist ".$sql;
		$query=$this->db->query($sql_count);
		
		$data=array();
		//$data["totalRows"]=$query[0]["resultCount"];
		
		// $sql_content="select *  from week_playlist where ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		// $query=$this->db->query($sql_content);
		$i=0;
		$playList=array();
		foreach($query->result() as $row){
			$playList[$i]['playListID']=$row->WeekPlaylistID;
			$playList[$i]['playListName']=$row->WeekPlaylistName;
			$playList[$i]['playListType']=$row->WeekPlaylistType;
			
			$playList[$i]['startTime']=$this->getTemPlayListStartTime($row->WeekPlaylistID);
			$playList[$i]['lastTime']=$this->getTemPlayListLastTime($row->WeekPlaylistID);
			
			$i++;
		}
		$data["result"]=$playList;
		return $playList;
	}
	
	//获取播放日期，判断是否过期用
	function getPlayListLastTime($weekPlaylistID=''){
		$sql="select EndTime from week_playlist_describe where WeekPlaylistID=$weekPlaylistID order by EndTime desc limit 1";
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
//			foreach($query->result() as $row){
//				$lastTime=$row->EndTime;
//				return $lastTime;
//			}//forech end

			$data=$query->result();
			return  $data[0]->EndTime;
		}else{
			return;
		}
	}

	function getPlayListStartTime($weekPlaylistID="")
	{
		$sql="select StartTime from week_playlist_describe where WeekPlaylistID=$weekPlaylistID order by StartTime asc limit 1";
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
//			foreach($query->result() as $row){
//				$lastTime=$row->StartTime;
//				return $lastTime;
//			}//forech end
			$data=$query->result();
			return  $data[0]->StartTime;
		}else{
			return;
		}
	}
	//获取播放日期，判断是否过期用
	function getTemPlayListLastTime($weekPlaylistID=''){
		$sql="select EndTime from week_playlist_describe where WeekPlaylistID=$weekPlaylistID order by Extend2 desc limit 1";
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
	function getTemPlayListStartTime($weekPlaylistID=''){
		$sql="select StartTime from week_playlist_describe where WeekPlaylistID=$weekPlaylistID order by Extend2 asc limit 1";
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$lastTime=$row->StartTime;
				return $lastTime;
			}//forech end
		}else{
			return;
		}

	}
	
	function areaAccess()
	{
		
		if(!isset($_SESSION["access_area"]))
		{
			@session_start();
		}
		if($_SESSION["access_area"]!="all")
		{
			$arr_accessArea=explode(",",$_SESSION["access_area"]);
			$str_accessArea="";
			for($i=0,$n=count($arr_accessArea); $i<$n; $i++)
			{
				
				$str_accessArea.="'".$arr_accessArea[$i]."'";
				if($i!=$n-1)
				{
					$str_accessArea.=" , ";
				}
			}
			return $str_accessArea;
		}
		return true;
	}
	
	//添加播放列表
	function addTemPlaylist($playlistName='',$playDataStr='',$playlistType='X86'){		
		$playlistName=iconv("GB2312","UTF-8",urldecode($playlistName));
		$playlistData=array(
					'WeekPlayListName'=>$playlistName,
					'WeekPlayListType'=>$playlistType,
					"Extend2"=>$this->userEntity->userGroupID,
					"Extend1"=>$this->userEntity->userID
							);
		$this->db->insert('week_playlist', $playlistData);
		$playlistID=$this->db->insert_id();

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
			echo '播放列表保存失败';
		}else{
			$this->UserLog->savePlaylist('1','102',iconv("utf-8","gb2312",$playlistName),$playDataStr,1);
			echo '0';
		}

	}
	function getPlayDataInfo($start,$end,$weekPlaylistID='',$profileID='',$prior='1'){
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
	}
	//编辑播放列表
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
	
	//将临时表数据复制到正式表里
	// function upTemPlayList($playlistid='')
	// {
		// //更新 week_playlist Extend3＝1 表示已经通过审批并且下发
		// $sql = "update week_playlist set Extend3='1' where weekPlayListId = '".$playlistid."'";
		// $this->db->query($sql);
// 		
		// $sqlstr = "select * from week_playlist_describe where weekPlayListId = '".$playlistid."'";
		// $sqlstr1 = "select * from week_playlist where weekPlayListId = '".$playlistid."'";
		// $sqlstr2 = "select * from week_playlist where weekPlayListId = '".$playlistid."'";
		// $rs=$this->db->query($sqlstr)->result_array();
		// $rs1=$this->db->query($sqlstr1)->result_array();	
		// $rs2=$this->db->query($sqlstr2)->result_array();	
// 		
		// if(count($rs2)<=0)
		// {
			// $insertsql1 = "insert into week_playList (WeekPlaylistName,WeekPlaylistType,IsChecked,Extend1,Extend2,Extend3) 
						   // values('".$rs1[0]["WeekPlaylistName"]."','".$rs1[0]["WeekPlaylistType"]."','".$rs1[0]["IsChecked"]."','".$rs1[0]["Extend1"]."','".$rs1[0]["Extend2"]."',NULL)";
		    // $this->db->query("$insertsql1");
		// }
		// if(count($rs)>0)
		// {
			// $str_now_time=date("Y-m-d H:i:s");
			// $sql="select * from week_playlist_describe where unix_timestamp(EndTime)>=unix_timestamp('".$str_now_time."') and weekPlayListId = '".$playlistid."'";
			// $rs_des=$this->db->query($sql)->result_array();
			// // 将临时表数据复制到正式表里
				// foreach($rs_des as $v)
			    // {
				   // $insertsql = "insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime)
				   // values(".$v["WeekPlaylistID"].",".$v["ProfileID"].",".$v["ProfilePrior"].",'".$v["StartTime"]."','".$v["EndTime"]."')";
				   // $this->db->query("$insertsql");
			    // }
		// }
// 		
	// }
	
	//多个playlist同时删除
	function deleteMulpPlaylist($playlistIDStr=''){
		$playlistIDArr=explode (',',$playlistIDStr);
		foreach($playlistIDArr as $playlistID){
			$this->deletePlaylist($playlistID);
			//$this->deletetemPlaylist($playlistID);
		}
	}
	
	function deletePlaylist($playlistID=''){
		//查播放计划名
		$sql=" select WeekPlaylistName from week_playlist where WeekPlaylistID = ".$playlistID;
		
		$query=$this->db->query($sql);
		
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$temp=$row->WeekPlaylistName;
						
			}
		}
		//查profile的name
		$sqlPro="select ProfileName from profile where ProfileID in (select ProfileID from week_playlist_describe where WeekPlaylistID = '".$playlistID."')";
		$query=$this->db->query($sqlPro);
		
		$pro=array();
		$i=0;
		if($query->num_rows>0){
			foreach($query->result() as $row){
				$pro[$i]=$row->ProfileName;
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
		
		}

	}
	// function deleteTemPlaylist($playlistID=''){
		// //查播放计划名
		// $sql=" select WeekPlaylistName from week_playlist where WeekPlaylistID = ".$playlistID;
// 		
		// $query=$this->db->query($sql);
// 		
		// if($query->num_rows>0){
			// foreach($query->result() as $row){
				// $temp=$row->WeekPlaylistName;
			// }
		// }
		// //查profile的name
		// $sqlPro="select ProfileName from profile where ProfileID in (select ProfileID from week_playlist_describe where WeekPlaylistID = '".$playlistID."')";
		// $query=$this->db->query($sqlPro);
// 		
		// $pro=array();
		// $i=0;
		// if($query->num_rows>0){
			// foreach($query->result() as $row){
				// $pro[$i]=$row->ProfileName;
				// $i++;		
			// }
		// }
		// //查profile数量
		// $sqlPro="select count(ProfileID) as sum from week_playlist_describe where WeekPlaylistID = '".$playlistID."'";
		// $query=$this->db->query($sqlPro);
// 		
		// if($query->num_rows>0){
			// foreach($query->result() as $row){
				// $prosum=$row->sum;
// 				
			// }
		// }
// 	
// 		
		// if($playlistID!=''){
			// $this->db->delete('week_playlist_describe',array('WeekPlaylistID'=>$playlistID));
			// $this->db->delete('week_playlist',array('WeekPlaylistID'=>$playlistID));
			// //$this->M_common->saveEventLog('playlist','delete',$playlistID);
		// }
// 		
		// if($this->db->affected_rows())
		// {
				// $this->UserLog->deletePlaylist('3','103',$temp,$pro,1,$prosum);	
// 			
		// }else
		// {
				// $this->UserLog->deletePlaylist('3','103',null,null,0,null);		
		// }
	// }

	function  mdeleteOnlyPlayList($playListIdOnly){
			$this->db->delete('week_playlist_describe',array('Extend2'=>$playListIdOnly));
	}
}
?>
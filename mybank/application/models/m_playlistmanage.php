<?php
class M_playlistmanage extends CI_Model
{
	function __construct(){
		parent::__construct();	
		  $this->load->helper(array('form', 'url'));
		  $this->load->model('m_userEntity','userEntity');
		  $this->load->model('m_userlog','UserLog');
	}
	function getPlayList($pageInfo){
		$username = $this->userEntity->userName;
		$sql="";
		$sql.=" where Extend2 in (".$this->userEntity->userGroupID.")"; 
		$sql.=" or Extend1 = ".$this->userEntity->userID." order by WeekPlaylistID desc";
		$sql_count="select count(*) as resultCount from week_playlist ".$sql;
		$query=$this->db->query($sql_count)->result_array();
		$data=array();
		$data["totalRows"]=$query[0]["resultCount"];
		$sql_content="select *  from week_playlist ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		$query=$this->db->query($sql_content);
		$i=0;
		$playList=array();
		foreach($query->result() as $row){
			$playList[$i]['playListID']=$row->WeekPlaylistID;
			$playList[$i]['playListName']=$row->WeekPlaylistName;
			$playList[$i]['playListType']=$row->WeekPlaylistType;
			$playList[$i]['playListModel']=$row->PlaylistModel;
			$playList[$i]['startDate']=$row->StartDate;
			$playList[$i]['endDate']=$row->EndDate;
			$playList[$i]['startTime']=$this->getPlayListStartTime($row->WeekPlaylistID);
			$playList[$i]['lastTime']=$this->getPlayListLastTime($row->WeekPlaylistID);
			$i++;
		}
		$data["result"]=$playList;
		return $data;
	}
	/*************************************************************
    |
    |	函数名:storagePlaylist
    |	功能:存储播放列表
    |	返回值: 返回数组 array("state"=>$state)
    |	参数: $playlistName 节目名称,$playDataArr 节目数组,$playlistType 播放列表类型,$playGolbalTime 总的播放时长
    |	创建时间:2012年7月26日 16:45:01 by 莫波
    |   
    **************************************************************/
	function storagePlaylist($playlistName='',$playDataArr,$playlistType='X86',$playGolbalTime,$playlistModel){		
		$playlistName=$playlistName;
		
		$playlistData=array(
					'WeekPlayListName'=>$playlistName,
					'WeekPlayListType'=>$playlistType,
					'PlaylistModel'=>$playlistModel,
			'StartDate'=>$playGolbalTime['startDate'],
			'EndDate'=>$playGolbalTime['endDate'],
					"Extend2"=>$this->userEntity->userGroupID,
					"Extend1"=>$this->userEntity->userID//,
					//"Extend3"=>$playGolbalTime
							);
		$this->db->insert('week_playlist', $playlistData);
		$playlistID=$this->db->insert_id();

		//添加到week_playlsit_describe
		$playDataInfo=array();
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startDateTime=$playDataArr[$i]['startDate'].",".$playDataArr[$i]['startTime'];
			$endDateTime=$playDataArr[$i]['endDate'].",".$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['programId'];
			$prior=$playDataArr[$i]['prior'];
			$extend=$playDataArr[$i]['extend'];
			$playDataInfo[]="($playlistID,$profileID,$prior,'$startDateTime','$endDateTime','$extend')";
			
		}
		$playDataStr= implode($playDataInfo,",");
		$sqlStr="insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime,Extend5) values".$playDataStr;

		$query=$this->db->query($sqlStr);

		$rows=$this->db->affected_rows();
		$state=true;
		$info="";
		if($rows<=0){
		
			$this->UserLog->savePlaylist('1','102',null,null,0);
			$state=false;
		}else{
			$this->UserLog->savePlaylist('1','102',iconv("utf-8","gb2312",$playlistName),$playDataStr,1);
		}
		return array("state"=>$state);
	}
	/*************************************************************
    |
    |	函数名:loadPlayListInfoById
    |	功能:获取播放列表的详细信息
    |	返回值: 返回数组 
    |	参数: $id 播放列表的ID
    |	创建时间:2012年7月26日 18:12:21 by 莫波
    |   
    **************************************************************/
	function loadPlayListInfoById($id)
	{
		$sql_group="select `WeekPlaylistID`, `WeekPlaylistName`, `WeekPlaylistType`, `PlaylistModel`,`StartDate`,`EndDate`,`IsChecked`, `Extend1`, `Extend2`, `Extend3` from `week_playlist` where WeekPlaylistID=".$id;
		$playListGobalInfo=$this->db->query($sql_group)->result_array();
		if(count($playListGobalInfo)<=0)
		{
			return false;
		}
		
		$sql_group="SELECT wtd.`WeekPlaylistID` ,p.ProfileName , wtd.`ProfileID` , wtd.`Layer` , wtd.`ProfilePrior` , wtd.`StartTime` , wtd.`EndTime` , wtd.`Extend1` , wtd.`Extend2` , wtd.`Extend3` , wtd.`Extend4` , wtd.`Extend5` 
					FROM `week_playlist_describe` AS wtd
					LEFT JOIN profile AS p ON wtd.ProfileID = p.ProfileID
					WHERE wtd.`WeekPlaylistID` = ".$id;
		$playListInfo=$this->db->query($sql_group)->result_array();
		$playListDesInfo=array(
							"dayCycle"=>array(),
							"weekCycle"=>array(
								"Mon"=>array(),
								"Tues"=>array(),
								"Wed"=>array(),
								"Thur"=>array(),
								"Fri"=>array(),
								"Sat"=>array(),
								"Sun"=>array(),"startDate"=>"","endDate"=>"","startTime"=>"","endTime"=>"")
							);
		$weekStartDateTime="";
		//兼容 CS-SCT
		$cs_sct_extend5="";
		if(count($playListInfo)){
			if($playListInfo[0]["Extend5"]=="")
			{
				$start_date=explode(",",$this->getTemPlayListStartTime($id));
				$start_date=$start_date[0];
				$end_date=explode(",",$this->getTemPlayListLastTime($id));
				$end_date=$end_date[0];
				$cs_sct_extend5="\"startDate\":\"".$start_date."\"||\"endDate\":\"".$end_date."\"||\"playType\":\"dayCycle\"||\"key\":\"0_div\"";
			}
		}
		
		for($i=0,$n=count($playListInfo); $i<$n; $i++)
		{
			$sdatetime=explode(",",$playListInfo[$i]["StartTime"]);
			$edatetime=explode(",",$playListInfo[$i]["EndTime"]);
			if($cs_sct_extend5!="")
			{
				$extend=json_decode("{".preg_replace("/\|\|/i",",",$cs_sct_extend5)."}",true);
			}
			else {
				$extend=json_decode("{".preg_replace("/\|\|/i",",",$playListInfo[$i]["Extend5"])."}",true);
			}
			
			
			
			$cacheData=array();
			$cacheData[0]["programId"]=$playListInfo[$i]["ProfileID"];
			$cacheData[0]["programName"]=$playListInfo[$i]["ProfileName"];
			$cacheData[0]["startDate"]=$sdatetime[0];
			$cacheData[0]["endDate"]=$edatetime[0];
			$cacheData[0]["startTime"]=$sdatetime[1];
			$cacheData[0]["endTime"]=$edatetime[1];
			$cacheData[0]["prior"]=$playListInfo[$i]["ProfilePrior"];
			$cacheData[0]["extend"]=$extend;
			$cacheData[0]["key"]=$playListInfo[$i]["Extend2"]."_div";
			
			if(count($extend)<=0){
				
			}
			if($extend["playType"]=="dayCycle")
			{
				$playListDesInfo["dayCycle"][]=$cacheData[0];
			}
			if($extend["playType"]=="weekCycle")
			{
				//记录 周为单位 的开始日期时间
				if($weekStartDateTime=="")
				{
					$playListDesInfo["weekCycle"]["startDate"]=$cacheData[0]["startDate"];
					$playListDesInfo["weekCycle"]["startTime"]=$cacheData[0]["startTime"];
					$weekStartDateTime="true";
				}
				//记录 周为单位 的结束日期时间
				$playListDesInfo["weekCycle"]["endDate"]=$cacheData[0]["endDate"];
				$playListDesInfo["weekCycle"]["endTime"]=$cacheData[0]["endTime"];
				
				switch($extend["weekDay"])
				{
					case "1":$playListDesInfo["weekCycle"]["Mon"][]=$cacheData[0]; break;
					case "2":$playListDesInfo["weekCycle"]["Tues"][]=$cacheData[0]; break;
					case "3":$playListDesInfo["weekCycle"]["Wed"][]=$cacheData[0]; break;
					case "4":$playListDesInfo["weekCycle"]["Thur"][]=$cacheData[0]; break;
					case "5":$playListDesInfo["weekCycle"]["Fri"][]=$cacheData[0]; break;
					case "6":$playListDesInfo["weekCycle"]["Sat"][]=$cacheData[0]; break;
					case "0":$playListDesInfo["weekCycle"]["Sun"][]=$cacheData[0]; break;
				}
			}
		}
		
		$dayCyclye=$playListDesInfo["dayCycle"];
		$fenge="";
		$newDayCycle=array();
		for($i =0,$n=count($dayCyclye); $i<$n; $i++)
		{
			if($fenge=="")
			{
				$fenge=$dayCyclye[$i]["extend"]["key"];
				$newDayCycle[]=$dayCyclye[$i];
				continue;
			}
			
			
			
			if($fenge!=$dayCyclye[$i]["extend"]["key"])
			{
				$fenge=$dayCyclye[$i]["extend"]["key"];
				$newDayCycle[]=$dayCyclye[$i];
			}
		}
		$playListDesInfo["dayCycle"]=$newDayCycle;
		
		
		$weekCycle=$playListDesInfo["weekCycle"];
		$fenge="";
		$newWeekCycle=array("Mon"=>array(),
							"Tues"=>array(),
							"Wed"=>array(),
							"Thur"=>array(),
							"Fri"=>array(),
							"Sat"=>array(),
							"Sun"=>array(),"startDate"=>"","endDate"=>"","startTime"=>"","endTime"=>"");
		foreach($weekCycle as $k=>$v)
		{
			if(!is_array($v)){continue;}
			for($a=0,$b=count($v); $a<$b; $a++)
			{
				if($fenge=="")
				{
					$fenge=$v[$a]["extend"]["key"];
					$newWeekCycle[$k][]=$v[$a];
					continue;
				}
				if($fenge!=$v[$a]["extend"]["key"])
				{
					$fenge=$v[$a]["extend"]["key"];
					$newWeekCycle[$k][]=$v[$a];
				}
			}
		}
		$newWeekCycle["startDate"]=$weekCycle["startDate"];
		$newWeekCycle["endDate"]=$weekCycle["endDate"];
		$newWeekCycle["startTime"]=$weekCycle["startTime"];
		$newWeekCycle["endTime"]=$weekCycle["endTime"];
		$playListDesInfo["weekCycle"]=$newWeekCycle;
		$playListInfoArray=array();
		for($i=0,$n=count($playListGobalInfo); $i<$n; $i++)
		{
			$playListInfoArray["name"]=$playListGobalInfo[$i]["WeekPlaylistName"];
			$playListInfoArray["id"]=$playListGobalInfo[$i]["WeekPlaylistID"];
			$playListInfoArray["type"]=$playListGobalInfo[$i]["WeekPlaylistType"];
			$playListInfoArray["startDate"]=$playListGobalInfo[$i]["StartDate"];//$this->getTemPlayListStartTime($id);
			$playListInfoArray["endDate"]=$playListGobalInfo[$i]["EndDate"];//$this->getTemPlayListLastTime($id);
			$playListInfoArray["playlistModel"]=$playListGobalInfo[$i]["PlaylistModel"];
			$playListInfoArray["programs"]=$playListDesInfo;
		}
		
		return $playListInfoArray;
	}
	/*************************************************************
    |
    |	函数名:getPlayListLastTime
    |	功能:获取播放列表的最后时间
    |	返回值: 时间
    |	参数: $weekPlaylistID 播放计划ID
    |	创建时间:2012年8月5日 19:17:44 by 莫波
    |   
    **************************************************************/
	function getPlayListLastTime($weekPlaylistID=''){
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
	/*************************************************************
    |
    |	函数名:getPlayListStartTime
    |	功能:获取播放列表的开始时间
    |	返回值: 时间
    |	参数: $weekPlaylistID 播放计划ID
    |	创建时间:2012年8月5日 19:17:34 by 莫波
    |   
    **************************************************************/
	function getPlayListStartTime($weekPlaylistID=''){
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
	/*************************************************************
    |
    |	函数名:saveEditPlayList
    |	功能:保存编辑后的播放计划
    |	返回值: 时间
    |	参数: $weekPlaylistID 播放计划ID
    |	创建时间:2012年8月5日 19:17:34 by 莫波
    |   
    **************************************************************/
	function saveEditPlayList($playListId,$playlistName='',$playDataArr,$playlistType='X86',$playGolbalTime){		
		//$playlistName=iconv("GBK","UTF-8",$playlistName);
		@session_start();
		$playlistData=array(
					'WeekPlayListName'=>$playlistName,
					'WeekPlayListType'=>$playlistType,
					"Extend2"=>$this->userEntity->userGroupID,
					"Extend1"=>$this->userEntity->userID//,
					//"Extend3"=>$playGolbalTime
							);

		$this->db->where('WeekPlaylistID', $playListId);
		$this->db->update('week_playlist', $playlistData); 
		
		$tables = array('week_playlist_describe');
		$this->db->where('WeekPlaylistID', $playListId);
		$this->db->delete($tables);
		
		$playDataInfo=array();
		$num=count($playDataArr);
		for($i=0;$i<$num;$i++){
			$startDateTime=$playDataArr[$i]['startDate'].",".$playDataArr[$i]['startTime'];
			$endDateTime=$playDataArr[$i]['endDate'].",".$playDataArr[$i]['endTime'];
			$profileID=$playDataArr[$i]['programId'];
			$prior=$playDataArr[$i]['prior'];
			$extend=$playDataArr[$i]['extend'];
			$playDataInfo[]="($playListId,$profileID,$prior,'$startDateTime','$endDateTime','$extend')";
			
		}
		$playDataStr= implode($playDataInfo,",");
		$sqlStr="insert into week_playlist_describe (WeekPlaylistID,ProfileID,ProfilePrior,StartTime,EndTime,Extend5) values".$playDataStr;
		$query=$this->db->query($sqlStr);

		$rows=$this->db->affected_rows();
		$state=true;
		$info="";
		if($rows<=0){
		
			$this->UserLog->savePlaylist('1','102',null,null,0);
			$state=false;
		}else{
			$this->UserLog->savePlaylist('1','102',iconv("utf-8","gb2312",$playlistName),$playDataStr,1);
		}
		return array("state"=>$state);
	}
	/*************************************************************
    |
    |	函数名:getPlayListToCilent
    |	功能:获取播放计划
    |	返回值: 播放计划列表 array
    |	参数: $weekPlaylistID 播放计划ID
    |	创建时间:2012年8月5日 19:17:34 by 莫波
    |   
    **************************************************************/
	function getPlayListToCilent()
	{
		
		$username = $this->userEntity->userName;
		
		$sql="";
		
		
			$sql.="where Extend2 in (".$this->userEntity->userGroupID.")";
		
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
	
}
?>
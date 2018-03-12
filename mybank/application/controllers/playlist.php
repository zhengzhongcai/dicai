<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class PlayList extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_client','PlayList');
		$this->load->model('m_playList','playListInfo');
		$this->load->model('m_profileinfo','m_profileInfo');
	}
	function index(){

	}
	//获取单条播放计划的信息
	function getOneOfPlayList()
	{
		$this->playListInfo->getPlistInfo($_POST['listId']);   
	}
	
	//dsy获取详细媒体文件或Excel导入
	function getAllFile($listName,$stime,$etime,$listId,$pr_id,$profileName){
		
		$this->playListInfo->getProfileInfo($listName,$stime,$etime,$listId,$pr_id,$profileName);
	}
	



	function getPlayListPage()
	{
		$data=$_POST["data"];
		$data=json_decode($data,true);
		$pageInfo=array();
		$pageInfo["pageSize"]=$data["pageSize"];
		$pageInfo["pageIndex"]=($data["curent"]*1-1)*$pageInfo["pageSize"];
		$keyWord=$data["keyWord"];
		if(is_array($keyWord))
		{
			$pageInfo["keyWord"]="";
		}
		$arr_result=$this->playListInfo->getPlayListPage($pageInfo);
		$info=array();
		$info['playListInfo']=$arr_result["result"];
		//$info['pageCount']=$arr_result["totalRows"];
		$pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
		$info['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
		echo json_encode($info);
	}
	//孙国安
	function getAllPlayList_s(){
		$data['title']='播放计划';
		$data['playListInfo']=$this->PlayList->getPlayList();
		//pArr($data);
		$this->load->view('playlist_V_s',$data);

	}

	function getPlayInfo(){
		//$playInfo=$this->PlayList->getPlayInfo($_POST['playListID'])
		$playlistID=$_POST['playListID'];
		$playInfo=$this->playListInfo->getPlayInfo($playlistID);//
		$output='<table id="describeTab" width="800" style="font-size:12px;" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
		<tr>
		
		<td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放单元</span></div></td>
        <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">开始时间</span></div></td>
        <td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">结束时间</span></div></td>
		<td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">优先级</span></div></td>
		<td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div>
</td>
		</tr>';
		foreach ($playInfo as $p){
			/*$output.='<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center">
          <input type="checkbox" name="describeID" id="describeID" value="'.$p['describeID'].'"/>'.$p['describeID'].
        '</div></td>';*/
		   
			$output.='<tr  id="'.$p['describeID'].'"  value="kycool"><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$p['profileName'])))."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['startTime']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['endTime']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['playListPre']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19"><a href="javascript:deleteDescribeInfo('.$p['describeID'].')"> 删除</a></td></tr>';
		}
		$output.="</table>";///
		if(count($playInfo)>1){
			$output.='<div align="center"><span class="STYLE19"><a href="/CI/index.php/playlist/deleteDescribe/'.$playlistID.'/1"> 删除所有</a></span></div>';
		}
		echo $output;
	}
	
	//孙国安
	function getPlayInfo_s(){
		//$playInfo=$this->PlayList->getPlayInfo($_POST['playListID'])
		$playlistID=$_POST['playListID'];
		$playInfo=$this->PlayList->getPlayInfo($playlistID);//
		$output='<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
		<tr>
		<td width="10%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">播放单元</span></div></td>
        <td width="15%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">开始时间</span></div></td>
        <td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">结束时间</span></div></td>
		<td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">优先级</span></div></td>
		<td width="14%" height="20" bgcolor="d3eaef" class="STYLE6"><div align="center"><span class="STYLE10">操作</span></div>
</td>
		</tr>';
		foreach ($playInfo as $p){
			/*$output.='<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center">
          <input type="checkbox" name="describeID" id="describeID" value="'.$p['describeID'].'"/>'.$p['describeID'].
        '</div></td>';*/
			$output.='<tr><td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.iconv("gb2312","utf-8",urldecode(preg_replace("/\_/","%",$p['profileName'])))."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['startTime']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['endTime']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">'.$p['playListPre']."</td>";
			$output.='<td height="20" bgcolor="#FFFFFF" class="STYLE6"><div align="center"><span class="STYLE19">
<a href="/CI/FileLib/'.iconv("gb2312","utf-8",$p['profileName']).'/'.iconv("gb2312","utf-8",$p['profileName']).'_view.html"> 浏览</a></td></tr>';
		//孙国安
		}
		$output.="</table>";
		if(count($playInfo)>1){
			$output.='<div align="center"><span class="STYLE19"><a href="/CI/index.php/playlist/deleteDescribe/'.$playlistID.'/1"> 删除所有</a></span></div>';
		}
		echo $output;
	}

	/*************************
	  --创建新的计划
	  ************************/
	function addPlayList(){
		$where=array('ProfileType'=> "X86");
		$info=$this->m_profileInfo->getProgramByWhere($where);
		$data['profile']=$info;
		//echo $info;
		//$this->smarty->assign('profile', $data);
		//$this->smarty->display('playProgram/addPlayList.html');
		$this->load->view('playProgram/addPlayList',$data);
	}
	
    function getProfileInfo(){
    	$type=$GET['type'];
		$where=array('ProfileType'=> $type);
		$profile=$this->m_profileInfo->getProgramByWhere($where);
		$strtab = '<p style=" margin-bottom:5px;">开始时间点:<input type="text" id="weekStartTime" name="weekStartTime" maxlength="8" size="10" /> ';
		$strtab .= '结束时间点:<input type="text" id="weekEndTime" name="weekEndTime" maxlength="8" size="10" /></p>';
		$strtab .= "<p>节目列表:</p><table id='tab_prolist' class='table_class' width='450px' border='1'><tr>";
		for($i=0;$i<count($profile);$i++)
		{
			$strtab .='<td><label for="program_'.$i.'"><input type="radio" id="program_'.$i.'" name="rad_pro" value="'.$profile[$i]["profileID"].'|'.$profile[$i]["profileName"].'" />'.$profile[$i]["profileName"].'</label></td>';
		    if(($i+1)==count($profile))
			{
				if(($i+1)%4!=0)
				{
					$strtab .="<td>&nbsp;</td>";
				}
				$strtab .="</tr>";
				break;
			}
			if(($i+1)%4==0)
			{ 
				$strtab .="</tr><tr>";
			}
		}
		$strtab .="</table><table class='table_class' width='100%'><tr><td align=\"center\"><input type=\"button\" value=\"确定\" onclick=\"chosepro(".$_POST['weekday'].");\"></td></tr></table>";
		echo $strtab;
		//var_dump($strtab);exit;
		// $this->load->view('addPlayList',$data);
	}
	
	function deleteDescribe(){
		$describeID=$this->uri->segment(3);
		$action=$this->uri->segment(4,'0');
		//exit();
		$this->PlayList->deleteDescribe($describeID,$action);
		echo '<script>history.back();window.reload();</script>';
	}
	function editPlaylist(){
		$data['title']="修改播放计划";
		//由类似于路径地址获得参数
		$playlistID = $this->uri->segment(3);
		$playlistName = urldecode($this->uri->segment(4));
		$data['playlistID']=$playlistID;
		$data['playlistName']=$playlistName;
		$data['profile']=$this->PlayList->getProfile();
        $data['profile_area_time']=$this->getPlaylistProfileInfo($playlistID);
		$this->load->view('editPlayList',$data);
	}
    
	//-----------------------------------------
    //  功能说明:
    //          获取播放计划中Profile的名称，ID，播放时间段 开始时间见和结束时间
    //  参数:
    //      $id:int 类型 播放计划的主键值;
    //  时间: 2011-09-28 17:42:50
    //  作者: BOBO
    //-----------------------------------------
    function getPlaylistProfileInfo($id)
    {
        $profileArray=$this->playListInfo->getPlayListProfileTimeEare($id);
        if(count($profileArray)==0)
        {
            return $profileArray;
        }
        $proId=array();
        foreach($profileArray as $k=>$v)
        {
            $proId[]=preg_replace("/_/","",$k);
        }
        $str=implode(",",$proId);
        $sql="SELECT  `ProfileName` ,`ProfileID`
                FROM  `profile` 
                WHERE  `ProfileID` 
                IN ($str)";
        $rs=$this->db->query($sql)->result_array();
        $count=count($rs);
        if($count)
        {
            foreach($profileArray as $k=>$v)
            {
                foreach($rs as $vl)
                {
                    if($vl["ProfileID"]==preg_replace("/_/","",$k))
                    {
                        $profileArray[$k]["name"]=proDecodeName($vl["ProfileName"]);
                        $profileArray[$k]["id"]=$vl["ProfileID"];
                    }
                }
            }
        }
        return $profileArray;
    }
    
    function deleteProfileFromPlaylist()
    {
       $proId= $_POST["Describeid"];
       $sql="DELETE FROM  `Week_playlist_describe` WHERE ProfileID =".preg_replace("/[' =]/","",$proId);
       $this->db->query($sql);
       echo '{"state":"true"}';
       
    }
    
	function saveEditPlaylist(){
		/*$playlistID=15;
		$str='[{"profileID":"1","startTime":"2010-01-11,00:00:00","endTime":"2010-01-11,23:59:59","prior":"1"}]';
		$this->PlayList->updatePlaylist($playlistID,$str);*/
		$this->PlayList->updatePlaylist($_POST['playlistID'],$_POST['playlistData'],$_POST['playlistName']);//dsy
	}
	function savePlaylist(){
		$this->playListInfo->addTemPlaylist(iconv("utf-8","gb2312",$_POST['playlistName']),$_POST['playlistData'],$_POST['playType']);
	}
	function checkIsInTime(){
		$data['title']="检查播放时间段是否占用";
		$this->PlayList->isInTime($_POST['weekPlaylistID'],$_POST['profileID'],$_POST['startTime'],$_POST['endTime']);
	}
	function checkIsExists(){
		$data['title']="检查用户名是否存在";
		$this->PlayList->checkIsExistsPlaylistName(@$_POST['playlistName']);
		//echo $_POST['playlistName'];
	}
	function deletePlaylist(){
		$this->PlayList->deletePlaylist($_POST['playlistID']);
	}
	function deleteMulpPlaylist(){
		$this->playListInfo->deleteMulpPlaylist($_POST['playlistIDs']);
	}
	function addPlayListByExcel($path)
	{
		$this->load->view($path);
	}
	function addPlayListByExcelNew()
	{
		$this->load->view("importExcelNew");
	}
	
	//删除播放计划的播放单元
	function deleteDescribeInfo()
	{
	    $this->playListInfo->deleteDescribeInfo($_POST['Describeid']);
	}
	
	//导出播放计划
	// 2011年6月8日12:38:20 by 莫波
	function exportPlayList($playlistIDs)
	{
		$ids=array("id"=>$playlistIDs);//explode(",",$_POST['playlistIDs']);getPlistInfoToExport
		$pinfo=$this->playListInfo->getPlistInfoToExport($ids);
		foreach($pinfo as $k=>$v)
		{
			//创建播放列表文件夹
			$export="export".$v["WeekPlaylistID"];
			//mkdir($export);
			$dayFiles=$v["week_playlist_describe"];
			foreach($dayFiles as $d=>$t)
			{
				$dayFileInfo=array();
				$dayFileInfo["fileName"]=substr($t["StartTime"],0,10);
				//找到已知的Profile读取信息
				foreach($v["weekPlaylistDescribe"] as $i=>$p)
				{
					if($p["ProfileID"]==$t["ProfileID"])
					{
						$dayFileInfo["fileName"]=array("time"=>substr($t["StartTime"],10)."||".substr($t["EndTime"],10));
					}
				}
				//创建文件写入播放数据
				//$handl=fopen($export."/".$dayFileInfo["fileName"],"w");
				//fwrite($handl,$t["StartTime"]);
				//fclose($handl);
			}
		}
		echo Information("exportPlayList",$pinfo);
	}
	
	//将临时表数据复制到正式表里
	// function upTemPlayList()
	// {
	   // // var_dump($_POST["PlayListID"]);exit;
		// $playlistid = $_POST["PlayListId"];
        // $this->playListInfo->upTemPlayList($playlistid);
	// }
	/*******************************************
	  *作者：kycool
	  *时间：2012/9/3  16:20:34
	  *描述：节目查看删除单条记录
	  *参数：无
	  ******************************************/
	function  deleteOnlyPlayList(){
			$this->playListInfo->mdeleteOnlyPlayList($_POST['strid']);
	}
}
?>
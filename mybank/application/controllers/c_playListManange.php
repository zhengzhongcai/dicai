<?php  
class C_playListManage extends CI_Controller{
	function __construct(){
		parent::__controller();
				$this->load->model('m_playlistmanage','m_pl');
		$this->load->model('m_client','m_client');
		$this->load->model('m_profileinfo','m_profileInfo');
	}
		/***********************
	  --节目模块首页输出
	  **********************/
	function getAllPlayList(){
		// $data=array();
		// $data['pageSize']=20;
		// $data['pageIndex']=0;
		// //pArr($data);
		// $arr_result=$this->m_pl->getPlayList($data);
		// $data['playListInfo']=$arr_result["result"];
// 		
		// $pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);//页数的取值
		// $data['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;//最终的页数
		// echo json_encode($data);
		//$this->smarty->display('v_playlist.html');
		$this->load->view("playProgram/v_playlist");
	}
	
	function playList(){
		$data=array();
		$data['pageSize']=$this->input->post("rows");
		$data['pageIndex']=($this->input->post("page")*1-1)*$data['pageSize'];
		//pArr($data);
		$arr_result=$this->m_pl->getPlayList($data);
		//$data['playListInfo']=$arr_result["result"];
		
		//$pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);//页数的取值
		//$data['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;//最终的页数
		
		$result=array(
			"total"=>$arr_result["totalRows"],
			"rows"=>$arr_result["result"]
		);
		echo json_encode($result);
	}
	/*************************************************************
    |
    |	函数名:savePlayList
    |	功能:保存播放列表
    |	返回值: 直接输出 JQUERY
    |	参数:
    |	创建时间:2012年7月26日 16:44:04 by 莫波
    |   
    **************************************************************/
	function savePlayList(){
		$info=$this->input->post("data");
		$dataPlayInfo=array();
		//echo json_encode($info);
		if(is_array($info))
		{
			$gobal=$info["golbal"];
			//echo json_encode($gobal);
			$playlistModel=$gobal["playlistModel"];
			$playlistName=$gobal["playListName"];
			$playlistType=$gobal["playListType"];
			$playGolbalTime=array("startDate"=>$gobal["startDateTime"],"endDate"=>$gobal["endDateTime"]);
			$programs=$info["programs"];
			if(isset($programs["dayCycle"]))
			{
				$dayCycle=$programs["dayCycle"];
				if(count($dayCycle))
				{
					foreach($dayCycle as $k=>$v)
					{
						$dataPlayInfo[]=$v;
					}
				}
			}
			if(isset($programs["weekCycle"]))
			{
				$weekCycle=$programs["weekCycle"];
				if(count($weekCycle))
				{
					foreach($weekCycle as $k=>$v)
					{
						$dataPlayInfo[]=$v;
					}
				}
			}
			//echo $dataPlayInfo;
			$res=$this->m_pl->storagePlaylist($playlistName,$dataPlayInfo,$playlistType,$playGolbalTime,$playlistModel);
			if($res["state"])
			{
				echo json_encode(array("state"=>true,"info"=>"播放列表创建成功"));
			}
			else
			{echo json_encode(array("state"=>true,"info"=>"播放列表创建失败"));}
		}
	}
	/*************************************************************
    |
    |	函数名:editPlayListView
    |	功能:加载编辑界面
    |	返回值: 编辑视图
    |	参数:$id 播放列表ID, $name播放列表名称
    |	创建时间:2012年7月26日 17:36:11 by 莫波
    |   
    **************************************************************/
	function editPlayListView(){
		$data['profile']=$this->m_client->getProfile();
		$this->load->view('playProgram/addPlayList',$data);
	}
	/*************************************************************
    |
    |	函数名:loadEditPlayListInfo
    |	功能:保存播放列表
    |	返回值: 直接输出 JQUERY
    |	参数:
    |	创建时间:2012年7月26日 16:44:04 by 莫波
    |   
    **************************************************************/
	function loadEditPlayListInfo()
	{
		$info=$this->input->post("data");
		//echo json_encode($info);
		$res=array();
		$state=false;
		if(is_array($info))
		{
			$id=(int)$info["playListId"];
			$result=$this->m_pl->loadPlayListInfoById($id);
			if(!is_bool($result))
			{
				$res=$result;
				$state=true;
			}
			else
			{$state=false;}
		}
		echo json_encode(array("state"=>$state,"data"=>$res));
	}
	/*************************************************************
    |
    |	函数名:saveEditPlayList
    |	功能:保存修改后的播放列表
    |	返回值: 直接输出 JQUERY 
    |	参数:
    |	创建时间:2012年7月27日 11:09:28 by 莫波
    |   
    **************************************************************/
	function saveEditPlayList()
	{
		$info=$this->input->post("data");
		$playListId=$this->input->post("playListkey");
		
		
		if(is_array($info))
		{
			$gobal=$info["golbal"];
			//echo json_encode($gobal);
			$playlistName=$gobal["playListName"];
			$playlistType=$gobal["playListType"];
			$playGolbalTime=$gobal["startDateTime"]."||".$gobal["endDateTime"];
			$programs=$info["programs"];
			if(isset($programs["dayCycle"]))
			{
				$dayCycle=$programs["dayCycle"];
				if(count($dayCycle))
				{
					foreach($dayCycle as $k=>$v)
					{
						$dataPlayInfo[]=$v;
					}
				}
			}
			if(isset($programs["weekCycle"]))
			{
				$weekCycle=$programs["weekCycle"];
				if(count($weekCycle))
				{
					foreach($weekCycle as $k=>$v)
					{
						$dataPlayInfo[]=$v;
					}
				}
			}
			//echo json_encode($dataPlayInfo);
			$res=$this->m_pl->saveEditPlayList($playListId,$playlistName,$dataPlayInfo,$playlistType,$playGolbalTime);
			if($res["state"])
			{
				echo json_encode(array("state"=>true,"info"=>"播放列表更新成功"));
			}
			else
			{echo json_encode(array("state"=>true,"info"=>"播放列表更新失败"));}
		}
	}
	/*************************************************************
    |
    |	函数名:getPlayListToCilent
    |	功能:获取播放列表
    |	返回值: 直接输出 JQUERY 
    |	参数:
    |	创建时间:2012年8月5日 19:30:40 by 莫波
    |   
    **************************************************************/
	function getPlayListToCilent(){
		$res=$this->m_pl->getPlayListToCilent();
		$state=false;
		$info="";  
		if(count($res)){
			$info=$res;
			$state=true;
		}
		echo json_encode(array("state"=>$state,"data"=>$info));
	}
	
	function getProgramInfoToPlayListAdd($proType){
		$where=array('ProfileType'=> $proType);
		$info=$this->m_profileInfo->getProgramByWhere($where);
		if(count($info)){
			echo json_encode(array("state"=>true,"data"=>$info));
		}
		else {
			echo json_encode(array("state"=>false,"data"=>"没有此类型的节目!"));
		}
	} 
}
?>
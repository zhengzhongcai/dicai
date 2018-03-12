<?php
class M_user extends CI_Model{
	function __construct()
    {
        parent::__construct();
		$this->load->helper('directory');
		$this->load->model('m_userlog','UserLog');
		$this->load->model('m_config','mconfig');
	}
	function getUserInfo($condition='',$offset='',$limit=''){	
		$userInfo=array();		
		if($condition)  $this->db->where($condition); 
		if($limit)	$query = $this->db->get('user',$limit,$offset);
		else	$query = $this->db->get('user');
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放计划名称
				$userInfo[$i]['userID']=$row->UserID;
				$userInfo[$i]['userName']=$row->UserName;
				$userInfo[$i]['userPwd']=$row->Password;				
				$userInfo[$i]['userPhone']=$row->Phone;
				$userInfo[$i]['userSessionID']=$row->Extend1;				
				$userInfo[$i]['km_user']=$row->Km;
				$userInfo[$i]['email']=$row->email;
				$userInfo[$i]['dept']=$row->Dept;
				$userInfo[$i]['title']=$row->Title;				
				$userInfo[$i]['dept_2']=$row->Dept_2;
				$userInfo[$i]['dept_3']=$row->Dept_3;
				$userInfo[$i]['description']=$row->Description;
				$userInfo[$i]['rid']=$row->Rid;
				$userInfo[$i]['isCheck']=$row->IsCheck;
				$i++;
			}//循环结束

		}
		return $userInfo;
	} 
	function getDeptSession(){
		@session_start ();
		$id = $_SESSION['opuserID'];	
		$sql_ = "select Km,Dept_2,Rid from user where UserID =".$id;
		$rs=$this->db->query($sql_)->result_array();		
		$_km = $rs[0]['Km'];
		$_dept = $rs[0]['Dept_2'];
		$_Rid = $rs[0]['Rid'];
		$data= array();
		$data[]="$id";
		$data[]="$_km";
		$data[]="$_dept";
		$data[]="$_Rid";		
		return $data;
	}
	
	function getUserInfo1($condition='',$offset='',$limit=''){
		
		$userInfo=array();		
		$data = $this->getDeptSession();		
		
		$sql="select * from user";
		if($condition)			
		{
			if($data[3] == 1)
				$sql.=" where ".$condition ;
			elseif($data[3] == 2)
				$sql.=" where ".$condition." and km!='".$data[1]."'";
			else
				$sql.=" where Dept_2 = '".$data[2]."' and ".$condition." and km!='".$data[1]."'";				
		}
		if($limit)	
		{
			$sql .=" limit ".$offset.",".$limit;
			$query = $this->db->query($sql);
			}
		else	{$query = $this->db->query($sql);}
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放计划名称
				$userInfo[$i]['userID']=$row->UserID;
				$userInfo[$i]['userName']=$row->UserName;
				$userInfo[$i]['userPwd']=$row->Password;				
				$userInfo[$i]['userPhone']=$row->Phone;
				$userInfo[$i]['userSessionID']=$row->Extend1;				
				$userInfo[$i]['km_user']=$row->Km;
				$userInfo[$i]['email']=$row->email;
				$userInfo[$i]['dept']=$row->Dept;
				$userInfo[$i]['title']=$row->Title;				
				$userInfo[$i]['dept_2']=$row->Dept_2;
				$userInfo[$i]['dept_3']=$row->Dept_3;
				$userInfo[$i]['description']=$row->Description; 
				$userInfo[$i]['rid']=$row->Rid;
				$userInfo[$i]['isCheck']=$row->IsCheck;
				$i++;
			}//循环结束
		}
		return $userInfo;
	}
	function getKmInfo($condition='',$offset='',$limit=''){
		$kmInfo=array();

		if($condition)	$this->db->where($condition);
		if($limit)	$query = $this->db->get('km_user',$limit,$offset);
		else	$query = $this->db->get('km_user');
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$kmInfo[$i]['km_user']=$row->km;
				$kmInfo[$i]['userName']=$row->username;
				$kmInfo[$i]['title']=$row->title;
				$kmInfo[$i]['dept']=$row->dept;
				$kmInfo[$i]['mobile']=$row->mobile;
				$kmInfo[$i]['email']=$row->email;
				$kmInfo[$i]['dept_2']=$row->dept_2;
				$kmInfo[$i]['dept_3']=$row->dept_3;
				$kmInfo[$i]['description']=$row->description;
				$i++;
			}
		}
		return $kmInfo;
	}

	function getClientGroup(){
		$data = $this->getDeptSession();
		$clientGroupInfo=array();		
		$sql = '';
		if($data[3] == 1){
			$sql="select * from client_tree where isClient=0";
		}
		if($data[3] == 2){
			$sql="select * from client_tree where isClient=0 and Extend1 != 'sa'";
		}
		if($data[3] == 3){
			$sql="select * from client_tree where isClient=0 and Extend1 in ('$data[1]','')";
		}
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放计划名称
				$clientGroupInfo[$i]['clientGroupID']=$row-> TreeNodeSerialID;
				$clientGroupInfo[$i]['clientGroupName']=$row->Name;
				$clientGroupInfo[$i]['clientGroupNodeCode']=$row->TreeNodeCode;
				$i++;
			}//循环结束
		}		
		return $clientGroupInfo;
	}
	//获取终端数组 array(TreeNodeSerialID=>TreeNodeCode)
	function _getClientGroupWI($condition='')
	{
		if($condition)
		{
			$this->db->select('TreeNodeSerialID,TreeNodeCode');
			$this->db->where_in('TreeNodeSerialID',$condition);
			$query = $this->db->get('client_tree');
			if ($query->num_rows>0)
			{
				foreach ($query->result() as $row)
				{					
					$clientGroupInfo[$row->TreeNodeSerialID]=$row->TreeNodeSerialID;
				}
			}
			return $clientGroupInfo;
		}
		return false;
	}
	//计算生成终端树根 返回TreeNodeSerialID
	function _getTreeRoot($arr='')	//$arr为_getClientGroupWI()获取的终端数组
	{
		
		if($arr)
		{
			
			foreach($arr as $k=>$v)
			{
			
			    for($i=1;$i<strlen($v)/4;$i++)
				{
					if(in_array(substr($v,0,-4*$i),$arr))
					{
						unset($arr[$k]);
					}
				} 			 
			}
			return array_keys($arr);
		}
		return false;
	}
	//权限
	function getAccessInfo(){
		$accessInfo=array();
		$sql="select * from access where AccessID>3";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放计划名称
				$accessInfo[$i]['accessID']=$row-> AccessID;
				$accessInfo[$i]['accessName']=$row->AccessName;
				$i++;
			}//循环结束

		}		
		return $accessInfo;
	}
	//数据表信息
	function getDatabaseInfo(){
		$databaseInfo=array();
		$sql="show Tables";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放计划名称
				$databaseInfo[$i]['tableID']=$i+1;
				$databaseInfo[$i]['tableName']=$row->Tables_in_ams;
				$i++;
			}//循环结束

		}		
		return $databaseInfo;
	}
	function showClientTree_ajax($item=''){
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
		client_tree ";
		$sql.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$item%'";
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

	function showClientTree($item=''){
		$returnArr='';
		if($item==''){
			$item='0001';
		}
		$ClientTree=array();
		$len=(strlen($item)+4);
		$sql="select TreeNodeSerialID,Name,TreeNodeCode,IsClient from
		client_tree ";
		$sql.= "where length(TreeNodeCode)=$len and TreeNodeCode like '$item%'";
		//echo $sql;
		$query=$this->db->query($sql);
		$i=0;
		if($query->num_rows>0){			
			foreach($query->result() as $row){
				$ClientTree[$i]['TreeNum']=$row->TreeNodeSerialID;
				$ClientTree[$i]['TreeName']=$row->Name;
				$ClientTree[$i]['TreeNodeCode']=$row->TreeNodeCode;
				$ClientTree[$i]['TreeIsClient']=$row->IsClient;
				if($ClientTree[$i]['TreeIsClient']==0){//是组的话进行下一轮循环
					//echo ("<li><ul><a href=#>group:".$row->Name."</a>");
					$returnArr.="<li><ul><a href=#>group:".$row->Name."</a>";
					$this->showClientTree($row->TreeNodeCode);
					$returnArr.="</ul></li>";
					//echo ("</ul></li>");


				}else{
					//echo ("<li><a href=#>".$row->Name."</a></li>");
					$returnArr.="<li><a href=#>".$row->Name."</a></li>";
				}
				$i++;
			}
		}
	}
	function getPlayList(){
		$query=$this->db->get('Week_PlayList');
		$i=0;
		$playList=array();
		foreach($query->result() as $row){
			$playList[$i]['ID']=$row->WeekPlaylistID;
			$playList[$i]['PlayListName']=$row->WeekPlaylistName;
			$i++;
		}

		return $playList;
	}
	function getPlayInfo($playListID){
		$sql="select startTime,endTime,profilename from week_playlist_describe left join profile on 		profile.profileID=week_playlist_describe.profileID where week_playlist_describe.weekplaylistID=".$playListID;
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			$playInfo=array();
			foreach($query->result() as $row){
				$playInfo[$i]['profileName']=$row->profilename;
				$playInfo[$i]['startTime']=$row->startTime;
				$playInfo[$i]['endTime']=$row->endTime;
				$i++;
			}
		}		
		return $playInfo;
	}
	function reopenUser($userIds=array())
	{
	    if(!empty($userIds)){
			$deltable = array('user','user_client');
			$this->db->trans_start();
			foreach ($userIds as $v)
			{
			$sql = "select UserName,Password from user where userID =".$v;
			$query=$this->db->query($sql);
			$UserName = "";
			$Password = "";
			if($query->num_rows>0){
			    foreach($query->result() as $row){
				$UserName=$row->UserName;
				$Password =$row->Password;
			}
			}
			$namearr = explode('--',$UserName);
			$passwordarr = explode('--',$Password);
			$this->db->where(array('userID'=>$v,'IsDisplay'=>'1'));
			$this->db->update('user',array('UserName'=>$namearr[0],'Password'=>$passwordarr[0],'IsDisplay'=>''));
			}
			/*$this->db->delete('user',array('userID'=>$userId));//删除用户表
			$this->db->delete('user_access',array('userID'=>$userId));//删除用户权限表
			$this->db->delete('user_client',array('userID'=>$userId));//删除用户终端分配表*/
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				// 生成一条错误信息... 或者使用 log_message() 函数来记录你的错误信息
				return false;
			}
			return true;
		}
	}
	//删除用户
	function deleteUser($userIds=array()){
		if(!empty($userIds)){
			$deltable = array('user','user_client');
			$this->db->trans_start();
			foreach ($userIds as $v)
			{
			$sql = "select UserName,Password from user where userID =".$v;
			$query=$this->db->query($sql);
			$UserName = "";
			$Password = "";
			if($query->num_rows>0){
			    foreach($query->result() as $row){
				$UserName=$row->UserName;
				$Password =$row->Password;
			}
			}
			$this->db->where(array('userID'=>$v,'IsDisplay'=>''));
			$this->db->update('user',array('UserName'=>$UserName."--已注销",'Password'=>$Password."--已注销" ,'IsDisplay'=>'1'));
			}
			/*$this->db->delete('user',array('userID'=>$userId));//删除用户表
			$this->db->delete('user_access',array('userID'=>$userId));//删除用户权限表
			$this->db->delete('user_client',array('userID'=>$userId));//删除用户终端分配表*/
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				// 生成一条错误信息... 或者使用 log_message() 函数来记录你的错误信息
				return false;
			}
			return true;
		}
	}

//denglei添加,调web服务失败时删除用户
	function deleteUserForWeb($userIds=array()){
		if(!empty($userIds)){
			$deltable = array('user','user_access','user_client');
			$this->db->trans_start();
			foreach ($userIds as $v)
			{
			$this->db->where(array('userID'=>$v));
			$this->db->delete($deltable);
			}			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				// 生成一条错误信息... 或者使用 log_message() 函数来记录你的错误信息
				return false;
			}
			return true;
		}
	}
	
/**
  company:sunrising

  name:zhangli

  description: Add $Ajax( KM_user );
  name :denglei
  删除了缺省变量,缺省为空会导致查寻报错
*/
	function checkuserkm($km_user)
	{
		if($km_user!='')
		{
			$query=$this->db->query("select km from km_user where km=".$this->db->escape($km_user));
			return $query->num_rows();
		}
	}
	
	

	/**
		name: zhangli
		根据USERID查询USER表中KM帐号；
	**/

	function getUserId($userID)
	{
		$userkm = array();
		if($userID!='')
		{
			$query=$this->db->query("select Km from user where UserID=".$this->db->escape($userID));

			if($query->num_rows>0){
				$i = 0;
				foreach($query->result() as $row){

					$userkm[$i]=$row->Km;
				}
			}
		}
		return $userkm;
	}	
	
	
	// zhangli  市场部 可以查看所有部门，其他部门只能查看自己的部门;
	function getDept(){
		
		$id = $_SESSION['opuserID'];
	
		$sql_ = "select Km,Dept from user where UserID =".$id;
		$rs=$this->db->query($sql_)->result_array();		
		$_km = null;
		$_dept = null;
		$_km = $rs[0]['Km'];
		$_dept = $rs[0]['Dept'];
		//$s = iconv('gbk','utf-8',$_dept);
		
		if($id == 1){
			$sql = "select Km,Dept from km_user where Dept != '' group by Dept";
			$query = $this->db->query($sql);
			if($query->num_rows > 0){			
				return $query->result_array();			
		    }
		}
		
		if($_dept == "市场经营部"){		
			$sql = "select Km,Dept from km_user where Dept != '' group by Dept";
			$query = $this->db->query($sql);
			if($query->num_rows > 0){			
				return $query->result_array();			
		    }			
			
	    }else{
			$sql = "select Km,Dept from km_user where Km = '".$_km."'";
			$query = $this->db->query($sql);
			if($query->num_rows > 0){			
				return $query->result_array();			
		    }
		}
	
	}
	//根据 Dept、title 查询
    function getDeptTitle($dept,$title){	
		
		$sql = '';
		$d = iconv('utf-8','gbk',$title);	
			
	 	if($dept != ''){
			if(is_numeric($title)){	
				$sql = "select * from km_user where Dept in (select Dept from km_user where Km='".$dept."') and Title like '".$title."%'";		
			}else{
				if($title != ''){
					$sql = "select * from km_user where Dept in (select Dept from km_user where Km='".$dept."') and username like '%".$d."%'";
				}else{
					$sql = "select * from km_user where Dept in (select Dept from km_user where Km='".$dept."')";
				}
			}
			$query = $this->db->query($sql);
			if($query->num_rows > 0){
				return $query->result_array();			  
			}
			else{ echo "null"; exit(0);}
		}		
	}	

	//插入用户信息 权限分配..
	function insert_user()
	{	
		$userdata['username'] = $this->input->post('username');
		$userdata['pws'] = $this->input->post('password');		
		$userdata['phone'] = $this->input->post('tel');
		$userdata['km'] = $this->input->post('km_user');
		$userdata['dept'] = $this->input->post('dept');
		$userdata['email'] = $this->input->post('email');
		$userdata['title'] = $this->input->post('title');		
		$userdata['dept_2']=$this->input->post('dept_2');
		$userdata['dept_3']=$this->input->post('dept_3');
		$userdata['description']=$this->input->post('description');
		$userdata['rid']=$this->input->post('Rid');
		$userdata['myRadio']=$this->input->post('myRadio');
		$checked = '';
		if($userdata['km'] == '')
		{
			$this->UserLog->loginLog('1','2','0','操作错误',0); 
			return false;
			exit();
		}
		if($userdata['myRadio'] == 1){
			if($userdata['rid'] == 3 || $userdata['rid'] == 4 || $userdata['rid'] == 5){
				$userdata['myRadio'] = 0;
			}
			$checked = '是';
			$this->getEditIsCheck($userdata['dept_2'],$userdata['rid']);
		}else{$checked = '是';}	
		$this->db->trans_start();
		$this->db->query("insert into user (UserName,Password,Phone,Km,Dept,email,Title,Dept_2,Dept_3,Description,Rid,IsCheck) values (".$this->db->escape($userdata['username']).",password(".$this->db->escape($userdata['pws'])."),".$this->db->escape($userdata['phone']).",".$this->db->escape($userdata['km']).",".$this->db->escape($userdata['dept']).",".$this->db->escape($userdata['email']).",".$this->db->escape($userdata['title']).",".$this->db->escape($userdata['dept_2']).",".$this->db->escape($userdata['dept_3']).",".$this->db->escape($userdata['description']).",".$this->db->escape($userdata['rid']).",".$this->db->escape($userdata['myRadio']).")");
		
		$insertID = $this->db->insert_id();			   			
		if($this->input->post('treeNode'))
		{
			
			foreach($this->_getClientGroupWI($this->input->post('treeNode')) as $c)
			{					
			  $this->db->query("insert into user_client (UserID,TreeNodeSerialID,PriorityID) values ($insertID,$c,1)");
			}
		}		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			// 生成一条错误信息... 或者使用 log_message() 函数来记录你的错误信息
			$this->UserLog->loginLog('1','2',$userdata['km'],$userdata['rid'],0);    // 日志记录 1. 添加失败
			return false;
			exit();
		}
		
		//创建与用户绑定的文件夹
		//mkdir("Material/".iconv("utf-8","gb2312",$userdata['username'])."Cache",0777);
		@mkdir("FileLib/".iconv("utf-8","gb2312",$userdata['username'])."Cache",0777);
		
		//设置默认FTp 
		$this->mconfig->SetUserDefaultFtp($this->input->post('defaultFtp'),$insertID);
		
		
		$str = 'KM账号:'.$userdata['km'].'&用户角色:'.$userdata['rid'].'&终端组ID:';
		$clientGroupName = $this->input->post('treeNode');
		for($i=0;$i < count($clientGroupName);$i++){
			$str .= $clientGroupName[$i].",";
		}
		$str1 = substr($str,0,(strlen($str)-1));
		$this->UserLog->loginLog('1','2',$userdata['km'],$str1,1);	// 日志记录 1. 添加成功
		
		return true;
	}
	
	
	
	
	//获取旧的权限
	function getOldAccessInfo($userID){
		$oldAccessInfo=array();
		$sql="select AccessID from user_access where UserID =$userID";
		$query=$this->db->query($sql);
		if($query->num_rows>0){

			foreach($query->result() as $row){
				//获得权限列表
				$oldAccessInfo[]=$row->AccessID;
			}//循环结束

		}
		return $oldAccessInfo;
	}
	//获取旧的终端分配信息
	function getOldClientInfo($userID){
		$oldClientInfo=array();
		$sql="select TreeNodeSerialID from user_client where UserID=$userID";
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			foreach($query->result() as $row){
				//获得列表
				$oldClientInfo[]=$row->TreeNodeSerialID;
			}//循环结束
		}
		return $oldClientInfo;
	}
	//修改用户
	function editUser($condition,$userID)
	{
		$data = array('Rid'=>$this->input->post('selRole'),'IsCheck'=>$this->input->post('myRadio'),'Dept_2'=>$this->input->post('dept_2'),'Dept_3'=>$this->input->post('dept_3'),'Description'=>$this->input->post('description'),'Phone'=>$this->input->post('tel'),'email'=>$this->input->post('email'));
		if($this->input->post('myRadio') == 1){
			$this->getEditIsCheck($this->input->post('dept_2'),$this->input->post('selRole'));
		}	
		$this->db->trans_start();//事务 start
		$this->db->update('user',$data,$condition);//update user table	
		$this->db->delete('user_client',$condition);//删除用户终端分配表
		if($this->input->post('clientGroupName'))
		{				  		
			foreach($this->input->post('clientGroupName') as $c)
			{						
				$this->db->query("insert into user_client (UserID,TreeNodeSerialID,PriorityID) values ($userID,$c,1)");
			}
		}			
		$this->db->trans_complete();//事务 end
		if ($this->db->trans_status() === FALSE)// 生成一条错误信息
		{
			return false;
		}	
		return true;	
	}
	
	//取得用户数
	function getUserNumber($condition='')
	{
		if($condition)	$this->db->where($condition);
		$this->db->from('user');
		return $this->db->count_all_results();
	}	
	
	//修改密码
	function editUserPws($userID=0)
	{
		if (intval($userID)>1)
		{
			$this->db->set('Password','password('.$this->db->escape($this->input->post('passwordnew')).')',FALSE);
			$this->db->where('UserID',$userID);
			$this->db->update('user');
			return true;
		}
		return false;
	}
	//op修改密码
	function changePwd($userID=0)
	{
		if (intval($userID))
		{
			//check old password
			$this->db->where('UserID',$userID);
			$this->db->where('UserName',$_SESSION['opuser']);
			$this->db->where('PassWord',"password(".$this->db->escape($this->input->post('oldpassword')).")",FALSE);
			$this->db->from('user');
			if($this->db->count_all_results())
			{
				$this->db->set('Password','password('.$this->db->escape($this->input->post('passwordnew')).')',FALSE);
				$this->db->where('UserID',$userID);
				$this->db->update('user');
				return true;
			}
		}
		return false;
	}
	//清除用户长时间的非法退出
	function clearLoginOut()
	{
		$this->db->select('UserID,Extend1');
		$this->db->where('Extend1 !=','');
		$query = $this->db->get('user');
		if($query->num_rows > 0)
		{
			$i = 0;
			$nowtimestamp = time();
			$tmp_session = session_id();
			foreach ($query->result() as $row)
			{
				$userinfo[$i]['userID'] = $row->UserID;
				$userinfo[$i]['userSessionID'] = $row->Extend1;

				if($userinfo[$i]['userID'] && $userinfo[$i]['userSessionID'])
				{
					session_id($userinfo[$i]['userSessionID']);
					@session_start();
					if (@$_SESSION['opuser'] && @$_SESSION['optimestamp'])
					{
						if ($nowtimestamp-$_SESSION['optimestamp']>3600)
						{
							$this->db->set('Extend1','');
							$this->db->where('UserID',$userinfo[$i]['userID']);
							$this->db->update('user');
							$_SESSION = array();
							session_destroy();
						}
					}
					else
					{
						$this->db->set('Extend1','');
						$this->db->where('UserID',$userinfo[$i]['userID']);
						$this->db->update('user');
						$_SESSION = array();
						session_destroy();
					}
				}
			}
			session_id($tmp_session);
		}
	}



/*
	company:sunrising
	name:sunguoan
	description:������֤�û��Ƿ���Ȩ�޵�¼ϵͳ
	*/
	//�û���½��֤
	function chkOpuserLogin($km) {
		//$query1 = $this->db->get_where('km_user', array('km' => $km), 1, 0);
		//$query2 = $this->db->get_where('user', array('KM' => $km), 1, 0);
		$this->db->select("*");
		$this->db->where('KM',$km);
		$query2=$this->db->get("user")->result_array();
//echo Information("-------------",$rs);
//echo Information("-------------",$query2);
//exit();
		//if ($query1!='' && $query2!= '') {
			if ( count($query2)>0) {
				
		if (count($query2)>0) {
			$i = 0;
			$nowtimestamp = time ();
			$userinfo=array();
			foreach ( $query2 as $row ) {				
				$userinfo [$i] ['userID'] = $row["UserID"];
				$userinfo [$i] ['userName'] = $row["UserName"];			
				$userinfo [$i] ['userSessionID'] = $row["Extend1"];
				$userinfo [$i] ['Dept'] = $row["Dept"];
				$userinfo [$i] ['Rid'] = $row["Rid"];
				$userinfo[$i]['Km'] = $row["Km"];	
				$i ++;
			}
			
			if ($userinfo [0] ['userID']) {
				if ($userinfo [0] ['userSessionID']) {
					session_id ( $userinfo [0] ['userSessionID'] );
				}
				@session_start ();
				if (@$_SESSION ['opuser'] && @$_SESSION ['optimestamp']) {
					if ($nowtimestamp - $_SESSION ['optimestamp'] > 1) {
						session_regenerate_id ( true );
						$_SESSION = array ();
					} else {
						session_regenerate_id ();
						$_SESSION = array ();
						session_destroy ();
						return 2;
					}
				}

				
					$this->db->set ( 'Extend1', session_id () );
					$this->db->where ( 'UserID', $userinfo [0] ['userID'] );
					$this->db->update ( 'user' );
					$_SESSION ['opuser'] = $userinfo [0] ['userName'];
					//邓雷添加,解决了用户通过综管系统登录后,终端控制时返回"服务器错误,用户已登录"错误.
					$_SESSION ['opuserPwd'] = ("1234");				
					$_SESSION ['opuserID'] = $userinfo [0] ['userID'];						
					$_SESSION ['optimestamp'] = $nowtimestamp;
					$_SESSION ['opctree'] = $this->getOldClientInfo ( $userinfo [0] ['userID'] );	
					$_SESSION ['Dept'] = $userinfo [0] ['Dept'];					
					$_SESSION ['Rid'] = $userinfo [0] ['Rid'];
					$_SESSION ['Km'] = $userinfo[0]['Km'];
				//echo Information("-------------",$_SESSION);
				return 3;
			}
		}
		session_regenerate_id ();
		$_SESSION = array ();
		@session_destroy ();
		return 1;
		//return $this->db->get('user');

		}else
			$outstr = "<script>alert('用户已经登录');</script>";

	}
	/************************************
	 *检测用户登陆的用户名和密码
	 ***********************************/
	function chkOpuserLogin21()
	{		
		$this->db->select('UserID,UserName,Extend1,Dept,Rid,Km');
		$this->db->where('UserName',$this->input->post('user'));
		$this->db->where('PassWord',"password(".$this->db->escape($this->input->post('pwd')).")",FALSE);	
		$query = $this->db->get('user');
		if($query->num_rows()>0)
		{
			$i=0;
			$nowtimestamp = time();
			foreach ($query->result() as $row)
			{
				$userinfo[$i]['userID'] = $row->UserID;
				$userinfo[$i]['userName'] = $row->UserName;						
				$userinfo[$i]['userSessionID'] = $row->Extend1;
				$userinfo[$i]['Dept'] = $row->Dept;	//部门		
				$userinfo[$i]['Rid'] = $row->Rid;//角色ID
				$userinfo[$i]['Km'] = $row->Km;	//可以删除不用
				$i++;
			}
			if($userinfo[0]['userID'])
			{
				if ($userinfo[0]['userSessionID'])
				{
					session_id($userinfo[0]['userSessionID']);
				}
				@session_start();
				if (@$_SESSION['opuser'] && @$_SESSION['optimestamp'])
				{
					if ($nowtimestamp-$_SESSION['optimestamp']<=120)
					{
						$_SESSION['optimestamp'] = $nowtimestamp;
						return 2;
					}
				}
				
				try{
				$this->db->set('Extend1',session_id());
				//throw new Exception($error);
				$this->db->where('UserID',$userinfo[0]['userID']);
				$this->db->update('user');
				$_SESSION['opuser'] = $userinfo[0]['userName'];
				$_SESSION['opuserPwd'] = $this->input->post('pwd');			
				$_SESSION['opuserID'] = $userinfo[0]['userID'];							
				$_SESSION['optimestamp'] = $nowtimestamp;
				$_SESSION['opctree'] = $this->getOldClientInfo($userinfo[0]['userID']);				
				$_SESSION['Dept'] = $userinfo[0]['Dept'];			
				$_SESSION['Rid'] = $userinfo[0]['Rid'];
				$_SESSION['Km'] = $userinfo[0]['Km'];
				//用于客户端获取当前登录的用户
				//sssetcookie('sharpi_userName',$userinfo[0]['userName'],time()+7200);
				}catch (Exception $e){echo 'e:'.$e->getMessage();}
				return 3;
			}
		}
		session_regenerate_id();
		$_SESSION = array();
		@session_destroy();
		return 1;
		//return $this->db->get('user');
	}

		function chkOpuserLogin2()
	{		
		$this->db->select('UserID,UserName,Extend1,Dept,Rid,Km');
		$this->db->where('UserName',$this->input->post('user'));
		$this->db->where('PassWord',"password(".$this->db->escape($this->input->post('pwd')).")",FALSE);	
		$query = $this->db->get('user');
		if($query->num_rows()>0)
		{
			$i=0;
			$nowtimestamp = time();
			foreach ($query->result() as $row)
			{
				$userinfo[$i]['userID'] = $row->UserID;
				$userinfo[$i]['userName'] = $row->UserName;						
				$userinfo[$i]['userSessionID'] = $row->Extend1;
				$userinfo[$i]['Dept'] = $row->Dept;	//部门		
				$userinfo[$i]['Rid'] = $row->Rid;//角色ID
				$userinfo[$i]['Km'] = $row->Km;	//可以删除不用
				$i++;
			}
			if($userinfo[0]['userID'])
			{
				if ($userinfo[0]['userSessionID'])
				{
					session_id($userinfo[0]['userSessionID']);
				}
				@session_start();
				if (@$_SESSION['opuser'] && @$_SESSION['optimestamp'])
				{
					if ($nowtimestamp-$_SESSION['optimestamp']<=120)
					{
						$_SESSION['optimestamp'] = $nowtimestamp;
						return 2;
					}
				}
				
				try{
				$this->db->set('Extend1',session_id());
				//throw new Exception($error);
				$this->db->where('UserID',$userinfo[0]['userID']);
				$this->db->update('user');
				$_SESSION['opuser'] = $userinfo[0]['userName'];
				$_SESSION['opuserPwd'] = $this->input->post('pwd');			
				$_SESSION['opuserID'] = $userinfo[0]['userID'];							
				$_SESSION['optimestamp'] = $nowtimestamp;
				$_SESSION['opctree'] = $this->getOldClientInfo($userinfo[0]['userID']);				
				$_SESSION['Dept'] = $userinfo[0]['Dept'];			
				$_SESSION['Rid'] = $userinfo[0]['Rid'];
				$_SESSION['Km'] = $userinfo[0]['Km'];
				//用于客户端获取当前登录的用户
				//sssetcookie('sharpi_userName',$userinfo[0]['userName'],time()+7200);
				}catch (Exception $e){echo 'e:'.$e->getMessage();}
				return 3;
			}
		}
		session_regenerate_id();
		$_SESSION = array();
		@session_destroy();
		return 1;
		//return $this->db->get('user');
	}
	//用户登陆认证
	function ajaxLogin()
	{		
		$this->db->select('UserID,UserName,Extend1,Dept,Rid,Km');
		$this->db->where('UserName',$_POST["userName"]);
		$this->db->where('PassWord',"password(".$this->db->escape($_POST["userPw"]).")",FALSE);		
		$query = $this->db->get('user');
		
		if($query->num_rows()>0)
		{
			$i=0;
			$nowtimestamp = time();
			foreach ($query->result() as $row)
			{
				$userinfo[$i]['userID'] = $row->UserID;
				$userinfo[$i]['userName'] = $row->UserName;				
				$userinfo[$i]['userSessionID'] = $row->Extend1;
				$userinfo[$i]['Dept'] = $row->Dept;				
				$userinfo[$i]['Rid'] = $row->Rid;
				$userinfo[$i]['Km'] = $row->Km;
				$i++;
			}
			if($userinfo[0]['userID'])
			{
				if ($userinfo[0]['userSessionID'])
				{
					session_id($userinfo[0]['userSessionID']);
				}
				@session_start();
				if (@$_SESSION['opuser'] && @$_SESSION['optimestamp'])
				{
					if ($nowtimestamp-$_SESSION['optimestamp']>120)
					{
						session_regenerate_id(true);
						$_SESSION = array();
					}
					else
					{
						session_regenerate_id();
						$_SESSION = array();
						session_destroy();
						return 2;
					}
				}			
				try{
				$this->db->set('Extend1',session_id());				
				$this->db->where('UserID',$userinfo[0]['userID']);
				$this->db->update('user');
				$_SESSION['opuser'] = $userinfo[0]['userName'];					
				$_SESSION['password'] = $this->input->post('pwd');
				$_SESSION['opuserID'] = $userinfo[0]['userID'];				
				$_SESSION['optimestamp'] = $nowtimestamp;
				$_SESSION['opctree'] = $this->getOldClientInfo($userinfo[0]['userID']);
				$_SESSION['Dept'] = $userinfo[0]['Dept'];				
				$_SESSION['Rid'] = $userinfo[0]['Rid'];
				$_SESSION['Km'] = $userinfo[0]['Km'];
				
				}catch (Exception $e){echo 'e:'.$e->getMessage();}
				return 3;
			}
		}
		session_regenerate_id();
		$_SESSION = array();
		@session_destroy();
		return 1;
		//return $this->db->get('user');
	}
	//用户登出
	function loginOut()
	{
		//$this->session->sess_destroy();
		@session_start();
		if(!isset($_SESSION['opuserID']))
		{return true;}
		//$this->UserLog->loginLog('6','2','LoginOut','退出系统',1);
		$sessionName = session_name();
		$tmpID = $_SESSION['opuserID'];
		$_SESSION = array();
		
		if (session_destroy())
		{
			if ($tmpID)
			{
				$this->db->set('Extend1','');
				$this->db->where('UserID',$tmpID);
				$this->db->update('user');
			}
			if (isset($_COOKIE[$sessionName]))
			{
	    		@setcookie($sessionName, '', time()-42000, '/');
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}
	//检查用户登陆情况 登陆返回true
	function chkLogin()
	{
		@session_start();
		$nowtimestamp = time();
		if (@$_SESSION['opuser']!='')
		{
			if ($nowtimestamp-$_SESSION['optimestamp']>90)
				$_SESSION['optimestamp']=$nowtimestamp;
			return true;
		}
		else
		{
			return false;
		}
	}
	//检查认证码
	function chkVcode()
	{
		@session_start();
		if(isset($_SESSION['opcode']))
		{
			if ($_SESSION['opcode']==$this->input->post('chknumber'))
			{
				$_SESSION = array();
				session_destroy();
				return true;
			}
		}
		return false;
	}
	
/**
	★★★★★★★★★★★★★★★★★★★★★★★★★★★★
	★ new update	2010-12-15					 		  ★
	★													  ★
 	★★★★★★★★★★★★★★★★★★★★★★★★★★★★
***/		
	
	//根据KM 查询用户信息
	function getKmUser($km)
	{	
		$data = $this->getDeptSession();
		$sql = "";
		if($data[3] < 3)
		{
			$sql = "select * from km_user where km='".$km."'";
			$query = $this->db->query($sql);
			if($query->num_rows > 0)
			{
				return $query->result_array();			
			}
			else{ 	echo "null"; exit(0);	}
			
		}
		else
		{
			$sql = "select * from km_user where km='".$km."' and dept_2 in (select dept_2 from km_user where km = '".$data[1]."')";
			$query = $this->db->query($sql);
			if($query->num_rows > 0)
			{
				return $query->result_array();			
			}
			else{ 	echo "NO"; exit(0);	}
		}		
	}
	//获取所有用户终端组
	function getUserClientGroup(){
		$data = $this->getDeptSession();
		$sql = '';
		if($data[3] == 1){
			$sql = "select * from client_tree where isClient=0";
		}
		if($data[3] == 2){
			$sql = "select * from client_tree where isClient=0 and Extend1 != 'sa'";
		}
		if($data[3] == 3){
			$sql="select * from client_tree where isClient=0  and Extend1 in ('','$data[1]')";
		}	
		$query = $this->db->query($sql);
		if($query->num_rows > 0)
		{			
			return $query->result_array();			
		}
		else
		{ 
			echo "null"; exit(0);
		}
	}
	//根据Km 查询User表
	function getCheckUserKm($km){
		$sql = "select * from user where Km ='".$km."'";
		$query = $this->db->query($sql);
		if($query->num_rows > 0)
		{			
			return $query->result_array();			
		}
	}
	function getEditUserRole(){
		$data = $this->getDeptSession();
		$sql = '';
		if($data[0] == 1) //系统管理员 SA-> id=1;
		{
			$sql = "select * from role";
		}	
		elseif($data[3] == 2)// 市场部管理员 Rid =2 ;
		{
			$sql = "select * from role where r_id != 2";
		}
		else
		{
			$sql = "select * from role where r_id not in(2,3,22,23)";
		}
		$query = $this->db->query($sql);
		if($query->num_rows > 0){			
			return $query->result_array();			
	    }
	}
	//根据用户权限查询角色
	function getRole($title,$dept_2){	
		$data = $this->getDeptSession();
		$sql = '';
		
		if($dept_2 == '市场经营部'){
			if($title == 4){
				if($data[3] == 2)
					$sql = "select * from role where r_id in (4,5)";
				else
					$sql = "select * from role where r_id in (2,4,5)";
			}
			if($title == 3 || $title == 34){
				$sql = "select * from role where r_id in (5,23)";
			}
			if($title == 2 || $title == 24 || $title == 26){
				$sql = "select * from role where r_id in (5,22)";
			}
			if($title == 1){
				$sql = "select * from role where r_id in (5,22)";
			}
		}else{
			if($title == 4){
				if($data[3] == 3)
					$sql = "select * from role where r_id in (4,5)";
				else
					$sql = "select * from role where r_id in (3,4,5)";
			}
			if($title == 3 || $title == 34){
				$sql = "select * from role where r_id in (5,33)";
			}
			if($title == 2 || $title == 24 || $title == 26){
				$sql = "select * from role where r_id in (5,32)";
			}
			if($title == 1){
				$sql = "select * from role where r_id in (5,22)";
			}
		}	
		$query = $this->db->query($sql);
		if($query->num_rows > 0){			
			return $query->result_array();			
	    }else{ echo 'null';exit(0);}
	}
	//用户总数
	function getUserNumber1($condition='')
	{				
		$data = $this->getDeptSession();		
		$sql = "";
		if($data[3] == '1') //Sa
			$sql="select * from user where ".$condition;		
		else if($data[3] == '2') //市场部
		    $sql="select * from user where ".$condition." and Rid != 2";
		else  //其他部门		  
		    $sql="select * from user where Dept_2 = '".$data[2]."' and ".$condition." and km != '".$data[1]."'";
				
		return count($this->db->query($sql)->result_array());
	}
	function getEditIsCheck($dept,$Rid){		
		$sql = "select Km from user where Dept_2 = '$dept' and Rid = '$Rid' and IsCheck = '1'";		
		$rs=$this->db->query($sql)->result_array();		
		if($rs[0]['Km'] != ''){
			$sql_ = "update user set IsCheck = 0 where Km = '".$rs[0]['Km']."'";
			$query = $this->db->query($sql_);			
		}
	}
		//sga
	function getUserRid($userid){
		$sql = "select Rid from user where UserID = '".$userid."'";
		$query = $this->db->query($sql);
		if($query->num_rows > 0){			
			foreach ( $query->result () as $row ) {				
				$rid = $row->Rid;	
			}		
	    }
		return $rid;
	}
	function getRoleName($rid){
		$sql = "select r_name from role where r_id = '".$rid."'";
		$query = $this->db->query($sql);
		if($query->num_rows > 0){			
			foreach ( $query->result () as $row ) {				
				$rname = $row->r_name;	
			}		
	    }
		return $rname;
	}
		//检查用户名(ajax)
	function checkusername($userName='')
	{
		if($userName!='')
		{
			$query=$this->db->query("select UserID from user where UserName=".$this->db->escape($userName));
			return $query->num_rows();
		}
	}
	
	//判断是否为禁用用户
	function isdisplayuser($userID)
	{
		$userkm = array();
		if($userID!='')
		{
			$query=$this->db->query("select UserName,IsDisplay from user where UserID=".$this->db->escape($userID));

			if($query->num_rows>0){
				$i = 0;
				foreach($query->result() as $row){

					if($row->IsDisplay=='1')
					{
					    return $row->UserName;
					}
				}
			}
		}
		return "";
	}	
}
?>
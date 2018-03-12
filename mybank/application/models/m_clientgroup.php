<?php
class M_clientgroup extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}
	/****************************************
	* @name  m_getUserGroup
	* @version  通过用户ID获取用户的终端分组信息
	* @param  $UserID int 用户ID
	* @return  array 终端组
	* @author  2012年11月6日 10:50:08 by 莫波
	****************************************/

	function m_getUserGroup($UserID)
	{
		$clientInfo=array();
		$sql="SELECT TreeNodeSerialID as id, TreeNodeCode as code, Name as name from client_tree where TreeNodeSerialID in (select TreeNodeSerialID from user_client where UserID=".$UserID.") order by TreeNodeSerialID asc";
		$query=$this->db->query($sql);
		if($query->num_rows>0)
		{
			$i=0;
			foreach($query->result() as $row)
			{
				$clientInfo[$i]['text']=$row->name;
				$clientInfo[$i]['code']=$row->code;
				$clientInfo[$i]['id']=$row->id;
			//	$clientInfo[$i]=$row->TreeNodeCode;
				$i++;
			}
		}
		//sort($clientInfo);
		//echo "<pre>";
//		print_r($clientInfo);
//		echo "<pre>";
		return $clientInfo;
	}
	/****************************************
	* @name  m_getUserAllTreeInfo
	* @version  获取用户的终端分组下的所有分组信息
	* @param  $UserID int 用户ID
	* @return  array 终端组
	* @author 2012-11-6 11:11:01  by 莫波
	****************************************/
	function m_getUserAllTreeInfo($UserID)
	{
		$user_tree=array();
		$rs=$this->m_getUserGroup($UserID);
		if($rs[0]['code']=="0001")
		{
			$user_tree[0]=$rs[0];
			$user_tree[0]["children"]=$this->allClientTree($rs[0]['code'],1);
			$user_tree[0]["clients"]=$this->getChildsByCode($rs[0]['code'],1);
		}
		else
		{
			$user_tree=$rs;
			for($i=0,$n=count($rs); $i<$n; $i++)
			{
				$user_tree[$i]["children"]=$this->allClientTree($rs[$i]['code'],$rs[$i]['id']);
				$user_tree[0]["clients"]=$this->getChildsByCode($rs[$i]['code'],1);
			}
		}
//		echo "<pre>";
//		print_r($user_tree);
//		echo "<pre>";
//		exit();
		return $user_tree;
	}
	/****************************************
	* @name  allClientTree()
	* @version  通过节点标识符获取节点下面所有的子节点
	* @param  $item string 节点标示符 "0001"
	* @return  array 终端组
	* @author 2012-11-6 11:13:59  by 莫波
	****************************************/
	function allClientTree($item='',$parentId=""){
		
		$ClientTree=array();
		$i=0;
		if($item==''){
			$ClientTree[$i]['id']="1";
			$ClientTree[$i]['text']="Root";
			$ClientTree[$i]['code']="0001";
			//$ClientTree[$i]['TreeIsClient']="0";
			$ClientTree[$i]['children']=$this->allClientTree($ClientTree[$i]['code'],1);
			$ClientTree[$i]["clients"]=$this->getChildsByCode($ClientTree[$i]['code'],1);
		}
		else
		{
			
			$query=$this->getChildsByCode($item,0);
			
			if(count($query)){
				$ClientTree[$i]['clients']=$this->getChildsByCode($item,1);
				foreach($query as $k=>$v){
					
						$ClientTree[$i]['id']=$v["id"];
						$ClientTree[$i]['text']=$v["name"];
						$ClientTree[$i]['code']=$v["code"];
						$ClientTree[$i]['parentId']=$ClientTree[$i]['_parentId']=$parentId;
						$ClientTree[$i]['clients']=$this->getChildsByCode($v["code"],1);
						$ClientTree[$i]['children']=$this->allClientTree($v["code"],$v["id"]);
						$i++;
					
				}
			}

		}
		return $ClientTree;
	}
	
	function getUserClient($userId){
		$clients=array();
		$userClientGroup=$this->m_getUserGroup($userId);
		foreach($userClientGroup as $k=>$v){
			
			$result=$this->getAllChildsByCode($v["code"],1);
		    $clients=array_merge($clients,$result); 
		}
		return $result;
	}
	
	
	/****************************************
	* @name  allClientTree()
	* @version  通过节点标识符获取节点下面所有的子节点
	* @param  $code string 节点标示符 "0001", $type 节点类型 1 表示终端 0表示分组
	* @return  array 终端组
	* @author 2014-04-11 11:13:59  by 莫波
	****************************************/
	function getChildsByCode($code,$type){
		$len=(strlen($code)+4);
			$sql="select TreeNodeSerialID as id,Name as name,TreeNodeCode as code,IsClient from
			client_tree ";
			$sql.= "where IsClient=$type and    length(TreeNodeCode)=$len and TreeNodeCode like '$code%' order by TreeNodeSerialID";
			return $this->db->query($sql)->result_array();
	}
	function getAllChildsByCode($code,$type){
		
			$sql="select TreeNodeSerialID as id,Name as name,TreeNodeCode as code,IsClient from
			client_tree ";
			$sql.= "where IsClient=$type  and TreeNodeCode like '$code%' order by TreeNodeSerialID";
			return $this->db->query($sql)->result_array();
	}
		/****************************************
	* @name  createNewNodeCode()
	* @version  当在一个分组下放置一个新终端时候, 计算此终端的终端树节点code
	* @param  $NodeCode string 节点标示符 "0001"
	* @return  string 节点code
	* @author 2014-04-22 11:13:59  by 莫波
	****************************************/
	function createNewNodeCode($NodeCode){
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
	function createGroupTreeNodeCode($treeNodeCode){
		$selfLen=strlen($treeNodeCode);
		$fatherLen=$selfLen-4;
		$sqlstr="SELECT * from client_tree ".
				" WHERE length(TreeNodeCode)=$selfLen".
				" GROUP BY TreeNodeCode desc LIMIT 1";
		$queryMax=$this->db->query($sqlstr)->result_array();
		if (count($queryMax)>0){
			$res=$queryMax[0];
			//echo  $res['TreeNodeCode'];
			$num=$res['TreeNodeCode']+1;
			//echo $num;
			return '000'.$num;
		} else {
			return $treeNodeCode.'0001';
		}

	}
	function createSubGroupTreeNodeCode($treeNodeCode){
		$len=strlen($treeNodeCode);
		$len=$len+4;
		$sqlstr="SELECT * from client_tree ".
				" WHERE TreeNodeCode like '$treeNodeCode%' and length(TreeNodeCode)=$len".
				" GROUP BY TreeNodeCode desc LIMIT 1";
		$queryMax=$this->db->query($sqlstr)->result_array();
		if (count($queryMax)>0){
			$res=$queryMax[0];
			return int($res['TreeNodeCode'])+1;
		} else {
			return $treeNodeCode.'0001';
		}

	}
	function addGroupTreeNodeCode($treeNodeCode,$name){
		$name=str_encode('inToDb',$name);
		 $group=array(
				"Name"=>$name,
				"TreeNodeCode"=>$treeNodeCode,
				"IsClient"=>'0',
				"Extend1"=>'',
				"Extend2"=>'0',
				"Extend3"=>'0',
				"Extend4"=>''
		);
		$this->add($group);
		return ($group);
	}
	function getByTreeNodeCode($treeNodeCode){
		$res=$this->get(array('treeNodeCode'=>$treeNodeCode));
		if (!is_bool($res)){
			return $res[0];
		}
		return false;
	}
	function isSameName($name){
		$res=$this->get(array('Name'=>$name));
		if (!is_bool($res)){
			return true;
		} else {
			return false;
		}
	}
	function isEmptyGroup($treeNodeCode){
		//判断是否为空的终端组对象记录组大于1时，即非本身外还存在子组或者终端
		$this->db->like('treeNodeCode',$treeNodeCode,'after');
		$res=$this->db->get("client_tree")->result_array();

		//$this->log->write_log("error",print_r($res));
		if (count($res)>1){
			return $res;
		} else {
			return true;
		}
	}
	function deleteByTreeNodeCode($treeNodeCode){
		return $this->delete(array('treeNodeCode'=>$treeNodeCode));
	}
	function deleteByTreeNodeSerialID($TreeNodeSerialID){
		return $this->delete(array('TreeNodeSerialID'=>$TreeNodeSerialID));
	}

	function add($info)
	{
		$data=array(
				"Name"=>$info["Name"],
				"TreeNodeCode"=>$info["TreeNodeCode"],
				"IsClient"=>$info["IsClient"],
				"Extend1"=>$info["Extend1"],
				"Extend2"=>$info["Extend2"],
				"Extend3"=>$info["Extend3"],
				"Extend4"=>$info["Extend4"]
		);
		$this->db->insert("client_tree",$data);
		$id= $this->db->insert_id();
		if ($id>0){
			return $id;
		}
		return false;
	}

	function get($where)
	{
		if(!empty($where))
		{
			foreach ($where as $k => $v)
			{
				$this->db->where($k,$v);
			}
		}
		//$this->db->limit(1);
		$res=$this->db->get("client_tree")->result_array();
		//print_r($where);
		if(count($res)>0){
			for ($i=0;$i<count($res);$i++){
				//$res[$i]['Name']=str_encode('formDb',$res[$i]['Name']);
			}
			return $res;
		}
		return false;
	}

	function delete($where)
	{
		if(!empty($where))
		{
			foreach ($where as $k => $v)
			{
				$this->db->where($k,$v);
			}
			$this->db->delete("client_tree");
		}
		if($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}

	function update($info,$where)
	{
		if(!empty($where))
		{
			foreach ($where as $k => $v)
			{
				$this->db->where($k,$v);
			}
			$data=array();
			if (!empty($info)){
				foreach ($info as $k => $v)
				{
					$data["$k"] = $v;
				}
			}
			$this->db->update('client_tree',$data);
		}
		if($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}

}
?>
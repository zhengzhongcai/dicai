<?php
class C_clientGroup extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_userLog','userLog');
		$this->load->model('m_clientGroup','m_group');
		$this->load->model('m_clientinfo','clientinfo');
		$this->load->model('m_userEntity','userEntity');
	}
	/****************************************
	* @name      treeNode
	* @version   
	* @param     $nodeArray array 
	* @return    
	* @author    2012-11-6 11:50:44 by 莫波
	****************************************/
	function treeNode($node,$parentId="")
	{
		if($parent!="")
		{
			//如果存在子节点	
			if(count($node["child"]))
			{
				foreach($node["child"] as $k=>$v)
				{
						
					$tree=$this->treeNode($v);
				}
			}
			
		}
		else {
			$tree=$this->treeNode($v);
		}
		
		return $tree;
		
	}
	function getGroup(){
		$clients=$this->m_group->getUserClient($this->userEntity->userID);
		$data=$this->m_group->m_getUserAllTreeInfo($this->userEntity->userID);
		$res=array(
		"total"=>1,
		"rows"=>$data,
		"clients"=>$clients
		);
		echo json_encode($res);
	}
	function view()
	{
		$this->load->view("v_clientGroup");
	}
	
	function moveClient()
	{	
		$groupCode=$this->input->post("groupCode");
		$clientCode=$this->input->post("clientCode");
		if($groupCode!=""&&$clientCode!=""){
			$newCode=$groupCode.($this->m_group->createNewNodeCode($groupCode));
			$this->db->where("TreeNodeCode",$clientCode);
			$this->db->set("TreeNodeCode",$newCode);
			$this->db->update("client_tree");
			if($this->db->affected_rows()){
				$res=$this->m_group->getByTreeNodeCode($newCode);
				//if (!is_bool($res)){}
				showInfo(true,$res);
			}
			else {
				showInfo(false,$newCode);
			}
		}
		
	}
	function deleteClient()
	{
		$TreeNodeSerialID=$this->input->post('treeNodeSerialID');
		if ($this->clientinfo->deleteByTreeNodeSerialID($TreeNodeSerialID) && $this->m_group->deleteByTreeNodeSerialID($TreeNodeSerialID)){
			showInfo(true,'');
			return;
		} else {
			showInfo(false,'');
			return;
		}
	}

	function addGroup()
	{
		$treeNodeCode=$this->input->post('treeNodeCode');
		$name=$this->input->post('name');
		if (isset($name)&&isset($treeNodeCode)){
		if ($this->m_group->isSameName($name)){
			showInfo(false,'','已存在的分组名称，请使用不一样的分组名称便于区分分组');
			return;
		}
		$newCode=$this->m_group->createGroupTreeNodeCode($treeNodeCode);
			//echo $newCode;
		$this->m_group->addGroupTreeNodeCode($newCode,$name);
			//echo $newCode;
			$res=$this->m_group->getByTreeNodeCode($newCode);

			showInfo(true,$res);
			return;
		}else {
			showInfo(false,'','缺失参数');
		}
	}
	function addSubGroup()
	{
		$treeNodeCode=$this->input->post('treeNodeCode');
		$name=$this->input->post('name');
		if (isset($name)&&isset($treeNodeCode)){
			if ($this->m_group->isSameName($name)){
				showInfo(false,'','已存在的分组名称，请使用不一样的分组名称便于区分分组');
				return;
			}
			$newCode=$this->m_group->createSubGroupTreeNodeCode($treeNodeCode);
			//echo $newCode;
			$this->m_group->addGroupTreeNodeCode($newCode,$name);
			//echo $newCode;
			$res=$this->m_group->getByTreeNodeCode($newCode);

			showInfo(true,$res);
			return;
		}else {
			showInfo(false,'','缺失参数');
		}
	}
	function moveGroup()
	{
	}
	function deleteGroup()
	{
		$treeNodeCode=$this->input->post('treeNodeCode');
		if ($treeNodeCode=='0001'){
			showInfo(false,'','root组不能删除');
			return;
		}
		$res=$this->m_group->isEmptyGroup($treeNodeCode);
		if (is_bool($res)){
			$this->m_group->deleteByTreeNodeCode($treeNodeCode);
			showInfo(true,'');
		} else  {
			showInfo(false,'','非空终端组不能删除');
		}
	}
}
?>
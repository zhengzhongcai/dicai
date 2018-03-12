<?php
class M_clientinfo extends CI_Model{
	function __construct(){
		parent::__construct();
		
	}

	function deleteByTreeNodeSerialID($TreeNodeSerialID){
		return $this->delete(array('TreeNodeSerialID'=>$TreeNodeSerialID));
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
		$this->db->limit(1);
		$res=$this->db->get("client_info")->result_array();
		//print_r($where);
		if(count($res)){
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
			$this->db->delete("client_info");
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
			$this->db->update('client_info',$data);
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmpdj extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_dmPDJ';
	}
	/*设备由AMS统一添加php不做添加
	 * function add($info)
	{
		$data=array(
				//"openid"=>$info["openid"],
				//"tokens"=>$info["tokens"]
		);
		$this->db->insert($this->_tableName,$data);
		$id= $this->db->insert_id();
		if ($id>0){
			return $id;
		}
		return false;
	}*/

	function isDevice($key){
		return $this->getOne(array('PDJ_mac'=>$key));
	}
	function has_JG($appKey,$info){
			if ($info['PDJ_sysno']<>'') {
				return $info;
			} else {
				return false;
			}
	}
	function clearSysno($keys){
		$this->db->where_in('PDJ_mac',$keys);
		$this->db->update($this->_tableName,array('PDJ_sysno'=>''));
		if($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}

	function updateSysno($key,$sysno){
		return $this->update(array('PDJ_sysno'=>$sysno),array('PDJ_mac'=>$key));
	}

	function getOne($where)
	{
		if(!empty($where))
		{
			$this->db->join('sys_orgrizetree','sys_orgrizetree.JG_ID=Sys_dmpdj.PDJ_sysno','LEFT');
			foreach ($where as $k => $v)
			{
				$this->db->where($k,$v);
			}
		}
		$this->db->limit(1);
		$res=$this->db->get($this->_tableName)->result_array();
		//print_r($where);
		if(count($res)){
			return $res[0];
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
		$res=$this->db->get($this->_tableName)->result_array();
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
			$this->db->delete($this->_tableName);
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
			$this->db->update($this->_tableName,$data);
		}
		if($this->db->affected_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
}// class
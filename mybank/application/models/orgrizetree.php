<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orgrizetree extends CI_Model {
	var $_tableName;
	function __construct()
	{
		parent::__construct();
		$this->_tableName = 'Sys_orgrizeTree';
	}
	
	// 获取银行机构结构树
	public function getOrgTree($authOrgStr = '')
	{
		if ($authOrgStr) $this->db->where("JG_ID in ({$authOrgStr})");
		$this->db->order_by('JG_ID', 'asc');
		$query = $this->db->get($this->_tableName);
		$ret = $query->result_array();
		
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($ret as $key=>$val){
			$ret[$key]['flag'] = 0;
			$refer[$val['JG_ID']] =& $ret[$key];
		}// for
		
		// 创建Tree
		$tree = array();
		$root = ' ';
		$jg='0';
		$child = '_child';
		foreach ($ret as $key=>$val){
			// 判断是否存在parent
			//if( $val['JG_ID']=='0101'){continue;}
			$parentId = $val['JG_PID'];
			/*if ($root === $parentId) {
				$ret[$key]['flag'] = 1;
				$tree[] =& $ret[$key];
			}*/

			if ($jg==$val['JG_ID']	){
				$ret[$key]['flag'] = 1;
				$tree[] =& $ret[$key];
			}else{
				if (isset($refer[$parentId])) {
					$refer[$parentId]['flag'] = 1;
					$parent =&$refer[$parentId];
					$parent[$child][] =& $ret[$key];
				}
			}// if
		}// for

		return $tree;
	}// func
	
	// 获取全部机构id
	public function getAllOrg()
	{
		$this->db->select("JG_ID");
		$this->db->group_by("JG_ID");
		$this->db->from($this->_tableName);
		$query = $this->db->get();
		$ret = $query->result_array();
		//$query=$this->db->query("select JG_ID from Sys_orgrizeTree");
	 //  $ret=$query->result_array();
		$jgArr = array();
		foreach ($ret as $row)
		{
			$jgArr[] = "'{$row['JG_ID']}'";
		}// for
	
		return implode(',', $jgArr);

	}// func
	public function model(){

	}

	public function  getOrgArr($JG){
			$this->db->order_by('JG_PID', 'asc');
			$query = $this->db->get('Sys_orgrizeTree');
			$res = $query->result_array();
			$ids=array();
			$ids[]=$JG;
			foreach ($res as $key => $val){
				$ff=$res[$key]['JG_PID'];
				$res2=preg_grep("/^$ff$/",$ids);
				if (count($res2)>0){
					$ids[]=$res[$key]['JG_ID'];
				}
			}
			return $ids;
	}
}// class
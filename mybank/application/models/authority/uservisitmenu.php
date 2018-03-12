<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uservisitmenu extends CI_Model
{
    var $_tableName;

    function __construct()
    {
        parent::__construct();
        $this->_tableName = 'system_uservisitmenu';
    }
    public function getfcodeid($orgid){
        $this->db->where('visit_roleid',$orgid);
        $query=$this->db->get($this->_tableName);
        $fcodeArr = $query->result_array();
        return $fcodeArr;
    }
    //获取权限ID
    public function getroleid($roleid){
        $query=$this->db->query("select menurole_id from $this->_tableName where visit_roleid=$roleid");
        $ret=$query->result_array();
        return $ret;

    }

}


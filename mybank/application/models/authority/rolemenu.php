<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolemenu extends CI_Model
{
    var $_tableName;

    function __construct()
    {
        parent::__construct();
        $this->_tableName = 'system_menu';
    }
    public function getRolemenu($roleid)
    {
        $query=$this->db->query("select a.*,b.visit_roleid from system_menu a left join system_uservisitmenu  b  on (b.menurole_id=a.menu_id and b.visit_roleid=$roleid)");
        $ret = $query->result_array();
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($ret as $key=>$val){
            $ret[$key]['flag'] = 0;
            $refer[$val['menu_id']] =& $ret[$key];
        }// for
        // 创建Tree
        $tree = array();
        $root = 0;
        $child = '_child';
        foreach ($ret as $key=>$val){
            // 判断是否存在parent
            $parentId = $val['menu_parentid'];
            if ($root ==$parentId) {
                $ret[$key]['flag'] = 1;
                $tree[] =& $ret[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $refer[$parentId]['flag'] = 1;
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $ret[$key];
                }
            }// if
        }// for

        return $tree;
    }// func
    public function getroleid($id){
        $query=$this->db->query("select * from system_uservisitmenu where visit_roleid=$id order by menurole_id asc");
        $ret=$query->result_array();
        return $ret;
    }
    public function getrolename($roleid){
           $query=$this->db->query("select menu_name,menu_id from system_menu where menu_id = $roleid ");
            $ret=$query->result_array();
             return $ret;
    }
}


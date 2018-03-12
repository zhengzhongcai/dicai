<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolename extends CI_Model
{
    var $_tableName;

    function __construct()
    {
        parent::__construct();
        $this->_tableName = 'system_role';
    }
public function del($roleid){
    $this->db->where('role_id',$roleid);
    $ret= $this->db->delete($this->_tableName);
    $this->db->where_in('visit_roleid',$roleid);
    $this->db->delete($this->_Muservisitmenu->_tableName);
    return 1;

}
}


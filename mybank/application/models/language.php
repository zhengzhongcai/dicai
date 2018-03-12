<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: 42902
 * Date: 2017/4/11
 * Time: 11:35
 */
class Language extends CI_Model{

    var $_tableName ;

    function  __construct(){
        parent::__construct();
        $this->_tableName='sys_language';
    }
    public function getstr(){
        $query=$this->db->query('select * from sys_language');
        $ret=$query->result_array();
        return $ret;
    }
    public function getvstr(){
        $query=$this->db->query('select * from sys_flanguage');
        $ret=$query->result_array();
        return $ret;
    }

}
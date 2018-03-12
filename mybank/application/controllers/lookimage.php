<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/10/11
 * Time: 16:03
 */
class Lookimage extends CI_Controller {



    function __construct()
    {



    }
    public function index(){

        echo "<img src='http://192.168.10.51:8082/dx1/application/tmp/portrait/02.jpg'/>";
    }
    public function aa(){

          $url=$this->_baseUrl; //http://192.168.10.51:8082/dx1
          $urlimg= $url."/".TMPPATH."portrait/"."02.jpg";
        echo "<img src='http://192.168.10.51:8082/dx1/application/tmp/portrait/02.jpg'/>";
        echo $urlimg;
    }

}
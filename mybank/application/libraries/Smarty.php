<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once BASEPATH.'libraries/Smarty/libs/Smarty.class.php';

class CI_Smarty extends Smarty {
        function __construct(){
          parent::__construct();
                $this->compile_dir = FCPATH . "application/views/templates_c";
                $this->template_dir = FCPATH . "application/views";
                $this->cache_dir = FCPATH . "application/views/cache";//����Ŀ¼
                //$this->caching = 1;
                //$this->cache_lifetime = 120; //�������ʱ��
                $this->debugging = false;
                $this->compile_check = true; // ��鵱ǰ��ģ���Ƿ����ϴα���󱻸��ģ�����������ˣ��������±����ģ�塣
                //$this->force_compile = true; // ǿ�����±���ģ��
                //$this->allow_php_templates= true; // ����PHPģ��
                $this->left_delimiter = "<{"; //�󶨽��
                $this->right_delimiter = "}>"; //�Ҷ����
        }
}

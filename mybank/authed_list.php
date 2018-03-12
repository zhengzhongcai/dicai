<?php

// 找出默认语言配置
$filename = dirname(__FILE__).'/lang/default.ini';
if (file_exists($filename)) $str = file_get_contents($filename);
else die('Not exists the default.ini file, please check.');
if (!trim($str)) die('Not set the default language, please check.');
// 加载默认语言
$filename = dirname(__FILE__).'/lang/'.$str.'/AUTHLIST.ini';
if (file_exists($filename))
{
	$fp = fopen($filename, 'r');
	while(!feof($fp))
	{
		$line = fgets($fp);
		if (!trim($line)) continue;
		$parts = explode('=', $line);
		$$parts[0] = trim($parts[1], "\"\r\n");
	}
}

$em_autheds = array();
$em_control_map = array();
/*
$em_autheds['monitor'] = '实时监控'; 
$em_control_map['monitor'] = 'monitor';

$em_autheds['report'] = '统计报表'; 
$em_control_map['report'] = 'statistic';

$em_autheds['report-f'] = '统计报表-业务流量统计';
$em_autheds['report-be'] = '统计报表-业务效率统计';
$em_autheds['report-a'] = '统计报表-评价统计';
$em_autheds['report-bld'] = '统计报表-办理等待时间统计';
$em_autheds['report-tbv'] = '统计报表-柜员业务量统计';
$em_autheds['report-tbe'] = '统计报表-柜员业务效率统计';
$em_autheds['report-ta'] = '统计报表-柜员评价统计';
$em_autheds['report-tabld'] = '统计报表-柜员办理等待时间统计';

$em_autheds['report-bfd'] = '统计报表-业务分布分析';
$em_autheds['report-bfdtr'] = '统计报表-业务趋势分析';
$em_autheds['report-ard'] = '统计报表-评价分布分析';
$em_autheds['report-ardtr'] = '统计报表-评价趋势分析';

$em_autheds['data'] = '数据管理'; 
$em_control_map['data'] = 'basedata';

$em_autheds['data-b'] = '数据管理-业务管理'; 
$em_autheds['data-t'] = '数据管理-柜员管理'; 
$em_autheds['data-c'] = '数据管理-柜台管理';
$em_autheds['data-v'] = '数据管理-VIP客户信息管理'; 
$em_autheds['data-p'] = '数据管理-公共参数管理'; 
$em_autheds['data-j'] = '数据管理-评价项目管理'; 

$em_autheds['organization'] = '机构管理'; 
$em_control_map['organization'] = 'institution';

$em_autheds['authority'] = '权限管理'; 
$em_control_map['authority'] = 'authority';

$em_autheds['authority-r'] = '权限管理-角色管理'; 
$em_autheds['authority-u'] = '权限管理-用户管理'; 
$em_autheds['authority-ul'] = '权限管理-用户使用日志管理'; 

$em_autheds['resource'] = '资源管理'; 
$em_control_map['resource'] = 'resource';

$em_autheds['resource-tpl'] = '资源管理-模板'; 
$em_autheds['resource-v'] = '资源管理-视频'; 
$em_autheds['resource-a'] = '资源管理-音频';
$em_autheds['resource-p'] = '资源管理-图片';
$em_autheds['resource-t'] = '资源管理-文字';  
$em_autheds['resource-c'] = '资源管理-新闻分类';
$em_autheds['resource-i'] = '资源管理-新闻条目'; 

$em_autheds['device'] = '设备管理'; 
$em_control_map['device'] = 'device';
*/

$em_autheds['monitor'] = $MON; 
$em_control_map['monitor'] = 'monitor';

$em_autheds['report'] = $REPORT; 
$em_control_map['report'] = 'statistic';

$em_autheds['report-f'] = $REPORT_F;
$em_autheds['report-be'] = $REPORT_BE;
$em_autheds['report-a'] = $REPORT_A;
$em_autheds['report-bld'] = $REPORT_BLD;
$em_autheds['report-tbv'] = $REPORT_TBV;
$em_autheds['report-tbe'] = $REPORT_TBE;
$em_autheds['report-ta'] = $REPORT_TA;
$em_autheds['report-tabld'] = $REPORT_TABLD;

$em_autheds['report-bfd'] = $REPORT_BFD;
$em_autheds['report-bfdtr'] = $REPORT_BFDTR;
$em_autheds['report-ard'] = $REPORT_ARD;
$em_autheds['report-ardtr'] = $REPORT_ARDTR;

$em_autheds['data'] = $DATA;
$em_control_map['data'] = 'basedata';

$em_autheds['data-b'] = $DATA_B; 
$em_autheds['data-t'] = $DATA_T; 
$em_autheds['data-c'] = $DATA_C;
$em_autheds['data-v'] = $DATA_V; 
$em_autheds['data-p'] = $DATA_P; 
$em_autheds['data-j'] = $DATA_J; 

$em_autheds['organization'] = $ORG; 
$em_control_map['organization'] = 'institution';

$em_autheds['authority'] = $AUTH; 
$em_control_map['authority'] = 'authority';

$em_autheds['authority-r'] = $AUTH_R; 
$em_autheds['authority-u'] = $AUTH_U; 
$em_autheds['authority-l'] = $AUTH_L; 
$em_autheds['authority-ul'] = $AUTH_UL; 

$em_autheds['resource'] = $RES; 
$em_control_map['resource'] = 'resource';

$em_autheds['resource-tpl'] = $RES_TPL; 
$em_autheds['resource-v'] = $RES_V; 
$em_autheds['resource-a'] = $RES_A;
$em_autheds['resource-p'] = $RES_P;
$em_autheds['resource-t'] = $RES_T;  
$em_autheds['resource-c'] = $RES_C;
$em_autheds['resource-i'] = $RES_I; 
$em_autheds['resource-ch'] = $RES_CH; 
$em_autheds['resource-cfg'] = $RES_CFG; 

$em_autheds['device'] = $DEVICE; 
$em_control_map['device'] = 'device';

$em_autheds['evalu'] = $EVALU; 
$em_control_map['evalu'] = 'evalu';
$em_autheds['evalu-l'] = $EVALU_L; 
$em_autheds['evalu-t'] = $EVALU_T; 

class AuthManager
{
    /*
    * 用法：
        // 初始化
        $authM = AuthManager.getInstance();
        $authM->setController($this); // $this的类型 为 Controller
        // 使用方法
        .......
    *
    */
    private static $instance;

    private $_em_autheds = array();
    private $controller;
    private $db;

    private function __construct()
    {
    }

    // getInstance method 
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->initAuthedList();
        }
        return self::$instance;
    }

    function initAuthedList()
    {
        global $em_autheds;
        $_em_autheds = array();
        foreach ($em_autheds as $k => $v) {
            $_em_autheds['id'][] = $k;
            $_em_autheds['name'][] = $v;
        }
        $this->_em_autheds = $_em_autheds;
    }

    public function getAuthedList()
    {
        return $this->_em_autheds;
    }

    public function setController($c)
    {
        $this->db = $c->db;
        $this->controller = $c;
        $this->loadModels();
    }

    function loadModels()
    {
        try {
            $this->controller->load->model('Userrole', '_Userrole');
        } catch (Exception $e) {
        }
        try {
            $this->controller->load->model('Rolefunc', '_Rolefunc');
        } catch (Exception $e) {
        }
        try {
            $this->controller->load->model('Roleopt', '_RoleOperation');
        } catch (Exception $e) {
        }
        try {
            $this->controller->load->model('Role', '_Role');
        } catch (Exception $e) {
        }
        try {
            $this->controller->load->model('User', '_User');
        } catch (Exception $e) {
        }
        try {
            $this->controller->load->model('UserAccessjg', '_UserAccessJG');
        } catch (Exception $e) {
        }
    }

    public function getControllerByFuncode($funcode)
    {
        global $em_control_map;
        return isset($em_control_map[$funcode]) ? $em_control_map[$funcode] : false;
    }

    /*
    * 检查用户是否有功能或者功能操作权限
    * $opid 默认是读权限，所有类型有：r--读、c--新建、u-->更新、d-->删除
    */
    public function hasAuthOnOperation($userid, $funcode, $opid = 'r')
    {
        $this->db->where('UID', $userid);
        $query = $this->db->get($this->controller->_Userrole->_tableName);
        $one = $query->row();
        if (empty($one)) return false; // 用户未关联角色，则认为没有权限
        $query = $this->db->query("select * from {$this->controller->_Rolefunc->_tableName} rf where rf.F_code='{$funcode}' and R_ID={$one->RID}");
        $ret = $query->row_array();
        if (empty($ret)) {
            return false; // 找不到权限记录，则认为没有权限
        }
        if (!(empty($opid) || $opid == 'r')) {
            // 需要对操作的权限继续进行判断
            $query = $this->db->query("select * from {$this->controller->_RoleOperation->_tableName} where RF_ID={$ret[0]['ID']} and Operation='{$opid}'");
            $ret = $query->row_array();
            if (empty($ret)) {
                return false; // 找不到权限记录，则认为没有权限
            }
        }
        return true; // 到此，认为用户有权限
    }

    /*
    * 获取角色列表
    * 
    */
    public function getRoleList()
    {
        try {
            $this->controller->load->model('Role', '_Role');
        } catch (Exception $e) {
        }
        $query = $this->db->query("select * from {$this->controller->_Role->_tableName} order by R_ID ASC");
        $ret = $query->row_array();
        $result = array();
        foreach ($ret as $row) {
            $result[] = array(
                'id' => $row['R_ID'], // 角色ID，用于删除、更新是传入的参数
                'name' => $row['R_name'], // 角色显示名称
                'lrtime' => $row['R_lrtime'], // 录入时间
                'lastuser' => $row['R_lastUser'], // 最后修改人的用户名
                'lasttime' => $row['R_lasttime'], // 最后修改时间
            );
        }
        return $result;
    }

    /*
    * 获取指定角色的所有功能操作权限
    * 
    */
    public function getAuthListOnRole($roleid)
    {
        global $em_autheds;

        $query = $this->db->query("select rf.* from {$this->controller->_Rolefunc->_tableName} rf where rf.R_ID={$roleid}");
        $ret = $query->result_array();
        $result = array();
        foreach ($ret as $row) {
            $query2 = $this->db->query("select ro.* from {$this->controller->_RoleOperation->_tableName} ro where ro.RF_ID={$row['ID']}");
            $ret2 = $query2->result_array();
            $ops = array('r');
            foreach ($ret2 as $row1) {
                if (!in_array($row1['Operation'], $ops)) {
                    $ops[] = $row1['Operation'];
                }
            }
            $result[$row['F_code']] = $ops; // 操作列
        }
        return $result;
    }

    /*
    * 增加角色
    * $funcodes_with_opids 的结构形如：
    *  array(
                '<功能代号>': array(
                        '<操作1>', '<操作2>'
                    )
            )
    */
    function addFuncCodes($roleid, $funcodes_with_opids = array(), $lastuser = '', $lruser = '')
    {
        global $em_autheds;

        foreach ($funcodes_with_opids as $funcode => $opids) {
            if (empty($em_autheds[$funcode])) continue;
            // 添加 角色功能权限表
            $this->db->where('R_ID', $roleid);
            $this->db->where('F_code', $funcode);
            $query = $this->db->get($this->controller->_Rolefunc->_tableName);
            $ret = $query->row_array();
            if (empty($ret)) { // 不存在则创建
                $info = array();
                $info['R_ID'] = $roleid;
                $info['F_code'] = $funcode;
                $info['R_lrtime'] = date('Y-m-d H:i:s');
                $info['R_lrUser'] = $lruser;
                $info['R_lasttime'] = date('Y-m-d H:i:s');
                $info['R_lastUser'] = $lastuser;
                $this->db->insert($this->controller->_Rolefunc->_tableName, $info);
                $query = $this->db->query("select max(ID) as ID from {$this->controller->_Rolefunc->_tableName}");
                $ret = $query->row_array();
                $rolefunid = $ret['ID'];
            } else { // 已经存在
                $rolefunid = $ret['ID'];
            }

            $this->db->delete($this->controller->_RoleOperation->_tableName, array('RF_ID' => $rolefunid));
            // 添加 角色操作权限表
            $insertArray = array();
            if (in_array('c', $opids)) {
                $insertArray = array(
                    'RF_ID' => $rolefunid,
                    'Operation' => 'c',
                    'lrtime' => date('Y-m-d H:i:s'),
                    'lrUser' => $lruser,
                    'lasttime' => date('Y-m-d H:i:s'),
                    'lastUser' => $lastuser,
                );
                $this->db->insert($this->controller->_RoleOperation->_tableName, $insertArray);
            }
            if (in_array('u', $opids)) {
                $insertArray = array(
                    'RF_ID' => $rolefunid,
                    'Operation' => 'u',
                    'lrtime' => date('Y-m-d H:i:s'),
                    'lrUser' => $lruser,
                    'lasttime' => date('Y-m-d H:i:s'),
                    'lastUser' => $lastuser,
                );
                $this->db->insert($this->controller->_RoleOperation->_tableName, $insertArray);
            }
            if (in_array('d', $opids)) {
                $insertArray = array(
                    'RF_ID' => $rolefunid,
                    'Operation' => 'd',
                    'lrtime' => date('Y-m-d H:i:s'),
                    'lrUser' => $lruser,
                    'lasttime' => date('Y-m-d H:i:s'),
                    'lastUser' => $lastuser,
                );
                $this->db->insert($this->controller->_RoleOperation->_tableName, $insertArray);
            }// if                
        }// for
    }

    /*
    * 增加角色
    * $funcodes_with_opids 的结构形如：
    *  array(
                '<功能代号>': array(
                        '<操作1>', '<操作2>'
                    )
            )
    */
    public function addRole($rolename, $funcodes_with_opids = array(), $lastuser = '', $lruser = '')
    {

        global $em_autheds;
        $query = $this->db->query("select * from {$this->controller->_Role->_tableName} rf where rf.R_name='{$rolename}'");
        $ret = $query->row_array();
        if ($ret) {
            return '该角色已存在，不能重复创建';
        }
        // 添加 角色表
        $info['R_name'] = $rolename;
        $info['R_lrtime'] = date('Y-m-d H:i:s');
        $info['R_lrUser'] = $lruser;
        $info['R_lasttime'] = date('Y-m-d H:i:s');
        $info['R_lastUser'] = $lastuser;
        $this->db->insert($this->controller->_Role->_tableName, $info);
        $query = $this->db->query("select max(R_ID) as ID from {$this->controller->_Role->_tableName}");
        $ret = $query->row_array();
        $roleid = $ret['ID'];
        $this->addFuncCodes($roleid, $funcodes_with_opids = $funcodes_with_opids, $lastuser = $lastuser, $lruser = $lruser);
        return $roleid;
    }
    //添加角色，及对应的权限
    public function addRole1($menu_id,$rolename){

      $info['role_name']=$rolename;
        $info['role_inputtime']=date('Y-m-d H:i:s');
       $query=$this->db->query("select * from system_role where role_name='$rolename'");
        $ret=$query->row_array();
        if($ret){
            return "该角色已经存在，不能重复创建";
        }
         $this->db->insert('system_role',$info);
         $query=$this->db->query("select max(role_id) as id  from system_role");
         $ret=$query->row_array();
        $roleid=$ret['id'];
        $arr=explode(',',$menu_id);
        $ret=array();
        foreach($arr as $key=>$val){
            if($val!=null) {
                $ret[]['menurole_id'] = $val;
                $ret[$key]['visit_roleid'] =$roleid;
            }
        };
     //   $this->db->insert_batch('system_uservisitmenu',$ret);
     return $ret;

    }


    /*
    * 删除角色
    */
    public function delRole($roleid)
    {
        $query = $this->db->query("select * from {$this->controller->_Userrole->_tableName} rf where  RID={$roleid}");
        $ret = $query->row_array();
        if ($ret) {
            return '请先删除用户与该角色的关联';
        }
        $this->db->query("delete from {$this->controller->_RoleOperation->_tableName} where RF_ID in ( select ID from {$this->controller->_Rolefunc->_tableName} rf where  R_ID={$roleid} )"); // 删除功能操作记录
        $this->db->query("delete from {$this->controller->_Rolefunc->_tableName} where  R_ID={$roleid} "); // 删除功能记录
        $this->db->where('R_ID', $roleid);
        $this->db->delete($this->controller->_Role->_tableName); // 删除角色记录
    }


    /*
    * 编辑角色，包括：名称、功能操作
    * 对比新旧两个操作集，<新-旧>的进行添加，<旧-新>的进行删除
    */
    public function updateRoleWithAuth($roleid, $rolename = null, $funcodes_with_opids = null, $lastuser = '', $lruser = '')
    {
        if ($rolename) {
            $info['R_name'] = $rolename;
            $this->db->update($this->controller->_Role->_tableName, $info, array('R_ID' => $roleid));
        }
        if (!is_array($funcodes_with_opids)) $funcodes_with_opids = array();
        $query = $this->db->query("select F_code from {$this->controller->_Rolefunc->_tableName} rf where R_ID={$roleid}");
        $ret = $query->result_array();
        $old_func_array = array();
        foreach ($ret as $row) {
            $old_func_array[] = $row['F_code'];
        }// for
        $new_func_array = array();
        foreach ($funcodes_with_opids as $func_code => $v) {
            $new_func_array[] = $func_code;
        }

        $to_deleted_array = array_diff($old_func_array, $new_func_array); // 被遗弃的角色功能
        $to_added_array = array_diff($new_func_array, $old_func_array); // 新增的角色功能
        foreach ($to_deleted_array as $k => $code) {
            $this->db->query("delete from {$this->controller->_RoleOperation->_tableName} where RF_ID in ( select ID from {$this->controller->_Rolefunc->_tableName} rf where  R_ID={$roleid} )");
            $this->db->delete($this->controller->_Rolefunc->_tableName, array('F_code' => $code, 'R_ID' => $roleid));
        }
        $to_added_funcodes_with_opids = array();
        foreach ($to_added_array as $func_code) {
            $to_added_funcodes_with_opids[$func_code] = $funcodes_with_opids[$func_code];
        }
        foreach ($funcodes_with_opids as $func_code => $val) {
            $to_added_funcodes_with_opids[$func_code] = $funcodes_with_opids[$func_code];
        }// for
        $this->addFuncCodes($roleid, $funcodes_with_opids = $to_added_funcodes_with_opids, $lastuser = $lastuser, $lruser = $lruser);

    }

    /*
    * 增加角色的功能操作权限
    * $opids  如果只传入$funcode而不传入$opids的话，默认只有读权限；允许一次传入一个array进来设置多个操作权限，譬如array('c', 'u', 'd')
    */
    public function addAuthOnRole($roleid, $funcode, $opids = 'r', $lastuser = '', $lruser = '')
    {
        if (!is_array($opids)) {
            $opids = array($opids);
        }
        $this->updateRoleWithAuth($roleid, $rolename = '', $funcodes_with_opids = array($funcode => $opids), $lastuser = $lastuser, $lruser = $lruser);
    }

    /*
    * 删除角色的功能权限
    *   $funcodes  为null时，表示删除所有功能权限；其余可以为字符串或者一个数组
    */
    public function delFunctionAuthOnRole($roleid, $funcodes = null)
    {
        $in_funcodes = '';
        if (is_array($funcodes)) {
            $in_funcodes = join(',', $funcodes);
        } else if (is_string($funcodes)) {
            $in_funcodes = "'{$funcodes}'";
        }
        if ($in_funcodes) {
            $in_funcodes = ' and F_code in (' . $in_funcodes . ')';
        }
        $this->db->query("delete from {$this->controller->_RoleOperation->_tableName} where RF_ID in ( select ID from {$this->controller->_Rolefunc->_tableName} rf where  R_ID={$roleid} {$in_funcodes} )"); // 删除功能操作记录

        if ($funcodes) // 删除功能记录
            $where_info = array('R_ID' => $roleid, 'F_code' => $funcodes);
        else
            $where_info = array('R_ID' => $roleid);
        $this->db->delete($this->controller->_Rolefunc->_tableName, $where_info);
    }

    /*
    * 删除角色的功能操作权限
    */
    public function delOperationAuthOnRole($roleid, $funcodes_with_opids)
    {
        foreach ($funcodes_with_opids as $funcode => $opids) {
            $opids_str = join(',', $opids);
            if ($opids_str) {
                $this->db->query("delete from {$this->controller->_RoleOperation->_tableName} where Operation in ({$opids_str}) and RF_ID in ( select ID from {$this->controller->_Rolefunc->_tableName} rf where  R_ID={$roleid} and F_code='{$funcode}' )"); // 删除功能操作记录
            }
        }
    }

    /*
    * 关联用户与角色
    */
    public function setRoleOnUser($roleid, $userid, $lruser = '', $lastuser = '')
    {
        $info['UID'] = $userid;
        $info['RID'] = $roleid;
        $query = $this->db->get($this->controller->_Userrole->_tableName, $info);
        $ret = $query->result_array();
        if (empty($ret)) {
            $info['lrtime'] = date('Y-m-d H:i:s');
            $info['lasttime'] = date('Y-m-d H:i:s');
            $info['lrUser'] = $lruser;
            $info['lastUser'] = $lastuser;
            $this->db->insert($this->controller->_Userrole->_tableName, $info);
        }
    }

    /*
    * 设置用户管辖的机构
    * 对比新旧两个机构集合，<新-旧>的进行添加，<旧-新>的进行删除
    * $orgids 为null或者空数组时，表示清掉所有机构管辖
    */
    public function setRuleAboutOrganizationOnUser($userid, $orgids, $lruser = '', $lastuser = '')
    {
        if ($orgids == null) $orgids = array();
        $query = $this->db->query("select * from {$this->controller->_UserAccessJG->_tableName} where UID={$userid}");
        $ret = $query->row_array();
        foreach ($ret as $row) {
            $old_func_array[] = $row['JG_ID'];
        }
        $to_deleted_array = array_diff($old_func_array, $orgids); // 被遗弃的机构关系
        $to_added_array = array_diff($orgids, $old_func_array); // 新增的机构关系
        $this->db->delete($this->controller->_UserAccessJG->_tableName, array('UID' => $userid, 'JG_ID' => $to_deleted_array));
        $insertArray = array();
        foreach ($to_deleted_array as $orgid) {
            $insertArray[] = array(
                'UID' => $userid,
                'JG_ID' => $orgid,
                'lrtime' => date('Y-m-d H:i:s'),
                'lrUser' => $lruser,
                'lasttime' => date('Y-m-d H:i:s'),
                'lastUser' => $lastuser,
            );
        }
        if ($insertArray)
            $this->db->insert_batch($this->controller->_UserAccessJG->_tableName, $insertArray);
    }

    /*
    * 追加用户管辖的机构
    */
    public function addRuleAboutOrganizationOnUser($userid, $orgid, $lruser = '', $lastuser = '')
    {
        $info = array();
        $info['UID'] = $userid;
        $info['JG_ID'] = $orgid;
        $info['lrtime'] = date('Y-m-d H:i:s');
        $info['lasttime'] = date('Y-m-d H:i:s');
        $info['lrUser'] = $lruser;
        $info['lastUser'] = $lastuser;
        $this->db->insert($this->controller->_UserAccessJG->_tableName, $info);
    }

    /*
    * 删除用户管辖的机构
    */
    public function deleteRuleAboutOrganizationOnUser($userid, $orgid)
    {
        $this->db->delete($this->controller->_UserAccessJG->_tableName, array('UID' => $userid, 'JG_ID' => $orgid));
    }

    /*
    * TODO: 读取用户管辖的机构
    * 
    */
    public function getRuleListAboutOrganizationOnUser($userid)
    {

        $query = $this->db->query("select JG_ID as orgid from {$this->controller->_UserAccessJG->_tableName} where UID={$userid}");
        $ret = $query->row_array();
        return $ret;
    }

    /*
    * TODO: 用户对特定的机构是否有管辖
    * 
    */
    public function hasRuleAboutOrganizationOnUser($userid, $orgid)
    {

        $query = $this->db->query("select * from {$this->controller->_UserAccessJG->_tableName} where UID={$userid} and JG_ID={$orgid}");
        $ret = $query->row_array();
        return !empty($ret);
    }

    public function P($arr)
    {
        echo "<pre>";
        print_r($arr);
    }

}

?>
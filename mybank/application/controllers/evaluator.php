<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Evaluator extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Newscate', '_Mcate');
		$this->load->model('Newsitem', '_Mitem');
		$this->load->model('Pfproject', '_Mpfproject');
		
		$this->load->model('Counter', '_Mcounter');
		$this->load->model('Server', '_Mserver');
		
		$this->load->model('Evalus', '_Mevalu');
		$this->load->model('Tpl', '_Mtpl');
		
		$this->load->model('Taskdetail', '_Mtaskdetail');
		
		$this->_baseUrl = $this->config->item('base_url');
	}
	
	// 获取评价项目信息
	public function getEvas(){
		$query = $this->db->get($this->_Mpfproject->_tableName);
		$ret = $query->result_array();
		$satisfy = array();
		$unsatisfy = array();
		
		foreach ($ret as $row){
			if ($row['PJ_WARNNING']) $unsatisfy[] = $row;
			else $satisfy[] = $row;
		}// for
		echo json_encode(array('satisfy'=>$satisfy, 'unsatisfy'=>$unsatisfy));
	}
	
	// 获取业务员信息
	public function getStaff()
	{
		//$_REQUEST['C_sysno'] = 1001;
		//$_REQUEST['C_no'] = 1;
		$sysno = $_REQUEST['C_sysno'];
		$no = $_REQUEST['C_no'];
		
		$this->db->where('C_sysno', $sysno);
		$this->db->where('C_no', $no);
		$query = $this->db->get($this->_Mcounter->_tableName);
		$ret = $query->row_array();
		
		$sno = $ret['C_sno'];
		$this->db->where('S_no', $sno);
		$query = $this->db->get($this->_Mserver->_tableName);
		$ret = $query->row_array();
		$parts = explode('/', $ret['S_photoPath']);
		$cnt = count($parts);
		$ret['S_photoPath'] = 'images/portrait/'.$parts[$cnt-1];
		
		$result=json_encode($ret);
		$callback=$_GET['callback'];
		echo $callback."($result)";
		//echo json_encode($ret);
	}
	
	// 提供心跳接口
	public function heartbeat(){
		if (!isset($_REQUEST['uuid']) || !isset($_REQUEST['package_version'])) die('缺少参数');
		
		$uuid = $_REQUEST['uuid'];
		$package_version = $_REQUEST['package_version'];
		$this->_publishUpdate($uuid, $package_version);
		 
		$filename = 'common_config';
		$config = file_get_contents($filename);
		$config = json_decode($config);
		
		$data = array(
				"action_hour" => "",
				"action_minute" => "",
				"package_url" => "",
				"package_version" => "",
				"device_id" => "",
				"csysno" => "",
				"cno" => "",
				"ad_time" => $config->toPublish
		);
		
		// 如果该设备尚未保存到数据库，则添加
		$this->db->where('E_series', $uuid);
		$query = $this->db->get($this->_Mevalu->_tableName);
		$ret = $query->row_array();
		if (!count($ret)) {
			$info = array();
			$info['E_series'] = $uuid;
			$this->db->insert($this->_Mevalu->_tableName, $info);
			// 同时保存在线临时文件
			$this->db->where('E_series', $uuid);
			$query = $this->db->get($this->_Mevalu->_tableName);
			$evalu = $query->row_array();
			$eid = $evalu['E_id'];
			
			$filename = ONLINEPATH.$eid;
			if (!file_exists($filename)) file_put_contents($filename, 1);
			
			$result['status'] = 0;
			$result['data'] = $data;
			$result['error_msg'] = '首次添加设备';
			echo json_encode($result);
			return;
		}else{
			// 更新设备信息包版本
			$info = array();
			$info['E_version'] = $package_version;
			$this->db->update($this->_Mevalu->_tableName, $info, array('E_series' => $uuid));
		}
		
		$filename = ONLINEPATH.$ret['E_id'];
		file_put_contents($filename, 1);
		
		// 检查设备是否已经禁用
		if (!$ret['E_isuse']){
			$result['status'] = 0;
			$result['error_msg'] = '该设备已经禁用';
			echo json_encode($result);
			return;
		}
		
		// 获取更新包信息
		if (!$ret['T_id']){
			$result['status'] = 0;
			$result['error_msg'] = '未设置评价器';
			echo json_encode($result);
			return;
		}
		
		// 检查是否有新的信息包更新任务
		$this->db->where('E_series', $uuid);
		$this->db->where('status', 0);
		$this->db->where('E_version > ', $package_version);
		$query = $this->db->get($this->_Mtaskdetail->_tableName);
		$tmp = $query->row_array();
		$is_task = count($tmp)? 1:0;
		$data['is_task'] = $is_task;
		
		// 是否已经设置了更新时间
		if ($is_task && $tmp['updatetime']){
			$parts = explode(':', $tmp['updatetime']);
			$data['action_hour'] = $parts[0]-0;
			$data['action_minute'] = $parts[1]-0;
		}
		
		// 找出是否有新的信息包版本
		$this->db->where('id', $ret['T_id']);
		$query = $this->db->get($this->_Mtpl->_tableName);
		$tpl = $query->row_array();
		
		if ($package_version <= $tpl['version']){
			$data['package_url'] = $this->_baseUrl.'/'.PACKPATH.'evalu_'.$tpl['version'].'.zip';
			$data['package_version'] = $tpl['version'];
		}
		
		$data['device_id'] = $ret['E_no'];
		$data['csysno'] = $ret['JG_ID'];
		$data['cno'] = $ret['C_no'];
		
		$result['status'] = 1;
		$result['data'] = $data;
		echo json_encode($result);	 
	}
	
	// 找出评价器的更新状态
	private function _publishUpdate($uuid, $version){
		$this->db->where('E_series', $uuid);
		$this->db->where('E_version', $version);
		$query = $this->db->get($this->_Mtaskdetail->_tableName);
		$ret = $query->row_array();
		$destVersion = isset($ret['E_version'])?$ret['E_version']:'';
		
		// 如果当前评价器信息包版本与要预设的版本一致，则更新成功
		if ($destVersion == $version){
			$info = array();
			$info['status'] = 1;
			$this->db->update($this->_Mtaskdetail->_tableName, $info, array('E_series'=>$uuid, 'E_version'=>$version));
		}
	}
	
	// 遍历评价器在线文件， 更新在线信息
	public function updateOnlineStatus(){
		$src = ONLINEPATH;
		$dir = opendir($src);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				$filename = $src.'/'.$file;
				$ctime = filemtime($filename);
				$now = time();
				//echo ($now - $ctime).'<br>';
				$status = 1;
				if ($now - $ctime > ONLINEHOLD) $status = 0;
				$info['E_status'] = $status;
				$this->db->update($this->_Mevalu->_tableName, $info, array('E_id'=>$file));
			}
		}
	}
	
	// 检查版本更新
	public function check_app_update(){
		$version = $_REQUEST['version'];
		$dir = APPPATH.'/apk';
		$fileArr = array();
		if (is_dir($dir)) {   
		   if ($dh = opendir($dir)) {   
		       while (($file = readdir($dh)) !== false) {   
			       if ($file!="." && $file!="..") {   
			       		$fileArr[] = $file;   
			       }   
		       }// while   
		       closedir($dh);   
		   }// if   
		}// if   
		
		$newVersion = '';
		sort($fileArr);
		foreach ($fileArr as $row){
			$parts = explode('_', $row);
			$parts = explode('.', $parts[1]);
			if ($parts[0] > $version) $newVersion = $row; 
		}
		
		$result = array();
		if ($newVersion == '') {
			$result['status'] = 0;
			$result['error_msg'] = '没有新的版本';
		}else{
			$result['status'] = 1;
			$result['title'] = '';
			$result['detail'] = '';
			$result['result'] = '';
			$result['url'] = $this->_baseUrl.'/application/apk/'.$newVersion;
		}
		
		echo json_encode($result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
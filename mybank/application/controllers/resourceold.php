<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__).'/../../authed_list.php');

class Resource extends CI_Controller {
	var $_userid;
	var $_roleId;
	function __construct()
	{
		parent::__construct();
		
		// 判断用户是否登录
		$sid = session_id();
		if(empty($sid)) session_start();
		$sid = session_id();
		$this->_userid = $_SESSION[$sid]['userid'];
		//$this->smarty->assign('auths', $_SESSION[$sid]['auths']);
		$this->_admin = $_SESSION[$sid]['username'];
		$this->smarty->assign('admin', $_SESSION[$sid]['username']);
		$this->smarty->assign('roleName', $_SESSION[$sid]['R_name']);
		$this->_roleId = $_SESSION[$sid]['RID'];
        
        $fcode = isset($_GET['fcode'])?$_GET['fcode']:'';
        $opid = isset($_GET['opid'])?$_GET['opid']:'';
		/*
        if($fcode){
            $authM = AuthManager::getInstance();
            $authM->setController($this); // $this的类型 为 Controller
            //echo $authM->hasAuthOnOperation($this->_userid, $fcode, $opid);
            if(!$authM->hasAuthOnOperation($this->_userid, $fcode, $opid)){
                $this->smarty->display('error/forbidden.html');
                exit;
            }
        }
		*/
		// 加载模型
        $this->load->model('Rolefunc', '_Mrolefunc');
        $this->load->model('Roleopt', '_Mroleopt');
        $this->load->model('User', '_Muser');
        
        $this->load->model('Res', '_Mres');
        $this->load->model('Tpl', '_Mtpl');
        $this->load->model('Newscate', '_Mcate');
        $this->load->model('Newsitem', '_Mitem');

		$this->load->model('authority/Rolemenu','_Mrolemenu');
		$this->load->model('authority/Uservisitmenu','_Muservisitmenu');
		$this->load->model('authority/Rolename','_Mrolename');
        
        $this->load->model('Adminlog', '_Madminlog');
        
        $this->load->model('Pfproject', '_Mpfproject');
		
		$this->_baseUrl = $this->config->item('base_url');
		$this->smarty->assign("baseUrl", $this->_baseUrl);

		$this->smarty->assign('roleId', $_SESSION[$sid]['RID']);
		
		$this->_resList = $this->config->item('res_list');
		$this->_resSuffix = $this->config->item('res_suffix');
		
		// 加载辅助函数
		$this->load->helper('common');
		$this->load->helper('upload');
		
		load_lang('COMMON', $this->smarty, $this);
		load_lang('RES', $this->smarty, $this);
		lang_list($this->smarty);
		
		// 控制器类型
		$this->smarty->assign('control', 'resource');
		
		// 获取用户功能权限数组
		//$fcodeArr = $this->_Mrolefunc->getFcodeByRoleId($this->_roleId);
		//$this->smarty->assign('fcodeArr', $fcodeArr);
		$fcodeArr=$this->_Muservisitmenu->getfcodeid($this->_roleId);
		$this->smarty->assign('fcodeArr', $fcodeArr);
		
		// 获取用户功能的操作权限
		// 根据用户角色和功能操作代码找出角色功能ID
		$fid = $this->_Mrolefunc->getFidByRoleIdAndFcode($this->_roleId, $fcode);
		// 根据功能id找出功能操作
		$optArr = $this->_Mroleopt->getOptByRfid($fid); 
		$this->smarty->assign('optArr', $optArr);
	}
	
	public function index()
	{	
		$this->resMananger();
	}// func
	
	// 模板列表
	public function tplList()
	{
		$this->smarty->assign('action', 'tplList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_tpl.html');
		$this->smarty->display('footer.html');
	}// func
	public function resMananger()
	{
		$this->smarty->assign('action', 'resMananger');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->load->view('resourceManage/fileManage');
		//$this->smarty->display('footer.html');
		$this->load->view('footer');
	}// func
	// 获取模板列表
	public function getTplList()
	{
		$query = $this->db->query("select a.*, b.username from {$this->_Mtpl->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID  order by a.create_time desc");
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 修改模板
	public function editTpl()
	{
		$tplid = isset($_GET['tplid'])?$_GET['tplid']:'';
		$rVideos = $rAudios = $rPics = $rTexts = array();
		$this->db->where('status', 1);
		$query = $this->db->get($this->_Mres->_tableName);
		$ret = $query->result_array();
		
		foreach ($ret as $row){
			switch ($row['type']){
				case '0':
					$rVideos[] = $row;
					break;
				case '1':
					$rAudios[] = $row;
					break;
				case '2':
					$rPics[] = $row;
					break;
				case '3':
					$rTexts[] = $row;
					break;
			}// switch
		}// for
		
		$this->smarty->assign('rVideos', $rVideos);
		$this->smarty->assign('rAudios', $rAudios);
		$this->smarty->assign('rPics', $rPics);
		$this->smarty->assign('rTexts', $rTexts);
		
		$this->smarty->assign('tplid', $tplid);
		
		$this->smarty->assign('action', 'tplList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/editTpl.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 保存模板
	public function storeTpl()
	{
		$tplName = $_POST['tpl_name'];
		$tplBg = $_POST['tpl_bg'];
		$version = $_POST['version'];
		$resolution = $_POST['resolution'];
		$areas = urlencode($_POST['areas']);
		$data = array(
				'tpl_name' => $tplName,
				'tpl_bg' => $tplBg,
				'version' => $version,
				'resolution' => $resolution,
				'areas' => $areas,
				'create_time' => date('Y-m-d H:i:s'),
				'usercode' => $this->_userid
				);
		
		// 添加到数据库
		$this->db->insert($this->_Mtpl->_tableName, $data);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加模板:{$tplName}");
	}// func
	
	// 修改模板
	public function updateTpl()
	{
		$tplid = $_POST['tplid'];
		$tplName = $_POST['tpl_name'];
		$tplBg = $_POST['tpl_bg'];
		$version = $_POST['version'];
		$resolution = $_POST['resolution'];
		$areas = urlencode($_POST['areas']);
		$data = array(
				'tpl_name' => $tplName,
				'tpl_bg' => $tplBg,
				'version' => $version,
				'resolution' => $resolution,
				'areas' => $areas,
				'status' => 0,
				'usercode' => $this->_userid
		);
	
		// 添加到数据库
		$this->db->update($this->_Mtpl->_tableName, $data, array('id'=>$tplid));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改模板:{$tplid}");
	}// func
	
	// 获取模板信息
	public function getTplInfo()
	{
		$tplid = $_POST['tplid'];
		$this->db->where('id', $tplid);
		$query = $this->db->get($this->_Mtpl->_tableName);
		$ret = $query->row_array();
		$ret['areas'] = urldecode($ret['areas']);
		echo json_encode($ret);
	}// func
	
	// 删除模板
	public function deleteTpl()
	{
		$tplids = $_POST['tplids'];
		$query = "delete from {$this->_Mtpl->_tableName} where id in ({$tplids})";
		$this->db->query($query);
		$this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "删除模板:{$query}");
	}// func
	
	// 导出模板
	public function exportTpl(){
		if (!class_exists('ZipArchive')){
			die('ZipArchive Class does not exist');
		}
		
		// 导出评价器的静态页面
		// 复制评价器模板
		$src = TMPPATH.'eva_tpl';
		$dst = TMPPATH.'evalu';
		
		if (file_exists($dst))recurse_delete($dst);
		recurse_copy($src, $dst);
		
		// 导出评价页面
		$this->_exportChoose();
		// 导出信息查询静态页
		$this->_exportIndex();
		// 导出感谢页面
		$this->_exportThanks();
		// 拷贝全部员工头像
		$src = TMPPATH.'portrait';
		$dst = TMPPATH.'evalu/images/portrait';
		recurse_copy($src, $dst);
		
		
		$tplid = $_GET['tplid'];
		$this->_tarTpl($tplid);
		
		// 获取版本号
		$this->db->where('id', $tplid);
		$query = $this->db->get($this->_Mtpl->_tableName);
		$ret = $query->row_array();
		
		$this->_Madminlog->add_log($this->_userid, "导出模板:{$tplid}");
		
		$version = $ret['version'];
		//exit;
		$filename = PACKPATH."evalu_{$version}.zip";
		chdir('../../');		
		header('Content-type: application/zip');
		header( "Content-Disposition: attachment; filename='evalu_{$version}.zip'" );
		readfile( $filename );
	}// func
	
	// 生成更新包
	public function genPackage(){
		if (!class_exists('ZipArchive')){
			die('ZipArchive Class does not exist');
		}
	
		// 导出评价器的静态页面
		// 复制评价器模板
		$src = TMPPATH.'eva_tpl';
		$dst = TMPPATH.'evalu';
	
		if (file_exists($dst))recurse_delete($dst);
		recurse_copy($src, $dst);
	
		// 导出评价页面
		$this->_exportChoose();
		// 导出信息查询静态页
		$this->_exportIndex();
		// 拷贝全部员工头像
		$src = TMPPATH.'portrait';
		$dst = TMPPATH.'evalu/images/portrait';
		recurse_copy($src, $dst);
	
	
		$tplid = $_POST['tplid'];
		$this->_tarTpl($tplid);
		
		$this->_Madminlog->add_log($this->_userid, "生成更新包:{$tplid}");
				
		// 获取版本号
		$this->db->where('id', $tplid);
		$query = $this->db->get($this->_Mtpl->_tableName);
		$ret = $query->row_array();
		$version = $ret['version'];
		//exit;
		$filename = PACKPATH."evalu_{$version}.zip";
		chdir('../../');
		if (file_exists($filename)) {
			$info = array();
			$info['status'] = 1;
			echo $this->db->update($this->_Mtpl->_tableName, $info, array('id' => $tplid));
		}else{
			echo 0;
		}
	}// func
	
	// 打包模板
	private function _tarTpl($tplid){
		$this->db->where('id', $tplid);
		$query = $this->db->get($this->_Mtpl->_tableName);
		$ret = $query->row_array();
		$areas = json_decode(urldecode($ret['areas']));
		$areaDiv = '';
		
		foreach ($areas as $row){
			$areaDiv .= $this->_generateArea($row);
		}// for
		$resolution = $ret['resolution'];
		$parts = explode('*', $resolution);
		$bodyStyle = "background:{$ret['tpl_bg']};position:absolute;margin:0;padding:0;top:0;bottom:0;right:0;left:0";
		$tpl = <<<TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
</head>
		
<body style="{$bodyStyle}">
	{$areaDiv}
</body>
</html>
TPL;
			file_put_contents(TMPPATH.'evalu/publish.html', $tpl);
			// 打包
			// 获取版本号
			$this->db->where('id', $tplid);
			$query = $this->db->get($this->_Mtpl->_tableName);
			$ret = $query->row_array();
			$version = $ret['version'];
	
			$zip = new ZipArchive();
			if ($zip->open(PACKPATH."evalu_{$version}.zip", ZipArchive::OVERWRITE) === TRUE) {
				chdir(TMPPATH);
				addFileToZip('evalu', $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
				$zip->close(); //关闭处理的zip文件
			}// if
	}// func
	
	// 生成模板
	public function generateTpl()
	{
		$areas = json_decode($_POST['areas']);
		$areaDiv = '';
		foreach ($areas as $row){
			$areaDiv .= $this->_generateArea($row);
		}// for
		$resolution = $_POST['resolution'];
		$parts = explode('*', $resolution);
		$bodyStyle = "background:black;position:absolute;margin:0;padding:0;top:0;bottom:0;right:0;left:0";
		$tpl = <<<TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
</head>

<body style="{$bodyStyle}">
	{$areaDiv}
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/publish.html', $tpl);
		echo $this->_baseUrl.'/application/tmp/evalu/publish.html';
	}// func
	
	// 生成区域模板
	private function _generateArea($area)
	{
		$uuid = uniqid();
		// 找出区块中资源的类型
		$resArr = $area->resArr;
		// 图片数组
		$photoArr = array();
		// 文本数组
		$text = '';
		
		$filename = 'common_config';
		$config = file_get_contents($filename);
		$config = json_decode($config);
		
		$pptpic = $config->pptpic * 1000;
		
		foreach ($resArr as $row){
			$this->db->where('id', $row->resid);
			$query = $this->db->get($this->_Mres->_tableName);
			$ret = $query->row_array();
			if (!count($ret)) return '';
			// 拷贝资源到临时目录
			$parts = explode('/', $ret['path']);
			$idx = count($parts)-1;
			switch($ret['type']){
				case '0':
					$dest = TMPPATH.'evalu/res/videos/'.$parts[$idx];
					break;
				case '1':
					$dest = TMPPATH.'evalu/res/audios/'.$parts[$idx];
					break;
				case '2':
					$dest = TMPPATH.'evalu/res/photos/'.$parts[$idx];
					$photoArr[] = './res/photos/'.$parts[$idx];
					break;
				case '3':
					$dest = TMPPATH.'evalu/res/texts/'.$parts[$idx];
					$text .= file_get_contents($ret['path']);
					break;
			}

			$source = $ret['path'];
			copy($source, $dest);
		}
		
		$photoStr = json_encode($photoArr);
		$photoHtml = '';
		$res = '';
		switch($ret['type']){
			case '0':
				//$res = "<video src='./res/dxy.mp4' style='top:{$area->top}px;left:{$area->left}px;width:{$area->width}px;height:{$area->height}px;'></video>";
				//$area->width = ceil($area->width * 800/715);
				//$area->height = ceil($area->height * 480/427);
				$res .= "<script>window.onload=function(){window.evaluator.setVideoView({$area->leftPer}, {$area->topPer}, {$area->widthPer}, {$area->heightPer}, 'dxy.mp4');}</script>";
				break;
			case '1':
				//$res = "<audio src='./res/{$parts[$idx]}' autoplay loop></audio>";
				break;
			case '2':
				$res = "<img id='{$uuid}' width='100%' height='100%' src=''>";
$photoHtml = <<<PHOTO
<script language =javascript >
var index{$uuid} = 0;
//时间间隔(单位毫秒)，每秒钟显示一张，数组共有5张图片放在Photos文件夹下。图片路径可以是绝对路径或者相对路径
var timeInterval={$pptpic}; //时间1秒
var arr{$uuid} = JSON.parse('{$photoStr}');

setInterval(fun{$uuid},timeInterval);
function fun{$uuid}()
{
    var obj = document.getElementById("{$uuid}");
    if (index{$uuid} == arr{$uuid}.length-1){
		index{$uuid} = 0;
    }else{
		index{$uuid} += 1;
    }
    obj.src = arr{$uuid}[index{$uuid}];
}
</script>
PHOTO;
				break;
			case '3':
				$res = "<marquee width='100%' height='100%' scrollamount='5' direction='right' style='color:#FFF;padding-top:20px;line-height:{$area->heightPer}%'>{$text}</marquee >";
				break;
		}// switch
		$areaHtml = <<<AREA
<div style="position:absolute;top:{$area->topPer}%;left:{$area->leftPer}%;width:{$area->widthPer}%;height:{$area->heightPer}%;">
	{$res}
</div>
{$photoHtml}
AREA;
		return $areaHtml;
	}// func
	
	// 视频列表
	public function videoList()
	{
		$this->smarty->assign('action', 'videoList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_video.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 音频列表
	public function audioList()
	{
		$this->smarty->assign('action', 'audioList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_audio.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 图片列表
	public function picList()
	{
		$this->smarty->assign('action', 'picList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_pic.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 文本列表
	public function textList()
	{
		$this->smarty->assign('action', 'textList');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_text.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 上传文件
	public function uploadRes()
	{
		// 上传资源
		$resType = $_POST['res_type'];
		// 构造封面保存位置
		$destPath = TMPPATH.'/';
		if (!file_exists($destPath)) mkdir($destPath, 0777);
		$fileName = $this->_userid;
		uploadFile($destPath, $fileName, $this->_resList[$resType]);
	}
	
	// 保存资源
	public function storeRes()
	{
		// 资源类型
		$resType = $_POST['res_type'];
		// 获取文件名
		$resName = $_POST['res_name'];
		// 查看资源文件大小
		$filename = TMPPATH.$this->_userid.'.'.$this->_resSuffix[$resType];
		// 检查是否有上传资源
		if (!file_exists($filename)){
			echo '未上传资源文件.';
			return;
		}
		// 构造文件路径
		$size = filesize($filename);
		
		// 移动资源文件
		$destPath = RESPATH.$resType.'/';
		$storename = uniqid().'.'.$this->_resSuffix[$resType];
		if (rename($filename, $destPath.$storename))
		{
			// 保存到数据库
			$data = array(
					'name' => $resName,
					'type' => $resType,
					'size' => fmtFileSize($size),
					'create_time' => date('Y-m-d H:i:s'),
					'usercode' => $this->_userid,
					'path' => $destPath.$storename
					);
			
			$this->db->insert($this->_Mres->_tableName, $data);
			echo $this->db->affected_rows();
		}
		else echo '保存失败.';
		
		$this->_Madminlog->add_log($this->_userid, "添加资源{$resType}:{$resName}");
	}// func
	
	// 删除资源
	public function deleteRes()
	{
		$resids = $_POST['resids'];
		$resArr = explode(',', $resids);
		foreach ($resArr as $row)
		{
			// 找出资源文件并删除
			$this->db->where('id', $row);
			$query = $this->db->get($this->_Mres->_tableName);
			$ret = $query->row_array();
			$path = $ret['path'];
			if (file_exists($path) && unlink($path)) $this->db->delete($this->_Mres->_tableName, array('id'=>$row));
		}// for
		
		$this->_Madminlog->add_log($this->_userid, "删除资源:{$resids}");
	}// func
	
	// 删除临时资源
	public function deleteTmpRes()
	{
		$filename = TMPPATH.$this->_userid.'.';
		@unlink($filename.'mp4');
		@unlink($filename.'mp3');
		@unlink($filename.'jpg');
		@unlink($filename.'txt');
		
		$this->_Madminlog->add_log($this->_userid, "删除临时资源");
	}
	
	// 获取资源列表
	public function getResList()
	{
		$resType = $_POST['res_type'];
		if ($resType === '')
			$query = $this->db->query("select a.*, b.username from {$this->_Mres->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID order by a.create_time desc");
		else
			$query = $this->db->query("select a.*, b.username from {$this->_Mres->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID where a.type = {$resType} order by a.create_time desc");
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	// 修改资源
	public function updateRes()
	{
		$resid = $_POST['resid'];
		// 资源类型
		$resType = $_POST['res_type'];
		// 获取文件名
		$resName = $_POST['res_name'];
		$data = array(
			'name' => $resName,
			'type' => $resType,
		);
		// 查看资源文件大小
		$filename = TMPPATH.$this->_userid.'.'.$this->_resSuffix[$resType];
		// 检查是否有上传资源
		if (file_exists($filename)){
			// 构造文件路径
			$size = filesize($filename);
			// 移动资源文件
			$destPath = RESPATH.$resType.'/';
			// 构造文件路径
			$storename = uniqid().'.'.$this->_resSuffix[$resType];
			rename($filename, $destPath.$storename);
			$data['size'] = fmtFileSize($size);
			$data['path'] = $destPath.$storename;
		}
		
		$this->db->update($this->_Mres->_tableName, $data, array('id'=>$resid));
		if ($this->db->affected_rows()) echo 1;
		else echo 0;
		
		$this->_Madminlog->add_log($this->_userid, "修改资源{$resType}:{$resid}");
	}// func
	
	// 获取单个资源信息
	public function getResInfo()
	{
		$resid = $_POST['resid'];
		$this->db->where('id', $resid);
		$query = $this->db->get($this->_Mres->_tableName);
		$ret = $query->row_array();
		echo json_encode($ret);
	}// func
	
	// 新闻分类列表
	public function newscate()
	{
		$this->smarty->assign('action', 'newscate');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_cate.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 获取分类列表
	public function getCateList()
	{
		$query = "select a.*, b.username from {$this->_Mcate->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID order by a.sortno asc, a.create_time desc";
		$query = $this->db->query($query);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 获取分类信息
	public function getNewscate()
	{
		$cateid = $_POST['cateid'];
		$this->db->where('id', $cateid);
		$query = $this->db->get($this->_Mcate->_tableName);
		$ret = $query->row_array();
		echo json_encode($ret);
	}// func
	
	// 编辑分类
	public function editCate()
	{
		$cateid = isset($_GET['cateid'])?$_GET['cateid']:'';
		$this->smarty->assign('cateid', $cateid);
		
		$this->smarty->assign('action', 'newscate');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/editCate.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 获取新闻分类上传图片
	public function uploadCateLogo()
	{
		// 构造封面保存位置
		$destPath = TMPPATH.'newscatelogo/';
		if (!file_exists($destPath)) mkdir($destPath, 0777);
		$fileName = $this->_userid;
		uploadFile($destPath, $fileName, 'pic');
		echo TMPPATH.'newscatelogo/'.$this->_userid.'.jpg';
	}// func
	
	// 添加分类
	public function storeCate()
	{
		$cateName = $_POST['catename'];
		$sortno = $_POST['sortno'];
		$filename = TMPPATH.'newscatelogo/'.$this->_userid.'.jpg';
		$dest = TMPPATH.'newscatelogo/'.uniqid().'.jpg';
		if (!file_exists($filename)) die('请上传分类图片.');

		if (rename($filename, $dest))
		{
			$data = array(
					'cate_name' => $cateName,
					'img_path' => $dest,
					'create_time' => date('Y-m-d H:i:s'),
					'usercode' => $this->_userid,
					'sortno' => $sortno
					);	
			
			$this->db->insert($this->_Mcate->_tableName, $data);
			echo $this->db->affected_rows();
		}
		else echo 0;
		
		$this->_Madminlog->add_log($this->_userid, "添加新闻分类:{$cateName}");
	}// func
	
	// 修改分类
	public function updateCate()
	{
		$cateid = $_POST['cateid'];
		$cateName = $_POST['catename'];
		$sortno = $_POST['sortno'];
		$data = array(
				'cate_name' => $cateName,
				'sortno' => $sortno
		);
		$filename = TMPPATH.'newscatelogo/'.$this->_userid.'.jpg';
		
		if (file_exists($filename))
		{
			$dest = TMPPATH.'newscatelogo/'.uniqid().'.jpg';
			rename($filename, $dest);
			
			$data['img_path'] = $dest;
		}		
		$this->db->update($this->_Mcate->_tableName, $data, array('id'=>$cateid));
		echo 1;
		
		$this->_Madminlog->add_log($this->_userid, "修改新闻分类:{$cateid}");
	}// func
	
	// 删除分类
	public function deleteCate()
	{
		$cateids = $_POST['cateids'];
		$cateArr = explode(',', $cateids);
		foreach ($cateArr as $row)
		{
			// 删除分类图片
			$query = $this->db->get($this->_Mcate->_tableName, array('id' => $row));
			$ret = $query->row_array();
			if (file_exists($ret['img_path'])) unlink($ret['img_path']);
			$this->db->delete($this->_Mcate->_tableName, array('id'=>$row));
		}// for
		
		$this->_Madminlog->add_log($this->_userid, "删除新闻分类:{$cateids}");
	}// func
	
	// 新闻条目列表
	public function newsItem()
	{
		$this->smarty->assign('action', 'newsitem');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_item.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 编辑条目
	public function editItem()
	{
		$itemid = isset($_GET['itemid'])?$_GET['itemid']:'';
		$this->smarty->assign('itemid', $itemid);
		
		$this->smarty->assign('action', 'newsitem');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/editItem.html');
		$this->smarty->display('footer.html');
	}// func
	
	// 添加新闻
	public function storeItem()
	{
		$itemname = $_POST['itemname'];
		$itemcont = $_POST['itemcont'];
		$sortno = $_POST['sortno'];
		$cateid = $_POST['cateid'];		
		$data = array(
				'item_name' => $itemname,
				'create_time' => date('Y-m-d H:i:s'),
				'usercode' => $this->_userid,
				'content' => $itemcont,
				'cateid' => $cateid,
				'sortno' => $sortno
				);
		
		$this->db->insert($this->_Mitem->_tableName, $data);
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "添加新闻:{$itemname}");
	}// func
	
	// 获取新闻条目列表
	public function getItemList()
	{
		$cateid = $_POST['cateid'];
		$where = '';
		if ($cateid) {
			$where = "where cateid = {$cateid}";
		}
		$query = "select a.*, b.username, c.cate_name from {$this->_Mitem->_tableName} a left join {$this->_Muser->_tableName} b on a.usercode = b.ID left join {$this->_Mcate->_tableName} c on a.cateid = c.id {$where} order by a.sortno asc, a.create_time desc";
		$query = $this->db->query($query);
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 删除新闻
	public function deleteItem()
	{
		$itemids = $_POST['itemids'];
		$itemArr = explode(',', $itemids);
		foreach ($itemArr as $row){
			$this->db->delete($this->_Mitem->_tableName, array('id' => $row));
		}// for
		
		$this->_Madminlog->add_log($this->_userid, "删除新闻:{$itemids}");
	}// func
	
	// 获取新闻详情
	public function getNewsItem()
	{
		$itemid = $_POST['itemid'];
		$this->db->where('id', $itemid);
		$query = $this->db->get($this->_Mitem->_tableName);
		$ret = $query->row_array();
		echo json_encode($ret);
	}// func
	
	// 修改新闻详情
	public function updateItem()
	{
		$itemid = $_POST['itemid'];
		$itemname = $_POST['itemname'];
		$itemcont = $_POST['itemcont'];
		$cateid = $_POST['cateid'];
		$sortno = $_POST['sortno'];
		$data = array(
				'item_name' => $itemname,
				'content' => $itemcont,
				'cateid' => $cateid,
				'sortno' => $sortno
		);
		
		$this->db->update($this->_Mitem->_tableName, $data, array('id' => $itemid));
		echo $this->db->affected_rows();
		
		$this->_Madminlog->add_log($this->_userid, "修改新闻:{$itemid}");
	}// func
	
	// 导出首页面
	private function _exportIndex()
	{
		$data = $this->_getCates();
		
		$tpl = <<<TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/style.css" rel="stylesheet">
</head>

<body>
	<div id="header"></div>
	<div id="content">
		<div id="menu">
			<ul></ul>
		</div>
	</div>
	<div id="footer">
		
		<a href="./evalu.html"><div class="evabtn"></div></a>
		
	</div>
	<script src="lib/jquery-1.7.2.min.js"></script>
	<script>
		window.onload = function(){
			var data = '{$data}';
			var cateObjs = JSON.parse(data);
			for (var idx in cateObjs){
				$('#menu > ul').append(generateCate(cateObjs[idx]));
			}// for
		}
		// 生成分类项
		function generateCate(cate){
			var liStr = '<li>'+
							'<a href="./pages/cate_'+cate.id+'.html">'+
								'<div class="menu_item">'+
									'<div class="item_icon"><img src="images/pages/'+cate.img_path+'" width="100%" height="100%"></div>'+
									'<div class="item_title">'+cate.cate_name+'</div>'+
								'</div>'+
							'</a>'+
						'</li>';
			return liStr;
		}
	</script>
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/index.html', $tpl);
	}// func
	
	// 导出列表页
	private function _exportList($cate)
	{
		$data = $this->_getItems($cate['id']);
		$data = urlencode($data);
		$tpl = <<< TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../css/style.css" rel="stylesheet">
	<link href="../css/scrollbar.css" rel="stylesheet">
</head>

<body>
	<div id="header"></div>
	<div id="content">
		<div style="height:15px"></div>
		<div id="intros">
			<div class="intro_head_bg"></div>
			<div class="title">{$cate['cate_name']}</div>
			<div id="list" class="list" style="position:absolute;">
				<div style="position:absolute;width:100%;">
					<ul></ul>
				</div>
			</div>
		</div>	
	</div>
	<div id="footer">
		<!--
		<a href="./evalu.html"><div class="evabtn"></div></a>
		-->
		<div class="homebtn" onclick="location.href='./../index.html'"></div>
		<div class="backbtn" onclick="history.go(-1)"></div>
	</div>
	<script src="../lib/jquery-1.7.2.min.js"></script>
	<script src="../lib/iscroll.js"></script>
	<script>		
		// 生成新闻条目
		function generateItem(item){
			var liStr = '<li>'+
							'<a href="./detail_'+item.id+'.html">'+
								'<div class="list_item">'+
									'<img src="../img/icon_li.png" height="10px"/>'+
									'<span>'+item.item_name+'</span>'+
								'</div>'+
							'</a>'+
						'</li>';
			return liStr;
		}// func
		window.onload = function(){
			var data = decodeURIComponent('{$data}');
			var items = JSON.parse(data);
			for (var idx in items) $('div.list > div > ul').append(generateItem(items[idx]));
			var mainScroll = new iScroll('list', { scrollbarClass: 'myScrollbar' });
		}
	</script>
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/pages/cate_'.$cate['id'].'.html', $tpl);
	}// func
	
	// 导出详细页
	private function _exportDetail($item)
	{
		$data = $this->_getItem($item);
		$data = urlencode($data);
		$tpl = <<< TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../css/style.css" rel="stylesheet">
	<link href="../css/scrollbar.css" rel="stylesheet">
</head>

<body>
	<div id="header"></div>
	<div id="content">
		<div style="height:15px"></div>
		<div id="detail">
			<div class="intro_head_bg"></div>
			<div class="title"></div>
			<div id="desc" class="desc" style="position:relative;">
				<div style="position:absolute;width:100%;">
				
				</div>
			</div>
		</div>	
	</div>
	<div id="footer">
		<!--
		<a href="./evalu.html"><div class="evabtn"></div></a>
		-->
		<div class="homebtn" onclick="location.href='./../index.html'"></div>
		<div class="backbtn" onclick="history.go(-1)"></div>
	</div>
	<script src="../lib/jquery-1.7.2.min.js"></script>
	<script src="../lib/iscroll.js"></script>
	<script>
		window.onload = function(){
			var data = decodeURIComponent(('{$data}' + '').replace(/\+/g, '%20'));
			var itemObj = JSON.parse(data);
			$('.title').html(itemObj.item_name);
			$('.desc > div').html(itemObj.content);
			var mainScroll = new iScroll('desc', { scrollbarClass: 'myScrollbar' });
		}
	</script>
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/pages/detail_'.$item['id'].'.html', $tpl);
	}// func
	
	// 导出感谢页面
	private function _exportThanks(){
		$filename = 'common_config';
		$config = file_get_contents($filename);
		$config = json_decode($config);
		$toSelect = $config->toSelect * 1000;
		
		$tpl = <<<TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/eva.css" rel="stylesheet">
</head>

<body>
	<div id="header">
		<img src="img/evaluate_title2.png">
	</div>
	<div id="content" style="height:320px;">
		<div id="thanks">
			<img src="img/text_3Q.png" style="margin-left:110px;margin-top:100px;" />
		</div>
	</div>
	<script src="lib/jquery-1.7.2.min.js"></script>
	<script>
		setInterval(function(){location.href="./index.html";window.evaluator.touchScreen();},{$toSelect});
	</script>
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/thanks.html', $tpl);
		
	}
	
	private function _getCates(){
		$this->db->order_by('sortno');
		$query = $this->db->get($this->_Mcate->_tableName);
		$ret = $query->result_array();
		// 把类型的图片放到相应的目录
		foreach ($ret as $key=>$row){
			// 拷贝图片
			$parts = explode('/', $row['img_path']);
			$len = count($parts);
			$filename = $parts[$len - 1];
			
			$source = $row['img_path'];
			$dest = TMPPATH.'evalu/images/pages/'.$filename;
			if (file_exists($dest)) @unlink($dest);
			copy($source, $dest);
			$row['img_path'] = $filename;
			$ret[$key] = $row;
			
			// 导出每个分类列表
			$this->_exportList($row);
		}// for
		return json_encode($ret);
	}
	
	private function _getItems($cateid){
		$this->db->where('cateid', $cateid);
		$this->db->order_by('sortno');
		$query = $this->db->get($this->_Mitem->_tableName);
		$ret = $query->result_array();
		
		foreach ($ret as $row){
			// 导出新闻详情页
			$this->_exportDetail($row);
		}
		return json_encode($ret);
	}
	
	private function _getItem($item){
		$itemid = $item['id'];
		$this->db->where('id', $itemid);
		$query = $this->db->get($this->_Mitem->_tableName);
		$ret = $query->row_array();
		// 修改文章的图片路径并拷贝图片
		$pattern = '/.*src="([^"]+)".*/';
		preg_match($pattern, $ret['content'], $matches);
		$len = strlen($this->_baseUrl);
		if (count($matches))
		{
			unset($matches[0]);
			foreach ($matches as $row);
			{
				$source = substr($row, $len+1);
				$parts = explode('/', $row);
				$cnt = count($parts);
				//$dest = TMPPATH.'evalu/images/news/'.$parts[$cnt-2].$parts[$cnt-1];
				$dest = TMPPATH.'evalu/images/news/'.$parts[$cnt-1];
				if (file_exists($dest)) unlink($dest);
				copy($source, $dest);
			}
		}// if
		$pattern = '/(.*src=")(.*\/)([\d.a-zA-Z]+)(".*)/';
		$replace = '\\1../images/news/\\3\\4';
		$ret['content'] = preg_replace($pattern, $replace, $ret['content']);
		return json_encode($ret);
	}// func
	
	// 导出评价页面
	private function _exportChoose()
	{
		$filename = 'common_config';
		$config = file_get_contents($filename);
		$config = json_decode($config);
		$toPublish = $config->toPublish * 1000;
		
		$data = $this->_getEvas();
		$tpl = <<< TPL
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
    <title>成都银行</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/eva.css" rel="stylesheet">
</head>

<body>
	<div id="header">
		<img src="img/evaluate_title2.png">
	</div>
	<div id="content">
		<div id="choose">
			<div class="pannel">
				<div class="name"></div>
				<div id="satisfy" class="itemlist"></div>
			</div>
			<div class="pannel" style="margin-top:40px;">
				<div class="name" style="background:url(img/evaluate_score_bad.png);background-size:105px 100px;"></div>
				<div id="unsatisfy" class="itemlist"></div>
			</div>
		</div>
	</div>
	<div id="footer">
		<img src="img/evaluate_foot_tips.png">
	</div>
	<script src="lib/jquery-1.7.2.min.js"></script>
	<script>
		window.onload = function(){
			var data = '{$data}';
			var evaObj = JSON.parse(data);
			$('#satisfy').html('');
			$('#unsatisfy').html('');
			
			for (var idx in evaObj.satisfy){
				$('#satisfy').append('<div class="evabtn" eva="'+evaObj.satisfy[idx].PJ_ID+'">'+evaObj.satisfy[idx].PJ_NAME+'</div>');
			}
			
			for (var idx in evaObj.unsatisfy){
				$('#unsatisfy').append('<div class="evabtn" eva="'+evaObj.unsatisfy[idx].PJ_ID+'">'+evaObj.unsatisfy[idx].PJ_NAME+'</div>');
			}
			
			// 通过串口发送评价信息 window.evaluator.choose(eva_val)
			$('.evabtn').click(function(){
				var eva_val = $(this).attr('eva');
				window.evaluator.choose(eva_val);
				location.href = "./thanks.html";
			});
			setInterval(function(){window.evaluator.choose(0);location.href="./publish.html";window.evaluator.touchScreen();},{$toPublish});
		}
	</script>
</body>
</html>
TPL;
		file_put_contents(TMPPATH.'evalu/choose.html', $tpl);
	}// func
	
	// 获取评价项目信息
	private function _getEvas(){
		$query = $this->db->get($this->_Mpfproject->_tableName);
		$ret = $query->result_array();
		$satisfy = array();
		$unsatisfy = array();
	
		foreach ($ret as $row){
			if ($row['PJ_WARNNING']) $unsatisfy[] = $row;
			else $satisfy[] = $row;
		}// for
		return json_encode(array('satisfy'=>$satisfy, 'unsatisfy'=>$unsatisfy));
	}// func

	// 资源审核
	public function rescheck(){
		$this->smarty->assign('action', 'rescheck');
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_check.html');
		$this->smarty->display('footer.html');
	}
	
	// 审核通过
	public function setcheck(){
		$resids = $_POST['resids'];
		$checktime = date('Y-m-d H:i:s', time());
		$sql = "update {$this->_Mres->_tableName} set status = 1, checktime = '{$checktime}', userid = {$this->_userid} where id in ({$resids})";
		echo $this->db->query($sql);
		
		$this->_Madminlog->add_log($this->_userid, "审核通过资源:{$resids}");
	}
	
	// 获取资源列表
	public function checkResList()
	{
		$resType = $_POST['res_type'];
		if ($resType === '')
			$query = $this->db->query("select a.*, b.username from {$this->_Mres->_tableName} a left join {$this->_Muser->_tableName} b on a.userid = b.ID order by a.create_time desc");
		else
			$query = $this->db->query("select a.*, b.username from {$this->_Mres->_tableName} a left join {$this->_Muser->_tableName} b on a.userid = b.ID where a.type = {$resType} order by a.create_time desc");
		$ret = $query->result_array();
		echo json_encode($ret);
	}// func
	
	// 预览资源
	public function checkRes(){
		$resid = $_REQUEST['resid'];
		
		$this->db->where('id', $resid);
		$query = $this->db->get($this->_Mres->_tableName);
		$ret = $query->row_array();
		
		if (!count($ret)) die('该资源已被删除.');
		
		$textStr = '';
		if ($ret['type'] == 3) $textStr = file_get_contents($ret['path']);
		
		$this->smarty->assign('textStr', $textStr);
		$this->smarty->assign('filepath', $ret['path']);
		$this->smarty->assign('filetype', $ret['type']);
		
		$this->smarty->display('resource/checkres.html');
	}
	
	// 添加文本
	public function addText(){
		$this->smarty->display('resource/add_text.html');
	}
	// 编辑文本
	public function editText(){
		$resid = $_GET['resid'];
		$this->db->where('id', $resid);
		$query = $this->db->get($this->_Mres->_tableName);
		$text = $query->row_array();
		$content = file_get_contents($text['path']);
		
		$this->smarty->assign('resid', $resid);
		$this->smarty->assign('title', $text['name']);
		$this->smarty->assign('content', $content);
		$this->smarty->display('resource/edit_text.html');
	}
	// 插入文本
	public function insertText(){
		$content = $_POST['content'];
		$title = $_POST['title'];
		
		$destPath = RESPATH.'3/';
		$storename = uniqid().'.txt';
		if (file_put_contents($destPath.$storename, $content)){
			$size = filesize($destPath.$storename);
			// 保存到数据库
			$data = array(
					'name' => $title,
					'type' => 3,
					'size' => fmtFileSize($size),
					'create_time' => date('Y-m-d H:i:s'),
					'usercode' => $this->_userid,
					'path' => $destPath.$storename
			);
				
			$this->db->insert($this->_Mres->_tableName, $data);
			
			$this->_Madminlog->add_log($this->_userid, "添加文本资源:{$title}");
			
			echo $this->db->affected_rows();
		}
		else echo '保存失败.';
	}
	
	// 修改文本
	public function updateText(){
		$resid = $_REQUEST['resid'];
		$content = $_REQUEST['content'];
		$title = $_REQUEST['title'];
		
		$this->db->where('id', $resid);
		$query = $this->db->get($this->_Mres->_tableName);
		$text = $query->row_array();
	
		if (file_put_contents($text['path'], $content)){
			$size = filesize($text['path']);
			// 保存到数据库
			$data = array(
					'name' => $title,
					'type' => 3,
					'size' => fmtFileSize($size),
					'create_time' => date('Y-m-d H:i:s'),
					'usercode' => $this->_userid
			);
	
			$this->db->update($this->_Mres->_tableName, $data, array('id'=>$resid));
			echo $this->db->affected_rows();
		}
		else echo '保存失败.';
		
		$this->_Madminlog->add_log($this->_userid, "修改文本资源:{$resid}");
	}
	
	// 总体配置
	public function commoncfg(){
		
		$filename = 'common_config';
		$config = file_get_contents($filename);
		$config = json_decode($config);
		
		$this->smarty->assign('action', 'commoncfg');
		$this->smarty->assign('config', $config);
		$this->smarty->display('header');
		$this->smarty->display('resource/lefter.html');
		$this->smarty->display('resource/righter_cfg.html');
		$this->smarty->display('footer.html');
	}
	
	// 保存配置
	public function storeCfg(){
		$config = array();
		$config['toPublish'] = $_POST['toPublish'];
		$config['toSelect'] = $_POST['toSelect'];
		$config['pptpic'] = $_POST['pptpic'];
		
		$filename = 'common_config';
		file_put_contents($filename, json_encode($config));
		
		// application\tmp\eva_tpl\audiores
		$path = APPPATH.'/tmp/eva_tpl/audiores';
		if (is_uploaded_file($_FILES['apprise']['tmp_name'])){
			@unlink($path.$_FILES['apprise']['name']);
			move_uploaded_file($_FILES['apprise']['tmp_name'], $path.'/'.$_FILES['apprise']['name']);
		}
		
		if (is_uploaded_file($_FILES['welcome']['tmp_name'])){
			@unlink($path.$_FILES['welcome']['name']);
			move_uploaded_file($_FILES['welcome']['tmp_name'], $path.'/'.$_FILES['welcome']['name']);
		}
		
		if (is_uploaded_file($_FILES['thanks']['tmp_name'])){
			@unlink($path.$_FILES['thanks']['name']);
			move_uploaded_file($_FILES['thanks']['tmp_name'], $path.'/'.$_FILES['thanks']['name']);
		}
		
		echo "<script>alert('保存成功')</script>";
		$this->commoncfg();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
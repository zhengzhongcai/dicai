<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generateOrgTree'))
{
	function generateOrgTree($tree, $opt, $isclick=true) {
		$str = "<ul>";
		foreach ($tree as $row)
		{
			$jg_name = $row['JG_name'];
			if(empty($jg_name)){
				$jg_name = '未知机构';
			}
			$str .= "<li>";
			if ($row['flag'])
			{
				if ($isclick)
					$str .= "<span class='folder'><a href='javascript:void(0);' onclick='checkOrginizationTree(\"{$row['JG_ID']}\",{$opt},this);'>{$jg_name}</a></span>";
				else 
					$str .= "<span class='folder'><a href='javascript:void(0)'>{$jg_name}</a></span>";

				if (isset($row['_child'])) {$str .= generateOrgTree($row['_child'], $opt, $isclick);}
			}
			else
			{
				$str .= "<span class='file'><a href='javascript:void(0);' onclick='checkOrginizationTree(\"{$row['JG_ID']}\",{$opt},this);'>{$jg_name}</a></span>";
			}
			$str .= "</li>";
		}// for
		$str .= "</ul>";
		return $str;
	}// func
}

if ( ! function_exists('generateOrgTreeCheck'))
{
	function generateOrgTreeCheck($tree, $checkArr = array()) {
		$str = "<ul>";
		foreach ($tree as $row)
		{
			$jg_name = $row['JG_name'];
			if(empty($jg_name)){
				$jg_name = '未知机构';
			}
			$str .= "<li>";
			if ($row['flag'])
			{
				if (in_array($row['JG_ID'], $checkArr))
					$str .= "<input type='checkbox' onchange='checkJgnode(this, \"{$row['JG_ID']}\")' checked name='org' value='{$row['JG_ID']}'>&nbsp;<span class='folder' style='display:inline-block;'>{$jg_name}</span>";
				else 
					$str .= "<input type='checkbox' onchange='checkJgnode(this, \"{$row['JG_ID']}\")' name='org' value='{$row['JG_ID']}'>&nbsp;<span class='folder' style='display:inline-block;'>{$jg_name}</span>";
				$str .= generateOrgTreeCheck($row['_child'], $checkArr);
			}
			else
			{
				if (in_array($row['JG_ID'], $checkArr))
					$str .= "<input type='checkbox' onchange='checkJgnode(this, \"{$row['JG_ID']}\")' checked name='org' value='{$row['JG_ID']}'>&nbsp;<span class='file' style='display:inline-block;'>{$jg_name}</span>";
				else
					$str .= "<input type='checkbox' onchange='checkJgnode(this, \"{$row['JG_ID']}\")' name='org' value='{$row['JG_ID']}'>&nbsp;<span class='file' style='display:inline-block;'>{$jg_name}</span>";
			}
			$str .= "</li>";
		}// for
		$str .= "</ul>";
		return $str;
	}// func
}

if ( ! function_exists('generateOrgTreeRadio'))
{
	function generateOrgTreeRadio($tree,$name, $checkArr = array()) {
		$str = "<ul>";
		foreach ($tree as $row)
		{
			$jg_name = $row['JG_name'];
			if(empty($jg_name)){
				$jg_name = '未知机构';
			}
			$str .= "<li>";
			if ($row['flag'])
			{
				if (in_array($row['JG_ID'], $checkArr))
					$str .= "<input type='radio'  name='{$name}' value='{$row['JG_ID']}'>&nbsp;<span class='folder' style='display:inline-block;'>{$jg_name}</span>";
				else
					$str .= "<input type='radio'  name='{$name}' value='{$row['JG_ID']}'>&nbsp;<span class='folder' style='display:inline-block;'>{$jg_name}</span>";
				$str .= generateOrgTreeRadio($row['_child'],$name, $checkArr);
			}
			else
			{
				if (in_array($row['JG_ID'], $checkArr))
					$str .= "<input type='radio'   name='{$name}' value='{$row['JG_ID']}'>&nbsp;<span class='file' style='display:inline-block;'>{$jg_name}</span>";
				else
					$str .= "<input type='radio'  name='{$name}' value='{$row['JG_ID']}'>&nbsp;<span class='file' style='display:inline-block;'>{$jg_name}</span>";
			}
			$str .= "</li>";
		}// for
		$str .= "</ul>";
		return $str;
	}// func
}

// -----------------------------------------------------
// 格式化时间字符串
if ( ! function_exists('formatTiemStr'))
{
	function formatTiemStr($second){
		$minute = 0;
		if ($second > 60)
		{
			$minute = round($second/60);
			$second = $second%60;
		}
		if ($minute)
			return "{$minute}分{$second}秒";
		else 
			return "{$second}秒";
	}// func
}

// -----------------------------------------------------
// 生成图表数据
if ( ! function_exists('generateChartData'))
{
	function generateChartData($data)
	{
		$theadArr = array();
		$tbodyArr = array();
		foreach ($data as $key=>$row)
		{
			$theadArr[] = $key;
			foreach ($row as $key=>$val)
			{
				$tbodyArr[$key][] = $val;
			}// for
		}// for
	
		$thead = "<thead><tr><td></td>";
		foreach ($theadArr as $row)
		{
			$thead .= "<th scope='col'>{$row}</th>";
		}// for
		$thead .= "</tr></thead>";
	
		$tbody = "<tbody>";
		foreach ($tbodyArr as $key=>$val)
		{
			$tbody .= "<tr><th scope='row'>{$key}</th>";
			foreach ($val as $row)
			{
				$tbody .= "<td>{$row}</td>";
			}// for
			$tbody .= "</tr>";
		}// for
		$tbody .= "</tbody>";
	
		return "<table  class='data' data-chart='line'>{$thead}{$tbody}</table>";
	}// func
}

// -----------------------------------------------------------------
// 日期时间
if ( ! function_exists('getDayTypeSelect'))
{
	function getDayTypeSelect($app)
	{
		$str = '<select name="year">';
		for($i=0;$i<10;$i++)
		{
			$str .= "<option value='".date('Y', strtotime("-{$i}years"))."'>".date('Y', strtotime("-{$i}years"))."</option>"; 
		}// for
		$str .= "</select>{$app->COMMON_YEAR}";
		
		$str .= '<select name="month">';
		for ($i=1;$i<13;$i++)
		{
			$selectStr = '';
			if ((int)date('m') == $i) $selectStr = 'selected';
			if (strlen($i) > 1)
				$str .= "<option value='".$i."' {$selectStr}>".$i."</option>";
			else
				$str .= "<option value='0".$i."' {$selectStr}>0".$i."</option>";
		}// for
		$str .= "</select>{$app->COMMON_MONTH}";
		$str .= '<select name="day">';
		for ($i=1;$i<32;$i++)
		{
			$selectStr = '';
			if ((int)date('d') == $i) $selectStr = 'selected';
			if (strlen($i) > 1)
				$str .= "<option value='".$i."' {$selectStr}>".$i."</option>";
			else
				$str .= "<option value='0".$i."' {$selectStr}>0".$i."</option>";
		}// for
		$str .= "</select>{$app->COMMON_DAY}";
		return $str;
	}// func
}// if

if ( ! function_exists('getMonthTypeSelect'))
{
	function getMonthTypeSelect($app)
	{
		$str = '<select name="year">';
		for($i=0;$i<5;$i++)
		{
			$str .= "<option value='".date('Y', strtotime("-{$i}years"))."'>".date('Y', strtotime("-{$i}years"))."</option>";
		}// for
		$str .= "</select>{$app->COMMON_YEAR}";
		
		$str .= '<select name="month">';
		for ($i=1;$i<13;$i++)
		{
			$selectStr = '';
			if ((int)date('m') == $i) $selectStr = 'selected';
			if (strlen($i) > 1)
				$str .= "<option value='".$i."' {$selectStr}>".$i."</option>";
			else
				$str .= "<option value='0".$i."' {$selectStr}>0".$i."</option>";
		}// for
		$str .= "</select>{$app->COMMON_MONTH}";
		return $str;
	}// func
}

if ( ! function_exists('getSeasonTypeSelect'))
{
	function getSeasonTypeSelect($app)
	{
		$str = '<select name="year">';
		for($i=0;$i<5;$i++)
		{
			$str .= "<option value='".date('Y', strtotime("-{$i}years"))."'>".date('Y', strtotime("-{$i}years"))."</option>";
		}// for
		$str .= "</select>{$app->COMMON_YEAR}";

		$str .= '<select name="season">';
		for ($i=1;$i<5;$i++)
		{
			if (strlen($i) > 1)
				$str .= "<option value='".$i."'>".$i."</option>";
			else
				$str .= "<option value='0".$i."'>0".$i."</option>";
		}// for
		$str .= "</select>{$app->COMMON_SEASON}";
		return $str;
	}// func
}

if ( ! function_exists('getYearTypeSelect'))
{
	function getYearTypeSelect($app)
	{
		$str = '<select name="year">';
		for($i=0;$i<10;$i++)
		{
			$str .= "<option value='".date('Y', strtotime("-{$i}years"))."'>".date('Y', strtotime("-{$i}years"))."</option>";
		}// for
		$str .= "</select>{$app->COMMON_YEAR}";
		return $str;
	}// func
}

// 根据季度获取日期起始点
if ( ! function_exists('season2datetimeStart'))
{
	function season2datetimeStart($season)
	{
		$parts = explode('-', $season);
		switch($parts[1]){
			case '01':
				return "{$parts[0]}-01-01 00:00:00";
				break;
			case '02':
				return "{$parts[0]}-04-01 00:00:00";
				break;
			case '03':
				return "{$parts[0]}-07-01 00:00:00";
				break;
			case '04':
				return "{$parts[0]}-10-01 00:00:00";
				break;
		}// switch
	}// func
}// if
// 根据季度获取日期结束点
if ( ! function_exists('season2datetimeEnd'))
{
	function season2datetimeEnd($season)
	{
		$parts = explode('-', $season);
		switch($parts[1]){
			case '01':
				return "{$parts[0]}-03-31 23:00:00";
				break;
			case '02':
				return "{$parts[0]}-06-30 23:00:00";
				break;
			case '03':
				return "{$parts[0]}-09-30 23:00:00";
				break;
			case '04':
				return "{$parts[0]}-12-31 23:00:00";
				break;
		}// switch
	}// func
}// if

if ( ! function_exists('formateStarttime'))
{
	function formateStarttime($type, $starttime)
	{
		switch ($type)
		{
			case 'day':
				return "{$starttime} 00:00:00";
				break;
			case 'month':
				return "{$starttime}-01 00:00:00";
				break;
			case 'season':
				return season2datetimeStart($starttime);
				break;
			case 'year':
				return "{$starttime}-01-01 00:00:00";
				break;
		}//switch
	}// func
}// if

if ( ! function_exists('formateEndtime'))
{
	function formateEndtime($type, $endtime)
	{
		switch ($type)
		{
			case 'day':
				return "{$endtime} 23:00:00";
				break;
			case 'month':
				$parts = explode('-', $endtime);
				$time = mktime(20,20,20,$parts[1],1,$parts[0]);//取得一个日期的 Unix 时间戳;
				return "{$endtime}-".date("t", $time)." 23:00:00";
				break;
			case 'season':
				return season2datetimeEnd($endtime);
				break;
			case 'year':
				return "{$endtime}-12-31 23:00:00";
				break;
		}//switch
	}// func
}// if

// ------------------------------------------------------------------
// 网点

// 获取机构的全部网点
if ( ! function_exists('getAllSpotFromJg'))
{
	function getAllSpotFromJg($tree)
	{
		$str = '';
		if (!count($tree)) return $str;
		foreach ($tree as $row)
		{
			if ($row['flag']) $str .= getAllSpotFromJg($row['_child']);
			else $str .= "'{$row['JG_ID']}',";
		}// for
		return $str;
	}// func
}// if

// 获取机构的子树
if ( ! function_exists('findSpotFromJg'))
{
	function findSpotFromJg($orgId, $tree)
	{
		foreach ($tree as $row)
		{
			if ($row['flag'])
			{
				if ($orgId != $row['JG_ID']) 
				{
					$returnArr = findSpotFromJg($orgId, $row['_child']);
					if (count($returnArr)) return $returnArr;
				}
				else return $row['_child'];
			}
			else if ($orgId == $row['JG_ID']) return array($row);
			else continue;
		}// for
	}// func
}

// -------------------------------------------------------------------
if ( ! function_exists('generateAuthList'))
{
	function generateAuthList($auths)
	{
		$tableStr = '<table style="margin:0px;">';
		$tableStr .= '<tr>'.
						'<th scope="row">角色名称:</th>'.
						'<td colspan="4"><input name="R_name" type="text" /></td>'.
					 '</tr>';
		foreach ($auths['id'] as $key=>$row)
		{
			$tableStr .= '<tr>'.
							'<th class="tr">'.$auths['name'][$key].':</th>'.
							'<td><input class="auth" type="checkbox" name="'.$row.'" value="r">查看</td>'.
							'<td><input class="auth" type="checkbox" name="'.$row.'" value="c">添加</td>'.
							'<td><input class="auth" type="checkbox" name="'.$row.'" value="u">修改</td>'.
							'<td><input class="auth" type="checkbox" name="'.$row.'" value="d">删除</td>'.
						 '</tr>';
		}// for
		$tableStr .= '</table>';
		return $tableStr;
	}// func
}// if

if ( ! function_exists('generateUpdateAuth'))
{
	function generateUpdateAuth($arr)
	{
		$rom='';
foreach($arr as $key=>$val){
	$rom=$arr;
}
		/*
		$tableStr = '<table style="margin:0px;">';
		$tableStr .= '<tr>'.
				'<th scope="row">'.$app->AUTH_RIGHTER_NAME.':</th>'.
				'<td colspan="4"><input name="R_name" type="text" value="'.$rname.'"/></td>'.
				'</tr>';
		foreach ($auths['id'] as $key=>$row)
		{
			$tableStr .= '<tr>'.
					'<th class="tr">'.$auths['name'][$key].':</th>';
			if (isset($authInfo[$row]) && in_array('r', $authInfo[$row]))
				$tableStr .= '<td><input class="auth" type="checkbox" checked name="'.$row.'" value="r">'.$app->COMMON_CHECK.'</td>';
			else
				$tableStr .= '<td><input class="auth" type="checkbox" name="'.$row.'" value="r">'.$app->COMMON_CHECK.'</td>';
			
			if (isset($authInfo[$row]) && in_array('c', $authInfo[$row]))
				$tableStr .= '<td><input class="auth" type="checkbox" checked name="'.$row.'" value="c">'.$app->COMMON_ADD.'</td>';
			else 
				$tableStr .= '<td><input class="auth" type="checkbox" name="'.$row.'" value="c">'.$app->COMMON_ADD.'</td>';
					
			if (isset($authInfo[$row]) && in_array('u', $authInfo[$row]))
				$tableStr .= '<td><input class="auth" type="checkbox" checked name="'.$row.'" value="u">'.$app->COMMON_BOX_CHANGE.'</td>';
			else
				$tableStr .= '<td><input class="auth" type="checkbox" name="'.$row.'" value="u">'.$app->COMMON_BOX_CHANGE.'</td>';
					
			if (isset($authInfo[$row]) && in_array('d', $authInfo[$row]))		
				$tableStr .= '<td><input class="auth" type="checkbox" checked name="'.$row.'" value="d">'.$app->COMMON_DEL.'</td>';
			else 
				$tableStr .= '<td><input class="auth" type="checkbox" name="'.$row.'" value="d">'.$app->COMMON_DEL.'</td>';
			
			$tableStr .= '</tr>';
		}// for
		$tableStr .= '</table>';
		return $tableStr;
		*/
		return $rom;
	}// func
}// if

// 去除业务括号
if ( ! function_exists('trimEnword'))
{
	function trimEnword($str)
	{
		// 根据英文括号去除
		$parts = explode('(', $str);
		// 根据中文括号去除
		$parts = explode('（', $parts[0]);
		return $parts[0];
	}// func
}// if

// 找出树的第一个子节点
if ( ! function_exists('findFirstNoe'))
{
	function findFirstNoe($orgTree){
		foreach ($orgTree as $row){
			if ($row['flag']) return findFirstNoe($row['_child']);
			else return $row['JG_ID'];
		}// for
	}// func
}// if

if ( ! function_exists('fmtFileSize'))
{
	function fmtFileSize($size){
		if($size >= pow(2,40)){
			$return= round($size/pow(1024,4),2);
			$suffix= 'TB';
		}
		elseif($size >= pow(2,30)){
			$return= round($size/pow(1024,3),2);
			$suffix= 'GB';
		}
		elseif($size >= pow(2,20)){
			$return= round($size/pow(1024,2),2);
			$suffix= 'MB';
		}
		elseif($size >= pow(2,10)){
			$return= round($size/pow(1024,1),2);
			$suffix= 'KB';
		}else{
			$return= $size;
			$suffix= 'Byte';
		}
		return $return.$suffix;
	}// func
}// if
if ( ! function_exists('addFileToZip'))
{
	function addFileToZip($path, $zip) {
		$handler = opendir($path); //打开当前文件夹由$path指定。
		/*
		 循环的读取文件夹下的所有文件和文件夹
		其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，
		为了不陷于死循环，所以还要让$filename !== false。
		一定要用!==，因为如果某个文件名如果叫'0'，或者某些被系统认为是代表false，用!=就会停止循环
		*/
		while (($filename = readdir($handler)) !== false) {
			if ($filename != "." && $filename != "..") {//文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if (is_dir($path . "/" . $filename)) {// 如果读取的某个对象是文件夹，则递归
					addFileToZip($path . "/" . $filename, $zip);
				} else { //将文件加入zip对象
					echo $path . "/" . $filename.'<br>';
					$zip->addFile($path . "/" . $filename);
				}
			}
		}
		@closedir($path);
	}// func
}

if ( ! function_exists('recurse_copy'))
{
	function recurse_copy($src,$dst) {  // 原目录，复制到的目录
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file,$dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}
}// if

if ( ! function_exists('recurse_delete'))
{
	function recurse_delete($dirName)
	{
		if(!is_dir($dirName)) {
			return false;
		}
		$handle = @opendir($dirName);
		while(($file = @readdir($handle)) !== false) {
			if($file != "." && $file != "..") {
				$dir = $dirName . "/" . $file;
				is_dir($dir) ? recurse_delete($dir) : @unlink($dir);
			}
		}
		closedir($handle);
		return rmdir($dirName);
	}
}// if

if ( ! function_exists('load_lang')){
	function load_lang($page, &$smarty, &$app){
		// 找出默认语言配置
		$filename = LANGPATH.'default.ini';
		if (file_exists($filename)) $str = file_get_contents($filename);
		else die('Not exists the default.ini file, please check.');
		if (!trim($str)) die('Not set the default language, please check.');
		// 加载默认语言
		$filename = LANGPATH.$str.'/'.$page.'.ini';
		if (file_exists($filename))
		{
			$fp = fopen($filename, 'r');
			while(!feof($fp))
			{
				$line = fgets($fp);
				if (!trim($line) || strpos($line, $page) != 0) continue;
				$parts = explode('=', $line);
				$smarty->assign($parts[0], trim($parts[1], "\"\r\n"));
				$app->{$parts[0]} = trim($parts[1], "\"\r\n");
			}
		}
	}// func
}

if ( ! function_exists('lang_list')){
	function lang_list(&$smarty){
		$filename = LANGPATH.'default.ini';
		if (file_exists($filename)) $default = file_get_contents($filename);
		
		$filename = LANGPATH.'lang_list.ini';
		if (file_exists($filename)) $str = file_get_contents($filename);
		else die('Not exists the language list file, please check.');
		
		if (!trim($str)) die('Not language options can be choose.');
		
		$fp = fopen($filename, 'r');
		while (!feof($fp))
		{
			$line = fgets($fp);
			if (!trim($line)) continue;
			$parts = explode('=', $line);
			
			$selected = '';
			if (trim($default, "\"\r\n") == $parts[0]) $selected = 'selected';
			
			$langList[] = array(
					'value' => $parts[0],
					'name' => trim($parts[1], "\"\r\n"),
					'selected' => $selected
					);
		}
		$smarty->assign('langList', $langList);
	}
}

if ( ! function_exists('set_lang')){
	function set_lang($val){
		$filename = LANGPATH.'default.ini';
		if (file_exists($filename)) unlink($filename);
		file_put_contents($filename, $val);
	}

}

if ( ! function_exists('P')){
	function P($arr){
		echo "<pre>";
		print_r($arr);
	}

}
if (! function_exists('showInfo')){
	function showInfo($state,$data,$info){
		echo json_encode(array(
		"state"=>$state
		,"data"=>$data
		,"info"=>$info
		));
	}
}


/* End of file table_helper.php */
/* Location: ./system/helpers/table_helper.php */


<?php
/**
grid排序
**/
require_once('../chkLogin.php');
header('Content-Type:text/html;charset=gb2312');
include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
$condition = '';
$ids = intval($_GET['ids']);
$otype = intval($_GET['order']);
$wfield = $_GET['field'];
function getfieldname($str){
	$arr = array('gcname'=>'name', 'gcstate'=>'state', 'gcsize'=>'FileSize', 'gctype'=>'type');
	if(@$arr[$str]){
		return $arr[$str];
	}
	return '';
}
if(getfieldname($wfield))
{
	$condition = ' order by `'.getfieldname($wfield).'`'.($otype?' ASC':' DESC');
}
if($ids){
	$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`=$ids".$condition;
}
else{
	$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`!=0".$condition;
}
$types = array('1'=>'视频', '2'=>'图片', '3'=>'文本', '4'=>'音频', '5'=>'动画', '6'=>'网页');
$res = $SqlDB->Query($sql);
$ostr = '';
if($SqlDB->getRowsNum($res) >= 1){
	$ostr .= '[';
	$sql_grid_rows=$SqlDB->getRows($res);
	foreach($sql_grid_rows as $v)
	{
		$k = $v['notes']?$v['notes']:"无";
		$ks = ($v['state']>1)?"审核驳回":($v['state']==1?"审核通过":"等待审核");
		//$tmp = iconv("utf-8","gb2312",$k);
		$ostr .= "{id:'".$v['PlayFileID']."',array:[{title:'".$v['PlayFileID']."'}, {title:'".$v['name']."'}, {title:'".$ks."'}, {title:'".$v['FileSize']."'}, {title:'".$types[$v['type']]."'}, {title:'".$k."'}]},";
	}
	$ostr = preg_replace("/\,$/","",$ostr);
	$ostr .= ']';
	echo $ostr;
}
else
{
	echo "[]";
}
?>
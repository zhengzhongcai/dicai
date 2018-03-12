<?php
/**
动态加载grid数据
添加分页功能(2010-4-20)
**/
require_once('../chkLogin.php');
header('Content-Type:text/html;charset=gb2312');
include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
//设定分页数据数
$pages = 18;
//取得grid类型
$ids = intval($_GET['ids']);
//取得当前页
$currentpage = intval($_GET['cp']);
if(!$currentpage){
	$currentpage = 1;
}
//取得分页数
if($ids){
	$sql = "select count(*) as num from `play_file_property` where `type`=$ids";
}
else{
	$sql = "select count(*) as num from `play_file_property` where `type`!=0";
}
$resnum = $SqlDB->Query($sql);
$anumber = $SqlDB->getRows($resnum);
$number = $anumber[0]['num'];
if($number){
	$pagenum = ceil($number/$pages); //分页数
	$limith = ($currentpage-1) * $pages;
	if($ids){
		$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`=$ids limit $limith,$pages";
	}
	else{
		$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`!=0 limit $limith,$pages";
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
		$pp  = ($currentpage>1)?$currentpage-1:1;
		$np  = ($currentpage+1<$pagenum)?$currentpage+1:$pagenum;
		$url = end(explode('/',$_SERVER['PHP_SELF']));
		echo '{"agc":'.$ostr.',"ps":{"pn":"'.$pagenum.'","pp":"'.$pp.'","np":"'.$np.'","cp":"'.$currentpage.'/'.$pagenum.'","url":"'.$url.'"}}';
	}
	else
	{
		//echo "[{array:[{title:' ', maxH:0}, {title: ' ', maxH:0}, {title:' ', maxH:0}, {title:' '}, {title:' '}, {title:' '}]}]";
		echo '{"agc":[],"ps":{"pn":"1","pp":"1","np":"1","cp":"1/1","url":" "}}';
	}
}
else
{
	echo '{"agc":[],"ps":{"pn":"1","pp":"1","np":"1","cp":"1/1","url":" "}}';
}


//echo "[{array:[{title:'1".$ids."'}, {title:'d2'}, {title:'d3'}, {title:'d4'}, {title:'d5'}]}";
//echo ",{array:[{title:'1".$ids."'}, {title:'d2'}, {title:'d3'}, {title:'d4'}, {title:'d5'}]}]";
?>
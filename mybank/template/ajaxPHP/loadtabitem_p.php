<?php
/**
��̬����grid����
��ӷ�ҳ����(2010-4-20)
**/
require_once('../chkLogin.php');
header('Content-Type:text/html;charset=gb2312');
include_once("../MySqlDateBase.class.php");
$SqlDB = new MySqlDateBase();
//�趨��ҳ������
$pages = 18;
//ȡ��grid����
$ids = intval($_GET['ids']);
//ȡ�õ�ǰҳ
$currentpage = intval($_GET['cp']);
if(!$currentpage){
	$currentpage = 1;
}
//ȡ�÷�ҳ��
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
	$pagenum = ceil($number/$pages); //��ҳ��
	$limith = ($currentpage-1) * $pages;
	if($ids){
		$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`=$ids limit $limith,$pages";
	}
	else{
		$sql = "select `PlayFileID`,`name`,`state`,`FileSize`,`type`,`notes` from `play_file_property` where `type`!=0 limit $limith,$pages";
	}
	$types = array('1'=>'��Ƶ', '2'=>'ͼƬ', '3'=>'�ı�', '4'=>'��Ƶ', '5'=>'����', '6'=>'��ҳ');
	$res = $SqlDB->Query($sql);
	$ostr = '';
	if($SqlDB->getRowsNum($res) >= 1){
		$ostr .= '[';
		$sql_grid_rows=$SqlDB->getRows($res);
		foreach($sql_grid_rows as $v)
		{
			$k = $v['notes']?$v['notes']:"��";
			$ks = ($v['state']>1)?"��˲���":($v['state']==1?"���ͨ��":"�ȴ����");
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
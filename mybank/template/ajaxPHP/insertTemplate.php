<?php

/*

模板总表 template
TemplateID 模版ID
TemplateName 模板名称
LengthScale----分辩率枚举值
AspectRatio----分辩率比例枚举值
TemplateType---模板类型(0=>X86,1=>em862,2=>NXP)
Extend1 ------模板背景

myajax.AddKey("TempID",temID); //模板ID
myajax.AddKey("Scale",fb);  //模板分辨率
myajax.AddKey("Type",ty); //模板类型
myajax.AddKey("bgImg",backGroundImg); //模板背景



模版组成表 template_describe

TemplateID 模版ID
BlockID	子区域ID
X 子区域X坐标
Y 子区域Y坐标
Width 子区域宽度
Heigth 子区域高度

*/
//模板信息

		include_once("../MySqlDateBase.class.php");
		$SqlDB = new MySqlDateBase();



//$TempID=$_POST["TempID"];//模板ID
$TempName=$_POST["TempName"];//模板名称
$Scale=$_POST["Scale"];//模板分辨率
//$Ratio=$_POST["Ratio"];//宽高比例
$Type=$_POST["Type"];//模板类型
$bgImg=$_POST["bgImg"];//模板背景

//子区域信息
$tempInfo=$_POST["areaInfo"];
$area=explode('_@@@_',$tempInfo);

//检查模板名是否重复
$sql = "select TemplateID from template where TemplateName='".$TempName."'";
$res = $SqlDB->Query($sql);
if($SqlDB->getRowsNum($res))
{
	echo $TempName."已存在!";
	$SqlDB->close();
	exit;
}

//添加 模板总表 template 信息

$sql="INSERT INTO template(TemplateName,LengthScale,TemplateType,Extend1) VALUES('".$TempName."',".$Scale.",".$Type.",'".$bgImg."')";
//echo $sql."\n";

if($SqlDB->Query($sql))
	{echo "模板信息添加成功\n";}
$id=$SqlDB->lastInsertId();
//echo "\n<br />".$id;
//插入子区域信息
for($i=0; $i<count($area);$i++)
{
	$itm=explode("_@_@_",$area[$i]);
	$sqll="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID) values(".$itm[3].",".$itm[4].",".$itm[1].",".$itm[2].",".$itm[0].",".$id.")";
	if($SqlDB->Query($sqll))
	{
		//echo $i."号区域添加成功\n";
	}
	//echo $sql."\n";
	
}


$SqlDB->Close();
//echo $tempInfo;
?>

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
		include_once("../templateClassEmue.php");
		$TemplateEmue=new TemplateEmue();

$TempName=$_POST["TempName"];//模板名称
$TempID=$_POST["TempID"];//模板ID
$Scale=$_POST["Scale"];//模板分辨率
$Type=$_POST["Type"];//模板类型
$bgImg=$_POST["bgImg"];//模板背景

//子区域信息
$tempInfo=$_POST["areaInfo"];
$area=explode('_@@@_',$tempInfo);

//更新 模板总表 template 信息
$sql="update template set TemplateName='".$TempName."',LengthScale=".$Scale.",TemplateType=".$Type.",Extend1='".$bgImg."' where TemplateID=".$TempID;
if($SqlDB->Query($sql))
	{echo "修改".$TempName."成功\n";}

//删除子区域信息
$sql="delete from template_describe where TemplateID=".$TempID;
if($SqlDB->Query($sql)){echo "删除子区域信息\n";}

//插入子区域信息
for($i=0; $i<count($area);$i++)
{
	$itm=explode("_@_@_",$area[$i]);
	//$sql="update template_describe set X=".$itm[3].",Y=".$itm[4].",Width=".$itm[1].",Height=".$itm[2]." where TemplateID=".$TempID." and BlockID=".$itm[0];
	$sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID) values(".$itm[3].",".$itm[4].",".$itm[1].",".$itm[2].",".$itm[0].",".$TempID.")";
	if($SqlDB->Query($sql))
	{echo "子区域".$i."修改成功\n";}
	
}

$SqlDB->Close();
//echo $tempInfo;
?>
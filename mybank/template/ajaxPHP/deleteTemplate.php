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

$TempID=$_POST["TempID"];//模板ID


//更新 模板总表 template 信息
$sql="delete from template where TemplateID=".$TempID;
if($SqlDB->Query($sql))
	{echo "删除".$TempName."成功\n";}

//删除子区域信息
$sql="delete from template_describe where TemplateID=".$TempID;
if($SqlDB->Query($sql)){echo "删除子区域信息\n";}
$SqlDB->Close();
?>
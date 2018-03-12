<?php

include_once("../readMode.php");
$t=new TemplateManagement();

//print_r($tt);


/*if(count($HTTP_POST_VARS)>0)
{
	foreach($HTTP_POST_VARS as $key => $value)
	{$$key=$value;}
}
else
{echo "no post value<br>";}
if(count($HTTP_GET_VARS)>0)
{
	foreach($HTTP_GET_VARS as $key => $value)
	{$$key=$value;}
}
else
{echo "no get value<br>";}*/
$TempID=$_POST["TempID"];
$bl=1;
$tmpInfo=$t->GetTempInfo($TempID);



echo "TempID:\"".$tmpInfo["TemplateID"]."\",";
echo "TempName:\"".$tmpInfo["TemplateName"]."\",";
echo "W:\"".$tmpInfo["F_Width"]."\",";
echo "H:\"".$tmpInfo["F_Height"]."\",";
echo "TempType:\"".$tmpInfo["TemplateType"]."\",";
if($tmpInfo["Extend1"]=="")
{echo "TempPic:\"0\"_@_@@_@_";}
else
{
	echo "TempPicPHP:\"".$tmpInfo["Extend1"]."\",";		//PHP下载图片是的路径
	echo "TempPic:\"http://".gethostbyname($_SERVER['SERVER_NAME'])."/CI/Material/".$tmpInfo["Extend1"]."\"_@_@@_@_";
}

$tt=$t->GetTemplate($TempID);
//$bl=0;//缩小比例
for($i=0;$i<count($tt);$i++)
{
	/*if($tt[$i][0]["F_Width"]<=1024)
	{
		$bl=$tt[$i][0]["F_Height"]/360;
	}
	else
	{*/	 //}
	$w=$tt[$i][0]["F_Width"]/$bl;
	$h=$tt[$i][0]["F_Height"]/$bl;
	for($a=1; $a<count($tt[$i]); $a++)
	{
		echo "<div id=\"".$tt[$i][$a]["BlockID"]."\" title=\"w:".$tt[$i][$a]["Width"].",h:".$tt[$i][$a]["Height"].",x:".$tt[$i][$a]["X"].",y:".$tt[$i][$a]["Y"]."\" style=\"position:absolute; background-color:green; border:0px solid; width:".(($tt[$i][$a]["Width"])/$bl)."px; height:".(($tt[$i][$a]["Height"])/$bl)."px; left:".(($tt[$i][$a]["X"])/$bl)."px; top:".(($tt[$i][$a]["Y"])/$bl)."px;\" onclick=\"itmClick(this);\" onmouseover=\"createCloseBar(this.id,event);\" onmouseout=\"deleteCloseBar(this.id);\" onmousedown=\"itemONmouseDown(this);\" onmouseup=\"itemONmouseUp(this);\" ></div>";
	}
}

?>
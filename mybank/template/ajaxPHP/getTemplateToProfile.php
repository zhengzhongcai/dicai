<?php
include_once("../readMode.php");
$t=new TemplateManagement();
$TempID=$_POST["TempID"];
//echo "my_Id__@@@_  ".$TempID."  _@@@______";

$bl=1;
$tmpInfo=$t->GetTempInfo($TempID);


echo "TempID:\"".$TempID."\",";
echo "TempName:\"".$tmpInfo["TemplateName"]."\",";
echo "W:\"".$tmpInfo["F_Width"]."\",";
echo "H:\"".$tmpInfo["F_Height"]."\",";
echo "TempType:\"".$tmpInfo["TemplateType"]."\",";
if($tmpInfo["Extend1"]=="")
{echo "TempPic:\"\",BgImageName:\"\"_@_@@_@_";}
else
{
	$r=split("//",$tmpInfo["Extend1"]);
	//$np=split("@",$r[1]);
	//$name_password=$np[0];
    if(count($r)>1)
    {
        $pathArray=split("/",$r[1]);
    }
	else
    {
        $pathArray=array($tmpInfo["Extend1"]);
    }
	$path="/";
	for($i=1; $i<count($pathArray); $i++)
	{
		$path.=$pathArray[$i]."/";
	}
	$path=substr($path,0,strlen($path)-1);
	$fname=$pathArray[count($pathArray)-1];
	echo"BgImageFullPath:\"".urlencode($tmpInfo["Extend1"])."\",";
	echo "BgImagePath:\"".$path."\",";
	echo "BgImageName:\"".$fname."\",";
	
	echo "TempPic:\"http://".gethostbyname($_SERVER['SERVER_NAME'])."/CI/Material/".$tmpInfo["Extend1"]."\"_@_@@_@_";
	}

$tt=$t->GetTemplate($TempID);

//$bl=0;//缩小比例

	$w=$tt["F_Width"]/$bl;
	$h=$tt["F_Height"]/$bl;
	$areas=$tt["areas"];
	for($a=0, $n=count($areas); $a<$n; $a++)
	{
		echo "<div id=\"".$areas[$a]["BlockID"]."\" areaType='".$areas[$a]["extend1"]."'  templateInfo=\"w:".$areas[$a]["Width"].",h:".$areas[$a]["Height"].",x:".$areas[$a]["X"].",y:".$areas[$a]["Y"]."\" position=\"'left':'".$areas[$a]["X"]."','top':'".$areas[$a]["Y"]."','width':'".$areas[$a]["Width"]."','height':'".$areas[$a]["Height"]."'\" style=\"position:absolute; background-color:green; border-style:dotted; border-width:1px; border-color:#FF0; width:".(($areas[$a]["Width"])/$bl)."px; height:".(($areas[$a]["Height"])/$bl)."px; left:".(($areas[$a]["X"])/$bl)."px; top:".(($areas[$a]["Y"])/$bl)."px;\" ></div>";
	}


?>
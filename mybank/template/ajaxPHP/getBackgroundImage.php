<?php

include_once("../CLASS/FileProperty.class.php");
$FileP = new FileProperty();
$flileList = $FileP->filecollect();
if(count($flileList)==0)
{
	echo "没有任何信息";
	exit();
}

function fileNameEncode($fileName)
{
	if (PHP_OS=="Linux")
	{
			return urlencode(utf8ToGb($fileName));
	}
	else
	{
		return urlencode($fileName);
	}


	
}

function utf8ToGb($str_string)
{
	return iconv("UTF-8","GBK",$str_string);
}

?>

<?php
foreach($flileList["Img"] as $key=>$itm)
{
	echo "<div  title='".$itm["fileName"]."' style=\"width:280px; height:27px; font-size:20px; border:0px solid #ccc; overflow:hidden; float:left; margin:10px 0px 0px 10px; text-align:left;cursor:pointer;\" id=\"bg_PICTURE".$key."\" mytitle=\"'fileType':'".$itm["fileType"]."','filePath':'".$itm["filePath"]."','fileFullPath':'".$itm["filePath"]."','fileSize':'".$itm["fileSize"]."','fileName':'".$itm["fileName"]."','myPath':'http://".gethostbyname($_SERVER['SERVER_NAME'])."/CI/Material/".fileNameEncode($itm["filePath"])."'\">".$itm["fileName"]."</div>";
	
	
}


?>



<?php
/*include_once("../CLASS/FTP.class.php");
$ftp=new FTP();
$flileList=$ftp->filecollect();
if(count($flileList)==0)
{
	echo "对不起,FTP服务器中没有文件.";
	exit();
}
$ftp->closeFTP();*/
/*echo "<pre>";
print_r($flileList);
echo "</pre>";*/
include_once("../CLASS/FileProperty.class.php");
$FileP = new FileProperty();
$flileList = $FileP->filecollect();
if(count($flileList)==0)
{
	echo "没有任何信息";
	exit();
}
?>

<!--div class="DragContainer TabbedPanelsContent" style="width:100%;display:block; border:0px red solid; float:left;  height:300px;" id="DragContainer_tupian" history="h_2">
<?php
/*foreach($flileList["Img"] as $key=>$itm)
{
	echo "<div class=\"DragBox\"   overClass=\"OverDragBox\" dragClass=\"DragDragBox\" id=\"PICTURE".$key."\" title=\"'fileType':'".$itm["fileType"]."','filePath':'".$itm["filePath"]."','fileFullPath':'".$itm["fileFullPath"]."','fileSize':'".$itm["fileSize"]."','fileName':'".urlencode($itm["fileName"])."','modifyDate':'".$itm["lastUpdateTime"]."'\">".$itm["fileName"]."</div>";
}*/
?>
</div-->
<div class="DragContainer TabbedPanelsContent" style="width:100%;display:block; border:0px red solid; float:left; height:300px; font-size:12px;" id="DragContainer_wenben" history="h_3">
<?php
if(isset($flileList["Txt"]))
{
	foreach($flileList["Txt"] as $key=>$itm)
	{
		echo "<div class=\"DragBox\"   overClass=\"OverDragBox\" dragClass=\"DragDragBox\" id=\"TEXT".$key."\" title=\"'playTime':'0','fileType':'".$itm["fileType"]."','filePath':'".$itm["filePath"]."','fileViewPath':'".$itm["fileViewPath"]."','fileSize':'".$itm["fileSize"]."','fileName':'".$itm["fileName"]."','modifyDate':'".$itm["lastUpdateTime"]."','filemd5':'".$itm["fileMD5"]."'\" >".$itm["fileName"]."</div>";
	}
}
?>
</div>

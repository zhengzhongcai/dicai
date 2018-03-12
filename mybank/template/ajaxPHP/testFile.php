<?php
include_once("../CLASS/FileProperty.class.php");
$FileP = new FileProperty();
$flileList = $FileP->filecollect();
if(count($flileList)==0)
{
	echo "没有任何信息";
	exit();
}

?>

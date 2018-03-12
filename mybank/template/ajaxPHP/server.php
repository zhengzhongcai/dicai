<?php
/*
 // Pull in the NuSOAP code
 require_once('nusoap.php');
 // Create the server instance
 $server = new soap_server;
 // Register the method to expose
 $server->register('hello');
 // Define the method as a PHP function
 function hello($name) {
 return 'Hello, ' . $name;
 }
 // Use the request to (try to) invoke the service
 $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
 $server->service($HTTP_RAW_POST_DATA);
 */




// Pull in the NuSOAP code
require_once('nusoap.php');
include_once("../MySqlDateBase.class.php");
// Enable debugging *before* creating server instance
$debug = 1;
// Create the server instance
$server = new soap_server;
// Register the method to expose
$server->register('hello');
$server->register('updateDBSL');
// Define the method as a PHP function
//function hello($arr1, $arr2) {
//	return 'Hello, ' . $arr1. $arr2;
//}

function updateDBSL($km) {
	$SqlDB = new MySqlDateBase();

	$sql="select count(*) as cn from app_info where state='0' and collectionId in (select UserId from user where km='".$km."')";
	$rs=$SqlDB->getRows($SqlDB->Query($sql));
	$tmp =$rs[0]["cn"];
	$RET= 'if(typeof(Delicious) == '.
	"'undefined'".
	') Delicious = {}; Delicious.posts = [{"u":'.
	"$tmp".
	'}];';
	return $RET;
}
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>
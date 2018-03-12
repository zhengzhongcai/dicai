<?php

/*
 // Pull in the NuSOAP code
 require_once('nusoap.php');
 // Create the client instance
 $client = new soapclient('http://113.31.19.201:8888/soap/server.php');
 // Call the SOAP method
 $result = $client->call('hello', array('name' => 'Scott'));
 // Display the result
 print_r($result);

 */





// Pull in the NuSOAP code
require_once('nusoap.php');
// Create the client instance
$client = new soapclient('http://192.168.100.40/ci/template/ajaxPHP/server.php');
//$client = new soapclient('http://webservice.webxml.com.cn/WebServices/WeatherWS.asmx?wsdl','wsdl');
//$client = new soapclient('http://10.4.41.182:9083/shm/services/PropagandaService?wsdl','wsdl');

// Call the SOAP method
//$result = $client->call('updatePropagandaUsers',array('userId' => "CDC", 'validation' => 'true'));
//$arr = array("userId" => "CDC","validation" => "true");
// print_r ($arr);
// print_r ("<br>");
// $result = $client->call('hello', $arr);
// print_r($result."</br>");
 
 $temp =array('sdfsf');
 //print_r ($temp);
 //print_r ("<br>");
 $result1 = $client->call('updateDBSL', $temp);
 var_dump($result1);
// Display the result

// Display the request and response
//echo '<h2>Request</h2>';
//echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Response</h2>';
//echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

// Display the debug messages
//echo '<h2>Debug</h2>';
//echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';



/*
 // Pull in the NuSOAP code
 require_once('nusoap.php');
 // Create the client instance
 $client = new soapclient('http://113.31.19.201:8888/soap/server.php');
 // Check for an error
 $err = $client->getError();
 if ($err) {
 // Display the error
 echo '<p><b>Constructor error: ' . $err . '</b></p>';
 // At this point, you know the call that follows will fail
 }
 // Call the SOAP method
 $result = $client->call('hello', array('name' => 'Scott'));
 // Check for a fault
 if ($client->fault) {
 echo '<p><b>Fault: ';
 print_r($result);
 echo '</b></p>';
 } else {
 // Check for errors
 $err = $client->getError();
 if ($err) {
 // Display the error
 echo '<p><b>Error: ' . $err . '</b></p>';
 } else {
 // Display the result
 print_r($result);
 }
 }
 */
?>

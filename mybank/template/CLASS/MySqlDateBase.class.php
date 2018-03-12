<?php
class MySqlDateBase
{
	   var $host; 
	   var $user; 
	   var $passwd; 
	   var $database;
	   var $conn; 
	   var $lastInsertIntoID;
	   //利用构造函数实现变量初始化 
	   //同时连接数据库操作
	   public function MySqlDateBase() 
	   { 
	   	  include_once("../config.php");
		  $this->host = HOSTIP; 
		  $this->user = USERNAME; 
		  $this->passwd = PASSWORD; 
		  $this->database = DATEBASE; 
		  /*$this->host = HOSTIP; 
		  $this->user = 'ams'; 
		  $this->passwd = 'amsdb_rogersluo'; 
		  $this->database ='ams';*/
		  //echo "---------------------------+++".$this->host."+++-----------------+++".HOSTIP;
		 // echo $this->host ."---------". $this->user."-------".$this->passwd;
		  //exit();
		  
		  $this->conn=mysql_connect($this->host, $this->user,$this->passwd) or 
		  die("Could not connect to $this->host"); 
		  mysql_query("set names latin1");
		  mysql_select_db($this->database,$this->conn) or 
		 die("Could not switch to database $this->database"); 
	   } 
	
	   //该函数用来关闭数据库连接
	   function Close() 
	   { 
		  MySQL_close($this->conn); 
	   } 
	
	   //该函数实现数据库查询操作
	   function Query($queryStr) 
	   { 
		  $res =Mysql_query($queryStr, $this->conn) or 
		  die("ERROR_@_@@_@_".mysql_error()."<br />".$queryStr); 
		  //echo "返回的id".mysql_insert_id()."\n<br>";
		  $this->lastInsertIntoID=mysql_insert_id($this->conn);
		  return $res; 
	   } 
	function lastInsertId()
	{
		//echo "取值 : ".$this->lastInsertIntoID."\n<br />";
		return $this->lastInsertIntoID;
	}
	
	   //该函数返回记录集
	   function getRows($res) 
	   { 
		  $rowno = 0; 
		  $rowno = MySQL_num_rows($res); 
		  if($rowno>0) 
		  { 
			 for($row=0;$row<$rowno;$row++ ) 
			 { 
				$rows[$row]=MySQL_fetch_array($res);
				//本来为MySQL_fetch_row,但是不能以数组的方式来提取,只能用索引
				//这样可以用索引和名称，更为方便
			 } 
			 return $rows; 
		  } 
		} 
	
		//该函数取回数据库记录数
		function getRowsNum($res) 
		{ 
		   $rowno = 0; 
		   $rowno = mysql_num_rows($res); 
		   return $rowno;
		} 
	
	//该函数返回数据库表字段数
	function getFieldsNum($res)
	{
		$fieldno = 0;
		$fieldno = mysql_num_fields($res);
		return $fieldno;
	}
	
	//该函数返回数据库表字段名称集
	function getFields($res)
	{
		  $fno = $this->getFieldsNum($res);
		  if($fno>0) 
		  { 
			 for($i=0;$i<$fno;$i++ ) 
			 { 
				$fs[$i]=MySQL_field_name($res,$i);//取第i个字段的名称
			 } 
			 return $fs;
		  } 
	}
}
?>
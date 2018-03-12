<?php
header('Content-Type:text/html;charset=gb2312');
//require_once('../chkLogin.php');
/*
swfupload use ftpupload file
*/
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}
session_start();
//output string
function HandleError($message) {
	echo $message;
}

//生成随机数	echo randomkeys(8);
function randomkeys($length)
{
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";  //字符池
	$key = "";
	for($i=0;$i<$length;$i++)
	{
		$key .= $pattern{mt_rand(0,strlen($pattern)-1)};//生成php随机数
	}
	return $key;
}
//取得上传文件类型 == 存贮路径
function getfiletype($ids)
{
	$type = array('', 'video', 'images', 'txt', 'audio', 'swf', 'html');
	if($ids){
		return $type[$ids];
	}
	else{
		switch(getextend($_POST['Filename']))
		{
			case "txt":
				return "txt";
				break;
			case "swf":
				return "swf";
				break;
			case "htm":
			case "html":
				return "html";
				break;
			case "wav":
			case "wma":
			case "mp3":
			case "midi":
				return "audio";
				break;
			case "jpeg":
			case "gif":
			case "png":
			case "bmp":
			case "jpg":
				return "images";
				break;
			default:
				return "video";
		}
		return 'h';
	}
}

//取得上传文件后缀
function getextend($file_name)
{
	$extend = pathinfo($file_name);
	$extend = strtolower($extend["extension"]);
	return $extend;
}
//setings
//ini_set ('memory_limit', '1024M');
ini_set('max_execution_time', '600');
ini_set('max_input_time', '600');
$upload_name = "Filedata";
$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
//$extension_whitelist = array("jpg", "gif", "png");	// Allowed file extensions
//$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters

// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
$POST_MAX_SIZE = ini_get('post_max_size');
$unit = strtoupper(substr($POST_MAX_SIZE, -1));
$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
	header("HTTP/1.1 500 Internal Server Error"); // This will trigger an uploadError event in SWFUpload
	echo "POST exceeded maximum allowed size.";
	exit(0);
}
// Other variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$uploadErrors = array(
        0=>"There is no error, the file uploaded successfully",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
	);


// Validate the upload
if (!isset($_FILES[$upload_name])) {
	print_r($_FILES[$upload_name]);
	HandleError("No upload found in \$_FILES for " . $upload_name);
	exit(0);
} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
	HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
	exit(0);
} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
	HandleError("Upload failed is_uploaded_file test.");
	exit(0);
} else if (!isset($_FILES[$upload_name]['name'])) {
	HandleError("File has no name.");
	exit(0);
}

// Validate the file size (Warning: the largest files supported by this code is 2GB)
$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
if (!$file_size || $file_size > $max_file_size_in_bytes) {
	HandleError("File exceeds the maximum allowed size");
	exit(0);
}

if ($file_size <= 0) {
	HandleError("File size outside allowed lower bound");
	exit(0);
}
$file_name = str_replace(',', "",basename($_FILES[$upload_name]['name']));
if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
	HandleError("Invalid file name");
	exit(0);
}

$filename = $file_name;//$_POST['Filename'];
if($filename)
{
	$ids = $_POST['ids'];	
	$filename = iconv("utf-8","gb2312",$filename);
	$floder = getfiletype($ids); //存放文件夹
	$types = array('video'=>'1', 'images'=>'2', 'txt'=>'3', 'audio'=>'4', 'swf'=>'5', 'html'=>'6');
	//echo $floder;
	$idtype = $types[$floder];
	//echo '0/'.$idtype;
	include_once("../CLASS/FTP.class.php");
	$myFtp=new FTP();
	//检查文件是否存在
	$res = ftp_size($myFtp->conn_id, $floder."/".$filename);
	if($res == -1)
	{
		//上传文件
		if($myFtp->checkdir($floder) == false)
		{
			$myFtp->createdir($floder);
			$myFtp->checkdir($floder);
		}
		//echo $_FILES["Filedata"]["tmp_name"];
		//echo '/'.$_FILES['Filedata']['name'];
		if($_FILES['Filedata']['error']){
			echo "php upload error, error code:".$_FILES['Filedata']['error'];
			exit;
		}
		if($myFtp->upLoadFile($_FILES["Filedata"]["tmp_name"], $filename))
		{
			//更新DB server
			$url = "ftp://".FTP_SERVER."/".$floder."/".$filename;
			$filesize = ftp_size($myFtp->conn_id, $filename);
			//get the last modified time
			$buff = ftp_mdtm($myFtp->conn_id, $filename);
			if ($buff != -1) {				
				$timestamp = date ("Y-m-d H:i:s", $buff);
			}
			else {
				$timestamp = date("Y-m-d H:i:s");
			}
			$checksum = md5_file(FTP_FFMPEG_PATH."/".$floder."/".$filename);
			//$checksum = md5_file("ftp://".FTP_USER_NAME.":".FTP_USER_PASS."@".FTP_SERVER."/".$floder."/".$filename);
			include_once("../MySqlDateBase.class.php");
			$SqlDB = new MySqlDateBase();
			$sql = "insert into `play_file_property` (`URL`, `name`, `FileSize`, `type`, `ModifyDate`, `CheckSum`, `uploadMan`) values ('".$url."', '".$filename."', '".$filesize."', '".$idtype."', '".$timestamp."', '".$checksum."', '".$_SESSION['opuser']."')";
			if($SqlDB->Query($sql)) {
				echo "success";
			}
			else {
				ftp_delete($myFtp->conn_id, $filename);
				echo "DB error!";
			}
			$SqlDB->Close();
		}
		else
		{
			echo "upload faid";
		}
	}
	else
	{
		echo "file exists! ".$floder."/".$filename;
	}
	$myFtp->closeFTP();
}
else
{
	echo "file's name error!";
}
?>
<?php
class Uploadfile extends CI_Controller
{
	//public $userEntity="";
   
	function __construct()
	{
		parent::__construct();
       // $this->load->library('Ffmpeg');
        $this->load->model("m_uploadFileds", "MUF");
		$this->load->model('m_filemanage','m_fm');
		$this->load->model('m_ftpserver','m_ftp');
		$this->load->model('m_filetype','m_type');
		
    }
	

    function tbFtp($localFile, $serverFile, $uid,$userFtp)
    {
		$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$userFtp));
		if(is_bool($ftpInfo))
		{
			$this->HandleError("您没有配置默认FTP!");
            exit();
		}
        $this->load->library('ftp');
		
        if ($ftpInfo[0]["ftpIP"] != gethostbyname($_SERVER['SERVER_NAME'])) {
            $config['hostname'] = $ftpInfo[0]["ftpIP"];
            $config['username'] = $ftpInfo[0]["ftpUserName"];
            $config['password'] = $ftpInfo[0]["ftpPassword"];
			$config['port']     = $ftpInfo[0]["ftpPort"];
            $config['debug'] = false;
			$ftpname=$ftpInfo["ftpName"];
            if(!$this->ftp->connect($config))
			{
				$this->HandleError("无法连接您的FTP服务器($ftpname)!");
				exit();
			}
            $this->ftp->upload($localFile, $serverFile);
            $this->ftp->close();
        }
    }
    function upFile()
    {   
    	$uid=$_GET['Uid'];
    	$nodeId=$_GET['nodeId'];
    	//$sessionid=$_GEt['sessionid'];
    	set_time_limit(300);
        //设置保存路径
        $absolute_save_path = PHP_OS != "Linux" ? getcwd()."\\Material\\":getcwd()."/Material/";
        // 重置文件缓存文件夹路径
        ini_set('upload_tmp_dir', $absolute_save_path);
        $debug = 0;
       // echo "dfgff";
       /*if(session_id()!=$sessionid)
		{
			session_destroy();
		}
        // Flash Player 会话 Cookie bug 解决方法的代码
		session_id($sessionid);
		// exit();
		@session_start();*/
		$this->load->model('m_userEntity','userEntity');
		$this->userEntity->init(); 
		
		
        // Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)CONTENT_LENGTH
        $POST_MAX_SIZE = ini_get('post_max_size');
        $unit = strtoupper(substr($POST_MAX_SIZE, -1));
        $multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ?
            1073741824 : 1)));

     /*  if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier * (int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
			$this->HandleError("您上传的文件超过允许的大小.");
            exit(0);
        }*/
        $local_save_path = "Material/";
        $view_path = "Material/view/";
        
        $upload_name = "resume_file";
        $max_file_size_in_bytes = 2147483647; // 2GB in bytes
        // $extension_whitelist = array("jpg", "gif", "png", "bmp", "flv", "vod", "mpeg", "mp4",
            // "avi", "mpg", "mpeg", "wmv", "vob", "mov", "mp4", "asf", "dat", "ppt", "rmvb",
            // "mkv", "txt", "html", "htm", "mp3", "wma", "midi", "wav", "swf", "ts", "BZ2",
            // "bz2","bin","ppt"); // Allowed file extensions
        // Characters allowed in the file name (in a Regular Expression format)
        
       $valid_chars_regex = '\x{4e00}-\x{9fa5}A-Za-z0-9_\.\-';
        // Other variables
        $MAX_FILENAME_LENGTH = 260;
        $file_name = "";
        $file_extension = "";
        $uploadErrors = array(0 => "没有错误,文件上传成功", 1 =>
            "上传的文件超过了php.ini中upload_max_filesize选项", 2 =>
            "上传的文件超过了MAX_FILE_SIZE选项，是我们在指定的HTML表单", 3 => "上传的文件只有部分被上传", 4 => "没有文件被上传", 6 =>
            "缺少一个临时文件夹");


        // Validate the upload
        // 验证上传
        if (!isset($_FILES[$upload_name])) {
            $this->HandleError("没有上传文件");
            exit(0);
        } else
            if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
                $this->HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
                exit(0);
            } else
                if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
                    $this->HandleError("文件未被上传.");
                    exit(0);
                } else
                    if (!isset($_FILES[$upload_name]['name'])) {
                        $this->HandleError("文件没有名称.");
                        exit(0);
                    }

        // Validate the file size (Warning: the largest files supported by this code is 2GB)
        $file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
        if (!$file_size || $file_size > $max_file_size_in_bytes) {
            $this->HandleError("文件超过了允许的最大尺寸");
            exit(0);
        }

        if ($file_size <= 0) {
            $this->HandleError("文件大小不能为0");
            exit(0);
        }
        $file_time = filemtime($_FILES[$upload_name]["tmp_name"]);

        //预览用
        $view_fileName = "";
        $file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/iu', "", $_FILES[$upload_name]['name']);
        $f_n = explode(".", $file_name);
        $file_name = "";
        for ($i = 0; $i < count($f_n); $i++) {
            if ($i != count($f_n) - 1) {
                $file_name .= $f_n[$i];
            } else {
                $suffix = "." . strtolower($f_n[$i]);
            }
        }

        $file_name=iconv("UTF-8","GBK",$file_name);
		
        if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
            $this->HandleError("无效的文件名称");
            exit(0);
        }

        // Validate file extension
        $path_info = pathinfo($_FILES[$upload_name]['name']);
        $file_extension = $path_info["extension"];
        
		//echo "---------".$file_extension."----------------";
		
		//检测文件类型是否允许
		$fileTypeId=$this->m_type->getFileTypeIDBySuffix(strtolower($file_extension));
		if($fileTypeId==""){
			 $this->HandleError("您的文件未支持!");
        	 exit(0);
		}
		
        
        
        $fileMd5 = md5_file($_FILES[$upload_name]["tmp_name"]);
        $view_fileName = $fileMd5;
        $file_name = $file_name . $suffix;
      /*  if ($this->MUF->checkMd5($fileMd5)) {
            $this->HandleError("文件已存在");
            exit(0);
        }*/
		
		
		// 设置是否创建预览文件
		$createViewFile_key=false;
		
        $local_file_path = $local_save_path . $file_name;
        if (!@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $local_file_path)) {
            $this->HandleError("无法保存文件,路径错误或者没有可写权限!");
            exit(0);
        } else {
        	
			
			
            if ($fileTypeId == "1" || $fileTypeId == "2") {
				if($path_info["extension"]=="ppt")
				{
					$time = "30";
					$view_fileName = "";
				}

				else
				{
					//$videoInfo = $this->video_info($local_file_path, $local_save_path, $path_info);
					//$time = $videoInfo["seconds"];
					//sleep(2);
					//$view_file = $view_path . $view_fileName . ".flv";
					//$this->createViewFile($local_file_path, $view_file, $local_save_path, $path_info);
					//$view_fileName = $view_fileName . ".flv";
					$view_file = $view_path . $view_fileName . ".flv";
					$view_info=$this->createViewFile($local_file_path, $view_file, $local_save_path, $path_info);
					$view_fileName = $view_fileName . ".flv";
					if(!isset($view_info["seconds"]))
					{
						$this->HandleError("无法识别的文件编码!");
            			exit(0);
					}
					$time = $view_info["seconds"];
					$createViewFile_key=true;
				}
            }
            else if ($fileTypeId == "3") {
           				$_suffix=str_replace(".", "", $suffix);
						if($_suffix=="jpg"||$_suffix=="jpeg")
						{
                           $this->convartImage($local_file_path,$_suffix);
						}
                        $time = "30";
						$file_size = @filesize($local_file_path);
						$view_fileName = iconv("GBK","UTF-8",$file_name);
						   
            }
            else {
                $time = "30";
                $view_fileName = iconv("GBK","UTF-8",$file_name);
            }

			
            $this->tbFtp($local_file_path, $file_name, $uid, $this->userEntity->userFTPID);
			
			if($nodeId=="all"){
				$nodeId=$fileTypeId;
			}
			
		$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$this->userEntity->userFTPID));
		if(is_bool($ftpInfo))
		{
			$this->HandleError("您没有配置默认FTP!");
            exit();
		}
			$ftp_ip= $ftpInfo[0]["ftpIP"];
            $result = array();
            $result["state"] = "true";
			$result["fileUrl"] = "ftp://".$ftp_ip."/".$file_name;
            $result["fileName"] = iconv("GBK","UTF-8",$file_name);
            $result["fileMd5"] = $fileMd5;
            $result["fileSize"] = $file_size;
            $result["fileMdTime"] = date("Y-m-d H:i:s",$file_time);
            $result["viewpath"] = $view_fileName;
            $result["playtime"] = $time;
			$result["uploadDateTime"] = date("Y-m-d H:i:s");
			$result["uploadUserId"] = $uid;
			$result["nodeId"] = $nodeId;
			$result["fileTypeId"] = $fileTypeId;
			$result["ftpIp"] = "";//$this->mconfig->getUserDefaultFtp($uid);
			$result["createViewFile_key"]=$createViewFile_key;
           // echo json_encode($result);
			$this->saveFileInfo($result);
        }
    }
	
	/*************************************************************
    |
    |	函数名:saveFileInfo
    |	功能: 保存上传的文件信息
    |	返回值: 直接输出 JQUERY
    |	参数:
    |	创建时间:2012年7月19日 17:40:25 by 莫波
    |   
    **************************************************************/
	function saveFileInfo($result){
		$state=false;
				$insertId=$this->m_fm->saveFileInfo($result);
				//保存失败则删除文件
				if(!is_int($insertId))
				{
					if (PHP_OS!="Linux")
					{
						 $save_path = getcwd()."\\Material\\".$f_info["fileTrueName"];
						 $view_path= getcwd()."\\Material\\view\\".$FileViewURL;
					}
					else
					{
						$save_path = getcwd()."/Material/".$f_info["fileTrueName"];
						$view_path= getcwd()."/Material/view/".$FileViewURL;
					}
					unlink($save_path);
					unlink($view_path);
					
				}
				else{
					$state=true;
					$message["insertId"]=$insertId;
					$message["fileName"]=$result["fileName"];
					$message["fileMd5"]=$result["fileMd5"];
					$message["createViewFile_key"]=$result["createViewFile_key"];
				}
		echo json_encode(array("state"=>$state,"data"=>$message));
	}
	
	
    /* Handles the error output. This error message will be sent to the uploadSuccess event handler.  The event handler
    will have to check for any error messages and react as needed. */
    function HandleError($message)
    {
		$result = array();
        $result["state"] = false;
		$result["data"] = $message;
		echo json_encode($result);
       
    }
    
   function createViewFile($localFile, $view_file, $local_save_path, $file_info)
    {
        $this->load->library("log");
		$newpath = $local_save_path . "abc" . time() . "." . $file_info["extension"];
        rename($localFile, $newpath);
		$ffmpeg_path = '';
        if (PHP_OS != 'Linux') {
            $ffmpeg_path = 'start '.getcwd().'\\thirdModel\\ffmpeg\\ffmpeg -i ';
            if($file_info["extension"]=="ts"){
        		$ffmpeg_path = 'start '.getcwd().'\\thirdModel\\ffmpeg\\ts\\ffmpeg-ts -i ';
        	}
        } else {
        	
            $ffmpeg_path = '/usr/bin/ffmpeg -i ';
        }
        $type = 'video';
        switch ($type) {
            case 'video':
            case 'audio':
                $targetFile = $view_file;
                //exec($ffmpeg_path . $newpath ." -ac 1 -ab 56 -ar 22050 -b 500 -ss 00:00:02 -t 00:00:15  -r 15 -s 480x320 -y " .$targetFile);
                $cmd=$ffmpeg_path . $newpath ." -ac 1 -ab 56 -ar 22050 -b 600 -ss 00:00:02 -t 00:00:15  -r 15 -s 480x320 -y " .$targetFile;
				//echo $cmd;
			   	exec($cmd);
				
				//exit();
				
				
				$v_cmd=getcwd().'\\thirdModel\\ffmpeg\\ffmpeg -i '.$newpath.' 2>&1';
				//echo $v_cmd;
		        ob_start();
		        passthru($v_cmd,$result);
		        $info = ob_get_contents();
				
		        ob_end_clean();
				
				
				$ret = array();

				if (preg_match("/Duration: (*?), start: (.*?), bitrate: (\d*) kb\/s/", $info, $match)) {

						$ret['duration'] = $match[1];
						$da = explode(':', $match[1]);

						$ret['seconds'] = $da[0] * 3600 + $da[1] * 60 + (float)$da[2];
						$ret['start'] = $match[2];
						$ret['bitrate'] = $match[3];
                    $this->log->write_log("error",$ret['seconds']);
					}
				else if(preg_match("/Duration: (.*?), start: (.*?), bitrate: (\d*)/", $info, $match))
					{
						$ret['duration'] = $match[1];
						$da = explode(':', $match[1]);
						$ret['seconds'] = $da[0] * 3600 + $da[1] * 60 + (float)$da[2];
						$ret['start'] = $match[2];
						$ret['bitrate'] = $match[3];
                        $this->log->write_log("error",$ret['seconds']);
					}
				// wav 格式 Duration: 00:03:57.02, bitrate: 1411 kb/s
				else if(preg_match("/Duration: (.*?), bitrate: (\d*)/", $info, $match))
					{

						$ret['duration'] = $match[1];
						$da = explode(':', $match[1]);
						$ret['seconds'] = $da[0] * 3600 + $da[1] * 60 + (float)$da[2];
						$ret['start'] = "";
						$ret['bitrate'] = $match[2];
                        $this->log->write_log("error",$ret['seconds']);
					}
		        if (preg_match("/Video: (.*?), (.*?), (.*?)[,\s]/", $info, $match)) {
					if($file_info["extension"]=="rmvb")
					{
						$ret['vcodec'] = $match[1];
						$ret['vbit'] = $match[3];
						$ret['resolution'] = $match[2];
						$a = explode('x', $match[3]);
						$ret['width'] = $a[0];
						$ret['height'] = $a[1];
					}
					else
					{
						$ret['vcodec'] = $match[1];
						$ret['vformat'] = $match[2];
						$ret['resolution'] = $match[3];
						$a = explode('x', $match[3]);
						$ret['width'] = $a[0];
						$ret['height'] = $a[1];
					}
		           
		        }
		        if (preg_match("/Audio: (\w*), (\d*) Hz/", $info, $match)) {
		            $ret['acodec'] = $match[1];
		            $ret['asamplerate'] = $match[2];
		        }
		        if (isset($ret['seconds']) && isset($ret['start'])) {
		            $ret['play_time'] = $ret['seconds'] + $ret['start'];
		        }
		        $ret['size'] = filesize($newpath);
		        rename($newpath, $localFile);
			
               return $ret;
				
                break;
            default:
                break;
        }
    }

    function zhcnBaseName($path)
    {
        $fileInfo = explode("/", $path);
        if (count($fileInfo) > 1) {
            $fileInfo = $fileInfo[count($fileInfo) - 1];
        } else {
            $fileInfo = $fileInfo[0];
        }
        return $fileInfo;
    }


    //转化为0：03：56的时间格式

    function fn($time)
	{
        $num = $time;
        $sec = intval($num/1000);
        $h = intval($sec/3600);
        $m = intval(($sec%3600)/60);
        $s = intval(($sec%60));
        $tm = $h.':'.$m.':'.$s;
        return $tm;
    }
	//生成图片缩略图
    //缩略图
	function convartImage($image,$toSuffix){
	
		//缩放
		$maxWidth=1920;
		$maxHeight=1080;
		
		if(is_string($image)){
			$path=$image."";
			$ifo=explode(".",basename($image));
			$image=array();
			$image["newName"]=$ifo[0];
			$image["path"]=$path;
			$image["suffix"]=$ifo[1];
			$image["dir"]=dirname($path);
		}
		
		if(isset($image["zoom"])){
			$zoom=true;
			$maxWidth=$image["maxWidth"];
			$maxHeight=$image["maxHeight"];
		}
		
		$file_souce_path=$image["path"];
		$newFileName=$image["newName"];
		
		
		
		$suffix=array(
			"jpg","png","bmp"
		);
		$toSuffixs=array(
			"jpg","png","bmp"
		);
		if(!in_array(strtolower($image["suffix"]),$suffix)){
			return false;
		}
		if(!in_array(strtolower($toSuffix),$toSuffixs)){
			return false;
		}
		$toSuffix=strtolower($toSuffix);
		$im="";
		
		$imgType = strtolower($image["suffix"]);
		 if ($imgType == "jpg" ) {
			$im = @imagecreatefromjpeg($file_souce_path);
		} elseif ($imgType == "png") {
			$im = @imagecreatefrompng($file_souce_path);
		} elseif ($imgType == "gif") {
			$im = @imagecreatefromgif($file_souce_path);
		}
		if($im){
		
		}
		
		//取得当前图片大小
		$width = imagesx($im);
		$height = imagesy($im);
		//生成缩略图的大小
		$file = $image["dir"]."/". $newFileName . ".".$toSuffix;
		if (($width > $maxWidth) || ($height > $maxHeight)) {
			$widthratio = $maxWidth / $width;
			$heightratio = $maxHeight / $height;
			if ($widthratio < $heightratio) {
				$ratio = $widthratio;
			} else {
				$ratio = $heightratio;
			}
			$newwidth = $width * $ratio;
			$newheight = $height * $ratio;
	
			if (function_exists("imagecopyresampled")) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			}
			
			ImageJpeg($newim, $file);
			ImageDestroy($newim);
		} else {
			ImageJpeg($im,  $file);
		}
		ImageDestroy($im);
	}
	
	
    
    
	
}


?>
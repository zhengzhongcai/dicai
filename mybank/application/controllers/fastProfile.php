<?php
class fastProfile extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_fastProfile','Profile');
		$this->load->model('m_profileInfo','ProfileInfo');
		$this->load->model('m_userLog','userLog');				
	}
	public $ftpHandle="";
	
	function ftpCheckDir($folder)
	{
		$this->ftpHandle=$this->Profile->contentFTP();
		if($this->ftpHandle->changedir($folder))
		{
			$this->ftpHandle->changedir("/");
			return true;
		}
		else
		{
			if($this->ftpHandle->mkdir($folder))
			{
				return true;
			}
			return false;
		}
	}

	//create led profile
	function createLedProfile()
	{
		$this->Profile->getLedProfileData($_POST['profileGlobalInfo'],$_POST['profileInfo']);
		//打包
		$tarName=$this->Profile->profileName.".tar"; //压缩包名
		$tarfilePath=FILELIB.$tarName; //存放地方
		rename(FILELIB.$this->Profile->profileName,$this->Profile->profileName);
		$this->Profile->createLEDTar($tarfilePath,$this->Profile->profileName);//调用打包程序
		rename($this->Profile->profileName,FILELIB.$this->Profile->profileName);
		//上传
		$this->ftpCheckDir(FTPTAR);
		$ftppath=FTPTAR.$tarName;
		$this->Profile->uploadFile($tarfilePath,$ftppath);
		//写数据库
		$this->Profile->saveDatas();
		echo "执行成功";
	}
	function createProfile()
	{
	//	$this->benchmark->mark('code_start');

		$post_info=$this->input->post("data");
		// echo "<pre>";
		// echo print_r($post_info);
		// echo "</pre>";
		//$this->Profile->copyTemplateImport($post_info["profileTemplateInfo"]);
		$state=$this->Profile->getProfileData($post_info,$post_info["playAreaInfo"],$post_info["profileTemplateInfo"]);
		//echo $state[0];
		//exit();
		if($state[0]=="false")
		{
			$this->userLog->createProfileLogError($state[1]);
			echo json_encode($state[1]);
			exit();
		}
		
		//-------------------------------------------------
		//copy 背景图
		//-------------------------------------------------
		if($post_info["tempBgGround"]!="")
		{    
			$file_name=iconv("utf-8","GBK",$post_info["tempBgGround"]);
			$folder_Name=$this->Profile->profileName;
			$local_path="FileLib/".$folder_Name."/".$file_name;
			$oldPath="Material/".$file_name;
			//echo copy($oldPath,$local_path);
			if(@copy($oldPath,$local_path))
			{ 
                
				$state=true; 
			}
			else
			{   
				echo json_encode(array("state"=>false,"message"=>"背景图拷贝失败","data"=>""));
				return ;
			}
		}
		//-------------------------------------------------/
		
		$localFilesPath=FILELIB.$this->Profile->profileName."/";	
		//$this->Profile->downloadFiles($localFilesPath);//下载文件
		//生成html
		//echo "ggg";
		//$data['htmlMeta']=$this->Profile->createOption();
		$data['htmlMeta']=$this->Profile->createProfileTouchInfo();
		$data['htmlCont']=$this->Profile->createHtmlBody();//给终端用
		$data['profileName']=$this->Profile->profileName;
		$data['bodyWidth']=$this->Profile->tempWidth;
		$data['bodyHeight']=$this->Profile->tempHeight;	
		$html=$this->load->view('html',$data,true);	
		
		$data['htmlMeta']="";
		$data['htmlCont']=$this->Profile->createHtmlBody("0");//预览用
		$data['bodyWidth']=$this->Profile->tempWidth;
		$data['bodyHeight']=$this->Profile->tempHeight;	
		$htmlPreView=$this->load->view('viewHtml',$data,true);	
		
		//写到文件		
		$filePathView=$localFilesPath.$this->Profile->profileName."_view.html";//预览用的html,profileName_view.html
		$this->Profile->writeHtml($filePathView,$htmlPreView);
		
		$filePath=$localFilesPath.$this->Profile->profileName.".html";//终端用的html,profileName.html
		$this->Profile->writeHtml($filePath,$html);

	//-----------------------------------------
	//-
	//-	打包 将Profile合成一个tar文件
	//-
	//-----------------------------------------
		
		
		//将profile文件夹从FileLib移动到CI目录下 与 tar程序 同级目录
		if(is_dir($this->Profile->profileName))
		{
			$this->deleteDir($this->Profile->profileName);
		}
		rename(FILELIB.$this->Profile->profileName,$this->Profile->profileName);  
		sleep(2); 
		//-----解决当文件很多时候导致打包失败的BUG
		//echo $this->Profile->profileType;
		
		//调用打包程序
		//节目包类型判断逻辑
		$tarName="";
        switch($this->Profile->profileType)
        {
            case "X86":
                $tarName=$this->Profile->profileName.".tar"; //压缩包名
                $tarfilePath=FILELIB.$tarName; //存放地方 
                $this->Profile->createTarByPhp($tarfilePath,$this->Profile->profileName);
              //  echo $tarfilePath;
            break;
            case "Android": 
                $tarName=$this->Profile->profileName.".7z"; //压缩包名
                $tarfilePath=FILELIB.$tarName; //存放地方 
                $this->Profile->androidTar($tarfilePath,$this->Profile->profileName);
            break;
        }
        
        $this->Profile->profileTarName=$tarName;
        
		//将profile文件夹从CI移动到FileLib目录下
		rename($this->Profile->profileName,FILELIB.$this->Profile->profileName);
		

		
		//写数据库
		$state=$this->Profile->saveDatas();
		echo "\n\n".$this->Profile->profileID."\n\n写数据库:";

		print_r($state);
		echo "\n\n";
		if($state[0]=="false")
		{
			echo $state[1];
			exit();
		}
	//----------------------------------------
	//-
	//-		上传 和成好的文件包
	//-
	//----------------------------------------
		$this->ftpCheckDir(FTPTAR);
		$ftppath=FTPTAR.$tarName;
		
		//echo "<br>上传节目包".$tarfilePath."-----------".$ftppath."<br>";
		$this->Profile->uploadFile($tarfilePath,$ftppath);
		
		echo "执行成功";
		$this->userLog->createProfileLogok($post_info,"",$post_info["playAreaInfo"]);
		//$this->benchmark->mark('code_end');
		//echo $state[1];
	//	echo "<p>".$this->benchmark->elapsed_time('code_start', 'code_end')."</p>";
	}
	function makeXML(){
		$this->load->helper('savexml');
		$this->load->library('templatem',array('16'));	
		savexml();
	}
	function editProfile(){
			
	}


	function deleteProfile(){
		$profileID=$_POST['profileID'];
		$state=$this->Profile->deleteProfile($profileID,"1");	
		if($state[0]=="true")
		{
			$this->userLog->delProLog($state[1]);
		}		
	}
	function deleteDir(){
		$path=FILELIB.'s';
		echo $path;
		$this->Profile->removeDir($path);	
	}
	
	//导出profile
	function export($profileID=0)
	{
		if ((int)($profileID)) 
		{
			$proInfo = $this->Profile->getProfileInfo($profileID);			
			if($proInfo[0]['profileName'])
			{
				$file = FILELIB.$proInfo[0]['profileName'].'.tar';
				if(!file_exists($file))
				{
				    //die('Error: File not found.');
				    echo '<script>alert("Error: File not found.");history.back();</script>';exit;
				}
				else 
				{
					header("Cache-Control: public");
					header("Content-Description: File Transfer");
					header("Content-Disposition: attachment; filename=".$proInfo[0]['profileName'].".tar");
					header("Content-Type: application/octet-stream");
					header("Content-Transfer-Encoding: binary");
					readfile($file);
				}
			}
			else 
			{
				//die('not any data');
				echo '<script>alert("not any data.");history.back();</script>';exit;
			}
		}
		else
		{
			//die('export error');
			echo '<script>alert("export error.");history.back();</script>';
			
		}
	}
	
	//导入profile
	function import()
	{

		//取文件夹名
		$postProfileName = preg_replace("/\.tar$/i","",$_FILES['uprofile']['name']);
		if(file_exists(FILELIB.$_FILES['uprofile']['name']))
		{
			echo '<script>alert("file:'.$_FILES['uprofile']['name'].' exist");history.back();</script>';exit;
		}
		if (file_exists(FILELIB.$postProfileName))
		{
			echo '<script>alert("file:'.$postProfileName.' exist");history.back();</script>';exit;
		}
		else
		{ 
			$this->load->helper('form');
			$config['upload_path'] = 'FileLib/';
  			$config['allowed_types'] = 'tar';//上传文件类型tar
  			$config['max_size'] = '32000';//上传文件大小限制32M
  			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('uprofile'))//
			{
				$error = $this->upload->display_errors();
				echo '<script>alert("'.$error.'");history.back();</script>';
				exit;
			}
			else//tar上传成功
			{
				//解压tar
				exec(escapeshellcmd('tar xf '.FILELIB.$_FILES['uprofile']['name']));
				//移动
				if(rename($postProfileName,FILELIB.$postProfileName))
				{
					//上传文件夹至默认ftp
					$this->load->library('ftp');	
					$this->ftp->connect($this->config);
					$this->ftp->mirror(FILELIB.$postProfileName.'/', '/import/'.$postProfileName.'/');	
					$this->ftp->close();
					echo '<script>location.href="'.base_url().'template/JavaScriptProduct/JavaScriptCreateMode/editProfile.html?profile_Name='.$postProfileName.'&edit_type=load"</script>';
				}
				else 
					echo '<script>alert("解压文件'.$postProfileName.'失败!");</script>';
			}			
		}
	}
	function _destruct(){
		//关闭ftp连接
		$this->ftpHandle->close();
	}
	function getTemplateID(){
          $profileId = $_POST['profileID'];
           $this->db->where("profileId",$profileId);
				$this->db->select('TemplateID');
				$query=$this->db->get("profile");
 	 //  $temGroup_SQL="select TemplateID from profile where ProfileID = ".$profileId; $UserID=$_POST['value'];
		     
				$rs=$query->result_array();
		//var_dump($rs);
		echo $rs[0]['TemplateID'];
 }
 function getPlayListID(){
        $PlaylistName = $_POST['PlaylistName'];
 	   $temGroup_SQL="select PlaylistID from playlist where PlaylistName=".$PlaylistName;
		$rs=$this->db->query($temGroup_SQL)->result();
		echo $rs;
 }


}
 
/****************************************************

		测试使用  开始

*****************************************************/
	/*function makeProfile(){
		$data['title']='生成Html给终端用';
		$data['htmlCont']='';
		$html=$this->load->view('html',$data,true);	
		//将html写到一个文件
		$filesPath='FileLib/myTest.html';
		$iswrite=$this->Profile->writeHtml($filesPath,$html);
		
		//打包
		$tarName='myTest.tar';
		$filepath='FileLib/'.$tarName;
		$filesArr=array($filesPath);
		$this->Profile->createTar($filepath,$filesArr);
		
		//上传
		
		$ftppath='/tar/'.$tarName;
		$this->Profile->uploadFile($filepath,$ftppath);
		
		//保存数据库
		$this->Profile->saveDatas();
		exit();	
		
	}
	function createTar(){
		$tarName='湖南联通3411.tar';
		$filepath='FileLib/'.$tarName;
		$folderpath='FileLib/myScroll';
		rename($folderpath,"湖南联通3411");
		
		$this->Profile->createTar($filepath,"湖南联通3411");
		rename("湖南联通3411",$folderpath);
	}
	function makeLEDTxt(){
		$this->Profile->makeLEDTxt('FileLib/txt/第二章初入县城.txt','FileLib');	
	}
	function makeScrollTxt(){
		$this->Profile->makeScrollTxt();
	}*/
/****************************************************

		测试使用  结束

*****************************************************/
?>
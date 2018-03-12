<?php
class Socket extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_socket','Socket');
		$this->load->model('m_client','Client');
	}
	function index(){
	}
	function getFilesInfo(){
		$data['title']='文件信息';
		//$clientID=$this->uri->segment(3, 0);
		$clientID=$this->input->get('client_id');
		$data['clientID']=$clientID;
		$diskInfo=$this->Socket->getDiskInfo($clientID);		
		$data['diskInfo']=$diskInfo[0];
		$data['filesInfo']=$diskInfo[1];	
		$this->load->view('clientFiles',$data);
	}
	function getClientState(){
		
		$clientStatus=$this->Socket->getClientStatus();
		echo "@#@#@#";
		$clientStatusJs=json_encode($clientStatus);
		echo $clientStatusJs;
	}
	function controlClients(){
		$this->Socket->controlClients($_POST);	
	}
	function bakupDB(){
		//$this->Socket->bakupDB('0');
		echo header("Content-type: text/html; charset=utf-8");
		$this->Socket->bakupDB($_POST['bak']);	
	}
	
		//sand insert led
	function insertled2()
	{
		$iPicColor = 3;			//灯色彩			
		$newfileName = substr(time(),-7,7).rand(0,9).'.R01'; //生成的文件名
		$saveFolder = 'FileLib'; 
		$astr = array();
		$clientID=$this->input->post('clientID');
		$str = iconv('utf-8','gb2312',$this->input->post('txt'));	//文本
		$scroll =3;// $this->input->post('direction');	//播放类型
		$speed = $this->input->post('scrollamount');	//滚动速度                               
		$delaytime = $this->input->post('delayTime');   //停留时间
		$playtime = $this->input->post('repalyCount');  //播放时长
		$width = $this->input->post('width');  //宽
		$height = $this->input->post('height');	//高
		$str = str_replace(array("\r\n", "\n", "\r"),"",$str);//过滤换行符				
		$params = array();
		$params['str'] = $str='sss';
		$params['fontsize'] = '6';//$this->input->post('fontsize');	//字体大小		
		$params['width'] ='66';// $width;	//led长
		$params['height'] ='10';// $height;	//len宽
		$params['font'] = '宋体';//iconv('utf-8','gb2312',$this->input->post('font'));	//字体
		
		$this->load->library('txtsplit', $params);	
		
		if(!is_object($this->txtsplit)) die("txtsplit 未加载进去");
		if($scroll=="3")//左滚动
		{
			$w = $this->txtsplit->imageboxw();//获取宽
			$iPictures = ceil($w/$width);
			$astr[0] = $str;
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
		}
		else//上滚动
		{
			$this->txtsplit->mysplit();
			$astr = $this->txtsplit->datas;
			$iPictures = count($astr);
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
			//echo var_dump($astr);	
		}
		//上传
		$fileFullPath=FILELIB.$newfileName;
		$ftpfileFullPath=FTPLED.$newfileName;
		//echo "<br>".$fileFullPath."<br>";
		//echo $ftpfileFullPath;
		$this->load->library('ftp');
		$config['hostname'] = $this->config->item('ftpServer');
		$config['username'] = $this->config->item('ftpUser');
		$config['password'] = $this->config->item('ftpPwd');
		$config['debug'] = TRUE;
		$this->ftp->connect();		
		$this->ftp->upload($fileFullPath,$ftpfileFullPath);//本地地址，ftp地址
		//删除led字幕包
		//$md5=md5_file($fileFullPath);
		unlink($fileFullPath);
		
		$postArr=array("params"=>array("TextFileURL"=>$ftpfileFullPath,
									   "InsertPlayTimes"=>$playtime,
									   "Rect"=>array($width,$height,$speed,$delaytime),
									   "FontStyle"=>'',
									   "FontSize"=>$scroll,
									   "BackGroundColer"=>0,
									   "ForeGroundColer"=>0,
									   "ScrollSpeed"=>0),
					   "clientID"=>$clientID,
					   "command"=>"ledTxt"); //socket命令
		exit();
		$this->Socket->controlClients($postArr);	
		echo 'sand socket...';
		//return $md5;
	}
	function insertled()
	{
		
		$iPicColor = 3;			//灯色彩			
		$newfileName = substr(time(),-7,7).rand(0,9).'.R01'; //生成的文件名
		$saveFolder = 'FileLib'; 
		$astr = array();
		$str = iconv('utf-8','gb2312',$this->input->post('txt'));	//文本
		$scroll = $this->input->post('direction');	//播放类型
		$speed = $this->input->post('scrollamount');	//滚动速度
		$delaytime = $this->input->post('delayTime');   //停留时间
		$playtime = $this->input->post('repalyCount');  //播放时长
		$width = $this->input->post('width');  //宽
		$height = $this->input->post('height');	//高
		$str = str_replace(array("\r\n", "\n", "\r"),"",$str);//过滤换行符				
		$params = array();
		$params['str'] = $str;
		$params['fontsize'] = $this->input->post('fontsize');	//字体大小		
		$params['width'] = $width;	//led长
		$params['height'] = $height;	//len宽
		$params['font'] = iconv('utf-8','gb2312',$this->input->post('font'));	//字体
		$this->load->library('txtsplit', $params);				
		if($scroll=="3")//左滚动
		{
			$w = $this->txtsplit->imageboxw();//获取宽
			$iPictures = ceil($w/$width);
			$astr[0] = $str;
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
		}
		else//上滚动
		{
			$this->txtsplit->split();
			$astr = $this->txtsplit->datas;
			$iPictures = count($astr);
			$this->txtsplit->txt2bin($iPictures,$saveFolder,$newfileName,$astr,$iPicColor,$scroll);
			//echo var_dump($astr);	
		}
		//上传
		$fileFullPath=FILELIB.$newfileName;
		$ftpfileFullPath=FTPLED.$newfileName;
		//echo "<br>".$fileFullPath."<br>";
		//echo $ftpfileFullPath;
		$this->load->library('ftp');
		$config['hostname'] = $this->config->item('ftpServer');
		$config['username'] = $this->config->item('ftpUser');
		$config['password'] = $this->config->item('ftpPwd');
		$config['debug'] = TRUE;
		$this->ftp->connect();		
		$this->ftp->upload($fileFullPath,$ftpfileFullPath);//本地地址，ftp地址
		//删除led字幕包
		//$md5=md5_file($fileFullPath);
		unlink($fileFullPath);
		echo 'sand socket...';
		//return $md5;
	}
	
	function delClientFile(){
		
		$clientID = intval($this->input->post('clientID'));
		if($clientID<1)die("error_id");
		
		$param = strip_tags($this->input->post('parameter'));
		if($param && split(",",$param)){
			$jsonArr = split(",",$param);
			array_pop($jsonArr);
			//$jsonArr = array_unique($jsonArr);
			$paramStr = json_encode($jsonArr);
		}elseif($param==""){
			$paramStr = "all";
		}else{
			die("error_param");
		}
		$clientStatus=$this->Socket->delclientfile($clientID,$paramStr);
		
		
		echo $clientStatus;
	}

}
?>
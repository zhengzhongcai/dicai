<?php
class M_fastProfile extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->helper("serverSystemInfo");
		$this->load->model('m_profileInfo','ProfileInfo');	
		$this->load->model('m_profileExtend','ProfileExtend');	
		$this->load->model('m_profileExtendHtml','ProfileExtendHtml');
		$this->load->model('m_userEntity','userEntity');
		$this->load->model('m_ftpserver','m_ftp');
	}
	//profile赋给全局变量,新增profile才能用到
	public $profileName='';
	public $profileType=''; 
	public $profilePeriod=0;
	public $profileTemplateID=0;//标准模板
	public $profileTmpID=0;//profile模板
	public $profileTmpFileID=0;
	public $profileTouchJumpUrl='';
	public $profileDiv=array();
	public $profileID=0;
	public $tempBgGround='';
	public $tempWidth=0;
	public $tempHeight=0;
	public $profileGlobal=array();
	public $profileDivStr;
	public $ftpHandel="";
    public $profileTarName="";
	
	//-----------------------------------
	//
	//- 连接用户默认的FTP服务器
	//
	//-----------------------------------
	function contentFTP()
	{
		if($this->ftpHandel=="")
		{
			
			$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$this->userEntity->userFTPID));
			if(is_bool($ftpInfo))
			{
				$this->HandleError("您没有配置默认FTP!");
				exit();
			}
			$this->load->library('ftp');
			$config['hostname'] = $ftpInfo[0]["ftpIP"];
            $config['username'] = $ftpInfo[0]["ftpUserName"];
            $config['password'] = $ftpInfo[0]["ftpPassword"];
			$config['port']     = $ftpInfo[0]["ftpPort"];
            $config['debug'] = false;
			$this->ftp->connect($config);
			$this->ftpHandel=$this->ftp;
			return $this->ftp;
		}
		return $this->ftpHandel;
	}
	//---------------------------------------
	//
	//	配置文件的FTP信息
	//
	//---------------------------------------
	function getFtpPath($file=""){	
		$ftpInfo=$this->m_ftp->getUserFtpInfo(array("FTPID" =>$this->userEntity->userFTPID));
		if(is_bool($ftpInfo))
		{
			$this->HandleError("您没有配置默认FTP!");
			exit();
		}
		$this->load->library('ftp');
		$ftpUser=$ftpInfo[0]["ftpUserName"];
		$ftpPwd=$ftpInfo[0]["ftpPassword"];
		$ftpServer=$ftpInfo[0]["ftpIP"];
		$ftpPort=$ftpInfo[0]["ftpPort"];
		$ftp="ftp://$ftpUser:$ftpPwd@$ftpServer";
		$ftppath=$ftp.$file;
		//echo Information("getFtpPath",$ftppath);
		return $ftppath;
	}
	
	
	
	function setProfileData(){
		$profileDataInfo=array();
		foreach($this->profileDataInfo  as $key =>$value){
			if($key=='templateID'){
				$profileDataInfo[$key]=$this->profileTmpID;
			}else{
				$profileDataInfo[$key]=$value;
			}
		}
		$profileGlobalStr=json_encode($profileDataInfo);
		$profileDivStr=json_encode($profileDivStr);
		$profileStr='profileGlobalInfo='+$profileGlobalStr+'profileInfo='+$profileDivStr;
		return $profileStr;
	}
	function getLedProfileData($profileGlobalStr='',$profileDivStr='')
	{
		$profileDataInfo=json_decode($profileGlobalStr,true);
		$profileDivInfo=json_decode($profileDivStr,true);
		
		//echo Information("Create LED Profile Source Global Info",$profileDataInfo);
		//echo Information("Create LED Profile Source Area Info",$profileDivInfo);
		
		if(count($profileDataInfo)<=0) die("全局变量未传递");
		$action=$profileDataInfo["action"];
		if($action=='edit'){
			$profileID=$profileDataInfo["profileID"];
		}else{
			$profileID=0;
		}
		$profileName=proEncodeName($profileDataInfo["profileName"]);//='testTxt';
		//重命名缓存目录 为 profile实体名称目录
		$ef=$this->ProfileInfo->createProfileFolder($profileName);
		if($ef[0]=="false")
		{
			return $ef[1];
		}
		$profileName=$profileDataInfo["profileName"];//='testTxt';
		$profileType=$profileDataInfo['profileType'];//='X86';
		$profilePeriod=$profileDataInfo['profilePeriod'];//='128'; //主区域图片（10s）,视频117s
		$profileTmpID=$this->saveTemplate(null,3,null,null);//led template
		//$profileTmpFileID=$profileDataInfo['templateFileID']=0;//tar 包
		$profileTouchJumpUrl=$profileDataInfo['touchJumpUrl'];//='';
		//$tempBgGround=urldecode(iconv('gb2312','utf-8',$profileDataInfo['tempBgGround']));
		$tempBgGround=$profileDataInfo['tempBgGround'];
		$this->tempWidth=$tempWidth=$profileDataInfo['tempWidth'];
		$this->tempHeight=$tempHeight=$profileDataInfo['tempHeight'];
		
		$divCount=count($profileDivInfo);
		for($i=0;$i<$divCount;$i++){
			$filesArr=$profileDivInfo[$i]['files'];
			$fileCount=count($filesArr);
			for($j=0;$j<$fileCount;$j++){
				//$profileDivInfo[$i]['files'][$j]['filePath']=urldecode(iconv('gb2312','utf-8',$filesArr[$j]['filePath']));
				$profileDivInfo[$i]['files'][$j]['filePath']=$filesArr[$j]['filePath'];
			}
		}
		//pArr($profileDivInfo);
		//exit();
		$profileDiv=$profileDivInfo;
		$this->profileName=$profileName;//='AAA';
		$this->profileType=$profileType;//='X86';
		$this->profilePeriod=$profilePeriod;//='128';
		$this->profileTemplateID=$profileTmpID;//='86';
		$this->tempBgGround=$tempBgGround;
		$this->tempWidth=$tempWidth;
		$this->tempHeight=$tempHeight;

		//$this->profileTmpFileID=$profileTmpFileID;
		$this->profileTouchJumpUrl=$profileTouchJumpUrl;
		$this->profileDiv=$profileDiv;
		//循环区域判断是否LED区域
		$divInfoArr=$this->profileDiv;
		$divNum=count($divInfoArr);
		for($i=0;$i<$divNum;$i++){
			if($divInfoArr[$i]['type']=='LED'){
				$x=$divInfoArr[$i]['files'][0]['left'];
				$y=$divInfoArr[$i]['files'][0]['top'];
				$width=$divInfoArr[$i]['files'][0]['width'];
				$height=$divInfoArr[$i]['files'][0]['height'];
				$this->saveTemplateDescribe(100,$x,$y,$width,$height,"Txt");
			}
		}
		if($profileID==0){
			$this->saveProfileDatas();
		}
	}
	function getProfileData($profileGlobalInfo,$profileAreaFileInfo,$profileTemplateInfo){
		//日志
		$usLog=array();
		$this->profileGlobal=$profileDataInfo=$profileGlobalInfo;

		$usLog["profileGlobalStr"]=$profileDataInfo;
		
		$action=$profileDataInfo["action"];
		$this->profileName=$profileName=proEncodeName($profileDataInfo["profileName"]);
		$profileID="";
		if($action=='edit'){
			$profileID=$profileDataInfo["profileID"];
			$profileOldName=$profileDataInfo["profileOldName"];
			echo "<script>alert('提示内容')</script>";
			//重命名缓存目录 为 profile实体名称目录
			if(@rename("Filelib\\".$profileOldName,"FileLib\\".$this->profileName))
			{rename("Filelib/".$profileOldName,"FileLib/".$this->profileName);}
		}else{
			$profileID=0;
			//preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$profileDataInfo["profileName"])));//='testTxt';
			//重命名缓存目录 为 profile实体名称目录
			$ef=$this->ProfileInfo->createProfileFolder($profileName);
			if($ef[0]=="false")
			{
				return $ef[1];
			}
			$usLog["renameProfileFolder"]=$ef[1];
		}
		@session_start();
		$_SESSION["failedProfileFolder"]=$profileName;
		$this->ProfileExtendHtml->copyBxJs($profileName);
		$profileType=$profileDataInfo['profileType'];//='X86';
		$profilePeriod=$profileDataInfo['profilePeriod'];//='128'; //主区域图片（10s）,视频117s
		$profileTmpID=$profileDataInfo['templateID'];//=110;//两个区域 图片区域两张
		//$profileTmpFileID=$profileDataInfo['templateFileID']=0;//tar 包
		$profileTouchJumpUrl=$profileDataInfo['touchJumpUrl'];//='touchJumpUrl';
		//$tempBgGround=urldecode(iconv('gb2312','utf-8',$profileDataInfo['tempBgGround']));
		$tempBgGround=$profileDataInfo['tempBgGround'];
		$this->tempWidth=$tempWidth=$profileDataInfo['tempWidth'];
		$this->tempHeight=$tempHeight=$profileDataInfo['tempHeight'];

		$profileDivInfo=$profileAreaFileInfo;
		//echo Information("profile区域文件信息 转码前",$profileDivInfo);
		//关联区域的关联信息 
        $relevanceInfoArr=array();
		foreach($profileDivInfo as $a=>$b)
        {
			if(!isset($b['files'])){continue;}
			$filesArr=$b['files'];
			foreach($filesArr as $k=>$v)
            {
				if($profileDivInfo[$a]["type"]=="Video")
				{
					 if($profileDivInfo[$a]['files'][$k]["fileInfo"]['fileType']=="Video")
					 {
						if(isset($profileDivInfo[$a]['files'][$k]["fileInfo"]['relevancefileinfo']))
						{
							$relevanceInfoArr[]=$profileDivInfo[$a]['files'][$k]["fileInfo"]['relevancefileinfo'];
						}
						$profileDivInfo[$a]["files"][$k]["fileInfo"]["filePath"]=utf8ToGb($v["fileInfo"]["filePath"]);
					 }
					else
					{
						$profileDivInfo[$a]["files"][$k]["fileInfo"]["filePath"]=utf8ToGb($v["fileInfo"]["filePath"]);
						
					}
				}
				else
				{
					if($profileDivInfo[$a]['files'][$k]["fileInfo"]['fileType']=="Txt")
					{
						$profileDivInfo[$a]["files"][$k]["fileInfo"]["filePath"]=utf8ToGb($v["fileInfo"]["filePath"]);
					}
					else if($profileDivInfo[$a]['files'][$k]["fileInfo"]['fileType']=="Url")
					{
						//不拥护转换
					}
					else
					{
						$profileDivInfo[$a]["files"][$k]["fileInfo"]["filePath"]=fileNameEncode($v["fileInfo"]["filePath"]);
					}
					$profileDivInfo[$a]["files"][$k]["fileInfo"]["fileViewPath"]=fileNameEncode($v["fileInfo"]["fileViewPath"]);
				}
			}
		}
	//echo Information("profile区域文件信息 转码后",$profileDivInfo);
		if(count($profileDivInfo)<=0)
		{
			return array("false",errorInfo(1004));
		}
		if(count($relevanceInfoArr)>0)
		{
			$this->ProfileExtendHtml->relevanceInfoToFile($relevanceInfoArr,$profileName);
			$this->ProfileExtendHtml->copySocketInfo($profileName);
		}
		
		
		
		$usLog["profileDivInfo"]=$profileDivInfo;

		

		$this->load->helper('fileviewxml');
		if(!createViewFileXMl($profileName,$profileDivInfo))
		{
			return array("false",errorInfo(1006));
		}
		
		$usLog["createViewFileXMl"]="mainAreaView.xml";
		//添加xml至profile文件夹
		//增加template信息
		//$templateDivInfo = $this->getTemplateDescribeInfo($profileTmpID);
		// $this->load->helper('savexml');
		// //保存Profile信息到 XMl 文件
		// if(!savexml_tofile($profileName,$profileDataInfo,$profileDivInfo,$templateDivInfo))
		// {
			// return array("false",errorInfo(1005));
		// }
		$usLog["ProfileInfoToXml"]=$profileName.".xml";
		$profileDiv=$profileDivInfo;
		$this->profileName=$profileName;//='AAA';
		$this->profileType=$profileType;//='X86';
		$this->profilePeriod=$profilePeriod;//='128';
		$this->profileTemplateID=$profileTmpID;//='86';
		$this->tempBgGround=$tempBgGround;
		$this->tempWidth=$tempWidth;
		$this->tempHeight=$tempHeight;

		//$this->profileTmpFileID=$profileTmpFileID;
		$this->profileTouchJumpUrl=$profileTouchJumpUrl;
		$this->profileDiv=$profileDiv;

		//复制模板，获得新的模板ID;
		
		if($action=='import'){
			//$profileTemplateInfo=$profileTemplateInfo;
			//echo Information("导入模板信息",$profileDivInfo);
			$this->copyTemplateImport($profileTemplateInfo);
			$usLog["profileTemp"]=$profileTemplateInfo;
		}
		if($action=="add"){
			//$state=$this->copyTemplate($profileTmpID);
            $state=$this->saveTemp($profileTemplateInfo);
			if($state[0]=="false")
			{
				return $state[1];
			}
			$usLog["copyTemplate"]=$state[1];
			
			$result=$this->saveProfileDatas();
			if($result[0]=="false")
			{
				return $result[1];
			}
			$usLog["saveProfileData"]=$result[1];
		}
		
		if($action=="edit"){
            $this->profileTmpID=$profileTmpID;
			$this->updateProfile($profileID);
			$this->updateFastTemplate($profileTemplateInfo,$profileTmpID);
		}
		
		return array("true",$usLog);
	}
	
	//生成html
	//isClient是否是给终端用的Html
	function createOption($isClient='1'){
		$options=$this->getOptions();
		$TouchScreen='';
		$htmlHead="";
		foreach($options as $option){
			if($option['optionName']=='Touch_Jump_Setting'){
				$TouchScreen=$option['optionValue'];
			}
		}
		return $htmlHead='<meta name="TouchScreen" content="'.$TouchScreen.'" />';
	}
	
	function createProfileTouchInfo(){
		return $htmlHead='<meta name="TouchScreen" content="'.$this->profileTouchJumpUrl.'" />';
		
	}
	//生成div
	function createDiv($left,$top,$width,$height,$cont,$id='',$relevanceKey){
		if($relevanceKey!="")
		{
			$relevanceKey='relevanceKey="'.$relevanceKey.'"';
		}
		$div='<div title="viewArea" style="position: absolute; left: '.$left.'px; top:'.$top.'px; width: '.$width.'px; height: '.$height.'px; z-index: 1; word-break:break-all; overflow: hidden" id="layer'.$id.'" '.$relevanceKey.'>';
		$div.=''.$cont.'</div>'."\n";
		return $div;
	}
	//生成htmlbody内容，1是给终端用
	function createHtmlBody($isClient='1',$div=array()){
		$areaInfo=$this->profileDiv;
		$htmlBody='';
		if(!empty($this->tempBgGround)){
			$htmlBody.='<div style="position: absolute; left: 0px; top:0px; width: '.$this->tempWidth.'px; height: '.$this->tempHeight.'px; z-index: 0; word-break:break-all; overflow: hidden" id=tempBG><img src='.$this->tempBgGround.' border="0" width="100%" height="100%"></div>'."\n";
		}
		foreach($areaInfo as $k=>$v){
			if($isClient=="1"){
				if($v['type']=='Video'|| $v['type']=='Txt'){ //当是给终端用时，主区域和滚动字幕不要处理html;
					continue;
				}
			}
			//pArr($div[$i]);
			$htmlBody.=$this->createCont($v);
		}
		return $htmlBody;
	}
	//img区域js代码
	public $imgCount=0;
	function createImgJs($div=array())
	{
		$id=$div['id'];
		$relevanceKey=isset($div['relevanceFileMd5'])?$div['relevanceFileMd5']:$div['id'];
		$areaType=$div['type'];
		$filesArr=$div['files']; //图片区域的文件数组
		foreach($filesArr as $k=>$v)
		{
			$oneFile=$v;//取第一个文件的属性
			break ;
		}
		
		$changeTime=$oneFile["playInfo"]['playTime']*1000+$this->imgCount*300;//去第一个图片文件的时间作为切换时间转成js中的秒
		$this->imgCount+=1;
		
		
		$js_img_str="";
		if($areaType=='Img'){  //生成图片区域的js
			foreach($filesArr as $k=>$v){
				$js_img_str.='"'.$v["fileInfo"]['filePath'].'",';
			}
		}
		$js_img_str=substr($js_img_str,0,strlen($js_img_str)-1);
		$jsStr="<script language='javascript'>
				var obj_$relevanceKey={
					img_id:'obj$id',
					str_relevanceKey:'$relevanceKey',
					arr_files:[$js_img_str], 
					arr_oldFiles:[$js_img_str], 
					state:'unrestart',
					st:'',
					playImg:function()
					{
						changeImg(obj_$relevanceKey.img_id,obj_$relevanceKey.arr_files,obj_$relevanceKey.state);
						if(obj_$relevanceKey.st!='')
						{
							window.clearTimeout(obj_$relevanceKey.st);
						}
						obj_$relevanceKey.state='unrestart';
						obj_$relevanceKey.st=window.setTimeout(obj_$relevanceKey.playImg,$changeTime);
					}
				};
				obj_$relevanceKey.playImg();
				</script>
				";
		return $jsStr;
	}
	function createSwfJs($div=array()){
		$id=$div['id'];
		$areaType=$div['type'];
		$filesArr=$div['files'];
		//list($left,$top,$width,$height)=$div['location'];
		$left=$div['location']['left'];
		$top=$div['location']['top'];
		$width=$div['location']['width'];
		$height=$div['location']['height'];
		//$changeTime=$div['files'][0]['playTime'];
		$jsStr="<script>\n";
		$id="show_flash_player".$id;	//js对象id;
			//js对象id;
		$filesArray=array();
		$playTimeArr=array();
		//pArr($filesArr);
		if($areaType=='Swf'){  //生成swf区域的js
			$i=0;
			foreach($filesArr as $k=>$v){
				//$filesArray[$i]=urlencode(iconv('gb2312','utf-8',basename($filesArr[$i]['filePath'])));
				$filesArray[$i]=basename($v['fileInfo']['filePath']);
				$playTimeArr[$i]=$v['playInfo']['playTime'];
				$i++;
			}
		}

		$jsFilesArr=json_encode($filesArray);
		$jsPlayTimeArr=json_encode($playTimeArr);
		$jsStr.="var filesArr=".$jsFilesArr.";\n";
		$jsStr.="var playTimeArr=".$jsPlayTimeArr.";\n";
		$jsStr.="var fPlayer1 = new PlayFlash(filesArr,playTimeArr);\n";
		$jsStr.="var flashWH1 = {w:".$width.",h:".$height."};\n";
		$jsStr.="var iframeWH1 ={w:".$width.",h:".$height."};\n";
		$jsStr.="fPlayer1.createIframe(\"".$id."\");\n";
		$jsStr.="fPlayer1.iframeInfo(iframeWH1);\n";
		$jsStr.="fPlayer1.createFlashInfo(flashWH1);\n" ;
		$jsStr.='var currTimer1 = window.setInterval(function(){ fPlayer1.runItem() },1000)';
		/*var fPlayer1 = new PlayFlash(arrFlash, arrFPlayTime);
		var flashWH1 = {w:objWidth,h:objHeight};
		var iframeWH1 ={w:objWidth,h:objHeight};
		fPlayer1.createIframe(objID);//指定flash播放的框架
		fPlayer1.createFlashInfo(flashWH1);
		fPlayer1.iframeInfo(iframeWH1);
		var currTimer1 = window.setInterval(function(){ fPlayer1.runItem() },1000);*/
		$jsStr.="</script>";
		//echo $jsStr;
		return $jsStr;
	}
	//这里只是单独的某个区域
	function createCont($div=array()){
		//$div=$this->profileDiv;
		$cont='';
		$id=$div['id'];
		$areaType=$div['type'];
		//list($left,$top,$width,$height)=$div['location'];//div绝对定位
		$left=$div['location']['left'];
		$top=$div['location']['top'];
		$width=$div['location']['width'];
		$height=$div['location']['height'];
		$relevanceKey=isset($div['relevanceFileMd5'])?$div['relevanceFileMd5']:"";
		$filesArr=$div['files'];//文件数组
		$fileNum=count($filesArr);
		
		//echo print_r($filesArr);
		
	if($fileNum<=0){$htmlCont=$this->createDiv($left,$top,$width,$height,$cont,$id,$relevanceKey); return $htmlCont;}
 		foreach($filesArr as $k=>$v)
		{
			$file=$v;//取第一个文件的属性
			break ;
		}
		$playInfo=$file['playInfo'];
		$fileInfo=$file['fileInfo'];
		$filelocalPath=$this->profileName.$this->zhcnBaseName($fileInfo['filePath']);
		//$ftpPath=$this->getFtpPath($file['filePath']);
		
		switch($areaType){
			case 'Video':
				$cont=$this->ProfileExtendHtml->videoTypeHtml(base_url().FILELIB.$this->profileName,$width,$height);
				break;
			case 'Img':
				$cont='<img id=obj'.$id.' curIndex="0" border="0" src="'.$fileInfo['filePath'].'" width='.$width.' height='.$height.'>' ;
				if($fileNum>1){
					$cont.=$this->createImgJs($div);//当图片数量大于1的时候将进行切换
				}
				break;
			//视屏和图片只取第一个文件
			case 'Txt':
			$fsize=explode(".",$height);
			$fsize=$fsize[0]-2;
				//滚动字幕预览时取第一个文件的属性
				$cont='<marquee scrollamount = "'.$playInfo['scrollamount'].'" direction="'.$playInfo['direction'].'" style=" height:'.$height.'px; line-height:'.$height.'px;background-color:'.$playInfo['bgcolor'].'; font-size:'.$fsize.'px;font-family:\''.$playInfo['fontName'].'\';  color:'.$playInfo['fontcolor'].';">';
				$txtContent=$this->getTxtCont($filesArr);
				$txt=preg_replace("/\r\n|\n|\r| /",'',$txtContent);
				$txt=@iconv("GBK","UTF-8",$txtContent); //防止中文乱码
				if(is_bool($txt))
				{
					$txt= iconv("UTF-8","UTF-8",$txtContent);
				}
				$cont=$cont.$txt.'</marquee>';
				break;
			case 'Swf':
				$cont='<iframe id="show_flash_player'.$id.'" src="fplayer.html?flash=default" width='.$width.' height='.$height.' marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no align=center></iframe>';
				$file=SWF."/fplayer.html";
				$newfile=FILELIB.$this->profileName."/fplayer.html";
				if (!copy($file, $newfile)) {
    				errStr("复制文件fplayer.html 失败，创建html文件时");
				}

				if($fileNum>0){
					$cont.=$this->createSwfJs($div);	//swf超过1的时候进行切换;
				}
				break;
			case 'Url':
				switch ($fileInfo['fileType'])
				{
					case 'Url':
						$cont='<iframe id="IFRAME'.$id.'"  src="'.urldecode($fileInfo['filePath']).'" style="width:'.$width.'px; height:'.$height.'px; overflow: hidden;" hspace="0" vspace="0" frameborder="0" scrolling="no" align="center"></iframe>';
						$cont.="<script>";
						foreach($filesArr as $k=>$v)
						{
							$playInfo=$v['playInfo'];
							$fileInfo=$v['fileInfo'];
							
							$arg='{src:"'.urldecode($fileInfo['filePath']).'",intermittent:'.$playInfo["playTime"].'}';
							
							$cont.='webAreaPlayer.addSrc("IFRAME'.$id.'",'.$arg.');
							';
							
						}
						$cont.="</script>";
						break;
					case 'Url1':
						// $txt=$this->getTxtCont($filesArr);
						// if($playInfo['direction'] == 0)
						// {
							// $cont='<td bgcolor=#ffffff>'.$txt.'</td>';
						// }
						// else if($playInfo['direction'] == 1)
						// {
							// $cont = '<marquee direction="up" scrollamount="2">'.$txt.'</marquee>';
						// }
						// else if($playInfo['direction'] == 2)
						// {
							// $cont = '<marquee direction="left" scrollamount="3" style=" height:'.$height.'px; line-height:'.$height.'px;background-color:'.$playInfo['bgcolor'].';">'.$txt.'</marquee>';
						// }
						$cont='<iframe id="IFRAME'.$id.'" src="'.urldecode($fileInfo['filePath']).'" style="width:'.$width.'px; height:'.$height.'px; overflow: hidden;" hspace=0 vspace=0 frameborder=0 scrolling=no align=center></iframe>';
						
						
						break;
					case 'Url2':
						$txt=$this->getTxtCont($filesArr);
						if($playInfo['direction'] == 0)
						{
							$cont='<td bgcolor=#ffffff>'.$txt.'</td>';
						}
						else if($playInfo['direction'] == 1)
						{
							$cont='<marquee scrollamount = "'.$playInfo['scrollamount'].'" direction="up" style=" height:'.$height.'px; background-color:'.$playInfo['bgcolor'].';"> <span style=" font-size:'.$playInfo['fontsize'].'px;font-family:'.$playInfo['font'].';  color:'.$playInfo['fontcolor'].';">';
							$cont=$cont.$txt.'</span></marquee>';
						}
						else if($playInfo['direction'] == 2)
						{
							$cont='<marquee scrollamount = "'.$playInfo['scrollamount'].'" direction="left" style=" height:'.$height.'px; line-height:'.$height.'px;background-color:'.$playInfo['bgcolor'].';"> <span style=" font-size:'.$playInfo['fontsize'].'px;font-family:'.$playInfo['font'].';  color:'.$playInfo['fontcolor'].';">';
							$cont=$cont.$txt.'</span></marquee>';
						}
						break;
					default:
						break;
				}
				break;
			case 'Audio':
				$left="0";
				$top="0";
				$width="1";
				$height="1";
				$cont='<iframe id="Audio_'.$id.'" src="about:blank" style="width:1px; height:1px; overflow: hidden;" hspace="0" vspace="0" frameborder="0" scrolling="no" align="center"></iframe>';
				$cont.="<script>";
				foreach($filesArr as $k=>$v)
				{
					$playInfo=$v['playInfo'];
					$fileInfo=$v['fileInfo'];
					
					$arg='{mp3:"'.basename(iconv("utf-8","gbk",urlencode($fileInfo['filePath']))).'",'
					.'loop:"1",'
					.'autoplay:"1",'
					.'volume:"'.$playInfo["volume"].'",'
					.'intermittent:"'.$playInfo["playTime"].'",'
					.'src:"audioPlayer.html"}';
					
					$cont.='bgAudioAreaPlayer.add("Audio_'.$id.'",'.$arg.');
					';
				}
				$cont.="</script>";
				$this->ProfileExtendHtml->setAudioPlay($this->profileName);				
				break;
			default:
			   $cont='';
			    break;
		}
		$htmlCont='';
		$htmlCont=$this->createDiv($left,$top,$width,$height,$cont,$id,$relevanceKey);
		return $htmlCont;

	}
	function getTxtCont($files){
		$txt='';
		foreach($files as $k=>$v){
			$txt.=file_get_contents($this->getLocalPath($v['fileInfo']['filePath']));
		}
		return $txt;
	}
	function getLocalPath($file){
		$file=$this->zhcnBaseName($file);
		$localfile=FILELIB.$this->profileName."/".$file;
		//echo Information("getLocalPath",$localfile);
		return $localfile;
	}
	function writeHtml($file,$html){
		$iswrite=file_put_contents($file,$html);
		return $iswrite;
	}
	
	//★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
	//	调用Phptar.php打包
	//  $tarPath        tar包保存路径 例如: ss/ssa/sss.tar
	//  $folderPath     被打包的路径
	//
	//  路径 CI\system\application\libraries\PhpTar.php
	//---------------------------------------------
	function createTarByPhp($tarPath,$folderPath)
	{
		$this->load->library('PhpTar');
		$this->phptar->createTar($tarPath,$folderPath);
	}
	//-------------------------------------------------
	//- 滚动字幕包
	//-------------------------------------------------
	function createTarImgByPhp($tarPath,$folderPath)
	{
		$this->createTarByPhp($tarPath,$folderPath);
	}
	//-------------------------------------------------
	//- Profile Tar字幕包
	//-------------------------------------------------
	function createProfileTarByPhp($tarPath,$folderPath)
	{
		$this->createTarByPhp($tarPath,$folderPath);
	}
	//-------------------------------------------------
	//- LED Tar包
	//-------------------------------------------------
	function createLEDTar($filename,$folders)
	{
		$this->createTarByPhp($filename,$folders);
	}
    
    function androidTar($fileName,$folders)
    {
        //7za a 包路径 文件路径
		@set_time_limit(120);
        $filePath=base_url()."createProfileBags.php?fileName=".$fileName."&folders=".$folders."&type=".$this->profileType;
		$handle = fopen($filePath, "r");
		$contents = "";
		while (!feof($handle)) {
			$contents.= fgets($handle, 4096);
		}
		fclose($handle);
		
	//	echo  $filePath."</br>".$contents;
		$res=json_decode($contents,true);
		if(isset($res["state"])&&$res["state"])
		{
			return true ;
		}
		return false;
    }
	//-------------
	//-
	//- 打包程序结束
	//- 2011年6月14日13:06:50
	//★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
	
	//上传
	function uploadFile($filefilePath='',$ftpfilePath=''){
		//$fileName='1.tar';
		//$this->ftp->upload(getcwd().'/FileLib/'.$fileName, '/tar/'.$fileName, 'ascii', 0775);
		//$this->ftp->upload(getcwd().'/FileLib/'.$fileName, '/tar/'.$fileName);
		//errStr($filefilePath.$ftpfilePath);
					
		$this->ftpHandel=$this->contentFTP();
		//var_dump($this->ftpHandel);
		//$ftpfilePath=substr($ftpfilePath,1);
		//echo Information("uploadFile","localFilePath: ".$filefilePath."<br> ftpPath: ".$ftpfilePath);	
		$this->ftpHandel->upload($filefilePath, $ftpfilePath);//本地地址，ftp地址
		

	}
	//上传文件组
	function uploadFiles($filefilePath='',$ftpfilePath=''){

		$this->contentFTP();
		$this->ftpHandel->upload($filefilePath, $ftpfilePath);//本地地址，ftp地址
		$this->ftpHandel->close();
	}
	//下载所需的文件
	function downloadFiles($localPath='',$divFiles=array()){
		$divInfo=$this->profileDiv;//所有区域的信息
		//pArr($divInfo);
		$divInfoNum=count($divInfo);
		if($divInfoNum<=0){
			errStr("没有区域信息");
		}
		if(is_dir($localPath) || @mkdir($localPath)){
		}else{
			errStr($localPath."创建失败，(downloadFiles)！");
		}
		for($i=0;$i<$divInfoNum;$i++){
			if($divInfo[$i]['type']=='Video' || $divInfo[$i]['type']=='Url'){
				continue;
			}else if($divInfo[$i]['type']=='Url'){
				$fileInfo=$divInfo[$i]['files'];
				$fileCount=count($fileInfo);
				for($j=0;$j<$fileCount;$j++){
					if(strpos('http',$fileInfo[$j]['filePath'])===false){
						$this->downloadFile($fileInfo[$j]['filePath'],$localPath);
					}else{
						continue;
					}
				}
			}else{
				$fileInfo=$divInfo[$i]['files'];
				$fileCount=count($fileInfo);
				//pArr($fileInfo);
				for($j=0;$j<$fileCount;$j++){
					//errStr($fileInfo[$j]['filePath'].$localPath);
					$this->downloadFile($fileInfo[$j]['filePath'],$localPath);
				}
			}
		}
	}
	//下载
	function downloadFile($ftpfilePath='',$localPath=''){
		$filename=basename($ftpfilePath);
		$this->ftpHandel->download($ftpfilePath,$localPath.$filename);
		//$this->ftp->close();不能关闭ftp连接，
	}
	function listFiles($filefilePath=''){
		$list = $this->ftpHandel->list_files('/');
		showMessage($list);
	}
	//保存profile数据库表内容
	function saveProfileDatas(){
       // var $proName=utf8ToGbk();

		$data = array(
			   'ProfileType' => $this->profileType,
               'ProfileName' => $this->profileName,
               'ProfilePeriod' => $this->profilePeriod,
               'TemplateID' => $this->profileTmpID,
			   //'TemplateFileID'=>$this->profileTmpFileID,
			   'TouchJumpUrl'=>$this->profileTouchJumpUrl,
			   "Extend4"=>$this->userEntity->userID,
			   "Extend5"=>$this->userEntity->userGroupID
            );
		
		$this->db->insert('profile', $data); 
		//echo "\n".$this->db->affected_rows();
		if($this->db->affected_rows()>0){
			$this->profileID=$this->db->insert_id();
			return trueInfo($data,"profile");
		}else{
			$this->profileID=0;
			return array("false",errorInfo(1007));
		}
	}
	function insertTar($tarID){
		$data=array('TemplateFileID'=>$tarID);
		$this->db->where('ProfileID', $this->profileID);
		$this->db->update('profile', $data);
		if($this->db->affected_rows()<=0)
		{
			return falseInfo(1019);
		}
		return trueInfo($data,"profile");
	}
	//保存到数据库中文件信息,单个的某个区域
	function saveFilesInfo($playlistID,$div=array()){
		$areaType=$div['type'];
		$filesArr=$div['files'];//文件数组
		//echo "<hr /><pre>";
		//echo print_r($filesArr);
		//echo "</pre>";
		$fileNum=count($filesArr);
		if($fileNum<=0){return array("true",array("data"=>array("playlistID"=>"","div"=>$div)));};
		//$file=$filesArr[0];//取第一个文件的属性
		switch($areaType){
			case 'Video':
				$i=0;
				foreach($filesArr as $k=>$v){
				//	//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
				
					//C1-C5 ，c9 int型，C-C8varchar
					//COntralPara1 //播放时长
					//ControlPara2,ControlPara3,ControlPara4,ControlPara9暂时没用到，播放word时可能需要用到
					$data=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileID,
								'PlayOrder'=>$i + 1,
								'ControlPara1'=>(float)$v['playInfo']['playTime']*1000,
								'ControlPara2'=>$v['playInfo']['replayCount'],
								'ControlPara3'=>$v['playInfo']['replayCount'], //总次数未用到
								'ControlPara4'=>isset($v['playInfo']['speed'])?$v['playInfo']['speed']:3, //word播放速度
								'ControlPara9'=>0); //ppt或word映射ID
					$this->db->insert('playlist_describe',$data);
					if($this->db->affected_rows()<=0){
						//errStr("主区域文件插入失败");
						return array("false",errorInfo(1011));
					}
					$i++;
				}
				break;
			case 'Img':
				$i=0;
				foreach($filesArr as $k=>$v){
					//COntralPara1 //播放时长
					//ControlPara2 暂时没用到不知
					$playTime=isset($v['playInfo']['playTime'])?$v['playInfo']['playTime']:1;
					$replayCount=isset($v['playInfo']['replayCount'])?$v['playInfo']['replayCount']:1;
					//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
					$data=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileID,
								'PlayOrder'=>$i + 1,
								'ControlPara1'=>$playTime,
								'ControlPara2'=>$replayCount
								);
					/*$sqlStr="insert into playlist_describe(PlaylistID,PlayFileID,PlayOrder,ControlPara1,
						ControlPara2) values(%s,%s,%d,%d,%d)",$playlistID,$playFileID,
						i + 1, $filesArr[$i]['playTime'], '');
					$this->db->query($sqlStr);*/
					$this->db->insert('playlist_describe',$data);
					if($this->db->affected_rows()<=0){
						//errStr("图片区域文件插入失败");
						return array("false",errorInfo(1012));
					}
					$i++;
				}
				break;
			case 'Swf'://存贮数组位置
				$i=0;
				foreach($filesArr as $k=>$v){
					//COntralPara1 //播放时长
					//ControlPara2 暂时没用到不知
					//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
					$playTime=isset($v['playInfo']['playTime'])?$v['playInfo']['playTime']:1;
					$replayCount=isset($v['playInfo']['replayCount'])?$v['playInfo']['replayCount']:1;
					$data=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileID,
								'PlayOrder'=>$i + 1,
								'ControlPara1'=>$playTime,
								'ControlPara2'=>$replayCount
								);
					/*$sqlStr="insert into playlist_describe(PlaylistID,PlayFileID,PlayOrder,ControlPara1,
						ControlPara2) values(%s,%s,%d,%d,%d)",$playlistID,$playFileID,
						i + 1, $filesArr[$i]['playTime'], '');
					$this->db->query($sqlStr);*/
					$this->db->insert('playlist_describe',$data);

					if($this->db->affected_rows()<=0){
						//errStr("flash区域文件插入失败");
						return array("false",errorInfo(1013));
					}
					$i++;
				}
				break;
			//视屏和图片只取第一个文件
			case 'Txt': 
				
				$uid=$this->userEntity->userID;
				//转换成图片并上传到服务器
				
				$sql="INSERT INTO `playlist_describe` (
					`PlaylistID` ,
					`PlayFileID` ,
					`PlayOrder` ,
					`ControlPara1` ,
					`ControlPara2` ,
					`ControlPara3` ,
					`ControlPara4` ,
					`ControlPara5` ,
					`ControlPara6` ,
					`ControlPara7` ,
					`ControlPara8` ,
					`ControlPara9` 
					)
					VALUES ";
					
				$fileInfo_array=array();
				$i=0;
				foreach($filesArr as $k=>$v)
				{
					//$playFileId				=	$this->savePlayFileProperty($v);
					$playFileId				=	$v['fileInfo']['fileID'];;
					$filePath			=	$v['fileInfo']['filePath'];
					$bgColor				=	$v['playInfo']['bgcolor'];
					$bgColorRGB				=	color2rgb($v['playInfo']['bgcolor']);//字体背景色
					$bgColorInt				=	hexdec($bgColor);
					$fontFile				=	$v['playInfo']['font'];
					$fontSize				=	$v['playInfo']['fontsize'];
					$fontColor				=	$v['playInfo']['fontcolor'];
					$fontColorRGB			=	color2rgb($fontColor);

					//$fontColorInt=color2int($fontColorRGB);
					$fontColorInt=hexdec($fontColor);//
					$speed=$v['playInfo']['scrollamount'];
					$direction=$v['playInfo']['direction'];
					$bgground=isset($v['playInfo']['bggound'])?$v['playInfo']['bggound']:'';
					$playNum=isset($v['playInfo']['replayCount'])?$v['playInfo']['replayCount']:5;//滚动次数
					//exit();
                    $Parameter["filePath"]=$v['fileInfo']['filePath'];
                    $Parameter["bgColor"]=$bgColorRGB;
                    $Parameter["height"]=$div["location"]["height"];
                    $Parameter["fontFile"]="Fonts/".$fontFile;
                    $Parameter["fontSize"]=$fontSize==1?round($Parameter["height"]-20):$fontSize;
                    $Parameter["fontColor"]=$fontColorRGB;
                    $Parameter["playFileId"]=$playFileId;
                    //--  SIGMA 和 NXP 滚动字幕兼容处理
                    if($this->profileGlobal["profileType"]=="NXP")
                    {
                        $Parameter["width"]=$div["location"]["width"];
                    }
                    
                    $Parameter["index"]=$uid.$i;
					$imgInfo=$this->makeScrollTxt($Parameter);//转换成图片;

					$fileInfo_array[$i]["sqlInfo"]=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileId,
								'PlayOrder'=>$i + 1,
								'ControlPara1'=>$fontSize,
								'ControlPara2'=>$fontColorInt,
								'ControlPara3'=>$bgColorInt,
								'ControlPara4'=>$speed,
								'ControlPara5'=>$playNum,//重复次数
								'ControlPara6'=>$fontFile, //字体类型
								'ControlPara7'=>$direction, //滚动类型
								'ControlPara8'=>$bgground, //网页模板背景
								'ControlPara9'=>""
								);
					$fileInfo_array[$i]["tarInfo"]=$imgInfo;
					$i++;
				}
				
				//被拼合是的SQl
				$sql_value="";
				//获取播放的滚动字幕包的 FTP 地址的id
				//赋值给 相应数据 信息中的字段
				//并且上传文件
   	            $file_info=array();
                $sfix="";

				foreach($fileInfo_array as $k=>$f)
				{
				     $tarPath="";
                     $ftpPath="";
				    //创建压缩包
                    switch($this->profileType)
                    {
                        case "X86":
                            $tarPath = $f["tarInfo"]["filePath"].".tar";//滚动字幕tar包本地路径
                            $ftpPath = $f["tarInfo"]["ftpfilePath"].".tar";
                            $this->createTarImgByPhp($tarPath,$f["tarInfo"]["dirPath"]);
                        break;
                        case "Android": 
                            $tarPath = $f["tarInfo"]["filePath"].".7z";//滚动字幕.7z包本地路径
                            $ftpPath = $f["tarInfo"]["ftpfilePath"].".7z";
                            $this->androidTar($tarPath,$f["tarInfo"]["dirPath"]);
                        break;
                    }
                  
					$this->removeDir($f["tarInfo"]["dirPath"]);
                    
					
					//检查 滚动那个字幕包 是否生成成功
					if(!file_exists($tarPath))
					{
						//echo Information("滚动字幕tar包生成失败",preg_replace("/\//","\\",getcwd()."\\".$tarPath));
						
						$this->ProfileInfo->resetProfileCacheFiles($this->$profileName);
						exit();
					}
					$m5 			= md5_file($tarPath);//滚动字幕包的MD5
					$uploadPath		= $ftpPath;
					$ftpPath 		= $ftpPath;//滚动字幕包在ftp上的地址
					$fs['fileInfo']['filePath']=$ftpPath;
					$playTxtImgID 	= $this->savePlayFileProperty($fs,"1",$m5); //获得滚动字幕图片URL地址的ID
					$f["sqlInfo"]["ControlPara9"]=$playTxtImgID;
					sleep(2);
					//上传滚动字幕包
					$uploadState=$this->uploadFile($tarPath,$uploadPath);
					if($uploadState)
					{
						//删除滚动字幕Tar包
						unlink($tarPath);
					}
					//拼合sql语句
					$d=$f["sqlInfo"];
					$sql_value.="(".$d["PlaylistID"].",".$d["PlayFileID"].",".$d["PlayOrder"].",".$d["ControlPara1"].",".$d["ControlPara2"].",".$d["ControlPara3"].",".$d["ControlPara4"].",".$d["ControlPara5"].",'".$d["ControlPara6"]."','".$d["ControlPara7"]."','".$d["ControlPara8"]."',".$d["ControlPara9"]."),";
				}
					//删除滚动字幕Tar包
					//$this->createTar($deltar);
					$sql_value=$sql.substr($sql_value,0,strlen($sql_value)-1);
					$this->db->query($sql_value);//出错了只循环到这里。
					if($this->db->affected_rows()<=0)
					{
						//echo("滚动字幕区域文件插入失败<br>".$sql.$sql_value);
						return array("false",errorInfo(1014));
						
					}
				break;

			case 'Url':
				$i=0;
				foreach($filesArr as $k=>$v){
					//COntralPara1 //播放时长
					//ControlPara2 暂时没用到不知
					//$playFileID=$this->savePlayFileProperty($filesArr[$i]); 
					switch($v['fileInfo']['fileType'])
					{
						case 'Url':
						//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
							$data=array('PlaylistID'=>$playlistID,
									'PlayFileID'=>$playFileID,
									'PlayOrder'=>$i + 1,
									'ControlPara7'=>$v['playInfo']['direction'],//滚动类型
									'ControlPara1'=>$v['playInfo']['playTime']
									);
						
							
							break;
						case 'Url1':
							$playFileID=0; 
							$data=array('PlaylistID'=>$playlistID,
									'PlayFileID'=>$playFileID,
									'PlayOrder'=>$i + 1,
									'ControlPara7'=>$v['playInfo']['direction'],//滚动类型
									'ControlPara1'=>$v['playInfo']['playTime'],
									'ControlPara8'=>$v['playInfo']['strBgorURL']	//网页模板背景
									);
							break;
						case 'Url2':
							//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
							$filePath=$v['fileInfo']['filePath'];
							$bgColor=$v['playInfo']['bgcolor'];
							$bgColorRGB=color2rgb($v['playInfo']['bgcolor']);//字体背景色

							$bgColorInt=hexdec($bgColor);
							$fontFile=$v['playInfo']['font'];
							$fontSize=$v['playInfo']['fontsize'];
							$fontColor=$v['playInfo']['fontcolor'];
							$fontColorRGB=color2rgb($fontColor);

							//$fontColorInt=color2int($fontColorRGB);
							$fontColorInt=hexdec($fontColor);//
							$speed=$v['playInfo']['scrollamount'];
							$direction=$v['playInfo']['strMoveType'];//
							$bgground=isset($v['playInfo']['strBgorURL'])?$v['playInfo']['strBgorURL']:'';
							$playNum=isset($v['playInfo']['replayCount'])?$v['playInfo']['replayCount']:5;//滚动次数
							//$this->makeScrollTxt($filesArr[$i]['filePath'],$bgColorRGB,$fontFile,$fontSize,$fontColorRGB,$playFileID);//转换成图片并上传到ftp;
							//echo Information("滚动字幕包在ftp上的地址",FTPTXT.basename($filesArr[$i]['filePath'],".txt").$playFileID.".tar");
							$ftpfilePath['fileInfo']['filePath']=$this->getFtpPath(FTPTXT.basename($v['fileInfo']['filePath'],".txt").$playFileID.".tar"); //滚动字幕包在ftp上的地址
							//echo $ftpfilePath['filePath'];
							$playTxtImgID=$this->savePlayFileProperty($ftpfilePath,"1"); //获得滚动字幕图片URL地址的ID

							$data=array('PlaylistID'=>$playlistID,
										'PlayFileID'=>$playFileID,
										'PlayOrder'=>$i + 1,
										'ControlPara1'=>$fontSize,
										'ControlPara2'=>$fontColorInt,
										'ControlPara3'=>$bgColorInt,
										'ControlPara4'=>$speed,
										'ControlPara5'=>$playNum,//重复次数
										'ControlPara6'=>$fontFile, //字体类型
										'ControlPara7'=>$direction, //滚动类型
										'ControlPara8'=>$bgground, //网页模板背景
										'ControlPara9'=>$playTxtImgID
										);
							break;
						default:
							;
					}
					$this->db->insert('playlist_describe',$data);
					if($this->db->affected_rows()<=0){
						//errStr("网页模板Url区域文件插入失败");
						return array("false",errorInfo(1015));
					}
					$i++;
				}
				break;
			case 'Audio':
				$i=0;
				foreach($filesArr as $k=>$v){
					//COntralPara1 //播放时长
					//ControlPara2 暂时没用到不知
					//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
					$data=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileID,
								'PlayOrder'=>$i + 1,
								'ControlPara1'=>$v['playInfo']['playTime'],
								'ControlPara2'=>$v['playInfo']['replayCount'],//重复次数
								'ControlPara3'=>0, //总次数
								'ControlPara5'=>$v['playInfo']['volume']);
					/*$sqlStr="insert into playlist_describe(PlaylistID,PlayFileID,PlayOrder,ControlPara1,"
						"ControlPara2,ControlPara3,ControlPara5) values(%s,%s,%d,%d,%d,%d,%d)",
						$playlistID,  $playFileID, i + 1, $filesArr[$i]['playTime'], '', '', $filesArr[$i]['volume']);*/
					$this->db->insert('playlist_describe',$data);
					if($this->db->affected_rows()<=0){
						//errStr("背景音乐区域文件插入失败");
						return array("false",errorInfo(1016));
					}
					$i++;
				}
				
				break;
			//
			case 'LED':
				$i=0;
				foreach($filesArr as $k=>$v){
					//$playFileID=$this->savePlayFileProperty($v);
$playFileID=$v['fileInfo']['fileID'];
					$filePath=$v['fileInfo']['filePath'];
					$bgColor=$v['playInfo']['bgcolor'];
					$bgColorRGB=color2rgb($v['playInfo']['bgcolor']);//字体背景色

					$bgColorInt=hexdec($bgColor);
					$fontFile=$v['playInfo']['font'];
					$fontSize=$v['playInfo']['fontsize'];
					$fontColor=$v['playInfo']['fontcolor'];
					$fontColorRGB=color2rgb($fontColor);

					//$fontColorInt=color2int($fontColorRGB);
					$fontColorInt=hexdec($fontColor);//
					$speed=$v['playInfo']['scrollamount'];
					$direction=$v['playInfo']['direction'];
					$bgground=isset($v['playInfo']['bggound'])?$v['playInfo']['bggound']:'';
					$playNum=isset($v['playInfo']['replayCount'])?$v['playInfo']['replayCount']:5;//滚动次数
					//exit();
					//生成的文件名
					$newFileName=substr(time(),-7,7).$i.'.R01';
					$font=urldecode($fontFile);
					$width=$v['playInfo']['width'];
					$height=$v['playInfo']['height'];

					$delayTime=$v['playInfo']['delayTime'];
					$fontB=$v['playInfo']['fontB'];
					$fontI=$v['playInfo']['fontI'];
					$fontU=$v['playInfo']['fontU'];

					$md5=$this->makeLEDTxt($v['fileInfo']['filePath'],'FileLib',$font,$fontSize,$width,$height,$newFileName,$direction);//转换成图片并上传到ftp;
					$ftpfilePath['fileInfo']['filePath']=$this->getFtpPath(FTPLED.$newFileName); //滚动字幕包在ftp上的地址
					//echo $ftpfilePath['filePath'];
					//$md5=md5_file(FILELIB.$newFileName);
					$playTxtImgID=$this->savePlayFileProperty($ftpfilePath,"1",$md5); //获得滚动字幕图片URL地址的ID
					//
					$data=array('PlaylistID'=>$playlistID,
								'PlayFileID'=>$playFileID,
								'PlayOrder'=>$i + 1,
								//1-5为数值型，6、7、8 ，字符，9数字
								'ControlPara1'=>$fontSize,  //字号
								'ControlPara2'=>$fontColorInt, //字体颜色
								'ControlPara3'=>$bgColorInt,   //背景颜色
								'ControlPara4'=>$speed,        //滚动速度
								'ControlPara5'=>$playNum,//重复次数
								'ControlPara6'=>$font, //字体类型
								'ControlPara7'=>$direction, //滚动类型
								'ControlPara8'=>$delayTime, //停留时间
								'ControlPara9'=>$playTxtImgID, //存放转换文件后的id号
								'Extend1'=>$fontB,//粗体
								'Extend2'=>$fontI,//斜体
								'Extend3'=>$fontU//下划线
								);

					/*$sqlStr="insert into playlist_describe(PlaylistID,PlayFileID,PlayOrder,ControlPara1,
					ControlPara6,ControlPara2,ControlPara3,ControlPara4,ControlPara5,ControlPara9)"
					" values(%s,%s,%d,%d,'%s',%d,%d,%d,%d,%s)", $playlistID, $playFileID, i + 1,
					$fontSize, $fontFile, $fontColor, $bgColor, $speed, $playNum,
					$playTxtImgID;	*/
					$this->db->insert('playlist_describe',$data);//出错了只循环到这里。
					if($this->db->affected_rows()<=0){
						//errStr("LED区域插入失败");
						return array("false",errorInfo(1017));
					}
					$i++;
				}
				break;
			default:
			    break;
		}
		return array("true",array("data"=>array("playlistID"=>$playlistID,"div"=>$div)));
	}
	function ftpPath($ftpfilePath){
		//将类似于ftp://dj:dj@192.168.100.55/1.jpg->ftp://192.168.100.55/1.jpg
		$ftp=explode("/",$ftpfilePath,3);
		$ftpfilePath=$ftp[0]."//".$ftp[2];
		return $ftpfilePath;
	}
	//记录ftp地址
	function savePlayFileProperty($file,$isChecksum='0',$checkSum=''){
		if($checkSum==''){//可以取本地的md5值
			if($isChecksum==0){
				$checkSum=$file['fileInfo']['filemd5'];
				//$checkSum=empty($file['checkSum'])?md5_file($file['filePath']):$file['checkSum'];
			}else{

				$checkSum=md5_file($file['fileInfo']['filePath']);
			}
		}
		$url=$this->zhcnBaseName($file['fileInfo']['filePath']);
		//echo iconv("GBK","UTF-8",$url)."<br />";
		$fix=explode(".",$url);
		
		//print_r($file);
			
		
		//echo "-----------".$fix[1]."--------<br>";
		if($fix[1]=="tar"||$fix[1]=="7z"){
			$url=$this->getFtpPath($file['fileInfo']['filePath']);
		}
		else{$url=$this->getFtpPath('/'.$file['fileInfo']['filePath']);}
			
		//$url=$this->ftpPath($file['filePath']);
		$fileSize=isset($file['fileInfo']['fileSize'])?$file['fileInfo']['fileSize']:0;
		$modifyDate=isset($file['fileInfo']['modifyDate'])?$file['fileInfo']['modifyDate']:'';
		$data=array('URL'=>$url,
					'FileSize'=>$fileSize,
					'ModifyDate'=>$modifyDate,
					'CheckSum'=>$checkSum);
		//echo Information("savePlayFileProperty",$data);	
		$this->db->insert('play_file_property', $data);
		$playfileID=$this->db->insert_id();
		//$this->db->delete('play_file_property',array('PlayFileID'=>$playFileID));
	//	var_dump($playfileID);
		return $playfileID;
	}
	function copyTemplateImport($tempInfo){ //导入时
		$lengScale=$tempInfo['Scale'];
		$tempType=$tempInfo['Type'];
		$aspectRatio=NULL;
		$bgImg=$tempInfo['BgImg'];
		$profileTmpID=$this->saveTemplate($lengScale,$tempType,$aspectRatio,$bgImg);
		$divInfo=$tempInfo['Area'];
		$divNum=count($divInfo);
		for($i=0;$i<$divNum;$i++){
			$blockID=$divInfo[$i]['BlockId'];
			$x=$divInfo[$i]['left'];
			$y=$divInfo[$i]['top'];
			$width=$divInfo[$i]['width'];
			$height=$divInfo[$i]['height'];
			$blockType=$divInfo[$i]['blockType'];
			$this->saveTemplateDescribe($blockID,$x,$y,$width,$height,$blockType);
		}
		$this->profileTmpID=$profileTmpID;
	}


		//保存模板cheng
	function saveTemp($profileTempInfo)
	{   
		$temp=$profileTempInfo["tempGobal"];
		$data=$profileTempInfo["data"];
		$TemplateName='********'.time();
		$data_1=array(
					'TemplateName'=>'********'.time(),

					'LengthScale'=>$temp["LengthScale"],
					'WidthScale'=>$temp["WidthScale"],
					'TemplateType'=>$temp["type"],
					'TemplatePicFileID'=>0,
					'Extend1'=>$data["backGroundImage"]["name"]
				);
		$this->db->insert('template', $data_1);
		
		//$sql="INSERT INTO template(TemplateName,LengthScale,TemplateType,Extend1) VALUES(".$this->db->escape($TemplateName).",".$temp["resolution"].",".$temp["type"].",'".$data["backGroundImage"]["name"]."')";
		///$this->db->query($sql);
		$id=$this->db->insert_id();
		$profileTmpID=$id;
		$this->profileTmpID=$profileTmpID;
		//echo print_r($info["data"]["areas"]);
		$area_sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID,Extend1) values";
		$sq_value=array();
		foreach($data["areas"] as $k=>$v)
		{
			$itm=$v["info"];
			$k--;
			$sq_value[]="(".round($itm["x"],2).",".round($itm["y"],2).",".round($itm["w"],2).",".round($itm["h"],2).",".$k.",".$id.",'".$itm["extendInfo"]["type"]."')";
		}
		
		$area_sql.=implode(",",$sq_value);
		
		$this->db->query($area_sql);

		$tempDivInfo=array();
		$i=1;
		foreach ($data["areas"] as $k=>$v)

		{	$itm=$v["info"];

	         $tempDivInfo[$i]['blockID']=$k;
			$tempDivInfo[$i]['location']=array(round($itm["x"],2),round($itm["y"],2),round($itm["w"],2),round($itm["h"],2),$itm["extendInfo"]["type"]);
			$i++;
		}
		return array("true",array("tempInfo"=>$temp,"divInfo"=>$tempDivInfo));
	}

	function copyTemplate($tempID){
		$tempInfo=$this->getTemplateInfo($tempID);
		$divInfo=$this->getTemplateDescribeInfo($tempID);
		if(!(count($tempInfo)>0&&count($divInfo)>0))
		{
			return array("false",errorInfo(1008));
		}
		
		$divNum=count($divInfo);
		$lengScale=$tempInfo['length'];
		//$withScale=$tempInfo['width'];
		$tempType=$tempInfo['tempType'];
		$aspectRatio=$tempInfo['aspectRatio'];
		$bgImg=$tempInfo['bgImg'];
		$this->profileTmpID=$profileTmpID=$this->saveTemplate($lengScale,$tempType,$aspectRatio,$bgImg);
		for($i=0;$i<$divNum;$i++){
			$blockID=$divInfo[$i]['blockID'];
			list($x,$y,$width,$height,$blockType)=$divInfo[$i]['location'];
			$this->saveTemplateDescribe($blockID,$x,$y,$width,$height,$blockType);
		}
		//循环区域判断是否LED区域   ----  目前去掉LED区域
		// $divInfoArr=$this->profileDiv;
		// $divNum=count($divInfoArr);
		// foreach($divInfoArr as $k=>$v)
		// {
			// if($v['type']=='LED')
			// {
				// $x=$v['files'][0]['left'];
				// $y=$v['files'][0]['top'];
				// $width=$v['files'][0]['width'];
				// $height=$v['files'][0]['height'];
				// $this->saveTemplateDescribe(100,$x,$y,$width,$height,"Txt");
			// }
		// }
		//return $profileTmpID;
		return array("true",array("tempInfo"=>$tempInfo,"divInfo"=>$divInfo));
	}
	//获得模板信息
	function getTemplateInfo($tempID){
		$query = $this->db->get_where('template',array('TemplateID' => $tempID));
		$tempInfo=array();
		foreach ($query->result() as $row)
		{
			$tempInfo['length']=$row->LengthScale;
			//$tempInfo['width']=$row->WidthScale;
			$tempInfo['aspectRatio']=$row->AspectRatio;
			$tempInfo['tempType']=$row->TemplateType;
			$tempInfo['bgImg']=$row->Extend1;
		}
		return $tempInfo;
	}
	function getTemplateDescribeInfo($tempID){
		$this->db->select('BlockID, X, Y,Width,Height,Extend1');
		$query = $this->db->get_where('template_describe', array('TemplateID' => $tempID));
		$tempDivInfo=array();
		$i=0;
		foreach ($query->result() as $row)
		{	$tempDivInfo[$i]['blockID']=$row->BlockID;
			$tempDivInfo[$i]['location']=array($row->X,$row->Y,$row->Width,$row->Height,$row->Extend1);
			$i++;
		}
		return $tempDivInfo;
	}
	//保存新的模板
	function saveTemplate($lengScale,$tempType,$aspectRatio,$bgImg){
		$data=array(
					'TemplateName'=>'********'.time(),

					'LengthScale'=>$lengScale,
					//'WidthScale'=>$widthScale,
					'AspectRatio'=>$aspectRatio,
					'TemplateType'=>$tempType,
					'TemplatePicFileID'=>0,
					'Extend1'=>$bgImg
				);
		$this->db->insert('template', $data);
		$profileTmpID=$this->db->insert_id();
		$this->profileTmpID=$profileTmpID;
		return $profileTmpID;
	}
	function saveTemplateDescribe($blockID='',$x=0,$y=0,$width=0,$height=0,$blockType){
		$data=array(
					'TemplateID'=>$this->profileTmpID,
					'BlockID'=>$blockID,
					'X'=>$x,
					'Y'=>$y,
					'Width'=>$width,
					'Height'=>$height,
					'Extend1'=>$blockType
					);
		$this->db->insert('template_describe', $data);

	}
	function saveProfileDescribe($seqNum,$playlistID,$playlistType,$playlistSubType=0,$extend1=0,$extend2=0){
		$data=array(
					'ProfileID'=>$this->profileID,
					'SequenceNum'=>$seqNum,
					'PlaylistID'=>$playlistID,
					'PlaylistType'=>$playlistType,
					'PlaylistSubType'=>$playlistSubType,
					'Extend1'=>$extend1,
					'Extend2'=>$extend2
					);
		$this->db->insert('profile_describe', $data);
		if($this->db->affected_rows()<=0){
			//die("保存profile_describe失败");	exit;
			return falseInfo(1006);
		}
		return trueInfo($data,"profile_describe");
	}
	function saveDatas($divInfoArr=array()){
		//profile
		$divInfoArr=$this->profileDiv;//整个profile区域
		$profileID=$this->profileID;  //保存profile表


		//先插入playlist 获得id
		//一个profile有多个区域，记录到PlylistName中去
		$divNum=count($divInfoArr);
		foreach($divInfoArr as $k=>$v){
			$id=$v['id'];
			$data=array('PlaylistName'=>$this->profileName."_".$id,
					    'PlaylistTimeLength'=>'');
						//区域的播放时长
			$this->db->insert('playlist', $data);  //保存playlist表
			$playlistID=$this->db->insert_id();
			if($this->db->affected_rows()<=0){
				return array("false",errorInfo(1009));
			}
			$state=$this->saveFilesInfo($playlistID,$v);//保存play_file_property表和playlist_describe表
			if($state[0]=="false")
			{
				//echo "saveFilesInfo error";
				return $state[1];
			}

			//$type = $divInfoArr[$i]['files'][0]['fileType'];
			$type = $v['type'];
			switch ($type){
				case 'Video':
				    $playlistType = 'VIDEO';
					$playlistSubType=0;
					break;
				case 'Img':
				    $playlistType='PICTURE';
					$playlistSubType=0;
				    break;
				case 'Swf':
				    $playlistType='PICTURE';
					$playlistSubType=1;
					break;
				case 'Txt':
				    $playlistType='MESSAGE';
					$playlistSubType=0;
					break;
				case 'Url':
				    $playlistType='MESSAGE';//网页模板的Url 
					$playlistSubType=3;
					break;
				//---------------------------将所有的网页相关的合并为一种--------------------------------
				// case 'Url1':
					// $playlistType='MESSAGE';//网页模板的超文本
					// $playlistSubType=2;
					// break;
				// case 'Url2':
					// $playlistType='MESSAGE';//网页模板的静态文本
					// $playlistSubType=1;
					// break;
				//------------------------------------------------------------
				case 'Audio':
				    $playlistType='AUDIO';
					$playlistSubType=0;
					break;
				case 'LED':
					$playlistType='LED';
					$playlistSubType=0;
					break;
			}
			$state=$this->saveProfileDescribe($id,$playlistID,$playlistType,$playlistSubType);//保存profile_describe表
			if($state[0]=="false")
			{
				//echo "saveProfileDescribe error";
				return $state[1];
			}
		}

		//保存tar包
		$ftpPath['fileInfo']['filePath']=FTPTAR.$this->profileTarName;
		$tarmd5=md5_file(FILELIB.$this->profileTarName);
		$tarfileID=$this->savePlayFileProperty($ftpPath,"1",$tarmd5);
		//保存到profile表中
		$state=$this->insertTar($tarfileID);
		if($state[0]=="false")
		{
			//echo "insertTar";
			return $state[1];
		}
	}
    //-----------------------------------------------
    //-
    //- 功能：创建滚动字幕
    //- 参数：
    //-      $Parameter["filePath"]        --txt文件路径
    //-      $Parameter["bgColor"]         --背景颜色
    //-      $Parameter["fontFile"]        --字体文件
    //-      $Parameter["fontSize"]        --字体大小
    //-      $Parameter["fontColor"]       --字体颜色
    //-      $Parameter["width"]           --单个图片的宽度
    //-      $Parameter["height"]          --大哥图片的高度
    //-      $Parameter["index"]           --滚滚动字幕tar包名称区别
    //-
    //- 创建时间：2011年9月15日 17:48:39
    //-
    //-----------------------------------------------
	function makeScrollTxt($Parameter)
    {
	
        $fontFile =$Parameter["fontFile"];
        $dirPath  =$Parameter["index"].time();
        //$fontSize =$Parameter["fontSize"];
        $bgColor  =$Parameter["bgColor"];
        $fontColor=$Parameter["fontColor"];
        $fontSize =round($Parameter["fontSize"]);
        $height   =round($Parameter["height"])>200?200:round($Parameter["height"]);
        $maxW     =isset($Parameter["width"])?round($Parameter["width"]):200;
        $maxH=$height=$height>12?$height:12;
        $width    =isset($Parameter["width"])?round($Parameter["width"]):600;
        @session_start();
		if(!isset($_SESSION["scrollImgCacheFolder"]))
		{$_SESSION["scrollImgCacheFolder"]=array();}
		$_SESSION["scrollImgCacheFolder"][]=$dirPath;
        if(!(is_dir($dirPath))){
			if(mkdir($dirPath,0777))	{
			}else{
				echo("创建滚动字幕临时文件夹失败(makeScrollTxt)！");
				exit(0);
			}
		}else{
			$this->removeDir($dirPath);
			if(mkdir($dirPath,0777))	{
			}else{
				echo("创建滚动字幕临时文件夹失败(makeScrollTxt)！");
				exit(0);
			}
		}
        
		file_exists($fontFile) or die("没有找到对应的字体库");
		$textStr=file_get_contents($this->getLocalPath($Parameter["filePath"]));
		$textContent= preg_replace("/\r\n|\n|\r| /",'',trim($textStr));
		$text= @iconv("GBK","UTF-8",$textContent); //防止中文乱码
		if(is_bool($text))
		{
			$text= iconv("UTF-8","UTF-8",$textContent);
		}
        
        /*
            计算并返回一个包围着 TrueType 文本范围的虚拟方框的像素大小
            0 左下角 X 位置 
            1 左下角 Y 位置 
            2 右下角 X 位置 
            3 右下角 Y 位置 
            4 右上角 X 位置 
            5 右上角 Y 位置 
            6 左上角 X 位置 
            7 左上角 Y 位置 
        */
        
		$size = imagettfbbox($fontSize, 0, $fontFile, $text);
		$dx = abs($size[2]-$size[0])+$width;//预留600个像素
   		$dy = abs($size[5]-$size[3])+20; //获取滚动字幕高度
		$dy=($dy>=200)?200:$dy;


		//生成画布
		$im =imagecreate($dx, $dy);
		$bgColorArr=preg_split('[(,)]',$bgColor);
		$bgR=preg_replace('/\D/s', '', $bgColorArr[0]);
		$bgG=preg_replace('/\D/s', '', $bgColorArr[1]);
		$bgB=preg_replace('/\D/s', '', $bgColorArr[2]);

//echo $im."-".$bgR."-".$bgG."-".$bgB;preg_replace('/\D/s', '', $str);
		$fontColorArr=preg_split('[(,)]',$fontColor);
		$fontR=preg_replace('/\D/s', '', $fontColorArr[0]);
		$fontG=preg_replace('/\D/s', '', $fontColorArr[1]);
		$fontB=preg_replace('/\D/s', '', $fontColorArr[2]);
  // echo $fontR."-".$fontG."-".$fontB;   
		$black =   imagecolorallocate ($im,$bgR,$bgG,$bgB); //背景 白色
		$fontColor=imagecolorallocate($im,$fontR,$fontG,$fontB); //黑色

		//imagettftext ( resource image, float size, float angle, int x, int y, int color, string fontfile, string text ) 向画布添加文字，（画布，字体大小，角度制表示的角度90表示从上向下，x,y 第一个字符的位置）
        //载图攀上写入文字
		imagettftext($im, $fontSize, 0, $width, $fontSize+10, $fontColor, $fontFile, $text);
		//imagettftext($im, $fontSize, 0, abs($size[6])+580,$size[3], $fontColor, $fontFile, $text);
		//切割图片
		
		$iOut = imagecreatetruecolor ($maxW,$maxH);
		
		/*bool imagecopy ( resource dst_im, resource src_im, int dst_x, int dst_y, int src_x, int src_y, int src_w, int src_h )
src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。*/
		$filsesArr=array();
        $widthnum=ceil($dx/$maxW);
		@set_time_limit(180);
		for ($j=0;$j < $widthnum;$j++) 
        {
	 		imagecopy($iOut,$im,0,0,($j*$maxW),0,$maxW,$maxH);//复制图片的一部分
		 	imagepng($iOut,$dirPath."/".$j.".png"); //输出成0_0.jpg,0_1.jpg这样的格式
			$filesArr[$j]=$dirPath."/".$j.".png";	//图片数组
		}
		imagedestroy($im);
		imagedestroy($iOut);
		
		$imgInfo=array();
		$imgInfo["filePath"]=FILELIB.$dirPath;
		$imgInfo["dirPath"]=$dirPath;
		$imgInfo["ftpfilePath"]=FTPTXT.$dirPath;
        $imgInfo["imgFile"]=$filesArr;
        
		return $imgInfo;
	}
    
    
    
	function makeLEDTxt($fileName,$saveFolder='FileLib',$font,$fontSize=12,$width=64,$height=16,$newfileName='1.R01',$scroll){
		$fileName=$this->getLocalPath($fileName);
		$iPicColor = 3;			//灯色彩
		$astr = array();
		
		
		$opts= array('file'=> array('encoding'=> 'gb2312')); 
		$ctxt = stream_context_create($opts);
		
		//$str = file_get_contents($fileName,false, $ctxt);//加载外部文件
		$str = file_get_contents($fileName);//加载外部文件
		//$str=mb_convert_encoding($str, 'UTF-8','ASCII,GB2312,GBK,UTF-8');
		//$str=iconv("utf-8","gb2312",$str);
		$str = str_replace(array("\r\n", "\n", "\r"),"",$str);//过滤换行符

		//$str = preg_replace('/\xa3([\xa1-\xfe])/e', 'chr(ord(\1)-0x80)', $str); //全角=>半角
		$params = array();
		$params['str'] = $str;
		$params['fontsize'] = $fontSize;	//字体大小
		$params['width'] = $width;	//led长
		$params['height'] = $height;	//len宽
		$params['font'] = $font;	//字体
		$this->load->library('Txtsplit', $params);
		if($scroll=="3")//左滚动
		{
		//	echo Information("滚动方向","3-->左滚动");
			$w = $this->txtsplit->imageboxw();//获取宽
			$iPictures = ceil($w/$width); //取其绝对值
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
		$filePath=FILELIB.$newfileName;
		$ftpfilePath=FTPLED.$newfileName;
		//echo "<br>".$filePath."<br>";
		//echo $ftpfilePath;
		
		$this->uploadFile($filePath,$ftpfilePath);
		//删除led字幕包
		$md5=md5_file($filePath);
		unlink($filePath);
		return $md5;
	}
	function makeCeShiLEDTxt($fileName,$saveFolder='FileLib',$font,$fontSize=12,$width=64,$height=16,$newfileName='1.led',$scroll){
		$fileName=$this->getLocalPath($fileName);
		$iPicColor = 3;			//灯色彩
		$astr = array();
		$str = file_get_contents($fileName);//加载外部文件
		$str = str_replace(array("\r\n", "\n", "\r"),"",$str);//过滤换行符
		//$str = preg_replace('/\xa3([\xa1-\xfe])/e', 'chr(ord(\1)-0x80)', $str); //全角=>半角
		$params = array();
		$params['str'] = $str;
		$params['fontsize'] = $fontSize;	//字体大小
		$params['width'] = $width;	//led长
		$params['height'] = $height;	//len宽
		$params['font'] = $font;	//字体
		$this->load->library('txtsplit', $params);
		if($scroll=="3")//左滚动
		{
			//echo Information("滚动方向","3-->左滚动");
			$w = $this->txtsplit->imageboxw();//获取宽
			$iPictures = ceil($w/$width); //取其绝对值
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
		//echo "-----------------------完成 OK --------------------";
		exit();
		//上传
		$filePath=FILELIB.$newfileName;
		$ftpfilePath=FTPLED.$newfileName;
		//echo "<br>".$filePath."<br>";
		//echo $ftpfilePath;
		$this->uploadFile($filePath,$ftpfilePath);
		//删除led字幕包
		$md5=md5_file($filePath);
		unlink($filePath);
		return $md5;
	}
	function removeDir($dir) {
		if(!is_dir($dir)){
			return false;
			}
		if ($handle = @opendir($dir)) { 
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					if (is_dir("$dir/$item")) {
						$this->removeDir("$dir/$item");
					} else {
						unlink("$dir/$item");
						//echo " removing $dir/$item<br>\n";
					}
				}
			}
	   closedir($handle);
	   rmdir($dir);
	  // echo " removing $dir<br>\n";
	  }
	}

	function getProfileInfo($profileID='',$isNumber='',$offset='',$limit=''){
		$profileInfo=array();
		@session_start();
		if($this->userEntity->userRoleID=="6"||$this->userEntity->userRoleID=="7"||$this->userEntity->userRoleID=="8")
			{
				$_SESSION["access_area"]="all";
			}
			else
			{
				$_SESSION["access_area"]=$this->userEntity->userGroupID;
			}
	
		$var_dept=$this->areaAccess();
		if(!is_bool($var_dept))
		{
			$this->db->where_in("Extend1",$this->userEntity->userGroupID);
		}
		$sql="select * from profile where Extend5 in (".$var_dept.")";
		if($profileID!=''){
			$sql="select * from profile";
			$sql.=" where profileID=".$profileID;
		}
		if($limit!=''){
			$sql.=" limit $offset,$limit";
		}
		$num=0;
		$query=$this->db->query($sql);
		$num=$query->num_rows;

		if($isNumber=="1"){
			return $num;
		}

		if($num>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放列表名称

				$profileInfo[$i]['profileID']=$row->ProfileID;
				//$profileInfo[$i]['profileName']=preg_replace($row->ProfileName);
				$profileInfo[$i]['profileName']=urldecode(preg_replace("/\_/","%",$row->ProfileName));
				$profileInfo[$i]['profileViewName']=$row->ProfileName;
				$profileInfo[$i]['profileType']=$row->ProfileType;
				$profileInfo[$i]['profileTime']=$row->ProfilePeriod;
				$profileInfo[$i]['profileJumpUrl']=$row->TouchJumpUrl;
				$profileInfo[$i]['profileTemplateID']=$row->TemplateID;
				$profileInfo[$i]['profileTemplateFileID']=$row->TemplateFileID;
				$i++;
			}//循环结束

		}
		return $profileInfo;
	}
	
	function areaAccess()
	{
		
		if(!isset($_SESSION["access_area"]))
		{
			@session_start();
		}
		if($_SESSION["access_area"]!="all")
		{
			$arr_accessArea=explode(",",$_SESSION["access_area"]);
			$str_accessArea="";
			for($i=0,$n=count($access_area); $i<$n; $i++)
			{
				
				$str_accessArea.="'".$access_area[$i]."'";
				if($i!=$n-1)
				{
					$str_accessArea.=" , ";
				}
			}
			return $str_accessArea;
		}
		return true;
	}
	
	//获得配置参数
	function getOptions(){
		$optionsInfo=array();
		$query=$this->db->get('ams_options');
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				//获得播放列表名称
				$optionsInfo[$i]['optionName']=$row->OptionName;
				$optionsInfo[$i]['optionValue']=$row->OptionPara7;
				$i++;
			}//循环结束

		}
		return $optionsInfo;

	}
	//------------------------------------------------
	//-
	//- 删除Profile
	//- 根据profileID 在 表profile_describe 中找到 playlistID,
	//-     然后再根据playlistID 在表playlist_describe中找到
	//-     playFileId 删除
	//------------------------------------------------
	function deleteProfile($profileID,$isDelete="0"){
		$info=array(); //------------> 操作信息记录(日志)
		//根据profileID-profile_describe
		//->得到playlistID->到playlist_describe()->play_file_property
		$playlistIDArr=$this->getProfileDescribe($profileID);

		//echo "<script>alert(".$playlistIDArr.")</script>";
		
		$playlistIDNum=count($playlistIDArr);
		for($i=0;$i<$playlistIDNum;$i++){
			$playfileIDArr=$this->getPlaylistDesribe($playlistIDArr[$i]);
			$playfileIDNum=count($playfileIDArr);
			for($j=0;$j<$playfileIDNum;$j++){
			//echo "playFileID:".$playfileIDArr[$j]."<br>";
				$tables = array('playlist_describe');
				$this->db->where('PlayFileID', $playfileIDArr[$j]);
				$this->db->delete($tables);
			}
			
			$tables = array('profile_describe', 'playlist',);
			$this->db->where('PlaylistID', $playlistIDArr[$i]);
			$this->db->delete($tables);
		}
		//从play_file_property中删除profile tar包相关信息
		  //echo $profileID;
			$this->db->select("TemplateFileID");
			$this->db->where("ProfileID",$profileID);
			$this->db->from("profile");
			$query=$this->db->get();
			if ($query->num_rows() > 0)
			{
			   $row = $query->row(); 
			   $tar_id=$row->TemplateFileID;
			   //echo Information("开始删除play_file_property表中的数据","tar包的Id:".$tar_id);
			 
			   $this->db->delete('play_file_property',array('PlayFileID'=>$tar_id));
			} 
		
		$profileName=$this->getProfileNameByID($profileID);
		if($profileName=="")
		{
			$profileDir="";
			$info["proNameIsNull"]=true;
		}
		else
		{ $info["proName"]=$profileName;}
		$profileDir=FILELIB.$profileName;
		if($isDelete=='0')
		{
			
			$this->db->delete('profile',array('ProfileID'=>$profileID));
			$this->db->delete('week_playlist_describe',array('ProfileID'=>$profileID));
			//删除文件夹
			//echo Information("删除文件夹",$profileDir);
			if($profileDir!=""&&count(explode(FILELIB,$profileDir))>1)
			{
				$this->removeDir($profileDir);
			}
			else {$info["proDirIsNull"]=true;}
			//删除tar包
			//echo Information("删除tar包",FILELIB.$profileName.'.tar');
			$bagsName=getProfileBagsNameByID($profileID);
			if(file_exists(FILELIB.$bagsName))
			{
				unlink(FILELIB.$bagsName);
			}
			else {$info["proTarIsNull"]=true;}
		}
		return trueInfo($info);
	}
	function getProfileNameByID($profileID=''){
		$this->db->select('ProfileName');
		$query=$this->db->get_where('profile',array('ProfileID'=>$profileID));
		$profileName='';
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$profileName=$row->ProfileName;
				break;
			}
		}
		return $profileName;

	}
	function getProfileBagsNameByID($profileID)
	{
		$this->db->select('ProfileName','ProfileType');
		$query=$this->db->get_where('profile',array('ProfileID'=>$profileID));
		$profileName='';
		$profileType='';
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$profileName=$row->ProfileName;
				$profileType=$row->ProfileType;
				break;
			}
		}
		$profileBagsName="";
		switch($profileType)
		{
			case "Android": $profileBagsName=$profileName.".7z"; break;
			case "X86": $profileBagsName=$profileName.".tar"; break;
		}
		return $profileBagsName;
	}
	function getProfileDescribe($profileID){
		$sql="select PlaylistID from profile_describe";
		if($profileID!=""){
			$sql.=" where ProfileID=".$profileID;
		}
		$playlist=array();
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$playlist[$i]=$row->PlaylistID;
				$i++;
			}
		}
		return $playlist;
	}
	function getPlaylistDesribe($playlistID){
		$sql="select PlayFileID from playlist_describe";
		if($playlistID!=""){
			$sql.=" where PlaylistID=".$playlistID;
		}
		$playfile=array();
		$query=$this->db->query($sql);
		if($query->num_rows>0){
			$i=0;
			foreach($query->result() as $row){
				$playfile[$i]=$row->PlayFileID;
				$i++;
			}
		}
		return $playfile;
	}
   //保存节目模板
    function updateTemplate($tempInfo,$profileTmpID)
	{
		$temp=$tempInfo["tempGobal"];
		$data=$tempInfo["data"];
		$TempName=$temp["name"];//模板名称
		$TempID=$profileTmpID;//模板ID
		//更新 模板总表 template 信息
		$sql="update template set TemplateName='".$TempName."',LengthScale=".$temp["resolution"].",TemplateType=".$temp["type"].",Extend1='".$data["backGroundImage"]["name"]."' where TemplateID=".$TempID;
		$this->db->query($sql);
		
		//删除子区域信息
		$sql="delete from template_describe where TemplateID=".$TempID;
		$this->db->query($sql);
		
		//插入子区域信息
		$area_sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID,Extend1) values";
		$sq_value=array();
		foreach($data["areas"] as $k=>$v)
		{
			$itm=$v["info"];
			$sq_value[]="(".round($itm["x"],2).",".round($itm["y"],2).",".round($itm["w"],2).",".round($itm["h"],2).",".$itm["id"].",".$TempID.",'".$itm["extendInfo"]["type"]."')";
		}
		$area_sql.=implode(",",$sq_value);
		
		
		
		
		$this->db->query($area_sql);
		return array("state"=>true);
	}

//保存节目模板
    function updateFastTemplate($tempInfo,$profileTmpID)
	{
		$temp=$tempInfo["tempGobal"];
		$data=$tempInfo["data"];
		$TempName=$temp["name"];//模板名称
		$TempID=$profileTmpID;//模板ID
		//更新 模板总表 template 信息
		$sql="update template set TemplateName='".$TempName."',LengthScale=".$temp["LengthScale"].",WidthScale=".$temp["WidthScale"].",TemplateType=".$temp["type"].",Extend1='".$data["backGroundImage"]["name"]."' where TemplateID=".$TempID;
		$this->db->query($sql);
		
		//删除子区域信息
		$sql="delete from template_describe where TemplateID=".$TempID;
		$this->db->query($sql);
		
		//插入子区域信息
		$area_sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID,Extend1) values";
		$sq_value=array();
		foreach($data["areas"] as $k=>$v)
		{
			$itm=$v["info"];
			$sq_value[]="(".round($itm["x"],2).",".round($itm["y"],2).",".round($itm["w"],2).",".round($itm["h"],2).",".$itm["id"].",".$TempID.",'".$itm["extendInfo"]["type"]."')";
		}
		$area_sql.=implode(",",$sq_value);
		
		
		
		
		$this->db->query($area_sql);
		return array("state"=>true);
	}


	function updateProfile($profileID){
		
		//修改profile，先将原来的数据清空
		$this->deleteProfile($profileID,"1");
		$data = array(
			   'ProfileType' => $this->profileType,
               'ProfileName' => $this->profileName,
               'ProfilePeriod' => $this->profilePeriod,
               'TemplateID' => $this->profileTmpID,
			   //'TemplateFileID'=>$this->profileTmpFileID,
			   'TouchJumpUrl'=>$this->profileTouchJumpUrl
            );
		$this->db->where('ProfileID', $profileID);
		$this->db->update('profile', $data);
		$this->profileID=$profileID;
	}
	function copyDir($source, $dest, $overwrite = false){
	  if($handle = opendir($source)){        // if the folder exploration is sucsessful, continue
	   while(false !== ($file = readdir($handle))){ // as long as storing the next file to $file is successful, continue
		 if($file != '.' && $file != '..'){
		   $path = $source . '/' . $file;
		   if(is_file($path)){
			 if(!is_file($dest . '/' . $file) || $overwrite)
			   if(!@copy($path, dest . '/' . $file)){
				 echo '<font color="red">File ('.$path.') could not be copied, likely a permissions problem.</font>';
			   }
		   } elseif(is_dir(loc1 . $path)){
			 if(!is_dir($dest . '/' . $file))
			   mkdir($dest . '/' . $file); // make subdirectory before subdirectory is copied
			 copyDir($path, $dest . '/' . $file, $overwrite); //recurse!
		   }
		 }
	   }
	   closedir($handle);
	  }
	}
	//------------------------------------------------
	//-
	//- 解决 中文的时候 basename() 函数会使中文消失
	//- 2011年6月15日15:08:43
	//------------------------------------------------
	function zhcnBaseName($path)
	{
		$fileInfo=explode("/",$path);
		if(count($fileInfo)>1)
		{
			$fileInfo=$fileInfo[count($fileInfo)-1];
		}
		else
		{
			$fileInfo=$fileInfo[0];
		}
		return $fileInfo;
	}
}?>
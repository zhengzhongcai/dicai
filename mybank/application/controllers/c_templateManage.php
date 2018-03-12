<?php
class C_templateManage extends CI_Controller {

	 function __construct()
	 {
	 	 parent::__construct();
	 	 $this->load->model('m_templatemanage','m_temp');
		 $this->load->model('m_filemanage','m_fm');
	 }
	
	/**************************************************
	 *作者：
	 *时间：
	 *参数：
	 *描述：控制器控制创建模版的方法
	 *返回：
	 **************************************************/
	function createTemp()
	{
		$this->load->view('playProgram/v_createTemp');
	}
	//快速创建节目
    function fastCreateProfile()
    {
    	$this->load->view('playProgram/v_fastCreateProfile');
    }
	/**************************************************
	 *作者：
	 *时间：
	 *参数：
	 *描述：检测创建模版时输入的名称是否重名，如果重名，
			返回false，用户需重新填写，返回true，则进行
			下一步操作
	 *返回：
	 **************************************************/	
	function checkTemplateName(){
		$data=$this->input->post("data");
		if(!count($data))
		{
			echo json_encode(array("state"=>"error","data"=>""));
			exit();
		}
		$tempInfo=array("TemplateName"=>$data["name"]);
		
		$result=$this->m_temp->checkTempName($tempInfo);
		if(count($result))
		{
			//检测是否是修改状态,如果是修改状态,则需要判断ID是否相同
			if($data["id"]!="")
			{
				if($data["id"]!=$result[0]["TemplateID"])
				{
					echo json_encode(array("state"=>false,"data"=>""));
					exit();
				}
				else
				{
					echo json_encode(array("state"=>true,"data"=>""));
					exit();
					
				}
			}
			
			echo json_encode(array("state"=>false,"data"=>""));
			
		}
		else
		{
			echo json_encode(array("state"=>true,"data"=>""));
		}
	}
	/**************************************************
	 *作者：
	 *时间：
	 *参数：
	 *描述：模版管理的首页显示；
			把模版显示在首页
	 *返回：
	 **************************************************/	
	function templateList(){
		$this->load->view("v_templateManage");   
	}

    function  upFile(){
    	
    $mypic = $_FILES["mypic"]; 
   //$mypic=$this->input->post("mypic");
    //$pics = $picname; mb_convert_encoding($name,"gbk", "utf-8")
    
    $pic_path = getcwd()."\Material\\".$_FILES["mypic"]['name']; 
    move_uploaded_file($mypic["tmp_name"],$pic_path);
    
      }
    

	function saveTemp()
	{
		$info=$this->input->post("template_info");
		$temp=$info["tempGobal"];
		$data=$info["data"];
		$res=$this->m_temp->saveTemp($temp,$data);
		if($res["state"])
		{
			$ret=array("state"=>"true");
			echo json_encode($ret);
		}
	}
	function saveFastTemp(){
          $info=$this->input->post("template_info");
		$temp=$info["tempGobal"];
		$data=$info["data"];
		$res=$this->m_temp->saveTemp($temp,$data);
		if($res["state"])
		{
			$ret=array("state"=>"true");
			echo json_encode($ret);
		}
	}
	
	function getTempListPage()
	{
		$data=$this->input->post("data");
		if(!is_array($data))
		{$data=json_decode($data,true);}
		$pageInfo=array();
		$pageInfo["pageSize"]=$data["pageSize"];
		$pageInfo["pageIndex"]=($data["curent"]*1-1)*$pageInfo["pageSize"];
		$keyWord=$data["keyWord"];
		if(is_array($keyWord))
		{
			$pageInfo["keyWord"]="";
		}
		$arr_result=$this->m_temp->getTempListPage($pageInfo);

		for($i=0,$n=count($arr_result["data"]); $i<$n;$i++)
		{
			$arr_result["data"][$i]["areas"]=$this->m_temp->getArea($arr_result["data"][$i]["TemplateID"]);
		}
		$info=array();
		$info['templateInfo']=$arr_result["data"];
		//$info['pageCount']=$arr_result["totalRows"];
		$pageCount=explode(".",$arr_result["totalRows"]/$data['pageSize']);
		$info['pageCount']=count($pageCount)==1?$pageCount[0]:intval($pageCount[0])+1;
		//echo json_encode($info);
		if(count($info['templateInfo']))
		{
			echo json_encode(array("state"=>"true","data"=>$info));
		}
		else
		{
			echo json_encode(array("state"=>"false","data"=>""));
		}
	}
	function getTempList()
	{
		$data=$this->input->post("data");
		
		$pageInfo=array();
		$pageInfo["pageSize"]=$data["rows"];
		$pageInfo["pageIndex"]=($data["page"]-1)*$pageInfo["pageSize"];
		$arr_result=$this->m_temp->getTempListPage($pageInfo);

		for($i=0,$n=count($arr_result["data"]); $i<$n;$i++)
		{
			$arr_result["data"][$i]["areas"]=$this->m_temp->getArea($arr_result["data"][$i]["TemplateID"]);
		}
		$info=array();
		$info['rows']=$arr_result["data"];
		$info['total']=$arr_result["totalRows"];
		
		//echo json_encode($info);
		if(count($info['rows']))
		{
			showInfo(true,$info);
		}
		else
		{
			showInfo(false,"您还没创建模版!");
		}
	}
	//返回模板信息
	function getTemplates()
	{
		$Templates=array();
		$Templates=$this->m_temp->getTemplates();
		for($i=0,$n=count($Templates); $i<$n;$i++)
		{
			$Templates[$i]["areas"]=$this->m_temp->getArea($Templates[$i]["TemplateID"]);
		}
		if(count($Templates))
		{
			echo json_encode(array("state"=>"true","data"=>$Templates));
		}
		else
		{
			echo json_encode(array("state"=>"false","data"=>""));
		}
	}
	//返回一个模板信息
	function getTempById()
	{
		$tempId=(int)$this->input->post("temp")*1;
		
		$rs=$this->m_temp->getTempById($tempId);
		
		if(is_array($rs))
		{
			$res=$this->m_fm->getFileInfoByID($rs[0]["temBgImg"]);
			if(!is_bool($res))
			{
				$rs[0]["fileID"] = $rs[0]["temBgImg"];
				$rs[0]["temBgImg"]=$this->m_fm->delFtpInfo($res["file_path"]);
			}
			echo json_encode(array("state"=>"true","data"=>$rs));
		}
		else
		{
			echo json_encode(array("state"=>"false","data"=>""));
		}
	}
	function deleteMulpTemp()
	{
		$id=$this->input->post("tempIDs");
		$this->m_temp->deleteMulpTemp(explode(",",$id));
		echo json_encode(array("state"=>"true","data"=>""));
	}
	//获取模板背景图列表
	public function getTemplateBGImg()
	{
				echo '{"state":true,"info":"","data":[{"fileName":"1.png","fileMD5":"5635b6e9434100f25ba7928e27bd1270","fileType":"Img","fileViewPath":"1.png","filePath":"1.png","fileSize":"27111","lastUpdateTime":"2012-04-17 08:49:37","playTime":"5","myPath":"http://192.168.100.39/CI/Material/1.png"},{"fileName":"0029.JPG","fileMD5":"de1aa8638f2675dee962887feae7ecea","fileType":"Img","fileViewPath":"0029.jpg","filePath":"0029.jpg","fileSize":"136989","lastUpdateTime":"2012-04-17 08:49:53","playTime":"5","myPath":"http://192.168.100.39/CI/Material/0029.jpg"},{"fileName":"74591771435342660002.jpg","fileMD5":"74cdba21b9dfab48c80594aec8446226","fileType":"Img","fileViewPath":"74591771435342660002.jpg","filePath":"74591771435342660002.jpg","fileSize":"237692","lastUpdateTime":"2012-04-17 09:14:22","playTime":"5","myPath":"http://192.168.100.39/CI/Material/74591771435342660002.jpg"},{"fileName":"\u6c11.png","fileMD5":"21586868f102000f14dc993b98276f9e","fileType":"Img","fileViewPath":"\u6c11.png","filePath":"\u6c11.png","fileSize":"40033","lastUpdateTime":"2012-04-17 09:52:25","playTime":"5","myPath":"http://192.168.100.39/CI/Material/%E6%B0%91.png"}]} ';
	}
	//保存模板编辑信息
	function saveEditTemp()
	{
		$info=$this->input->post("template_info");
		$temp=$info["tempGobal"];
		$data=$info["data"];
		$res=$this->m_temp->updateTemplate($temp,$data);
		if($res["state"])
		{
			$ret=array("state"=>"true");
			echo json_encode($ret);
		}
		/*echo "<pre>";
		echo json_encode($info);
		echo "</pre>";*/
	}
	//保存模板编辑信息
	function saveEditFastTemp()
	{
		$info=$this->input->post("template_info");
		$temp=$info["tempGobal"];
		$data=$info["data"];
		$res=$this->m_temp->updateFastTemplate($temp,$data);
		if($res["state"])
		{
			$ret=array("state"=>"true");
			echo json_encode($ret);
		}
		/*echo "<pre>";
		echo json_encode($info);
		echo "</pre>";*/
	}
	//获取模版信息 to Profile
	function getTemplateToProfile(){
		$t_id=$this->db->input("TempID");
		$tem_info=$this->m_temp->getTemplateToProfile($t_id);
		if(count($tem_info>1)){
			$temp=array(
				"tem_id"=>"",
				"tem_type"=>""
			);
		}
	}
}
?>
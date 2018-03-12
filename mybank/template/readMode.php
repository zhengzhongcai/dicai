 <?php
/*
模版管理类

模板总表 template
TemplateID 模版ID
TemplateName 模板名称
LengthScale----分辩率枚举值
AspectRatio----分辩率比例枚举值
TemplateType---模板类型(0=>X86,1=>em862,2=>NXP)
Extend1 ------模板背景
TemplatePicFileId 背景图片id




模版组成表 template_describe

TemplateID 模版ID
BlockID	子区域ID
X 子区域X坐标
Y 子区域Y坐标
Width 子区域宽度
Heigth 子区域高度

*/

class TemplateManagement
{
	private $SqlDB="";
	private $TemplateEmue="";
	public function TemplateManagement()
	{
		include_once("MySqlDateBase.class.php");
		$this->SqlDB = new MySqlDateBase();
		include_once("templateClassEmue.php");
		$this->TemplateEmue=new TemplateEmue();
	}

	//返回模板信息
	function GetTemplates()
	{
		$Templates=array();
		$tempID=$this->GetTempID();
		for($i=0; $i<count($tempID);$i++)
		{
			$Templates[]=$this->GetBlock($tempID[$i][0]);
		}
		$this->SqlDB->Close();
		return $Templates;
	}
	//返回一个模板信息
	function GetTemplate($tempID)
	{
		$Templates=$this->GetTempInfo($tempID);
		$Templates["areas"]=$this->GetBlock($tempID);
		$this->SqlDB->Close();
		return $Templates;
	}
	//获取模板组
	function GetTempID()
	{
		$temGroup_SQL="select TemplateID,TemplateName from template where TemplateName not like '********%'";
		$temGroup_Result = $this->SqlDB->Query($temGroup_SQL);
		$temGroup_Rs = $this->SqlDB->getRows($temGroup_Result);
		$temGroup_Num = $this->SqlDB->getRowsNum($temGroup_Result);
		$temID=array();
		for($i=0; $i<$temGroup_Num;$i++)
		{
			$temID[$i][0]=$temGroup_Rs[$i]["TemplateID"];
			$temID[$i][1]=$temGroup_Rs[$i]["TemplateName"];
			
		}
		//$this->SqlDB->Close();
		return $temID;
	}
	

	//获取模板集内的子模版的信息
	function GetBlock($a)
	{
		$temBlock=array();
		
		
		$temBlock_Sql = "select * from template_describe where TemplateID=".$a ;
		$temBlock_Result = $this->SqlDB->Query($temBlock_Sql);
		$temBlock_Rs = $this->SqlDB->getRows($temBlock_Result);
		$temBlock_Num = $this->SqlDB->getRowsNum($temBlock_Result);

		//$temBlock=array();
		for($i=0;$i<$temBlock_Num;$i++)
		{
			$temBlock[$i]["TemplateID"]=$temBlock_Rs[$i]["TemplateID"];
			$temBlock[$i]["BlockID"]=$temBlock_Rs[$i]["BlockID"];
			$temBlock[$i]["X"]=$temBlock_Rs[$i]["X"];
			$temBlock[$i]["Y"]=$temBlock_Rs[$i]["Y"];
			$temBlock[$i]["Width"]=$temBlock_Rs[$i]["Width"];
			$temBlock[$i]["Height"]=$temBlock_Rs[$i]["Height"];
			$temBlock[$i]["extend1"]=$temBlock_Rs[$i]["Extend1"];
        

		}
		//$this->SqlDB->Close();
		return $temBlock;
	}
		//获取总模板的基本模板信息
	function GetTempInfo($id)
	{
		$TempInfo_SQL="select * from template where TemplateID=".$id;
		$TempInfo_Result = $this->SqlDB->Query($TempInfo_SQL);
		$TempInfo_Rs = $this->SqlDB->getRows($TempInfo_Result);
		$TempInfo_Num = $this->SqlDB->getRowsNum($TempInfo_Result);
		$temInfo=array();
	
		$temInfo["TemplateID"]=$TempInfo_Rs[0]["TemplateID"];
		$temInfo["TemplateName"]=$TempInfo_Rs[0]["TemplateName"];
		$temInfo["LengthScale"]=$TempInfo_Rs[0]["LengthScale"];
		//cheng添加
		$temInfo["WidthScale"]=$TempInfo_Rs[0]["WidthScale"];
        $temInfo["TemplateTypeStr"]=$TempInfo_Rs[0]["TemplateTypeStr"];
        $temInfo["Extend2"]=$TempInfo_Rs[0]["Extend2"];
        $temInfo["Extend3"]=$TempInfo_Rs[0]["Extend3"];
		//结束
		$temInfo["AspectRatio"]=$TempInfo_Rs[0]["AspectRatio"];
		$temInfo["TemplateType"]=$TempInfo_Rs[0]["TemplateType"];
		$temInfo["Extend1"]=$TempInfo_Rs[0]["Extend1"];
		if($temInfo["WidthScale"]!=null){
        $temInfo["F_Width"]=$temInfo["LengthScale"];
		$temInfo["F_Height"]=$temInfo["WidthScale"];

		}else{
		$wh=explode("x",$this->TemplateEmue->getBaseInfo($temInfo["LengthScale"]));
		$temInfo["F_Width"]=$wh[0];
		$temInfo["F_Height"]=$wh[1];
		
		
		}



		//$this->SqlDB->Close();
		return $temInfo;
	}
	
}
?>
<?php
class M_templateManage extends CI_Model{
	function __construct()
    {
        parent::__construct();
		
    }
	
	
	function  checkTempName($tempInfo){
		$this->db->where($tempInfo);
		$query=$this->db->get("template")->result_array();
		return $query;
	}
	//保存模板
	function saveTemp($temp,$data)
	{
		$sql="INSERT INTO template(TemplateName,LengthScale,TemplateType,Extend1) VALUES(".$this->db->escape($temp["name"]).",".$temp["resolution"].",".$temp["type"].",'".$data["backGroundImage"]["name"]."')";
		$this->db->query($sql);
		$id=$this->db->insert_id();
		
		//echo print_r($info["data"]["areas"]);
		//插入子区域信息
		$area_sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID,Extend1) values";
		$sq_value=array();
		foreach($data["areas"] as $k=>$v)
		{
			$itm=$v["info"];
			$sq_value[]="(".round($itm["x"],2).",".round($itm["y"],2).",".round($itm["w"],2).",".round($itm["h"],2).",".$itm['id'].",".$id.",'".$itm["extendInfo"]["type"]."')";
		}
		
		$area_sql.=implode(",",$sq_value);
		
		$this->db->query($area_sql);
		return array("state"=>true);
	}
  //快速创建节目保存模板
	function saveFastTemp($temp,$data)
	{
		$sql="INSERT INTO template(TemplateName,LengthScale,WidthScale,TemplateType,Extend1) VALUES(".$this->db->escape($temp["name"]).",".$temp["LengthScale"].",".$temp["WidthScale"].",".$temp["type"].",'".$data["backGroundImage"]["name"]."')";
		$this->db->query($sql);
		$id=$this->db->insert_id();
		
		//echo print_r($info["data"]["areas"]);
		//插入子区域信息
		$area_sql="insert into template_describe(X,Y,Width,Height,BlockID,TemplateID,Extend1) values";
		$sq_value=array();
		foreach($data["areas"] as $k=>$v)
		{
			$itm=$v["info"];
			$sq_value[]="(".round($itm["x"],2).",".round($itm["y"],2).",".round($itm["w"],2).",".round($itm["h"],2).",".$itm['id'].",".$id.",'".$itm["extendInfo"]["type"]."')";
		}
		
		$area_sql.=implode(",",$sq_value);
		
		$this->db->query($area_sql);
		return array("state"=>true);
	}
	
	//获取模板组
	function getTemplates()
	{
		$temGroup_SQL="select * from template where TemplateName like '********%'";
		$rs=$this->db->query($temGroup_SQL)->result_array();
		return $rs;
	}
	

	//获取模板内的区域的信息
	function getArea($a)
	{
		$temBlock_Sql = "select * from template_describe where TemplateID=".$a ;
		$temBlock=$this->db->query($temBlock_Sql)->result_array();
		return $temBlock;
	}
	//通过ID获取某一个模板的信息
	function getTempById($id)
	{
		$tem_Sql = "select * from template where TemplateID=".$id ;
		$tem=$this->db->query($tem_Sql)->result_array();
		if(!count($tem)){return false;}
		$n_tems=array();
		/*TemplateID,TemplateName,LengthScale,WidthScale,AspectRatio,TemplateType,TemplateTypeStr,TemplatePicFileID,Extend1,Extend2,Extend3*/
		$n_tems[0]["temId"]=$tem[0]["TemplateID"];
		$n_tems[0]["temNm"]=$tem[0]["TemplateName"];
		$n_tems[0]["lenSc"]=$tem[0]["LengthScale"];
		$n_tems[0]["wSc"]=$tem[0]["WidthScale"];
		$n_tems[0]["asRa"]=$tem[0]["AspectRatio"];
		$n_tems[0]["temTp"]=$tem[0]["TemplateType"];
		$n_tems[0]["temTps"]=$tem[0]["TemplateTypeStr"];
		//$n_tems[0]["temBgImg"]=$tem[0]["TemplatePicFileID"];
		$n_tems[0]["temBgImg"]=$tem[0]["Extend1"];
		$n_tems[0]["ex_b"]=$tem[0]["Extend2"];
		$n_tems[0]["ex_c"]=$tem[0]["Extend3"];
		
		
			/*
			TemplateID,BlockID,X,Y,Width,Height,Extend1,Extend2,Extend3
			*/
			$areas=$this->getArea($id);
			$n_areas=array();
			foreach($areas as $k=>$v)
			{
				$n_areas[$k]["tempId"]=$v["TemplateID"];
				$n_areas[$k]["areaId"]=$v["BlockID"];
				$n_areas[$k]["x"]=$v["X"];
				$n_areas[$k]["y"]=$v["Y"];
				$n_areas[$k]["w"]=$v["Width"];
				$n_areas[$k]["h"]=$v["Height"];
				$n_areas[$k]["ex_a"]=$v["Extend1"];
				$n_areas[$k]["ex_b"]=$v["Extend2"];
				$n_areas[$k]["ex_c"]=$v["Extend3"];
			}
			$n_tems[0]["areas"]=$n_areas;
			
		return $n_tems;
		
	}
	
	function getTempListPage($pageInfo)
	{
		

		$sql=" where TemplateName not like '********%' order by TemplateID desc";
		
		$sql_count="select count(*) as resultCount from `template`  ".$sql;
		$query=$this->db->query($sql_count)->result_array();
		
		$data=array();
		$data["totalRows"]=$query[0]["resultCount"];
		
		$sql_content="select *  from `template` ".$sql." limit ".$pageInfo['pageIndex'].",".$pageInfo['pageSize'];
		$data["data"]=$this->db->query($sql_content)->result_array();
		
		return $data;
	}
	// 删出多个模板
	function deleteMulpTemp($tempIds)
	{
		//更新 模板总表 template 信息
		foreach($tempIds as $v)
		{
			$sql="delete from template where TemplateID =".$v;
			$this->db->query($sql);
			//删除子区域信息
			$sql="delete from template_describe where TemplateID=".$v;
			$this->db->query($sql);
		}
	}
	
	function updateTemplate($temp,$data)
	{   
		$TempName=$temp["name"];//模板名称
		$TempID=$temp["updateid"];//模板ID
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

	function updateFastTemplate($temp,$data)
	{   
		$TempName=$temp["name"];//模板名称
		$TempID=$temp["updateid"];//模板ID
		//更新 模板总表 template 信息
		//$sql="update template set TemplateName='".$TempName."',LengthScale=".$temp["resolution"].",TemplateType=".$temp["type"].",Extend1='".$data["backGroundImage"]["name"]."' where TemplateID=".$TempID;
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
			for($i=0,$n=count($arr_accessArea); $i<$n; $i++)
			{
				
				$str_accessArea.="'".$arr_accessArea[$i]."'";
				if($i!=$n-1)
				{
					$str_accessArea.=" , ";
				}
			}
			return $str_accessArea;
		}
		return true;
	}
	
	//获取模版信息 to Profile
	function getTemplateToProfile($t_id){
		$array_temp_info=array();
		//查询全局信息
		$this->db->select("TemplateID,
										TemplateName,
										LengthScale,
										WidthScale,
										AspectRatio,
										TemplateType,
										TemplateTypeStr,
										TemplatePicFileID,
										Extend1,
										Extend2,
										Extend3,
										OwnerUser,
										OwnerUserGroup,
										GroupID");
		$this->db->where("TemplateID",$t_id);
		$rs=$this->db->get("template")->array_result();
		
		if(count($rs)){
			$array_temp_info["temp"]=$rs;
			
			//查询模块信息
			$this->db->select("TemplateID,
											BlockID,
											X,
											Y,
											Width,
											Height,
											Extend1,
											Extend2,
											Extend3,
											OwnerUser,
											OwnerUserGroup");
			$this->db->where("TemplateID",$t_id);
			$rs_des=$this->db->get("template_describe")->array_result();
			if(count($rs_des))
			{
				$array_temp_info["temp_des"]=$rs_des;
			}
			else{return $array_temp_info;}
			
			$bg_img_id=$rs[0]["Extend1"];
			$this->load->model("m_filemanage","f_m");
			//查询背景图片文件信息
			$this->f_m->getFileInfo($bg_img_id);
			$bg_des=$this->db->get("play_file_property")->array_result();
			if(count($bg_des))
			{
				$array_temp_info["bg_img"]=$bg_des;
			}
			
		}
		return $array_temp_info;
	}
}
?>
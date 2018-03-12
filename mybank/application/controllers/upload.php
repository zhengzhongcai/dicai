<?php

class Upload extends CI_Controller {
 
 function Upload()
 {
  parent::__construct();
  
  $this->load->helper(array('form', 'url'));
  $this->load->library('Spreadsheet_Excel_Reader');
  $this->load->model('m_client','client');
 }
 
 function import()
	{
	//	echo "开始上传";
		//取文件夹名
		$postProfileName = iconv("utf-8","gb2312",$_FILES['uprofile']['name']);

		if (file_exists("uploads\\".$postProfileName))
		{
			echo '<script>alert("file:'.$postProfileName.' exist");history.back();</script>';exit;
		}
		else
		{ 
			$this->load->helper('form');
			$config['upload_path'] = 'uploads/';
  			$config['allowed_types'] = 'xls';//上传文件类型tar
  			$config['max_size'] = '32000';//上传文件大小限制32M
  			$this->load->library('upload', $config);
			if (!$this->upload->do_upload("uprofile"))//
			{
				$error = $this->upload->display_errors();
				echo '<script>alert("'.$error.'");history.back();</script>';
				exit;
			}
			else//tar上传成功
			{
				echo "<pre>";
			//	print_r($this->upload->data());
				echo "</pre>";
					// ExcelFile($filename, $encoding);
				$data = new Spreadsheet_Excel_Reader();

					// Set output Encoding.
				$data->setOutputEncoding('UTF-8');
				
				$data->read('uploads\\'.$postProfileName);
				error_reporting(E_ALL ^ E_NOTICE);
				
				
				$playlist=array();
				$str="";
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++  ) 
				{
					$profile=array();
					for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++  ) 
					{
							$st=$data->sheets[0]['cells'][$i][1];
							$strV=$data->sheets[0]['cells'][$i][$j];
							
							if($j==1&&strlen($st)>0)
							{
								$str=$st;
								
							}
							if($j!=1&&strlen($st)<=0&&strlen($strV)>0)
							{
								
								$profile[]=$strV;
								
							}
					}
					if(count($profile)>0)
					{
						$playlist[$str][]=$profile;
					}
					$profile=NULL;
				}
				 
				
				unlink('uploads\\'.$postProfileName);
				
				
				
				$sql="";
				$sql_p="";
				foreach($playlist as $k=>$v)
				{
					$sql.="'".$k."',";
					foreach($v as $p)
					{
						$sql_p.="'".preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$p[0])))."',";
					}
				}
				
				
				
				//查是否有同名的profile列表名称
				$sql="select * from week_playlist where  WeekPlaylistName in(".substr($sql,0,strlen($sql)-1).")";
				$query=$this->db->query($sql);
				if($query->num_rows()==0)
				{	
					//查是否有同名的profile
					$ws=substr($sql_p,0,strlen($sql_p)-1);
					$sql_p="select ProfileName,ProfileID from profile where  ProfileName in(".$ws.")";
					
					$query=$this->db->query($sql_p);
					if($query->num_rows()==count(explode(",",$ws)))
					{
						// $rs=$query->result_array();
						// $oldRs=explode(",",$ws);
						// print_r($rs);
						// for($i=0,$n=count($rs); $i<$n; $i++)
						// {
							// if($rs[$i]["ProfileID"]=="")
							// {
								// echo "您的Profile名称 '".$oldRs[$i]."' 有误";
								// exit();
							// }
						// }
					}
					else
					{
						echo "--您的Profile名称有误";
						exit();
					}
				}
				else 
				{
					echo "播放计划重名";
					exit();
				}
				
			//	echo "<br>".$sql."<br>";
				

				
				foreach($playlist as $k=>$v)
				{
					$profile=array();
					foreach($v as $i=>$p)
					{
						$this->db->select("ProfileID");
						$this->db->where("ProfileName",preg_replace("/\%/","_",urlencode(iconv("utf-8","gb2312",$p[0]))));
						$query=$this->db->get("profile");
						$row = $query->row();

						$profile[$i]["profileID"]=$row->ProfileID;
						$profile[$i]["startTime"]=preg_replace("/\//","-",$this->formatTime($p[1])).",".$p[2];
						$profile[$i]["endTime"]=preg_replace("/\//","-",$this->formatTime($p[3])).",".$p[4];
						$profile[$i]["prior"]="1";
						
					}
					$profileStr=json_encode($profile);
				//	echo $profileStr;
					
					$this->client->addPlaylist(iconv("utf-8","gb2312",$k),$profileStr);
					
				}
				//跳转页面
				header("Location: ".base_url()."index.php/playlist/getAllPlayList"); 

				//echo '<script>alert("href:"http://192.168.168.122/CI/index.php/playlist/getAllPlayList"");</script>';exit;
				exit();

				
			}

		}
	}
function formatTime($s)
{
	$c=explode("/",$s );
	$c=array_reverse($c);
	$c[2]=$c[2]-1;
	$c=implode("/",$c);
	
	return $c;
}
}
?>
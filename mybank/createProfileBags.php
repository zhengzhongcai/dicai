<?php

	function androidTar($fileName,$folders)
    {

        //7za a 包路径 文件路径
        @set_time_limit(60);
		$cmd="7za a ".escapeshellarg($fileName)." ".escapeshellarg($folders);
        $info=exec($cmd);
        //echo $info;
		if($info=="Everything is Ok")
		{echo json_encode(array("state"=>"true","data"=>""));}
		else
		{echo json_encode(array("state"=>"false","data"=>$info));}
    }
	function start()
	{

		if(!isset($_GET["fileName"]))
		{
			echo json_encode(array("state"=>"false","data"=>""));
		}
		$fileName=$_GET["fileName"];
		$folders=$_GET["folders"];
		$proType=$_GET["type"];
		
		switch($proType){
			case "X86":break;
			case "Android": androidTar($fileName,$folders); break;
		}
	}
	start();
?>
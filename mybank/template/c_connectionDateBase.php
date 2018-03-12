
<?php
include_once("readMode.php");
$t=new TemplateManagement();
$tt=$t->GetTemplates();
/*echo "<pre>";
print_r($tt);
echo "</pre>";
exit();*/
$bl=1;//ËõÐ¡±ÈÀý

//echo "<DIV STYLE=\"display:inline; font-size:12px;\">";
for($i=0;$i<count($tt);$i++)
{
		$bl=$tt[$i][0]["F_Height"]/120;

	$w=$tt[$i][0]["F_Width"]/$bl;
	$h=$tt[$i][0]["F_Height"]/$bl;
 
	echo "<div class=\"temp_sample\" style=\"text-align:center;  display:block;width:auto;float:left; margin-left:5px;\">";
		echo "<a href=\"javascript:getTemp(".$tt[$i][0]["TemplateID"].");\">";
			echo "<div class=\"div\"  style=\"width:".$w."px; height:".($h+17)."px; \">";
				echo "<div style=\"display:block; height:16px; font-size:12px;\">".$tt[$i][0]["TemplateName"]."</div>";
				echo "<DIV STYLE=\"font-size:1px;display:block; width:".$w."px; height:".$h."px; background-color:#0099ff;   padding:0px; float:left;\">";
					echo "<div style=\"position:relative; display:block;width:".$w."px; height:".$h."px;\">";
						for($a=1; $a<count($tt[$i]); $a++)
						{
							echo "<div style=\"position:absolute; background-color:green; border:1px solid; width:".(($tt[$i][$a]["Width"])/$bl-2)."px; height:".(($tt[$i][$a]["Height"])/$bl-2)."px; left:".(($tt[$i][$a]["X"])/$bl)."px; top:".(($tt[$i][$a]["Y"])/$bl)."px;\"></div>";
							
						}
					echo "</div>";
				echo "</DIV>";
				echo "<div style=\"display:block; height:16px; font-size:12px;\">".$tt[$i][0]["F_Width"]."x".$tt[$i][0]["F_Height"]."</div>";
			echo "</div>";
		echo "</a>";
	echo "</div>";
}
?>




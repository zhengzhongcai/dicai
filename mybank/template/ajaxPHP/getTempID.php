<?php
include_once("../readMode.php");
$t=new TemplateManagement();

//print_r($tt);

/*if(count($HTTP_POST_VARS)>0)
{
foreach($HTTP_POST_VARS as $key => $value)
{$$key=$value;}}
if(count($HTTP_GET_VARS)>0){
foreach($HTTP_GET_VARS as $key => $value)
{$$key=$value;}
}*/

$tt=$t->GetTempID();
/*print_r($tt);

echo "<hr >";*/
/*if(count($tt)>1)
{
	$st="[\"".$tt[0][0]."\",\"".$tt[0][1]."\"],";
}
else
{$st="[\"".$tt[0][0]."\",\"".$tt[0][1]."\"]";}*/

for($i=0; $i<count($tt); $i++)
{
	//echo substr($tt[$i][1],0,8)."<br>";
		if(substr($tt[$i][1],0,8)!="********")
		{
			$st.="[\"".$tt[$i][0]."\",\"".$tt[$i][1]."\"],";
		}
}
$s=substr($st,0,strlen($st)-1);
echo $s;
?>
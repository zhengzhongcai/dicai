<?php
session_start();
if(chkLogin())
{	
	echo $_SESSION["opuser"];
}
else { echo "isTimeOut";}




function chkLogin()
{
	if(isset($_SESSION["opuser"]))
	{
		$nowtimestamp=time();
		//if ($nowtimestamp-$_SESSION['optimestamp']<120)
			$_SESSION['optimestamp']=$nowtimestamp;
		return true;
	}
	else
	{
		return false;
	}
}
?>
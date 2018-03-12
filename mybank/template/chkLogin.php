<?php
/*
用户登陆后保存的session变量说明
['opuser']=>userName
['opuserID']=>userID
['optype']=>userType 1管理员2普通用户
['opctree']=>ClientTreeID(array) 可管理终端树根ID
['optrad']=>AccessID(array)	分配的权限
['optimestamp']=>用户最近操作时间(5分钟后更新一次)
查看变量接口http://192.168.100.55:81/CI/index.php/user/showsession
*/
include_once('../../config.php');

if(!chkLogin()){
	//echo $myconfig['base_url'];
	Header("Location:".$myconfig['base_url']."index.php/user/login");
}
function chkLogin()
{
	$nowtimestamp = time();
	if (@$_SESSION['opuser']!='')
	{
		if ($nowtimestamp-$_SESSION['optimestamp']>300)
			$_SESSION['optimestamp']=$nowtimestamp;
		return true;
	}
	else
	{
		return false;
	}
}
?>
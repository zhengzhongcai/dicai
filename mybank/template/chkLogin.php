<?php
/*
�û���½�󱣴��session����˵��
['opuser']=>userName
['opuserID']=>userID
['optype']=>userType 1����Ա2��ͨ�û�
['opctree']=>ClientTreeID(array) �ɹ����ն�����ID
['optrad']=>AccessID(array)	�����Ȩ��
['optimestamp']=>�û��������ʱ��(5���Ӻ����һ��)
�鿴�����ӿ�http://192.168.100.55:81/CI/index.php/user/showsession
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
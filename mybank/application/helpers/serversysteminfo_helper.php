<?php

//获取操作系统是32位还是64位
function systemBit()
{
	$a=21474836419;
	if((int)$a>0)
	{return 64;}
	else
	{return 32;}
}
?>
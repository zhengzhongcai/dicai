	
	/******************************************
	 *作者：kycool	
	 *时间：2012/7/9 21:00:11
	 *描述：对用户输入的信息进行简单的验证
	 *返回：如果用户没有缺少输入信息则返回true
				  否则返回false
	 ******************************************/
	 function  checklogin(){
			if(document.forms[0].user.value==""){
					art.dialog(
							{
								title:"提示",
								content:"亲爱的用户：请输入用户名",
								width:300,
								height:100,
								top:'50%',
								left:"100%",
								lock:true,
								time:2000
							});
					document.forms[0].user.focus();
					return false;
			}

			if(document.forms[0].pwd.value==""){
					art.dialog(
							{
								title:"提示",
								content:"亲爱的用户：请输入密码",
								width:300,
								height:100,
								lock:true,
								time:2000
							});
					document.forms[0].pwd.focus();
					return false;
			}

			/*if(document.forms[0].chknumber.value==""){
					art.dialog(
							{
								title:"提示",
								content:"亲爱的用户：请输入验证码",
								width:300,
								height:100,
								lock:true,
								time:2000
							});
					document.forms[0].chknumber.focus();
					return false;
			}*/
			return true;
	 }


	



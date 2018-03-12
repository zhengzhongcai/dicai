 /**********************************************************
	  *作者：kycool
	  *时间：2012/7/10 15:14:57
	  *描述：ajax：监听unload事件，当用户选择退出时则
		用ajax方法返回服务器调用删除session函数
	  *返回：无
	  **********************************************************/
	  function unloadSession(){
			var xmlHttp;
			xmlHttp=getXmlHttpObject();
			if(xmlHttp==null){
					art.dialog(
							{
								title:"提示",
								content:"亲爱的用户：浏览器不支持HTTP Request",
								width:300,
								height:100,
								lock:true,
								time:2000
							});
					 return;
			}
			var url="http://192.168.100.37/CI/index.php/login/login/unSession/";
			xmlHttp.open("POST",url,false);
			xmlHttp.send();
			return;
	  }

	 /**********************************************************
	  *作者：kycool
	  *时间：2012/7/10 15:38:45
	  *描述：获取xmlHttp对象
	  *返回：返回XMLHttpRequest对象
	  **********************************************************/
	  function getXmlHttpObject(){
			var xmlHttp=null;
			try{
					xmlHttp=new XMLHttpRequest();
			}
			catch(e){
					try{
							xmlHttp=new ActiveXObject("Msxm12.XMLHTTP");
					}
					catch(e){
							xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
			}
		   return xmlHttp;
	  }

      /*
		监听到页面的退出的事件
	    标志
	  */
	    
	 // window.onunload=unloadSession;


	  /******************************************************************
	   *作者：kycool
	   *时间：2012/7/10 15:37:57
	   *描述：ajax：每隔一定的时间，发送到服务器调用重置session
	                的方法
	   *返回：无
	   ******************************************************************/
	   function  resetSession(){
			var xmlHttp;
			xmlHttp=getXmlHttpObject();
			if(xmlHttp==null){
					art.dialog(
							{
								title:"提示",
								content:"亲爱的用户：浏览器不支持HTTP Request",
								width:300,
								height:100,
								lock:true,
								time:2000
							});
					 return;
			}
			var url="http://192.168.100.37/CI/index.php/login/login/resetSession/";
			xmlHttp.open("POST",url,false);
			xmlHttp.send();
			return;
	   }
		
	   /*
		定时的刷新重置标志的session
	   */
	  // window.onload=setInterval(resetSession,1000);



	   /***********************************************************************
	    *作者：kycool
		*时间：2012/7/10 19:04:26
		*描述：监听页面所有的点击事件，如果检测到用户在规定的时间中
					  产生点击事件，那么此函数会让用户退出
		*返回：无
		************************************************************************/
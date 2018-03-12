/*******************************
用法1:
function  xxx ()
{
	var myinfo = document.getElementById("id");
	var myajax= new DedeAjax(
							 myinfo,        ------>此处为一个html对象 ,当第二个参数为false的时候,返回的信息会显示在,对象myinfo中
							 true,			------>true  表示调用用户自定义的方法来处理返回的数据;  false 表示把数据显示在对象myinfo中
							 create			------>用户自定义的方法
							 );
	myajax.AddKey("key","value"); 	---->数据键值对
	myajax.SendPost("您要请求的服务器页面");	----->post  方式提交,服务器使用post方式获取
	或者
	myajax.SendGet("您要请求的服务器页面");	----->get  方式提交,服务器使用get方式获取
}

function create(obj)
{
	obj  表示Ajax返回的数据
}

方法二:

function mmmm()
{
	var myinfo = document.getElementById("id");
	var myajax= new DedeAjax( myinfo, true,
							 function(obj)
							 {
								 Ajax返回数据处理
								}
							 );
	myajax.AddKey("key","value"); 	-
	myajax.SendPost("您要请求的服务器页面");
}


********************************/

<!--
//xmlhttp和xmldom对象
var DedeXHTTP = null;
var DedeXDOM = null;
var DedeContainer = null;
var KeyT=0;
//获取指定ID的元素
function $(eid){
	return document.getElementById(eid);
}

function $DE(id) {
	return document.getElementById(id);
}

//参数 gcontainer 是保存下载完成的内容的容器

function DedeAjax(gcontainer,userCode,userFunction,errorKey,errorFunction,timeOuttingFuntion,timeOutFuntion){

DedeContainer = gcontainer;
if(!errorKey){errorKey=false;}
//用户函数
var uFn=userFunction;
if(typeof(timeOuttingFuntion)=="undefined")
{
	KeyT=0;
}
else
{
	KeyT="OK";
}


//post或get发送数据的键值对
this.keys = Array();
this.values = Array();
this.keyCount = -1;

//http请求头
this.rkeys = Array();
this.rvalues = Array();
this.rkeyCount = -1;
//请求头类型
this.rtype = 'text';

//初始化xmlhttp
if(window.ActiveXObject){//IE6、IE5
   try { DedeXHTTP = new ActiveXObject("Msxml2.XMLHTTP");} catch (e) { }
   if (DedeXHTTP == null) try { DedeXHTTP = new ActiveXObject("Microsoft.XMLHTTP");} catch (e) { }
}
else{
	 DedeXHTTP = new XMLHttpRequest();
}

var k;
DedeXHTTP.onreadystatechange = function()
{
	if(KeyT=="OK")
	{
		KeyT=0;
		k=window.setInterval(function()
									  {

										  	if(KeyT>30)
											{
												window.clearInterval(k);
												timeOutFuntion("超时 "+KeyT+" 秒！");
											}
											else
											{
											timeOuttingFuntion(KeyT);
											KeyT=KeyT+1;
											}
										}
					,1000);
	}
	if(DedeXHTTP.readyState == 4)
	{
		if(DedeXHTTP.status == 200)
		{
		   // 传入当数据加载完后要执行的用户自定义的方法
		   if(userCode)
		   {
			   uFn(DedeXHTTP.responseText);
			   try{window.clearInterval(k);}
			   catch(e){}
			}
			else{DedeContainer.innerHTML = DedeXHTTP.responseText;}
		   DedeXHTTP = null;
		}
		else
		{

			if(errorKey){errorFunction(DedeXHTTP.status);}
			else
			{DedeContainer.innerHTML = "下载数据失败";}
		}

	}
	//else DedeContainer.innerHTML = "正在下载数据...";
};
//增加一个POST或GET键值对
this.AddKey = function(skey,svalue)
{
	this.keyCount++;
	this.keys[this.keyCount] = skey;
	this.values[this.keyCount] = svalue;
};
this.AddKey2 = function(skey,svalue)
{
	this.keyCount++;
	this.keys[this.keyCount] = skey;
	this.values[this.keyCount] = svalue;
};
//增加一个Http请求头键值对
this.AddHead = function(skey,svalue){
	this.rkeyCount++;
	this.rkeys[this.rkeyCount] = skey;
	this.rvalues[this.rkeyCount] = svalue;
};

//清除当前对象的哈希表参数
this.ClearSet = function(){
	this.keyCount = -1;
	this.keys = Array();
	this.values = Array();
	this.rkeyCount = -1;
	this.rkeys = Array();
	this.rvalues = Array();
};

//发送http请求头
this.SendHead = function(){
	if(this.rkeyCount!=-1){ //发送用户自行设定的请求头
  	for(;i<=this.rkeyCount;i++){
  		DedeXHTTP.setRequestHeader(this.rkeys[i],this.rvalues[i]);
  	}
  }
if(this.rtype=='binary'){
  	DedeXHTTP.setRequestHeader("Content-Type","multipart/form-data");
  }
  else if(this.rtype=='xml'){
	  DedeXHTTP.setRequestHeader("Content-Type","text/xml");
  }
  else{
  	DedeXHTTP.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
  }
};

//用Post方式发送数据
this.SendPost = function(purl){
	var pdata = "";
	var i=0;
	this.state = 0;
	DedeXHTTP.open("POST", purl, true);
	this.SendHead();
  if(this.keyCount!=-1){ //post数据
  	for(;i<=this.keyCount;i++){
  		if(pdata=="") pdata = this.keys[i]+'='+this.values[i];
  		else pdata += "&"+this.keys[i]+'='+this.values[i];
  	}
  }
  DedeXHTTP.send(pdata);
};

//用POST方式发送xml数据
this.SendPostXML = function(purl,pxml){
	DedeXHTTP.open("POST",purl,true);
	this.SendHead();
	DedeXHTTP.send(pxml);
};

//用GET方式发送数据
this.SendGet = function(purl){
	var gkey = "";
	var i=0;
	this.state = 0;
	if(this.keyCount!=-1){ //get参数
  	for(;i<=this.keyCount;i++){
  		if(gkey=="") gkey = this.keys[i]+'='+this.values[i];
  		else gkey += "&"+this.keys[i]+'='+this.values[i];
  	}
  	if(purl.indexOf('?')==-1) purl = purl + '?' + gkey;
  	else  purl = purl + '&' + gkey;
  }
	DedeXHTTP.open("GET", purl, true);
	this.SendHead();
  DedeXHTTP.send(null);
};

} // End Class DedeAjax

//初始化xmldom
function InitXDom(){
  if(DedeXDOM!=null) return;
  var obj = null;
  if (typeof(DOMParser) != "undefined") { // Gecko、Mozilla、Firefox
    var parser = new DOMParser();
    obj = parser.parseFromString(xmlText, "text/xml");
  } else { // IE
    try { obj = new ActiveXObject("MSXML2.DOMDocument");} catch (e) { }
    if (obj == null) try { obj = new ActiveXObject("Microsoft.XMLDOM"); } catch (e) { }
  }
  DedeXDOM = obj;
};

-->


function Cookie()
{
	//构造函数
}

/*******************************************
*
*	功能:
*		写入Cookie
*	参数:
*		name cookie的名称
*		value cookie的值
*		hours 保存的时间 单位为小时
*
********************************************/
Cookie.prototype.writeCookie=function(name, value, hours)
{
  try{var expire = "";
  if(hours != null)
  {
    expire = new Date((new Date()).getTime() + hours * 3600000);
    expire = "; expires=" + expire.toGMTString();
  }
  document.cookie = name + "=" + escape(value) + expire;}
  catch(e)
  {
	  alert(" cookie 写入失败"+e);
	 }
}
/*******************************************
*
*	功能:
*		读取Cookie
*	参数:
*		name cookie的名称
*	返回:
*		cookie的值
*
********************************************/
Cookie.prototype.readCookie=function(name)
{
  var cookieValue = "";
  var search = name + "=";
  if(document.cookie.length > 0)
  { 
    offset = document.cookie.indexOf(search);
    if (offset != -1)
    { 
      offset += search.length;
      end = document.cookie.indexOf(";", offset);
      if (end == -1) end = document.cookie.length;
      cookieValue = unescape(document.cookie.substring(offset, end))
    }
  }
  return cookieValue;
}
/*******************************************
*
*	功能:
*		通过cookie的起始位置读取Cookie
*	参数:
*		offset cookie的起始位置
*	返回:
*		cookie的值
*
********************************************/
Cookie.prototype.GetCookieVal=function(offset)
{
    var endstr = document.cookie.indexOf (";", offset);
    if (endstr == -1)
    endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}
/*******************************************
*
*	功能:
*		读取Cookie
*	参数:
*		name cookie的名称
*	返回:
*		cookie的值
*
********************************************/
Cookie.prototype.GetCookie=function(name) {
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen)
    {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
        return this.GetCookieVal (j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    }
    return null;
}
/*******************************************
*
*	功能:
*		删除Cookie
*	参数:
*		name cookie的名称
*	返回:
*		无
*
********************************************/
Cookie.prototype.DeleteCookie = function(name) 
{   
    var exp = new Date();
    exp.setTime (exp.getTime() - 1);
    var cval = this.GetCookie (name);
    document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}
/*******************************************
*
*	功能:
*		清除所有的Cookie
*	参数:
*		无
*	返回:
*		无
*
********************************************/
Cookie.prototype.ClearCookies=function()
{
    var temp=document.cookie.split(";");
        var ts;
        for (var i=0;;i++)
        {
            if(!temp[i])break;
            ts=temp[i].split("=")[0];
            this.DeleteCookie(ts);
        }
        document.getElementById("mg").innerHTML="COOKIE已清除！";
}
/********************************************
*
*
*	获取URL上传来的的参数
*	例如: 
*			var hrf=http://www.xxxxx.com?pth=a&ld=c
*			var arguments_1=GetArgsFromHref(hrf,"pth");
*			则:
*				arguments_1的值为:	a
*
*
********************************************/
function GetArgsFromHref(sHref, sArgName)
{
    var args  = sHref.split("?");
    var retval = "";
    if(args[0] == sHref) /*  参数为空   */
    {
         return retval; /*  无需做任何处理  */
    } 
    var str = args[1];
    args = str.split("&");
    for(var i = 0; i < args.length; i ++)
    {
        str = args[i];
        var arg = str.split("=");
        if(arg.length <= 1) continue;
        if(arg[0] == sArgName) retval = arg[1];
    }
    return retval;
}
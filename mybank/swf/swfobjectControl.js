var _debug=false;
var socket = {
    config :{
        ip:"127.0.0.1",
        port:2234,
        flashcontainer:"flashcontainer",
        auto:true
    },
	//连接Socket
     connect : function() {
        socket.showMessage("开始连接Socket服务器!");           
        socket.flash.connect("127.0.0.1", "2234");
     },
	 //发送数据
     send : function(msg) {
         if(socket.isConnected >= 1){
              socket.flash.send(msg);
         }
     },
	 //默认连接
     loaded : function() {       
         socket.flash = document.getElementById("SharpSocket");
         socket.isConnected = 0;
         if(socket.config.auto){
             socket.connect();
         }
     },
	 //检测是否
     connected : function() {
         socket.isConnected = 1;
         socket.showMessage("Socket连接成功");
		// xinTiao();
     },
     close : function() {
         socket.flash.close();
        socket.isConnected = 0;
        socket.showMessage("关闭Socket连接");
     },           
     disconnected : function() {
         socket.isConnected = 0;
         socket.showMessage("socket已经被关闭");
     },   
     ioError: function(msg) {
         socket.showMessage("ioError : "+msg);
        socket.isConnected = 0;
     },                         
     securityError: function(msg) {
         socket.showMessage("securityError : "+msg);
        socket.isConnected = 0;
     },
     receive: function(msg) {
		 if(_debug)
		 {
			var messageContainer=document.getElementById("message");
			 var d=new Date();
			 var str=messageContainer.value;
			 if(str.length>1000)
			 {
				  messageContainer.value="";
				  str="";
			 }
			 messageContainer.value=str+"\n"+msg+" "+d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
			 //alert(messageContainer.style.height+messageContainer.scrollHeight);
			 var mHeight=messageContainer.style.height;
			 messageContainer.scrollTop=(messageContainer.scrollHeight-mHeight.substring(0,mHeight.length-2));
		 }
		 //alert(messageContainer.scrollHeight-mHeight.substring(0,mHeight.length-2));
         var str_info=msg.split(" ");
		 if(str_info.length==2){
         playRelevanceFile(str_info[0],str_info[1]);}
     },
	 showMessage:function(msg)
	 {
	 if(_debug)
		 {
		  var LogContainer=document.getElementById("message");
		 var str=LogContainer.value;
		 LogContainer.value=str+"\n"+msg;
		 var mHeight=LogContainer.style.height;
		 LogContainer.scrollTop=(LogContainer.scrollHeight-mHeight.substring(0,mHeight.length-2));
		 }
		},
	encode:function(msg)
	{
		return escape(msg);
	},
	decode:function(msg)
	{
		return unescape(msg);
	}
};

function initialFlash(){
    var so = new SWFObject("SharpSocket.swf", "SharpSocket", "0", "0", "10", "#ffffff"); 
    so.addParam("allowscriptaccess", "always"); 
    so.addVariable("scope", "socket"); 
    so.write(socket.config.flashcontainer);
}

//发送数据
function sendInfo()
{
	socket.send(document.getElementById('cmd').value);
}

var si=null;
function xinTiao()
{
	if(si)
	{
		window.clearInterval(si);
	}
	else
	{
		si=window.setInterval("socket.send(1)",5000);
	}
}
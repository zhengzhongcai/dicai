<html> 
<head> 
<meta http-equiv="Content-Language" content="zh-cn"> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php echo $htmlMeta;?>
<title><?php echo iconv("gb2312","utf-8",$profileName);?></title> 
<script language="javascript">

var bgAudioAreaPlayer={
	iframeInfo:{},
	playHandel:{},
	playState:"",
	play:function(){
		var d=new Date();
			d=d.getTime()*1;
		var ifs=bgAudioAreaPlayer.iframeInfo;
		for(var i in ifs){
			var arg=[],
			itms=ifs[i][0];
				for(var k in itms){
				if(k!="src"&&k!="intermittent"){
					 arg.push(k+"_|_"+itms[k]);
					}
				}
			
			arg=arg.join("_+_");
			document.getElementById(i).src=itms.src+"?arg="+arg;
			bgAudioAreaPlayer.playHandel[i]={src:itms.mp3,time:d};
			break;
		}
		bgAudioAreaPlayer.playState=window.setInterval(function(){
			bgAudioAreaPlayer.changePlayIframe();
		},1000);
	},
	changePlayIframe:function(){
		var d=new Date();
			d=d.getTime()*1;
		var hand=bgAudioAreaPlayer.playHandel;
		var ifs=bgAudioAreaPlayer.iframeInfo;
		for(var i in hand){
			var srcItms=ifs[i];
			for(var a=0,b=srcItms.length; a<b; a++){
				if(srcItms[a].mp3==hand[i].src){
					if(d-hand[i].time>=srcItms[a].intermittent*1000){
						if(a==b-1){
							a=-1;
						}
						var arg=[],
							itms=srcItms[a+1];
								for(var k in itms){
								if(k!="src"&&k!="intermittent"){
									 arg.push(k+"_|_"+itms[k]);
									}
								}
							
							arg=arg.join("_+_");
						
						document.getElementById(i).src=itms.src+"?arg="+arg;
						bgAudioAreaPlayer.playHandel[i]={src:itms.mp3,time:d};
					}
				}
			}
		}
	},
	add:function(iframeId,arg){
		//arg={src:"audioPlayer.html",mp3:"bgmusic/1.mp3",loop:"loop=1",autoplay:"1",volume:"100",intermittent:7}
		if(!bgAudioAreaPlayer.iframeInfo.hasOwnProperty(iframeId)){
			bgAudioAreaPlayer.iframeInfo[iframeId]=[];
			}
		bgAudioAreaPlayer.iframeInfo[iframeId].push(arg);
	}
};

var webAreaPlayer={
	iframeInfo:{},
	playHandel:{},
	playState:"",
	play:function(){
		var d=new Date();
			d=d.getTime()*1;
		var ifs=webAreaPlayer.iframeInfo;
		for(var i in ifs){
			document.getElementById(i).src=ifs[i][0].src;
			webAreaPlayer.playHandel[i]={src:ifs[i][0].src,time:d};
		}
		webAreaPlayer.playState=window.setInterval(function(){
			webAreaPlayer.changePlayIframe();
		},1000);
	},
	changePlayIframe:function(){
		var d=new Date();
			d=d.getTime()*1;
		var hand=webAreaPlayer.playHandel;
		var ifs=webAreaPlayer.iframeInfo;
		for(var i in hand){
			var srcItms=ifs[i];
			for(var a=0,b=srcItms.length; a<b; a++){
				if(srcItms[a].src==hand[i].src){
					if(d-hand[i].time>=srcItms[a].intermittent*1000){
						if(a==b-1){
							a=-1;
						}
						document.getElementById(i).src=srcItms[a+1].src;
						webAreaPlayer.playHandel[i]={src:srcItms[a+1].src,time:d};
					}
				}
			}
		}
	},
	addSrc:function(iframeId,arg){
		//arg={src:"audioPlayer.html",intermittent:7}
		if(!webAreaPlayer.iframeInfo.hasOwnProperty(iframeId)){
			webAreaPlayer.iframeInfo[iframeId]=[];
			}
		webAreaPlayer.iframeInfo[iframeId].push(arg);
	}
};

//更改图片的function
function changeImg(objID,filesArr,state){
	var obj=document.getElementById(objID);
	var curIndex=parseInt(obj.getAttribute("curIndex"));
    if(state=="restart"){curIndex=0;}
	if (curIndex>=filesArr.length-1){ 
		curIndex=0; 
		obj.setAttribute("curIndex",curIndex);
	}else{
		curIndex+=1;
		obj.setAttribute("curIndex",curIndex);
	}
	obj.src=filesArr[curIndex];
} 
//更改flash的function
 function PlayFlash(arrFiles,arrTime) 
{ 
   this.count = arrFiles.length; 
   this.arrFiles = arrFiles; 
   this.arrTime = arrTime;  
 } 
 
 PlayFlash.prototype.strat=0; 
 PlayFlash.prototype.$=function (obj){return document.getElementById(obj);} 
 PlayFlash.prototype.nowTime = 0; 
 PlayFlash.prototype.subIndex = 0; 
 PlayFlash.prototype.Iframe=null;  
 PlayFlash.prototype.createIframe=function(objID){this.Iframe=this.$(objID);}; 
 PlayFlash.prototype.iframeInfo=function(ifr) 
  { 
     this.Iframe.style.width=ifr.w+"px";  
     this.Iframe.style.height=ifr.h+"px";   
  } 

 PlayFlash.prototype.f_w=0;  
 PlayFlash.prototype.f_h=0;  
 PlayFlash.prototype.createFlashInfo=function(f){this.f_w=f.w;this.f_h=f.h;};   
 PlayFlash.prototype.changFlash=function()  
 { 
    this.strat = 1;  
    this.Iframe.src="fplayer.html?flash="+this.arrFiles[this.subIndex]+"&w="+this.f_w+"&h="+this.f_h; 
  };  
 PlayFlash.prototype.itemTimer = function() 
 { 
   if(this.subIndex==this.count) 
   { 
 	  this.nowTime=0;  
 	  this.subIndex=0; 
 	  return this.arrTime[0]; 
   } 
   else 
   {  
 	  return this.arrTime[this.subIndex];    } 
 } 
  PlayFlash.prototype.runItem = function() 
 {  
    this.strat == 0 ? this.changFlash():null;  
   var a=this.subIndex;   
   if(this.nowTime==this.itemTimer()) 
    {  
       this.nowTime=0; 
        this.subIndex=this.subIndex+1;  
    } 
    else  
    {     
        this.nowTime = this.nowTime+1;  
   }  
    if(a!=this.subIndex){this.changFlash();}   
}

</script>
<script language="javascript" src="bx.core.js"></script>
<script language="javascript" src="swfobject.js"></script>
<script language="javascript" src="relevanceInfo.js"></script>
<script language="javascript" src="swfobjectControl.js"></script>
<script language="javascript">
    //-----------------------------------------
    //  功能说明:
    //          开始执行区域关联播放
    //  参数:
    //       无
    //  返回值: 无
    //  时间: 2011/10/20 23:59:08
    //  作者: BOBO
    //-----------------------------------------
    function relevanceStart()
    {
        if(arr_relevance)
        {
            var str_style="position:absolute; top:0px; left:0px; width:500px; height:500px; border:0px; background-color:#fff; ";
            var dom_dv=document.createElement("iframe");
            dom_dv.src="about:blank";
            dom_dv.setAttribute("style",str_style+"z-index:2;");
            dom_dv.setAttribute("allowtransparency","false");
            dom_dv.setAttribute("frameborder","0");
            document.body.appendChild(dom_dv);
            
             var dom_textArea=document.createElement("textarea");
            dom_textArea.id="message"
            dom_textArea.setAttribute("style",str_style+"z-index:100;");
            document.body.appendChild(dom_textArea);
            
            
            
            var dom_arrRelevance=getRelevanceArea();
            initialFlash();
        }
    }

    //-----------------------------------------
    //  功能说明:
    //          获取带有关联功能的区域
    //  参数:
    //       无
    //  返回值: Bolen 或者 结果集 Dom Array
    //  时间: 2011/10/23 23:59:08
    //  作者: BOBO
    //-----------------------------------------
    function getRelevanceArea()
    {
        var dom_arrDiv=childs(document.body,"div");
        var dom_arrRelevance=[];
        for(var i=0,n=dom_arrDiv.length; i<n; i++)
        {
            if(attr(dom_arrDiv[i],"relevanceKey")!=null)
            {
                dom_arrRelevance.push(dom_arrDiv[i]);
            }
        }
        return dom_arrRelevance.length>0?dom_arrRelevance:false;
    }
    
    //-----------------------------------------
    //  功能说明:
    //          播放关联的文件
    //  参数:
    //      relevanceKey 关联的主文件的MD5
    //  返回值: 无
    //  时间: 2011/10/24 0:14:26
    //  作者: BOBO
    //-----------------------------------------
    function playRelevanceFile(str_state,str_relevanceKey)
    {
	
        var obj_imgInfo=eval("window.obj_"+str_relevanceKey);
		
        if(typeof(obj_imgInfo)=="object")
        {
            for(var i=0,n=arr_relevance.length; i<n; i++)
            {
			   
                if(arr_relevance[i]["relevanceFileMd5"]==str_relevanceKey)
                {
                    if(str_state=="start")
                    {
                        
						obj_imgInfo.arr_files=arr_relevance[i]["relevanceFile"];
                        window.clearTimeout(obj_imgInfo.st);  
                        obj_imgInfo.state="restart";
						obj_imgInfo.playImg();
                    }
                    else
                    {
						obj_imgInfo.arr_files=obj_imgInfo.arr_oldFiles;
                        window.clearTimeout(obj_imgInfo.st);
                        obj_imgInfo.state="restart";
                        obj_imgInfo.playImg();
                    }
                }
            }
        }
    }
</script>
</head> 
<body onLoad="relevanceStart()" style=" margin:0px; padding:0px; width:<?php echo $bodyWidth ?>px; height:<?php echo $bodyHeight?>px;  overflow:hidden;" bgcolor="#000000">
<span id="flashcontainer"></span>
<!--将内容填到html中去-->
<?php echo $htmlCont;?>

</body>
<script>
	function ProgramPlayerStart(){
		var a=0;
		for(var i in bgAudioAreaPlayer.iframeInfo){
			a++;
		}
		if(a){bgAudioAreaPlayer.play();}
		
		var a=0;
		for(var i in webAreaPlayer.iframeInfo){
			a++;
		}
		if(a){webAreaPlayer.play();}
		
	}
	ProgramPlayerStart();
</script>

</html>

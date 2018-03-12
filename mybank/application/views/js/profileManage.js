// JavaScript Document
(function(){
    var d = art.dialog.defaults;
    d.skin = ['chrome'];
    d.drag = true;
    d.showTemp = 100000;
})();

//-----------------------------------
//
//	profile view
//  path profile name
//  2011年12月28日19:06:20
//-----------------------------------

function viewProfile(Path,name)
{
/*	var w=width(document),
	h=height(document);
	var path="FileLib/"+Path+"/"+Path+"_view.html";
	art.dialog({
		title:"播放单元预览",
		id:'viewPro',
		padding:0,
	    content: '信息加载中',
		lock:true
	});
	setTimeout(function(){
			//art.dialog.list["viewPro"].content('<iframe id="viewProfile_dialog" src="'+path+'" frameborder="0" allowtransparency="true"   style="width:'+(w-30)+'px;height:'+(h-55)+'px;"'+'onload=\"resizeViewPro(this.id)\"'+'></iframe>');
		    //art.dialog.list["viewPro"].content('<iframe id="viewProfile_dialog" src="'+path+'" frameborder="0" allowtransparency="true"   style="width:'+(w-30)+'px;height:'+(h-55)+'px;"'+'onload=\"resizeViewPro(this.id)\"'+'></iframe>');
		    art.dialog.list["viewPro"].content('<iframe id="viewProfile_dialog" src="'+Path+'" frameborder="0" allowtransparency="true"   style="width:'+(w-30)+'px;height:'+(h-55)+'px;"'+'onload=\"resizeViewPro(this.id)\"'+'></iframe>');

		},1000);*/
	var path="FileLib/"+Path+"/"+Path+"_view.html";
	art.dialog.open(path,
		{
			title:"预览节目: "+name, id:"viewPro", width:"98%",height:"98%", padding:0, lock:true,opacity:0.5,
			init:function(){
					var _this=this;
					addListener(this.iframe,"load",function(){
								
								var p=getIframe_WH(this);
								this.style.width=p.w+"px";
								this.style.height=p.h+"px";
								art.dialog.list["viewPro"].size(parseInt(p.w),parseInt(p.h));
								art.dialog.list["viewPro"].position("50%","50%");
						});
					var src= this.iframe.src;
					this.iframe.src=src;
					
				}
		});
}


function getIframe_WH(iframeObj)
{
	var _w=0,_h=0;
	 var iframeHeight=0;
            //if ((navigator.userAgent.indexOf("Firefox")>0) || (navigator.userAgent.indexOf("Chrome")>0)) { // Mozilla, Safari, ...
			if ((navigator.userAgent.indexOf("Gecko")>0) || (navigator.userAgent.indexOf("Presto")>0)) { // Mozilla, Safari, ...
				_w=(_(iframeObj).contentDocument.body.style.width).replace("px","");
				_h=(_(iframeObj).contentDocument.body.style.height).replace("px","");
            } else if (navigator.userAgent.indexOf("MSIE")>0) { // IE  记
				_w=((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.width).replace("px","");
				_h=((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.height).replace("px","");
            }
	return {w:_w,h:_h};
}


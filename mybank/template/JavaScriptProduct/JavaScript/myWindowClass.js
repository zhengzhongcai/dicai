function DivWindow()
{	
	this.newId="";
	this.myWindowClassName="";
	this.myWindowStyle="";
	this.WindowContainer="";
}
DivWindow.prototype._=function(objId){return document.getElementById(objId);};
//获取指针相对于页面的位置
//ev触发的事件
DivWindow.prototype.mouseCoords=function (ev)
{
	if(ev.pageX || ev.pageY){
	return {x:ev.pageX, y:ev.pageY};
	};
	return {
	x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
	y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
};
/*

	ev,											---------->鼠标事件
	newId,										---------->窗口容器id
	myWindowStyle,						---------->窗口容器样式
	myWindowClassName,				---------->窗口容器样式名称
	imageBaseUrl,							---------->窗口UI图片路径

*/
//创建容器层
DivWindow.prototype.createContainer=function(ev,newId,myWindowStyle,myWindowClassName,imageBaseUrl)
{
	var positoin=this.mouseCoords(ev);
	this.newId=newId;
	if(this._(newId))
	{
		if(this._(newId).style.display=="none")
		{
//			this._(newId).style.left=positoin.x+"px";
//			this._(newId).style.top=positoin.y+"px";
			this._(newId).style.left=(positoin.x-300)+"px";
			this._(newId).style.top=(positoin.y-150)+"px";
			this._(newId).style.display="block";
		}
		else
		{this.closeMyWindow();};
		return false;
	};
	
	if(myWindowStyle!=null){this.myWindowStyle=myWindowStyle;}
	else{if(myWindowClassName!=null){this.myWindowClassName=myWindowClassName;}else{this.myWindowStyle="width:auto; height:auto; display:block; position:absolute; z-index:1000;";};};
	var table=this.myTable(imageBaseUrl,newId);
	var dv=document.createElement("DIV");
	
	
		dv.id=newId;
		dv.style.cssText=this.myWindowStyle;
		dv.className=this.myWindowClassName;
//		dv.style.left=positoin.x+"px";
//		dv.style.top=positoin.y+"px";
		dv.style.left=(positoin.x-300)+"px";
		dv.style.top=(positoin.y-150)+"px";
		dv.innerHTML=table;
	
	document.body.appendChild(dv);
	this.WindowContainer=dv;
	return {
		WindowTitle:this._("myWindowTitle"+newId),
		WindowBody:this._("myWindowBody"+newId),
		WindowFoot:this._("myWindowBottem"+newId)
		};
};
//创建UI界面
DivWindow.prototype.myTable=function(imageBaseUrl,newId)
{
	var table="<TABLE width='auto'  border='0' cellspacing='0' cellpadding='0'>\
					<TR>\
						<TD width='15'><IMG name='bg_t_l' src='"+imageBaseUrl+"/myWindow/bg_t_l.png' width='15' height='22' border='0' id='bg_t_l'  /></TD>\
						<TD background='"+imageBaseUrl+"/myWindow/bg_t_m.png' id='myWindowTitle"+newId+"'></TD>\
						<TD width='15'><IMG name='bg_t_r' src='"+imageBaseUrl+"/myWindow/bg_t_r.png' width='15' height='22' border='0' id='bg_t_r'  /></TD>\
					</TR>\
					<TR>\
						<TD background='"+imageBaseUrl+"/myWindow/bg_l_m.png'></TD>\
						<TD style='background-color:#eeeeee; padding:0px;' id='myWindowBody"+newId+"'>&nbsp;</TD>\
						<TD background='"+imageBaseUrl+"/myWindow/bg_r_m.png'></TD>\
					</TR>\
					<TR>\
						<TD height='17'><IMG name='bg_l_b' src='"+imageBaseUrl+"/myWindow/bg_l_b.png' width='15' height='17' border='0' id='bg_l_b'  /></TD>\
						<TD background='"+imageBaseUrl+"/myWindow/bg_b_m.png' id='myWindowBottem"+newId+"'></TD>\
						<TD height='17'><IMG name='bg_b_r' src='"+imageBaseUrl+"/myWindow/bg_b_r.png' width='15' height='17' border='0' id='bg_b_r'  /></TD>\
					</TR>\
				</TABLE>";
				return table;
}
//存在时关闭弹出窗口
DivWindow.prototype.closeMyWindow=function()
{
	this._(this.newId).style.display="none";
};

//重置窗口位置
DivWindow.prototype.newPosition=function(ev,id)
{
	var positoin=this.mouseCoords(ev);
	this.WindowContainer=this._(id);
	var w=this.WindowContainer.clientWidth||this.WindowContainer.offsetWidth;
	var h=this.WindowContainer.clientHeight||this.WindowContainer.offsetHeight;
	//alert((document.documentElement.clientHeight-positoin.y>h?positoin.y:positoin.y-h)+"\n w: "+(document.documentElement.clientWidth-positoin.x>w?positoin.x:positoin.x-w));
	this.WindowContainer.style.top=((document.documentElement.clientHeight-h)/2)+"px";
	this.WindowContainer.style.left=((document.documentElement.clientWidth-w)/2)+"px";
}
DivWindow.prototype.tablePart=function(newId)
{

return {
		WindowTitle:this._("myWindowTitle"+newId),
		WindowBody:this._("myWindowBody"+newId),
		WindowFoot:this._("myWindowBottem"+newId)
		};
}
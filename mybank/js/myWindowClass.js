function DivWindow()
{	
	this.newId="";
	this.myWindowClassName="";
	this.myWindowStyle="";
	this.WindowContainer="";
}
DivWindow.prototype.get$=function(objId){return document.getElementById(objId);};
//��ȡָ�������ҳ���λ��
//ev�������¼�
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

	ev,											---------->����¼�
	newId,										---------->��������id
	myWindowStyle,						---------->����������ʽ
	myWindowClassName,				---------->����������ʽ����
	imageBaseUrl,							---------->����UIͼƬ·��

*/
//����������
DivWindow.prototype.createContainer=function(ev,newId,myWindowStyle,myWindowClassName,imageBaseUrl)
{
	var positoin=this.mouseCoords(ev);
	this.newId=newId;
	if(this.get$(newId))
	{
		if(this.get$(newId).style.display=="none")
		{
			this.get$(newId).style.left=positoin.x+"px";
			this.get$(newId).style.top=positoin.y+"px";
			this.get$(newId).style.display="block";
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
		dv.style.left=positoin.x+"px";
		dv.style.top=positoin.y+"px";
		dv.innerHTML=table;
	
	document.body.appendChild(dv);
	this.WindowContainer=dv;
	return {
		WindowTitle:this.get$("myWindowTitle"+newId),
		WindowBody:this.get$("myWindowBody"+newId),
		WindowFoot:this.get$("myWindowBottem"+newId)
		};
};
//����UI����
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
//����ʱ�رյ�������
DivWindow.prototype.closeMyWindow=function()
{
	this.get$(this.newId).style.display="none";
};

//���ô���λ��
DivWindow.prototype.newPosition=function(ev,id)
{
	var positoin=this.mouseCoords(ev);
	this.WindowContainer=this.get$(id);
	var w=this.WindowContainer.clientWidth||this.WindowContainer.offsetWidth;
	var h=this.WindowContainer.clientHeight||this.WindowContainer.offsetHeight;
	//alert((document.documentElement.clientHeight-positoin.y>h?positoin.y:positoin.y-h)+"\n w: "+(document.documentElement.clientWidth-positoin.x>w?positoin.x:positoin.x-w));
	this.WindowContainer.style.top=((document.documentElement.clientHeight-h)/2)+"px";
	this.WindowContainer.style.left=((document.documentElement.clientWidth-w)/2)+"px";
}
DivWindow.prototype.tablePart=function(newId)
{

return {
		WindowTitle:this.get$("myWindowTitle"+newId),
		WindowBody:this.get$("myWindowBody"+newId),
		WindowFoot:this.get$("myWindowBottem"+newId)
		};
}
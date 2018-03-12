var Class=function (){
		var klass=function (){
			this.init.apply(this.aguments);
		};
		klass.prototype.init=function(){};
		klass.fn=klass.prototype;
		klass.fn.parent=klass;
		
		klass.extend = function(obj){
			var extended = obj.extended || obj.setup;
			for(var i in obj)
			{
			  this[i] = obj[i];
			}
			if (extended) extended(this);
		};
		
		klass.include= function(obj){
			var included = obj.included || obj.setup;
			for(var i in obj)
			{
			  this.fn[i] = obj[i];
			}
			if (included) included(this);
		};
		klass.proxy= function(func){
			var thisObject = this;
			return(function(){ 
			  return func.apply(thisObject, arguments); 
			});
		}
		klass.fn.proxy=klass.proxy;
		return klass;
	}
	
/*
 * 
 * @description 使用shiftKey 开启多选拖拽
 * @param clone Bool 是否使用克隆模式
 * @param dragMultiple Bool 是否开启批量拖拽
 * @param events Object 拖动过程中触发的鼠标事件 mouseDown:function(){},mouseUp:function(){},mouseMove:function(){} 
 * 
 *
 */
var dgFactory=new Class();
dgFactory.extend({
		guid:1000,
		dragHand:"",
		dragGuid:"",
		entity:{},
		init:function(option){
			this.guid++;
			this.entity[this.guid]={
				clone:false,
				dragItem:"", //被拖拽的对象
				dragItemArray:[], //开启批量拖拽时候存储被拖拽的对象
				dragOldItem:"", //如果开启克隆,这里存储原对象而不是克隆对象
				dragMultiple:false,
				state:false,
				dragContainerArr:[/*{domItem:"",mi_x:"",mi_y:"",ma_x:"",ma_y:""}*/], //被拖拽对象的容器队列
				focusArea:"",
				events:{mouseDown:function(){},mouseUp:function(){},mouseMove:function(){},multipleCheck:function(){return true;}}
			};
			for(var i in option)
			{
				
				if(i=="events"){
					var eves=this.entity[this.guid][i];
					for(var a in eves)
					{
						if(option[i].hasOwnProperty(a))
						{
							this.entity[this.guid][i][a]=option[i][a];
						}
					}
				}
				else
				{this.entity[this.guid][i]=option[i];}
			}
			return this.guid;
		},
		setHanderPos:function(ev){
			var _this=dgFactory;
			var corsur=getMousePos(ev)
			with(_this.dragHand.style){
				position="absolute";
				left=(corsur.x+10)+"px";
				top=(corsur.y+10)+"px";
			}
		},
		multipleAdd:function(dom_item,ev,guid){
			var _this=dgFactory;
			if(_this.dragGuid!=guid){return false;}
			if(_this.entity[guid].dragMultiple)
			{
				bug("multipleAdd","ev: "+ev.button+ " key: "+ev.ctrlKey);
				if(!ev.shiftKey){return false;}
				for(var i=0, n= _this.entity[guid].dragItemArray.length; i<n; i++)
				{
					if(_this.entity[guid].dragItemArray[i].innerHTML==dom_item.innerHTML)
					{
						return false;
					}
				}
				if(_this.entity[guid].clone)
				{
					dom_item=dom_item.cloneNode(true);
				}
				// 检测小类型是否匹配 默认不检测
				if(_this.entity[guid].events.multipleCheck(dom_item))
				{
					_this.entity[guid].dragItemArray.push(dom_item);
					_this.dragHand.appendChild(dom_item);
				}
			}
		},
		newDrag:function(guid,array_dom,str_tagName){
			
			var _this=this;
			var dragItems=[],dragConItem="";
			//alert(array_dom.length);
			for(var i=0,n=array_dom.length; i<n; i++)
			{   
				dragConItem=array_dom[i];
				attr(dragConItem,"guid",this.guid.toString());
				var pos=getElementPos(dragConItem);
				var w=dragConItem.offsetWidth,h=dragConItem.offsetHeight;
		         //alert(this.hasDgContainer(guid,dragConItem));
				if(!this.hasDgContainer(guid,dragConItem))
				{
					this.entity[guid].dragContainerArr[this.entity[guid].dragContainerArr.length]={
						domItem:dragConItem,
						mi_x:pos.x,
						mi_y:pos.y,
						ma_x:(w+pos.x),
						ma_y:(h+pos.y)
					};
				}
				dragItems=childs(dragConItem,str_tagName);
				
                   for(var a=0, m=dragItems.length; a<m; a++)
				{   //判断是否是播放区域div中的缩放div
					if(dragItems[a].getAttribute('bar')==null){
                         attr(dragItems[a],"guid",guid.toString());
					     addListener(dragItems[a],"mousedown",this.dragStart);
					     bindMouseOver(dragItems[a],function(ev){
						 addClass(this,"OverDragBox");
						var guid= attr(this,"guid");
						//是否开启多选
						if(!_this.entity[guid].state){return false;};
						//_this.multipleAdd(this,ev,guid);
						});
						bindMouseOut(dragItems[a],function(){
							rmClass(this,"OverDragBox");
						});

					}


				} 

				
				
				
				
			}
		},
		hasDgContainer:function(guid,dom_dragConItem){
			var arr_dgCons=this.entity[guid].dragContainerArr;
			for(var i in arr_dgCons){
				if(arr_dgCons[i].domItem==dom_dragConItem)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		},
		addDragItem:function(guid,dragConItem,str_tagName){
			var _this=dgFactory;
			var dragItems=childs(dragConItem,str_tagName);
				for(var a=0, m=dragItems.length; a<m; a++)
				{
					attr(dragItems[a],"guid",guid.toString());
					addListener(dragItems[a],"mousedown",_this.dragStart);
					//addListener(dragItems[a],"mousedown",function(){
					//	alert(this.innerHTML);
					//});
/*					$(dragItems[a])
						.attr("guid",guid.toString())
						.mouseenter(function(ev){
							addClass(this,"OverDragBox");
							var guid= attr(this,"guid");
							//是否开启多选
							if(!_this.entity[guid].state){return false;};
							_this.multipleAdd(this,ev,guid);
						})
						.mouseleave(function(){
							rmClass(this,"OverDragBox");
						})
						.mousedown(_this.dragStart);*/
					bindMouseOver(dragItems[a],function(ev){
						addClass(this,"OverDragBox");
						var guid= attr(this,"guid");
						//是否开启多选
						if(!_this.entity[guid].state){return false;};
						_this.multipleAdd(this,ev,guid);
					});
					bindMouseOut(dragItems[a],function(){
						rmClass(this,"OverDragBox");
					});
				}
		},
		updateDragContainer:function(guid,dragContainer){
			var _this=dgFactory;
			var dragContainerArr = _this.entity[guid].dragContainerArr;
			for(var i =0,n=dragContainerArr.length; i<n; i++){
				if(dragContainer==dragContainerArr[i].domItem){
					var dragConItem=dragContainer;
					var pos=getElementPos(dragConItem);
					var w=dragConItem.offsetWidth,h=dragConItem.offsetHeight;
					this.entity[guid].dragContainerArr[i]={
						domItem:dragConItem,
						mi_x:pos.x,
						mi_y:pos.y,
						ma_x:(w+pos.x),
						ma_y:(h+pos.y)
					};
				}
			}
		},
		dragMouseMove:function(ev){
			var _this=dgFactory;
			var guid = _this.dragGuid;
		//	bug("dragMouseMove","");
			if(_this.entity[guid].dragItem!="")
			{
				_this.setHanderPos(ev);
			}
			if(_this.entity[guid].focusArea!="")
			{
				_this.entity[guid].events.mouseMove(_this.entity[guid]);
			}
		},
		dragMouseUp:function(ev){
			
			var _this=dgFactory;
			var guid = _this.dragGuid;
			bug("dragMouseMove","remove bind mouse event");
			removeListener(document,"mousemove",_this.dragMouseMove);
			removeListener(document,"mouseup",_this.dragMouseUp);
			var corsur=getMousePos(ev),
				container = _this.entity[guid].dragContainerArr;
			var arr_focusContainer=[];
			for(var i =0,n=container.length; i<n; i++)
			{
				if(container[i].mi_x<=corsur.x&&corsur.x<=container[i].ma_x&&container[i].mi_y<=corsur.y&&corsur.y<=container[i].ma_y)
				{
					arr_focusContainer.push(container[i]);
					
				}
			}
			 _this.entity[guid].focusArea=arr_focusContainer;
			//for(var i =0, n=arr_focusContainer.length; i<n; i++){
				
			//}
			
			if(_this.entity[guid].focusArea!="")
			{
				_this.entity[guid].events.mouseUp(_this.entity[guid]);
			}
			 
			//清理当前拖拽的相关信息
			with(_this.entity[guid]){
				dragItem="";
				dragOldItem="";
				dragItemArray=[];
				state=false;
				focusArea="";
			}
			addClass(_this.dragHand,"dragHanderHidden");
			_this.dragHand.innerHTML="";
			
		},
		dragStart:function(ev){
			var _this=dgFactory;
			var guid = _this.dragGuid = attr(this,"guid");
			// 这里的this表示的是当前鼠标触发的mouseDown事件的HTMLDOM
			// 是否开启了拖拽对象的克隆模式
			if(_this.entity[guid].clone){
				_this.entity[guid].dragOldItem =this;
				_this.entity[guid].dragItem = this.cloneNode(true);
			}
			else
			{
				_this.entity[guid].dragItem = this;
			}
			_this.entity[guid].dragItemArray.push(_this.entity[guid].dragItem);
			// 拖拽容器对象, 用来容纳被拖拽的HTMLDOM
			if(!_("dragHander"))
			{
				var dragHand=document.createElement("div");
				addClass(dragHand,"dragHander");
				dragHand.id="dragHander";
				_this.dragHand=dragHand;
				document.body.appendChild(dragHand);
			}
			else
			{
				rmClass(_this.dragHand,"dragHanderHidden");
			}
			_this.setHanderPos(ev);
			_this.dragHand.appendChild(_this.entity[guid].dragItem);
			_this.entity[guid].state=true;
			//alert(dgFactory.dragItem.innerHTML);
			bug("dragMouseMove","add bind mouse event");
			addListener(document,"mousemove",_this.dragMouseMove);
			addListener(document,"mouseup",_this.dragMouseUp);
			addListener(document,"select",function(){return false;});
			_this.entity[guid].events.mouseDown(_this.entity[guid]);
		}
	});

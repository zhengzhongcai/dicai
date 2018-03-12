var clientGroupTree={
		treeContainer:"tree_container",
		currentDrag:"", // 当前正在被拖动的对象
		currentFocusTreeItem:"", //被拖动对象,悬浮的Tree 节点
		lastFocusTreeItem:"", //被拖动对象,悬浮的上一个Tree 节点
		treeList:{},
		init:function(){
				this.bindDrag();
				this.bindTreeMouseHandle();
				this.setDragInfo();
			},
		bindTreeMouseHandle:function(){
			//addClassName(_("tree_container"),"group_vh_handle");
			bindMouseOver("tree_container",function(){removeClassName(_("tree_container"),"group_vh_handle");});
			bindMouseOut("tree_container",function(){addClassName(_("tree_container"),"group_vh_handle");});
		},
		
		changeCheck:function(ev)
		{ 
			
			var dom_n="",o=evTag(ev);
			var dom_item=getSpecificParent(o,"div"); //点击的那条信息
			clientGroupTree.changeFirstFather(dom_item);
			clientGroupTree.changeFartherChecked(dom_item);
			
			if(attr(dom_item,"type")=="item"&&attr(dom_item,"father")=="father")
			{
				dom_n=getSpecificParent(dom_item,"div");
				if(getFirstChild(dom_n)==dom_item)
				{
					var state="1";
					if(attr(o,"checked")*1)
					{
						clientGroupTree.changeCheckBox(o,1);
						state="0";
					}
					else{
						clientGroupTree.changeCheckBox(o,0);
					}
					bug(" dom_n","dom_item: 为终端组!");
					clientGroupTree.diGuiChecked(dom_n,state,dom_item);
				}
			}
			else
			{
				if(attr(o,"checked")*1)
				{
					clientGroupTree.changeCheckBox(o,1);
					
				}
				else{
					clientGroupTree.changeCheckBox(o,0);
				}
				clientGroupTree.changeFirstFather(dom_item);
			}
			stopBubble(ev);
		},
		diGuiChecked:function(dom_n,state,dom_item)
		{
			if(!dom_n){return false;}
			var dom_divs=getChildNodes(dom_n,"div");
			if(dom_divs.length==0){return false;}
			var dom_checkbox="";
			for(var i in dom_divs)
			{
				if(dom_divs[i]==dom_item){continue;}
				if(attr(dom_divs[i],"type")=="group")
				{clientGroupTree.diGuiChecked(dom_divs[i],state);}
				else
				{
					dom_checkbox=dom_divs[i].getElementsByTagName("ins")[0];
					attr(dom_checkbox,"checked",state);
					if(state*1){changeClass(dom_checkbox,"checkBoxChecked","checkBox");}else{changeClass(dom_checkbox,"checkBox","checkBoxChecked");}
				}
			}
		},
		changeFirstFather:function(dom_item){
			if(attr(dom_item,"father")=="father"){return ;}
			var dom_childs=childs(getParentNode(dom_item)),state=true,check="";
			for(var i=1, n=dom_childs.length; i<n; i++){
				check=attr(dom_childs[i].getElementsByTagName("ins")[0],"checked")*1;
				if(!check){
					state=false;
				}
			}
			if(state)
			{
				var dom_input =dom_childs[0].getElementsByTagName("ins")[0]; //当前节点的父节点
				
				if(attr(dom_input,"checked")*1)
				{
					clientGroupTree.changeCheckBox(dom_input,1);
				}
				else{
					clientGroupTree.changeCheckBox(dom_input,0);
				}
			}
		},
		changeFartherChecked:function (o)
		{

			var dom_ffparent=getSpecificParent(o,2);
			bug("changeFartherChecked","type: "+attr(dom_ffparent,"type"));
			
			if(attr(dom_ffparent,"type")=="group")
			{
				var dom_checkbox=getFirstChild(dom_ffparent).getElementsByTagName("ins")[0];//getFirstChild(getFirstChild(getChildNodes(getFirstChild(dom_ffparent),"b")[0]));
				if(attr(dom_checkbox,"checked")*1)
				{
					i=1;
					var dom_pNodes=getChildNodes(dom_ffparent,"div","father=father");
					var dom_itm="",state="";
					for(var a =0, n=dom_pNodes.length; a<n; a++)
					{
						dom_itm=dom_pNodes[a];
						if(attr(dom_itm,"type")=="item")
						{
							dom_itm=dom_itm.getElementsByTagName("ins")[0];//getFirstChild(getFirstChild(getChildNodes(dom_itm,"b")[0]));
							state=attr(dom_itm,"checked")*1;
							clientGroupTree.changeCheckBox(dom_itm,state);
							
						}
						
					}
				}
				clientGroupTree.changeFartherChecked(getFirstChild(dom_ffparent));
			}
		},
		changeCheckBox:function(dom_checkbox,state){
			if(state){
				attr(dom_checkbox,"checked","0");
				changeClass(dom_checkbox,"checkBox","checkBoxChecked");
			}else{
				attr(dom_checkbox,"checked","1");
				changeClass(dom_checkbox,"checkBoxChecked","checkBox");
			}
		},
		getUserChecked:function (obj_info)
		{
			var dom_group=getFirstChild("tree_container");
			
			var arr_checked=clientGroupTree.getChecked(dom_group,obj_info);
			/*if(arr_checked.length==0)
			{
				
				return false;
			}*/
			
			//_("client").innerHTML="";
			//insertHTML(_("client"),"beforeend",str_checkbox);
			return arr_checked;
		},
		getChecked:function (dom_con,obj_info)
		{	
			var dom_itm="";
			var dom_groupitm=getFirstChild(dom_con);
			//解决只有一个Root组的时候 无法完成
			dom_groupitm.tagName.toUpperCase()!="DIV"?dom_groupitm=dom_con:'';
			dom_itm=getFirstChild(getFirstChild(getChildNodes(dom_groupitm,"b")[0]));
			if(dom_itm.checked)
			{
				obj_info.push({id:attr(dom_itm,'tid'),name:attr(dom_itm,'tname')});
				return ;
			}
			
			var arr_checked=[];
			var dom_itms=getChildNodes(dom_con,"div");
			
			for(var i in dom_itms)
			{
					dom_itm=dom_itms[i];
					bug("getChecked dom_itm","dom_itm type:" + attr(dom_itm,"type"));
					if(attr(dom_itm,"type")=="item")
					{
						dom_itm=getFirstChild(getFirstChild(getChildNodes(dom_itm,"b")[0]));
						if(dom_itm.checked)
						{
							obj_info.push({id:attr(dom_itm,'tid'),name:attr(dom_itm,'tname')});
							//str_checkbox+= "<input type='hidden' name='treeNode[]' value='"+attr(dom_itm,'tid')+"'  />";
						}
					}
				
			}
			for(var i in dom_itms)
			{
				
					dom_itm=dom_itms[i];
					bug("getChecked dom_itm","dom_itm type:" + attr(dom_itm,"type"));
					if(attr(dom_itm,"type")=="group")
					{
						clientGroupTree.getChecked(dom_itms[i],obj_info);
					}
				
			}
			//return arr_checked;
		},
		getRootNode:function(){
			var dom_con=getFirstChild("tree_container");
			var dom_itm="";
			var dom_groupitm=getFirstChild(dom_con);
			//解决只有一个Root组的时候 无法完成
			dom_groupitm.tagName.toUpperCase()!="DIV"?dom_groupitm=dom_con:'';
			dom_itm=getFirstChild(getFirstChild(getChildNodes(dom_groupitm,"b")[0]));
			return {id:attr(dom_itm,'tid'),name:attr(dom_itm,'tname')};

		},
		createTreeList:function(){
			var dom_con=getFirstChild("tree_container");
			var dom_n="",top="";
			var dom_div=dom_con.getElementsByTagName("div");
			for(var i in dom_div)
			{
				if(attr(dom_div[i],"type")=="item")
				{
					//bindMouseOver(dom_div[i],clientGroupTree.itemMouseEnter);
					top=getElementPos(dom_div[i]).y;
					clientGroupTree.treeList[top]=dom_div[i];
					//bug("createTreeList itemHeight",dom_div[i].clientHeight);
				}
			}
		},
		bindDrag:function(){
			var dom_con=getFirstChild("tree_container");
			var _dom_div=dom_con.getElementsByTagName("DIV");
			//alert(_dom_div.length);
			var dom_div=_dom_div;
			for(var i in dom_div)
			{
				if(attr(dom_div[i],"type")=="item"){
				addListener(dom_div[i].getElementsByTagName("ins")[0],"mousedown",clientGroupTree.changeCheck);
				}
				if(attr(dom_div[i],"type")=="item"&&attr(dom_div[i],"father")==null)
				{
					
					//绑定拖拽事件
					dg(dom_div[i]).enabled({
						key:"_area_item_",
						callback:{
							mv_start:function(cacheKey,dragItm,info){
									with(dragItm.style){
										
										width=clientWidth(dragItm)+"px";
										height=clientHeight(dragItm)+"px";
										position="absolute";
									}
									addClass(dragItm,"draging");
									clientGroupTree.currentDra=dragItm;
									clientGroupTree.createTreeList();
									
								},
							mv_stop:function(cacheKey,dragItm,info){
									with(dragItm.style){
										position="";
										top="";
										left="";
										width="";
										height="";
									}
									rmClass(dragItm,"draging");
									if(clientGroupTree.lastFocusTreeItem!="")
									{
										rmClass(clientGroupTree.lastFocusTreeItem,"dragFocus");
									}
									var dom_el = parentNode(clientGroupTree.focusTreeItem);
									dom_el.insertBefore(clientGroupTree.currentDra,clientGroupTree.focusTreeItem.nextSibling);
									
									clientGroupTree.currentDra="";
								},
							mv_move:function(cacheKey,dragItm,info){
								
								var int_ItmH = dragItm.clientHeight;
								for(var i in clientGroupTree.treeList){
									i=i*1;
									//bug("mv_move ","i: "+i+"  info.y: "+info.y+"  i+int_ItmH: "+(i+int_ItmH));
									if(i!="undefind"&&i<info.y&&info.y<=i+int_ItmH){
										if(clientGroupTree.lastFocusTreeItem!="")
										{
											rmClass(clientGroupTree.lastFocusTreeItem,"dragFocus");
										}
										addClass(clientGroupTree.treeList[i],"dragFocus");
										clientGroupTree.lastFocusTreeItem=clientGroupTree.focusTreeItem=clientGroupTree.treeList[i];
										
										break;
									}
								}
							}
							}
						});
				}
			}
		},
		//初始层拖动的范围
		setDragInfo:function (){
			var c=$("#tree_container"),
			w=c.width(),
			h=c.height(),
			p=c.offset(),
			x=p.left,
			y=p.left;
			dg.fn.setDragInfo({mi:{x:0,y:0},mx:{x:w,y:h},x:x,y:y,w:w,h:h},"_area_item_");
		}
	};
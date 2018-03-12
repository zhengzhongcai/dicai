/*
	终端树状图
	增加分组
	删除分组
	菜单管理
*/
var client_tree={
	tree_id:'#goods_type_grid',
	title_html_id:"#clientTitle",
	right_click_select:{},
	data:{},
	clientRows:[],
	groupRows:[],
	//初始化树，事件等
	init:function(data){
		var _this=this;
		_this.data=data;
		var aaa= $(_this.title_html_id).html();
		$(_this.title_html_id).hide();
		$(_this.tree_id).treegrid({
			iconCls:'icon-ok',
			//width: $(window).width() - 1000,
			//height: $(window).height() - 1035,
			//width:400,
			height:300,
			//striped:true,
			//autoScroll : true,
			//animate:true,
			//nowrap:false,
			//collapsible:true,
			//autoRowHeight:false,
			//fit:true,
			idField:'id',
			treeField:'client_name',
			//showFooter:true,
			toolbar:"clientGroup-grid-toolbar",
			columns:[[

				//{field:'ck',title:'名称',width:120,align:'center',checkbox:'true'},
				{field:'client_name',title:'名称',width:120,align:'center'},
			/*	{field:'name',title:'名称',align:'center'},
				{field:'choose',title:'<button  type="button"  id="checkAll" onclick=buttonCheck(this,"clientID") title="全">全</button >'
					,align:'center',
					width:40,
					formatter:function(value,row,index){
						if (row.is_group){return;}
						var pNode=row.obj.clientNodeCode.slice(0,-4);
						var info="{'clientNodeCode':'"+row.obj.clientNodeCode+"'}";
						var str= '<input state="unline" type="checkbox" pNode="'+pNode+
								'" ctype="1" info="'+info+
						'" name="clientID" value="'+row.obj.clientNum+
						'"/>';
						return str;
					}},
				{field:'reg_state',title:'注册状态',width:120,align:'center',
					formatter: function(value,row,index){
						if (row.is_group){return;}
						var str='未注册';
						if (row.obj.clientRegCode!=' '){
							var str= '已注册';
						}
						return str;
		   			}},
				{field:'profile',title:'播放列表',width:120,align:'center'},
				{field:'type',title:'终端类型',width:120,align:'center'},
				{field:'ip',title:'终端IP',width:120,align:'center'},
				{field:'machine_code',title:'机器码',width:120,align:'center'},
*/
				{field:'html',title:aaa,width:850},
			]],
			onSelect:function(rowIndex, rowData){  //用于解决点击某行不会高亮
				$(_this.tree_id).datagrid('unselectAll');
			},
			onDblClickRow:function(row){
				//alert(row);
			},
			onContextMenu:function(e,row){
				e.preventDefault();
				_this.right_click_select=row;
				if (row.is_client){
				$('#right_click_memu').menu('show', {
					left: e.pageX,
					top: e.pageY,
				});}
				if (row.is_group){
					$('#group_right_click_memu').menu('show', {
						left: e.pageX,
						top: e.pageY,
					});
				}
				console.log('right click');
				console.log(row);
			},
		});
		$(_this.tree_id).treegrid(
				'loadData',data
		);
		console.log('初始化右键');
		client_right_click_memu.init();
		group_right_click_memu.init();
		console.log('初始化按钮');
		_this.buttons.refresh().click(function(){
			client_tree_remote_control.updateData();
			//client_tree_remote_control.getClientStatus();
			//_this.removeOffLineRow();
			//var datas =	$('#goods_type_grid').treegrid('getData');
			//console.log(datas);
		});
		_this.buttons.check().click(function(){
			client_tree_remote_control.getClientStatus();
		});
		_this.buttons.showAllClient().click(function(){
			client_tree_remote_control.updateData();
			setTimeout(function(){client_tree_remote_control.getClientStatus();},3000);
			//client_tree_remote_control.getClientStatus();
		});
		_this.buttons.showOnlineClient().click(function(){
			client_tree_remote_control.getClientStatus();
			setTimeout(function(){_this.removeOffLineRow();;},3000);

		});

		console.log('初始化自动更新终端在线状态');
		client_tree_remote_control.getClientStatus();
		client_tree_remote_control.autoGetClientStatus(5000);
	},
	reloadData:function(data){
		var _this=this;
		_this.data=data;
		$(_this.tree_id).treegrid(
				'loadData',data
		);
	},
	loadData:function(data){
		var _this=this;
		_this.data=data;
		$(_this.tree_id).treegrid(
				'loadData',data
		);
		_this.clientRows=_this.getClientRows();
		_this.groupRows=_this.getGroupRows();
	},
	removeRow:function(row){
		console.log(row);
		var _this=this;
		$(_this.tree_id).treegrid('remove',row.id);
	},
	removeOffLineRow: function () {
		var _this=this;
		var rows=_this.getClientRows();
		for (var i=0 ;i<rows.length;i++){
			if (!rows[i].obj.isOnLine){
				_this.removeRow(rows[i]);
			}
		}
	},
	getRemoteDate:function(){
		client_tree_remote_control.updateData();
	},
    getRowById:function(id){
        var _this=this;
        return $(_this.tree_id).treegrid('find',id);
    },
	getRowByClientNum:function(ClientNum,clientRows){
		var _this=this;
		//var clientRows=_this.getClientRows;
		var clientRows=arguments[2]?arguments[2]:_this.getClientRows();
		//if (!arguments[2]){  var clientRows=_this.getClientRows()};
		for(var i =0;i<clientRows.length; i++){
			if(clientRows[i].obj.clientNum==ClientNum){
				return clientRows[i];
			}
		}
		return false;
	},
	getRowsByOnlineArr:function(onlineArr){
		var _this=this;
		var rows=[];
		var row;
		var state=true;
		var clientRows=arguments[2]?arguments[2]:_this.getClientRows();
		for(var i =0, n=onlineArr.length; i<n; i++){
			row =_this.getRowByClientNum(onlineArr[i]["clientID"]);
			row ? rows.push(row) : state=false;
		}
		return state ?   rows :  false;
	},
	//select_rows:[],
	getSelectRows:function(){
		var _this=this;
		var cIds=_name('clientID');
		var SelectRows=[];
		for(var a=0,n=cIds.length; a<n; a++)
		{
			//alert(cIds[a].attributes.pNode.value);
			if (cIds[a].checked==true){
				SelectRows.push($(_this.tree_id).treegrid('find',cIds[a].attributes.rowid.value));
				//alert(cIds[a].attributes.pNode.value);
			}
		}
		return SelectRows;
	},
	getGroupRows:function(){
		var datas =	$('#goods_type_grid').treegrid('getRoot');
		var groupRows=[];
		//console.log($('#goods_type_grid').treegrid('getRoot'));
		var dirRoot=function(rootObj,perObj,groupRows){
			for (var x in rootObj) {
				var tempObj=rootObj[x];
					if (tempObj.is_group){
					groupRows.push(rootObj[x]);
					if (rootObj[x].children && rootObj[x].children.length>0){dirRoot(rootObj[x].children,rootObj[x],groupRows)}
					}
			}
			//return groupRows;
		};
		dirRoot([datas],'',groupRows);
		return groupRows;
	},
	getClientRows:function(){
		var datas =	$('#goods_type_grid').treegrid('getRoot');
		var clientRows=[];
		//console.log($('#goods_type_grid').treegrid('getRoot'));
		var dirRoot=function(rootObj,perObj,clientRows){
			for (var x in rootObj) {
				var tempObj=rootObj[x];
				if (tempObj.is_client){
					clientRows.push(rootObj[x]);
				}
				if (rootObj[x].children && rootObj[x].children.length>0){dirRoot(rootObj[x].children,rootObj[x],clientRows)}
			}
			//return groupRows;
		};
		dirRoot([datas],'',clientRows);
		return clientRows;
	},
	getRowsData:function(){
		var datas =	$('#goods_type_grid').treegrid('getRoot');
		var rowsData=[];
		var dirRoot=function(rootObj,perObj,rowsData){
			for (var x in rootObj) {
				var tempObj=rootObj[x];
					rowsData.push(rootObj[x]);
				if (rootObj[x].children && rootObj[x].children.length>0){dirRoot(rootObj[x].children,rootObj[x],rowsData)}
			}
		};
		dirRoot([datas],'',rowsData);
		return rowsData;
	},
	clientMove:function(srcRow,newRow,desRow){
        //由于移动后TreeNodeCode，组名称需要跟随变化,
		var _this=this;
        var desRowId=desRow.id;
		_this.removeRow(srcRow);
        newRow._parentId=desRowId;
		var tempObj=$(_this.tree_id).treegrid('getChildren',desRowId);
		if (tempObj.length>0){
		$(_this.tree_id).treegrid('insert',{
			before: tempObj[0].id,
			data: newRow
		});
		} else {
			$(_this.tree_id).treegrid('append',{
				parent: desRowId,
				data: [newRow]
			});
		}
	},
	addRow:function(newRow,desRow){
		var _this=this;
		var desRowId=desRow.id;
		newRow.html = newRow.is_client? createrClientList([newRow.obj]).str_client: createrGroupList([newRow.obj]);
		$(_this.tree_id).treegrid('insert',{
			after: desRowId,
			data: newRow
		});
	},
	addSubRow:function(newRow,desRow){
		var _this=this;
		var desRowId=desRow.id;
		var tempObj=$(_this.tree_id).treegrid('getChildren',desRowId);
		newRow.html = newRow.is_client? createrClientList([newRow.obj]).str_client: createrGroupList([newRow.obj]);
		if (tempObj.length>0){
			$(_this.tree_id).treegrid('insert',{
				after: tempObj[tempObj.length-1].id,
				data: newRow
			});
		} else {
			$(_this.tree_id).treegrid('append',{
				parent: desRowId,
				data: [newRow]
			});
		}
	},
	updateRow:function(id,row){
		var _this=this;
		row.html = row.is_client? createrClientList([row.obj]).str_client: createrGroupList([tempObj]);
		 $(_this.tree_id).treegrid('update',{
			id: id,
			row: row
		});
	},
	updateRowOnLine:function(row){
		var _this=this;
		row.obj.isOnLine=true;
		//row.html=createrClientList([row.obj]).str_client;
		_this.updateRow(row.id,row);
	},
	updateRowOffLine:function(row){
		var _this=this;
		row.obj.isOnLine=false;
		//row.html=createrClientList([row.obj]).str_client;
		_this.updateRow(row.id,row);
	},
	updateAllRowOffLine:function(clientRows){
		var _this=this;
		//var clientRows=_this.getClientRows;
		var clientRows=arguments[1]?arguments[1]:_this.getClientRows();
		//if (!arguments[2]){  var clientRows=_this.getClientRows()};
		for(var i =0;i<clientRows.length; i++){
			_this.updateRowOffLine(clientRows[i]);
			}

	},
	setClientOnline:function(id){},
	checkNewClient:function (onLineDatas){
		var _this=this;
		var clientRows=_this.getClientRows;
		for(var i =0;i<clientRows.length; i++){
			if(clientRows[i]["clientNum"]==ClientNum){
				return clientRows[i];
			}
		}
		return false;
	},
	buttons:{
		refresh: function () {
			return $('#btn_refresh') ;
		},
		check: function () {
			return $('#btn_check') ;
		},
		showAllClient: function () {
			return $('#btn_show_all_client') ;
		},
		showOnlineClient: function () {
			return $('#btn_show_online_client') ;
		},
	}
}
/*
* 用于将原有的userClientSouce对象转换成treegird需要的对象
* */
//遍历userClientSouce的终端组对象
function dirNode(nodeObj,perObj,data){
	for (var x in nodeObj) {
		var tempObj=nodeObj[x];
		var tempHtml=createrGroupList([tempObj]);
		//userGroupData.push(nodeObj[x]);
		if (tempObj.TreeNodeCode=='0001'){
			data.rows.push({
				id: tempObj.TreeNodeCode,
				client_name: tempObj.TreeName,
				is_group:true,
				html: tempHtml,
				obj:tempObj
			});
		} else {
			data.rows.push({
				id: tempObj.TreeNodeCode,
				client_name: tempObj.TreeName,
				//html: tempObj.TreeNum,
				is_group:true,
				html: tempHtml,
				obj:tempObj,
				_parentId: perObj.TreeNodeCode
			});
		}
		if (nodeObj[x].child.length>0){dirNode(nodeObj[x].child,nodeObj[x],data)}
	}
}
//用于遍历终端对象
function clientInfoToData(clientInfo,data){
	//var clientInfo=userClientSouce["clientInfo"];
	for (var x in clientInfo){
		var tempObj=clientInfo[x];
		//tempObj.isOnLine=true;
		var tempHtml=createrClientList([tempObj]);
		data.rows.push({
			id: tempObj.clientNodeCode,
			client_name: tempObj.clientName,
			is_client:true,
			html: tempHtml.str_client,
			obj:tempObj,
			_parentId: tempObj.clientNodeCode.slice(0,-4)
		});
	}
}
function UCStoTreeGridData(UCS){
	var data={total:10,rows:[]};
	clientInfoToData(userClientSouce["clientInfo"],data);
	dirNode(userClientSouce['userGroup'],'',data);
	return data;
}

/*
* 菜单创建控制
* */

var client_right_click_memu={
	menu_id:'#right_click_memu',
	init:function(){
		var _this=this;
		$(_this.menu_id).menu('appendItem', {text: '移动终端',name:'right_click_memu_move_client' });
		$(_this.menu_id).menu('appendItem', {text: '移动选中终端',name:'right_click_memu_move_select_client' });
		$(_this.menu_id).menu('appendItem', {text: '删除终端',name:'remove_client' });
		$(_this.menu_id).menu('appendItem', {text: '删除选中终端',name:'remove_select_client' });
		$(_this.menu_id).menu({
			onClick:function(item){
				switch (item.name){
					case 'right_click_memu_move_client':
						_this.add_group(item,client_tree.right_click_select);
						break;
					case "remove_client":
						_this.remove_client(item,client_tree.right_click_select);
						break;
					case "remove_select_client":
						_this.remove_select_client(item,client_tree.getSelectRows());
						break;
				}
				console.log('item');
				console.log(item);
				switch (item.id){
					case 'memu_group_item':
							//console.log('bclick');
						_this.move_client(item,client_tree.right_click_select);
						//client_tree.clientMove();
						//_this.add_group(item,client_tree.right_click_select);
						break;
					case 'memu_group_item_select':
						_this.move_select_client(item,client_tree.getSelectRows());
						//client_tree.clientMove();
						break;

				}
			},
			onShow:function(){
				var group_rows=client_tree.getGroupRows();
				var item1 = $('#right_click_memu').menu('findItem', '移动终端');
				var item2 = $('#right_click_memu').menu('findItem', '移动选中终端');
				var item3 = $('#memu_group_item')[0];
				while($('#memu_group_item')[0]){
					var item3 = $('#memu_group_item')[0];
					item3.remove();
					//$('#right_click_memu').menu("removeItem",item3);
				}
				while($('#memu_group_item_select')[0]){
					var item3 = $('#memu_group_item_select')[0];
					item3.remove();
				}
				for(var a=0,n=group_rows.length; a<n; a++)
				{
					$('#right_click_memu').menu('appendItem', {
						parent: item1.target,  // the parent item element
						id:'memu_group_item',
						name:group_rows[a].id,
						text: group_rows[a].client_name,
						onclick: function(e,item){
							console.log('aitem');
							console.log(this);
							console.log(item);
						}
					});
					$('#right_click_memu').menu('appendItem', {
						parent: item2.target,  // the parent item element
						id:'memu_group_item_select',
						name:group_rows[a].id,
						text: group_rows[a].client_name,
						onclick: function(){
							console.log(this)
						}
					});
				}
				console.log('onshow');
			}
		});
	},
	update_group:function(){

	},
	add_group:function(item,row){

	},
	remove_client: function (item,row) {
		if (row.is_client){
			client_tree_remote_control.deleteClient(row);
			//client_tree.removeRow(row);
		}
	},
	remove_select_client:function(item,rows){
		for(var a=0,n=rows.length; a<n; a++)
		{
			this.remove_client(item,rows[a]);
		}
	},
	move_client:function(item,row){
		if (row.is_client){
			//client_tree.clientMove:function(srcRow,newRow,desRowId)
			//菜单用name保存ID
            var desRow=client_tree.getRowById(item.name);
            client_tree_remote_control.moveClient(row,desRow);
			//client_tree.clientMove(row,row,item.name);
		}
	},
	move_select_client:function(item,rows){
		for(var a=0,n=rows.length; a<n; a++)
		{
			this.move_client(item,rows[a]);
		}
	}
}

var group_right_click_memu={
	menu_id:'#group_right_click_memu',
	init:function(){
		var _this=this;
		$(_this.menu_id).menu('appendItem', {text: '添加分组',name:'new_group' });
		$(_this.menu_id).menu('appendItem', {text: '添加子分组',name:'new_sub_group' });
		$(_this.menu_id).menu('appendItem', {text: '删除分组',name:'remove_group' });
		$(_this.menu_id).menu({
			onClick:function(item){
				switch (item.name){
					case 'new_group':
						_this.new_group(item,client_tree.right_click_select);
						break;
					case 'new_sub_group':
						_this.new_sub_group(item,client_tree.right_click_select);
						break;
					case 'remove_group':
						_this.remove_group(item,client_tree.right_click_select);
						break;
				}
			},
			onShow:function(){
			}
		});
	},
	new_sub_group:function(item,row){
		var d = art.dialog({
			id:'new_group_dialog',
			title: '请输入分组名字',
			quickClose: true,
			content: '<input id="new_group_dialog_input" autofocus />',
			ok: function (){
				//alert($('#new_group_dialog_input').val())
				var name=$('#new_group_dialog_input').val();
				client_tree_remote_control.addSubGroup(item,row,name);
			},
			//cancel: function(){}
		});
	},
	new_group:function(item,row){
		var d = art.dialog({
			id:'new_group_dialog',
			title: '请输入分组名字',
			quickClose: true,
			content: '<input id="new_group_dialog_input" autofocus />',
			ok: function (){
				//alert($('#new_group_dialog_input').val())
				var name=$('#new_group_dialog_input').val();
				client_tree_remote_control.addGroup(item,row,name);
			},
			//cancel: function(){}
		});
	},
	remove_group:function(item,row){
		if (row.is_group){
			client_tree_remote_control.deleteGroup(row);
		}
	}
}

var client_tree_remote_control={
	//TreeNodeSerialID唯一不变，treeNodeCode唯一
	addGroup:function(item,row,name){
		//返回新的TreeNodeCode
		var treeNodeCode=row.id;
		//var desRow=row;
		$.messager.progress({title:"分组创建中请稍等"});
		$.ajax({
			type:"post",
			data:{treeNodeCode:treeNodeCode,name:name},
			url:"index.php?control=c_clientGroup&action=addGroup",
			dataType:"json",
			success:function(result){
				$.messager.progress("close");
				if(result.state)
				{
					var newRow= jQuery.extend(true,{}, row);
					newRow.children=[];
					newRow.child=[];
					newRow.id = newRow.obj.TreeNodeCode=result.data.TreeNodeCode;
					newRow.client_name = newRow.obj.TreeName =result.data.Name;
					newRow.obj.TreeNum =result.data.TreeNodeSerialID;
					//newRow.html=createrGroupList([newRow.obj]);
					newRow.is_group=true;
					client_tree.addRow(newRow,row);
					$.messager.show({
						msg:'创建成功。',
						timeout:5000,
						showType:'fade'
					});
				}
				else
				{
					$.messager.show({
						msg:'创建失败。'+result.info,
						timeout:5000,
						showType:'fade'
					});
				}
			}
		});
	},
	addSubGroup:function(item,row,name){
		//返回新的TreeNodeCode
		var treeNodeCode=row.id;
		//var desRow=row;
		$.messager.progress({title:"分组创建中请稍等"});
		$.ajax({
			type:"post",
			data:{treeNodeCode:treeNodeCode,name:name},
			url:"index.php?control=c_clientGroup&action=addSubGroup",
			dataType:"json",
			success:function(result){
				$.messager.progress("close");
				if(result.state)
				{
					var newRow= jQuery.extend(true,{}, row);
					newRow.children=[];
					newRow.child=[];
					newRow.id = newRow.obj.TreeNodeCode=result.data.TreeNodeCode;
					newRow.client_name = newRow.obj.TreeName =result.data.Name;
					newRow.obj.TreeNum =result.data.TreeNodeSerialID;
					//newRow.html=createrGroupList([newRow.obj]);
					newRow.is_group=true;
					client_tree.addSubRow(newRow,row);
					$.messager.show({
						msg:'创建成功。',
						timeout:5000,
						showType:'fade'
					});
				}
				else
				{
					$.messager.show({
						msg:'创建失败。'+result.info,
						timeout:5000,
						showType:'fade'
					});
				}
			}
		});
	},
	deleteGroup:function(row){
		//发送groupId直接删除组，非空组不能删除
		var treeNodeCode=row.obj.TreeNodeCode;
		$.messager.progress({title:"删除分组中请稍等"});
		$.ajax({
			type:"post",
			data:{treeNodeCode:treeNodeCode},
			url:"index.php?control=c_clientGroup&action=deleteGroup",
			dataType:"json",
			success:function(result){
				$.messager.progress("close");
				if(result.state)
				{
					client_tree.removeRow(row);
					$.messager.show({
						msg:'删除分组成功。',
						timeout:5000,
						showType:'fade'
					});
				}
				else
				{
					$.messager.show({
						msg:'删除分组失败。'+result.info,
						timeout:5000,
						showType:'fade'
					});
				}
			}
		});
	},
	deleteClient:function(row){
		//发送clientId直接删除终端
		var treeNodeSerialID=row.obj.clientNum;
		$.messager.progress({title:"删除终端中请稍等"});
		$.ajax({
			type:"post",
			data:{treeNodeSerialID:treeNodeSerialID},
			url:"index.php?control=c_clientGroup&action=deleteClient",
			dataType:"json",
			success:function(result){
				$.messager.progress("close");
				if(result.state)
				{
					client_tree.removeRow(row);
					$.messager.show({
						msg:'删除终端成功。',
						timeout:5000,
						showType:'fade'
					});
				}
				else
				{
					$.messager.show({
						msg:'删除终端失败。',
						timeout:5000,
						showType:'fade'
					});
				}
			}
		});
	},
	moveClient:function(row,desRow){
		/*返回移动后的treeNodeCode
		使用原有的moveClient接口
		*/
		clientCode=row.id;
		groupCode=desRow.id;
		$.messager.progress({title:"移动中请稍等"});
		$.ajax({
			type:"post",
			data:{groupCode:groupCode,clientCode:clientCode},
			url:"index.php?control=c_clientGroup&action=moveClient",
			dataType:"json",
			success:function(result){
				$.messager.progress("close");
				if(result.state)
				{
                    var newRow= jQuery.extend(true,{}, row);
                    newRow.id=result.data.TreeNodeCode;
                    newRow.obj.clientNodeCode=result.data.TreeNodeCode;
                    newRow.obj.clientGroupName=desRow.client_name;
                    newRow.html=createrClientList([newRow.obj]).str_client;
                    client_tree.clientMove(row,newRow,desRow);
					$.messager.show({
						msg:'移动成功。',
						timeout:5000,
						showType:'fade'
					});
				}
				else
				{
					$.messager.show({
						msg:'移动失败。',
						timeout:5000,
						showType:'fade'
					});
				}
			}
		});
	},
	updateClient:function(){

	},
	updateData:function (){
		$.ajax({
			type:"post",
			//data:{treeNodeSerialID:treeNodeSerialID},
			url:"index.php?control=client&action=getClientInfoJson",
			dataType:"json",
			success:function(result){
				if(result.state)
				{
					//client_tree.removeRow(row);
					clientManage.clients=result.clientInfo;
					clientManage.clientGroup=result.clientGroup;
					userClientSouce= {"clientInfo":result.clientInfo,"userGroup":result.clientGroup};
					data=UCStoTreeGridData(userClientSouce);
					client_tree.loadData(data);
				}
				else
				{

				}
			}
		});
	},
	getClientStatus:function(){
		var _this=this;
		$.ajax({
			type:"post",
			url:"index.php?control=socket&action=getClientState",
			success:function(result){
				bug("服务器返回的信息",result,"red");
				if(result.indexOf("Register fail")>=0){
					alert("服务器错误，用户可能已经登录");
					bug("用户退出登录",top.location+"<br>"+self.location);
					if (top.location !== self.location)
					{
						top.location="index.php?control=c_login&action=loginOut";
					}
					return false;
				}
				if(result.indexOf("@#@#@#")>0){
					var clientStatusArr=result.split("@#@#@#");
					var clientStatus=clientStatusArr[1];
					var array_onlineClient=[];
					var clientArr=window.eval("("+clientStatus+")");
					arrLen=clientArr.length;
					//无终端上线 arrLen 为 0
					if(!arrLen)
					{
						reqtimeout("当前没有终端上线！");
						client_tree.updateAllRowOffLine();
						return ;
					}
					//有新终端上线,终端列表中不存在的时候, 刷新界面
					var rows=client_tree.getRowsByOnlineArr(clientArr);
					if (!rows){
						_this.updateData();
						setTimeout(function(){_this.getClientStatus();},5000);
						return;
					}
					client_tree.updateAllRowOffLine();
					for(i=0;i<arrLen;i++)
					{
						client_tree.updateRowOnLine(rows[i]);
					}
					clientStatistics(rows);
				}

			}
		});
	},
	autoGetClientStatus:function(time){
		var _this=this;
		var time=arguments[1]?arguments[1]:5000;
		setInterval(function(){_this.getClientStatus()},time);
	},
	updateClientName:function(clientID,Name,obj){
		$.ajax({
			type:"post",
			url:"index.php?control=client&action=updateClientName" ,
			data:{clientID:clientID,Name:Name},
			success:function(result){
				if (result=='1'){
					alert("修改成功");
					client_tree_remote_control.updateData();
				}else {
					alert("修改失败");
				}
			}
		});

	}

}
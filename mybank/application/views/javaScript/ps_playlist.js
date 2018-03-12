var program = {
    init: function() {
    	var grid_height =$(document).height();
        $('#programGrid').datagrid({
            url: "index.php?control=c_playListManage&action=playList",
            columns: [[{
                field: 'ck',
                checkbox: true
            },
            {
                field: 'playListName',
                title: '播放计划名称',
                sortable:true,
                width: 200
            },
            {
                field: 'playListType',
                title: '类型',
                width: 150
            },
            {
                field: 'startDate',
                title: '开始时间',
                width: 150
            },
            {
                field: 'endDate',
                title: '结束时间',
                width: 150
            },
            {
                field: 'operator',
                title: '基本操作',
                width: 150,
                formatter: function(value, row, index) {
					var str='<a href="javascript:program.getPlayFileInfo('+row.playListID+',\''+row.playListName+'\')">查看</a>';
					str+="|";
					str+= '<a id='+row.playListID+' name='+row.playListName+' onclick="program.editplaylist(this)" href="javascript:void(0)">修改</a>';
                	return str;
                }
            }]],
            pagination: true,
            // pagePosition:"both",
            pageSize:10,
            remoteSort:false,
            fitColumns: true,
            rownumbers:true,
            height:grid_height
        });
        //绑定按钮事件
        // $('#add').on("click",program.createprofile());
        // $('#cut').on("click",program.deleteMulProfile());
    },
    
    //
    getPlayFileInfo:function(playfileID,playListName){
    	$.ajax({
			type:"post",
			url:"index.php?control=playlist&action=getPlayInfo",
			data:"playListID="+playfileID,
			timeout:300000,
			success:function(data){
				console.info(data);
				program.showPlaylistInfo(playListName,data);
			},
			error:function(jqXHR, textStatus, errorThrown){
				if(textStatus=="timeout"){
					art.dialog({
						skin: 'chrome',
						id: 'timeOutUi',
						content: '你指定的信息,加载失败!<br>请求超时......'
					});
				}else{
					art.dialog({
						skin: 'chrome',
						id: 'serverError',
						content: '无法加载您需要的信息!'
					});
				}
			}
		});
	},
	//--------------修改计划-------------//
	editplaylist:function(editobj){
		var id=editobj.id;
			var name=editobj.name;
			window.top._BS_.playList.edit=true;
			window.top._BS_.playList.id=id;
			art.dialog.open('index.php?control=c_playListManage&action=editPlayListView',
					{title: '修改计划', width: 880, height: 530,lock:false,resize:false});
	},
	  //------------------------------------------
 //-
 //- 显示某个播放列表中的详情
 //- params str_name(播放列表的名称),str_html(播放列表的详情)
 //------------------------------------------
 showPlaylistInfo:function (str_name,str_html)
 {
	art.dialog({
					title:"播放列表 "+str_name+" 详情",
					width:800,
					skin: 'chrome',
					id: 'art_PlaylistInfo',
					lock:false,
					content: "<div id='art_PlaylistInfo_content' style='display:block;'>"+str_html+"</div>"
				});
	if($("art_PlaylistInfo_content").height()>=$(document).height())
	{
		with($("art_PlaylistInfo_content")[0].style)
		{
			height=($(document).height()-100)+"px";
			overflowY="scroll";
		}
	}
	
	window.setTimeout(function(){
		art.dialog.list["art_PlaylistInfo"].position();},50);
 },
	 //------------创建计划-----------------//
	createplaylist:function (){
		//alert("1");
		//var url=obj.id;?control=play&action=play_list&fcode=monitor
		art.dialog.open('index.php?control=playlist&action=addPlayList',
			{title: '创建计划',
			 width: 880, 
			 height: 530,
			 //lock:true,
			 resize:false,
			 close:function(){$('#programGrid').datagrid("reload");}});
	},
	 //------------------------------------------
	 //-
	 //- 删除 播放列表 删除多条
	 //- params arr_id array tr 的部分ID
	 //------------------------------------------
	deleteMulpPlaylist:function (){
		var playlistID=program.getPlaylistID();
		if(playlistID.length>0){
			if(confirm("你确定要删除该播放计划?")){
				$.ajax({
					url:"index.php?control=playlist&action=deleteMulpPlaylist",
					data:"playlistIDs=" + playlistID.join(","),
					type:"post",
					timeout:30000,
					success:function(data){
						$('#programGrid').datagrid('reload');
					},
					error:function(jqXHR, textStatus, errorThrown){
						if(textStatus=="timeout"){
							art.dialog({
								skin: 'chrome',
								id: 'timeOutUi',
								content: '你指定的信息,加载失败!<br>请求超时......'
							});
						}else{
							art.dialog({
								skin: 'chrome',
								id: 'serverError',
								content: '无法加载您需要的信息!'
							});
						}
					}
				});
			}
		}else{
			alert("您没有选择任何播放计划!");
		}
	},
	 //------------------------------------------
	 //-
	 //- 获取选中的播放列表的ID
	 //- params 无
	 //------------------------------------------
	 getPlaylistID:function(){
		var playlistID=[];
		var rows=$('#programGrid').datagrid('getChecked');
		for(var s in rows){
			playlistID.push(rows[s].playListID);
		}
		return playlistID;
	 }
};

$(document).ready(function() {
    program.init();
});
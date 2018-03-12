
var program = {
    init: function() {
    	var grid_height =$(document).height();
        $('#gridContainer').datagrid({
            url: 'index.php?control=fileManageGrid&action=index',
            columns: [[{
                field: 'ck',
                checkbox: true
            },
            {
                field: 'profileID',
                title: '编号',
                sortable:true,
                width: 50,
                hidden:true
            },
            {
                field: 'FileName',
                title: '文件名称',
                sortable:true,
                width: 200
            },
            {
                field: 'FileTypeName',
                title: '文件类型',
                sortable:true,
                width: 80
            },
            {
                field: 'FileSize',
                title: '文件大小(字节)',
                sortable:true,
                formatter: function(value, row, index) {
                	var units = ['B', 'KB', 'MB', 'GB', 'TB'];
                	_value = parseInt(value);
                	for(var i=0;i<4&&_value>=1024;i++){
                		_value=_value/1024;
                	}
                	return _value.toFixed(2)+" "+units[i];
                }
            },
            {
                field: 'AuditState',
                title: '审核状态',
                sortable:true,
                formatter: function(value){
                	_value = parseInt(value);
                	return _value?"已审核":"未审核";
                }
            },
            {
            	field:'UploadDate',
            	title:'上传时间',
                sortable:true,
                width: 150
            },
            {
                field: 'UploadUser',
                title: '上传者',
                sortable:true,
                formatter: function(value) {
                 var UserName;
                            $.ajax({
                                url: "index.php?control=fileManage&action=getUploadUser",
                                async: false,//改为同步方式
                                type: "POST",
                                data: { value: value },
                                success: function (data) {
                                    UserName = data;
                         }
                         });
                         return UserName;
                   
                }
            },
            {
            	field:'IsCommon',
            	title:'文件权限',
                sortable:true,
                formatter:function(value){
                	_value = parseInt(value);

                   // return "<select name=''><option value='0'>私有</option><option value='1'>完全公开</option></select>";
                	switch(_value){
                		case 0: return '私有';
                		case 1: return '向组成员开放';
                		case 2: return '完全公开';
                	}
                		
                }
            },


            {
                field: 'FileViewURL',
                title: '预览',
                formatter: function(value, row, index) {
					if(row.FileType!="7"){
						var str = '<a fileType="'+row.FileType+'" onclick="view(\''+row.FileType+'\',\''+row.FileViewURL+'\',event)" href="javascript:void(0)">预览</a>';
					} 
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
        // $('#add').on("click",program.createprofile);
        // $('#cut').on("click",program.deleteMulProfile);
        
        $('#tre_all').click(program.loadAllList);
    }
    ,loadAllList:function(){
    	//$('#gridContainer').datagrid("changeUrl","index.php/fileManageGrid/getOneType");
    	$('#gridContainer').datagrid({
    				url:"index.php?control=fileManageGrid&action=getOneType",
					queryParams: {
						type:"all"
					}
				});
    }
    //-----------------------------------
    //
    //	profile view
    //  path profile name
    //  2011年12月28日19:06:20
    //-----------------------------------
    ,
    
    
    selectFileList:function ()
   {
		//重置预览窗口
		review();
		var filename = document.getElementById('txt_FileName').value;
		var sfilesize = document.getElementById('txt_sFileSize').value;
		var efilesize = document.getElementById('txt_eFileSize').value;
		var filenotes = document.getElementById('txt_FileNotes').value;
		$('#gridContainer').datagrid("changeUrl","index.php?control=fileManageGrid&action=selectFilelist");
	    $('#gridContainer').datagrid({
			queryParams: {
				fileName:filename,
				sfilesize:sfilesize,
				efilesize:efilesize,
				filenotes:filenotes
			}
		});
		
	}
	
	
        //------------------------------------------
        //-
        //- 删除 节目 删除多条
        //- params arr_id array tr 的部分ID
        //------------------------------------------
        ,
        deleteFiles:function () {
            var fileID = program.getFileID();

            if (fileID.length > 0) {
				art.dialog.confirm('你确定要删除选中的文件吗？', function () {
					tip.tip({message:"文件删除中,请稍候.....",stateClose:false});
			
					var id = fileID.join(",");
					$.get("index.php?control=fileManage&action=deleteFile&id="+id, function(data)
					{
						bug("文件删除服务器返回的消息",data,"green");
						var st=data;
						try{st=eval("("+st+")");}
						catch(e)
						{
							tip.change("删除失败<br>"+obj.responseText);
							tip.tipInfo.defaultState=true;
							return ;
						}
						if(st["state"]=="true")
						{
							var str_unused="";
							if(st["data"].hasOwnProperty("unused"))
							{
								var array_unused=st["data"]["unused"];
								for(var i=0,n=array_unused.length; i<n; i++)
								{
									str_unused+=array_unused[i]["fileName"]+" "+(array_unused[i]["state"]=="true"?"成功.\n":"失败("+array_unused[i]["info"]+").\n");
								}
							}
							var str_used="";
							if(st["data"].hasOwnProperty("used"))
							{
								var array_used=st["data"]["used"];
								for(var i=0,n=array_used.length; i<n; i++)
								{
									str_used+=array_used[i]["fileName"]+" 被使用.<br />";
								}
							}
		
							tip.change(st["message"]+"\n"+str_unused + str_used);
							tip.tipInfo.defaultState=true;
						}
						$('#gridContainer').datagrid("reload");
						//kycool add 在删除成功后提示自动消失
						setTimeout(function(){tip.tipClose();},2000);
					});
	            }, function () {
	                art.dialog.tips('您取消了删除操作!');
	            }); 
            } else {
                alert("您没有选择任何文件!");
            }
        }
       	 //------------------------------------------
		 //-
		 //- 获取选中的节目的ID
		 //- params 无
		 //------------------------------------------
		,
		getFileID:function (){

			var fileID=[];
			var row=$("#gridContainer").datagrid('getChecked');
			for(var s in row){
				fileID.push(row[s].PlayFileID);
			}
			return fileID;
		}
		,
		verify:function(obj){
			
             var fileID = program.getFileID();
              
            if (fileID.length > 0) {
				var id = fileID.join(",");
				art.dialog.confirm("您确定进行文件审核吗？",function(){
					tip.tip({message:"文件审核中，请稍后.....",stateClose:false,id:"kverify"});
					$.get("index.php?control=fileManage&action=verifyFile&id="+id,function(data){
                        if(data){
                             $('#gridContainer').datagrid("reload");
                        tip.change("审核文件成功","kverify");
                        
                        }else{
                            alert("您没有审核权限");
                        }
						setTimeout(function(){tip.tipClose("kverify");},1000);
					});	
				},function(){
							art.dialog.tips('您取消了审核操作');
				});			
			}else{
				 alert("您没有选择任何文件!");
			}
	}
    ,
        verifyBack:function(obj){
            
             var fileID = program.getFileID();
              
            if (fileID.length > 0) {
                var id = fileID.join(",");
                art.dialog.confirm("您确定取消文件审核吗？",function(){
                    tip.tip({message:"文件取消审核中，请稍后.....",stateClose:false,id:"kverify"});
                    $.get("index.php?control=fileManage&action=verifyBackFile&id="+id,function(data){
                        if(data){
                             $('#gridContainer').datagrid("reload");
                        tip.change("取消审核文件成功","kverify");
                        
                        }else{
                            alert("您没有审核权限");
                        }
                        setTimeout(function(){tip.tipClose("kverify");},1000);
                    }); 
                },function(){
                            art.dialog.tips('您取消了操作');
                });         
            }else{
                 alert("您没有选择任何文件!");
            }
    }
    ,common:function(){
            
             var fileID = program.getFileID();
                if (fileID.length > 0) {
                var id = fileID.join(",");
                art.dialog.confirm("您确定设置文件公开吗？",function(){
                  
                    $.get("index.php?control=fileManage&action=commonFile&id="+id,function(data){
                        //alert(data);
                       if(data==2){
                        alert("您选择的文件含有不是您上传的！请重新选择");
                       }
                       if(data==3){
                        alert("您即将设置的文件中含没通过审核的，通过审核才能公开！");
                       }
                        $('#gridContainer').datagrid("reload");
                      
                        
                    }); 
                },function(){
                            art.dialog.tips('您取消了审核操作');
                });         
            }else{
                 alert("您没有选择任何文件!");
            }
    }
   
    ,private:function(){
            
             var fileID = program.getFileID();
              
            if (fileID.length > 0) {
                var id = fileID.join(",");
                art.dialog.confirm("您确定设置文件为私有吗？",function(){
                   // tip.tip({message:"文件审核中，请稍后.....",stateClose:false,id:"kverify"});
                    $.get("index.php?control=fileManage&action=privateFile&id="+id,function(data){
                        if(data==2){
                        alert("您选择的文件含有不是您上传的！请重新选择");
                       }
                       
                        $('#gridContainer').datagrid("reload");
                      //  tip.change("审核文件成功","kverify");
                        //setTimeout(function(){tip.tipClose("kverify");},1000);
                    }); 
                },function(){
                            art.dialog.tips('您取消设置操作');
                });         
            }else{
                 alert("您没有选择任何文件!");
            }
    }
    ,group:function(){
            
             var fileID = program.getFileID();
              
            if (fileID.length > 0) {
                var id = fileID.join(",");
                art.dialog.confirm("您确定设置文件向组员公开吗？",function(){
                   // tip.tip({message:"文件审核中，请稍后.....",stateClose:false,id:"kverify"});
                    $.get("index.php?control=fileManage&action=groupFile&id"+id,function(data){
                        if(data==2){
                        alert("您选择的文件含有不是您上传的！请重新选择");
                       }
                       if(data==3){
                        alert("您即将设置的文件还没通过审核，通过审核才能公开！请联系管理员");
                       }
                        $('#gridContainer').datagrid("reload");
                      //  tip.change("审核文件成功","kverify");
                        //setTimeout(function(){tip.tipClose("kverify");},1000);
                    }); 
                },function(){
                            art.dialog.tips('您取消设置操作');
                });         
            }else{
                 alert("您没有选择任何文件!");
            }
    }
};
$(document).ready(function() {
    program.init();

});

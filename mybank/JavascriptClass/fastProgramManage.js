
var program = {
    init: function() {
    	var grid_height =$(document).height();
        $('#programGrid').datagrid({
            url: "index.php?control=c_profileInfo&action=profileList",
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
                field: 'profileName',
                title: '节目名称',
                sortable:true,
                width: 200
            },
            {
                field: 'profileTime',
                title: '时长（秒）',
                width: 150
            },
            {
                field: 'profileType',
                title: '类型',
                width: 150
            },
            {
                field: 'profileJumpUrl',
                title: '跳转地址',
                width: 150
            },
            {
                field: 'operator',
                title: '基本操作',
                formatter: function(value, row, index) {
                    var str = '<a href="javascript:program.viewProfile(\'' + row.profileViewName + '\',\'' + row.profileName + '\');">预览节目</a>';
                    str += '|';
                    str += '<a href="javascript:program.editprofile({id:' + row.profileID + ',name:\'' + row.profileName + '\'});" id="" name="">编辑节目</a>';
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
    }
    //-----------------------------------
    //
    //	profile view
    //  path profile name
    //  2011年12月28日19:06:20
    //-----------------------------------
    ,
    viewProfile: function(Path, name) {

        var path = "FileLib/" + Path + "/" + Path + "_view.html";
        console.log("program view path: " + Path);
        art.dialog.open(path, {
            title: "预览节目: " + name,
            id: "viewPro",
            width: "98%",
            height: "98%",
            padding: 0,
            lock: false,
            opacity: 0.5,
            init: function() {
                var _this = this;
                $(this.iframe).load(function() {

                    var p = program.getIframe_WH(this);
                    this.style.width = p.w + "px";
                    this.style.height = p.h + "px";
                    art.dialog.list["viewPro"].size(parseInt(p.w), parseInt(p.h));
                    art.dialog.list["viewPro"].position("50%", "50%");
                });
                var src = this.iframe.src;
                this.iframe.src = src;

            }
        });
    },
    getIframe_WH: function(iframeObj) {
        var _w = 0,
        _h = 0;
        var iframeHeight = 0;
        //if ((navigator.userAgent.indexOf("Firefox")>0) || (navigator.userAgent.indexOf("Chrome")>0)) { // Mozilla, Safari, ...
        if ((navigator.userAgent.indexOf("Gecko") > 0) || (navigator.userAgent.indexOf("Presto") > 0)) { // Mozilla, Safari, ...
            _w = ($(iframeObj)[0].contentDocument.body.style.width).replace("px", "");
            _h = ($(iframeObj)[0].contentDocument.body.style.height).replace("px", "");
        } else if (navigator.userAgent.indexOf("MSIE") > 0) { // IE  记
            _w = ((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.width).replace("px", "");
            _h = ((document.frames[iframeObj].document.getElementsByTagName("body")[0]).style.height).replace("px", "");
        }
        return {
            w: _w,
            h: _h
        };
    },
    //-------------创建节目-----------///bank/index.php?control=playlist&action=addPlayList

    createprofile: function() {

        art.dialog.open('index.php?control=c_templateManage&action=fastCreateProfile', {
            title: '快速新建节目 ',
            width: 1200,
            height: 549,
            padding: 0,
            //lock: true,
            opacity: 0.5,
            resize: false,
            close: function() {
            	$('#programGrid').datagrid("reload");
                //window.parent.document.getElementById("getProfileInfo").contentWindow.location.reload();
            }
        });
    }
    //--------------编辑节目----------------//
    ,
    editprofile: function(editobjs) {
       // alert(editobjs.id);
        console.log("O", editobjs);
        window.top._BS_.temp.edit = true;
        window.top._BS_.temp.profileid =editobjs.id;
        window.top._BS_.temp.editid=true;
        window.top._BS_.temp.programInfoAction='edit';
       $.ajax({
            url:"index.php?control=fastProfile&action=getTemplateID"
            ,type:"POST"
            ,data:{profileID:editobjs.id}
            ,success: function(data){
               //data=$.parseJSON(data);
               window.top._BS_.temp.id=data;
              // alert(data[0].TemplateID);
            }

        });
       //alert(window.top._BS_.temp.id);
       // var id = editobjs.id;
         window.top._BS_.temp.profilename = editobjs.name;
        art.dialog.open('index.php?control=c_templateManage&action=fastCreateProfile', {
            title: '编辑节目',
            width: 1200,
            height: 549,
            padding: 0,
            lock: false,
            opacity: 0.5,
            resize: false,
            close: function() {
                $('#programGrid').datagrid("reload");
                //window.parent.document.getElementById("getProfileInfo").contentWindow.location.reload();
            }
        });
    }
        //------------------------------------------
        //-
        //- 删除 节目 删除多条
        //- params arr_id array tr 的部分ID
        //------------------------------------------
        ,
        deleteMulProfile:function () {
            var profileID = program.getprofileID();

            if (profileID.length > 0) {
                art.dialog({
                    title: '播放计划查看',
                    id: 'viewNodeInfoUi',
                    skin: 'chrome',
                    lock: false,
                    content: '您确定要删除此Profile么?',
                    button: [{
                        name: "确定",
                        callback: function() {
                            art.dialog({
                                id: 'dleProW',
                                skin: 'chrome',
                                content: '正在删除Profile.....',
                                lock: false
                            });
                            $.ajax({
                            	type:"post",
                            	url:"index.php?control=c_profileinfo&action=deleteMulProfile",
                            	data:"data="+profileID.join(","),
	                            timeout:300000,
                            	success:function(data){
                            		var st = data.responseText;
                            		console.info(st);
	                                art.dialog.list['dleProW'].close();
	                                $('#programGrid').datagrid('reload');
	                            },
	                            error:function(jqXHR, textStatus, errorThrown){
	                            	if(textStatus=="timeout"){
	                            		art.dialog({
		                                    skin: 'chrome',
		                                    id: 'timeOutUi',
		                                    content: '你指定的信息,加载失败!<br>请求超时......',
		                                    lock: false
		                                });
		                                art.dialog.list['dleProW'].close();
	                            	}else{
	                            		art.dialog({
	            	                        skin: 'chrome',
    	            	                    id: 'serverError',
        	            	                content: '无法加载您需要的信息!',
            	            	            lock: false
                                		});
                                		art.dialog.list['dleProW'].close();
                                		console.info(textStatus+":"+errorThrown);
	                            	}
	                        	}
                        	});
                    	}
                    },
                    {
                        name: "取消"
                    }]

                });
            } else {
                alert("您没有选择任何节目!");
            }
        }
       	 //------------------------------------------
		 //-
		 //- 获取选中的节目的ID
		 //- params 无
		 //------------------------------------------
		,
		getprofileID:function (){
			var profileID=[];
			var row=$("#programGrid").datagrid('getChecked');
			for(var s in row){
				profileID.push(row[s].profileID);
			}
			return profileID;
		}
};

$(document).ready(function() {
    program.init();

});
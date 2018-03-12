/**
 * Created by BoBo on 2017/5/11.
 */
if("undefined" == typeof _bs_sct) { var _bs_sct={}}
_bs_sct.c={
    result:{
        state:false,
        data:{},
        info:''
    },
    lastOnlineData:[],
    getClientStatusUrl:'index.php?control=socket&action=getClientState',
    getClientInfoJsonUrl:'index.php?control=client&action=getClientInfoJson',
    moveClientUrl:'index.php?control=c_clientGroup&action=moveClient',
    deleteClientUrl:'index.php?control=c_clientGroup&action=deleteClient',
    deleteGroupUrl:'index.php?control=c_clientGroup&action=deleteGroup',
    addSubGroupUrl:'index.php?control=c_clientGroup&action=addSubGroup',
    addGroupUrl:'index.php?control=c_clientGroup&action=addGroup',
    getProfileListUrl:'index.php?control=c_clientGroup&action=addGroup',
    getPlayListUrl:'index.php?control=c_clientGroup&action=addGroup',
    sendCommandUrl:'index.php?control=c_clientGroup&action=addGroup',
    updateClientNameUrl:'index.php?control=c_clientGroup&action=addGroup',
    controlClientsUrl:'index.php?control=socket&action=controlClients',
    getSendPlayListUrl:'index.php?control=c_playListManage&action=getSendPlayList',
    getClientStatus:function(cb){
        var _this=this;
        $.ajax({
            type:"post",
            url:this.getClientStatusUrl,
            success:function(result){
                var msg={state:false, data:[], info:''};
                if(result.indexOf("Register fail")>=0){
                    //注册错误，此处应该提示用户登录异常
                    result.info='用户退出登录';
                    cb(msg);
                    return false;
                }
                if(result.indexOf("@#@#@#")>0){
                    var clientStatusArr=result.split("@#@#@#");
                    var clientStatus=clientStatusArr[1];
                    var array_onlineClient=[];
                    var clientArr=window.eval("("+clientStatus+")");
                    msg.state=true;
                    msg.data=clientArr;
                    arrLen=clientArr.length;
                    //无终端上线 arrLen 为 0
                    if(!arrLen)
                    {
                        //此处应该将所有的终端下线
                        msg.info='当前没有终端上线!';
                        cb(msg);
                        return ;
                    }
                    //有新终端上线,终端列表中不存在的时候, 刷新控件数据
                    //一般将所有终端状态转换成下线，再更改上线的终端视图
                    cb(msg);
                }
            }
        });
    },
    getClientInfoJson:function (cb){
        //该函数将获取clientjson数据
        $.ajax({
            type:"post",
            url:this.getClientInfoJsonURL,
            dataType:"json",
            success:function(result){
                cb(result);
            }
        });
    },
    moveClient:function(clientCode,groupCode,cb){
        /*返回移动后的treeNodeCode
         使用原有的moveClient接口*/
        $.ajax({
            type:"post",
            data:{groupCode:groupCode,clientCode:clientCode},
            url:this.moveClientUrl,
            dataType:"json",
            success:function(result){
                cb(result);
            }
        });
    },
    deleteClient:function(treeNodeSerialID,cb){
        //发送clientId直接删除终端
        $.ajax({
            type:"post",
            data:{treeNodeSerialID:treeNodeSerialID},
            url:this.deleteClientUrl,
            dataType:"json",
            success:function(result){
                cb(result);
            }
        });
    },
    deleteGroup:function(treeNodeCode,cb){
        //发送groupId直接删除组，非空组不能删除
        $.messager.progress({title:"删除分组中请稍等"});
        $.ajax({
            type:"post",
            data:{treeNodeCode:treeNodeCode},
            url:this.deleteGroupUrl,
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
    addSubGroup:function(treeNodeCode,name,cb){
        //新分组创建在发送节点下，返回新的TreeNodeCode
        $.ajax({
            type:"post",
            data:{treeNodeCode:treeNodeCode,name:name},
            url:this.addSubGroupUrl,
            dataType:"json",
            success:function(result){
                cb(result);
            }
        });
    },
    addGroup:function(treeNodeCode,name,cb){
        //返回新的TreeNodeCode
        $.ajax({
            type:"post",
            data:{treeNodeCode:treeNodeCode,name:name},
            url:this.addGroupUrl,
            dataType:"json",
            success:function(result){
                cb(result)
            }
        });
    },
    getProfileList:function(){},
    getPlayList:function(){},
    updateClientName:function(clientId,name,cb){
        $.ajax({
            type:"post",
            data:{id:clientId,name:name},
            url:this.updateClientNameUrl,
            dataType:"json",
            success:function(result){
                cb(result)
            }
        });
    },
    controlClients:function (data,str_clientID,cb) {
        data.clientID = str_clientID;
        $.ajax({
            url: this.controlClientsUrl,
            type: "post",
            data: {data: data},
            success: function (result) {
                //shengpi__#@#__over
                var msg = {state: false, data: result, info: ''}
                if (result.indexOf("Register fail") >= 0) {
                    msg.info = "发送失败，服务器错误，用户可能已经登录！";
                    cb(msg);
                } else {
                    msg.state = true;
                    if (result.indexOf("shengpi") >= 0){
                        msg.info = "该节目需要等待审核之后才能发送！";
                    } else {
                        msg.info = "命令发送成功！";
                    }
                    cb(msg);
                }
            }
        });
    },
    _checkStrClientId:function(str_clientID){
        if (str_clientID == undefined || str_clientID == '') {
            console.log('str_clientID data format is incorrect');
            return false;
        } else {
            return true;
        }
    },
    setClientDownload:function (data,str_clientID,cb) {
        data.command = 'setClientDownload';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('setClientDownload str_clientID data format is incorrect');
            return false;
        }
        if (data.clientSpeed == undefined || data.clientSpeed == '' || isNaN(data.clientSpeed)) {
            console.log('setClientDownload clientSpeed data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    shengpi:function(data,str_clientID,cb){
        //shengpi__#@#__over
        data.command = 'shengpi';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('shengpi str_clientID data format is incorrect');
            return false;
        }
        if (data.shenpi == undefined || data.shenpi == '' || isNaN(data.shenpi)) {
            console.log('shengpi shenpi data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    playlist:function (data, str_clientID, cb){
        data.command = 'playlist';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('playlist str_clientID data format is incorrect');
            return false;
        }
        if (data.playListID == undefined || data.playListID == '' || isNaN(data.playListID)) {
            console.log('playlist playListID data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    shutTime:function(data, str_clientID, cb){
        data.command = 'shutTime';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('shutTime str_clientID data format is incorrect');
            return false;
        }
        if (data.shutOnTime == undefined || data.shutOnTime == ''||data.shutOffTime == undefined || data.shutOffTime == '') {
            console.log('shutTime shutOnTime/shutOffTime data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    screen:function(data, str_clientID, cb){
        data.command = 'screen';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('screen str_clientID data format is incorrect');
            return false;
        }
        if (data.screenResolution == undefined || data.screenResolution == ''||data.rotateDirection == undefined || data.rotateDirection == '') {
            console.log('shutTime screenResolution/rotateDirection data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    volume:function(data, str_clientID, cb) {
        data.command = 'volume';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('volume str_clientID data format is incorrect');
            return false;
        }
        if (data.volume == undefined || data.volume == '') {
            console.log('volume volume data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    }
    ,profile:function(data, str_clientID, cb) {
        data.command = 'profile';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('profile str_clientID data format is incorrect');
            return false;
        }
        if (data.profileID == undefined || data.profileID == '') {
            console.log('profile profileID data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    upgrate:function(data, str_clientID, cb) {
        data.command = 'upgrate';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('upgrate str_clientID data format is incorrect');
            return false;
        }
        if (data.upgratefile == undefined || data.upgratefile == '') {
            console.log('upgrate upgratefile data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    screenshot:function(data, str_clientID, cb) {
        data.command = 'screenshot';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('screenshot str_clientID data format is incorrect');
            return false;
        }
        if (data.screenshotTime == undefined || data.screenshotTime == '') {
            console.log('screenshot screenshotTime data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    reboot:function(data, str_clientID, cb) {
        data.command = 'reboot';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('reboot str_clientID data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    shutDown:function(data, str_clientID, cb) {
        data.command = 'reboot';
        if (str_clientID == undefined || str_clientID == '') {
            console.log('reboot str_clientID data format is incorrect');
            return false;
        }
        this.controlClients(data, str_clientID, cb)
    },
    getSendPlayList:function(cb){
        var _this=this;
        $.ajax({
            type:"post",
            url:this.getSendPlayListUrl,
            dataType:"json",
            success:function(result){
                cb(result);
            }
        });
    }
}
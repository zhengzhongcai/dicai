window._BS_ = {
	temp : {
		edit : false,
		id : ""
	},
	playList : {
		edit : false,
		id : ""
	},
	user : {
		edit : false,
		id : ""
	},
	profile : {
		weather : {
			addWeather : function(ifo) {

			}
		}
	}
};
var mainpage = {
	defaultSet : {
		model : "m_user_center",
		app : "app_user_log",
		rightTopModel : {
			m_user_center : true
		}
	},
	model : [],
	rightTopModel : [],
	app : [],
	modelPath : {},
	viewInit : function() {
		$("#mainView").hide();
		$.messager.progress({
			text : "正在加载中,请稍等......",
			msg : "<div style='text-align:center; font-size:16px; padding:20px 0px 20px 0px;'>欢迎进入多媒体信息发布系统!</div>"
		});
		mainpage.loadPermission();
	},
	readyLayoutItem : function(data) {
		var pers = data.permission;
		var m_path = mainpage.modelPath = data.modelPath;
		var model = [];
		var app = [];
		for (var i in pers) {
			if (pers[i].level == 1) {
				if (mainpage.defaultSet.rightTopModel[pers[i].akey]) {
					mainpage.rightTopModel.push(pers[i]);
				} else {
					model.push(pers[i]);
				}

			}
			if (pers[i].level == 2) {
				app.push(pers[i]);
			}
		}
		mainpage.app = app;
		mainpage.model = model;
		return {
			model : model,
			app : app
		};
	},
	parserLeftPanel : function() {

		var menu = mainpage.model;
		var menuButnArray = [];
		var centter = [];
		for (var i = 0, n = menu.length; i < n; i++) {
			menuButnArray.push('<a href="javascript:void(0);" tab_akey="' + menu[i].akey + '" tab_title="' + menu[i].permissionName + '" class="easyui-bxButton" style="height:100px; width:100px; line-height:90px;" data-options="iconCls:\'' + menu[i].akey + '\'">' + menu[i].permissionName + '</a>');
		}

		var west_panel = $('#mainView').layout('panel', 'west');
		$(west_panel).panel({content:menuButnArray.join("")});
		var west_panel = $('#mainView').layout('panel', 'center');
		$(west_panel).panel({content:"加载中请稍等......"});

		mainpage.bindMainMenuClick();
		mainpage.perserRightTopToolbar();
		mainpage.loadDefaultPage();
	},
	perserRightTopToolbar : function() {
		var m = mainpage.rightTopModel;
		for (var i in m) {
			$('<a href="javascript:void(0);" tab_akey="' + m[i].akey + '" tab_title="' + m[i].permissionName + '" class="easyui-linkButton" style="" data-options="iconCls:\'' + m[i].akey + '\',plain:true">' + m[i].permissionName + '</a>').appendTo("#top-right-toolbar").linkbutton().click(function() {
				var center_panel = $('#mainView').layout('panel', 'center');
				var tabPanel = $("#" + $(this).attr("tab_akey"));
				var tab_id = $(this).attr("tab_akey");
				var tabPanels = $(center_panel[0]).children(".easyui-tabs");
				tabPanels.each(function(index, item) {
					if (item.id != tab_id) {
						$(item).hide();
					}
				});
				//防止重复添加
				if (tabPanel.length) {
					tabPanel.fadeIn(500);
					return true;
				}
				mainpage.addTabPanel($(this).attr("tab_akey"));
			});
		}
		//切换主题
		var splitBtn='<a href="javascript:void(0)" id="theme_split_btn" class="easyui-menubutton" data-options="" >换肤</a>';
		var splitBtn_list='<div id="theme_split_list" style="width:100px;">'+  
							    '<div data-options="name:\'bootstrap\'">bootstrap</div>'+   
							    '<div data-options="name:\'metro\'">扁平风格</div>'+
							    '<div data-options="name:\'black\'">酷黑风格</div>'+ 
							    '<div data-options="name:\'metro-blue\'">扁平风格-蓝色</div>'+
							    '<div data-options="name:\'metro-gray\'">扁平风格-灰色</div>'+
							    '<div data-options="name:\'metro-green\'">扁平风格-绿色</div>'+ 
							    '<div data-options="name:\'metro-orange\'">扁平风格-橙色</div>'+
							    '<div data-options="name:\'metro-red\'">扁平风格-红色</div>'+
							'</div>';
		$(splitBtn_list).appendTo('#top-right-toolbar');
		$(splitBtn).menubutton({
			menu:'#theme_split_list',iconCls:'skin-change',plain:true
		}).appendTo('#top-right-toolbar');
		$($('#theme_split_btn').menubutton('options').menu).menu({onClick: function (item) { 
                 //item 的相关属性参见API中的menu 
                mainpage.changeTheme(item.name);
             } 
         });
		
		//退出按钮
		$('<a href="javascript:void(0);"  class="easyui-linkButton" style="" data-options="iconCls:\'login-out\',plain:true">退出系统</a>').appendTo("#top-right-toolbar").linkbutton().click(function() {
				mainpage.loginOut();
		});
	},
	loadDefaultPage : function() {
		mainpage.clearCenterPanel();
		var menu = mainpage.model;
		for (var i = 0, n = menu.length; i < n; i++) {
			//console.log(mainpage.defaultSet.model + "-----" + menu[i].akey);
			if (mainpage.defaultSet.model == menu[i].akey) {
				mainpage.addTabPanel(menu[i].akey);
				return true;
			}
		}

		var menu = mainpage.rightTopModel;
		for (var i = 0, n = menu.length; i < n; i++) {
			//console.log(mainpage.defaultSet.model + "-----" + menu[i].akey);
			if (mainpage.defaultSet.model == menu[i].akey) {
				mainpage.addTabPanel(menu[i].akey);
				return true;
			}
		}
	},
	bindMainMenuClick : function() {
		//绑定左侧菜单点击事件
		var west_panel = $('#mainView').layout('panel', 'west');
		$(west_panel[0]).css({
			"textAlign" : "center",
			"overflow" : "hidden"
		}).children(".easyui-bxButton").css({
			marginTop : "5px"
		}).click(function() {

			$(west_panel[0]).children(".easyui-bxButton").each(function(index, itm) {
				$(itm).bxButton("unselect");
			});
			$(this).bxButton("select");

			var center_panel = $('#mainView').layout('panel', 'center');
			var tabPanel = $("#" + $(this).attr("tab_akey"));
			var tab_id = $(this).attr("tab_akey");
			var tabPanels = $(center_panel[0]).children(".easyui-tabs");
			tabPanels.each(function(index, item) {
				if (item.id != tab_id) {
					$(item).hide();
				}
			});
			//防止重复添加
			if (tabPanel.length) {
				tabPanel.fadeIn(500);
				return true;
			}
			mainpage.addTabPanel($(this).attr("tab_akey"));
		});
		
	},
	addTabPanel : function(tabPanelID) {
		var center_panel = $('#mainView').layout('panel', 'center');
		$(center_panel[0]).append('<div id="' + tabPanelID + '" class="easyui-tabs"  ></div>');
		$("#" + tabPanelID).tabs({
			fit : true,
			onSelect : function(title, index) {
				var tab = $(this).tabs('getSelected'), extoption = $(tab[0]).data("extOption");
				if (extoption.loaded) {
					return true;
				}
				$(this).tabs("update", {
					tab : tab,
					options : {
						content : extoption.content
					}
				});
				extoption.loaded = true;
				$(tab[0]).data("extOption", extoption);
			}
		});
		var m = mainpage.model;
		var appParentId = "";
		for (var i in m) {
			if (m[i].akey == tabPanelID) {
				appParentId = m[i].permissionId;
				break;
			}
		}
		var m = mainpage.rightTopModel;
		for (var i in m) {
			if (m[i].akey == tabPanelID) {
				appParentId = m[i].permissionId;
				break;
			}
		}
		var app = mainpage.app;
		var appItems = [];
		var h = $(center_panel[0]).height() - 4 - $("#" + tabPanelID).children(".tabs-header").height(), w = $(center_panel[0]).width() - 4;
		var appPath = "", appTitle = "";
		for (var a in app) {
			if (app[a].parentId == appParentId) {
				var str_key=tabPanelID+"";
				appPath = mainpage.modelPath[app[a].akey];
				if(!appPath){continue;}
				appTitle = app[a].permissionName;
				$('#' + tabPanelID).tabs('add', {
					title : appTitle,
					height : h,
					closable : false,
					content : "加载中......",
					selected : false,
					tools : [{
						iconCls : 'icon-mini-refresh',
						handler : function() {
							mainpage.refreshTab(str_key);
							
						}
					}]
				});
				$($('#'+tabPanelID)
				.tabs('getTab',appTitle)[0]).data("extOption", {
					content : "<iframe frameborder='0' style='height:100%; width:100%;  overflow-x:hidden '  src = 'index.php/" + appPath + "' ></iframe>",
					loaded : false,
					akey:app[a].akey
				});
			}
		}
		$("#" + tabPanelID).tabs("select", 0);
	},
	refreshTab : function(akey) {
		
		
		
		
		var center_panel = $('#mainView').layout('panel', 'center');
		var tabPanel = "";
		$(center_panel[0]).children(".easyui-tabs").each(function(index, item) {
			if (item.id== akey) {
				tabPanel = item;
			}
		});
		var tab = $("#"+akey).tabs('getSelected'), extoption = $(tab[0]).data("extOption");
		$(tabPanel).tabs("update", {
			tab : tab,
			options : {
				content : extoption.content
			}
		});

	},
	clearCenterPanel : function() {
		var center_panel = $('#mainView').layout('panel', 'center');
		$(center_panel[0]).html("");
	},
	loadPermission : function() {
		$.ajax({
			url : "index.php/c_userRole/getUserRolePermission",
			type : "post",
			success : function(data) {
				if (data.state) {
					mainpage.readyLayoutItem(data.data);
					mainpage.parserLeftPanel();
					$.messager.progress("close");
					$("#mainView").fadeIn(1000);
				}
			},
			dataType : "json"
		});
	},
	changeTheme : function(themeName) {/* 更换主题 */
		var $easyuiTheme = $('#easyuiTheme');
		var url = $easyuiTheme.attr('href');
		var href = url.substring(0, url.indexOf('themes')) + 'themes/' + themeName + '/easyui.css';
		$easyuiTheme.attr('href', href);

		var $iframe = $('iframe');
		if ($iframe.length > 0) {
			for (var i = 0; i < $iframe.length; i++) {
				var ifr = $iframe[i];
				$(ifr).contents().find('#easyuiTheme').attr('href', href);
			}
		}
	}
	,loginOut:function(){
		$.messager.confirm("提示","您确定要退出系统么?",function(state){
			if(state){
				var dom_base=document.getElementsByTagName("base")[0];
				var str_base=$(dom_base).attr("href");
				window.location.href=str_base+"index.php/c_login/loginOut";
			}
		});
		
	}
};

$(document).ready(function() {
	//mainpage.viewInit();
});

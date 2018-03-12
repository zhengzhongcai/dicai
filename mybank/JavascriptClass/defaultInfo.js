// JavaScript Document
var resolutionInfo={
	resolution:{
		transverse:[
		["720x480","22"],
		["720x576","23"],
		["800x480","24"],
		["800x600","1"],
		["1024x768","0"],
		["1024x600","20"],
		["1280x800","4"],
		["1280x720","21"],
		["1280x1024","2"],
		["1360x768","25"],
		["1366x768","8"],
		["1440x900","5"],
		["1600x900","32"],
		["1600x1200","3"],
		["1680x1050","6"],
		["1920x1080","9"],
		["1920x1200","7"]
		],
		vertical:[
		["480x720","26"],
		["480x800","28"],
		["576x720","27"],
		["600x800","11"],
		["600x1024","29"],
		["720x1280","30"],
		["768x1024","10"],
		["768x1360","31"],
		["768x1366","18"],
		["800x1280","14"],
		["900x1440","15"],
		["1024x1280","12"],
		["1050x1680","16"],
		["1080x1920","19"],
		["1200x1600","13"],
		["1200x1920","17"]
		]
	},
	getResById:function(id)
	{
		var res=resolutionInfo.resolution.transverse,reso="";
		for(var i=0,n=res.length; i<n; i++)
		{
			if(res[i][1]==id)
			{
				reso=res[i][0].split("x");
			}
		}
		if(reso!=""){return {w:reso[0],h:reso[1]}; }
		var res=resolutionInfo.resolution.vertical,reso="";
		for(var i=0,n=res.length; i<n; i++)
		{
			if(res[i][1]==id)
			{
				reso=res[i][0].split("x");
			}
		}
		if(reso=="")
		{
			return false;
		}
		return {w:reso[0],h:reso[1]};
	},
	getIdByRes:function(resInfo)
	{
		var  arrf=resolutionInfo.resolution.transverse,arrs=resolutionInfo.resolution.vertical;
		var  arrtotal=arrf.concat(arrs);
		for(var i=0,len=arrtotal.length;i<len;i++){
						if(arrtotal[i][0]==resInfo){
								return arrtotal[i][1];
						}
		}
		return false;
	}
};

var _areasInfo_={
	areas:[
	//"#060","#0C0","#63F","#69F","#366","#96F","#9CF","#069","#3C9","#FC9"
			{type:"Video",title:"主区域",color:"#060"},
			{type:"Img",title:"图片",color:"#0C0"},
			{type:"Swf",title:"动画",color:"#63F"},
			{type:"Url",title:"网页",color:"#69F"}
			//,{type:"Time",title:"时钟",color:"#366"}
			,{type:"Txt",title:"字幕",color:"#96F"}
			//,{type:"Weather",title:"天气",color:"#96F"}
		],
	getAreaInfo:function(attrInfo){
		for(var i=0,n=_areasInfo_.areas.length; i<n; i++)
		{
			for(var a in _areasInfo_.areas[i])
			{
				for(var b in attrInfo){
					if(a==b&&_areasInfo_.areas[i][a]==attrInfo[b])
					{
						return _areasInfo_.areas[i];
					}
				}
				
			}
		}
		return false;
	}
};
var Bs={
		fontInfo:{
			font:[['simsun.ttc','宋体'],
				['simfang.ttf','仿宋'],
				['simhei.ttf','黑体'],
				['simkai.ttf','楷体'],
				['simli.ttf','隶书'],
				['simyou.ttf','幼圆'],
				['FZSTK.TTF','方正舒体'],
				['FZSTK.TTF','方正姚体'],
				['STLITI.TTF','华文隶书'],
				['stxinwei.ttf','华文新魏'],
				['stxingkai.ttf','华文行楷'],
				['ARIAL.TTF','Arial']],
				getFontNameByFileName:function(fname)
				{
					for(var i in Bs.fontInfo.font)
					{
						if(Bs.fontInfo.font[i][0]==fname)
						{return Bs.fontInfo.font[i][1];}
					}
					return false;
				},
				getFileNameByFontName:function(fname)
				{
					for(var i in Bs.fontInfo.font)
					{
						if(Bs.fontInfo.font[i][1]==fname)
						{return Bs.fontInfo.font[i][0];}
					}
					return false;
				}
		}
	};
Bs.template={
			type:[
				 ["0","X86"]
				,["1","安卓"]
			],
			getTypeNameByKey:function(key){
				var type=Bs.template.type;
				for(var i =0, n=type.length; i<n; i++)
				{
					if(type[i][0]==key.toString()){
						return type[i][1];
					}
				}
				return "";
			}
		}
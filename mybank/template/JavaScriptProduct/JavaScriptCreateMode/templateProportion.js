// JavaScript Document
function templateProportion(Proportion,tempType)
{
	this.pro=Proportion;
	this.type=tempType;
}
//获取终端类型预设值对应值
templateProportion.prototype.templateTypeEm=function()
{
	
	switch(this.type)
	{
		//0=>X86,1=>em862,2=>NXP
		case "X86":return {type:"0"}  ;break;
		case "em8621":return {type:"1"};break;
		case "Android":return {type:"2"}  ;break;
		default:return {type:this.type};
	}
}
//判断终端类型
templateProportion.prototype.templateType=function()
{
	
	switch(this.type)
	{
		//0=>X86,1=>em862,2=>NXP
		case "0":return {type:"X86"}  ;break;
		
		case "1":return {type:"Android"}  ;break;
		default:return {type:this.type};
	}
}
//可视化操作的比例
templateProportion.prototype.checkPro=function()
{
	
	switch(this.templateType().type)
	{
		case "X86":
					switch(this.pro)
					{
						
						//横向
						case "720x480"  :return {c:"1.241379",em:"22"} ;break;
						case "720x576"  :return {c:"1.241379",em:"23"} ;break;
						case "800x480"  :return {c:"1.379310",em:"24"} ;break;
						case "1360x768"  :return {c:"2.344828",em:"25"} ;break;
						case "1280x720"  :return {c:"2.206897",em:"21"} ;break;
						case "800x600"  :return {c:"1.455",em:"1"} ;break;
						case "1024x768" :return {c:"1.766",em:"0"}  ;break;
						case "1024x600" :return {c:"1.768",em:"20"}  ;break;
						case "1280x1024":return {c:"2.28",em:"2"}  ;break;
						case "1600x1200":return {c:"2.896552",em:"3"} ;break;
						case "1280x800" :return {c:"2.151261",em:"4"}  ;break;
						case "1366x768" :return {c:"2.355172",em:"8"};break;
						case "1440x900" :return {c:"2.452559",em:"5"};break;
						case "1600x900" :return {c:"2.852559",em:"32"};break;
						case "1680x1050":return {c:"2.896552",em:"6"};break;
						case "1920x1080":return {c:"3.310345",em:"9"};break;
						case "1920x1200":return {c:"3.310345",em:"7"};break;
						//纵向
						case "480x720"  :return {c:"1.655172",em:"26"} ;break;
						case "576x720"  :return {c:"1.655172",em:"27"} ;break;
						case "480x800"  :return {c:"1.839080",em:"28"} ;break;
						case "768x1360"  :return {c:"3.1264368",em:"31"} ;break;
						case "720x1280"  :return {c:"2.9425287",em:"30"} ;break;
						case "600x1024"  :return {c:"2.35402299",em:"29"} ;break;
						case "600x800"  :return {c:"2",em:"11"} ;break;
						case "768x1024" :return {c:"2.5",em:"10"}  ;break;
						case "800x1280" :return {c:"3",em:"14"}  ;break;
						case "1024x1280":return {c:"3",em:"12"}  ;break;
						case "768x1366" :return {c:"3.2",em:"18"};break;
						case "900x1440" :return {c:"3",em:"15"};break;
						case "900x1600" :return {c:"3.2",em:"33"};break;
						case "1200x1600":return {c:"4.1",em:"13"} ;break;
						case "1050x1680":return {c:"3.8",em:"16"};break;
						case "1080x1920":return {c:"4.3",em:"19"};break; 
						case "1200x1920":return {c:"4.3",em:"17"};break;
					}
		;break;
		case "Android": 
						switch(this.pro)
						{
							
							//横向
						case "720x480"  :return {c:"1.241379",em:"22"} ;break;
						case "720x576"  :return {c:"1.241379",em:"23"} ;break;
						case "800x480"  :return {c:"1.379310",em:"24"} ;break;
						case "1360x768"  :return {c:"2.344828",em:"25"} ;break;
						case "1280x720"  :return {c:"2.206897",em:"21"} ;break;
						case "800x600"  :return {c:"1.455",em:"1"} ;break;
						case "1024x768" :return {c:"1.766",em:"0"}  ;break;
						case "1024x600" :return {c:"1.768",em:"20"}  ;break;
						case "1280x1024":return {c:"2.28",em:"2"}  ;break;
						case "1600x1200":return {c:"3",em:"3"} ;break;
						case "1280x800" :return {c:"2.151261",em:"4"};break; 
						case "1366x768" :return {c:"2.355172",em:"8"};break;
						case "1440x900" :return {c:"2.232559",em:"5"};break;
						case "1600x900" :return {c:"2.852559",em:"32"};break;
						case "1680x1050":return {c:"2.896552",em:"6"};break;
						case "1920x1080":return {c:"3.310345",em:"9"};break;
						case "1920x1200":return {c:"3.410345",em:"7"};break;
						//纵向
						case "480x720"  :return {c:"1.655172",em:"26"} ;break;
						case "576x720"  :return {c:"1.655172",em:"27"} ;break;
						case "480x800"  :return {c:"1.839080",em:"28"} ;break;
						case "768x1360"  :return {c:"3.1264368",em:"31"} ;break;
						case "720x1280"  :return {c:"2.9425287",em:"30"} ;break;
						case "600x1024"  :return {c:"2.35402299",em:"29"} ;break;
						case "600x800"  :return {c:"2",em:"11"} ;break;
						case "768x1024" :return {c:"2.5",em:"10"}  ;break;
						case "800x1280" :return {c:"3",em:"14"}  ;break;
						case "1024x1280":return {c:"3",em:"12"}  ;break;
						case "768x1366" :return {c:"3.140230",em:"18"};break;
						case "900x1440" :return {c:"3",em:"15"};break;
						case "900x1600" :return {c:"3.2",em:"33"};break;
						case "1200x1600":return {c:"4.1",em:"13"} ;break;
						case "1050x1680":return {c:"3.8",em:"16"};break;
						case "1080x1920":return {c:"4.3",em:"19"};break; 
						case "1200x1920":return {c:"4.3",em:"17"};break;
						}
		;break;
	}
	
}
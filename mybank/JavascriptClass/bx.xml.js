// (function() {  
	// var _Xml = window._Xml = function(s) {  
		// this.test;  
		// return _Xml.fn.init(s);  
	// };  
	// _Xml.fn = _Xml.prototype = {  
		// init: function(s) {  
			// this.test = s;   
		// },  
		// testing: function() {  
			// alert(this.test);  
		// }  
	// };  
	// _Xml.fn.init.prototype = _Xml.prototype;   
// })();  
	
(function() {  
	var _Xml = window._Xml = function(s) {  
		this.test;  
		return _Xml.fn.init(s);  
	};  
	_Xml.fn = _Xml.prototype = {  
		init: function(s) {  
			this.test = s;   
		},
		/*************************************************************
		|
		|	函数名:loadDomXmlString
		|	功能:通过xml格式string加载XML对象
		|	返回值:
		|	参数: xmlInfo -> String xml格式字符串
		|	函数关联:
		|		-被调用:
		|		-主动调用:
		|	创建时间:2011年12月29日21:00:21
		|	修改时间:
		|
		**************************************************************/
		loadDomXmlString:function ()
		{
			xmlInfo=this.test;
			if(window.DOMParser)//firefox内核的浏览器
			{
				var p = new DOMParser();
				return p.parseFromString( str, "text/xml" );
			}
			else if( window.ActiveXObject )//ie内核的浏览器
			{
				var doc = new ActiveXObject( "Msxml2.DOMDocument" );
				doc.loadXML(str);
				return doc;
			}
			else
			{
				return false;
			}																								
		},
		/*************************************************************
		|
		|	函数名:loadDomXmlFile
		|	功能: 通过xml文件加载XML对象
		|	返回值:
		|	参数: xmlFile->String xml文件路径
		|	函数关联:
		|		-被调用:
		|		-主动调用:
		|	创建时间:2011年12月30日14:42:08
		|	修改时间:
		|
		**************************************************************/
		loadDomXmlFile:function ()
		{
			xmlFile=this.test;
			//加载多浏览器兼容的xml文档
			var xmldoc =null;
			try 
			{
				xmldoc =new ActiveXObject("Microsoft.XMLDOM");
			}
			catch (e) 
			{
				try 
				{
					xmldoc = document.implementation.createDocument("", "", null);
				} 
				catch (e) 
				{
					//alert(e.message);
				}
			}
			if(xmldoc!= null)
			{
				try 
				{
					//关闭异步加载
					xmldoc.async =false;
					xmldoc.load(xmlUrl);
					return xmldoc;
				}
				catch (e) 
				{
					//alert(e.message);
				}
			}
			return false;
		}
	};  
	_Xml.fn.init.prototype = _Xml.prototype;   
})();  
	
﻿/*!
 * Javascript Utility for web development.
 * 反馈 : www.cicyui.com/forum
 * www.cicyui.com ? 2010 - 构建自由的WEB应用
 */
(function(){
	var CC = window.CC;
/**
 * @class CC.Ajax
 * CC.Ajax Ajax请求封装类<br>
 * 该类依赖底层连接器实现，目前已实现的连接器有
 * <ul>
 * <li>XMLHttpRequest，这是浏览器自带的http连接，不能跨哉。</li>
 * <li>JSONP，利用script标签加载资源，可跨域。，参见{@link CC.util.JSONPConnector}</li>
 * </ul>
 * AJAX类具有很详细的事件列表，利用这些事件可控制请求的每个细节。
 * 可以new一个实例，再调用{@link open}, {@link send}或{@link connect}方法请求数据，
 * 也可以直接调用静态方法{@link CC.Ajax.connect}发起请求。
 <pre><code>
  //连接服务器并获得返回的JSON数据
  CC.Ajax.connect({
    url : '/server/json/example.page?param=v',
    success : function(ajax){
                    var json = this.getJson();
                    alert(json.someKey);
    },
    failure : function(){alert('连接失败.');},
    
    onfinal : function(){
        alert('无论成功与否，都被执行');
    }
  });

  //连接服务器并获得返回的XML文档对象数据
  CC.Ajax.connect({
    url : '/server/xml/example.page?param=v',
    success : function(ajax){
                    var xmlDoc = ajax.getXmlDoc();
                    alert(xmlDoc);
    }
  });

  // 连接服务器并运行返回的html数据,
  // 将html显示在设置的displayPanel中,在window范围内运行Javascript和style
  CC.Ajax.connect({
    url : '/server/xml/example.page?param=v',
    displayPanel : 'panel'
  });

  //
  var ajax = new CC.Ajax({
   url : '...',
   // 指定POST请法度
   method:'POST',
   // POST数据
   data : {article:'long long text.'}
   ....
  });
  ajax.connect();
  
  // 当资源需要跨域时，可进行JSONP请求，返回JSON对象数据。
  CC.Ajax.connect({
    // 指定方式为JSONP
    method : 'JSONP',
    //其它设置一样
    success : function(json){
        alert(json);
    }
  });
  </code></pre>
 * @extends CC.Eventable 
 */
var Ajax = CC.Ajax = CC.create();
/**
 * 快速Ajax调用<br>
  <pre><code>
  //连接服务器并获得返回的JSON数据
  Ajax.connect({
    url : '/server/json/example.page?param=v',
    success : function(ajax){
                    var json = this.getJson();
                    alert(json.someKey);
                },
    failure : function(){alert('连接失败.');}
  });

  //连接服务器并获得返回的XML文档对象数据
  Ajax.connect({
    url : '/server/xml/example.page?param=v',
    success : function(ajax){
                    var xmlDoc = this.getXmlDoc();
                    alert(xmlDoc);
                }
  });

  //连接服务器并运行返回的html数据,将html显示在设置的displayPanel中,在window范围内运行Javascript和style
  Ajax.connect({
    url : '/server/xml/example.page?param=v',
    displayPanel : 'panel'
  });
  </code></pre>
 * @member CC.Ajax
 */
Ajax.connect = (function(option){
    var ajax = new Ajax(option);
    ajax.connect();
    return ajax;
});

/**
* @event final
* 请求结束后调用,无论成功与否.
* @param {CC.Ajax} ajax
*/
/**
 * @event open
 * 在打开前发送
 * @param {CC.Ajax} ajax
 */

 /**
  * @event send
  * 在发送数据前发送
  * @param {CC.Ajax} ajax
  */
  
/**
 * @event json
 * 在获得XMLHttpRequest数据调后Ajax.getJson方法后发送,可直接对当前json对象作更改,这样可对返回的json数据作预处理.
 * @param {Object} o json对象
 * @param {Ajax} ajax
 */
/**
 * @event xmlDoc
 * 在获得XMLHttpRequest数据调后Ajax.getXMLDoc方法后发送,可直接对当前xmlDoc对象作更改,这样可对返回的XMLDoc数据作预处理.
 * @param {XMLDocument} doc
 * @param {CC.Ajax} ajax
 */
/**
 * @event text
 * 在获得XMLHttpRequest数据调后Ajax.getText方法后发送,如果要改变当前text数据,在更改text后设置当前Ajax对象text属性即可,这样可对返回的文件数据作预处理.
 * @param {String} responseText
 * @param {CC.Ajax} ajax
 */
/**
 * @event failure
 * 数据请求失败返回后发送.
 * @param {CC.Ajax} ajax
 */
 
/**
 * @event success
 * 数据成功返回加载后发送.
 * @param {CC.Ajax} ajax
 */
 
/**
 * @event load
 * 请求响应返回加载后发送(此时readyState = 4).
 * @param {CC.Ajax} ajax
 */
 
/**
 * @event statuschange
 * 在每个fire事件发送前该事件都会发送
 * @param {String} status
 * @param {CC.Ajax} j
 */
Ajax.prototype =
   /**
    * @class CC.Ajax
    */
   {
/**
 * @cfg {String} method GET 或者 POST 或者 JSONP,默认GET.
 */
    method :'GET',
/**@cfg {String} url 请求URL*/
    url : null,
/**@cfg {Boolean} asynchronous=true 是否异步,默认true*/
    asynchronous: true,
/**@cfg {Number} timeout=false 设置超时,默认无限制*/
    timeout: false,
/**@cfg {DOMElement} disabledComp 在请求过程中禁止的元素,请求结束后解除*/
   disabledComp : undefined,
/**@cfg {String} contentType 默认application/x-www-form-urlencoded*/
    contentType: 'application/x-www-form-urlencoded',
/**@cfg {String} msg 提示消息*/
    msg: "数据加载中,请稍候...",

/**@cfg {Boolean} cache=true 是否忽略浏览器缓存,默认为true.*/
    cache:true,

/**
 * @cfg {Function} caller 用于调用failure,success函数的this对象.
 */

/**
 * @cfg {Function} failure 失败后的回调.
 */

/**
 * @cfg {Object} data POST时发送的数据
 */

/**
 * @cfg {String|Object} params G提交的字符串参数或Map键值对,结果被追加到<b>url</b>尾.
 */
 /**
  *@cfg {Function} success 设置成功后的回调,默认为调用{@link invokeHtml}运行服务器返回的数据内容.
  */
    success: (function(ajax) {
        ajax.invokeHtml();
    }),

    /**
     * @cfg {Function} onfinal 无论请求成功与否最终都被调用.
     */

    /**@cfg {DOMElement|String} displayPanel 如果数据已加载,数据显示的DOM面板.*/
    displayPanel: null,

/**
 * @property xmlReq XMLHttpRequest对象
 * @type XMLHttpRequest
 */

/**
 * @property busy
 * 指明当前Ajax是否处理请求处理状态,在open后直至close前该值为真.
 * @type Boolean
 */
 
/**
 * @property loaded
 * 指明当前请求是否已成功返回(状态码200).
 * @type Boolean
 */

/**
 * @property closed
 * 指明当前请求是否已关闭.
 * @type Boolean
 */

/**
 * 在每个事件发送后,事件名称记录在该属性下.
 * @property status
 * @type String
 */

/**
 * @property text
 * 调用{@link #getText}方法后保存的text文本,在{@link #close}方法调用后销毁, 可重设以后某些过滤处理.
 * @type String
 */
         
/**
 * @property xmlDoc
 * 调用{@link #getXmlDoc}方法后保存的XMLDocument对象,在{@link #close}方法调用后销毁.
 * @type XMLDocument
 */

/**
 * @property json
 * 调用{@link #getJson}方法后保存的json对象,在{@link #close}方法调用后销毁.
 * @type Object
 */
             

    /**
     * @private
     * 根据设置初始化.
     */
    initialize: function(options) {
        CC.extend(this, options);
        this.method = this.method.toUpperCase();
    }
    ,

  /**
   * 重设置.
   * @param {Object} opts
   */
    setOption: function(opts) {
      CC.extend(this, opts);
    }
    ,

   /**
   * 重写以实现自定消息界面,用于进度的消息显示,默认为空调用.
   * @method setMsg
   */
    setMsg: fGo
    ,
    /**@private*/
    _onTimeout: function() {
        if (this.xmlReq.readyState >= 4) {
            return ;
        }
        if(__debug) console.log('ajax request timeout for '+this.url);
        this.abort();
        this._fire('timeout', this);
        this._close();
    }
    ,
    
    closed : false,
    
    /**@private*/
    _close: function() {
      if(!this.closed){
        if(this.timeout)
            clearTimeout(this._tid);
        if(this.onfinal)
            if(this.caller)
                this.onfinal.call(this.caller,this);
            else
                this.onfinal.call(this,this);

        this._fire('final', this);

        if (this.disabledComp)
            CC.disable(this.disabledComp, false);

        if(!(this.json === undefined))
            delete this.json;
        if(!(this.xmlDoc === undefined))
            delete this.xmlDoc;

        if(!(this.text === undefined))
            delete this.text;

        this.disabledComp = null;
        this.xmlReq = null;
        this.params = null;
        this.busy = 0;
        this.closed = true;
      }
    }
    ,

    /**终止请求*/
    abort: function() {
      if(this.xmlReq !== null){
        this.xmlReq.abort();
        this.aborted = true;
        this._close();
      }
    }
    ,
    /**@private*/
    _req : function(){
        if(!this.xmlReq)
            this.xmlReq = this.method==='JSONP'? 
                new CC.util.JSONPConnector(this) : 
                CC.ajaxRequest();
    },
    /**@private*/
    _setHeaders: function() {
        this._req();
        if (this.method === 'POST') {
            this.xmlReq.setRequestHeader('Content-type', this.contentType + (this.encoding ? '; charset=' + this.encoding: ''));
        }
        var j = this.xmlReq;
        if(this.headers) {
          CC.each(this.headers, function(k, v){
            j.setRequestHeader(k, v);
          });
        }
    }
    ,

   /**
    * 建立XMLHttpRequest连接,在调用该方法后调用send方法前可设置HEADER.
    */
    open: function() {
        this._req();
        this.busy = 1;
        this._fire('open',this);
        
        if (this.timeout) {
            this._tid = setTimeout(this._onTimeout.bind(this), this.timeout);
        }

        if (this.disabledComp) {
            CC.disable(this.disabledComp, true);
        }

        var ps = this.params, ch = this.cache, theUrl = this.url;
        if(ps || ch){
            
            var isQ = theUrl.indexOf('?') > 0;
            if(ch){
                //if (isQ)
                    theUrl = theUrl + '__uid=' + (+new Date());
                //else
                   // theUrl = theUrl + '?__uid=' + (+new Date());
            }

            if(ps){
                if(!isQ && !ch)
                    theUrl = theUrl+'?';

                theUrl = theUrl + '&' + ((typeof ps === 'string') ? ps : CC.queryString(ps));
            }
            
        }
        this.xmlReq.open(this.method, theUrl, this.asynchronous);
    }
    ,

/**开始传输.
 * @param {object} [data] 要传输的数据
 */
    send: function(data) {
        this._fire('send', this);
        this._setHeaders();
        this.xmlReq.onreadystatechange = this._onReadyStateChange.bindRaw(this);
        this.setMsg(this.msg);
    
    if(!data)
        data = this.data;
        
    if(data){
      if(typeof data === 'object')
        data = CC.queryString(data);
      this.xmlReq.send(data);
    }
    else this.xmlReq.send();
  }
    ,
    /**
   * 建立连接并发送数据,如果当前Ajax类正忙,会终止先前连接再重新建立,这方法是连续调用open,send以完成的.
   *@param {object} [data] 要传输的数据
   */
    connect : function(data) {
        if(this.busy)
            try{
                this.abort();
            }catch(e){
                if(__debug) console.log(e);
            }

        this.open();
        this.send(data);
    },
/**
 * 设置请求数据头.
 * @param {Object} key
 * @param {Object} value
 */
    setRequestHeader: function(key, value) {
        this._req();
        try{
          this.xmlReq.setRequestHeader(key, value);
        }catch(e){
          this._close();
          if(__debug) console.log(e);
        }
    }
    ,
/**
 * 获得服务器返回的数据头信息.
 */
    getResponseHeader: function(key) {
        return this.xmlReq.getResponseHeader(key);
    }
    ,
    
    _fire : function(e){

    	this.status = e;
    	
    	if(this.statuschange)
    	   this.statuschange.call(this.caller||this, e, this);
    	   
    	Ajax.fire('statuschange', e, this);
    	this.fire('statuschange', e, this);
    	
      if(Ajax.fire.apply(Ajax, arguments) !== false){
      	if(this.fire.apply(this, arguments) !== false)
      	  return;
      }
      return false;
    },
    
    //private
    _onReadyStateChange: function() {
        var req = this.xmlReq;
        if (req.readyState === 4) {
        	if(!this.aborted){
            if(this._fire('load', this) === false)
              return;
            var success = this.success;
            var failure = this.failure;
            // req.status 为 本地文件请求
            try{
                if (req.status == 200) {
                    this.loaded = true;
                    if(this._fire('success', this) === false)
                      return false;
                    if(success){
                        if(this.method === 'JSONP')
                            success.apply(this.caller||this, arguments);
                        else success.call(this.caller||this, this);
                    }
                } else {
                	  if(req.status == 0)
                	    if(__debug) console.error('拒绝访问,确认是否跨域,',this.url); 
                    if(this._fire('failure', this) === false)
                      return false;
                    if(failure)
                        failure.call(this.caller||this, this);
                }
            }catch(reqEx){
                if(__debug) console.error(reqEx);
                this._close();
                throw reqEx;
            }
            this._close();
          }
        }
    }
    ,
/**
 * 提供访问返回数据一致性方法,以文本形式提取返回数据,并将该数据保存在当前Ajax实例的text属性中.
 * 调用该方法中发送text事件,在Ajax关闭后Ajax.text会被清空.
 * @return {string} text 服务器返回的文件数据
 */
    getText : function() {
        if(this.text)
            return this.text;
        var s = this.text = this.xmlReq.responseText;
        this._fire('text',s,this);
        return this.text;
    },
  /**
   * 获得服务器返回数据的XML Document 格式文档对象,该方法调用了XMLHttpRequest.responseXML.documentElement获得XML文档对象.
   * 在调用过程中会发送xmlDoc事件.
   * @return {XMLDocument} XML Document 文档对象.
   */
    getXmlDoc : function() {
        if(this.xmlDoc)
            return this.xmlDoc;

        var doc = this.xmlDoc = this.xmlReq.responseXML.documentElement;
        this._fire('xmlDoc', doc, this);
        return this.xmlDoc;
    },
   /**
   * 获得服务器返回数据格式的JSON对象,该方法先调用getText方法获得文本数据,再将数据转为Javascript对象.
   * 可改变返回的text文本数据以达到修改JSON数据的目的,只要在调用getJson重设ajax.text值即可.
   * 在调用过程中会发送text事件.
   * @return 转换后的Javascript对象,如果数据格式有误,返回undefined
   */
    getJson : function(){
        if(this.json)
            return this.json;
        var o;
        try {
            this.json = o = eval("("+this.getText()+");");
        }catch(e) {
            if(__debug) { console.log('Internal server error : a request responsed with wrong json format:\n'+e+"\n"+this.getText()); }
            throw e;
        }
        this._fire('json',o,this);
        return this.json;
    }
    ,
  /**
   * 运行返回内容中的JS,方法返回已剔除JS后的内容.<br>
   *<pre><code>
    //服务器返回的文本数据为
    &lt;script&gt;
      alert('Hello world!');
    &lt;/script&gt;
    &lt;div&gt;something&lt;/div&gt;

    //////////
    Ajax.connect({
      url:'/test/',
      success : function(){
       //以下ss值为 '&lt;xml&gt;something&lt;/xml&gt;',弹出的alert并显示Hello world!.
        var ss = this.invokeScript();
      }
    });
   *</code></pre>
   *@return {string} 返回已剔除JS后的内容
   */
    invokeScript: function() {
        return eval(this.getText());
    }
    ,
  /**
   * 应用请求返回的HTML文本,方法先提取JS(如果存在),style(如果存在),将剩下内容放入displayPanel(innerHTML)中,再运行提取的JS,style.
   */
    invokeHtml: function() {
        var cacheJS =[] ,cache = [];
        var ss = this.getText().stripScript(function(sMatch) {
            cacheJS[cacheJS.length] = sMatch;
        }
        );
        cache = [];
        //先应用CSS
        ss = ss.stripStyle(function(sMatch) {
            cache[cache.length] = sMatch.innerStyle();
        }
        );
        cache.join('').execStyle();
        //再应用HTML
        if (this.displayPanel) {
            CC.$(this.displayPanel).innerHTML = ss;
        }
        //最后应用JS
        cacheJS.join('').execScript();
        cache = null;
        cacheJS = null;
        ss = null;
    }
};

CC.Eventable.call(Ajax.prototype);
CC.Eventable.call(Ajax);
})();
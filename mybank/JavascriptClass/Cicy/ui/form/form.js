﻿/**
 * @class CC.ui.ContainerBase
 */

/**
 * @cfg {Boolean} isForm 属性来自表单控件,注明该容器是否为一个表单容器。
 * 该属性便于表单元素通过getForm获得自身所在的表单容器。
 */
CC.ui.ContainerBase.prototype.isForm = false;

/**
 * @class CC.ui.form
 */

/**
 * @class CC.ui.form.FormElement
 * 表单元素基类，所有表单元素都派生自该类。
 * @extends CC.Base
 */
 
/**
 * @event focus
 * 元素获得焦点时发送
 */
/**
 * @event blur
 * 元素失去焦点后发送
 */

/**@cfg {String} name 指定提交字段的名称*/

/**@cfg {Object} value 值*/

/**
 * @property element
 * 提交数据放在这个html form element里.
 * @type {HTMLElement}
 */

/**
 * @cfg {Function} validator 数据验证函数.
 * 返回true或错误信息
 */

/**
 * @cfg {Boolean} validateOnblur=true 失去焦点时是否验证.
 */
 
/**
 * @cfg {String} elementNode 指定原生的表单元素所在结点的ID，默认为'_el'，
 * 每个表单控件都有一个原生的表单元素。<br>
 * 该配置通常用于创建或定制表单控件，使用时不必理会。
 */


(function(){
var spr,
    CC = window.CC,
    Bx = CC.Base,
    Tpl = CC.Tpl;

CC.create('CC.ui.form.FormElement', Bx, {

    name : false,

    value : undefined,

    element : false,
    
    elementNode: '_el',

    eventable : true,

    validator : false,

    validateOnblur : true,
    
    elementCS: 'g-form-el',

    initComponent: function() {
      //generate template first and searching form element node..
      var v = this.view;
      if (!v) {
        var t = this.template || this.type;
        this.view = v = Tpl.$(t);
      }
      var el = this.element;

      if (!el) {
        el = this.dom(this.elementNode);
        if(!el)
          el = this.view;
          
        this.element = el;
      }
      
      this.focusNode = el;
      
      this.addClass(this.elementCS);

      Bx.prototype.initComponent.call(this);

      if (this.name) this.setName(this.name);

      if (this.value) {
        v = CC.delAttr(this, 'value');
        this.setValue(v);
      }
      
      if (this.focusCS)
        this.bindFocusCS();
    },
/**
 * 设置聚焦,失焦时样式切换效果
 * @private
 */
    bindFocusCS : function(cs){
      if(cs)
        this.focusCS = cs;
      this.on('focus', this._switchFocusCS);
      this.on('blur', this._switchFocusCS);
    },

    _switchFocusCS : function(){
      if(this.focused){
        this.addClassIf(this.focusCS);
        this.focusCallback();
      }
      else this.delClass(this.focusCS);

    },

    /**
     * 用于修改聚焦样式时回调,如果子项有聚焦效果并需要监听聚焦的话,就不用重新监听一次,直接重写该函数即可.
     * @private
     */
    focusCallback : fGo,

    /**
     * 继承的FormElement控件必要实现控件失去/获得焦点时事件的发送.
     * @private
     */
    onFocusTrigger : function(){
      if(this.focused)
        return;
      this.focused = true;

      if (this.onfocus) this.onfocus();

      this.fire('focus');
    },

    /**@private*/
    onBlurTrigger : function(){
      if(this.focused){
        this.focused = false;

      if(this.validateOnblur && this.validator){
        this.checkValid();
      }

      if (this.onblur)
          this.onblur();

        this.fire('blur');
      }
    },

    /**
     * 继承的FormElement控件必要实现控件按件事件的发送.
     * @private
     */
    onKeydownTrigger : function(evt){
      this.fire('keydown', evt);
    },

/**
 * 验证控件,利用控件自身的validator验证,并调用{@link decorateValid}方法修饰结果
 * @return {Boolean}
 */
    checkValid : function(){
      var isv = this.validator? this.validator(this.getValue()):true;
      this.decorateValid(isv);
      return isv;
    },

/**
 * 验证失败后修饰控件的"错误"状态.重写该方法可自定义修饰"错误提示"的方法
 * @param {Boolean} isValid
 */
    decorateValid : function(msg){
    	var es = this.errorCS;
    	if(es)
    		this.checkClass(es, !(msg === true));
    },

/**
 * 置值
 * @param {Object} value
 * @return this
 */
    setValue: function(v) {
      this.element.value = v;
      this.value = v;
      return this;
    },

/**
 * 获得html form element元素值.
 * @return {Object}
 */
    getValue : function(){
      return this.element.value;
    },

/**获得控件文本显示值
 * @return {Object}
 */
    getText : function(){
      return this.getValue();
    },
/**
 * 设置显示值
 */
    setText : function(text){
    	return this.setValue(text);
    },
    
/**
 * 设置提交字段名称.
 * @param {String} name
 * @return this
 */
    setName: function(n) {
      this.element.name = n;
      this.name = n;
      return this;
    },

/**
 * 返回表单所在的表单容器，任何一个容器控件只需注明是否表单容器即可为表单容器,参见{@link CC.ui.ContainerBase#isForm}.
 * @return {CC.ui.ContainerBase|NULL} formContainer 或 null
 */   
    getForm : function(){
      var p = this.pCt;
      while(p){
        if(p.isForm)
          return p;
        p = p.pCt;
      }
      return null;
    },
    
    active : fGo,
    
    deactive : fGo,
    
    // @override
    mouseupCallback: function(evt) {
      if (this.onclick)
        this.onclick(evt, this.element);
    }
}
);

var cf = CC.ui.form.FormElement;
spr = cf.prototype;

var fr = CC.ui.form;

Tpl.def('Text', '<input type="{type}" class="g-ipt-text g-corner" />')
   .def('Textarea', '<textarea class="g-textarea g-corner" />')
   .def('Checkbox', '<span tabindex="0" class="g-checkbox"><input type="hidden" id="_el" /><img src="' + Tpl.BLANK_IMG + '" class="chkbk" /><label id="_tle"></label></span>')
   .def('Select', '<select class="g-corner"/>')
   .def('CC.ui.form.Label', '<span><label id="_tle" class="cap"></label></span>');
/**
 * @class CC.ui.form.Text
 * @extends CC.ui.form.FormElement
 * 封装原生input text元素,引用名为text
 */
/**
 * @cfg {String} type text或者password，默认text
 */
CC.create('CC.ui.form.Text', cf, {

    type : 'text',
    
    template : 'Text',
    
    initComponent : function(){
      this.view = Tpl.forNode(Tpl[this.template], this);
      spr.initComponent.call(this);
      var el = this.element;
      this.domEvent('focus',   this.onFocusTrigger, false, null, el)
          .domEvent('blur',    this.onBlurTrigger, false, null, el)
          .domEvent('keydown', this.onKeydownTrigger, false, null, el);
    },
    
    maxH : 20,

    focusCS: 'g-ipt-text-hover',
    
    focusCallback: function(evt) {
      spr.focusCallback.call(this, evt);
      //fix chrome browser.
      var self = this;
      //IE6下 this.view.select.bind(this.view).timeout(20);
      // 也会出错,它的select没能bind..晕
      (function() {
        self.view.select();
      }).timeout(20);
    },
    
    // fix ?? form element border box model
    getSize : function(){
        var tmp = CC.borderBox;
        CC.borderBox = true;
        var ret = Bx.prototype.getSize.apply(this, arguments);
        CC.borderBox = tmp;
        return ret;
    },
    // fix ?? form element border box model
    setSize : function(){
        var tmp = CC.borderBox;
        CC.borderBox = true;
        var ret = Bx.prototype.setSize.apply(this, arguments);
        CC.borderBox = tmp;
        return ret;
    }
});

CC.ui.def('text', fr.Text);
/**
 * @class CC.ui.form.Textarea
 * @extends CC.ui.form.FormElement
 * 封装原生textarea元素,引用名为textarea
 */
CC.create('CC.ui.form.Textarea', cf, fr.Text.constructors, {
  template : 'Textarea',
  focusCallback: cf.prototype.focusCallback,
  maxH : Bx.prototype.maxH
});

CC.ui.def('textarea', fr.Textarea);

/**
 * @class CC.ui.form.Checkbox
 * @extends CC.ui.form.FormElement
 * 引用名为checkbox
 */

/**
 * @cfg {Boolean} checked 是否选中状态,参见{@link #setChecked}
 */
/**
 * @cfg {Function} oncheck 状态改变时回调 oncheck(checked)
 */
CC.create('CC.ui.form.Checkbox', cf, {
    template : 'Checkbox',
    hoverCS: 'g-check-over',
    clickCS: 'g-check-click',
    checkedCS: 'g-check-checked',
    
    initComponent: function() {
      spr.initComponent.call(this);
      
      if (this.checked) {
        delete this.checked;
        this.setChecked(true);
      }
      
      this.domEvent('focus', this.onFocusTrigger)
          .domEvent('blur', this.onBlurTrigger)
          .domEvent('keydown', this.onKeydownTrigger);
    },

    mouseupCallback: function(evt) {
      this.setChecked(!this.checked);
      spr.mouseupCallback.call(this, evt);
    },
/**
 * @param {Boolean} checked
 * @return this
 */
    setChecked: function(b) {
      if(this.checked !== b){
        this.checked = b;
        this.element.checked = b;
        this.checkClass(this.checkedCS, b);
        if (this.oncheck) 
          this.oncheck(b);
      }
      return this;
    }
});
CC.ui.def('checkbox', fr.Checkbox);


/**
 * @class CC.ui.form.Radio
 * @extends CC.ui.form.FormElement
 */

/**
 * @cfg {Function} oncheck 状态改变时回调 oncheck(checked)
 */

CC.create('CC.ui.form.Radio', cf, fr.Checkbox.constructors, {
/**
 * @cfg {Boolean} checked 是否选中状态,参见{@link #setChecked}
 */
  innerCS: 'g-radio',
  template: 'Checkbox',
  hoverCS: 'g-radio-over',
  clickCS: 'g-radio-click',
  checkedCS: 'g-radio-checked',
  elementNode : false,
  
  mouseupCallback: function(evt) {
    if(!this.checked)
      this.setChecked(true);
    spr.mouseupCallback.call(this, evt);
  },
  
  getGroup : function(){
    var f = this.getForm();
    if(f) {
      var rg = f._RADIOGROUPS;
      if(!rg)
        rg = f._RADIOGROUPS = {};
        
      var rs = rg[this.name];
      if(rs) {
        return Bx.byCid(rs);
      } else {
          rs = CC.ui.instance('radiogrp', {pCt:f, showTo:f.ct, name:this.name});
          f.follow(rs);
          rg[this.name] = rs.cacheId;
          return rs;
      }
    }
  },
/**
 * @param {Boolean} checked
 * @return this
 */
  setChecked : function(checked){
    var pc = this.checked;
    fr.Checkbox.prototype.setChecked.apply(this, arguments);
    
    if(pc !== checked && checked && this.name){
       var g = this.getGroup();
       g && g.setChecked(this, true);
    }
    
    return this;
  }
});
CC.ui.def('radio', fr.Radio);

CC.Tpl.def('CC.ui.form.RadioGroup', '<input type="hidden" />');

/**
 * @class CC.ui.form.RadioGroup
 * @extends CC.ui.form.FormElement
 * Radio分组，引用名为radiogrp
 */
CC.create('CC.ui.form.RadioGroup', cf, {
/**
 * 获得当前选中的Radio
 * @return {CC.ui.form.Radio}
 */
  getChecked : function(){
    return this.currentRadio && Bx.byCid(this.currentRadio);
  },
/**
 * 设置Radio的选择状态。
 * @param {CC.ui.form.Radio} radio
 * @param {Boolean} selected
 */
  setChecked : function(radio, b){
    if(b){
      var c = this.getChecked();
      if(!c || c !== radio){
        if(c) {
          c.setChecked(false);
        }
        this.currentRadio = radio.cacheId;
        var v = radio.getValue();
        if(v !== undefined)
          this.setValue( v );
      }
    }else {
      this.currentRadio = null;
      this.setValue('');
    }
  }
});
CC.ui.def('radiogrp', CC.ui.form.RadioGroup);

/**
 * @class CC.ui.form.Select
 * 对原生select元素的轻量封装
 * @extends CC.ui.form.FormElement
 * @cfg {Array} array options, 属性为原生option元素的属性，例如{text:'text', value:'value'}
 * 
 <pre><code>
   var sel = CC.ui.instance(
     {
        ctype:'select',
        selectedIndex : 1,
        onchange : function(){
            alert(this.getSelIdx());
        },
        array:[
          {text:'请选择...', value:0},
          {text:'选项一...', value:1},
          {text:'选项二...', value:2}
        ]
     });
     
     alert(sel.getSelIdx());
     sel.add({text:'选项三'});
     sel.setSelIdx(3);
     sel.$(3).text = '改变选项三';
 </code></pre>
 */

/**
 * @cfg {Number} selectedIndex 可以在初始化时设置一个默认选中的选项下标。
 */
 
/**
 * @cfg {Function} onchange 选择变更时触发
 */
/**
 * @event change
 * 选择变更时发送
 */
CC.create('CC.ui.form.Select', cf, {
  
    template:'Select',
    
    initComponent: function() {
      spr.initComponent.call(this);
      this.domEvent('focus', this.onFocusTrigger)
          .domEvent('blur', this.onBlurTrigger)
          .domEvent('keydown', this.onKeydownTrigger)
          .domEvent('change', this.onChangeTrigger);
          
      if(this.array){
        for(var i=0,as = this.array,len=as.length;i<len;i++){
          this.add(as[i]);
        }
        delete this.array;
      }
      
      if(this.selectedIndex){
        this.element.selectedIndex = this.selectedIndex;
        delete this.selectedIndex;
      }
    },
    
    onChangeTrigger : function(){
      if(this.onchange)
         this.onchange();
         
      this.fire('change');
    },

    getText : function(){
    	var el = this.element, idx = el.selectedIndex;
      return idx == -1 ? '' : el.options[idx].text;
    },
/**
 * 添加一个option元素
 * @param {Object} option {text:'option text', value:'option value'}
 */
    add : function(option){
      var opts = this.element.options,
          op = document.createElement("OPTION");
      CC.extend(op, option);
      opts[opts.length] = op;
    },
/**
 * 获得下标对应的html option元素
 * @param {Number} index
 * @return {HTMLElement} option
 */
    $ : function(idx){
        return this.element.options[i];
    },
/**
 * 获得当前选择项下标。
 * @return {Number} selectedIndex
 */
    getSelIdx : function(){return this.element.selectedIndex;},
/**
 * 设置选中选项
 * @param {Number} index
 */
    setSelIdx : function(idx){this.element.selectedIndex = idx;}
});

CC.ui.def('select', fr.Select);
/**
 * @class CC.ui.form.Label
 * 标签，
 * 引用名为label
 * @extend CC.Base
 */
CC.create('CC.ui.form.Label', CC.Base);
CC.ui.def('label', CC.ui.form.Label);

})();
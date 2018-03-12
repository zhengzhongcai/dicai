﻿/**
 *
 */
CC.Tpl.def('CC.ui.form.Line', '<li class="g-form-ln"><label class="desc" id="_lbl"><span id="_tle"></span><span class="req" id="_req">*</span></label><div id="_ctx" class="field-ct"></div></li>')
      .def('CC.ui.form.Layer', '<ul class="g-formfields"></ul>')
      .def('CC.ui.form.FormLayer', '<form><ul id="_ctx" class="g-formfields"></ul></form>')
      .def('CC.ui.form.FieldsetUL', '<fieldset class="g-fieldset g-corner"><legend id="_tle"></legend><div id="_ctx" class="fieldset-ct"></div><div class="g-clear"></div></fieldset>');


CC.create('CC.ui.form.Line', CC.ui.ContainerBase, function(spr) {
  return {
/**
 * 指明Label结点ID,不存在时设为false
 * @type {String}
 */
    labelNode: '_lbl',

    hlabel:false,

    hlabelCS:'g-form-hln',

/**
 * 如果字段是必须的,属性指明用于修饰"必须"字段的结点
 */
    reqNode : '_req',

/**
 * 域中标签的htmlFor指向的子项id,默认为0,为首级第一个子项
 */
    labelFor: 0,

    ct: '_ctx',

    title: false,

    initComponent: function() {
      spr.initComponent.call(this);

      if(this.hlabel)
        this.addClass(this.hlabelCS);

      if (this.title === false && this.labelNode !== false) {
        var d = this.dom(this.labelNode);
        d.parentNode.removeChild(d);
      }

/**
 * @name CC.ui.form.FieldLI
 * @property {Boolean} required 值是否必须,
 * 该属性在基类中只起修饰作用,并无验证功能,
 * 并且当属性为真时,存在结点id为this.reqNode用于显示"必须"提示符.
 */
      if(this.required)
        CC.fly(this.reqNode).show().unfly();
    },

    onAdd: function(field) {
    	spr.onAdd.apply(this, arguments);
      if(this.labelFor !== false && this.$(this.labelFor) === field){
        if(field.element){
         var lbl =  this.dom(this.labelNode);
         if(lbl)
          lbl.htmlFor = field.element.id;
        }
      }
    }
  };
});



CC.ui.def('fieldline',CC.ui.form.Line);

CC.create('CC.ui.form.Layer', CC.ui.ContainerBase, {
  itemCls : CC.ui.form.Line,
  ct: '_ctx'
});

CC.ui.def('fieldlayer', CC.ui.form.Layer);

CC.create('CC.ui.form.FormLayer', CC.ui.ContainerBase, {
  itemCls : CC.ui.form.Line,
  ct: '_ctx',
/**
 * @return {HTMLElement} form
 */
  getFormEl : function(){
  	return this.view;
  },
/**
 * 根据name返回首个元素或多个控件元素.
 * @param {String} name 控件元素的name值
 * @param {Boolean} [loop] 是否返回多个
 * @return {CC.Base|null|Array}
 */
    byName : function(name, loop){
      return this.byId(name, 'name',loop);
    }
});

CC.ui.def('form', CC.ui.form.FormLayer);

CC.ui.form.Fieldset = function(opt){
  return new CC.ui.form.Layer(CC.extendIf(opt, {
    template:'CC.ui.form.FieldsetUL',
    itemCls : CC.ui.form.Layer,
    ct: '_ctx'
  }));
};


CC.ui.form.Line.prototype.itemCls = CC.ui.form.Layer;

CC.ui.def('fieldset',CC.ui.form.Fieldset);
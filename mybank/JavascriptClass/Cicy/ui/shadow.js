﻿(function(){

var CC = window.CC;
var PR = CC.Base.prototype;

/**
 * @class CC.ui.Shadow
 * 阴影类, 阴影类须在文档创建后(DOM Ready)生成.
 * @extends CC.Base
 */
CC.Tpl.def('CC.ui.Shadow' , CC.ie6 ? '<div class="g-dxshadow"></div>' : '<div class="g-shadow" style="display:none;"><div class="g-shadow-t" id="_t"></div><div class="g-shadow-lt" id="_lt"></div><div class="g-shadow-rt" id="_rt"></div><div class="g-shadow-l" id="_l"></div><div class="g-shadow-lb" id="_lb"></div><div class="g-shadow-r" id="_r"></div><div class="g-shadow-rb" id="_rb"></div><div class="g-shadow-b" id="_b"></div></div>');
CC.create('CC.ui.Shadow', CC.Base,
{
/**
 * @cfg {Number} [inpactW=8] 阴影宽度相关参数
 */
  inpactW : 8,
/**
 * @cfg {Number} [inpactH=0] 阴影高度相关参数
 */
  inpactH : 0,
/**
 * @cfg {Number} [inpactX=-4] 阴影x方向位移相关参数
 */
  inpactX : -4,
/**
 * @cfg {Number} [inpactY=8] 阴影y方向位移相关参数
 */
  inpactY : 4,
/**
 * @cfg {Number} [shadowWidth=8] 阴影边沿宽度,该值只对IE有效
 */
  shadowWidth : 6,

  /**
   * @cfg {Number} offset 变换引起的偏移量, 专为IE6采用的滤镜设置,非IE6时忽略该值,默认为4, 参见CSS滤镜中Blur(pixelradius).
   * @private
   */
  offset : 4,

  hidden : true,

/**
 * @cfg {CC.Base} target 阴影附加的目标控件
 */
  target : false,
  
  initComponent : function(){

    PR.initComponent.call(this);

    if(this.target)
        this.attach(this.target);
    if(CC.ie && !CC.ie6){
      this.shadowR = this.dom('_r');
      this.shadowB = this.dom('_b');
      this.shadowL = this.dom('_l');
      this.shadowT = this.dom('_t');
    }
  },
/**
 * 将阴影关联到目标控件.
 * @param {CC.Base} target 阴影附加的目标控件
 * @return this
 */
  attach : function(target){
    this.target = target;

    if(this.target.eventable){
        this.target.on('resized', this.reanchor, this)
                   .on('reposed', this.reanchor, this);
    }
    this.setZ((this.target.fastStyle('zIndex') || 1)-1);
    //专门针对不支持PNG图片的IE6
    if(CC.ie6){
      this._ie6OffDt = Math.floor(this.offset/2);
      this.view.style.filter="progid:DXImageTransform.Microsoft.alpha(opacity=50) progid:DXImageTransform.Microsoft.Blur(pixelradius="+this.offset+")";
    }
    return this;
  },

/**
 * 撤消阴影与目标控件的关联.
 * @return this
 */
  detach : function(){
    if(this.target.eventable){
        this.target.un('resized', this.reanchor, this);
        this.target.un('reposed', this.reanchor, this);
    }
    this.target = null;
    this.display(false);
    return this;
  },

/**
 * 调整阴影大小.
 * @private
 */
  setRightSize : CC.ie6?
    function(a, b){
      if(a !== false)
        this.setWidth(a - this.offset - this._ie6OffDt + this.inpactW - 1);
      if(b !== false)
        this.setHeight(b - this.offset - this._ie6OffDt + this.inpactH);
    }:function(a, b){
    if(a !== false){
      a = a+this.inpactW;
      if(a!=this.width)
        this.setWidth(a);
    }
    if(b !== false){
      b+=this.inpactH;
      if(b!=this.height){
        this.setHeight(b);
      }
    }
    //修正IE不能同时设置top, bottom的问题,设置具体高度
    if(CC.ie){
      var f = CC.fly(this.shadowR), d = this.shadowWidth*2, e;
      if(b !== false){
        e = b - d;
        f.setHeight(e);
        f.view = this.shadowL;
        f.setHeight(e);
      }
      if(a !== false){
        e = a - d;
        f.view = this.shadowB;
        f.setWidth(e);
        f.view = this.shadowT;
        f.setWidth(e);
      }
      f.unfly();
    }
  },
/**
 * 定位阴影.
 * @private
 */
  setRightPos : CC.ie6?
    function(pos){
      pos[0]+=this.inpactX - this._ie6OffDt + 1;
      pos[1]+=this.inpactY - this._ie6OffDt;
      this.setXY(pos);
    }:
    function(pos){
      this.setXY(pos[0]+this.inpactX, pos[1]+this.inpactY - 1);
    },
/**
 * 假如目标只是宽高改变，可调用本方法重新调整阴影。
 */
  resize : function(){
    var d = this.target.getSize(true);
    this.setRightSize(d.width, d.height);
  },
/**
 * 假如目标只是x,y改变，可调用本方法重新调整阴影。
 */
  repos : function(){
    this.setRightPos(this.target.absoluteXY());
  },
/**
 * 更新至当前状态,当阴影大小或位置与目标不一致时调用.
 * @return this
 */
  reanchor : function(){
    var t = !this.hidden;
    this.resize();
    this.repos();
    if(t)
      PR.display.call(this, true);
    return this;
  },

  // 只有target显示时才显示阴影,否则忽略.
  display : function(b){
    if(b===undefined)
      return PR.display.call(this);
    var b = b && this.target && !this.target.hidden;
    if(b){
      this.reanchor();
      this.appendTo(document.body);
    }else {
      this.del();
    }
    return PR.display.call(this, b);
  }
}
);

CC.ui.def('shadow', CC.ui.Shadow);

})();
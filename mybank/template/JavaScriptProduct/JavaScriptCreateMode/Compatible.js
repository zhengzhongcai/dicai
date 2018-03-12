// JavaScript Document

/*
*
*	兼容Firefox IE 的动态事件注册
*
*/
if(!window.attachEvent && window.addEventListener)
{
  window.attachEvent = HTMLElement.prototype.attachEvent=
  document.attachEvent = function(en, func, cancelBubble)
  {
    var cb = cancelBubble ? true : false;
    this.addEventListener(en.toLowerCase().substr(2), func, cb);
  };
}




/*
*
*	兼容Firefox IE 的event.offsetX  event.offsetY
*
*/

function getOffset(evt)
{
  var target = evt.target;
  if (target.offsetLeft == undefined)
  {
    target = target.parentNode;
  }
  var pageCoord = getPageCoord(target);
  var eventCoord ={
					x: window.pageXOffset + evt.clientX,
					y: window.pageYOffset + evt.clientY
				  };
  var offset ={
				offsetX: eventCoord.x - pageCoord.x,
				offsetY: eventCoord.y - pageCoord.y
			  };
  return offset;
}

function getPageCoord(element)
{
  var coord = {x: 0, y: 0};
  while (element)
  {
    coord.x += element.offsetLeft;
    coord.y += element.offsetTop;
    element = element.offsetParent;
  }
  return coord;
}

function Offset(evt)
{
  var Offset={_X:0,_Y:0};
  if (evt.offsetX == undefined)
  {
    var evtOffsets = getOffset(evt);
    Offset._X=evtOffsets.offsetX;
    Offset._Y=evtOffsets.offsetY;
  }
  else
  {
    Offset._X=evt.offsetX;
    Offset._Y=evt.offsetY;
  }
  return Offset;
}
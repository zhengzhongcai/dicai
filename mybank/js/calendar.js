//(function($) {
/* Timepicker plugin
 * Use timeboard to pick up any time.
 */
$.fn.timepicker = function(inputname) {
    if (!this.length) return this;
        var debug = false,
        _input = this,
        _timepicker = null,
        _timepickerPosition = null,
        _timepickerShowing = false,
        _mainClass = 'timepicker',
        _inputClass = 'timepicker-input',
        _mainWrap = 'time-picker-wrap'+inputname,
        _ddlhour='ddlhour'+inputname,
        _ddlminute='ddlminute'+inputname,
        _btnClear='btnClear'+inputname

    var _select="";
    _select+="<tr><td>小时:<select id=\""+_ddlhour+"\">";
    for(var i=0;i<24;i++)
    {
        _select+="<option value='"+padLeft(i.toString())+"'>"+i.toString()+"</option>";
    }
     _select+="</select></td></tr>";
    _select+="<tr><td>分钟:<select id=\""+_ddlminute+"\">";
    for(var i=0;i<60;i++)
    {
        _select+="<option value='"+padLeft(i.toString())+"'>"+i.toString()+"</option>";   
    }
    _select+="</select></td></tr>";
    
    var _clearinput="<tr><td><input type=\"button\" class=\"input_btn\" id=\""+_btnClear+"\" value=\"清空\"/></td></tr>"
    
    var _html = '<div id="' + _mainWrap + '" class="' + _mainClass+ '" style="display:none;"><table><tbody>'+_select+_clearinput+'</tbody></table></div>';

    this.focus(showTimepicker).click(showTimepicker).keydown(doKeyDown);
    $(document.body).mousedown(checkExternalClick);  //鼠标移开后

    function initialTimepicker() {
        _input.after(_html);
        _input.addClass(_inputClass);
        _timepicker = $('#' + _mainWrap);
        $("#"+_ddlhour).change(getTime);
        $("#"+_ddlminute).change(getTime);
        $("#"+_btnClear).click(doClear);
        if(_input.val()!="")
        {
           $("#"+_ddlhour+" option[value='"+_input.val().split(':')[0]+"']").attr("selected","true"); 
           $("#"+_ddlminute+" option[value='"+_input.val().split(':')[1]+"']").attr("selected","true");    
        }
        getTime();
    }

    function showTimepicker() {
        if (_timepicker == null) initialTimepicker();
        if (!_timepickerShowing) {
            getTime();
            setPosition(this);
            _timepicker.fadeIn("fast");
            _timepickerShowing = true;
            return;
        }
    }

    function hideTimepicker() {
        if (_timepickerShowing) {
            _timepicker.fadeOut("fast");
            _timepickerShowing = false;
            return;
        }
    }

    // Set position of timepicker(设定弹出div的位置)
    function setPosition(input) {
        var _inputPosition = $(input).offset();
        _timepickerPosition = [_inputPosition.left, _inputPosition.top + input.offsetHeight];
        if ($.browser.opera) { // correction for Opera when scrolled
            _timepickerPosition[0] -= document.documentElement.scrollLeft;
                _timepickerPosition[1] -= document.documentElement.scrollTop;
        }
        _timepicker.css({ 'left': _timepickerPosition[0] + 'px',
                          'top': _timepickerPosition[1] + 'px' });
    }

    function doKeyDown(e) {
        var handled = true;
        if (_timepickerShowing) {
            switch (e.keyCode) {
                // Tab key
                case 9: getTime();
                        hideTimepicker();
                        break;
                // ESC key
                case 27: hideTimepicker();
                         break;
            }
        } else {
            handled = false;
        }
            if (handled) {
                e.preventDefault();
            e.stopPropagation();
            }
    }

    function doClear() {
        // Clear time in the ``_input``
        _input.val("");
        hideTimepicker();
        return;
    }
    
    function getTime() {
        // 赋值
        var time = padLeft($("#"+_ddlhour).val()) + ':' + padLeft($("#"+_ddlminute).val());
        _input.val(time);
        return time;
    }

    function checkExternalClick(e) {
        if (!_timepickerShowing) return;
        var target = $(e.target);
        if ((target.parents('#' + _mainWrap).length == 0) &&
            !target.hasClass(_inputClass) &&
            !target.hasClass(_mainClass))
            hideTimepicker();
    }

};

    function padLeft(val) {
        if (val.toString().length >= 2) return String(val);
        return padLeft("0" + val);
    }
    
//})(jQuery);
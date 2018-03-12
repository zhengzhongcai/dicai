/***
 *
 * 
 * 解决 linkButton 禁用后还可以点击的BUG
 * 
 * 
 * 
 *  ***/

$.extend($.fn.linkbutton.methods, {  
            enable: function(jq){  
                return jq.each(function(n,obj){  
                    var state = $.data(obj, "linkbutton");   
                    state.options.disabled = false;
                    if (state.href) {
                        $(obj).attr("href", state.href);
                    }
                    if (state.onclick) {
                        obj.onclick = state.onclick;
                    }
                   
                    if (state.savedHandlers) {
                        for ( var i=0;i<state.savedHandlers.length;i++){
                         //$(obj).bind(state.savedHandlers[i].type,state.savedHandlers[i].handler);
                         $(obj).click(state.savedHandlers[i]);
                        }
                    }
                    $(obj).removeClass("l-btn-disabled");
                });  
            }
        });  
         
        $.extend($.fn.linkbutton.methods, {  
            disable: function(jq)
            {
                return jq.each(function(n,obj){  
                    var state = $.data(obj, "linkbutton");   
                    state.options.disabled = true;
                    var href = $(obj).attr("href");
                    if (href) {
                        state.href = href;
                        $(obj).attr("href", "javascript:void(0)");
                    }
                    if (obj.onclick) {
                        obj.onclick = obj.onclick;
                        obj.onclick = null;
                    }
                    //事件处理
                     //本来，jQuery 提供了一个 $.data 函数可以让我们直接获取元素缓存的数据，包括 jQuery 内部使用的 events 数据。
                     //但是，从 jQuery 1.8 开始，使用 $.data 就不可以了
                     //但是，依然提供了一个非支持的接口 $._data(element, "events") 来获取这些数据。
                     var eventData = $(obj).data("events") || $._data(obj, 'events');
			        if (eventData && eventData["click"]) {
			            var clickHandlerObjects = eventData["click"];
			            state.savedHandlers = [];
			            for (var i = 0; i < clickHandlerObjects.length; i++) {
			                if (clickHandlerObjects[i].namespace != "menu") {
			                    var handler = clickHandlerObjects[i]["handler"];
			                    $(obj).unbind('click', handler);
			                    state.savedHandlers.push(handler);
			                }
			            }
			        }
                     
                     
                    $(obj).addClass("l-btn-disabled");
                });
            }}
        ); 
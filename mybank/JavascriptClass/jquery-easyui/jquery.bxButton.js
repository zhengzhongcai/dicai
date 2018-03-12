(function($){
	
	function createButton(target) {
		var opts = $.data(target, 'bxButton').options;
		var t = $(target);
		
		t.addClass('l-btn').removeClass('l-btn-plain l-btn-selected l-btn-plain-selected');
		if (opts.plain){t.addClass('l-btn-plain');}
		if (opts.selected){
			t.addClass(opts.plain ? 'l-btn-selected l-btn-plain-selected' : 'l-btn-selected');
		}
		t.attr('group', opts.group || '');
		t.attr('id', opts.id || '');
		
		if(opts.iconCls){
			t.html(
			'<span class="l-btn-left">' +
			'<span class="big-icon-btn" style="display:block; padding:2px 0px 2px 0px;">' +
			'</span>' +
				'<span class="l-btn-text"></span>' +
			'</span>'
			);
		}
		else
		{
			t.html(
			'<span class="l-btn-left">' +
				'<span class="l-btn-text"></span>' +
			'</span>'
			);
		}
		
		if (opts.text){
			t.find('.l-btn-text').html(opts.text);
			if (opts.iconCls){
				t.find('.big-icon-btn').addClass(opts.iconCls);
			}
		} else {
			t.find('.l-btn-text').html('<span class="l-btn-empty">&nbsp;</span>');
			if (opts.iconCls){
				t.find('.l-btn-empty').addClass(opts.iconCls);
			}
		}
		
		t.unbind('.bxButton').bind('focus.bxButton',function(){
			if (!opts.disabled){
				$(this).find('.l-btn-text').addClass('l-btn-focus');
			}
		}).bind('blur.bxButton',function(){
			$(this).find('.l-btn-text').removeClass('l-btn-focus');
		});
		if (opts.toggle && !opts.disabled){
			t.bind('click.bxButton', function(){
				if (opts.selected){
					$(this).bxButton('unselect');
				} else {
					$(this).bxButton('select');
				}
			});
		}
		
		setSelected(target, opts.selected);
		setDisabled(target, opts.disabled);
	}
	
	function setSelected(target, selected){
		var opts = $.data(target, 'bxButton').options;
		if (selected){
			if (opts.group){
				$('a.l-btn[group="'+opts.group+'"]').each(function(){
					var o = $(this).bxButton('options');
					if (o.toggle){
						$(this).removeClass('l-btn-selected l-btn-plain-selected');
						o.selected = false;
					}
				});
			}
			$(target).addClass(opts.plain ? 'l-btn-selected l-btn-plain-selected' : 'l-btn-selected');
			opts.selected = true;
		} else {
			if (!opts.group){
				$(target).removeClass('l-btn-selected l-btn-plain-selected');
				opts.selected = false;
			}
		}
	}
	
	function setDisabled(target, disabled){
		var state = $.data(target, 'bxButton');
		var opts = state.options;
		$(target).removeClass('l-btn-disabled l-btn-plain-disabled');
		if (disabled){
			opts.disabled = true;
			var href = $(target).attr('href');
			if (href){
				state.href = href;
				$(target).attr('href', 'javascript:void(0)');
			}
			if (target.onclick){
				state.onclick = target.onclick;
				target.onclick = null;
			}
			opts.plain ? $(target).addClass('l-btn-disabled l-btn-plain-disabled') : $(target).addClass('l-btn-disabled');
		} else {
			opts.disabled = false;
			if (state.href) {
				$(target).attr('href', state.href);
			}
			if (state.onclick) {
				target.onclick = state.onclick;
			}
		}
	}
	
	$.fn.bxButton = function(options, param){
		if (typeof options == 'string'){
			return $.fn.bxButton.methods[options](this, param);
		}
		
		options = options || {};
		return this.each(function(){
			var state = $.data(this, 'bxButton');
			if (state){
				$.extend(state.options, options);
			} else {
				$.data(this, 'bxButton', {
					options: $.extend({}, $.fn.bxButton.defaults, $.fn.bxButton.parseOptions(this), options)
				});
				$(this).removeAttr('disabled');
			}
			
			createButton(this);
		});
	};
	
	$.fn.bxButton.methods = {
		options: function(jq){
			return $.data(jq[0], 'bxButton').options;
		},
		enable: function(jq){
			return jq.each(function(){
				setDisabled(this, false);
			});
		},
		disable: function(jq){
			return jq.each(function(){
				setDisabled(this, true);
			});
		},
		select: function(jq){
			return jq.each(function(){
				setSelected(this, true);
			});
		},
		unselect: function(jq){
			return jq.each(function(){
				setSelected(this, false);
			});
		}
	};
	
	$.fn.bxButton.parseOptions = function(target){
		var t = $(target);
		return $.extend({}, $.parser.parseOptions(target, 
			['id','iconCls','iconAlign','group',{plain:'boolean',toggle:'boolean',selected:'boolean'}]
		), {
			disabled: (t.attr('disabled') ? true : undefined),
			text: $.trim(t.html()),
			iconCls: (t.attr('icon') || t.attr('iconCls'))
		});
	};
	
	$.fn.bxButton.defaults = {
		id: null,
		disabled: false,
		toggle: false,
		selected: false,
		group: null,
		plain: false,
		text: '',
		iconCls: null,
		iconAlign: 'left'
	};
	
})(jQuery);
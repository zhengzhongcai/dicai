$.extend($.fn.datagrid.methods,{
	changeUrl:function(target, s){
		//target.
		var opts=$(target[0]).data("datagrid");
		opts.options.url=s;
		//console.log("%O",opts);
		//console.log("%O",target.datagrid.defaults);
	}
});


$.extend($.fn.datagrid.methods, {
        bg: function (target, options) {
            console.log("%O",target);
        }
        
    });
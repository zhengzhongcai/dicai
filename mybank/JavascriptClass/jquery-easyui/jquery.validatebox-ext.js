$.extend($.fn.validatebox.defaults.rules, {    
    remoteMulitParamater: {    
    	 /**
                 * [validator 远端验证规则]  
                 * @param  {[type]} value [description]  
                 * @param  {[type]} param [param[0]为url,param[1]为要传给后台的属性名，其值为value,param[2]为一个字符串模式的Object{}对象,包含了额外的参数]  
                 * @return {[type]}  
                 */  
        validator: function(value, param){    
            var data = {};   
                    data[param[1]] = value;   
                    if(param.length>2){
                    	if(typeof(param[2])=="string")
                    	{
                    		param[2]=eval(param[2]);
                    	}
                    	for(var i in param[2]){
                    		data[i]=param[2][i];
                    	}
                    }
                    var isValidate = $.ajax({   
                        url: param[0],   
                        dataType: "json",   
                        data: data,   
                        async: false,   
                        cache: false,   
                        type: "post"  
                    }).responseText;   
                    return isValidate == "true";    
        },    
        message: '您输入的字符已存在,请重新输入!.'   
    }    
}); 

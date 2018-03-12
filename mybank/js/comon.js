function checkAll(objName,objAllName){
	if($('input[name="'+objName+'"]').attr("checked")==true){
		$('input[name="'+objAllName+'"]').attr("checked",true);
	}else{
		$('input[name="'+objAllName+'"]').attr("checked",false);
	}
}

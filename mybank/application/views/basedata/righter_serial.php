	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="javascript:void(0)" class="on">业务清单</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=vipParam">VIP客户资料管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serverParam">柜员管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=counterParam">柜台管理</a></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem">添加</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem">删除</a>
		</div>
		<script>
			<{foreach item=row from=$optArr}>
				$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbSerialPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">业务代码</th>
						<th width="10%">业务名称</th>
						<th width="15%">等候超时临界时间(单位:秒)</th>
						<th width="15%">办理超时临界时间(单位:秒)</th>
						<th width="25%">业务说明</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->
<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3>添加业务</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">业务代码:</th>
				<td><input name="S_serialno" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">业务名称:</th>
				<td><input name="S_serialname" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">等候超时临界时间(单位:秒):</th>
				<td><input name="S_mintime" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">办理超时临界时间(单位:秒):</th>
				<td><input name="S_stime" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">业务说明:</th>
				<td><textarea name="S_explain" rows="4" cols="30"></textarea></td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	var paramInfo = {
		S_serialno:"",
		S_serialname:"",
		S_mintime:"",
		S_stime:"",
		S_explain:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		getSerialParam();
	}
	// 获取公共参数数据
	function getSerialParam(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getSerialParam";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#tbSerialPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbSerialPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.S_serialno+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.S_serialno+'</td>'+
						  '<td>'+paramInfo.S_serialname+'</td>'+
						  '<td>'+paramInfo.S_mintime+'</td>'+
						  '<td>'+paramInfo.S_stime+'</td>'+
						  '<td>'+paramInfo.S_explain+'</td>'+
						  //'<td>'+paramInfo.S_lrtime.substr(0, paramInfo.S_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.S_lasttime.substr(0, paramInfo.S_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		$('.pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('.pop_box ,tbAddParamInfo'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=addSerialInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data == '' || typeof data == 'undefined')
				{
					alert('添加成功.');
					getSerialParam();
					hidePopbox();
				}
				else
					alert('添加失败.');
			}
		}); // ajax
	}// func
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbSerialPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		
		var isEdit = $('#isEdit').val();
		if (isEdit-0) return;
		else $('#isEdit').val(1);
		
		var i = 1;
		$('#'+paramId).parent().nextAll().each(function(){
			var content = $(this).html();
			switch (i){
				case 1:
					paramInfo.S_serialno = content;
					$(this).html('<input type="text" name="S_serialno" value="'+content+'"/>');
					break;
				case 2:
					paramInfo.S_serialname = content;
					$(this).html('<input type="text" name="S_serialname" value="'+content+'"/>');
					break;
				case 3:
					paramInfo.S_mintime = content;
					$(this).html('<input type="number" name="S_mintime" value="'+content+'"/>');
					break;
				case 4:
					paramInfo.S_stime = content;
					$(this).html('<input type="number" name="S_stime" value="'+content+'"/>');
					break;
				case 5:
					paramInfo.S_explain = content;
					$(this).html('<textarea name="S_explain" rows="4" cols="40">'+content+'</textarea>'+'&nbsp;<input class="btn_orange" type="button" value="保存" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="取消" onclick="resetParamInfo()">');
					break;
			}// switch
			i++;
		});
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbSerialPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbSerialPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbSerialPram'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=saveSerialInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.S_serialno,
			success: function(data) {
				if (data == '' || typeof data == 'undefined')
				{
					alert('<{$COMMON_TIP_EDIT_SUCCESS|default:"修改成功."}>');
					getSerialParam();
					$('#isEdit').val(0);
				}
				else
					alert('<{$COMMON_TIP_EDIT_FAILED|default:"修改失败."}>');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getSerialParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbSerialPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=deleteSerialInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('删除成功.');
					getSerialParam();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
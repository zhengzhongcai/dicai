	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="javascript:void(0)" class="on">公共参数管理</a></li>
				<li><a href="<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=evaParam&fcode=data-j" >评价项目管理</a></li>
			</ul>
		</div>
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
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="15%">参数名</th>
						<th width="15%">参数值</th>
						<th width="65%">备注</th>
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
		<h3>添加公共参数</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">参数名:</th>
				<td><input name="PramsName" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">参数值:</th>
				<td><input name="PramsValue" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">备注:</th>
				<td><textarea name="PramsBz" rows="4" cols="30"></textarea></td>
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
		PramsName:"",
		PramsValue:"",
		PramsBz:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		getCommonParam();
	}
	// 获取公共参数数据
	function getCommonParam(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getCommonParam";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCommonPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.PramsName+'" type="checkbox"/></td>'+
						  '<td>'+paramInfo.PramsName+'</td>'+
						  '<td>'+paramInfo.PramsValue+'</td>'+
						  '<td>'+paramInfo.PramsBz+'</td>'+
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
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=addParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data > 0)
				{
					alert('添加成功');
					getCommonParam();
					hidePopbox();
				}
				else
					alert('添加失败');
			}
		}); // ajax
	}// func
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
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
					paramInfo.PramsName = content;
					$(this).html('<input type="text" name="PramsName" value="'+content+'"/>');
					break;
				case 2:
					paramInfo.PramsValue = content;
					$(this).html('<input type="text" name="PramsValue" value="'+content+'"/>');
					break;
				case 3:
					paramInfo.PramsBz = content;
					$(this).html('<textarea name="PramsBz" rows="4" cols="50">'+content+'</textarea>'+'&nbsp;<input class="btn_orange" type="button" value="保存" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="取消" onclick="resetParamInfo()">');
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
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbCommonPram'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=saveParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.PramsName,
			success: function(data) {
				if (data > 0)
				{
					alert('修改成功');
					getCommonParam();
					$('#isEdit').val(0);
				}
				else
					alert('修改失败.');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getCommonParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=deleteParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('删除成功.');
					getCommonParam();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
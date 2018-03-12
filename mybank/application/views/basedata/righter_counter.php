	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serialParam">业务清单</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=vipParam">VIP客户资料管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serverParam">柜员管理</a></li>
				<li><a href="javascript:void(0)" class="on">柜台管理</a></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="itsOrgId" id="itsOrgId" onchange="getCounterParam()">
				<option value="">默认</option>
				<?php foreach($itsOrgAr as $val): ?>
				<option value="<?php echo $val['sysno'];?>"><?php echo $val['sysname'];?></option>
				<?php endforeach;?>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem1">添加</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem1">编辑</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem1	">删除</a>
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">所属机构代码</th>
						<th width="10%">柜台号</th>
						<th width="25%">评价器柜台号IP地址</th>
						<th width="25%">业务ID序列</th>
						<th width="35%">评价器是否受控</th>
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
		<h3>添加柜台</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">所属机构代码:</th>
				<td>
					<select name="C_sysno">
						<{foreach item=row from=$itsOrgArr}>
						<option value="<{$row.sysno}>"><{$row.sysname}></option>
						<{/foreach}>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">柜台号:</th>
				<td><input name="C_no" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">评价器是否受控:</th>
				<td>
					<select name="C_iscontrol">
						<option value="1">是</option>
						<option value="0">否</option>
					</select>
				</td>
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
		C_no:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		//getCounterParam();
	}
	// 获取公共参数数据
	function getCounterParam(){
		// 获取网点id
		var orgId = $('#itsOrgId').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getCounterParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			success: function(data) {
				$('#tbCounterPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbCounterPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.C_no+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.C_sysno+'</td>'+
						  '<td>'+paramInfo.C_no+'</td>'+
						  '<td>'+paramInfo.C_Mip+'</td>'+
						  '<td>'+paramInfo.C_serialIdArray+'</td>'+
						  '<td>'+paramInfo.C_iscontrol+'</td>'+
						  //'<td>'+paramInfo.C_bz+'</td>'+
						  //'<td>'+paramInfo.C_lrtime.substr(0, paramInfo.C_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.C_lasttime.substr(0, paramInfo.C_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		var orgid = $('[name=itsOrgId]').val();
		if(orgid.length>0){
			$('.pop_box [name=C_sysno]').val(orgid);
		}
		$('.pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],input[type="number"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=addCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('添加成功.');
					getCounterParam();
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
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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
					paramInfo.C_sysno = content;
					break;
				case 2:
					paramInfo.C_no = content;
					break;
				case 3:
					paramInfo.C_Mip = content;
					$(this).html('<input type="text" name="C_Mip" value="'+content+'"/>');
					break;
				case 4:
					paramInfo.C_serialIdArray = content;
					$(this).html('<textarea rows="4" cols="40" name="C_serialIdArray">'+content+'</textarea>');
					break;
				case 5:
					paramInfo.C_iscontrol = content;
					if (content > 0) 
						$(this).html('<select name="C_iscontrol"><option value="1" selected>是</option><option value="0">不是</option></select>');
					else
						$(this).html('<select name="C_iscontrol"><option value="1">是</option><option value="0" selected>不是</option></select>');
						$(this).append('&nbsp;<input class="btn_orange" type="button" value="保存" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="取消" onclick="resetParamInfo()">');
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
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbCounterPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbCounterPram'));
		postData += 'C_sysno='+paramInfo.C_sysno+'&C_no='+paramInfo.C_no;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=saveCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "&paramId=" + paramInfo.C_no,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<{$COMMON_TIP_EDIT_SUCCESS|default:"修改成功."}>');
					getCounterParam();
					$('#isEdit').val(0);
				}
				else
					alert('<{$COMMON_TIP_EDIT_FAILED|default:"修改失败."}>');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getCounterParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('<{$COMMON_TIP_CHOOSE_DEL_ITEM|default:"请选择需要删除的项."}>');
			return;
		}// if
		
		if (!confirm('<{$COMMON_TIP_IS_DEL|default:"确认删除!"}>')) return;
		
		var C_sysno = $('select[name="itsOrgId"]').val();
		//alert(C_sysno);return;
		var url = "<{$baseUrl}>/index.php?control=basedata&action=deleteCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma() + "&C_sysno="+C_sysno,
			success: function(data) {
				if (data > 0)
				{
					alert('<{$COMMON_TIP_DEL_SUCCESS|default:"删除成功."}>');
					getCounterParam();
				}
				else
					alert('<{$COMMON_TIP_DEL_FAILED|default:"删除失败."}>');
			}
		}); // ajax
	}// func
</script>
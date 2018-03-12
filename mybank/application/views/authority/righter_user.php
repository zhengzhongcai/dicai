	<!----right---->
	<div class="right_box">

		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="209" href="javascript:showPopbox()" class="tool_add statItem1"><?=lang('AUTH_LEFTER_ADD')?lang('AUTH_LEFTER_ADD'):'添加' ?></a>
			<a auth="210" href="javascript:editParamInfo()" class="tool_edit statItem1"><?=lang('AUTH_LEFTER_EDIT')?lang('AUTH_LEFTER_EDIT'):'编辑' ?></a>
			<a auth="211" href="javascript:deleteParamInfo()" class="tool_del statItem1"><?=lang('AUTH_LEFTER_DEL')?lang('AUTH_LEFTER_DEL'):'删除' ?></a>
		</div>
		<!----tool 工具条 end---->
		<script>
			//<{foreach item=row from=$fcodeArr}>
			//	$('a[auth="<{$row.menurole_id}>"]').css('display', 'inline-block');
			//<{/foreach}>
		</script>
		<!----table 表格---->
		<!--
		<input type="hidden" id="isEdit" value="0"/>
		-->
		<div class="mod_table">
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="5%"><?=lang('AUTH_RIGHTER_USERID')?lang('AUTH_RIGHTER_USERID'):'ID' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_USER_LOGIN')?lang('AUTH_RIGHTER_USER_LOGIN'):'登录名' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_USER_NAME')?lang('AUTH_RIGHTER_USER_NAME'):'用户名' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_USER_ROLE')?lang('AUTH_RIGHTER_USER_ROLE'):'角色' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_USER_PHONE')?lang('AUTH_RIGHTER_USER_PHONE'):'电话号码' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_USER_EMAIL')?lang('AUTH_RIGHTER_USER_EMAIL'):'电子邮箱' ?></th>
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
<div id="popupedit" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?=lang('AUTH_RIGHTER_USER_CHANGE')?lang('AUTH_RIGHTER_USER_CHANGE'):'修改用户' ?></h3>
		<a href="javascript:hideEditPopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body" id="tbEditParamInfo" style="overflow-y:auto">
		<table>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_LOGIN')?lang('AUTH_RIGHTER_USER_LOGIN'):'登录名' ?></th>
				<td><input name="username" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_NAME')?lang('AUTH_RIGHTER_USER_NAME'):'用户名' ?></th>
				<td><input name="truename" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_PHONE')?lang('AUTH_RIGHTER_USER_PHONE'):'电话号码' ?></th>
				<td><input name="phone" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_EMAIL')?lang('AUTH_RIGHTER_USER_EMAIL'):'电子邮箱' ?></th>
				<td><input name="email" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_BEYOND_AGENCY')?lang('AUTH_RIGHTER_USER_BEYOND_AGENCY'):'所属机构:' ?></th>
				<td>
					<select name="JG_ID">
						<option value=""><?=lang('AUTH_LEFTER_DEFAULT')?lang('AUTH_LEFTER_DEFAULT'):'默认' ?></option>
						<?php foreach($orgInfos as $val): ?>
						<option value="<?php echo $val['JG_ID']; ?>"><?php echo $val['JG_name']; ?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_ROLE')?lang('AUTH_RIGHTER_USER_ROLE'):'角色' ?></th>
				<td>
					<select name="R_ID">
						<option value="13"><?=lang('AUTH_LEFTER_DEFAULT')?lang('AUTH_LEFTER_DEFAULT'):'默认' ?></option>
						<?php foreach($roleInfos as $val): ?>
						<option value="<?php echo $val['role_id']; ?>"><?php echo $val['role_name']; ?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_AGENCY_MAN_AUTH')?lang('AUTH_RIGHTER_USER_AGENCY_MAN_AUTH'):'机构管辖权限:' ?></th>
				<td>
					<div style="height:300px;width:300px;overflow-y:auto">
					<ul id="browser" class="filetree">
					</ul>
					</div>
				</td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_SAVA')?lang('COMMON_BOX_SAVA'):'保存' ?>&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hideEditPopbox()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_CANCEL')?lang('COMMON_BOX_CANCEL'):'取消' ?>&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>

<div id="addUser" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3>添加用户</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_LOGIN')?lang('AUTH_RIGHTER_USER_LOGIN'):'登录名' ?></th>
				<td><input name="username" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_NAME')?lang('AUTH_RIGHTER_USER_NAME'):'用户名' ?></th>
				<td><input name="truename" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_PHONE')?lang('AUTH_RIGHTER_USER_PHONE'):'电话号码' ?></th>
				<td><input name="phone" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_EMAIL')?lang('AUTH_RIGHTER_USER_EMAIL'):'电子邮箱' ?></th>
				<td><input name="email" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_PASS')?lang('AUTH_RIGHTER_USER_PASS'):'密码' ?></th>
				<td><input name="password" type="password"/></td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_REPASS')?lang('AUTH_RIGHTER_USER_REPASS'):'密码' ?></th>
				<td><input name="repassword" type="password"/></td>
			</tr>
			<tr>


				<th scope="row"><?=lang('AUTH_RIGHTER_USER_BEYOND_AGENCY')?lang('AUTH_RIGHTER_USER_BEYOND_AGENCY'):'所属于机构:' ?></th>
				<td>
					<select name="JG_ID">
						<option value=""><?=lang('AUTH_LEFTER_DEFAULT')?lang('AUTH_LEFTER_DEFAULT'):'默认' ?></option>
						<?php foreach($orgInfos as $val): ?>
						<option value="<?php echo $val['JG_ID']; ?>"><?php echo $val['JG_name']; ?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_ROLE')?lang('AUTH_RIGHTER_USER_ROLE'):'用户角色' ?></th>
				<td>
					<select name="R_ID">
						<option value="13"><?=lang('AUTH_LEFTER_DEFAULT')?lang('AUTH_LEFTER_DEFAULT'):'默认' ?></option>
						<?php foreach($roleInfos as $val): ?>
						<option value="<?php echo $val['role_id']; ?>"><?php echo $val['role_name']; ?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?=lang('AUTH_RIGHTER_USER_AGENCY_MAN_AUTH')?lang('AUTH_RIGHTER_USER_AGENCY_MAN_AUTH'):'机构管辖权限:' ?></th>
				<td>
					<div style="height:300px;width:300px;overflow-y:auto">
					<ul id="browser" class="filetree">
						
					</ul>
					</div>
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
		ID:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		$('.tbAddParamInfo #browser').treeview();
		getCommonParam();
	}
	
		// 勾选树节点时间
	function checkJgnode(elem, orgId){
		if ($(elem).attr('checked') == 'checked') 
		{
			var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getJgpid";
			$.ajax({
				type: "post",
				url: url,
				data: 'orgId='+orgId,
				success: function(data) {
					//alert(data);return;
					var pOrg = data.split(',');
					for (var idx in pOrg){
						$('input[name="org"][value="'+pOrg[idx]+'"]').attr('checked', 'checked');
					}// for
				}
			}); // ajax
			
			var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getJGcid";
			$.ajax({
				type: "post",
				url: url,
				data: 'orgId='+orgId,
				success: function(data) {
					//alert(data);return;
					var childOrgArr = data.split(",");
					for(var idx in childOrgArr) 
						$('input[name="org"][value='+childOrgArr[idx]+']').attr('checked', 'checked');
				}
			}); // ajax
		}// if
		
		//alert($(elem).attr('checked'));
		if ($(elem).attr('checked') != 'checked')
		{
			var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getJGcid";
			$.ajax({
				type: "post",
				url: url,
				data: 'orgId='+orgId,
				success: function(data) {
					//alert(data);return;
					var childOrgArr = data.split(",");
					for(var idx in childOrgArr) 
						$('input[name="org"][value='+childOrgArr[idx]+']').removeAttr('checked');
				}
			}); // ajax
		}// if
	}// func
	
	// 获取公共参数数据
	function getCommonParam(){
		hidePopbox();
		hideEditPopbox();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getUsers";
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
						  '<td class="tc"><input id="'+paramInfo.ID+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.ID+'</td>'+
						  '<td>'+paramInfo.username+'</td>'+
						  '<td>'+paramInfo.truename+'</td>'+
						  '<td>'+paramInfo.rname+'</td>'+
						  '<td>'+paramInfo.phone+'</td>'+
						  '<td>'+paramInfo.email+'</td>'+
						  //'<td>'+paramInfo.lasttime.substr(0, paramInfo.lasttime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.lrtime.substr(0, paramInfo.lrtime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		$('#addUser').css('display', 'block');
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getOrgTreeStr";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {				
				$('.tbAddParamInfo #browser').html(data);
				$('.tbAddParamInfo #browser').treeview();
			}
		}); // ajax
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('#addUser').css('display', 'none');
		$('.tbAddParamInfo').find('input[type="text"],input[type="password"],input[type="checkbox"],textarea').each(function(){
			$(this).val('');
			$(this).removeAttr('checked');
		});
	}// func
	
	function hideEditPopbox(){
		$('#popupedit').css('display', 'none');
		$('#tbEditParamInfo').find('input[type="text"],input[type="password"],input[type="checkbox"],textarea').each(function(){
			$(this).val('');
			$(this).removeAttr('checked');
		});
	}
	
	// 添加参数信息dengl
	function addParamInfo(){
		var postData = getPostData($('.tbAddParamInfo'));
		if ($('.tbAddParamInfo input[name="username"]').val() == '')
		{
			alert('<?=lang('AUTH_RIGHTER_TIP2')?lang('AUTH_RIGHTER_TIP2'):'请输入登录名：' ?>');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="truename"]').val() == '')
		{
			alert('<?=lang('AUTH_RIGHTER_TIP3')?lang('AUTH_RIGHTER_TIP3'):'请输入用户名：' ?>.');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="password"]').val() == '')
		{
			alert('<?=lang('AUTH_RIGHTER_TIP4')?lang('AUTH_RIGHTER_TIP4'):'请输入密码：' ?>');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="password"]').val() != $('.tbAddParamInfo input[name="repassword"]').val())
		{
			//alert($('.tbAddParamInfo input[name="password"]').val());
			//alert($('.tbAddParamInfo input[name="repassword"]').val());
			alert('<?=lang('AUTH_RIGHTER_TIP5')?lang('AUTH_RIGHTER_TIP5'):'请确认两次输入的密码一致：' ?>');
			return;
		}// if
		
		
		//alert(postData);return;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=addParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?=lang('AUTH_LEFTER_SUCCESS')?lang('AUTH_LEFTER_SUCCESS'):'添加成功' ?>');
					getCommonParam();
					hidePopbox();
				}
				else
					alert('<?=lang('AUTH_LEFTER_FAIL')?lang('AUTH_LEFTER_FAIL'):'添加失败' ?>');
			}
		}); // ajax
	}// func
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?=lang('AUTH_LEFTER_FAIL')?lang('AUTH_LEFTER_FAIL'):'添加失败' ?>');
			return;
		}// if
		
		paramInfo.ID = paramId;
		
		// 获取用户管辖机构
		$('#popupedit').css('display', 'block');
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getUserInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'ID='+paramId,
			success: function(data) {
				var userObj = eval('(' + data + ')');
				$('#tbEditParamInfo input[name="username"]').val(userObj.userInfo.username);
				$('#tbEditParamInfo input[name="truename"]').val(userObj.userInfo.truename);
				$('#tbEditParamInfo input[name="phone"]').val(userObj.userInfo.phone);
				$('#tbEditParamInfo input[name="email"]').val(userObj.userInfo.email);
				
				$('#tbEditParamInfo select[name="JG_ID"] > option[value="'+userObj.userInfo.JG_ID+'"]').attr('selected', 'selected');
				$('#tbEditParamInfo select[name="R_ID"] > option[value="'+userObj.R_ID+'"]').attr('selected', 'selected');
				
				$('#tbEditParamInfo #browser').html(userObj.orgTreeStr);
				$('#tbEditParamInfo #browser').treeview();
			}
		}); // ajax
		
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
		var postData = getPostData($('#tbEditParamInfo'));
		//alert(postData);return;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=saveParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.ID,
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?=lang('AUTH_LEFTER_EDIT_SUCCESS')?lang('AUTH_LEFTER_EDIT_SUCCESS'):'修改成功' ?>');
					getCommonParam();
					//$('#isEdit').val(0);
				}
				else
					alert('<?=lang('AUTH_LEFTER_EDIT_FAIT')?lang('AUTH_LEFTER_EDIT_FAIT'):'修改失败' ?>');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getCommonParam();
		//$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0) 
		{
			alert('<?=lang('AUTH_LEFTER_EDIT_FAIT')?lang('AUTH_LEFTER_EDIT_FAIT'):'请选择需要删除的项.' ?>');
			return;
		}// if
		
		if (!confirm('<?=lang('AUTH_RIGHTER_TIP6')?lang('AUTH_RIGHTER_TIP6'):'若用户为超级管理员，则无法删除，确认删除!' ?>')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=deleteParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?=lang('AUTH_LEFTER_DEL_SUCCESS')?lang('AUTH_LEFTER_DEL_SUCCESS'):'删除成功' ?>');
					getCommonParam();
				}
				else
					alert('<?=lang('AUTH_LEFTER_DEL_FAIL')?lang('AUTH_LEFTER_DEL_FAIL'):'删除失败' ?>.');
			}
		}); // ajax
	}// func
</script>
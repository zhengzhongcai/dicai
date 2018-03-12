<?php /* Smarty version Smarty-3.1.8, created on 2014-01-21 14:31:58
         compiled from "G:\WWW\cdyh\application/views\authority\righter_user.html" */ ?>
<?php /*%%SmartyHeaderCode:2079552de145e0ef9c7-84777284%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb5b7ac39a8d38792d655bee3a9bb9ce46845862' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\authority\\righter_user.html',
      1 => 1376896459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2079552de145e0ef9c7-84777284',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'AUTH_RIGHTER_USERID' => 0,
    'AUTH_RIGHTER_USER_NAME' => 0,
    'AUTH_RIGHTER_USER_LOGIN' => 0,
    'AUTH_RIGHTER_USER_ROLE' => 0,
    'AUTH_RIGHTER_USER_PHONE' => 0,
    'AUTH_RIGHTER_USER_EMAIL' => 0,
    'AUTH_RIGHTER_USER_BEYOND_AGENCY' => 0,
    'COMMON_DEFAULT' => 0,
    'orgInfos' => 0,
    'roleInfos' => 0,
    'AUTH_RIGHTER_USER_AGENCY_MAN_AUTH' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'AUTH_RIGHTER_USER_ADD' => 0,
    'AUTH_RIGHTER_USER_PASS' => 0,
    'AUTH_RIGHTER_USER_REPASS' => 0,
    'baseUrl' => 0,
    'AUTH_RIGHTER_TIP2' => 0,
    'AUTH_RIGHTER_TIP3' => 0,
    'AUTH_RIGHTER_TIP4' => 0,
    'AUTH_RIGHTER_TIP5' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'AUTH_RIGHTER_TIP6' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52de145e31ff92_46334082',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52de145e31ff92_46334082')) {function content_52de145e31ff92_46334082($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
		</div>
		<!----tool 工具条 end---->
		<script>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				$('a[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['Operation'];?>
"]').css('display', 'inline-block');
			<?php } ?>
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
						<th width="5%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USERID']->value)===null||$tmp==='' ? "ID" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_NAME']->value)===null||$tmp==='' ? "登录名" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_LOGIN']->value)===null||$tmp==='' ? "用户名" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_ROLE']->value)===null||$tmp==='' ? "角色" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_PHONE']->value)===null||$tmp==='' ? "电话号码" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_EMAIL']->value)===null||$tmp==='' ? "电子邮箱" : $tmp);?>
</th>
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
		<h3>修改用户</h3>
		<a href="javascript:hideEditPopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body" id="tbEditParamInfo" style="overflow-y:auto">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_NAME']->value)===null||$tmp==='' ? "登录名" : $tmp);?>
:</th>
				<td><input name="username" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_LOGIN']->value)===null||$tmp==='' ? "用户名" : $tmp);?>
:</th>
				<td><input name="truename" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_PHONE']->value)===null||$tmp==='' ? "电话号码" : $tmp);?>
:</th>
				<td><input name="phone" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_EMAIL']->value)===null||$tmp==='' ? "电子邮箱" : $tmp);?>
:</th>
				<td><input name="email" type="text" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_BEYOND_AGENCY']->value)===null||$tmp==='' ? "所属机构" : $tmp);?>
:</th>
				<td>
					<select name="JG_ID">
						<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orgInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['JG_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['JG_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_ROLE']->value)===null||$tmp==='' ? "角色" : $tmp);?>
:</th>
				<td>
					<select name="R_ID">
						<option value="13"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roleInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['R_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['R_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_AGENCY_MAN_AUTH']->value)===null||$tmp==='' ? "机构管辖权限" : $tmp);?>
:</th>
				<td>
					<div style="height:300px;width:300px;overflow-y:auto">
					<ul id="browser" class="filetree">
						
					</ul>
					</div>
				</td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hideEditPopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>

<div id="addUser" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_ADD']->value)===null||$tmp==='' ? "添加用户" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_NAME']->value)===null||$tmp==='' ? "登录名" : $tmp);?>
:</th>
				<td><input name="username" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_LOGIN']->value)===null||$tmp==='' ? "用户名" : $tmp);?>
:</th>
				<td><input name="truename" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_PHONE']->value)===null||$tmp==='' ? "电话号码" : $tmp);?>
:</th>
				<td><input name="phone" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_EMAIL']->value)===null||$tmp==='' ? "电子邮箱" : $tmp);?>
:</th>
				<td><input name="email" type="text"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_PASS']->value)===null||$tmp==='' ? "密码" : $tmp);?>
:</th>
				<td><input name="password" type="password"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_REPASS']->value)===null||$tmp==='' ? "重复密码" : $tmp);?>
:</th>
				<td><input name="repassword" type="password"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_BEYOND_AGENCY']->value)===null||$tmp==='' ? "所属机构" : $tmp);?>
:</th>
				<td>
					<select name="JG_ID">
						<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orgInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['JG_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['JG_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_ROLE']->value)===null||$tmp==='' ? "用户角色" : $tmp);?>
:</th>
				<td>
					<select name="R_ID">
						<option value="13"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roleInfos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['R_ID'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['R_name'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_USER_AGENCY_MAN_AUTH']->value)===null||$tmp==='' ? "机构管辖权限" : $tmp);?>
:</th>
				<td>
					<div style="height:300px;width:300px;overflow-y:auto">
					<ul id="browser" class="filetree">
						
					</ul>
					</div>
				</td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
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
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getJgpid";
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
			
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getJGcid";
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
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getJGcid";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getUsers";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getOrgTreeStr";
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
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('.tbAddParamInfo'));
		if ($('.tbAddParamInfo input[name="username"]').val() == '')
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP2']->value)===null||$tmp==='' ? "请输入登录名." : $tmp);?>
');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="truename"]').val() == '')
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP3']->value)===null||$tmp==='' ? "请输入用户名." : $tmp);?>
');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="password"]').val() == '')
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP4']->value)===null||$tmp==='' ? "请输入密码." : $tmp);?>
');
			return;
		}// if
		
		if ($('.tbAddParamInfo input[name="password"]').val() != $('.tbAddParamInfo input[name="repassword"]').val())
		{
			//alert($('.tbAddParamInfo input[name="password"]').val());
			//alert($('.tbAddParamInfo input[name="repassword"]').val());
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP5']->value)===null||$tmp==='' ? "请确认两次输入的密码一致." : $tmp);?>
');
			return;
		}// if
		
		
		//alert(postData);return;
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=addParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getCommonParam();
					hidePopbox();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if
		
		paramInfo.ID = paramId;
		
		// 获取用户管辖机构
		$('#popupedit').css('display', 'block');
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=getUserInfo";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=saveParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.ID,
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getCommonParam();
					//$('#isEdit').val(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['AUTH_RIGHTER_TIP6']->value)===null||$tmp==='' ? "若用户为超级管理员，则无法删除，确认删除!" : $tmp);?>
')) return;
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=authority&action=deleteParamInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;
				if (data == '' || typeof data == 'undefined')
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCommonParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
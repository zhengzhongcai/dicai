<?php /* Smarty version Smarty-3.1.8, created on 2015-07-25 15:41:18
         compiled from "E:\WWW\cdbank\application/views\basedata\righter_counter.html" */ ?>
<?php /*%%SmartyHeaderCode:2293855b33d9e3527a3-38822180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0968dc03a66968997f3b1109252cd50b88c9a7a' => 
    array (
      0 => 'E:\\WWW\\cdbank\\application/views\\basedata\\righter_counter.html',
      1 => 1383549424,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2293855b33d9e3527a3-38822180',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'baseUrl' => 0,
    'COMMON_DEFAULT' => 0,
    'itsOrgArr' => 0,
    'row' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'DATA_RIGHTER_COUNTER_AGENCYID' => 0,
    'DATA_RIGHTER_COUNTER_NUMBER' => 0,
    'DATA_RIGHTER_COUNTER_IP' => 0,
    'DATA_RIGHTER_COUNTER_SERIAL' => 0,
    'DATA_RIGHTER_COUNTER_ISCONTROL' => 0,
    'DATA_RIGHTER_COUNTER_POPBOX_TITLE' => 0,
    'COMMON_TEXT_YES' => 0,
    'COMMON_TEXT_NO' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_CHOOSE_ONE_TO_EDIT' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
    'COMMON_TIP_CHOOSE_DEL_ITEM' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_SUCCESS' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55b33d9e553712_48809469',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55b33d9e553712_48809469')) {function content_55b33d9e553712_48809469($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=serialParam">业务清单</a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=vipParam">VIP客户资料管理</a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=serverParam">柜员管理</a></li>
				<li><a href="javascript:void(0)" class="on">柜台管理</a></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="itsOrgId" id="itsOrgId" onchange="getCounterParam()">
				<option value=""><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEFAULT']->value)===null||$tmp==='' ? "默认" : $tmp);?>
</option>
				<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
				<?php } ?>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
		</div>
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
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbCounterPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_AGENCYID']->value)===null||$tmp==='' ? "所属机构代码" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_NUMBER']->value)===null||$tmp==='' ? "柜台号" : $tmp);?>
</th>
						<th width="25%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_IP']->value)===null||$tmp==='' ? "评价器的IP地址" : $tmp);?>
</th>
						<th width="25%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_SERIAL']->value)===null||$tmp==='' ? "业务ID序列" : $tmp);?>
</th>
						<th width="35%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_ISCONTROL']->value)===null||$tmp==='' ? "评价器是否受控" : $tmp);?>
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
<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_POPBOX_TITLE']->value)===null||$tmp==='' ? "添加柜台" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_AGENCYID']->value)===null||$tmp==='' ? "所属机构代码" : $tmp);?>
:</th>
				<td>
					<select name="C_sysno">
						<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['itsOrgArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['row']->value['sysno'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['sysname'];?>
</option>
						<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_NUMBER']->value)===null||$tmp==='' ? "柜台号" : $tmp);?>
:</th>
				<td><input name="C_no" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DATA_RIGHTER_COUNTER_ISCONTROL']->value)===null||$tmp==='' ? "评价器是否受控" : $tmp);?>
:</th>
				<td>
					<select name="C_iscontrol">
						<option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option>
						<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "否" : $tmp);?>
</option>
					</select>
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
		C_no:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		//getCounterParam();
	}
	// 获取公共参数数据
	function getCounterParam(){
		// 获取网点id
		var orgId = $('#itsOrgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=getCounterParam";
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=addCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getCounterParam();
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
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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
						$(this).html('<select name="C_iscontrol"><option value="1" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
					else
						$(this).html('<select name="C_iscontrol"><option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_YES']->value)===null||$tmp==='' ? "是" : $tmp);?>
</option><option value="0" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TEXT_NO']->value)===null||$tmp==='' ? "不是" : $tmp);?>
</option></select>');
						$(this).append('&nbsp;<input class="btn_orange" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
" onclick="resetParamInfo()">');
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
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=saveCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "&paramId=" + paramInfo.C_no,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getCounterParam();
					$('#isEdit').val(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
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
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var C_sysno = $('select[name="itsOrgId"]').val();
		//alert(C_sysno);return;
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=basedata&action=deleteCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma() + "&C_sysno="+C_sysno,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCounterParam();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
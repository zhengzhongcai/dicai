<?php /* Smarty version Smarty-3.1.8, created on 2013-08-19 16:27:20
         compiled from "G:\WWW\webmark\application/views\institution\righter_list.html" */ ?>
<?php /*%%SmartyHeaderCode:320925211d6e80255e1-35729917%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0cd3739aaec6503fc8f2dd487e9c4542071e81d6' => 
    array (
      0 => 'G:\\WWW\\webmark\\application/views\\institution\\righter_list.html',
      1 => 1376641107,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '320925211d6e80255e1-35729917',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ORG_RIGHTER_ADD_UNDER' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'ORG_RIGHTER_AGENCY_NAME' => 0,
    'ORG_RIGHTER_AGENCY_ID' => 0,
    'ORG_RIGHTER_DIRECTOR' => 0,
    'ORG_RIGHTER_PHONE' => 0,
    'ORG_RIGHTER_NODE_NAME' => 0,
    'ORG_RIGHTER_NODE_ID' => 0,
    'ORG_RIGHTER_NODE_ADDR' => 0,
    'ORG_RIGHTER_LOC_LONG' => 0,
    'ORG_RIGHTER_LOC_LAT' => 0,
    'ORG_RIGHTER_WARNNING_PHONES' => 0,
    'ORG_RIGHTER_WARNNING_EMAILS' => 0,
    'ORG_RIGHTER_COUNTER_STAFF_NUM' => 0,
    'ORG_RIGHTER_COUNTER_OPEN_NUM' => 0,
    'ORG_RIGHTER_WELCOME_AUDIO_SWITCH' => 0,
    'ORG_RIGHTER_NOT_EVA_VALUE' => 0,
    'ORG_RIGHTER_NODE_IP' => 0,
    'ORG_RIGHTER_BUS_TIME' => 0,
    'ORG_RIGHTER_WAIT_FIR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_SEC_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_THR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_EVA_BAD_FIR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_EVA_BAD_SEC_LEVEL_VAL' => 0,
    'ORG_RIGHTER_EVA_BAD_THR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_OVER_FIR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_OVER_SEC_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_OVER_THR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_HANDLE_FIR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_HANDLE_SEC_LEVEL_VAL' => 0,
    'ORG_RIGHTER_WAIT_HANDLE_THR_LEVEL_VAL' => 0,
    'ORG_RIGHTER_IS_SET_NODE' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'baseUrl' => 0,
    'ORG_RIGHTER_HIDE' => 0,
    'ORG_RIGHTER_ACTIVE' => 0,
    'ORG_RIGHTER_TIP1' => 0,
    'ORG_RIGHTER_TIP2' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'ORG_RIGHTER_TIP3' => 0,
    'COMMON_TIP_IS_DEL' => 0,
    'COMMON_TIP_DEL_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5211d6e8258779_81094847',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5211d6e8258779_81094847')) {function content_5211d6e8258779_81094847($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">  
		<input type="hidden" id="isspot">
		<!----tab 标签页---->
		<!--
		<div class="mod_tab">
			<ul>
				<li></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_ADD_UNDER']->value)===null||$tmp==='' ? "添加下属机构" : $tmp);?>
</a>
			<a auth="u" href="javascript:editOrgInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteOrgInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
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
		<input type="hidden" id="orgId"/>
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table" id="tbOrgInfo" style="display:none">
			<table>
				<tr>
					<th width="155" scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_AGENCY_NAME']->value)===null||$tmp==='' ? "机构名称" : $tmp);?>
</th>
					<td id="JG_name"></td>
				</tr>
				<tr>
					<th width="155" scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_AGENCY_ID']->value)===null||$tmp==='' ? "机构代码" : $tmp);?>
</th>
					<td id="JG_ID"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_DIRECTOR']->value)===null||$tmp==='' ? "负责人" : $tmp);?>
</th>
					<td id="JG_fzr"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_PHONE']->value)===null||$tmp==='' ? "联系电话" : $tmp);?>
</th>
					<td id="JG_phone"></td>
				</tr>
		  </table>
		</div>
		<div class="mod_table" id="tbOrgInfoChild" style="display:none">
			<table>
				<tr>
					<th width="155" scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_NODE_NAME']->value)===null||$tmp==='' ? "网点名称" : $tmp);?>
</th>
					<td id="sysname"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_NODE_ID']->value)===null||$tmp==='' ? "网点代码" : $tmp);?>
</th>
					<td id="sysno"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_NODE_ADDR']->value)===null||$tmp==='' ? "网点地址" : $tmp);?>
</th>
					<td id="sysaddress"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_LOC_LONG']->value)===null||$tmp==='' ? "地理经度" : $tmp);?>
</th>
					<td id="sysJd"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_LOC_LAT']->value)===null||$tmp==='' ? "地理纬度" : $tmp);?>
</th>
					<td id="sysWd"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WARNNING_PHONES']->value)===null||$tmp==='' ? "预警手机序列" : $tmp);?>
</th>
					<td id="sysmobile"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WARNNING_EMAILS']->value)===null||$tmp==='' ? "预警邮箱序列" : $tmp);?>
</th>
					<td id="sysmail"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_COUNTER_STAFF_NUM']->value)===null||$tmp==='' ? "柜台员工数量" : $tmp);?>
</th>
					<td id="sysGyNum"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_COUNTER_OPEN_NUM']->value)===null||$tmp==='' ? "开通柜台数量" : $tmp);?>
</th>
					<td id="sysGtNum"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WELCOME_AUDIO_SWITCH']->value)===null||$tmp==='' ? "欢迎光临语音控制开关" : $tmp);?>
</th>
					<td id="useWelvoice"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_NOT_EVA_VALUE']->value)===null||$tmp==='' ? "未评价时的评价键值" : $tmp);?>
</th>
					<td id="noMarkValue"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_NODE_IP']->value)===null||$tmp==='' ? "网点IP" : $tmp);?>
</th>
					<td id="sysIP"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_BUS_TIME']->value)===null||$tmp==='' ? "营业时间说明" : $tmp);?>
</th>
					<td id="sysYWtime"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_FIR_LEVEL_VAL']->value)===null||$tmp==='' ? "等待排队人流量1级预警临界值" : $tmp);?>
</th>
					<td id="sysWaitMax1"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_SEC_LEVEL_VAL']->value)===null||$tmp==='' ? "等待排队人流量2级预警临界值" : $tmp);?>
</th>
					<td id="sysWaitMax2"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_THR_LEVEL_VAL']->value)===null||$tmp==='' ? "等待排队人流量3级预警临界值" : $tmp);?>
</th>
					<td id="sysWaitMax3"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_EVA_BAD_FIR_LEVEL_VAL']->value)===null||$tmp==='' ? "评价很差数量1级预警临界值" : $tmp);?>
</th>
					<td id="SysPjhcMax1"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_EVA_BAD_SEC_LEVEL_VAL']->value)===null||$tmp==='' ? "评价很差数量2级预警临界值" : $tmp);?>
</th>
					<td id="SysPjhcMax2"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_EVA_BAD_THR_LEVEL_VAL']->value)===null||$tmp==='' ? "评价很差数量3级预警临界值" : $tmp);?>
</th>
					<td id="SysPjhcMax3"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_OVER_FIR_LEVEL_VAL']->value)===null||$tmp==='' ? "排队等待超时数量1级预警临界值" : $tmp);?>
</th>
					<td id="SysWaitCsMax1"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_OVER_SEC_LEVEL_VAL']->value)===null||$tmp==='' ? "排队等待超时数量2级预警临界值" : $tmp);?>
</th>
					<td id="SysWaitCsMax2"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_OVER_THR_LEVEL_VAL']->value)===null||$tmp==='' ? "排队等待超时数量3级预警临界值" : $tmp);?>
</th>
					<td id="SysWaitCsMax3"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_HANDLE_FIR_LEVEL_VAL']->value)===null||$tmp==='' ? "排队受理超时数量1级预警临界值" : $tmp);?>
</th>
					<td id="SysBlCsMax1"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_HANDLE_SEC_LEVEL_VAL']->value)===null||$tmp==='' ? "排队受理超时数量2级预警临界值" : $tmp);?>
</th>
					<td id="SysBlCsMax2"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_WAIT_HANDLE_THR_LEVEL_VAL']->value)===null||$tmp==='' ? "排队受理超时数量3级预警临界值" : $tmp);?>
</th>
					<td id="SysBlCsMax3"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_DIRECTOR']->value)===null||$tmp==='' ? "负责人" : $tmp);?>
</th>
					<td id="sys_fzr"></td>
				</tr>
				<tr>
					<th scope="row" class="tr"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_PHONE']->value)===null||$tmp==='' ? "负责人联系电话" : $tmp);?>
</th>
					<td id="sys_phone"></td>
				</tr>
		  </table>
		</div>
		<!----table 表格 end----> 
	</div>
	<!----right end----> 
</div>
<!--content end-->

<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_ADD_UNDER']->value)===null||$tmp==='' ? "添加下属机构" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
	<div class="pop_body" id="tbAddOrgInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_IS_SET_NODE']->value)===null||$tmp==='' ? "是否设为网点" : $tmp);?>
:</th>
				<td><input name="isspot" type="checkbox"/></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_AGENCY_ID']->value)===null||$tmp==='' ? "机构代码" : $tmp);?>
:</th>
				<td><input name="JG_ID" type="text" style="width:70px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_AGENCY_NAME']->value)===null||$tmp==='' ? "机构名称" : $tmp);?>
:</th>
				<td><input name="JG_name" type="text" style="width:160px" /></td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="addOrgInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
	</div>
</div>
<script>
	// 获取分行机构信息
	function getOrgInfo(orgId){
		$('#isEdit').val(0);
		$('#orgId').val(orgId);
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&action=getOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + orgId,
			success: function(data) {
				//alert(data);return;
				var infoObj = eval('(' + data + ')');
				toggleAddOrg(infoObj.isspot);
				if (infoObj.isspot > 0) displaySpotInfo(infoObj);
				else displayJgInfo(infoObj);
			}
		}); // ajax
	}// func
	
	// 是否显示添加下属机构
	function toggleAddOrg(isspot){
		$('#isspot').val(isspot);
		if (isspot > 0) $('#anchorAddOrg').css('display','none');
		else $('#anchorAddOrg').css('display','inline-block');
	}// func
	
	// 展示网点信息
	function displaySpotInfo(infoObj){
		$('#tbOrgInfo').css('display', 'none');
		$('#tbOrgInfoChild').css('display', 'block');
		// 修改侧边的高度
		$('.left_box').css('height', $('.right_box').css('height'));
		
		$('#sysno').html(infoObj.sysno);
		$('#sysname').html(infoObj.sysname);
		$('#sysaddress').html(infoObj.sysaddress);
		$('#sysJd').html(infoObj.sysJd);
		$('#sysWd').html(infoObj.sysWd);
		$('#sysmobile').html(infoObj.sysmobile);
		$('#sysmail').html(infoObj.sysmail);
		$('#sysGyNum').html(infoObj.sysGyNum);
		$('#sysGtNum').html(infoObj.sysGtNum);
		if (infoObj.useWelvoice == '0') $('#useWelvoice').html('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_HIDE']->value)===null||$tmp==='' ? "屏蔽" : $tmp);?>
');
		else $('#useWelvoice').html('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_ACTIVE']->value)===null||$tmp==='' ? "激活" : $tmp);?>
');
		$('#noMarkValue').html(infoObj.noMarkValue);
		$('#sysIP').html(infoObj.sysIP);
		$('#sysYWtime').html(infoObj.sysYWtime);
		$('#sysWaitMax1').html(infoObj.sysWaitMax1);
		$('#sysWaitMax2').html(infoObj.sysWaitMax2);
		$('#sysWaitMax3').html(infoObj.sysWaitMax3);
		$('#SysPjhcMax1').html(infoObj.SysPjhcMax1);
		$('#SysPjhcMax2').html(infoObj.SysPjhcMax2);
		$('#SysPjhcMax3').html(infoObj.SysPjhcMax3);
		$('#SysWaitCsMax1').html(infoObj.SysWaitCsMax1);
		$('#SysWaitCsMax2').html(infoObj.SysWaitCsMax2);
		$('#SysWaitCsMax3').html(infoObj.SysWaitCsMax3);
		$('#SysBlCsMax1').html(infoObj.SysBlCsMax1);
		$('#SysBlCsMax2').html(infoObj.SysBlCsMax2);
		$('#SysBlCsMax3').html(infoObj.SysBlCsMax3);
		$('#sys_fzr').html(infoObj.sys_fzr);
		$('#sys_phone').html(infoObj.sys_phone);
		$('#sys_bz').html(infoObj.sys_bz);
		$('#sys_lastUser').html(infoObj.sys_lastUser);
	}// func
	// 展示机构信息
	function displayJgInfo(infoObj){
		$('#tbOrgInfoChild').css('display', 'none');
		$('#tbOrgInfo').css('display', 'block');
		// 修改侧边的高度
		$('.left_box').css('height', $('.right_box').css('height'));
		
		$('#JG_ID').html(infoObj.JG_ID);
		$('#JG_name').html(infoObj.JG_name);
		$('#JG_fzr').html(infoObj.JG_fzr);
		$('#JG_phone').html(infoObj.JG_phone);
		//$('#JG_bz').html(infoObj.JG_bz);
		//$('#JG_lrtime').html(infoObj.JG_lrtime.substr(0, infoObj.JG_lrtime.indexOf('.')));
		//$('#JG_lasttime').html(infoObj.JG_lasttime.substr(0, infoObj.JG_lasttime.indexOf('.')));
		//$('#JG_lastUser').html(infoObj.JG_lastUser);
	}// func
	
	// 编辑机构信息
	function editOrgInfo(){
		var isEdit = $('#isEdit').val();
		if (isEdit-0) return;
		else $('#isEdit').val(1);
		var isspot = $('#isspot').val();
		if (isspot > 0)
		{
			$('#tbOrgInfoChild').find('td[id^="sys"],td[id^="Sys"],td[id="useWelvoice"],td[id="noMarkValue"]').each(function(){
				var content = $(this).html();
				switch($(this).attr('id')){
					case 'sysmobile':
					case 'sysmail':
					case 'sys_bz':
					case 'sysYwName':
						$(this).html('<textarea name="'+$(this).attr('id')+'" rows="4" cols="30">'+content+'</textarea>');
						break;
					case 'useWelvoice':
						if (content == '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_HIDE']->value)===null||$tmp==='' ? "屏蔽" : $tmp);?>
')
							$(this).html('<select name="'+$(this).attr('id')+'"><option value="0" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_HIDE']->value)===null||$tmp==='' ? "屏蔽" : $tmp);?>
</option><option value="1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_ACTIVE']->value)===null||$tmp==='' ? "激活" : $tmp);?>
</option></select>');
						else
							$(this).html('<select name="'+$(this).attr('id')+'"><option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_HIDE']->value)===null||$tmp==='' ? "屏蔽" : $tmp);?>
</option><option value="1" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_ACTIVE']->value)===null||$tmp==='' ? "激活" : $tmp);?>
</option></select>');
						break;
					case 'noMarkValue':
					default:
						$(this).html('<input type="text" name="'+$(this).attr('id')+'" value="'+content+'"/>');
						break;
				}// switch
			});
			$('#tbOrgInfoChild').find('input[type="button"]').remove();
			$('#tbOrgInfoChild').append('<input class="btn_orange" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
" onclick="saveOrgInfo()"><input class="btn_gray" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
" onclick="resetOrgInfo()">');
		}
		else
		{
			$('#tbOrgInfo').find('td[id^="JG_"]').each(function(){
				var content = $(this).html();
				if ("JG_bz" == $(this).attr('id'))$(this).html('<textarea name="'+$(this).attr('id')+'" rows="4" cols="30">'+content+'</textarea>');
				else $(this).html('<input type="text" name="'+$(this).attr('id')+'" value="'+content+'"/>');
			});
			$('#tbOrgInfo').find('input[type="button"]').remove();
			$('#tbOrgInfo').append('<input class="btn_orange" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
" onclick="saveOrgInfo()"><input class="btn_gray" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
" onclick="resetOrgInfo()">');
		}// if
		// 修改侧边的高度
		$('.left_box').css('height', $('.right_box').css('height'));
	}// func
	
	// 保存分行机构信息修改
	function saveOrgInfo(){
		var isspot = $('#isspot').val();
		var postData = '';
		if (isspot > 0) postData = getPostData($('#tbOrgInfoChild'));
		else postData = getPostData($('#tbOrgInfo'));
		
		var orgId = $('#orgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&action=saveOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "orgId=" + orgId + '&isspot=' + isspot,
			success: function(data) {
				if (data > 0)
					alert('保存成功.');
				else
					alert('保存失败.');
				
				getOrgTreeStr();
				resetOrgInfo();
			}
		}); // ajax
	}// func
	
	// 取消机构信息编辑
	function resetOrgInfo(){
		var orgId = $('#orgId').val();
		getOrgInfo(orgId);		
		// 去掉保存和删除取消按钮
		$('#tbOrgInfo').find('input[type="button"]').remove();
		$('#tbOrgInfoChild').find('input[type="button"]').remove();
		$('#isEdit').val(0);
	}// func
	
	// 添加下属机构
	function addOrgInfo(){
		// 判断是否有填写机构代码和机构名称
		var jgDm = $('input[name="JG_ID"]').val();
		var jgMc = $('input[name="JG_name"]').val();
		if ("" == jgDm) {
			alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_TIP1']->value)===null||$tmp==='' ? "请输入机构代码." : $tmp);?>
");
			return;
		}// if
		
		if ("" == jgMc) {
			alert("<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_TIP2']->value)===null||$tmp==='' ? "请输入机构名称." : $tmp);?>
");
			return;
		}// if
		
		var postData = getPostData($('#tbAddOrgInfo'));
		var orgId = $('#orgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&action=addOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "orgId=" + orgId,
			success: function(data) {
				if (data > 0)
				{
					hidePopbox();
					getOrgTreeStr();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
			}
		}); // ajax
	}// func 
	
	// 弹出添加输入框
	function showPopbox(){
		var orgId = $('#orgId').val();
		if (!(orgId != '')){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['ORG_RIGHTER_TIP3']->value)===null||$tmp==='' ? "请先选择分行." : $tmp);?>
');
			return;
		}// if
		$('.pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('#tbAddOrgInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 获取机构树形结构
	function getOrgTreeStr(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&action=getOrgTreeStr";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				$('#browser').html(data);
				$("#browser").treeview();
			}
		}); // ajax
	}// func
	
	// 删除机构
	function deleteOrgInfo(){
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		var isspot = $('#isspot').val();
		var orgId = $('#orgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=institution&action=deleteOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + orgId + '&isspot=' + isspot,
			success: function(data) {
				if (data > 0)
				{
					getOrgTreeStr();
					$('#tbOrgInfoChild').find('td').each(function(){
						$(this).html('');
					});
					$('#tbOrgInfo').find('td').each(function(){
						$(this).html('');
					});
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
</script><?php }} ?>
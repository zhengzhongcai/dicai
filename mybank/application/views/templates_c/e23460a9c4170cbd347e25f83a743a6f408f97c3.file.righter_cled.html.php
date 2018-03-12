<?php /* Smarty version Smarty-3.1.8, created on 2017-04-06 15:20:12
         compiled from "D:\bankSct2\BANK\application/views\device\righter_cled.html" */ ?>
<?php /*%%SmartyHeaderCode:3082858e5ec2c499808-08779841%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e23460a9c4170cbd347e25f83a743a6f408f97c3' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\device\\righter_cled.html',
      1 => 1490866943,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3082858e5ec2c499808-08779841',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DEVICE_RIGHTER_TOOL_CATE' => 0,
    'DEVICE_RIGHTER_TOOL_DMPJD' => 0,
    'DEVICE_RIGHTER_TOOL_PAD' => 0,
    'DEVICE_RIGHTER_TOOL_CLED' => 0,
    'DEVICE_RIGHTER_TOOL_MLED' => 0,
    'DEVICE_RIGHTER_TOOL_ADV' => 0,
    'COMMON_ADD' => 0,
    'COMMON_EDIT' => 0,
    'COMMON_DEL' => 0,
    'optArr' => 0,
    'row' => 0,
    'DEVICE_RIGHTER_MAC' => 0,
    'DEVICE_RIGHTER_CLED_ADDR' => 0,
    'DEVICE_RIGHTER_MANU' => 0,
    'DEVICE_RIGHTER_PHONE' => 0,
    'DEVICE_RIGHTER_DIRECTOR' => 0,
    'DEVICE_RIGHTER_REMARK' => 0,
    'DEVICE_RIGHTER_CLED_POPBOX_TITLE' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CANCEL' => 0,
    'DEVICE_RIGHTER_CLED_UPDATE_POPBOX_TITLE' => 0,
    'DEVICE_RIGHTER_ORG' => 0,
    'orgTreeStrRadio' => 0,
    'tabs' => 0,
    'orgId' => 0,
    'baseUrl' => 0,
    'DEVICE_RIGHTER_CLED_TIP1' => 0,
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
  'unifunc' => 'content_58e5ec2c6029c7_81620848',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58e5ec2c6029c7_81620848')) {function content_58e5ec2c6029c7_81620848($_smarty_tpl) {?>	<input id="orgId" type="hidden"/>
	<input id="device_key" type="hidden" value="cled"/>
	<!----right---->
	<div class="right_box">
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->

		<div class="mob_tool">
			<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_CATE']->value)===null||$tmp==='' ? "设备类型" : $tmp);?>
:</span>
			<select id="deviceType" name="deviceType" onchange="changeDevice()">
				<option value="Dmpdj"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_DMPJD']->value)===null||$tmp==='' ? "排队机" : $tmp);?>
</option>
				<option value="Pad"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_PAD']->value)===null||$tmp==='' ? "呼叫器" : $tmp);?>
</option>
				<option value="Cled" selected><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_CLED']->value)===null||$tmp==='' ? "窗口LED" : $tmp);?>
</option>
				<option value="Mled"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_MLED']->value)===null||$tmp==='' ? "主LED" : $tmp);?>
</option>
				<option value="Adv"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_TOOL_ADV']->value)===null||$tmp==='' ? "广告机" : $tmp);?>
</option>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_ADD']->value)===null||$tmp==='' ? "添加" : $tmp);?>
</a>
			<a auth="u" href="javascript:editDeviceInfo()" class="tool_edit statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_EDIT']->value)===null||$tmp==='' ? "编辑" : $tmp);?>
</a>
			<a auth="d" href="javascript:deleteDeviceInfo()" class="tool_del statItem"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_DEL']->value)===null||$tmp==='' ? "删除" : $tmp);?>
</a>
			上线:<b id="onlineCledTotal">0</b>台&nbsp;&nbsp;
			未上线:<b id="unlineCledTotal">0</b>台&nbsp;&nbsp;
			总计:<b id="cledTotal">0</b>台&nbsp;&nbsp;
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
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbDevice">
				<thead id="default_header">
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MAC']->value)===null||$tmp==='' ? "MAC地址" : $tmp);?>
</th>
						<th width="20%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_ADDR']->value)===null||$tmp==='' ? "地址" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MANU']->value)===null||$tmp==='' ? "制造商" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_PHONE']->value)===null||$tmp==='' ? "联系电话" : $tmp);?>
</th>
						<th width="10%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_DIRECTOR']->value)===null||$tmp==='' ? "负责人" : $tmp);?>
</th>
						<th width="25%"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_REMARK']->value)===null||$tmp==='' ? "备注" : $tmp);?>
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
<div id="cled_pop_box" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_POPBOX_TITLE']->value)===null||$tmp==='' ? "添加窗口LED" : $tmp);?>
</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MAC']->value)===null||$tmp==='' ? "MAC地址" : $tmp);?>
:</th>
				<td><input name="cLed_mac" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_ADDR']->value)===null||$tmp==='' ? "地址" : $tmp);?>
:</th>
				<td><input name="cLed_addr" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MANU']->value)===null||$tmp==='' ? "制造商" : $tmp);?>
:</th>
				<td><input name="cled_zzsname" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_PHONE']->value)===null||$tmp==='' ? "联系电话" : $tmp);?>
:</th>
				<td><input name="cled_zzsPhone" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_DIRECTOR']->value)===null||$tmp==='' ? "负责人" : $tmp);?>
:</th>
				<td><input name="cled_fze" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_REMARK']->value)===null||$tmp==='' ? "备注" : $tmp);?>
:</th>
				<td><textarea name="cled_bz" rows="4" cols="30"></textarea></td>
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
	<div id="cled_update_box" class="pop_box" style="display:none">
		<div class="pop_title">
			<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_UPDATE_POPBOX_TITLE']->value)===null||$tmp==='' ? "窗口LED信息更新" : $tmp);?>
</h3>
			<a href="javascript:hidePopbox()" class="pop_close"></a>
		</div>
		<div class="pop_body tbAddParamInfo">
			<table>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MAC']->value)===null||$tmp==='' ? "MAC地址" : $tmp);?>
:</th>
					<td><input disabled id="update_cLed_mac" name="cLed_mac" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_ADDR']->value)===null||$tmp==='' ? "地址" : $tmp);?>
:</th>
					<td><input id="update_cLed_addr" name="cLed_addr" type="number" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_MANU']->value)===null||$tmp==='' ? "制造商" : $tmp);?>
:</th>
					<td><input id="update_cled_zzsname" name="cled_zzsname" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_PHONE']->value)===null||$tmp==='' ? "联系电话" : $tmp);?>
:</th>
					<td><input id="update_cled_zzsPhone" name="cled_zzsPhone" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_DIRECTOR']->value)===null||$tmp==='' ? "负责人" : $tmp);?>
:</th>
					<td><input id="update_cled_fze" name="cled_fze" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_ORG']->value)===null||$tmp==='' ? "机构" : $tmp);?>
:</th>
					<td>
					<ul id="cled_rr" class="filetree treeview">
						<?php echo $_smarty_tpl->tpl_vars['orgTreeStrRadio']->value;?>

					</ul>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_REMARK']->value)===null||$tmp==='' ? "备注" : $tmp);?>
:</th>
					<td><textarea id="update_cled_bz" name="cled_bz" rows="4" cols="30"></textarea></td>
				</tr>
			</table>
			<div class="pop_foot">
				<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
&nbsp;&nbsp;" class="btn_orange" />
				<input onclick="resetParamInfo()" type="button" value="&nbsp;&nbsp;<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
&nbsp;&nbsp;" class="btn_gray" />&nbsp;
			</div>
		</div>
	</div>
<script>
	var tabInfos = new Object();
	window.onload = function(){
		var tabs = '<?php echo $_smarty_tpl->tpl_vars['tabs']->value;?>
';
		var orgId = '<?php echo $_smarty_tpl->tpl_vars['orgId']->value;?>
';
		if ('' != tabs){
		var parts = tabs.split(',');
			for(var idx in parts){
				getDeviceInfo(parts[idx]);
			}//for
		}
		$("#cled_rr").treeview(
				{collapsed: true,}
		);
		/*$('#tt').treegrid({
			//url:'get_data.php',
			idField:'id',
			treeField:'name',
			columns:[[
				{title:'Task Name',field:'name',width:180},
				{field:'data',title:$("#default_header").html(),width:60,align:'right'},
			]]
		});*/
		//getDeviceInfo('<?php echo $_smarty_tpl->tpl_vars['orgId']->value;?>
');
		//tabChange(orgId);
	}
	
	// 查看其它类型的设备
	function changeDevice(){
		// 获取已经存在的标签信息
		var tabArr = new Array();
		var i=0;
		$('.mod_tab>ul').children('li').each(function(){
			var parts = $(this).attr('id').split('_');
			tabArr[i] = parts[1];
			i++;
		});
		var orgId = $('#orgId').val();
		var device = $('#deviceType').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=get"+device+'List&fcode=device&orgId='+orgId+'&tabs='+tabArr.join(',').trimcomma();
		var url1 = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&fcode=device&type="+device;
		if ('' != tabArr.join(',').trimcomma())
			location.href=url;
		else
			location.href=url1;
	}// func

	// 获取网点设备基本信息
	function getDeviceInfo(orgId){
		addOrgTab(orgId);
		// 保存网点信息
		$('#orgId').val(orgId);
		// 异步获取网点数据
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=getOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			success: function(data) {
				var orgInfo = eval('(' + data + ')');
				$('#tab_'+orgId+'>span').html(orgInfo.JG_name);
				tabChange(orgId);
			}
		}); // ajax
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		$('#cled_pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],input[type="number"],textarea').each(function(){
			$(this).val('');
		});
		getCledInfos();
	}// func
	
	// 添加参数信息
	function addParamInfo(){
		var orgId = $('#orgId').val();
		if(isNaN($('input[name="cLed_addr"]').val()) || parseInt($('input[name="cLed_addr"]').val())>999){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['DEVICE_RIGHTER_CLED_TIP1']->value)===null||$tmp==='' ? "呼叫器地址必须为数值，且不大于999" : $tmp);?>
');
			return;
		}
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=addCledInfo";
		$.ajax({
			type: "post",
			url: url,
			dataType:'json',
			data: postData+'orgId='+orgId,
			success: function(result) {
				if (result.state) {
					alert(result.info);
					getCledInfos();
					hidePopbox();
				} else {
					alert(result.info);
				}
			}
			/*success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					getCledInfos();
					hidePopbox();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
			}*/
		}); // ajax
	}// func
	
	// 添加网点标签
	function addOrgTab(orgId){
		// 找出是否存在该网点标签
		var isExists = false;
		$('.mod_tab > ul').children('li').each(function (){
			if (('tab_'+orgId) == $(this).attr('id')) isExists = true;
		});
		// 不存在该网点的标签则添加
		if (false == isExists) $('.mod_tab>ul').append('<li id="tab_'+orgId+'" class="on"><span onclick="tabChange(\''+orgId+'\')"></span><a onclick="tabDelete(\''+orgId+'\')" class="tab_close"></a></li>');
	}// func
	
	// 切换激活标签，并找出网点数据
	function tabChange(orgId){
		$('#tab_'+orgId).parent().children("li").each(function(){
			$(this).removeClass('on');
		});
		$('#tab_'+orgId).addClass('on');
		
		// 找出默认的设备类型，并显示其列表
		$('#orgId').val(orgId);
		getCledInfos();
	}// func
	
	// 删除标签，并将上一标签的内容显示出来
	function tabDelete(orgId){
		var activeId = $('#tab_'+orgId).prev().attr('id');
		if ("on" == $('#tab_'+orgId).attr('class') && typeof activeId != "undefined"){
			var parts = activeId.split('_');
			tabChange(parts[1]);
		}
		else if (typeof activeId == "undefined") {
			activeId = $('#tab_'+orgId).next().attr('id');
			if (typeof activeId != "undefined"){
				var parts = activeId.split('_');
				tabChange(parts[1]);
			}// if
			else $('#tbDevice > tbody').html('');
		}// if
		$('#tab_'+orgId).remove();
		// 找出需要显示的标签和将要显示的标签
	}// func
	
	// 根据设备类型和网点id找出设备的列表
	function getCledInfos(){
		var deviceStr = "";
		var orgId = $('#orgId').val();
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=getCledInfos";
		$.ajax({
			type: "post",
			url: url,
			dataType:'json',
			data: 'orgId='+orgId,
			success: function(data) {
				var tables={};
				$('#tbDevice > tbody').html('');
				//var deviceObjs = eval('(' + data + ')');
				var deviceObjs = data;
				var jgHash={};
				var i=0;
				var jgArr=[];
				for (var idx in deviceObjs){
					var sysno=deviceObjs[idx].cLed_sysno;
					if (tables[sysno]==undefined){
						//tables[deviceObjs[idx].cLed_sysno]='<tr><td colspan="7">'+deviceObjs[idx].JG_name+'</td></tr>';
						tables[sysno]={};
						tables[sysno].rows=0;
						tables[sysno].str=[];
						jgHash[sysno]=deviceObjs[idx].JG_name;
						jgArr.push(sysno);
						i++;
					}
					tables[sysno].str.push(generateDevice(deviceObjs[idx]));
					tables[sysno].rows++;
					//deviceStr += generateDevice(deviceObjs[idx]);
				}// for
				if (i>1) {
					jgArr.sort();
					//for (var idx in tables) {
					for (var x in jgArr) {
						var idx=jgArr[x];
						var gStr='<tr><td colspan="2">' +
								'<input onclick="hideGroup(this,'+"\'"+idx+"\'"+')" type="button" value="&nbsp;&nbsp;收起&nbsp;&nbsp;" class="btn_gray">'+
								jgHash[idx] +
								'</td>'+
								'<td colspan="5" > <div style="float:left; display:inline;">' +
								'<div style="float:right; display:inline;" id="pn_'+idx+'" class="M-box1"></div>'+
								'</div></td>'+
								'</td></tr>';
						if ($('#orgId').val()==idx){
							$('#tbDevice > tbody').append(gStr + tables[idx].str);
						}else {
							$('#tbDevice > tbody').append(gStr + tables[idx].str);
						}
					$('#pn_'+idx).pagination({
						totalData:tables[idx].rows,
						showData:10,
						coping:true,
						select:'.cled_'+idx,
						callback:function(api) {
							var curPage = api.getCurrent();
							var begin = (curPage - 1) * 10;//起始记录号
							var end = begin + 10;
							var select=this.select;
							tableShow(select,begin,end);
						}
					});
					$('.cled_'+idx).hide();
					$('.cled_'+idx).each(function(i,e){
							if(i<10)//显示第page页的记录
							{
								$(this).show();
							}
						});
					}
				} else {
					for (var idx in tables) {
						var gStr='<tr><td colspan="2">' +
								'<input onclick="hideGroup(this,'+"\'"+idx+"\'"+')" type="button" value="&nbsp;&nbsp;收起&nbsp;&nbsp;" class="btn_gray">'+
								jgHash[idx] +
								'</td>'+
								'<td colspan="5" > <div style="float:left; display:inline;">' +

								'<div style="float:right; display:inline;" id="pn_'+idx+'" class="M-box1"></div>'+
								'</div></td>'+
								'</td></tr>';
						$('#tbDevice > tbody').append(tables[idx].str+gStr);
						$('#pn_'+idx).pagination({
							totalData:tables[idx].rows,
							showData:10,
							coping:true,
							callback:function(api) {
								var curPage = api.getCurrent();
								var begin = (curPage - 1) * 10;//起始记录号
								var end = begin + 10;
								var select='.cled_'+idx;
								tableShow(select,begin,end);
							}
						});
						$('.cled_'+idx).hide();
						$('.cled_'+idx).each(function(i,e){
							if(i<10)//显示第page页的记录
							{
								$(this).show();
							}
						});
					}
				}

			}
		}); // ajax
	}// func

	function tableShow(select,begin,end){
		$(select).hide();
		$(select).each(function(i,e){
			if(i>=begin && i<end)//显示第page页的记录
			{
				$(e).show();
			}
		});
	}

	// 生成一行设备信息记录
	function generateDevice(deviceInfo){
		var paramStr = '<tr class="cled_'+deviceInfo.cLed_sysno+'">'+
						  '<td class="tc"><input id="'+deviceInfo.cLed_mac+'"  cLed_sysno="'+deviceInfo.cLed_sysno+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+deviceInfo.cLed_mac+'</td>'+
						  '<td>'+deviceInfo.cLed_addr+'</td>'+
						  '<td>'+deviceInfo.cled_zzsname+'</td>'+
						  '<td>'+deviceInfo.cled_zzsPhone+'</td>'+
						  '<td>'+deviceInfo.cled_fze+'</td>'+
						  '<td>'+deviceInfo.cled_bz+'</td>'+
						  //'<td>'+deviceInfo.cled_lrtime.substr(0, deviceInfo.cled_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+deviceInfo.cled_lasttime.substr(0, deviceInfo.cled_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func

	function hideGroup(btn,jgId){
		var selecter='.cled_'+jgId;
		var pn='#pn_'+jgId;
		var btnValue=$(btn).val();
		if (btnValue.match('收起')){
			$(btn).attr('value','  展开  ');
			$(selecter).hide();
		} else {
			$(btn).attr('value','  收起  ');
			var curPage=$(pn+' span').text();
			var begin = (curPage - 1) * 10;//起始记录号
			var end = begin + 10;
			tableShow(selecter,begin,end);
		}
	}
	
	var paramInfo = {
		cLed_mac:"",
		cLed_addr:"",
		cled_zzsname:"",
		cled_zzsPhone:"",
		cled_fze:"",
		cled_bz:""
	};// 修改前保存参数原始信息
	
	// 修改设备数据
	function editDeviceInfo(){
		var checkedCnt = 0;
		var paramId;
		var cLed_sysno;
		$('#tbDevice').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					paramId = $(this).attr('id');
					cLed_sysno = $(this).attr('cLed_sysno');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_ONE_TO_EDIT']->value)===null||$tmp==='' ? "请选择其中一个进行编辑." : $tmp);?>
');
			return;
		}// if

		//var isEdit = $('#isEdit').val();
		//if (isEdit-0) return;
		//else $('#isEdit').val(1);
		$('#cled_update_box').show();
		$("input[name='org_radio'][value="+cLed_sysno+"]").attr("checked",true);
		var i = 1;
		$('#'+paramId).parent().nextAll().each(function(){
			var content = $(this).html();
			switch (i){
				case 1:
					paramInfo.cLed_mac = content;
					//$(this).html('<input type="text"  disabled name="cLed_mac" value="'+content+'"/>');
					$("#update_cLed_mac").val(content);
					break;
				case 2:
					paramInfo.cLed_addr = content;
					//$(this).html('<input type="text" name="cLed_addr" value="'+content+'"/>');
					$("#update_cLed_addr").val(content);
					break;
				case 3:
					paramInfo.cled_zzsname = content;
					//$(this).html('<input type="text" name="cled_zzsname" value="'+content+'"/>');
					$("#update_cled_zzsname").val(content);
					break;
				case 4:
					paramInfo.cled_zzsPhone = content;
				//	$(this).html('<input type="text" name="cled_zzsPhone" value="'+content+'"/>');
					$("#update_cled_zzsPhone").val(content);
					break;
				case 5:
					paramInfo.cled_fze = content;
				//	$(this).html('<input type="text" name="cled_fze" value="'+content+'"/>');
					$("#update_cled_fze").val(content);
					break;
				case 6:
					paramInfo.cled_bz = content;
					//$(this).html('<textarea name="cled_bz" rows="4" cols="40">'+content+'</textarea>'+'&nbsp;<input class="btn_orange" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CANCEL']->value)===null||$tmp==='' ? "取消" : $tmp);?>
" onclick="resetParamInfo()">');
					$("#update_cled_bz").val(content);
					break;
			}// switch
			i++;
		});
	}// func
	
	// 保存设备的修改
	function saveParamInfo(){
		var orgId = $('#orgId').val();
		var updateOrgId=$("input[name='org_radio']:checked").val();
		//var postData = getPostData($('#tbDevice'));
		var postData = getPostData($('#cled_update_box .tbAddParamInfo'));

		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=saveCledInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.cLed_mac + '&orgId='+updateOrgId,
			success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					getCledInfos();
					//$('#isEdit').val(0);
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
			}
		}); // ajax
	}// func
	
	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbDevice').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbDevice').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		var orgId = $('#orgId').val();
		$('#cled_update_box').hide();
		getCledInfos();
		//$('#isEdit').val(0);
	}// func
	
	// 删除设备
	function deleteDeviceInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbDevice').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_CHOOSE_DEL_ITEM']->value)===null||$tmp==='' ? "请选择需要删除的项." : $tmp);?>
');
			return;
		}// if
		
		if (!confirm('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_IS_DEL']->value)===null||$tmp==='' ? "确认删除!" : $tmp);?>
')) return;
		
		var orgId = $('#orgId').val();
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=device&action=deleteCledInfo";
		$.ajax({
			type: "post",
			url: url,
			dataType:'json',
			data: "params=" + deleteItemArr.join(',').trimcomma()+'&orgId='+orgId,
			success: function(result) {
				if (result.state) {
					alert(result.info);
					getCledInfos();
				} else {
					alert(result.info);
				}
			}
			/*success: function(data) {
				if (data > 0)
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_SUCCESS']->value)===null||$tmp==='' ? "删除成功." : $tmp);?>
');
					getCledInfos();
				}
				else
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_DEL_FAILED']->value)===null||$tmp==='' ? "删除失败." : $tmp);?>
');
			}*/
		}); // ajax
	}// func
</script><?php }} ?>
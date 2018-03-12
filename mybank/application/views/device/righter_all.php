	<input id="orgId" type="hidden"/>
	<input id="device_key" type="hidden" value="all"/>
	<!----right---->
	<div class="right_box">  
		<!----tab 标签页---->
		<div class="mod_tab">
			<ul></ul>
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<span>设备类型:</span>
			<select id="deviceType" name="deviceType" onchange="changeDevice()">
				<option value="All" selected>全部</option>
				<option value="Dmpdj">排队机</option>
				<option value="Pad">呼叫器</option>
				<option value="Cled">窗口LED</option>
				<option value="Mled">主LED</option>
				<option value="Adv">广告机</option>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem">添加</a>
			<a auth="u" href="javascript:editDeviceInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteDeviceInfo()" class="tool_del statItem">删除</a>
			上线:<b id="onlinePadTotal">0</b>台&nbsp;&nbsp;
			未上线:<b id="unlinePadTotal">0</b>台&nbsp;&nbsp;
			总计:<b id="padTotal">0</b>台&nbsp;&nbsp;
		</div>
		<!----tool 工具条 end---->
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
			<?foreach ($session['optArr'] as $k=>$v){?>
				$('a[auth="<? echo $v['Operation']?>"]').css('display', 'inline-block');
			<?}?>
		</script>
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbDevice">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">MAC/APPKEY/CODE</th>
						<th width="20%">IP地址</th>
						<th width="10%">设备类型</th>
						<th width="10%">设备状态</th>
						<th width="25%">备注</th>
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
<div id="all_pop_box" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3>添加呼叫器</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">MAC地址:</th>
				<td><input name="PAD_mac" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">呼叫器地址:</th>
				<td><input name="PAD_addr" type="number" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">制造商:</th>
				<td><input name="PAD_zzsname" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">联系电话:</th>
				<td><input name="PAD_zzsPhone" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">负责人:</th>
				<td><input name="PAD_fze" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">备注:</th>
				<td><textarea name="PAD_bz" rows="4" cols="30"></textarea></td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
	<div id="pad_update_box" class="pop_box" style="display:none">
		<div class="pop_title">
			<h3>添加呼叫器</h3>
			<a href="javascript:hidePopbox()" class="pop_close"></a>
		</div>
		<div class="pop_body tbAddParamInfo">
			<table>
				<tr>
					<th scope="row">MAC地址:</th>
					<td><input disabled id="update_PAD_mac" name="PAD_mac" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row">呼叫器地址:</th>
					<td><input id="update_PAD_addr"  name="PAD_addr" type="number" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row">制造商:</th>
					<td><input id="update_PAD_zzsname"  name="PAD_zzsname" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row">联系电话:</th>
					<td><input  id="update_PAD_zzsPhone" name="PAD_zzsPhone" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row">负责人:</th>
					<td><input  id="update_PAD_fze" name="PAD_fze" type="text" style="width:160px" /></td>
				</tr>
				<tr>
					<th scope="row">机构:</th>
					<td>
						<ul id="pad_rr" class="filetree treeview">
							<? ECHO $session['orgTreeStrRadio']?>
						</ul>
					</td>
				</tr>
				<tr>
					<th scope="row">备注:</th>
					<td><textarea  id="update_PAD_bz" name="PAD_bz" rows="4" cols="30"></textarea></td>
				</tr>
			</table>
			<div class="pop_foot">
				<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
				<input onclick="resetParamInfo()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
			</div>
		</div>
	</div>
<script>
	var tabInfos = new Object();
	window.onload = function(){
		var tabs = '<?echo $tabs?>';
		var orgId = '<?echo $orgId?>';
		if ('' != tabs){
		var parts = tabs.split(',');
			for(var idx in parts){
				getDeviceInfo(parts[idx]);
			}//for
		}
		$("#pad_rr").treeview({collapsed: true,});
		//getDeviceInfo('<{$orgId}>');
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=get"+device+'List&fcode=device&orgId='+orgId+'&tabs='+tabArr.join(',').trimcomma();
		var url1 = "<?php echo $session['baseurl']; ?>/index.php?control=device&fcode=device&type="+device;
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=getOrgInfo";
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
		$('#all_pop_box').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],input[type="number"],textarea').each(function(){
			$(this).val('');
		});
		getPadInfos();
	}// func
	
	// 添加参数信息
	function addParamInfo(){
		var orgId = $('#orgId').val();
		if(isNaN($('input[name="PAD_addr"]').val()) || parseInt($('input[name="PAD_addr"]').val())>999){
			alert('<{$DEVICE_RIGHTER_PAD_TIP1|default:"呼叫器地址必须为数值，且不大于999"}>');
			return;
		}
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=addPadInfo";
		$.ajax({
			type: "post",
			url: url,
			dataType:'json',
			data: postData+'orgId='+orgId,
			success: function(result) {
				if (result.state) {
					alert(result.info);
					getPadInfos();
					hidePopbox();
				} else {
					alert(result.info);
				}
			}
			/*success: function(data) {
				if (data > 0)
				{
					alert('<{$COMMON_TIP_SAVE_SUCCESS|default:"添加成功."}>');
					getPadInfos();
					hidePopbox();
				}
				else
					alert('<{$COMMON_TIP_SAVE_FAILED|default:"添加失败."}>');
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
		getPadInfos();
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
	function getPadInfos(){
		var deviceStr = "";
		var orgId = $('#orgId').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=getAllInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			dataType:'json',
			success: function(data) {
				var tables={};
				$('#tbDevice > tbody').html('');
				var deviceObjs = data;
				var jgHash={};
				var i=0;
				var jgArr=[];
				var device_key=$('#device_key').val();
				for (var idx in deviceObjs){
					var sysno=deviceObjs[idx].sysno;
					if (tables[sysno]==undefined){
						tables[sysno]={};
						tables[sysno].rows=0;
						tables[sysno].str=[];
						jgHash[sysno]=deviceObjs[idx].JG_name;
						jgArr.push(sysno);
						i++;
					}
					tables[sysno].str.push(generateDevice(deviceObjs[idx]));
					tables[sysno].rows++;
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
							$('#tbDevice > tbody').prepend(gStr + tables[idx].str);
						}else {
							$('#tbDevice > tbody').append(gStr + tables[idx].str);
						}
						$('#pn_'+idx).pagination({
							totalData:tables[idx].rows,
							showData:10,
							coping:true,
							select:'.'+device_key+'_'+idx,
							callback:function(api) {
								var curPage = api.getCurrent();
								var begin = (curPage - 1) * 10;//起始记录号
								var end = begin + 10;
								var select=this.select;
								tableShow(select,begin,end);
							}
						});
						$('.'+device_key+'_'+idx).hide();
						$('.'+device_key+'_'+idx).each(function(i,e){
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
								var select='.'+device_key+'_'+idx;
								tableShow(select,begin,end);
							}
						});
						$('.'+device_key+'_'+idx).hide();
						$('.'+device_key+'_'+idx).each(function(i,e){
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
	function hideGroup(btn,jgId){
		var device_key=$('#device_key').val();
		var selecter='.'+device_key+'_'+jgId;
		var pn='#pn_'+jgId;
		var btnValue=$(btn).val();
		if (btnValue.match('收起')){
			$(btn).attr('value','  展开  ');
			$(selecter).hide();
		} else {
			$(btn).attr('value','  收起  ');
			var curPage=$(pn+' span').text().replace(/\./g, "");
			var begin = (curPage - 1) * 10;//起始记录号
			var end = begin + 10;
			tableShow(selecter,begin,end);
		}
	}

	// 生成一行设备信息记录
	function generateDevice(deviceInfo){
		var device_key=$('#device_key').val();
		var paramStr = '<tr class="'+device_key+'_'+deviceInfo.sysno+'">'+
						  '<td class="tc"><input id="'+deviceInfo.deviceKey+'" sysno="'+deviceInfo.sysno+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+deviceInfo.deviceKey+'</td>'+
						  '<td>'+deviceInfo.addr+'</td>'+
						  '<td>'+deviceInfo.deviceType+'</td>'+
						  '<td>'+'0'+'</td>'+
						  '<td>'+deviceInfo.bz+'</td>'+
						  //'<td>'+deviceInfo.PAD_lrtime.substr(0, deviceInfo.PAD_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+deviceInfo.PAD_lasttime.substr(0, deviceInfo.PAD_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	var paramInfo = {
		PAD_mac:"",
		PAD_addr:"",
		PAD_zzsname:"",
		PAD_zzsPhone:"",
		PAD_fze:"",
		PAD_bz:""
	};// 修改前保存参数原始信息
	
	// 修改设备数据
	function editDeviceInfo(){
		var checkedCnt = 0;
		var paramId;
		var PAD_sysno;
		$('#tbDevice').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					paramId = $(this).attr('id');
					PAD_sysno= $(this).attr('PAD_sysno');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		
		/*var isEdit = $('#isEdit').val();
		if (isEdit-0) return;
		else $('#isEdit').val(1);*/
		$('#pad_update_box').show();
		$("input[name='org_radio'][value="+PAD_sysno+"]").attr("checked",true);
		var i = 1;
		$('#'+paramId).parent().nextAll().each(function(){
			var content = $(this).html();
			switch (i){
				case 1:
					paramInfo.PAD_mac = content;
				//	$(this).html('<input type="text" disabled name="PAD_mac" value="'+content+'"/>');
					$('#update_PAD_mac').val(content);
					break;
				case 2:
					paramInfo.PAD_addr = content;
					//$(this).html('<input type="text" name="PAD_addr" value="'+content+'"/>');
					$('#update_PAD_addr').val(content);
					break;
				case 3:
					paramInfo.PAD_zzsname = content;
					//$(this).html('<input type="text" name="PAD_zzsname" value="'+content+'"/>');
					$('#update_PAD_zzsname').val(content);
					break;
				case 4:
					paramInfo.PAD_zzsPhone = content;
					//$(this).html('<input type="text" name="PAD_zzsPhone" value="'+content+'"/>');
					$('#update_PAD_zzsPhone').val(content);
					break;
				case 5:
					paramInfo.PAD_fze = content;
					//$(this).html('<input type="text" name="PAD_fze" value="'+content+'"/>');
					$('#update_PAD_fze').val(content);
					break;
				case 6:
					paramInfo.PAD_bz = content;
					//$(this).html('<textarea name="PAD_bz" rows="4" cols="40">'+content+'</textarea>'+'&nbsp;<input class="btn_orange" type="button" value="<{$COMMON_BOX_SAVA|default:"保存"}>" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="<{$COMMON_BOX_CANCEL|default:"取消"}>" onclick="resetParamInfo()">');
					$('#update_PAD_bz').val(content);
					break;
			}// switch
			i++;
		});
	}// func
	
	// 保存设备的修改
	function saveParamInfo(){
		var orgId = $('#orgId').val();
		//var postData = getPostData($('#tbDevice'));
		var postData = getPostData($('#pad_update_box .tbAddParamInfo'));
		var org_radio_val=$("input[name='org_radio']:checked").val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=device&action=savePadInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.PAD_mac + '&orgId='+orgId+'&new_sysno='+org_radio_val,
			success: function(data) {
				if (data > 0)
				{
					alert('修改成功.');
					getPadInfos();
					$('#isEdit').val(0);
				}
				else
					alert('修改失败.');
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
		$('#pad_update_box').hide();
		getPadInfos();
		$('#isEdit').val(0);
	}// func
	
	// 删除设备
	function deleteDeviceInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbDevice').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}// if
		});
		
		if (deleteItemArr.length == 0)
		{
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var orgId = $('#orgId').val();
		
		var url = "<{$baseUrl}>/index.php?control=device&action=deletePadInfo";
		$.ajax({
			type: "post",
			url: url,
			dataType:'json',
			data: "params=" + deleteItemArr.join(',').trimcomma()+'&orgId='+orgId,
			success: function(result) {
				if (result.state) {
					alert(result.info);
					getPadInfos();
				} else {
					alert(result.info);
				}
			}
			/*success: function(data) {
				if (data > 0)
				{
					alert('<{$COMMON_TIP_DEL_SUCCESS|default:"删除成功."}>');
					getPadInfos();
				}
				else
					alert('<{$COMMON_TIP_DEL_FAILED|default:"删除失败."}>');
			}*/
		}); // ajax
	}// func
</script>
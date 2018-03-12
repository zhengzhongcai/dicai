	<!----right---->
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
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem">添加下属机构</a>
			<a auth="u" href="javascript:editOrgInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteOrgInfo()" class="tool_del statItem">删除</a>
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
			//	$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
			//<{/foreach}>
			<?foreach ($session['optArr'] as $k=>$v){?>
			$('a[auth="<? echo $v['Operation']?>"]').css('display', 'inline-block');
			<?}?>
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="orgId"/>
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table" id="tbOrgInfo" style="display:none">
			<table>
				<tr>
					<th width="155" scope="row" class="tr">机构名称</th>
					<td id="JG_name"></td>
				</tr>
				<tr>
					<th width="155" scope="row" class="tr">机构代码</th>
					<td id="JG_ID"></td>
				</tr>
				<tr>
					<th scope="row" class="tr">负责人</th>
					<td id="JG_fzr"></td>
				</tr>
				<tr>
					<th scope="row" class="tr">联系电话</th>
					<td id="JG_phone"></td>
				</tr>
		  </table>
		</div>
		<div class="mod_table" id="tbOrgInfoChild" style="display:none">
			<table>
				<tr>
					<th width="155" scope="row" class="tr">网点名称</th>
					<td id="sysname" width="155"></td>

					<th width="155" scope="row" class="tr">网点代码</th>
					<td id="sysno" width="155"></td>
					<th width="155"scope="row" class="tr">网点地址</th>
					<td id="sysaddress" width="155"></td>
				</tr>

				<tr>
					<th scope="row" class="tr">地理经度</th>
					<td id="sysJd"></td>

					<th scope="row" class="tr">地理纬度</th>
					<td id="sysWd"></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th scope="row" class="tr">预警手机序列</th>
					<td id="sysmobile"></td>

					<th scope="row" class="tr">预警邮箱序列</th>
					<td id="sysmail"></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th scope="row" class="tr">柜台员工数量</th>
					<td id="sysGyNum"></td>

					<th scope="row" class="tr">开通柜台数量</th>
					<td id="sysGtNum"></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th scope="row" class="tr">欢迎光临语音控制开关</th>
					<td id="useWelvoice"></td>

					<th scope="row" class="tr">未评价时的评价键值</th>
					<td id="noMarkValue"></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th scope="row" class="tr">网点IP</th>
					<td id="sysIP"></td>

					<th scope="row" class="tr">营业时间说明</th>
					<td id="sysYWtime"></td>
					<th></th>
					<td></td>
				</tr>
				<tr>
					<th scope="row" class="tr">等待排队人流量1级预警临界值</th>
					<td id="sysWaitMax1"></td>

					<th scope="row" class="tr">等待排队人流量2级预警临界值</th>
					<td id="sysWaitMax2"></td>
					<th scope="row" class="tr">等待排队人流量3级预警临界值</th>
					<td id="sysWaitMax3"></td>
				</tr>

				<tr>
					<th scope="row" class="tr">评价很差数量1级预警临界值</th>
					<td id="SysPjhcMax1"></td>

					<th scope="row" class="tr">评价很差数量2级预警临界值</th>
					<td id="SysPjhcMax2"></td>
					<th scope="row" class="tr">评价很差数量3级预警临界值</th>
					<td id="SysPjhcMax3"></td>
				</tr>

				<tr>
					<th scope="row" class="tr">排队等待超时数量1级预警临界值</th>
					<td id="SysWaitCsMax1"></td>

					<th scope="row" class="tr">排队等待超时数量2级预警临界值</th>
					<td id="SysWaitCsMax2"></td>
					<th scope="row" class="tr">排队等待超时数量3级预警临界值</th>
					<td id="SysWaitCsMax3"></td>
				</tr>
				<tr>

				</tr>
				<tr>
					<th scope="row" class="tr">排队受理超时数量1级预警临界值</th>
					<td id="SysBlCsMax1"></td>

					<th scope="row" class="tr">排队受理超时数量2级预警临界值</th>
					<td id="SysBlCsMax2"></td>
					<th scope="row" class="tr">排队受理超时数量3级预警临界值</th>
					<td id="SysBlCsMax3"></td>
				</tr>
				<tr>
					<th scope="row" class="tr">功能区A</th>
					<td id="SysBlCsMax1"></td>

					<th scope="row" class="tr">功能区B</th>
					<td id="SysBlCsMax2"></td>
					<th scope="row" class="tr">功能区C</th>
					<td id="SysBlCsMax3"></td>
				</tr>

				<tr>
					<th scope="row" class="tr">负责人</th>
					<td id="sys_fzr"></td>

					<th scope="row" class="tr">负责人联系电话</th>
					<td id="sys_phone"></td>
					<th></th>
					<td></td>
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
		<h3>添加下属机构</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
	<div class="pop_body" id="tbAddOrgInfo">
		<table>
			<tr>
				<th scope="row">是否设为网点:</th>
				<td><input name="isspot" type="checkbox"/></td>
			</tr>
			<tr>
				<th scope="row">机构代码:</th>
				<td><input name="JG_ID" type="text" style="width:70px" /></td>
			</tr>
			<tr>
				<th scope="row">机构名称:</th>
				<td><input name="JG_name" type="text" style="width:160px" /></td>
			</tr>
		</table>
		<div class="pop_foot">
			<input onclick="addOrgInfo()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
	</div>
</div>
<script>
	// 获取分行机构信息
	function getOrgInfo(orgId){
		$('#isEdit').val(0);
		$('#orgId').val(orgId);
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=institution&action=getOrgInfo";
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
		if (infoObj.useWelvoice == '0') $('#useWelvoice').html('<?= lang('$ORG_RIGHTER_HIDE')?lang('$ORG_RIGHTER_HIDE'):'屏蔽'?>');
		else $('#useWelvoice').html('<?= lang('$ORG_RIGHTER_ACTIVE')?lang('$ORG_RIGHTER_ACTIVE'):'激活'?>');
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
						if (content == '<?= lang('$ORG_RIGHTER_HIDE')?lang('$ORG_RIGHTER_HIDE'):'屏蔽'?>')
							$(this).html('<select name="'+$(this).attr('id')+'"><option value="0" selected><?= lang('$ORG_RIGHTER_HIDE')?lang('$ORG_RIGHTER_HIDE'):'屏蔽'?></option><option value="1"><?= lang('$ORG_RIGHTER_ACTIVE')?lang('$ORG_RIGHTER_ACTIVE'):'激活'?></option></select>');
						else
							$(this).html('<select name="'+$(this).attr('id')+'"><option value="0"><?= lang('$ORG_RIGHTER_HIDE')?lang('$ORG_RIGHTER_HIDE'):'屏蔽'?></option><option value="1" selected><?= lang('$ORG_RIGHTER_ACTIVE')?lang('$ORG_RIGHTER_ACTIVE'):'激活'?></option></select>');
						break;
					case 'noMarkValue':
					default:
						$(this).html('<input type="text" name="'+$(this).attr('id')+'" value="'+content+'"/>');
						break;
				}// switch
			});
			$('#tbOrgInfoChild').find('input[type="button"]').remove();
			$('#tbOrgInfoChild').append('<input class="btn_orange" type="button" value="<?= lang('$COMMON_BOX_SAVA')?lang('$COMMON_BOX_SAVA'):'保存'?>" onclick="saveOrgInfo()"><input class="btn_gray" type="button" value="<?= lang('$COMMON_BOX_CANCEL')?lang('$COMMON_BOX_CANCEL'):'取消'?>" onclick="resetOrgInfo()">');
		}
		else
		{
			$('#tbOrgInfo').find('td[id^="JG_"]').each(function(){
				var content = $(this).html();
				if ("JG_bz" == $(this).attr('id'))$(this).html('<textarea name="'+$(this).attr('id')+'" rows="4" cols="30">'+content+'</textarea>');
				else $(this).html('<input type="text" name="'+$(this).attr('id')+'" value="'+content+'"/>');
			});
			$('#tbOrgInfo').find('input[type="button"]').remove();
			$('#tbOrgInfo').append('<input class="btn_orange" type="button" value="<?= lang('$COMMON_BOX_SAVA')?lang('$COMMON_BOX_SAVA'):'保存'?>" onclick="saveOrgInfo()"><input class="btn_gray" type="button" value="<?= lang('$COMMON_BOX_CANCEL')?lang('$COMMON_BOX_CANCEL'):'取消'?>" onclick="resetOrgInfo()">');
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
		var url = "index.php?control=institution&action=saveOrgInfo";
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
			alert("请输入机构代码");
			return;
		}// if
		
		if ("" == jgMc) {
			alert("请输入机构名称.");
			return;
		}// if
		
		var postData = getPostData($('#tbAddOrgInfo'));
		var orgId = $('#orgId').val();
		var url = "index.php?control=institution&action=addOrgInfo";
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
					alert('添加失败.');
			}
		}); // ajax
	}// func 
	
	// 弹出添加输入框
	function showPopbox(){
		var orgId = $('#orgId').val();
		if (!(orgId != '')){
			alert('请先选择分行');
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=institution&action=getOrgTreeStr";
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
		if (!confirm('确认删除!')) return;
		var isspot = $('#isspot').val();
		var orgId = $('#orgId').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=institution&action=deleteOrgInfo";
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
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
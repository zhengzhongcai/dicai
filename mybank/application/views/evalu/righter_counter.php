	<!----right---->
	<div class="right_box">  
		<!----tool 工具条---->
		<div class="mob_tool">
			<input type="text" id="no" name="no" placeholder="模糊查询编号" onchange="getCounterParam()">
			<input type="text" id="series" name="series" placeholder="模糊查询序列号" onchange="getCounterParam()">
			<select name="itsOrgId" id="itsOrgId" onchange="getCounterParam()">
				<option value="">选择机构</option>
				<?php foreach($itsOrgAr as $val): ?>
				<option value="<?php echo $val['sysno'];?>"><?php echo $val['sysname'];?></option>
				<?php endforeach;?>
			</select>
			<select name="isuse" id="isuse" onchange="getCounterParam()">
				<option value="">是否启用</option>
				<option value="1">启用</option>
				<option value="0">禁用</option>
			</select>
			<select name="status" id="status" onchange="getCounterParam()">
				<option value="">状态</option>
				<option value="1">在线</option>
				<option value="0">掉线</option>
			</select>
			<!-- <a auth="c" href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=addEvalu" class="tool_add statItem"><{$COMMON_ADD|default:"添加"}></a> -->
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem">删除</a>
		</div>
		<script>
			//<{foreach item=row from=$optArr}>
		//		$('a[auth="<{$row.Operation}>"]').css('display', 'inline-block');
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
						<th>设备编号</th>
						<th>设备序列号</th>
						<th>所属网点</th>
						<th>柜台编号</th>
						<th>使用压缩包</th>
						<th>在线版本</th>
						<th>是否启用</th>
						<th>在线状态</th>
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
<script>
	window.onload=function(){
		//getCounterParam();
		timedCount();
	}
	
	function timedCount()
	{
		getCounterParam();
		t=setTimeout("timedCount()", 5000)
	}
	
	// 修改公共参数
	function editParamInfo(){
		var checkedCnt = 0;
		var paramId;
		$('#tbCounterPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					console.dir($(this));
					paramId = $(this).attr('id');
					checkedCnt++;
				}// if
		});
		
		if (checkedCnt > 1 || checkedCnt < 1) {
			alert('请选择其中一个进行编辑.');
			return;
		}// if
		
		// 进入编辑界面
		location.href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=editEvalu&eId="+paramId;
	}// func
	
	// 获取公共参数数据
	function getCounterParam(){
		var no = $('#no').val();
		var series = $('#series').val();
		var orgId = $('#itsOrgId').val();
		var status = $('#status').val();
		var isuse = $('#isuse').val();
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=getCounterParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId+'&no='+no+'&status='+status+'&isuse='+isuse+'&series='+series,
			dataType:'json',
			success: function(data) {
			//console.log(data);
				$('#tbCounterPram > tbody').html('');
				var paramObjs = data;
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					$('#tbCounterPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var isuse;
		var status;
		if (1 == paramInfo.E_isuse) isuse = '启用';
		else isuse = '禁用';
		
		if (1 == paramInfo.E_status) status = '在线';
		else status = '掉线';
		
		
		var version;
		if (paramInfo.E_version == null) version = '';
		else version = paramInfo.E_version;
		
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.E_id+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.E_no+'</td>'+
						  '<td>'+paramInfo.E_series+'</td>'+
						  '<td>'+paramInfo.JG_name+'</td>'+
						  '<td>'+paramInfo.C_no+'</td>'+
						  '<td>'+paramInfo.tpl_name+'</td>'+
						  '<td>'+version+'</td>'+
						  '<td>'+isuse+'</td>'+
						  '<td>'+status+'</td>'+
						  //'<td>'+paramInfo.C_lrtime.substr(0, paramInfo.C_lrtime.indexOf('.'))+'</td>'+
						  //'<td>'+paramInfo.C_lasttime.substr(0, paramInfo.C_lasttime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
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
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var C_sysno = $('select[name="itsOrgId"]').val();
		//alert(C_sysno);return;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=deleteCounterInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('删除成功.');
					getCounterParam();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
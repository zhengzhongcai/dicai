	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serialParam">业务清单</a></li>
				<li><a href="javascript:void(0)" class="on">VIP客户资料管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serverParam">柜员管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=counterParam">柜台管理</a></li>
			</ul>
		</div>
		-->


		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="itsOrgId" id="itsOrgId" onchange="getVipParam()">
				<option value="">默认</option>
				<?php foreach($itsOrgAr as $val): ?>
				<option value="<?php echo $val['sysno'];?>"><?php echo $val['sysname'];?></option>
				<?php endforeach;?>
			</select>
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem">添加</a>
			<a auth="u" href="javascript:editParamInfo()" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteParamInfo()" class="tool_del statItem">删除</a>
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
			<table id="tbVipPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">客户代码</th>
						<th width="10%">客户名</th>
						<th width="20%">添加的用户代码</th>
						<th width="20%">所属网点机构代码</th>
						<!--
						<th width="15%">添加时间</th>
						-->
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
		<h3>添加VIP资料</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">客户代码:</th>
				<td><input name="V_cardNo" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">客户名:</th>
				<td><input name="V_name" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">添加的用户代码:</th>
				<td><input name="V_addUser" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">所属网点机构代码:</th>
				<td>
					<select name="V_addFwt">
						<?php foreach($itsOrgAr as $val): ?>
						<option value="<?php echo $val['sysno'];?>"><?php echo $val['sysname'];?></option>
						<?php endforeach;?>
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
		V_cardNo:"",
		V_name:"",
		V_addUser:"",
		V_addFwt:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		//getVipParam();
	}
	// 获取公共参数数据
	function getVipParam(){
		// 获取网点id
		var orgId = $('#itsOrgId').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getVipParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			success: function(data) {
				$('#tbVipPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbVipPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.V_cardNo+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.V_cardNo+'</td>'+
						  '<td>'+paramInfo.V_name+'</td>'+
						  '<td>'+paramInfo.V_addUser+'</td>'+
						  '<td>'+paramInfo.V_addFwt+'</td>'+
						  //'<td>'+paramInfo.V_addtime.substr(0, paramInfo.V_addtime.indexOf('.'))+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		var orgid = $('[name=itsOrgId]').val();
		if(orgid.length>0){
			$('.pop_box [name=V_addFwt]').val(orgid);
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=addVipInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data > 0)
				{
					alert('添加成功.');
					getVipParam();
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
		$('#tbVipPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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
					paramInfo.V_cardNo = content;
					$(this).html('<input type="text" name="V_cardNo" value="'+content+'"/>');
					break;
				case 2:
					paramInfo.V_name = content;
					$(this).html('<input type="text" name="V_name" value="'+content+'"/>');
					break;
				case 3:
					paramInfo.V_addUser = content;
					$(this).html('<input type="text" name="V_addUser" value="'+content+'"/>');
					break;
				case 4:
					paramInfo.V_addFwt = content;
					var orgSelect = '<select name="V_addFwt">';
					//<{foreach item=row from=$itsOrgArr}>
					//if (content == '<{$row.sysno}>')
					//	orgSelect += '<option value="<{$row.sysno}>" selected><{$row.sysname}></option>';
					//else
					//	orgSelect += '<option value="<{$row.sysno}>"><{$row.sysname}></option>';
					//<{/foreach}>
					orgSelect += '</select>';
					
					$(this).html(orgSelect+'&nbsp;<input class="btn_orange" type="button" value="保存" onclick="saveParamInfo()"><input class="btn_gray" type="button" value="取消" onclick="resetParamInfo()">');
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
			$('#tbVipPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbVipPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbVipPram'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=saveVipInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.V_cardNo,
			success: function(data) {
				if (data > 0)
				{
					alert('修改成功.');
					getVipParam();
					$('#isEdit').val(0);
				}
				else
					alert('修改失败.');
			}
		}); // ajax
	}// func
	
	// 取消参数编辑
	function resetParamInfo(){
		getVipParam();
		$('#isEdit').val(0);
	}// func
	
	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbVipPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=deleteVipInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data > 0)
				{
					alert('删除成功');
					getVipParam();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
</script>
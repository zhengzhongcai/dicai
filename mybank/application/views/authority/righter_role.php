
<!----right---->

	<div class="right_box">

		<!----title 标题栏 标签---->
		<div class="mod_title mod_title_nonebor">
			
		</div>
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox()" class="tool_add statItem1"><?=lang('AUTH_LEFTER_ADD')?lang('AUTH_LEFTER_ADD'):'添加' ?></a>
			<a auth="u" href="javascript:text3()" class="tool_edit statItem"><?=lang('AUTH_LEFTER_EDIT')?lang('AUTH_LEFTER_EDIT'):'编辑' ?></a>
			<a auth="d"href="javascript:deleteParamInfo()" class="tool_del statItem1"><?=lang('AUTH_LEFTER_DEL')?lang('AUTH_LEFTER_DEL'):'删除' ?></a>
		</div>
		<!----tool 工具条 end---->
		<script>
			<{foreach item=row from=$fcodeArr}>
				$('a[auth="<{$row.f_code}>"]').css('display', 'inline-block');
			<{/foreach}>
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
						<th width="10%"><?=lang('AUTH_RIGHTER_ROLEID')?lang('AUTH_RIGHTER_ROLEID'):'角色ID' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_NAME')?lang('AUTH_RIGHTER_NAME'):'角色名称' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_CHANGE_TIME')?lang('AUTH_RIGHTER_CHANGE_TIME'):'修改时间' ?></th>
						<th width="10%"><?=lang('AUTH_RIGHTER_ADDTIME')?lang('AUTH_RIGHTER_ADDTIME'):'添加时间' ?></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>

		</div>
		<div id="aa">
			<div id="rolemenu" class="pop_box_menu" style="height:auto;display: none;">

				<!--	<div class="pop_title">
		<h3 id="role_id"><?=lang('AUTH_RIGHTER_EDIT')?lang('AUTH_RIGHTER_EDIT'):'角色编辑' ?></h3>
	<a href="javascript:rolemenuPopbox()" class="pop_close"></a>
</div>
-->
				<div style="height:auto;">
					<!--<div style="text-align: center; font-size: 15px">角色名称：<input type="text" id="editrolename" readonly="true"></div>-->

				</div>
			<ul id="demo4" >
				<?php foreach($rolemenu as $val): ?>
					<li>
						<div style="font-size: 14px"><?php echo $val['menu_name'] ; ?></div>
						<?php foreach($val['_child'] as $val1): ?>
							<ul style="display: block">
								<li><div><table width="1000px" border="0" id="check<?php echo $val1['menu_id']; ?>">
											<tr>
												<hr />
											<tr id="" ><?php echo $val1['menu_name']; ?></tr>
											<tr id='fun_id'>
												<?php foreach($val1['_child'] as $val2): ?><?php
														$menid=$val2['menu_id'];
														echo "<th  style='width: 100px; font-size: 14px;'>";
														echo "<input name='fun_name' type='checkbox' id='$menid'>";
														echo  $val2['menu_name'];
											echo "</th>";

													?><?php endforeach ; ?>
												<td style="font-size: 14px"><input id="add<?php echo $val1['menu_id']; ?>" name="add<?php echo $val1['menu_id']; ?>" type="checkbox" onclick="toggleChooseAll2('<?php echo $val1['menu_id']; ?>')"><?=lang('AUTH_RIGHTER_CHECKALL')?lang('AUTH_RIGHTER_CHECKALL'):'全选' ?></td>
											</tr>
										</table>
									</div></li>
							</ul>
						<?php endforeach ; ?>
					</li>
				<?php endforeach ; ?>
			</ul>
				<div class="pop_foot1">
					<input onclick="savetext1()" id="savef" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_SAVA')?lang('COMMON_BOX_SAVA'):'保存' ?>&nbsp;&nbsp;" class="btn_orange" />
					<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_CANCEL')?lang('COMMON_BOX_CANCEL'):'取消' ?>&nbsp;&nbsp;" class="btn_gray" />&nbsp;
				</div>
			</div>
			</div>
		<!----table 表格 end---->
	</div>
	<!----right end---->
</div>
<!--content end-->
<div id="popupadd" class="pop_box_menu1" style="display:none;height:auto;">
	<div class="pop_title">
		<h3><?=lang('AUTH_RIGHTER_ADD_ROLE')?lang('AUTH_RIGHTER_ADD_ROLE'):'添加角色' ?></h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="" id="tbAddParamInfo">
		<div id="authChoose" style="height:500px;overflow-y:auto">
			<div style="text-align: center"><?=lang('AUTH_RIGHTER_NAME')?lang('AUTH_RIGHTER_NAME'):'角色名称' ?><input type="text" id="rolename"></div>
			<hr />
			<ul id="demo5">
				<?php foreach($rolemenu as $val): ?>
				<li>
					<div><?php echo $val['menu_name'] ; ?></div>
					<?php foreach($val['_child'] as $val1): ?>
					<ul style="display:none">
						<li>
							<div>
								<table width="800px" border="0" id="<?php echo $val1['menu_id']; ?>">
							<tr>
							<tr id=""><?php echo $val1['menu_name']; ?></tr>
							<tr>
								<?php foreach($val1['_child'] as $val2): ?><th style="width: 100px"><input  type="checkbox"  id="<?php echo $val2['menu_id']; ?>"><?php echo $val2['menu_name'] ;?></th><?php endforeach ; ?>
									<td><input id="<?php echo $val1['menu_id']; ?>" name="edit<?php echo $val1['menu_id']; ?>" type="checkbox" onclick="toggleChooseAll1('<?php echo $val1['menu_id']; ?>')"><?=lang('AUTH_RIGHTER_CHECKALL')?lang('AUTH_RIGHTER_CHECKALL'):'全选' ?></td>
							</tr>

						</table>
						</div></li>
					</ul>
					<?php endforeach ; ?>
				</li>
				<?php endforeach ; ?>
			</ul>
		</div>
		<div class="pop_foot1">
			<input onclick="addrole()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_SAVA')?lang('COMMON_BOX_SAVA'):'保存' ?>&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_CANCEL')?lang('COMMON_BOX_CANCEL'):'取消' ?>&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>





<!--content end-->
<div id="popupedit" class="pop_box" style="display:none">
	<div class="pop_title">
		<h3><<?=lang('AUTH_RIGHTER_EDIT_ROLE')?lang('AUTH_RIGHTER_EDIT_ROLE'):'修改角色' ?></h3>
		<a href="javascript:hideEditPopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body" id="tbEditParamInfo">
		<div id="authUpdate" style="height:500px;overflow-y:auto">
		</div>
		<div class="pop_foot">
			<input onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_SAVA')?lang('COMMON_BOX_SAVA'):'保存' ?>&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hideEditPopbox()" type="button" value="&nbsp;&nbsp;<?=lang('COMMON_BOX_CANCEL')?lang('COMMON_BOX_CANCEL'):'取消' ?>&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>

<script>
	var paramInfo = {
		R_ID:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		getCommonParam();
	}

	
	// 获取公共参数数据
	function getCommonParam(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getRoles";
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
		var paramStr = '<tr id='+paramInfo.role_id+'>'+
						  '<td class="tc"><input id="'+paramInfo.role_id+'" class="optCheck" type="checkbox" onclick="text3()"/></td>'+
						  '<td>'+paramInfo.role_id+'</td>'+
						  '<td>'+paramInfo.role_name+'</td>'+
						  '<td>'+paramInfo.role_inputtime+'</td>'+
						  '<td>'+paramInfo.role_lastinputtime+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	
	// 弹出添加输入框
	function showPopbox(){
		$('#popupadd').css('display', 'block');
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('#popupadd').css('display', 'none');
		$('#tbAddParamInfo').find('input[type="text"],input[type="checkbox"],textarea').each(function(){
			$(this).val('');
			$(this).removeAttr('checked');
		});
	}// func
	
	// 取消添加输入框
	function hideEditPopbox(){
		$('#popupedit').css('display', 'none');
		$('#tbEditParamInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func

	function rolemenuPopbox(){
		$('#rolemenu').css('display', 'none');
		$('#tbCommonPram').find('input[type="checkbox"]').each(function(){
			$(this).removeAttr('checked');
		});
	}// f
	
	
	// 添加参数信息
	function addParamInfo(){
		var postData = getPostData($('#authChoose'));
		if ('' == $('input[name="R_name"]').val()){
			alert('<?=lang('AUTH_RIGHTER_TIP0')?lang('AUTH_RIGHTER_TIP0'):'请添加角色名称' ?>');
			return;
		}// if
		//alert(postData);return;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=addRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?=lang('AUTH_LEFTER_SUCCESS')?lang('AUTH_LEFTER_SUCCESS'):'添加成功' ?>.');
					getCommonParam();
					hidePopbox();
				}
				else
					alert('<?=lang('AUTH_LEFTER_FAIL')?lang('AUTH_LEFTER_FAIL'):'请添失败' ?>');
			}
		}); // ajax
	}// func

	//保存参数
	
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
			alert('<?=lang('AUTH_SERVER_TIP7')?lang('AUTH_SERVER_TIP7'):'请选择一个来编辑' ?>');
			return;
		}// if
		
		//var isEdit = $('#isEdit').val();
		//if (isEdit-0) return;
		//else $('#isEdit').val(1);
		
		paramInfo.R_ID = paramId;
		
		$('#popupedit').css('display', 'block');
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=getRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: 'R_ID='+paramId,
			success: function(data) {
				var roleObj = eval('(' + data + ')');
				$('#authUpdate').html(roleObj.auths);
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

	function toggleChooseAll1($menu_id){
		var choosename="edit"+$menu_id;
		var chooseAll = $("input[name='"+choosename+"']").attr('checked');
		if ('checked' == chooseAll)
		{
			$('#'+$menu_id).find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#'+$menu_id).find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func

	function toggleChooseAll2($menu_id){
		var choosename="add"+$menu_id;
		var chooseAll = $("input[name='"+choosename+"']").attr('checked');
		if ('checked' == chooseAll)
		{
			$('#check'+$menu_id).find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#check'+$menu_id).find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func
	
	// 保存参数的修改
	function saveParamInfo(){
		var postData = getPostData($('#tbEditParamInfo'));
		//alert(postData);return;
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=saveRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.R_ID,
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<?=lang('AUTH_LEFTER_EDIT_SUCCESS')?lang('AUTH_LEFTER_EDIT_SUCCESS'):'修改成功' ?>');
					getCommonParam();
					//$('#isEdit').val(0);
				}
				else
					alert('<?=lang('AUTH_LEFTER_EDIT_FAIT')?lang('AUTH_LEFTER_EDIT_FAIT'):'修改失败' ?>.');
					
				hideEditPopbox();
			}
		}); // ajax
	}// func

	//保存修改参数

	
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
			alert('<?=lang('AUTH_SERVER_TIP8')?lang('AUTH_SERVER_TIP8'):'请选择需要删除的项' ?>');
			return;
		}// if
		
		if (!confirm('<?=lang('AUTH_LEFTER_CONFIRM_DEL')?lang('AUTH_LEFTER_CONFIRM_DEL'):'确认删除！' ?>')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=deleteRoleInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;

				if (data == '' || typeof data == 'undefined')
				{
					alert('<?=lang('AUTH_LEFTER_DEL_SUCCESS')?lang('AUTH_LEFTER_DEL_SUCCESS'):'删除成功' ?>.');
					getCommonParam();
					window.location.href=window.location.href;
				}
				else
					alert('<?=lang('AUTH_LEFTER_DEL_FAIL')?lang('AUTH_LEFTER_DEL_FAIL'):'删除失败' ?>');
			}
		}); // ajax
	}// func
	function rolemenu(){
		$('#rolemenu').css('display','block');
	}
	function check(){
		$("#tbCommonPram input[type='checkbox']").on('click',function(){
			if($(this).is(':checked')){
				var inputId=$(this).attr('id');
				$('#tbCommonPram tbody tr').css({'display':'none'});
				$('tr#inputId').css({'display':'block'})
			}else{
				alert('nimei')
			}
		})
	}

	function savetext1(){
		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function () {
			if ('checked' == $(this).attr('checked')) {
				paramId = $(this).attr('id');

			}// if
		});
		var str=savemenu();
		var rolename=$("#editrolename").val()
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=saveRole";
		//var url = "<?php echo $session['baseurl']; ?>/index.php?control=authority&action=inforole";
		$.ajax({
			type:"post",
			url:url,
			data:"id="+str+"&rolename="+rolename+"&roleid="+paramId,
			success:function(data){
				if(data!=''){
					//alert(data);
					alert("<?=lang('AUTH_LEFTER_SAVE_SUCCESS')?lang('AUTH_LEFTER_SAVE_SUCCESS'):'保存成功' ?>");
					window.location.href=window.location.href;
				}
				else{
					alert("<?=lang('AUTH_LEFTER_SAVE_FAIL')?lang('AUTH_LEFTER_SAVE_FAIL'):'保存失败' ?>");
				}
			}

		});

	}

	function  each1(kkk){
		alert(kkk);
	}
	//添加角色
	function addrole(){
		var rolename=$("#rolename").val();
		var str=saverole();
		if(rolename==''){
			alert("<?=lang('AUTH_SERVER_TIP9')?lang('AUTH_SERVER_TIP9'):'角色名称不能为空，请输入角色名称' ?>");
			return;
		}
		var url="<?php echo $session['baseurl']; ?>/index.php?control=authority&action=addRole";
		$.ajax({
			type:"post",
			url:url,
			data:"rolename="+rolename+"&menu_id="+str,
			success:function(data){
				if(data!=''){
					alert("<?=lang('AUTH_LEFTER_SUCCESS')?lang('AUTH_LEFTER_SUCCESS'):'添加成功' ?>");
				}
				else {
					alert("<?=lang('AUTH_LEFTER_FAIL')?lang('AUTH_LEFTER_FAIL'):'添加失败' ?>");
				}

			}
		})
	}

	function text3() {
		/*
		$('input[type=checkbox]').change(function(){
			$('#tbCommonPram').hide();
		});
		*/
		//var text=$('#rolemenu').html();
		//$('#aa').html(text);

		$('#tbCommonPram').find('input[type="checkbox"][class="optCheck"]').each(function () {

				if ('checked' == $(this).attr('checked')) {
					paramId = $(this).attr('id');
					$('#' + paramId).show();
				}//

				else {
					paramId1 = $(this).attr('id');
					$('#' + paramId1).hide();

				}
		});
		$("#tbCommonPram input[type='checkbox']").on('click',function(){
			if($(this).is('checked')){

			}
			else {
				window.location.href=window.location.href;
			}
		});
		var url="<?php echo $session['baseurl']; ?>/index.php?control=authority&action=inforole";
		$.ajax({
			type:"POST",
			url:url,
			data:"roleid="+paramId,
			success:function(data){
				$(document).ready(function(){
						$("#rolemenu").slideToggle("slow");
						$(this).toggleClass("active"); return false;

				});
				$(function(){
            var arr=eval(data);
					$.each(arr,function(i,n){
						$("#"+ n.menurole_id).attr("checked", true);
					})


				});
			//	$("#editrolename").val(data);
				var arr=eval(data);
				new Vue({
					el: '#app',
					data: {
						todos: arr,
					}
				})

			}
		});


		// ajax
				//$("#rolemenu").slideToggle("slow");
				//$(this).toggleClass("active");
				//return false;
	}
</script>


</script>


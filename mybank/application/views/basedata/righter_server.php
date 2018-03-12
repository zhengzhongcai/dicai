	<!----right---->
	<div class="right_box">  
		<!----title 标题栏 标签---->
		<!--
		<div class="mod_title mod_title_nonebor">
			<ul class="title_tab">
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=serialParam">业务清单</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=vipParam">VIP客户资料管理</a></li>
				<li><a href="javascript:void(0)" class="on">柜员管理</a></li>
				<li><a href="<{$baseUrl}>/index.php?control=basedata&action=counterParam">柜台管理</a></li>
			</ul>
		</div>
		-->
		<!----title 标题栏标签 end----> 
		<!----tool 工具条---->
		<div class="mob_tool">
			<select name="itsOrgId" id="itsOrgId" onchange="getServerParam()">
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
			$('a[auth="c"]').css('display', 'inline-block');
			$('a[auth="u"]').css('display', 'inline-block');
			$('a[auth="d"]').css('display', 'inline-block');
		</script>
		<!----tool 工具条 end---->
		<!----table 表格---->
		<input type="hidden" id="isEdit" value="0"/>
		<div class="mod_table">
			<table id="tbServerPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="30%">柜员工号</th>
						<th width="30%">柜员名称</th>
						<th width="35%">所属机构代码</th>
						<!--
						<th width="5%">星级</th>
						<th width="20%">备注</th>
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
<link rel="stylesheet" href="assets/SWFUpload/default.css">
<script type="text/javascript" src="assets/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="assets/SWFUpload/plugins/swfupload.queue.js"></script>
<script type="text/javascript" src="assets/SWFUpload/fileprogress.js"></script>
<script type="text/javascript" src="assets/SWFUpload/handlers.js"></script>
<div class="pop_box" style="display:none">
	<div class="pop_title">
		<h3>添加柜员资料</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<th scope="row">柜员工号:</th>
				<td><input name="S_no" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">柜员名称:</th>
				<td><input name="S_name" type="text" style="width:160px" /></td>
			</tr>
            <tr>
				<th scope="row">部门名称:</th>
				<td><input name="S_bz" type="text" style="width:160px" /></td>
			</tr>
             <tr>
				<th scope="row">岗位名称:</th>
				<td><input name="S_gwname" type="text" style="width:160px" /></td>
			</tr>
			<tr>
				<th scope="row">所属机构代码:</th>
				<td>
					<select name="S_sysno">
						<!--
						<{foreach item=row from=$itsOrgArr}>
						<option value="<{$row.sysno}>"><{$row.sysname}></option>
						<{/foreach}>
						-->
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">柜员头像:</th>
				<td>
					<div class="fieldset flash" id="fsUploadProgress"></div>
					<div>
						<span id="spanButtonPlaceHolder"></span>
						<input id="btnCancel" type="button" value="取消上传" onclick="swfu.cancelQueue();" disabled="disabled"/>
					</div>
					<div>请上传jpg文件</div>
					<img id="cateLogo" style="display:block;width:300px;height:200px;border:1px solid #000;margin-top:10px;margin-bottom:10px;" src="assets/images/nopic.png"/>
				</td>
			</tr>
			
		</table>
		<div class="pop_foot">
			<input id="addParamInfo" onclick="addParamInfo()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input id="saveParamInfo" style="display:none" onclick="saveParamInfo()" type="button" value="&nbsp;&nbsp;修改&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	var paramInfo = {
		S_no:""
	};// 修改前保存参数原始信息
	window.onload=function(){
		//getServerParam();
	}
	// 获取公共参数数据
	function getServerParam(){
		// 获取网点id
		var orgId = $('#itsOrgId').val();
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getServerParam";
		$.ajax({
			type: "post",
			url: url,
			data: 'orgId='+orgId,
			success: function(data) {

				//alert(data);return;
				$('#tbServerPram > tbody').html('');
				var paramObjs = eval('(' + data + ')');
				var paramStr = "";
				for (var idx in paramObjs){
					paramStr = generateParam(paramObjs[idx]);
					//alert(paramStr);
					$('#tbServerPram > tbody').append(paramStr);
				}// for
			}
		}); // ajax
	}// func

	// 生成一行记录
	function generateParam(paramInfo){
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+paramInfo.S_no+'" class="optCheck" type="checkbox"/></td>'+
						  '<td>'+paramInfo.S_no+'</td>'+
						  '<td>'+paramInfo.S_name+'</td>'+
						  '<td>'+paramInfo.S_sysno+'</td>'+
						  //'<td>'+paramInfo.S_star+'</td>'+
						  //'<td>'+paramInfo.S_bz+'</td>'+
						'</tr>';
		return paramStr;
	}// func

	// 弹出添加输入框
	function showPopbox(){
		// 修改title
		$('.pop_title > h3').html('添加柜员资料');
		$('#saveParamInfo').css('display', 'none');
		$('#addParamInfo').css('display', 'inline-block');
		$('#cateLogo').attr('src', $.trim('assets/images/nopic.png'));
		var orgid = $('[name=itsOrgId]').val();
		if(orgid.length>0){
			$('.pop_box [name=S_sysno]').val(orgid);
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
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=addServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData,
			success: function(data) {
				if (data > 0)
				{
					alert('添加成功.');
				//	getServerParam();
					//hidePopbox();
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
		$('#tbServerPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
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

		// 显示编辑框
		$('.pop_box').css('display', 'block');
		// 修改title
		$('.pop_title > h3').html('修改柜员资料');
		// 显示修改按钮
		$('#addParamInfo').css('display', 'none');
		$('#saveParamInfo').css('display', 'inline-block');


		paramInfo.S_no = paramId;
		// 异步获取员工信息
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=getServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "sno=" + paramId,
			success: function(data) {
				var sObj = JSON.parse(data);
				$('input[name="S_no"]').val(sObj.S_no);
				$('input[name="S_name"]').val(sObj.S_name);
				var orgSelect = '';
				//<{foreach item=row from=$itsOrgArr}>
				//if (sObj.S_sysno == '<{$row.sysno}>')
				//	orgSelect += '<option value="<{$row.sysno}>" selected><{$row.sysname}></option>';
				//else
			//		orgSelect += '<option value="<{$row.sysno}>"><{$row.sysname}></option>';
				//<{/foreach}>
				$('select[name="S_sysno"]').html(orgSelect);
				if ($.trim(sObj.S_photoPath) == "") $('#cateLogo').attr('src', $.trim('assets/images/nopic.png'));
				else $('#cateLogo').attr('src', $.trim(sObj.S_photoPath));
			}
		}); // ajax
	}// func

	// 选择全部
	function toggleChooseAll(){
		var chooseAll = $('#checkControl').attr('checked');
		if ('checked' == chooseAll)
		{
			$('#tbServerPram').find('input[type="checkbox"]').each(function(){
				$(this).attr('checked', 'checked');
			});
		}
		else{
			$('#tbServerPram').find('input[type="checkbox"]').each(function(){
				$(this).removeAttr('checked');
			});
		}// if
		//
	}// func

	// 保存参数的修改
	function saveParamInfo(){
		//var postData = getPostData($('#tbServerPram'));
		var postData = getPostData($('.pop_box .tbAddParamInfo'));
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=saveServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: postData + "paramId=" + paramInfo.S_no,
			success: function(data) {
				if (data > 0)
				{
					alert('<{$COMMON_TIP_EDIT_SUCCESS|default:"修改成功."}>');
					getServerParam();
					$('#isEdit').val(0);
				}
				else
					alert('<{$COMMON_TIP_EDIT_FAILED|default:"修改失败."}>');
			}
		}); // ajax
	}// func

	// 取消参数编辑
	function resetParamInfo(){
		getServerParam();
		$('#isEdit').val(0);
	}// func

	// 删除公共参数
	function deleteParamInfo(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbServerPram').find('input[type="checkbox"][class="optCheck"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = "'"+$(this).attr('id')+"'";
				i++;
			}//
		});

		if (deleteItemArr.length == 0)
		{
			alert('<{$COMMON_TIP_CHOOSE_DEL_ITEM|default:"请选择需要删除的项."}>');
			return;
		}// if

		if (!confirm('<{$COMMON_TIP_IS_DEL|default:"确认删除!"}>')) return;

		var url = "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=deleteServerInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "params=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				//alert(data);return;
				if (data > 0)
				{
					alert('<{$COMMON_TIP_DEL_SUCCESS|default:"删除成功."}>');
					getServerParam();
				}
				else
					alert('<{$COMMON_TIP_DEL_FAILED|default:"删除失败."}>');
			}
		}); // ajax
	}// func
</script>

<script>
	// 文件上传对象
	var swfu;
	window.onload = function () { // Do something... 	
		// 文件上传对象初始化
		var settings = {
			upload_url : "<?php echo $session['baseurl']; ?>/index.php?control=basedata&action=uploadStaffPic",
			flash_url : "assets/SWFUpload/Flash/swfupload.swf",
			post_params: {"PHPSESSID" : ""},
			file_size_limit : "100 MB",
			file_types : "*.jpg",
			file_types_description : "All Files",
			file_upload_limit : 100,
			file_queue_limit : 1,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "assets/SWFUpload/upload_pic.png",
			button_width: "80px",
			button_height: "40px",
			button_placeholder_id: "spanButtonPlaceHolder",
			button_text: '',
			button_text_style: ".button{color:red}",
			button_text_left_padding: 12,
			button_text_top_padding: 3,
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccessRoute,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete	// Queue plugin event
		};
		swfu = new SWFUpload(settings);
	}//
	
	// 展示路线封面
	function uploadSuccessRoute(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("完成上传");
			progress.toggleCancel(false);
			$('#cateLogo').attr('src', $.trim(serverData));
		} catch (ex) {
			this.debug(ex);
		}
	}// func
</script>
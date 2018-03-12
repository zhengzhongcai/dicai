	<!----right---->
	<div class="right_box">
		<!----tool 工具条---->
		<div class="mob_tool">
			<a auth="c" href="javascript:showPopbox('addRes')" class="tool_add statItem">添加音频</a>
			<a auth="u" href="javascript:showPopbox('editRes')" class="tool_edit statItem">编辑</a>
			<a auth="d" href="javascript:deleteRes()" class="tool_del statItem">删除</a>
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
			<table id="tbCommonPram">
				<thead>
					<tr>
						<th width="5%"><input id="checkControl" onclick="toggleChooseAll()" type="checkbox"/></th>
						<th width="10%">编号</th>
						<th width="5%">状态</th>
						<th width="10%">文件名称</th>
						<th width="15%">文件大小</th>
						<th width="20%">文件路径</th>
						<th width="15%">录入时间</th>
						<th width="15%">录入用户代码</th>
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
		<h3>添加音频</h3>
		<a href="javascript:hidePopbox()" class="pop_close"></a>
	</div>
    <div class="pop_body tbAddParamInfo">
		<table>
			<tr>
				<td>文件名称：</td>
				<td><input type="text" name="resname" /></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="fieldset flash" id="fsUploadProgress"></div>
					<div>
						<span id="spanButtonPlaceHolder"></span>
						<input id="btnCancel" type="button" value="取消上传" onclick="swfu.cancelQueue();" disabled="disabled"/>
					</div>
					<div>请上传MP3文件</div>
				</td>
			</tr>
		</table>
		<div class="pop_foot">
			<input id="editRes" onclick="editRes()" type="button" value="&nbsp;&nbsp;修改&nbsp;&nbsp;" class="btn_orange" />
			<input id="addRes" onclick="addRes()" type="button" value="&nbsp;&nbsp;保存&nbsp;&nbsp;" class="btn_orange" />
			<input onclick="hidePopbox()" type="button" value="&nbsp;&nbsp;取消&nbsp;&nbsp;" class="btn_gray" />&nbsp;
		</div>
    </div>
</div>
<script>
	// 文件上传对象
	var swfu;
	window.onload = function () { // Do something... 	
		getResList();
		// 文件上传对象初始化
		var settings = {
			upload_url : "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=uploadRes",
			flash_url : "assets/SWFUpload/Flash/swfupload.swf",
			post_params: {"PHPSESSID" : "", "res_type":"1"},
			file_size_limit : "100 MB",
			file_types : "*.mp3",
			file_types_description : "All Files",
			file_upload_limit : 100,
			file_queue_limit : 1,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,

			// Button settings
			button_image_url: "assets/SWFUpload/upload.png",
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
	}
	
	// 获取资源列表
	function getResList(){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getResList";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=1',
			success: function(data) {
				$('#tbCommonPram > tbody').html('');
				var resObjs = eval('(' + data + ')');
				var resStr = "";
				for (var idx in resObjs){
					resStr = generateRes(resObjs[idx]);
					$('#tbCommonPram > tbody').append(resStr);
				}// for
			}
		}); // ajax
	}// func
	
	// 生成一行记录
	function generateRes(res){
		var status;
		if (res.status == 1){
			status = '已审核';
		}else{
			status = '<span style="color:red">未审核<span>';
		}
		
		var paramStr = '<tr>'+
						  '<td class="tc"><input id="'+res.id+'" type="checkbox" class="item"/></td>'+
						  '<td>'+res.id+'</td>'+
						  '<td>'+status+'</td>'+
						  '<td title="点击预览"><span style="cursor:pointer" onclick="showRes(\''+res.name+'\',\'<?php echo $session['baseurl']; ?>/index.php?control=resource&action=checkRes&resid='+res.id+'\')">'+res.name+'</span></td>'+
						  '<td>'+res.size+'</td>'+
						  '<td>'+res.path+'</td>'+
						  '<td>'+res.create_time+'</td>'+
						  '<td>'+res.username+'</td>'+
						'</tr>';
		return paramStr;
	}// func
	 
	// 展示路线封面
	function uploadSuccessRoute(file, serverData) {
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("完成上传.");
			progress.toggleCancel(false);
		} catch (ex) {
			this.debug(ex);
		}
	}
	// 弹出添加输入框
	function showPopbox(type){
		$('#editRes').hide();
		$('#addRes').hide();
		$('#'+type).show();
		
		if ('editRes' == type){
			var checkedCnt = 0;
			var resid;
			$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
				if ('checked' == $(this).attr('checked')) 
				{
					resid = $(this).attr('id');
					checkedCnt++;
				}// if
			});
			
			if (checkedCnt > 1 || checkedCnt < 1) {
				alert('请选择其中一个进行编辑.');
				return;
			}// if
			// 异步获取资源信息
			var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=getResInfo";
			$.ajax({
				type: "post",
				url: url,
				data: 'resid='+resid,
				success: function(data) {
					var resObj = eval('(' + data + ')');
					$('input[name="resname"]').val(resObj.name);
				}
			}); // ajax
		}
		
		$('.pop_box').css('display', 'block');
		// 删除临时资源
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteTmpRes";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {}
		}); // ajax
		
	}// func
	// 取消添加输入框
	function hidePopbox(){
		$('.pop_box').css('display', 'none');
		$('.pop_box .tbAddParamInfo').find('input[type="text"],textarea').each(function(){
			$(this).val('');
		});
	}// func
	
	// 添加资源
	function addRes(){
		// 检查文件名是否填写
		var resname = $('input[name="resname"]').val();
		if ('' == resname) {
			alert('请输入文件名');
			return;
		}// if
		
		// 异步添加资源
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=storeRes";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=1&res_name='+resname,
			success: function(data) {
				if (data > 0) {
					alert('添加成功.');
					getResList();
					hidePopbox();
				}
				else alert('添加失败.');
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
	
	// 删除资源
	function deleteRes(){
		var i = 0;
		var deleteItemArr = new Array();
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) {
				deleteItemArr[i] = $(this).attr('id');
				i++;
			}
		});
		
		if (deleteItemArr.length == 0) {
			alert('请选择需要删除的项.');
			return;
		}// if
		
		if (!confirm('确认删除!')) return;
		
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=deleteRes";
		$.ajax({
			type: "post",
			url: url,
			data: "resids=" + deleteItemArr.join(',').trimcomma(),
			success: function(data) {
				if (data == '')
				{
					alert('删除成功.');
					getResList();
				}
				else
					alert('删除失败.');
			}
		}); // ajax
	}// func
	
	// 修改资源
	function editRes(){
		// 检查文件名是否填写
		var resname = $('input[name="resname"]').val();
		if ('' == resname) {
			alert('请输入文件名');
			return;
		}// if
		
		var checkedCnt = 0;
		var resid;
		$('#tbCommonPram').find('input[type="checkbox"][class="item"]').each(function(){
			if ('checked' == $(this).attr('checked')) 
			{
				resid = $(this).attr('id');
				return;
			}
		});
		
		// 异步修改资源
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=resource&action=updateRes";
		$.ajax({
			type: "post",
			url: url,
			data: 'res_type=1&res_name='+resname+'&resid='+resid,
			success: function(data) {
				if (data > 0) {
					alert('修改成功.');
					getResList();
					hidePopbox();
				}
				else alert('修改失败.');
			}
		}); // ajax
	}// func
</script>
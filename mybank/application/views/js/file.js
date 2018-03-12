
  	var swfu;
		/*
		 
		 * 
		 * @description 加载上传组件
		 * @param info Object {typeSuffix:"*.avi;*.mpg;*.mpeg;*.wmv;....",typeDescription:"Video",nodeId:"类型树节点ID"}
		 * @author 2013-1-17 11:38:27 by bobo
		 * 
		 * 
		 * 
		 * */
		function uploadUI(info){
			//alert("start upload")
			var str_type_Multitude="<?=$fileTypeForFlashUpload?>",
				str_fileSuffix ="*.*",
				str_typeDescription = "All Files",
				str_nodeId="all",
				str_typeMultitude="";
			bug("uploadUI",print_r(info));
			if(info.hasOwnProperty("typeSuffix")){
				str_fileSuffix=info.typeSuffix;
			}
			if(info.hasOwnProperty("typeDescription")){
				str_typeDescription=info.typeDescription;
			}
			if(info.hasOwnProperty("nodeId")){
				str_nodeId=info.nodeId;
			}
			if(str_nodeId=="all"){
				str_typeMultitude=str_type_Multitude;
			}
			
				var _width=document.getElementById("btnUpload").clientWidth,
					_heith=document.getElementById("btnUpload").clientHeight;
					//alert(_width+" "+_heith)
				var settings = {
					flash_url : "thirdModel/swfUpload/flashUpload.swf",
					upload_url: "index.php?control=uploadfile&action=upFile&uid="+<?=$Uid?>+"&nodeId="+str_nodeId+"&sessionid=<?=$sessionId?>",
					file_size_limit : "2048 MB",
					file_post_name : "resume_file",
					file_types : str_fileSuffix,
					file_types_description : str_typeDescription,
					file_types_Multitude : str_typeMultitude,
					file_upload_limit : 0 ,
					file_queue_limit : 0,
					custom_settings : {
						progressTarget : "fsUploadProgress",
						cancelButtonId : "btnCancel"
					},
					debug: _Bool_,
			
					// Button Settings
					button_placeholder_id : "spanButtonPlaceholder",
					button_width: _width,
					button_height: _heith,
					button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
					button_cursor: SWFUpload.CURSOR.HAND,
					preserve_relative_urls:true,
			
					// The event handler functions are defined in handlers.js
					swfupload_loaded_handler : swfUploadLoaded,
					file_queued_handler : fileQueued,
					file_queue_error_handler : fileQueueError,
					file_dialog_complete_handler : fileDialogComplete,
					upload_start_handler : uploadStart,
					upload_progress_handler : uploadProgress,
					upload_error_handler : uploadError,
					upload_success_handler : uploadSuccess,
					upload_complete_handler : uploadComplete,
					queue_complete_handler : queueComplete,	// Queue plugin event
					
					// SWFObject settings
					minimum_flash_version : "11.1",
					swfupload_pre_load_handler : swfUploadPreLoad,
					swfupload_load_failed_handler : swfUploadLoadFailed
				};
			
				swfu = new SWFUpload(settings);
				
				
	
        }

<?php /* Smarty version Smarty-3.1.8, created on 2014-01-22 13:52:44
         compiled from "G:\WWW\cdyh\application/views\resource\editTpl.html" */ ?>
<?php /*%%SmartyHeaderCode:323352dce2edd3b107-37375615%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c7205521d27d321b34541f4130c31e0fb2e5d8d' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\editTpl.html',
      1 => 1390369955,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '323352dce2edd3b107-37375615',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dce2edeed538_53333827',
  'variables' => 
  array (
    'COMMON_RES_VIDEO' => 0,
    'rVideos' => 0,
    'video' => 0,
    'baseUrl' => 0,
    'COMMON_RES_AUDIO' => 0,
    'rAudios' => 0,
    'audio' => 0,
    'COMMON_RES_PIC' => 0,
    'rPics' => 0,
    'pic' => 0,
    'COMMON_RES_TEXT' => 0,
    'rTexts' => 0,
    'text' => 0,
    'RES_RIGHTER_TPL_NAME' => 0,
    'RES_RIGHTER_VERSION' => 0,
    'RES_RIGHTER_TPL_RESOLU' => 0,
    'RES_RIGHTER_EDIT_TPL_ADD_AREA' => 0,
    'tplid' => 0,
    'RES_RIGHTER_EDIT_TPL_FINISH' => 0,
    'RES_RIGHTER_EDIT_TPL_CHANGE' => 0,
    'RES_RIGHTER_EDIT_TPL_PREVIEW' => 0,
    'RES_RIGHTER_EDIT_TPL_TIP1' => 0,
    'RES_RIGHTER_EDIT_TPL_TIP2' => 0,
    'RES_RIGHTER_EDIT_TPL_TIP3' => 0,
    'RES_RIGHTER_EDIT_TPL_TIP4' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dce2edeed538_53333827')) {function content_52dce2edeed538_53333827($_smarty_tpl) {?>	<!----right---->
	<script src="assets/js/jquery.collapse.js"></script>
	<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
	<link rel="stylesheet" href="assets/css/jquery-ui.css" />
	<link href="assets/colorpicker/css/evol.colorpicker.min.css" rel="stylesheet" /> 
	<!-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
	<script src="assets/js/jquery-ui.js"></script>
	<script src="assets/colorpicker/js/evol.colorpicker.min.js" type="text/javascript"></script>
	<script>
		$(function() {
			$( ".item" ).draggable({helper:"clone" });
		});
	</script>
	<div class="right_box">
		<div id="srclist" data-collapse="accordion">
			<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_RES_VIDEO']->value)===null||$tmp==='' ? "视频" : $tmp);?>
</h3>
			<div id="videoList">
				<?php  $_smarty_tpl->tpl_vars['video'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['video']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rVideos']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['video']->key => $_smarty_tpl->tpl_vars['video']->value){
$_smarty_tpl->tpl_vars['video']->_loop = true;
?>
				<div style="cursor:pointer" class="item" id="<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
" onclick="showRes('<?php echo $_smarty_tpl->tpl_vars['video']->value['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid=<?php echo $_smarty_tpl->tpl_vars['video']->value['id'];?>
')" ><?php echo $_smarty_tpl->tpl_vars['video']->value['name'];?>
</div>
				<?php } ?>
			</div>
			<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_RES_AUDIO']->value)===null||$tmp==='' ? "音频" : $tmp);?>
</h3>
			<div id="audioList">
				<?php  $_smarty_tpl->tpl_vars['audio'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['audio']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rAudios']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['audio']->key => $_smarty_tpl->tpl_vars['audio']->value){
$_smarty_tpl->tpl_vars['audio']->_loop = true;
?>
				<div style="cursor:pointer" class="item" id="<?php echo $_smarty_tpl->tpl_vars['audio']->value['id'];?>
" onclick="showRes('<?php echo $_smarty_tpl->tpl_vars['audio']->value['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid=<?php echo $_smarty_tpl->tpl_vars['audio']->value['id'];?>
')"><?php echo $_smarty_tpl->tpl_vars['audio']->value['name'];?>
</div>
				<?php } ?>
			</div>
			<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_RES_PIC']->value)===null||$tmp==='' ? "图片" : $tmp);?>
</h3>
			<div id="picList">
				<?php  $_smarty_tpl->tpl_vars['pic'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pic']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rPics']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pic']->key => $_smarty_tpl->tpl_vars['pic']->value){
$_smarty_tpl->tpl_vars['pic']->_loop = true;
?>
				<div style="cursor:pointer" class="item" id="<?php echo $_smarty_tpl->tpl_vars['pic']->value['id'];?>
" onclick="showRes('<?php echo $_smarty_tpl->tpl_vars['pic']->value['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid=<?php echo $_smarty_tpl->tpl_vars['pic']->value['id'];?>
')"><?php echo $_smarty_tpl->tpl_vars['pic']->value['name'];?>
</div>
				<?php } ?>
			</div>
			<h3><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_RES_TEXT']->value)===null||$tmp==='' ? "文本" : $tmp);?>
</h3>
			<div id="textList">
				<?php  $_smarty_tpl->tpl_vars['text'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['text']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rTexts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['text']->key => $_smarty_tpl->tpl_vars['text']->value){
$_smarty_tpl->tpl_vars['text']->_loop = true;
?>
				<div style="cursor:pointer" class="item" id="<?php echo $_smarty_tpl->tpl_vars['text']->value['id'];?>
" onclick="showRes('<?php echo $_smarty_tpl->tpl_vars['text']->value['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid=<?php echo $_smarty_tpl->tpl_vars['text']->value['id'];?>
')"><?php echo $_smarty_tpl->tpl_vars['text']->value['name'];?>
</div>
				<?php } ?>
			</div>
		</div>
		<div id="editarea">
			<div style="margin-left:50px;">
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_NAME']->value)===null||$tmp==='' ? "模板名称" : $tmp);?>
：</span>
				<input type="text" name="tpl_name">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_VERSION']->value)===null||$tmp==='' ? "版本号" : $tmp);?>
：</span>
				<input type="text" name="version">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_TPL_RESOLU']->value)===null||$tmp==='' ? "分辨率" : $tmp);?>
：</span>
				<select name="resolution" onchange="changeCanvas()">
					<option value="800*480">800*480</option>
				</select>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<button id="addArea"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_ADD_AREA']->value)===null||$tmp==='' ? "添加区块" : $tmp);?>
</button>
				<?php if (''==$_smarty_tpl->tpl_vars['tplid']->value){?>
				<button onclick="storeTpl()"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_FINISH']->value)===null||$tmp==='' ? "完成" : $tmp);?>
</button>
				<?php }else{ ?>
				<button onclick="updateTpl(<?php echo $_smarty_tpl->tpl_vars['tplid']->value;?>
)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_CHANGE']->value)===null||$tmp==='' ? "修改" : $tmp);?>
</button>
				<?php }?>
				<!--
				<button onclick="previewTpl()"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_PREVIEW']->value)===null||$tmp==='' ? "预览" : $tmp);?>
</button>
				-->
			</div>
			<div style="margin-left:50px;">
				<input id="cpBoth" name="tpl_bg" value="#31859b" style="width:60px"/>
			</div>
			<div class="splitarea">
			</div>
		</div>
	</div>
	<script>
		// 设置编辑区域宽高值
		var editAreaWidth;
		var editAreaHeight;
	
		// Generate four random hex digits.
		function S4() {
		   return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
		};

		// Generate a pseudo-GUID by concatenating random hexadecimal.
		function guid() {
		   return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
		};
		// 区域
		var Area = function(id){
			this.id = id;
			//this.resid = null;
			//this.resname = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP1']->value)===null||$tmp==='' ? "未添加资源" : $tmp);?>
';
			// 宽
			this.width = 100;
			this.widthPer = 0;
			// 高
			this.height = 100;
			this.heightPer = 0;
			
			this.top = 0;
			this.topPer = 0;
			this.left = 0;
			this.leftPer = 0;
			this.resArr = new Array();
		}
		
		Area.prototype.addRes = function(res){
			this.resArr.push(res);
		}
		
		Area.prototype.setId = function(id){this.id = id;}
		Area.prototype.getId = function(){return this.id;}
		
		// 设置资源数组
		Area.prototype.setResArr = function(resArr){this.resArr = resArr;}
		Area.prototype.getResArr = function(){return this.resArr;}
		Area.prototype.removeRes = function(resid){
			for(var i=0,n=0;i<this.resArr.length;i++) { 
				if(this.resArr[i].resid == resid) { 
					this.resArr.splice(i,1);
					break;
				}// if
			}// for
			//this.length -= 1;
		}
		// 设置资源id
		//Area.prototype.setResid = function(resid){this.resid = resid;}
		//Area.prototype.getResid = function(){return this.resid;}
		// 设置资源名称
		//Area.prototype.setResname = function(resname){this.resname = resname;}
		//Area.prototype.getResname = function(){return this.resname;}
		// 设置区域宽度
		Area.prototype.setWidth = function(width){
			this.width = width;
			this.widthPer = width/editAreaWidth*100;
		}
		Area.prototype.getWidth = function(){return this.width;}
		// 设置区域高度
		Area.prototype.setHeight = function(height){
			this.height = height
			this.heightPer = height/editAreaHeight*100;
		}
		Area.prototype.getHeight = function(){return this.height;}
		// 设置相对父元素top
		Area.prototype.setTop = function(top){
			this.top = top;
			this.topPer = top/editAreaHeight*100;
		}
		Area.prototype.getTop = function(){return this.top;}
		// 设置相对父元素left
		Area.prototype.setLeft = function(left){
			this.left = left;
			this.leftPer = left/editAreaWidth*100;
		}
		Area.prototype.getLeft = function(){return this.left;}
		// 渲染区域
		Area.prototype.render = function(){
			var newDiv = $('<div></div>');
			newDiv.addClass('nodeCanvas').append('<button type="button" class="close" onclick="deleteCanvas(this)">&times;</button>').append('<ul class="link-title"></ul>');
			newDiv.css('width', this.width);
			newDiv.css('height', this.height);
			newDiv.css('position', 'absolute');
			newDiv.attr('id', this.id);
			
			var areaid = this.id;
			
			for (var idx in this.resArr){
				var resid = this.resArr[idx].resid;
				var item = this.resArr[idx];
				var newLi = $('<li resid="'+resid+'"></li>');
				var newA = $('<a href="javascript:void(0)" style="color:red">×</a>');
				$(newA).click(function(){
					// 删除资源
					var destRes = $(this).parent().attr('resid');
					areas.getArea(areaid).removeRes(destRes);
					$(this).parent().remove();
				});
				var newSpan = $('<span style="cursor:pointer" onclick="showRes(\''+item.resname+'\',\'<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=checkRes&resid='+item.resid+'\')">'+item.resname+'</span>');
				$(newLi).append(newA);
				$(newLi).append(newSpan);
				$(newDiv).find("ul[class='link-title']").append(newLi);
			}
			return newDiv;
		}
		
		// 区域列表
		var AreaList = function(){
			this.areas = new Array();
		}
		
		// 添加区域
		AreaList.prototype.addArea = function(area){
			this.areas.push(area);
		}
		
		// 获取区域
		AreaList.prototype.getArea = function(id){
			for(var i=0,n=0;i<this.areas.length;i++) { 
				if(this.areas[i].getId() == id) { 
					return this.areas[i];
				}// if
			}// for
		}
		
		// 删除区域
		AreaList.prototype.removeArea = function(id){
			for(var i=0,n=0;i<this.areas.length;i++) { 
				if(this.areas[i].getId() == id) { 
					this.areas.splice(i,1);
					break;
				}// if
			}// for
			this.length -= 1;
		}
		
		// 获取区域数组
		AreaList.prototype.getAreas = function(){
			return this.areas;
		}
		// --------------------------------------------
		// 初始化模板数组
		var areas = new AreaList();
		
		window.onload = function(){
			//.on('change.color', function(evt, color){
			//	$('.splitarea').css('background', color);
			//})
			changeCanvas()
			// 获取模板信息并渲染布局
			<?php if (''!=$_smarty_tpl->tpl_vars['tplid']->value){?>
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getTplInfo";
			$.ajax({
				type: "post",
				url: url,
				data: 'tplid='+<?php echo $_smarty_tpl->tpl_vars['tplid']->value;?>
,
				success: function(data) {
					//console.log(JSON.parse(data));
					renderTpl(JSON.parse(data));
				}
			}); // ajax
			<?php }?>
			
			$('#cpBoth').colorpicker();
		}
		
		// 根据模板id获取模板信息
		function renderTpl(tpl){
			// 设置模板名称
			$('input[name="tpl_name"]').val(tpl.tpl_name);
			// 设置模板版本
			$('input[name="version"]').val(tpl.version);
			// 设置分辨率
			$('select[name="resolution"]').val(tpl.resolution);
			// 设置背景色
			$('input[name="tpl_bg"]').val(tpl.tpl_bg);
			// 渲染模板布局
			var items = JSON.parse(tpl.areas);
			$('#cpBoth').colorpicker();
			
			for (var idx in items){
				var area = new Area(items[idx].id);
				//area.setResid(items[idx].resid);
				//area.setResname(items[idx].resname);
				area.setTop(items[idx].top);
				area.setLeft(items[idx].left);
				area.setWidth(items[idx].width);
				area.setHeight(items[idx].height);
				area.setResArr(items[idx].resArr);
				
				areas.addArea(area);
				
				var newDiv = area.render();
				$('.splitarea').append(newDiv);
				$('#'+area.getId()).animate({left:area.getLeft(), top:area.getTop()});
				activeArea(newDiv);
			}// for
		}// func
		
		// 每次添加区域，则推送到区域列表
		// 关联资源和区域
		function changeCanvas(){
			var reso = $('select[name="resolution"]').val();
			var wh = reso.split('*');
			$('.splitarea').css('width', wh[0]+'px');
			$('.splitarea').css('height', wh[1]+'px');
			editAreaWidth = wh[0];
			editAreaHeight = wh[1];
		}// func
		
		$('#addArea').bind('click', function(){
			var id = guid();
			// 添加资源区域
			var area = new Area(id);
			var newDiv = area.render();
			$('.splitarea').append(newDiv);
			areas.addArea(area);
			activeArea(newDiv);
		});
		
		// 激活区块可以调整特效
		function activeArea(newDiv){
			// 设置最大可用范围
			var reso = $('select[name="resolution"]').val();
			var wh = reso.split('*');
			newDiv.draggable({ 
				containment: "parent", 
				cursor: "move",
				stop: function( event, ui ) {
					areas.getArea(this.id).setTop(ui.position.top);
					areas.getArea(this.id).setLeft(ui.position.left);
				}
			}).resizable({
				minWidth:50,
				maxWidth:wh[0],
				minHeight: 50,
				maxHeight: wh[1],
				stop: function(event, ui) {
					areas.getArea(ui.element.attr('id')).setWidth(ui.element.width());
					areas.getArea(ui.element.attr('id')).setHeight(ui.element.height());
				}
			}).droppable({
				drop: function( event, ui ) {
					if (0 == ui.draggable.attr('class').indexOf('nodeCanvas')) return;
					var areaid = this.id;
					var resid = ui.draggable.attr('id');
					var resname = ui.draggable.html();
					
					var newLi = $('<li resid="'+resid+'"></li>');
					var newA = $('<a href="javascript:void(0)" style="color:red">×</a>');
					$(newA).click(function(){
						// 删除资源
						var destRes = $(this).parent().attr('resid');
						areas.getArea(areaid).removeRes(destRes);
						$(this).parent().remove();
					});
					var newSpan = $('<span>'+ui.draggable.html()+'</span>');
					$(newLi).append(newA);
					$(newLi).append(newSpan);
					$(this).find("ul[class='link-title']").append(newLi);
					// 修改区域对应资源
					var res = {'resid':resid, 'resname':resname}
					areas.getArea(this.id).addRes(res);
					//areas.getArea(this.id).setResid(ui.draggable.attr('id'));
					//areas.getArea(this.id).setResname(ui.draggable.html());
				}
			});
		}// func
		
		// 保存模板
		function storeTpl(){
			// 确认所有区域都添加了资源
			var items = areas.getAreas();
			if (0 == items.length){
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP2']->value)===null||$tmp==='' ? "请添加区块." : $tmp);?>
');
				return;
			}
			for (var idx in items){
				if (items[idx].resArr.length == 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP3']->value)===null||$tmp==='' ? "存在未添加资源的区块." : $tmp);?>
');
					return;
				}// if
			}// for
			
			// 检查模板名称
			var tpl_name = $('input[name="tpl_name"]').val();
			var version = $('input[name="version"]').val();
			var resolution = $('select[name="resolution"]').val();
			
			var tpl_bg = $('#cpBoth').val();
			
			if ('' == tpl_name){
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP4']->value)===null||$tmp==='' ? "请输入模板名称." : $tmp);?>
');
				return;
			}// if
			
			//console.dir(items);return;
			
			// 异步添加模板
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=storeTpl";
			$.ajax({
				type: "post",
				url: url,
				data: 'tpl_name='+tpl_name+'&tpl_bg='+tpl_bg+'&areas='+encodeURIComponent(JSON.stringify(items))+'&resolution='+resolution+'&version='+version,
				success: function(data) {
					if (data > 0) alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
				}
			}); // ajax
		}// func
		
		// 修改模板
		function updateTpl(tplid){
			// 确认所有区域都添加了资源
			var items = areas.getAreas();
			if (0 == items.length){
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP2']->value)===null||$tmp==='' ? "请添加区块." : $tmp);?>
');
				return;
			}
			for (var idx in items){
				if (items[idx].resArr.length == 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP3']->value)===null||$tmp==='' ? "存在未添加资源的区块." : $tmp);?>
');
					return;
				}// if
			}// for
			
			// 检查模板名称
			var tpl_name = $('input[name="tpl_name"]').val();
			var version = $('input[name="version"]').val();
			var resolution = $('select[name="resolution"]').val();
			
			var tpl_bg = $('#cpBoth').val();
			
			if ('' == tpl_name){
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP4']->value)===null||$tmp==='' ? "请输入模板名称." : $tmp);?>
');
				return;
			}// if
			
			// 异步修改模板
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=updateTpl";
			$.ajax({
				type: "post",
				url: url,
				data: 'tplid='+tplid+'&tpl_name='+tpl_name+'&tpl_bg='+tpl_bg+'&areas='+encodeURIComponent(JSON.stringify(items))+'&resolution='+resolution+'&version='+version,
				success: function(data) {
					if (data > 0) alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
					else alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
				}
			}); // ajax
		}// func
		
		// 预览模板
		function previewTpl(){
			// 确认所有区域都添加了资源
			var items = areas.getAreas();
			if (0 == items.length){
				alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP2']->value)===null||$tmp==='' ? "请添加区块." : $tmp);?>
');
				return;
			}
			for (var idx in items){
				if (items[idx].getResid() == null){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_TPL_TIP3']->value)===null||$tmp==='' ? "存在未添加资源的区块." : $tmp);?>
');
					return;
				}// if
			}// for
			
			var resolution = $('select[name="resolution"]').val();
			var wh = resolution.split('*');
			// 将模板信息发送到服务器端生成发布界面
			var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=generateTpl";
			$.ajax({
				type: "post",
				url: url,
				data: 'areas='+encodeURIComponent(JSON.stringify(items))+'&resolution='+resolution,
				success: function(data) {
					window.open(data, '', 'height='+wh[1]+',width='+wh[0]+',top=100,left=200');
				}
			}); // ajax
		}// func
		
		function deleteCanvas(el){
			$(el).parent().remove();
			areas.removeArea($(el).parent().attr('id'));
		}
	</script>
	<!----right end----> 
</div>
<!--content end--><?php }} ?>
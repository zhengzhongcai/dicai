<?php /* Smarty version Smarty-3.1.8, created on 2014-01-20 16:42:31
         compiled from "G:\WWW\cdyh\application/views\resource\editItem.html" */ ?>
<?php /*%%SmartyHeaderCode:3011752dce177cce4c0-89619098%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e96cfa5e0fa0664b6209ae68e5e58e626eb6e1fd' => 
    array (
      0 => 'G:\\WWW\\cdyh\\application/views\\resource\\editItem.html',
      1 => 1376882952,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3011752dce177cce4c0-89619098',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RES_RIGHTER_EDIT_ITEM_CATE' => 0,
    'RES_RIGHTER_EDIT_ITEM_NOTCATE' => 0,
    'RES_RIGHTER_EDIT_ITEM_TITLE' => 0,
    'RES_RIGHTER_EDIT_ITEM_SORT' => 0,
    'RES_RIGHTER_EDIT_ITEM_CONTENT' => 0,
    'itemid' => 0,
    'COMMON_BOX_SAVA' => 0,
    'COMMON_BOX_CHANGE' => 0,
    'baseUrl' => 0,
    'RES_RIGHTER_EDIT_ITEM_TIP1' => 0,
    'RES_RIGHTER_EDIT_ITEM_TIP2' => 0,
    'RES_RIGHTER_EDIT_ITEM_TIP3' => 0,
    'RES_RIGHTER_EDIT_ITEM_TIP4' => 0,
    'COMMON_TIP_SAVE_SUCCESS' => 0,
    'COMMON_TIP_SAVE_FAILED' => 0,
    'COMMON_TIP_EDIT_SUCCESS' => 0,
    'COMMON_TIP_EDIT_FAILED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_52dce177df4430_73273586',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52dce177df4430_73273586')) {function content_52dce177df4430_73273586($_smarty_tpl) {?>	<!----right---->
	<div class="right_box">
		<div style="margin-left:50px;margin-top:20px;">
			<div style="margin-bottom:10px">
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_CATE']->value)===null||$tmp==='' ? "分类" : $tmp);?>
：</span>
				<select id="newscate">
					<option value="0"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_NOTCATE']->value)===null||$tmp==='' ? "未分类" : $tmp);?>
</option>
				</select>
			</div>
			<div class="newsarea">
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TITLE']->value)===null||$tmp==='' ? "标题" : $tmp);?>
：</span>
				<input type="text" name="item_name">
			</div>
			<div>
				<span><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_SORT']->value)===null||$tmp==='' ? "排序" : $tmp);?>
：</span>
				<input type="text" class="sortno" name="sortno" value="1">
			</div>
			<div style="margin-bottom:10px;"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_CONTENT']->value)===null||$tmp==='' ? "内容" : $tmp);?>
：</div>
			<div id="myeditor" style="margin-bottom:10px"></div>
			<?php if (''==$_smarty_tpl->tpl_vars['itemid']->value){?>
			<button onclick="storeItem()" class="btn_orange"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_SAVA']->value)===null||$tmp==='' ? "保存" : $tmp);?>
</button>
			<?php }else{ ?>
			<button onclick="updateItem(<?php echo $_smarty_tpl->tpl_vars['itemid']->value;?>
)" class="btn_orange"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_BOX_CHANGE']->value)===null||$tmp==='' ? "修改" : $tmp);?>
</button>
			<?php }?>
		</div>
	</div>
	<script>

	</script>
	<!----right end----> 
</div>
<!--content end-->
<script type="text/javascript" charset="utf-8" src="assets/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="assets/ueditor/ueditor.all.js"></script>

<script>
	window.onload = function(){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getCateList";
		$.ajax({
			type: "post",
			url: url,
			data: '',
			success: function(data) {
				var cateObjs = JSON.parse(data);
				for (var idx in cateObjs){
					$('#newscate').append('<option value='+cateObjs[idx].id+'>'+cateObjs[idx].cate_name+'</option>');
				}// for
			}
		}); // ajax
		<?php if (''!=$_smarty_tpl->tpl_vars['itemid']->value){?>
		getNewsItem(<?php echo $_smarty_tpl->tpl_vars['itemid']->value;?>
);
		<?php }?>
	}


    window.UEDITOR_HOME_URL = "assets/ueditor/";

	 //实例化编辑器
    var options = {
        lang:/^zh/.test(navigator.language || navigator.browserLanguage || navigator.userLanguage) ? 'zh-cn' : 'en',
        langPath:UEDITOR_HOME_URL + "lang/",

        webAppKey:"9HrmGf2ul4mlyK8ktO2Ziayd",
        initialFrameWidth:860,
        initialFrameHeight:420,
        focus:true
    };



	var ue = UE.getEditor('myeditor', options);
    var domUtils = UE.dom.domUtils;

    ue.addListener("ready", function () {
        ue.focus(true);
    });

	
	// 获取新闻条目
	function getNewsItem(itemid){
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=getNewsItem";
		$.ajax({
			type: "post",
			url: url,
			data: 'itemid='+itemid,
			success: function(data) {
				var itemObj = JSON.parse(data);
				$('input[name="item_name"]').val(itemObj.item_name);
				$('input[name="sortno"]').val(itemObj.sortno);
				ue.setContent(itemObj.content);
				$('#newscate').val(itemObj.cateid);
			}
		}); // ajax
	}// func
	
	// 添加新闻
	function storeItem(){
		var itemname = $('input[name="item_name"]').val();
		if ("" == itemname) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP1']->value)===null||$tmp==='' ? "请输入新闻标题." : $tmp);?>
');
			return;
		}
		
		if ("" == ue.getContentTxt()){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP2']->value)===null||$tmp==='' ? "请填写新闻内容." : $tmp);?>
');
			return;
		}
		
		if (0 == $('#newscate').val()){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP3']->value)===null||$tmp==='' ? "请选择新闻分类." : $tmp);?>
');
			return;
		}
		
		var sortno = $('input[name="sortno"]').val();
		if ("" == sortno){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP4']->value)===null||$tmp==='' ? "请输入排序号." : $tmp);?>
');
			return;
		}
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=storeItem";
		$.ajax({
			type: "post",
			url: url,
			data: 'itemname='+itemname+'&itemcont='+encodeURIComponent(ue.getContent())+'&cateid='+$('#newscate').val()+'&sortno='+sortno,
			success: function(data) {
				if (data > 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_SUCCESS']->value)===null||$tmp==='' ? "添加成功." : $tmp);?>
');
					clearForm();
				}else{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_SAVE_FAILED']->value)===null||$tmp==='' ? "添加失败." : $tmp);?>
');
				}
			}
		}); // ajax
	}// func
	
	// 清除表单
	function clearForm(){
		 $('input[name="item_name"]').val('');
		 ue.setContent('');
	}
	
	// 修改新闻
	function updateItem(itemid){
		var itemname = $('input[name="item_name"]').val();
		if ("" == itemname) {
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP1']->value)===null||$tmp==='' ? "请输入新闻标题." : $tmp);?>
');
			return;
		}
		
		if ("" == ue.getContentTxt()){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP2']->value)===null||$tmp==='' ? "请填写新闻内容." : $tmp);?>
');
			return;
		}
		
		if (0 == $('#newscate').val()){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP3']->value)===null||$tmp==='' ? "请选择新闻分类." : $tmp);?>
');
			return;
		}
		
		var sortno = $('input[name="sortno"]').val();
		if ("" == sortno){
			alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['RES_RIGHTER_EDIT_ITEM_TIP4']->value)===null||$tmp==='' ? "请输入排序号." : $tmp);?>
');
			return;
		}
		
		var url = "<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=resource&action=updateItem";
		$.ajax({
			type: "post",
			url: url,
			data: 'itemid='+itemid+'&itemname='+itemname+'&itemcont='+encodeURIComponent(ue.getContent())+'&cateid='+$('#newscate').val()+'&sortno='+sortno,
			success: function(data) {
				if (data > 0){
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_SUCCESS']->value)===null||$tmp==='' ? "修改成功." : $tmp);?>
');
				}else{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['COMMON_TIP_EDIT_FAILED']->value)===null||$tmp==='' ? "修改失败." : $tmp);?>
');
				}
			}
		}); // ajax
	}// func
</script><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2017-03-30 11:53:58
         compiled from "D:\bankSct2\BANK\application/views\statistic\righter_list.html" */ ?>
<?php /*%%SmartyHeaderCode:1489458c909f465f098-23943287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '448ec48b640e564bb38da5b757e72c5662118fa1' => 
    array (
      0 => 'D:\\bankSct2\\BANK\\application/views\\statistic\\righter_list.html',
      1 => 1490845844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1489458c909f465f098-23943287',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_58c909f46a0465_13453278',
  'variables' => 
  array (
    'STAT_RIGHTER_LIST_TABLE' => 0,
    'STAT_RIGHTER_LIST_STAT_BUS' => 0,
    'STAT_RIGHTER_LIST_STAT_EFF' => 0,
    'STAT_RIGHTER_LIST_STAT_EVA' => 0,
    'STAT_RIGHTER_LIST_WAIT_TIME' => 0,
    'STAT_RIGHTER_LIST_STAFF_BUS' => 0,
    'STAT_RIGHTER_LIST_STAFF_EFF' => 0,
    'STAT_RIGHTER_LIST_STAFF_EVA' => 0,
    'STAT_RIGHTER_LIST_STAFF_AVG_WAIT_TIME' => 0,
    'STAT_RIGHTER_LIST_CHART' => 0,
    'STAT_RIGHTER_LIST_CHART_BUS_DST' => 0,
    'STAT_RIGHTER_LIST_CHART_BUS_TREND' => 0,
    'STAT_RIGHTER_LIST_CHART_EVA_DST' => 0,
    'STAT_RIGHTER_LIST_CHART_EVA_TREND' => 0,
    'fcodeArr' => 0,
    'row' => 0,
    'baseUrl' => 0,
    'STAT_RIGHTER_CHOOSE_AGENCY_TIP' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58c909f46a0465_13453278')) {function content_58c909f46a0465_13453278($_smarty_tpl) {?><!----right---->
<div class="right_box"> 
<!-- 
	<div class="mod_tab">
		<ul></ul>
    </div>
-->
<style>
.left_menu_b_list h2{width:100%; height:45px; overflow:hidden; border-bottom:1px solid #dedddd;font-size:18px; color:#c6011b; text-align:center; line-height:50px;}
</style>
	<div style="width:100%;float:left;">
		<div class="left_menu_b_list fl">
			<h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_TABLE']->value)===null||$tmp==='' ? "报表" : $tmp);?>
</h2>
			<ul>
				<li style="cursor:default;" auth="52" class="statItem"><a onclick="setTableType('busFlow', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAT_BUS']->value)===null||$tmp==='' ? "网点业务量统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="55" class="statItem"><a onclick="setTableType('busEff', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAT_EFF']->value)===null||$tmp==='' ? "网点业务效率统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="60" class="statItem"><a onclick="setTableType('evaStat', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAT_EVA']->value)===null||$tmp==='' ? "网点服务评价统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="64" class="statItem"><a onclick="setTableType('busWait', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_WAIT_TIME']->value)===null||$tmp==='' ? "网点平均等待时间统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="68" class="statItem"><a onclick="setTableType('staffBusFlow', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAFF_BUS']->value)===null||$tmp==='' ? "柜员业务量统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="300" class="statItem"><a onclick="setTableType('staffBusEff', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAFF_EFF']->value)===null||$tmp==='' ? "柜员业务效率统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="72" class="statItem"><a onclick="setTableType('staffEvaStat', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAFF_EVA']->value)===null||$tmp==='' ? "柜员服务评价统计" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="76" class="statItem"><a onclick="setTableType('staffBusWait', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_STAFF_AVG_WAIT_TIME']->value)===null||$tmp==='' ? "柜员平均等待时间统计" : $tmp);?>
</a></li>
			</ul>
			<h2><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_CHART']->value)===null||$tmp==='' ? "图表" : $tmp);?>
</h2>
			<ul>
				<li style="cursor:default;" auth="80" class="statItem"><a onclick="setTableType('busFlowDistr', this, 'g')"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_CHART_BUS_DST']->value)===null||$tmp==='' ? "业务分布分析" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="84" class="statItem"><a onclick="setTableType('busFlowTrend', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_CHART_BUS_TREND']->value)===null||$tmp==='' ? "业务趋势分析" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="88" class="statItem"><a onclick="setTableType('evaLevelDistr', this, 'g')"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_CHART_EVA_DST']->value)===null||$tmp==='' ? "评价分布分析" : $tmp);?>
</a></li>
				<li style="cursor:default;" auth="92" class="statItem"><a onclick="setTableType('evaLevelTrend', this)"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_LIST_CHART_EVA_TREND']->value)===null||$tmp==='' ? "评价趋势分析" : $tmp);?>
</a></li>
			</ul>
		</div>
		<!----左边二级菜单 end---->
		<script>
			<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fcodeArr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
				$('li[auth="<?php echo $_smarty_tpl->tpl_vars['row']->value['menurole_id'];?>
"]').css('display', 'block');
			<?php } ?>
			// 设置查询的图标类型
			function setTableType(tableType, elem, gType){
				var orgId = $('#orgId').val();
				if (orgId == "")
				{
					alert("请先选择机构.");
					return;
				}// func
				if(gType==='g'){
					if($('#pType').val()!='bar'){
						switch(tableType){
							case 'busFlowDistr':
								tableType = 'busPieDistr';
								break;
							case 'evaLevelDistr':
								tableType = 'evaPieDistr';
								break;
						}
					}
					$('#gType').val(tableType);
				}
				if(gType!=='g'){
					$('#tableType').val(tableType);
				}else{
					$('#tableType').val('');
				}
				$('.table_title>h3').html($('#orgTitle').html()+'-'+$(elem).html());
				$(elem).closest('.left_menu_b_list').find('a').each(function(){
					$(this).removeClass('on');
				});
				$(elem).addClass('on');
				// 清空报表位置
				$('#tab1').html('');
				$('#tab2').html('');
				
				if (tableType=='busFlowDistr' || tableType=='busPieDistr' || tableType=='evaLevelDistr' || tableType=='evaPieDistr') $('#displayChoose').css('display', 'block');
				else $('#displayChoose').css('display', 'none');
				
				$('#displayChoose').closest('.left_menu_b_list').find('a').each(function(){
					$(this).removeClass('on');
				});
				selectData();
			}// func
			
			function getStatData(action){
				var url="<?php echo $_smarty_tpl->tpl_vars['baseUrl']->value;?>
/index.php?control=statistic&action="+action;
				var orgId = $('#orgId').val();
				if (orgId == "")
				{
					alert('<?php echo (($tmp = @$_smarty_tpl->tpl_vars['STAT_RIGHTER_CHOOSE_AGENCY_TIP']->value)===null||$tmp==='' ? "请先选择机构." : $tmp);?>
');
					return;
				}// func
				$.ajax({
					type: "post",
					url: url,
					data: "orgId=" + orgId,
					success: function(data) {
						var statObj = eval('(' + data + ')');
						$('.table_title>h3').html(statObj.title);
						$('.mob_tool').css("display", "block");
						$('#tab1').html('');
						$('#tab1').append(statObj.tableStr);
						// 设置表排序特效
						$('#tab1>table').dataTable({
							"bPaginate": false,
							"bFilter": false
						});
						$('#tab2').html('');
						$('#tab2').append(statObj.chartStr);
					}
				}); // ajax
			}// func
		</script><?php }} ?>
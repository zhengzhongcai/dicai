<div id="block_container"></div>
<div id="block_template" style="display:none;">
	<div class="block">
		<!----right left---->
		<div style="width:82%; float:left; border-right:1px solid #beb5b5;border-bottom:1px solid #beb5b5;">
			<input class="orgId" type="hidden"/>
			<!----title 标题栏---->
			<div class="mod_title mod_title_nonebor"> 
				<h3>基本信息</h3>
				<a class="display_title" onclick="miniseinfo(this)"></a>
               
			</div>
			<!----title 标题栏 end----> 
			<!----table 表格---->
			<div class="baseInfo mod_table">
				<table>
					<tr>
						<th width="155" scope="row" class="tr">银行名称</th>
						<td class ="JG_name"></td>
					</tr>
					<tr>
						<th scope="row" class="tr">机构代码</th>
						<td class="JG_ID"></td>
					</tr>
					<tr>
						<th scope="row" class="tr">负责人</th>
						<td class="JG_fzr"></td>
					</tr>
					<tr>
						<th scope="row" class="tr">联系电话</th>
						<td class="JG_phone"></td>
					</tr>
					<tr>
						<th scope="row" class="tr">所属上级分支机构</th>
						<td class="pname"></td>
					</tr>
			  </table>
			</div>
			<!----table 表格 end----> 
			<!----title 标题栏---->
			<div class="mod_title">
				<h3>柜台信息</h3>
				<a class="display_title" onclick="minisegt(this)"></a>
				<div class="minimized_window minimized_banner">
					<span style="line-height:32px;"><!--最小化的柜台--></span>
				</div>
			</div>
			<!----title 标题栏 end----> 
			
			<!----counter_box 柜台---->
			<div class="all_bar_box counter_box">
			</div>
			<!----counter_box 柜台 end----> <!----title 标题栏 标签---->
			<div class="mod_title">
				<ul class="title_tab">
					<li><a onclick="currDateChart(this)" class="on" style="cursor: default;">当天数据</a></li>
					<li><a onclick="currWeekChart(this)" style="cursor: default;">本周数据</a></li>
				</ul>
				<a class="display_title" onclick="minisedata(this)"></a>
			</div>
			<!----title 标题栏标签 end---->
			<div class="displayDataAndChart">
				<script LANGUAGE="Javascript" SRC="assets/FusionCharts/FusionCharts.js"></script>	
				<div class="currDateChart" style="margin-top:12px;padding:12px;"></div>
				<div class="currWeekChart" style="margin-top:12px;padding:12px;display:none;"></div>
				<!----table 表格---->
				<div class="mod_table">
					<table class="currDateData">
						<thead></thead>
						<tbody></tbody>
					</table>
					<table class="currWeekData" style="display:none;">
						<thead></thead>
						<tbody></tbody>
					</table>
				</div>
				<!----table 表格 end----> 
			</div>
			<!----title 标题栏---->
			<div class="mod_title">
				<h3>预警</h3>
				<a class="display_title" onclick="minisewarn(this)"></a>
			</div>
			<!----title 标题栏 end----> 
			<!----table 表格---->
			<div class="mod_table">
				<table class="tbWarnInfo">
					<thead>
						<tr>
							<th>预警信息</th>
							<th>数量</th>
							<th>是否超过预警值</th>
							<th>预警等级</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<!----table 表格 end----> 
			<!----right right end---->
		</div>
		<!----right right---->
		<div style="overflow:hidden;"><!----title 标题栏---->
			<div class="mod_title  mod_title_nonebor">
				<h3>排队信息</h3>
				<a class="display_title" onclick="minisepd(this)"></a>
			</div>
			<!----title 标题栏 end----> 
			<!----table---->
			<div class="mod_table pdinfo">
				<!--当前等候人数-->
				<table class="table_style2 waitBaseInfo">
				</table>
				<table class="table_style2">
					<tr class="font_red">
						<th style="width:65%;">当前最长等候的号码</th>
						<td><span class="maxWaitNum"></span></td>
					</tr>
					<tr>
						<th>是否超时</th>
						<td><span class="isover"></span></td>
					</tr>
				</table>
				<table class="table_style2">
					<tr>
						<th style="width:65%;">平均办理时间</th>
						<td><span class="avg_ztime"></span></td>
					</tr>
					<tr>
						<th>平均等候时间</th>
						<td><span class="avg_wtime"></span></td>
					</tr>
				</table>
			</div>
			<!----table end---->
		</div>
		<!----right end----> 
	</div>
</div>
<!--content end-->
	
	
</div>

<script>
	// 显示或者隐藏
	function displayOrNot(el){
		if ($(el).attr('class') == 'display_title') {
			$(el).attr('class', 'hidden_title');
			$(el).attr('title', '点击展开');
		}else {
			$(el).attr('class', 'display_title');
			$(el).attr('title', '点击隐藏');
		}// if
	}// func

	function minisepd(el){
		$(el).closest('.block').find('.pdinfo').toggle();
		displayOrNot(el);
	}// func
	function minisewarn(el){
		$(el).closest('.block').find('.tbWarnInfo').toggle();
		displayOrNot(el);
	}// func
	function currDateChart(elem){
		$(elem).parent().parent().find('a').each(function(){
			$(this).removeClass('on');
		});
		$(elem).addClass('on');
		$(elem).closest('.block').find('.currWeekChart').toggle();
		$(elem).closest('.block').find('.currDateChart').toggle();
		
		$(elem).closest('.block').find('.currWeekData').toggle();
		$(elem).closest('.block').find('.currDateData').toggle();
		
		var orgId = $(elem).closest('.block').find('.orgId').val();
		getCurrDateBusChart(orgId);
	}// func
	
	function currWeekChart(elem){
		$(elem).parent().parent().find('a').each(function(){
			$(this).removeClass('on');
		});
		$(elem).addClass('on');
		$(elem).closest('.block').find('.currWeekChart').toggle();
		$(elem).closest('.block').find('.currDateChart').toggle();
		
		$(elem).closest('.block').find('.currWeekData').toggle();
		$(elem).closest('.block').find('.currDateData').toggle();
		
		var orgId = $(elem).closest('.block').find('.orgId').val();
		getWeekDateBusChart(orgId);
		getWeekDateBusList(orgId);
	}// func
	function minisedata(el){
		$(el).closest('.block').find('.displayDataAndChart').toggle();
		
		displayOrNot(el);
	}// func
	function minisegt(el){
		$(el).closest('.block').find('.all_bar_box').toggle();
		
		displayOrNot(el);
	}// func
	function miniseinfo(el){
		$(el).closest('.block').find('.baseInfo').toggle();
		displayOrNot(el);
	}// func
	if ('<?php echo $session['roleId']; ?>' != '') getOrgDetail('<?php echo $session['roleId']; ?>');
	// 最小化柜台
	function minimize(el, id){
		var $ctn = $(el).closest('.block');
		$('.bar_button_'+id, $ctn).css('display', 'inline-block');
		$('.bar_'+id, $ctn).css('display', 'none');
	}// func
	
	// 最大化柜台
	function maximize(el, id){
		var $ctn = $(el).closest('.block');
		$('.bar_button_'+id,$ctn).css('display', 'none');
		$('.bar_'+id,$ctn).css('display', 'inline-block');
	}// func
	
	// 获取对应网点的监控数据
	function getOrgDetail (orgId){
		addOrgTab(orgId);
		tabChange(orgId);
	}// func
	
	function getBlockClassName(orgId){
		return 'b_'+orgId;
	}
	
	// 添加网点标签
	function addOrgTab(orgId){
		// 找出是否存在该网点标签
		var isExists = false;
		$('.mod_tab > ul').children('li').each(function (){
			if (('tab_'+orgId) == $(this).attr('id')) isExists = true;
		});
		// 不存在该网点的标签则添加
		if (false == isExists){
			$('.mod_tab>ul').append('<li id="tab_'+orgId+'" class="on"><span onclick="tabChange(\''+orgId+'\')"></span><a onclick="tabDelete(\''+orgId+'\')" class="tab_close"></a></li>');
			var $tpl = $('#block_template').clone();
			$tpl.find('.block').addClass(getBlockClassName(orgId)).hide();
			$('#block_container').append($tpl.html());
			var $b = $('.'+getBlockClassName(orgId));
			$('.'+getBlockClassName(orgId) +' .orgId').val(orgId);
			var st = setInterval(function(){
				refreshData(orgId);
			}, 20000);
			$b.data('interval', st);
		}
	}// func
	
	function refreshData(orgId){
		(function(orgId){
				getOrgInfo(orgId);
				getBarInfo(orgId);
				getWaitInfo(orgId);
				getMaxWaitNum(orgId);
				getWarnInfo(orgId);
				getCurrDateBusList(orgId);
				getCurrDateBusChart(orgId);
				getAvgInfo(orgId);
		})(orgId);
	}

	// 切换激活标签，并找出网点数据
	function tabChange(orgId){
		$('#tab_'+orgId).parent().children("li").each(function(){
			$(this).removeClass('on');
		});
		$('#tab_'+orgId).addClass('on');
		// 找出默认的设备类型，并显示其列表
		$('#block_container .block').not('.'+getBlockClassName(orgId)).hide();
		$('.'+getBlockClassName(orgId)).show();
		refreshData(orgId);
	}// func
	
	// 删除标签，并将上一标签的内容显示出来
	function tabDelete(orgId){
		var activeId = $('#tab_'+orgId).prev().attr('id');
		if ("on" == $('#tab_'+orgId).attr('class') && typeof activeId != "undefined"){
			var parts = activeId.split('_');
			tabChange(parts[1]);
		}
		else if (typeof activeId == "undefined") {
			activeId = $('#tab_'+orgId).next().attr('id');
			if (typeof activeId != "undefined"){
				var parts = activeId.split('_');
				tabChange(parts[1]);
			}// if
			else $('#tbDevice > tbody').html('');
		}// if
		$('#tab_'+orgId).remove();
		clearInterval($('.'+getBlockClassName(orgId)).data('interval'));
		$('.'+getBlockClassName(orgId)).remove();
		// 找出需要显示的标签和将要显示的标签
	}// func
  
	// 获取网点基本信息
	function getOrgInfo(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getOrgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + <?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				var $b = $('.'+getBlockClassName(orgId));
				var infoObj = eval('(' + data + ')');
				$('#tab_'+orgId+'>span').html(infoObj.JG_name);
				$('.JG_name').html(infoObj.JG_name);
				$('.JG_ID', $b).html(infoObj.JG_ID);
				$('.JG_fzr', $b).html(infoObj.JG_fzr);
				$('.JG_phone', $b).html(infoObj.JG_phone);
				$('.pname', $b).html(infoObj.pname);

			}
		  }); // ajax
	}// func
	
	//获取窗口监控数据
	function getBarInfo(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getBarInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId=" + <?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				var barObjs = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.minimized_banner', $b).children('input[class^="bar_button_"]').remove();
				$('.all_bar_box', $b).children('div.counter').remove();
				for(var idx in barObjs){
					generateBarData(idx, barObjs[idx], $b);
				}// for
				leaveout(orgId);
				// 修改侧边的高度
				$('.left_box').css('height', $('.right_box').css('height'));
			}
		  }); // ajax
	}// func
	
	
	// 过长省略
	function leaveout(orgId)
	{
		var $b = $('.'+getBlockClassName(orgId));
		$(".counter_box", $b).find('div[class="li_title"]').each(function(i){  
			//获取td当前对象的文本,如果长度大于25;  
			if($(this).html().length>10){  
				//给td设置title属性,并且设置td的完整值.给title属性.  
				$(this).attr("title",$(this).html());  
				//获取td的值,进行截取。赋值给text变量保存.  
				var text=$(this).html().substring(0,10)+"...";  
				//重新为td赋值;  
				$(this).text(text);  
			}  
		});
	}// func
	
	// 生成窗口数据
	function generateBarData(idx, barInfo, $b){
		// 最小化按钮
		$('.minimized_banner', $b).append('<input onclick="maximize(this,'+idx+')" class="bar_button_'+idx+' btn_gray" type="button" value="窗口'+idx+'" style="display:none"/>');
		
		var busStr = "";
		for (var id in barInfo.bus){
			busStr += '<li>'+
						'<div class="li_title">'+barInfo.bus[id].name+'</div>'+
						'<div class="li_text">'+barInfo.bus[id].cnt+'笔</div>'+
					'</li>';
		}// for
		
		// 最大化窗口
		var barStr = '<div class="counter bar_'+idx+'">'+
						'<div class="counter_title">'+
							'<a onclick="minimize(this,'+idx+')" class="counter_close"></a>'+
							'<p>'+
								'<strong>窗口'+idx+'</strong><br />'+
								'<strong>柜员:'+barInfo.S_name+'</strong><br />'+
								'登录时间：'+barInfo.C_loginTime.substr(0, barInfo.C_loginTime.indexOf('.'))+
							'</p>'+
						'</div>'+
						'<div class="counter_data">'+
							'<div class="counter_score">'+
								'<div class="li_title">综合评价</div>'+
								'<div class="li_score"><span style="width:'+barInfo.S_star+'%;"></span></div>'+
							'</div>'+
							'<ul>'+
								'<li class="counter_total_data">'+
									'<div class="li_title">已办理业务</div>'+
								'<div class="li_text">'+barInfo.zywl+'笔</div>'+
								busStr +
							'</ul>'+
							'<div class="counter_efficiency">'+
								'<ul>'+
								'<li style="border-top:0px;"><div class="li_title">总处理时间</div>'+
								'<div class="li_text">'+formateTiemStr(barInfo.ztime)+'</div></li>'+
								'<li><div class="li_title">平均办理时间</div>'+
								'<div class="li_text">'+formateTiemStr(barInfo.avgtm)+'/笔</div></li>'+
								'</ul>'+
							'</div>'+
						'</div>'+
					'</div>';
		
		$('.all_bar_box', $b).append(barStr);
	}// func
	
	// 获取实时等待数据
	function getWaitInfo(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getWaitInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+<?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				var $b = $('.'+getBlockClassName(orgId));
				var objInfos = eval('(' + data + ')');
				$('.waitBaseInfo', $b).html('');
				for (var idx in objInfos){
					$('.waitBaseInfo', $b).append('<tr><th style="width:65%;">'+objInfos[idx].Q_serialname+'</th><td>'+objInfos[idx].cnt+'人</td></tr>');
				}// for
			}
		}); // ajax
	}// func
	
	// 获取最长等候号码
	function getMaxWaitNum(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getMaxWaitNum";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+<?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				//alert(data);
				var $b = $('.'+getBlockClassName(orgId));
				var maxWaitInfos = eval('(' + data + ')');
				$('.maxWaitNum', $b).html(maxWaitInfos.number);
				if (maxWaitInfos.isover > 0)
					$('.isover', $b).html('是');
				else
					$('.isover', $b).html('否');
			}
		}); // ajax
	}// func
	
	// 获取预警信息

	function getWarnInfo(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getWarnInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+<?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				var warnInfos = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				var item = "";
				var warnCls = '';
				var isover = '';
				var level = '';
				$('.tbWarnInfo>tbody', $b).html('');
				for (var idx in warnInfos){
					warnCls = (warnInfos[idx].level>0)?'class="tr_warning"':'';
					isover = (warnInfos[idx].level>0)?'是':'否';
					level = (warnInfos[idx].level>0)?warnInfos[idx].level:'';
					item = '<tr '+warnCls+'>'+
								'<td>'+warnInfos[idx].title+'</td>'+
								'<td>'+warnInfos[idx].cnt+'</span></td>'+
								'<td>'+isover+'</td>'+
								'<td>'+level+'</td>'+
							'</tr>';
					$('.tbWarnInfo>tbody', $b).append(item);
				}// for
			}
		}); // ajax
	}// func

	// 更新当天办理业务数据
	function getCurrDateBusList(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getCurrDateBusList";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+<?php echo $session['sys_orgId']; ?>,
			success: function(data) {
				var dataInfos = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.currDateData>thead', $b).html('');
				$('.currDateData>tbody', $b).html('');
				var theadStr = '<tr>';
				var tbodyStr = '<tr>';
				for (var idx in dataInfos.thead){
					theadStr += '<th>'+dataInfos.thead[idx]+'</th>';
				}// for
				theadStr += '</tr>';
				$('.currDateData>thead', $b).append(theadStr);

				for (var idx in dataInfos.tbody){
					tbodyStr += '<td>'+dataInfos.tbody[idx]+'</td>';
				}// for
				tbodyStr += '</tr>';
				$('.currDateData>thead', $b).append(tbodyStr);
			}
		}); // ajax
	}// func
	
	// 更新当天办理业务量图表
	function getCurrDateBusChart(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getCurrDateBusChart";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+orgId,
			success: function(data) {
				var chartInfo = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.currDateChart', $b).html('');
				$('.currDateChart', $b).html(chartInfo.chartStr);
				chartActive('line');
				// 修改侧边的高度
				$('.left_box').css('height', $('.right_box').css('height'));
			}
		}); // ajax
	}// func
	
	// 更新本周办理业务量图表
	function getWeekDateBusChart(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getWeekDateBusChart";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+orgId,
			success: function(data) {
				var chartInfo = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.currWeekChart',$b).html('');
				$('.currWeekChart',$b).html(chartInfo.chartStr);
				chartActive('line');
				// 修改侧边的高度
				$('.left_box').css('height', $('.right_box').css('height'));
			}
		}); // ajax
	}// func
	
	// 更新本周办理业务量数据
	function getWeekDateBusList(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getWeekDateBusList";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+orgId,
			success: function(data) {
				var dataInfos = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.currWeekData>thead',$b).html('');
				$('.currWeekData>tbody',$b).html('');
				var theadStr = '<tr>';
				var tbodyStr = '';
				for (var idx in dataInfos.thead){
					theadStr += '<th>'+dataInfos.thead[idx]+'</th>';
				}// for
				theadStr += '</tr>';
				$('.currWeekData>thead',$b).append(theadStr);
				
				for (var idx in dataInfos.tbody){
					tbodyStr += '<tr>';
					for (var idx2 in dataInfos.tbody[idx]){
						tbodyStr += '<td>'+dataInfos.tbody[idx][idx2]+'</td>';
					}// for
					tbodyStr += '</tr>';
				}// for
				//tbodyStr += '';
				$('.currWeekData>thead',$b).append(tbodyStr);
				// 修改侧边的高度
				$('.left_box').css('height', $('.right_box').css('height'));
			}
		}); // ajax
	}// func
	
	// 更新平均等待时间和办理时间数据
	function getAvgInfo(orgId){
		var url = "<?php echo $session['baseurl']; ?>/index.php?control=monitor&action=getAvgInfo";
		$.ajax({
			type: "post",
			url: url,
			data: "orgId="+orgId,
			success: function(data) {
				var avgInfo = eval('(' + data + ')');
				var $b = $('.'+getBlockClassName(orgId));
				$('.avg_ztime',$b).html(formateTiemStr(avgInfo.avg_ztime));
				$('.avg_wtime',$b).html(formateTiemStr(avgInfo.avg_wtime));
			}
		}); // ajax
	}// func
</script>
<!--content-->
<div class="content">
	<!----left---->
	<div class="left_box">
		<div class="left_menu">
			<h2>设备管理</h2>
			<div class="left_menu_tab">
				<ul>
					<li class="li1" style="width:100%"><a href="index.php?control=device" class="on">组织架构</a></li>
				</ul>
			</div>
			<div class="left_menu_tab">
				<ul>
					<li class="li1" style="width:100%"><a href="index.php?control=device&action=adMachine" class="on">广告机器</a></li>
				</ul>
			</div>
		</div>
	</div>

<a onclick="hiddenLeft()" class="hidden_left" style="background-color:#EEECED"></a>

<!----left end---->
<script>
	<?php foreach($www as $val): ?>
	$('li[auth="<?php echo $val['menurole_id'];?>"]').css('display', 'block');
	<?php endforeach;?>
</script>
	<!----left end---->

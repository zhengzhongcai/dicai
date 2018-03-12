<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box" style="min-height:800px;">
    <div class="left_menu">
      <h2>实时监控</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="<?php echo $session['baseurl']; ?>/index.php?control=monitor&fcode=monitor">组织架构</a></li>
	  <!--<li class="li1" style="width:100%"><a href="<?php echo $session['baseurl']; ?>/index.php?control=monitor&fcode=monitor&action=map">地图</a></li>-->
        </ul>
      </div>

      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">

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





<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>机构管理</h2>
      <div class="left_menu_tab">
        <ul>
          <li class="li1" style="width:100%"><a href="#" class="on">组织架构</a></li>
        </ul>
      </div>
      <div class="tree_menu" style="margin-top:50px;margin-right:8px;overflow-y: scroll;max-height: 600px;">
		<ul id="browser" class="filetree">
          <?php echo $session['orgtree']; ?>
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
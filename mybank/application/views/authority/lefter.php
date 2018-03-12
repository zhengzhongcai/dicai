<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2><?=lang('AUTH_LEFTER_MENU_TITLE')?lang('AUTH_LEFTER_MENU_TITLE'):'权限管理' ?></h2>
      
      <div class="left_menu_a_list">
        <ul>
          <li auth="208" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=authority&fcode=authority-u" ><?=lang('AUTH_LEFTER_MENU_MANAGER_USER')?lang('AUTH_LEFTER_MENU_MANAGER_USER'):'用户管理'?></a></li>
		  <li auth="204" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=authority&action=role&fcode=authority-r" ><?=lang('AUTH_LEFTER_MENU_MANAGER_ROLE')?lang('AUTH_LEFTER_MENU_MANAGER_ROLE'):'角色管理' ?></a></li>
		  <li auth="212" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=authority&action=log&fcode=authority-l" ><?=lang('AUTH_LEFTER_DATA')?lang('AUTH_LEFTER_DATA'):'日志管理' ?></a></li>
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
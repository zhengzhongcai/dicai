<!--content-->
<div class="content"> 
  <!----left---->
  <div class="left_box">
    <div class="left_menu">
      <h2>信息发布</h2>
      
      <div class="left_menu_a_list">
        <ul>
			<li auth="224" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=counterParam&fcode=evalu-l" >评价器清单</a></li>
			<li auth="228" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=task&fcode=evalu-l" >任务管理</a></li>
			<li auth="290" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=templateManage&fcode=evalu-l" >模块管理作</a></li>
			<li auth="292" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=profileManage&fcode=evalu-l" >节目管理</a></li>
			<li auth="294" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=projectManage&fcode=evalu-l" >播放计划管理</a></li>
			<li auth="296" class="statItem"><a href="<?php echo $session['baseurl']; ?>/index.php?control=evalu&action=fastManage&fcode=evalu-l" >快速创建节目</a></li>
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
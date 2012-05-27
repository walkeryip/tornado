<h2><?php echo $list['TaskList']['name'] ?></h2> 
<p><?php echo $list['TaskList']['description'] ?></p>
<i><?php echo $list['TaskList']['created'] ?></i>

<?php echo $html->link($list['Parent']['name'], array('action'=>'view', $list['Parent']['id'], null)); ?>

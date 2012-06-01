<h2><?php echo $list['TaskList']['name'] ?></h2> 
<p><?php echo $list['TaskList']['description'] ?></p>
<i><?php echo $list['TaskList']['created'] ?></i>

<h3>Parent</h3>
<p>
	<?php echo $html->link($list['Parent']['name'], array('action'=>'view', $list['Parent']['id'], null)); ?>
</p>

<h3>Sub lists</h3>
<div id="sub-lists">
	<?php echo $this->element('lists', array('lists' => $lists)); ?>
</div>

<h3>Tasks</h3>
<div id="tasks">
	<?php echo $this->element('tasks', array('tasks' => $tasks)); ?>
</div>

<h3>Done tasks</h3>
<div id="tasks-done">
	<?php echo $this->element('tasks', array('tasks' => $tasksDone)); ?>
</div>

<?php echo $this->element('add_task', array('list' => $list['TaskList'], 'tags' => $list['Tag'], 'contexts' => $list['Context'])); ?>
<?php echo $this->element('add_list', array('list' => $list['TaskList'], 'tags' => $list['Tag'], 'contexts' => $list['Context'])); ?>


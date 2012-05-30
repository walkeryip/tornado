<h2><?php echo $list['TaskList']['name'] ?></h2> 
<p><?php echo $list['TaskList']['description'] ?></p>
<i><?php echo $list['TaskList']['created'] ?></i>

<?php echo $html->link("Add sub list", array('action'=>'add', $list['Parent']['id'], null)); ?>

<!--<pre><code><?php print_r($tasks); ?></code></pre>-->
<h3>Parent</h3>
<?php echo $html->link($list['Parent']['name'], array('action'=>'view', $list['Parent']['id'], null)); ?>

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

<h3>Add task</h3>
<div id="add-task">
<?php echo $this->element('add_task', array('list' => $list['TaskList'])); ?>
</div>

<h3>Add list</h3>
<div id="add-list">
<?php echo $this->element('add_list', array('list' => $list['TaskList'])); ?>
</div>

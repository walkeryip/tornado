<h2><?php echo $context['Context']['name'] ?></h2> 
<i><?php echo $context['Context']['created'] ?></i>

<h3>Lists</h3>
<div id="lists">
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

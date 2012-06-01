<h2>Tasks</h2> 
<?php if(empty($tasks)): ?> 
<p>There are no tasks in this list </p>
<?php else: ?>
<div id="tasks">
	<?php echo $this->element('tasks', array('tasks' => $tasks)); ?>
</div>
<?php endif; ?>

<?php if(empty($tasksDone)): ?> 
<p>There are no tasks in this list </p>
<?php else: ?>
<h2>Tasks Done</h2> 
<div id="tasks-done">
	<?php echo $this->element('tasks', array('tasks' => $tasksDone)); ?>
</div>
<?php endif; ?>

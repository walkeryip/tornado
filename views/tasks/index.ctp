<h2>Tasks</h2> 
<?php if(empty($tasks)): ?> 
There are no tasks in this list 
<?php else: ?>
<table id="tasks_todo"> 
<tr> 
<!--<th>ID</th>-->
<th></th>
<th>Name</th>
<!--<th>Description</th>-->
<th>Created</th>
<th>Deadline</th>
<th>Priority</th>
<th>Labels</th>
<th>Contexts</th>
<th></th>
<th></th>
</tr>
<?php echo $this->element('tasks', array('tasks' => $tasks)); ?>
</table> 
<?php endif; ?>

<h2>Tasks Done</h2> 
<?php if(empty($tasksDone)): ?> 
There are no tasks in this list 
<?php else: ?>
<table id="tasks_done"> 
<tr> 
<!--<th>ID</th>-->
<th></th>
<th>Name</th>
<!--<th>Description</th>-->
<th>Created</th>
<th>Deadline</th>
<th>Priority</th>
<th>Labels</th>
<th>Contexts</th>
<th></th>
<th></th>
</tr>
<?php echo $this->element('tasks', array('tasks' => $tasksDone)); ?>
</table> 

<?php endif; ?>

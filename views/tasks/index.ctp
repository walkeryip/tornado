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
<?php foreach ($tasks as $task): ?>
<tr id="task-<?php echo $task['Task']['id'];?>"> 
<?php echo $this->element('task', array('task' => $task)); ?>
</tr>
<?php endforeach; ?>

</table> 
<?php endif; ?>

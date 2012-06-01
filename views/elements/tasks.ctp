<ul class="tasks">
	<?php foreach ($tasks as $task): ?>
	<li id="task-<?php echo $task['Task']['id'];?>"> 
		<?php echo $this->element('task', array('task' => $task)); ?>
	</li>
	<?php endforeach; ?>
</ul>

<tr> 
<!--<td> 
<?php echo $task['Task']['id'] ?> 
</td>-->
<td><?php 
	if ($task['Task']['checked']){
		echo $this->Form->checkbox('Task.checked', array('checked' => 'checked'));
	}else{
		echo $this->Form->checkbox('Task.checked');
	}?></td>
<td> 
<?php echo $html->link($task['Task']['name'], array('controller'=>'tasks', 'action'=>'view', $task['Task']['id'])); ?>
</td> 
<td> 
<?php echo $task['Task']['created'] ?>
</td>
<td>
<?php echo $task['Task']['deadline'] ?>
</td>
<td>
<?php echo $task['Task']['priority'] ?>
</td> 
<td>
<?php
	foreach ($task['Tag'] as $tag){
		echo $html->link($tag['name'], array('controller'=>'tags', 'action'=>'view', $tag['id']));
		echo ' ';
	}
?>
</td>
<td>
<?php
	foreach ($task['Context'] as $context){
		echo $html->link($context['name'], array('controller'=>'contexts', 'action'=>'view', $context['id']));
		echo ' ';
	}
?>
</td>
<td>
<?php echo $html->link('Edit', array('action'=>'edit', $task['Task']['id'])); ?>
</td> 
<td>
<?php echo $html->link('Delete', array('action'=>'delete', $task['Task']['id'], null)); ?>
</td>
</tr>

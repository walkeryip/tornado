<div class="task">
	<p>
	<?php 
		$taskId = $task['Task']['id'];
		if ($task['Task']['checked']){
			$url = $this->Html->url(array('controller' => 'tasks', 'action' => 'uncheck'));
			echo $this->Form->checkbox('Task.checked', array('checked' => 'checked', 
				'onClick' => 'new Ajax.Updater(\'task-' . $taskId . '\',\'' . $url . '/' . $taskId . '\' , {asynchronous:true, evalScripts:true});'));
		}else{
			$url = $this->Html->url(array('controller' => 'tasks', 'action' => 'check'));
			echo $this->Form->checkbox('Task.checked', array(
				'onClick' => 'new Ajax.Updater(\'task-' . $taskId . '\',\'' . $url . '/' . $taskId . '\' , {asynchronous:true, evalScripts:true});'));
		}
	?>
	</p>
	<p> 
	<?php echo $html->link($task['Task']['name'], array('controller'=>'tasks', 'action'=>'view', $taskId)); ?>
	</p> 

	<a href="#" class="info-button expandable-div-button" onclick="expandableDivButtonClick(this); return false;">I</a>
	<div class="info expandable-div" style="display: none">
		<p> 
		<?php echo $task['Task']['created'] ?>
		</p>
		<p>
		<?php echo $task['Task']['deadline'] ?>
		</p>
		<p>
		<?php echo $task['Task']['priority'] ?>
		</p> 
		<p>
		<?php
			foreach ($task['Tag'] as $tag){
				echo $html->link($tag['name'], array('controller'=>'tags', 'action'=>'view', $tag['id']));
				echo ' ';
			}
		?>
		</p>
		<p>
		<?php
			foreach ($task['Context'] as $context){
				echo $html->link($context['name'], array('controller'=>'contexts', 'action'=>'view', $context['id']));
				echo ' ';
			}
		?>
		</p>
	</div>

	<a href="#" class="settings-button expandable-div-button" onclick="expandableDivButtonClick(this); return false;">O</a>
	<div class="settings expandable-div" style="display: none">
		<p>
		<?php echo $ajax->link('Edit', '/tasks/edit/' . $taskId,
						array('update' => 'task-' . $taskId)); ?>
		</p> 
		<p>
		<?php echo "<a class=\"delete\" href=\"#\" onclick=\"deleteTask(" . $taskId . ",'" . $task['Task']['name'] . "'); return false;\">Delete</a>"; ?>
		</p>
	</div>
</div>

<?php echo $form->create('Task');?> 
	<legend>Edit Task</legend>
	<?php
	echo $form->input('name');
	echo $form->input('description');
	echo $form->input('deadline');
	echo $form->input('priority');
	?>
	<legend>Tags</legend>
	<?php echo $form->input('Task.tags', array(
					'type' => 'textarea',
					'label' => __('Tags', true),
					'after' => __('Separate each tag with a ","', true)));
	?>
	<legend>Contexts</legend>
	<?php echo $form->input('Task.contexts', array(
					'type' => 'textarea',
					'label' => __('Contexts', true),
					'after' => __('Separate each context with a ","', true)));
	?>
	<?php echo $ajax->submit('Submit', array('url'=> '/tasks/edit/' . $taskId, 'update' => 'task-' . $taskId)); ?>
<?php echo $form->end();?>

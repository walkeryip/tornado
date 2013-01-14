<a href="#" class="expandable-div-button" onclick="modalDivButtonClick(this); return false;">Add task</a>
<div id="add-task" class="modal" style="display: none">
	<div class="modal-content">
	<?php echo $form->create('Task');?> 
		<?php
		echo $form->input('name');
		?>
		<?php		
		echo $form->input('description');
		echo $form->input('deadline');
		echo $form->input('priority');
		?>
		<?php 
			echo $form->input('Task.tags', array(
						'type' => 'textarea',
						'label' => __('Tags', true),
						'after' => __('Separate each tag with a ","', true),
						'value' => implode_model(", ", $tags, "name")));
		?>
		<?php 
			echo $form->input('Task.contexts', array(
						'type' => 'textarea',
						'label' => __('Contexts', true),
						'after' => __('Separate each context with a ","', true),
						'value' => implode_model(", ", $contexts, "name")));
		?>
		<?php echo $ajax->submit('Add task', array('url'=> '/tasks/add/' . $list['id'], 'update' => 'tasks')); ?>
	<?php echo $form->end();?>
	</div>
</div>

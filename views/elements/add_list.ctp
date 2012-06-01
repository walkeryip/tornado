<a href="#" class="expandable-div-button" onclick="modalDivButtonClick(this); return false;">Add list</a>
<div id="add-list" class="modal" style="display: none">
<?php echo $form->create('TaskList');?> 
	<?php
	echo $form->input('name');
	echo $form->input('description');
	?>
	<?php 
		echo $form->input('TaskList.tags', array(
					'type' => 'textarea',
					'label' => __('Tags', true),
					'after' => __('Separate each tag with a ","', true),
					'value' => implode_model(", ", $tags, "name")));
	?>
	<?php 
		echo $form->input('TaskList.contexts', array(
					'type' => 'textarea',
					'label' => __('Contexts', true),
					'after' => __('Separate each context with a ","', true),
					'value' => implode_model(", ", $contexts, "name")));
	?>
	<?php echo $ajax->submit('Submit', array('url'=> '/task_lists/add/' . $list['id'], 'update' => 'sub-lists')); ?>
<?php echo $form->end();?>
</div>



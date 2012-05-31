<?php echo $form->create('Task');?> 
<fieldset> 
<?php
echo $form->input('name');
echo $form->input('description');
echo $form->input('deadline');
echo $form->input('priority');
?>
</fieldset>
<fieldset>
<legend>Tags</legend>
<?php 
	echo $form->input('Task.tags', array(
				'type' => 'textarea',
				'label' => __('Tags', true),
				'after' => __('Separate each tag with a ","', true),
				'value' => implode_model(", ", $tags, "name")));
?>
</fieldset>
<fieldset>
<legend>Contexts</legend>
<?php 
	echo $form->input('Task.contexts', array(
				'type' => 'textarea',
				'label' => __('Contexts', true),
				'after' => __('Separate each context with a ","', true),
				'value' => implode_model(", ", $contexts, "name")));
?>
</fieldset>
<?php echo $ajax->submit('Submit', array('url'=> '/tasks/add/' . $list['id'], 'update' => 'tasks')); ?>
<?php echo $form->end();?>

<?php echo $form->create('Task');?> 
<fieldset> 
<legend>Edit Task</legend>
<?php
echo $form->input('id');
echo $form->input('name');
echo $form->input('checked');
echo $form->input('description');
echo $form->input('deadline');
echo $form->input('priority');
?>
</fieldset>
<fieldset>
<legend>Tags</legend>
<?php echo $form->input('Task.tags', array(
				'type' => 'textarea',
				'label' => __('Tags', true),
				'after' => __('Separate each tag with a ","', true)));
?>
</fieldset>
<fieldset>
<legend>Contexts</legend>
<?php echo $form->input('Task.contexts', array(
				'type' => 'textarea',
				'label' => __('Contexts', true),
				'after' => __('Separate each context with a ","', true)));
?>
</fieldset>
<?php echo $form->end('Save');?>

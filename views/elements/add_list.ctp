<?php echo $form->create('TaskList');?> 
<?php
echo $form->input('name');
echo $form->input('description');
?>
</fieldset>
<fieldset>
<legend>Tags</legend>
<?php echo $form->input('TaskList.tags', array(
				'type' => 'textarea',
				'label' => __('Tags', true),
				'after' => __('Separate each tag with a ","', true)));
?>
</fieldset>
<fieldset>
<legend>Contexts</legend>
<?php echo $form->input('TaskList.contexts', array(
				'type' => 'textarea',
				'label' => __('Contexts', true),
				'after' => __('Separate each context with a ","', true)));
?>
</fieldset>
<?php echo $ajax->submit('Submit', array('url'=> '/task_lists/add/' . $list['id'], 'update' => 'sub-lists')); ?>
<?php echo $form->end();?>



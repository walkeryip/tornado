<td colspan=9>
<?php echo $form->create('TaskList');?> 
<fieldset> 
<legend>Edit List</legend>
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
<?php echo $ajax->submit('Submit', array('url'=> '/task_lists/edit/' . $listId, 'update' => 'list-' . $listId)); ?>
<?php echo $form->end();?>
</td>

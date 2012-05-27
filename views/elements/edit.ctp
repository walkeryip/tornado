<tr>
<?php echo $form->create('Task');?> 
<th><?php echo $form->input('checked'); ?></th>
<th><?php echo $form->input('name'); ?></th>
<th></th>
<th><?php echo $form->input('deadline'); ?></th>
<th><?php echo $form->input('priority'); ?></th>
<th><?php echo $form->input('Task.tags', array(
				'type' => 'textarea',
				'label' => __('Tags', true),
				'after' => __('Separate each tag with a ","', true)));
?></th>
<th><?php echo $form->input('Task.contexts', array(
				'type' => 'textarea',
				'label' => __('Contexts', true),
				'after' => __('Separate each context with a ","', true)));
?></th>
<th></th>
<th></th>
<?php echo $form->end('Save');?>
</tr>

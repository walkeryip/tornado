<h2>Contexts</h2> 
<?php if(empty($contexts)): ?> 
There are no contexts 
<?php else: ?>
<table> 
<tr> 
<!-- <th>ID</th> -->
<th>Name</th>
<th>Created</th>
<th></th>
<th></th>
</tr>
<?php foreach ($contexts as $context): ?>
<tr> 
<!--<td> 
<?php //echo $context['Context']['id'] ?> 
</td>-->
<td> 
<?php echo $html->link($context['Context']['name'], array('action'=>'view', 'controller'=>'contexts', $context['Context']['id'])); ?>
</td> 
<td> 
<?php echo $context['Context']['created'] ?>
</td> 
<td>
<?php echo $html->link('Edit', array('action'=>'edit', $context['Context']['id'])); ?>
</td> 
<td>
<?php echo $html->link('Delete', array('action'=>'delete', $context['Context']['id'], null)); ?>
</td>
</tr>
<?php endforeach; ?> 
</table> 
<?php endif; ?>

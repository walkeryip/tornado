<h2>Tags</h2> 
<?php if(empty($tags)): ?> 
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
<?php foreach ($tags as $tag): ?>
<tr> 
<!--<td> 
<?php //echo $context['Context']['id'] ?> 
</td>-->
<td> 
<?php echo $html->link($tag['Tag']['name'], array('action'=>'view', 'controller'=>'tags', $tag['Tag']['id'])); ?>
</td> 
<td> 
<?php echo $tag['Tag']['created'] ?>
</td> 
</tr>
<?php endforeach; ?> 
</table> 
<?php endif; ?>

<h2>Lists</h2> 
<?php if(empty($lists)): ?> 
There are no tasks in this list 
<?php else: ?>
<table id="tasklists_todo"> 
<tr> 
<!--<th>ID</th>-->
<th></th>
<th>Name</th>
<th>Created</th>
<th>Labels</th>
<th>Contexts</th>
<th>Parent</th>
<th></th>
<th></th>
</tr>
<?php echo $this->element('lists', array('lists' => $lists)); ?>

</table> 
<?php endif; ?>

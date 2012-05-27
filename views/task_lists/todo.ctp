<h2>ToDo Lists</h2> 
<?php if(empty($lists)): ?> 
There are no lists here 
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
<?php foreach ($lists as $list): ?>
<tr id="list-<?php echo $list['TaskList']['id'];?>"> 
<?php echo $this->element('list', array('list' => $list)); ?>
</tr>
<?php endforeach; ?>

</table> 
<?php endif; ?>

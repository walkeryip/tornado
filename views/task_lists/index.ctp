<h2>Lists</h2> 
<?php if(empty($lists)): ?> 
<p>There are no tasks in this list</p>
<?php else: ?>
<div id="lists">
	<?php echo $this->element('lists', array('lists' => $lists)); ?>
</div>
<?php endif; ?>

<h2>Contexts</h2> 
<?php if(empty($contexts)): ?> 
<p>There are no contexts</p>
<?php else: ?>
<ul> 
	<?php foreach ($contexts as $context): ?>
	<li> 
		<p> 
		<?php echo $html->link($context['Context']['name'], array('action'=>'view', 'controller'=>'contexts', $context['Context']['id'])); ?>
		</p> 
		<p> 
		<?php echo $context['Context']['created'] ?>
		</p> 
		<p>
		<?php echo $html->link('Edit', array('action'=>'edit', $context['Context']['id'])); ?>
		</p> 
		<p>
		<?php echo $html->link('Delete', array('action'=>'delete', $context['Context']['id'], null)); ?>
		</p>
	</li>
	<?php endforeach; ?> 
</ul> 
<?php endif; ?>

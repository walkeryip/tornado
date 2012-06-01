<h2>Tags</h2> 
<?php if(empty($tags)): ?> 
<p>There are no contexts </p>
<?php else: ?>

<div id="tags">
	<?php foreach ($tags as $tag): ?>
	<ul> 
		<li>
			<?php echo $html->link($tag['Tag']['name'], array('action'=>'view', 'controller'=>'tags', $tag['Tag']['id'])); ?>
			<?php echo $tag['Tag']['created'] ?>
		</li>
	</ul>
	<?php endforeach; ?> 
</div> 
<?php endif; ?>

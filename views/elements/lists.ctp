<ul class="lists">
	<?php foreach ($lists as $list): ?>
	<li id="list-<?php echo $list['TaskList']['id'];?>"> 
		<?php echo $this->element('list', array('list' => $list)); ?>
	</li>
	<?php endforeach; ?>
</ul>

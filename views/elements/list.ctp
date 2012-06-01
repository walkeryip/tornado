<div class="list">
	<p> 
	<?php echo $html->link($list['TaskList']['name'], array('controller'=>'task_lists', 'action'=>'view', $list['TaskList']['id'])); ?>
	</p>

	<a href="#" class="info-button expandable-div-button" onclick="expandableDivButtonClick(this); return false;">I</a>
	<div class="info expandable-div" style="display: none">
		<p> 
		<?php echo $list['TaskList']['created'] ?>
		</p>
		<p>
		<?php
			foreach ($list['Tag'] as $tag){
				echo $html->link($tag['name'], array('controller'=>'tags', 'action'=>'view', $tag['id']));
				echo ' ';
			}
		?>
		</p>
		<p>
		<?php
			foreach ($list['Context'] as $context){
				echo $html->link($context['name'], array('controller'=>'contexts', 'action'=>'view', $context['id']));
				echo ' ';
			}
		?>
		</p>
		<p>
		<?php
			echo $html->link($list['Parent']['name'], array('controller'=>'task_lists', 'action'=>'view', $list['Parent']['id'])); //$list['Parent']['name'];
		?>
		</p>
	</div> 
	<a href="#" class="settings-button expandable-div-button" onclick="expandableDivButtonClick(this); return false;">O</a>
	<div class="settings expandable-div" style="display: none">
		<p>
		<?php echo $ajax->link('Edit', '/task_lists/edit/' . $list['TaskList']['id'],
						array('update' => 'list-' . $list['TaskList']['id'])); ?>
		</p> 
		<p>
		<?php echo $html->link('Delete', array('controller'=>'task_lists', 'action'=>'delete', $list['TaskList']['id'], null)); ?>
		</p>
	</div>
	
	
</div>

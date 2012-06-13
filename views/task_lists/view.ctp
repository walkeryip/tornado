<script type="text/javascript">
	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $list['TaskList']['id']; ?>, "ListView", "#tasks");
		//var contextView = new Tornado.TagView(<?php //echo $tag['Tag']['id']; ?>, "TagView", "#tag-tasks");
		Tornado.viewManager.addView(listView);
		//Tornado.viewManager.addView(contextView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = <?php echo $list['TaskList']['id'] ?>;
		defaultList.name = "<?php echo $list['TaskList']['name'] ?>";
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<h2><?php echo $list['TaskList']['name'] ?></h2> 
<p><?php echo $list['TaskList']['description'] ?></p>
<i><?php echo $list['TaskList']['created'] ?></i><br />

<?php echo $html->link('Delete list', array('controller'=>'task_lists', 'action'=>'delete', $list['TaskList']['id'], null)); ?>
<?php echo $this->element('add_task', array('list' => $list['TaskList'], 'tags' => $list['Tag'], 'contexts' => $list['Context'])); ?>
<?php echo $this->element('add_list', array('list' => $list['TaskList'], 'tags' => $list['Tag'], 'contexts' => $list['Context'])); ?>

<h3>Parent</h3>
<p>
	<?php echo $html->link($list['Parent']['name'], array('action'=>'view', $list['Parent']['id'], null)); ?>
</p>
<div style="float: left">
<h3>Tasks</h3>
<div id="tasks">
	<?php //echo $this->element('tasks', array('tasks' => $tasks)); ?>
</div>


<!--<h3>Sub lists</h3>
<div id="sub-lists">
	<?php //echo $this->element('lists', array('lists' => $lists)); ?>
</div>



<h3>Done tasks</h3>
<div id="tasks-done">
	<?php //echo $this->element('tasks', array('tasks' => $tasksDone)); ?>
</div>
</div>
<div style="float: left">
<h3>C Tasks</h3>
<div id="context-tasks">
	<?php //echo $this->element('tasks', array('tasks' => $tasks)); ?>
</div>
</div>-->

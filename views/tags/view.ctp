<script type="text/javascript">
	jq(document).ready(function () {
		//var listView = new Tornado.ListView(5, "ListView");
		var contextView = new Tornado.TagView(<?php echo $tag['Tag']['id']; ?>, "TagView", "#tag-tasks");
		//Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(contextView);
		
		var defaultTag = {};
		defaultTag.id = <?php echo $tag['Tag']['id'] ?>;
		defaultTag.name = "<?php echo $tag['Tag']['name'] ?>";

		Tornado.setDefaultTag(defaultTag);
	});
</script>

<h2><?php echo $tag['Tag']['name'] ?></h2> 
<i><?php echo $tag['Tag']['created'] ?></i>

<div id="tag-tasks"></div>
<!--
<h3>Lists</h3>
<div id="lists">
	<?php //echo $this->element('lists', array('lists' => $lists)); ?>
</div>

<h3>Tasks</h3>
<div id="tasks">
	<?php //echo $this->element('tasks', array('tasks' => $tasks)); ?>
</div>

<h3>Done tasks</h3>
<div id="tasks-done">
	<?php //echo $this->element('tasks', array('tasks' => $tasksDone)); ?>
</div>

-->

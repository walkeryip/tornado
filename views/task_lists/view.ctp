<?php echo "test"; ?>
<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $list_id; ?>, "#tasks");
		var tagView = new Tornado.TagView(22, "#tag-tasks");
		var tagView2 = new Tornado.TagView(41, "#tag-tasks2");
		var contextView = new Tornado.ContextView(6, "#context-tasks");
		var taskView = new Tornado.TaskView("#task-view");
		Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(tagView);
		Tornado.viewManager.addView(tagView2);
		Tornado.viewManager.addView(contextView);
		Tornado.viewManager.addView(taskView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = <?php echo $list_id ?>;
		
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<div class="column">
	<div id="tasks"></div>
	<div id="task-view"></div>
</div>
<div class="column">
	<div id="tag-tasks"></div>
	<div id="tag-tasks2"></div>
	<div id="context-tasks"></div>
</div>

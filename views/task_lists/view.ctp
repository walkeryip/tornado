<?php echo "test"; ?>
<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $task_list_id; ?>, "#tasks");
		Tornado.viewManager.addView(listView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = <?php echo $task_list_id ?>;
		
		
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

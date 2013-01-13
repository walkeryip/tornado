<h2>Tasks</h2>
<script type="text/javascript">

	jq(document).ready(function () {
		var tasksDonePanel = new Tornado.TaskPanel("#tasks-done-panel", {title: "Done tasks", checked: true});
		Tornado.panelManager.addPanel(tasksDonePanel);

		var tasksPanel = new Tornado.TaskPanel("#tasks-panel", {title: "Uncompleted tasks"});
		Tornado.panelManager.addPanel(tasksPanel);
	});
</script>
<div id="tasks-panel"></div>
<div id="tasks-done-panel"></div>

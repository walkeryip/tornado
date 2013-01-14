<h2>Shared</h2>
<script type="text/javascript">

	jq(document).ready(function () {
		var tasksPanel = new Tornado.TaskPanel("#tasks-panel", {title: "Shared tasks", shared: true});
		Tornado.panelManager.addPanel(tasksPanel);
		var listsPanel = new Tornado.ListsPanel("#lists-panel", {title: "Shared lists", shared: true});
		Tornado.panelManager.addPanel(listsPanel);
	});
</script>
<div id="tasks-panel"></div>
<div id="lists-panel"></div>

<script type="text/javascript">

	jq(document).ready(function () {
		var listPanel = new Tornado.ListPanel(5, "#tasks");
		var tagsPanel = new Tornado.TagsPanel("#tags");
		var contextsPanel = new Tornado.ContextsPanel("#contexts");
		var tagPanel2 = new Tornado.TagPanel(40, "#tag-tasks2");
		var contextPanel = new Tornado.ContextPanel(6, "#context-tasks");
		var taskPanel = new Tornado.TaskPanel("#task-panel");
		Tornado.panelManager.addPanel(listPanel);
		Tornado.panelManager.addPanel(tagsPanel);
		Tornado.panelManager.addPanel(contextsPanel);
		Tornado.panelManager.addPanel(tagPanel2);
		Tornado.panelManager.addPanel(contextPanel);
		Tornado.panelManager.addPanel(taskPanel);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = 5;
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<div class="column">
	<div id="tasks"></div>
	<div id="task-panel"></div>
</div>
<div class="column">
	<div id="tags"></div>
	<div id="contexts"></div>
	<div id="tag-tasks2"></div>
	<div id="context-tasks"></div>
</div>

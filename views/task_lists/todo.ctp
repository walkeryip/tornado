<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(5, "#tasks");
		var tagsView = new Tornado.TagsView("#tags");
		var contextsView = new Tornado.ContextsView("#contexts");
		var tagView2 = new Tornado.TagView(40, "#tag-tasks2");
		var contextView = new Tornado.ContextView(6, "#context-tasks");
		var taskView = new Tornado.TaskView("#task-view");
		Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(tagsView);
		Tornado.viewManager.addView(contextsView);
		Tornado.viewManager.addView(tagView2);
		Tornado.viewManager.addView(contextView);
		Tornado.viewManager.addView(taskView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = 5;
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<div class="column">
	<div id="tasks"></div>
	<div id="task-view"></div>
</div>
<div class="column">
	<div id="tags"></div>
	<div id="contexts"></div>
	<div id="tag-tasks2"></div>
	<div id="context-tasks"></div>
</div>

<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $task_list_id; ?>, "#tasks");
		Tornado.viewManager.addView(listView);
		var defaultList = {};
		var defaultUser = {};

		defaultList.id = <?php echo $task_list_id ?>;
		defaultUser.id = <?php echo $user_id ?>;
				
		Tornado.setDefaultList(defaultList);
		Tornado.setDefaultUser(defaultUser);
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

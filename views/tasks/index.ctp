<h2>Tasks</h2>
<script type="text/javascript">

	jq(document).ready(function () {
		var tasksDoneView = new Tornado.TaskView("#tasks-done-view", {title: "Done tasks", checked: true});
		Tornado.viewManager.addView(tasksDoneView);

		var tasksView = new Tornado.TaskView("#tasks-view", {title: "Uncompleted tasks"});
		Tornado.viewManager.addView(tasksView);


		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		defaultUser.name = "<?php echo $_SESSION['Auth']['User']['username']; ?>";
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="tasks-view"></div>
<div id="tasks-done-view"></div>

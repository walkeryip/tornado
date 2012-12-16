<h2>Shared</h2>
<script type="text/javascript">

	jq(document).ready(function () {
		var tasksView = new Tornado.TaskView("#tasks-view", {title: "Shared tasks", shared: true});
		Tornado.viewManager.addView(tasksView);

		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		defaultUser.name = "<?php echo $_SESSION['Auth']['User']['username']; ?>";
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="tasks-view"></div>
<div id="task-lists-view"></div>

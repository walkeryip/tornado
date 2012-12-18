<h2>Shared</h2>
<script type="text/javascript">

	jq(document).ready(function () {
		var tasksView = new Tornado.TaskView("#tasks-view", {title: "Shared tasks", shared: true});
		Tornado.viewManager.addView(tasksView);
		var listsView = new Tornado.ListsView("#lists-view", {title: "Shared lists", shared: true});
		Tornado.viewManager.addView(listsView);

		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		defaultUser.name = "<?php echo $_SESSION['Auth']['User']['username']; ?>";
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="tasks-view"></div>
<div id="lists-view"></div>

<script type="text/javascript">

	jq(document).ready(function () {
		var listsView = new Tornado.ListsView("#lists-view");
		Tornado.viewManager.addView(listsView);

		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		defaultUser.name = <?php echo $_SESSION['Auth']['User']['username']; ?>;
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="lists-view"></div>

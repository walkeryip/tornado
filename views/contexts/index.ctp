<script type="text/javascript">

	jq(document).ready(function () {
		var contextsView = new Tornado.ContextsView("#contexts-view");
		Tornado.viewManager.addView(contextsView);

		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="contexts-view"></div>

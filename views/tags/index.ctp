<script type="text/javascript">

	jq(document).ready(function () {
		var tagsView = new Tornado.TagsView("#tags-view");
		Tornado.viewManager.addView(tagsView);

		var defaultUser = {};
		defaultUser.id = <?php echo $user_id ?>;
		Tornado.setDefaultUser(defaultUser);
	});
</script>
<div id="tags-view"></div>

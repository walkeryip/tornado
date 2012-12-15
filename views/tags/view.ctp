<script type="text/javascript">
	jq(document).ready(function () {
		var tagView = new Tornado.TagView(<?php echo $tag_id; ?>, "#tag-tasks");
		Tornado.viewManager.addView(tagView);

        var defaultTag = {};
		var defaultUser = {};

     	defaultTag.id = <?php echo $tag_id; ?>;
		defaultUser.id = <?php echo $user_id ?>;

     	Tornado.setDefaultTag(defaultTag);
		Tornado.setDefaultUser(defaultUser);
	});
</script>

<div id="tag-tasks"></div>


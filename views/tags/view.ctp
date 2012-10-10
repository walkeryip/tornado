<script type="text/javascript">
	jq(document).ready(function () {
		var tagView = new Tornado.TagView(<?php echo $tag_id; ?>, "#tag-tasks");
		Tornado.viewManager.addView(tagView);

        var defaultTag = {};
     	defaultTag.id = <?php echo $tag_id; ?>;

     	Tornado.setDefaultTag(defaultTag);
	});
</script>

<div id="tag-tasks"></div>


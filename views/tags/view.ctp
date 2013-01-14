<script type="text/javascript">
	jq(document).ready(function () {
		var tagPanel = new Tornado.TagPanel(<?php echo $tag_id; ?>, "#tag-tasks");
		Tornado.panelManager.addPanel(tagPanel);
		Tornado.state.setContext({id: <?php echo $tag_id; ?>});
	});
</script>

<div id="tag-tasks"></div>


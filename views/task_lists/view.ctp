<?php echo "test"; ?>
<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $list_id; ?>, "#tasks");
		var contextView = new Tornado.TagView(22, "#tag-tasks");
		Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(contextView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = <?php echo $list_id ?>;
		
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<div id="tasks"></div>
<div id="tag-tasks"></div>

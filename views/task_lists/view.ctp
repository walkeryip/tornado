<?php echo "test"; ?>
<script type="text/javascript">

	jq(document).ready(function () {
		var listView = new Tornado.ListView(<?php echo $list_id; ?>, "ListView", "#tasks");
		var contextView = new Tornado.TagView(22, "TagView", "#tag-tasks");
		Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(contextView);
		var defaultList = {};
		var defaultContext = {};

		defaultList.id = <?php echo $list_id ?>;
		
		
		Tornado.setDefaultList(defaultList);
	});
</script>

<div style="float:right;" id="tasks"></div>
<div style="float: right;" id="tag-tasks"></div>

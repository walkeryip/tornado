<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Tag",
		    type: "tag",
		    tag_id: <?php echo $tag_id ?>,
		    deleted: false,
		    checked: false,
		    showLists: true,
		    showTasks: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>

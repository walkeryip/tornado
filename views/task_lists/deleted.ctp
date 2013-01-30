<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Trash",
		    type: "list",
		    deleted: true,
		    children: true,
		    showLists: true,
		    showTasks: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>
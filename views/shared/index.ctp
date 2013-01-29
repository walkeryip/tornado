<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Shared",
		    type: "list",
		    deleted: false,
		    checked: false,
		    children: true,
		    showLists: true,
		    shared: true,
		    showTasks: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>
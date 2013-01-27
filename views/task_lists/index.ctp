<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Lists",
		    type: "list",
		    parent_id: null,
		    children: true,
		    showLists: true,
		    deleted: false});
		Tornado.panelManager.addPanel(panel);
	});
</script>

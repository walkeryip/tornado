<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Context",
		    type: "context",
		    context_id: <?php echo $context_id ?>,
		    //active: true,
		    deleted: false,
		    checked: false,
		    //children: true,
		    showLists: true,
		    showTasks: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>

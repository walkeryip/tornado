<script type="text/javascript">

	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Tasks",
		    type: "task",
		    checked: false,
		    deleted: false,
		    showTasks: true,
		    });
		Tornado.panelManager.addPanel(panel);
		
		var panel2 = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Done Tasks",
		    type: "task",
		    checked: true,
		    deleted: false,
		    showTasks: true,
		    });
		Tornado.panelManager.addPanel(panel2);
	});
</script>

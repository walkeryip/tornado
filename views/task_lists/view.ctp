<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Lists",
		    type: "list",
		    list_id: <?php echo $task_list_id ?>,
		    parent_id: <?php echo $task_list_id ?>,
		    deleted: false,
		    breadcrumbs: {
		      id: <?php echo $task_list_id ?>,
		      type: "list"
		      },
		      showTitle: true,
		      showDescription: true,		      
		    checked: false,
		    children: true,
		    showLists: true,
		    showTasks: true});

		var panel_done = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Lists",
		    type: "list",
		    list_id: <?php echo $task_list_id ?>,
		    parent_id: <?php echo $task_list_id ?>,
		    deleted: false,
		    checked: true,
		    showTitle: false,
		    showDescription: false,
		 
		    children: true,
		    //showLists: true,
		    showTasks: true});

		Tornado.panelManager.addPanel(panel);
		Tornado.panelManager.addPanel(panel_done);
		Tornado.state.setList({id: <?php echo $task_list_id ?>});
	});
</script>
<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Contexts",
		    type: "context",
		    showContexts: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>

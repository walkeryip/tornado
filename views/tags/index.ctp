<script type="text/javascript">
	jq(document).ready(function () {
		var panel = new Tornado.GeneralPanel("test", "#content", 
		    {title: "Tags",
		    type: "tag",
		    breadcrumbs: {
		      type: "tag"
		      },
		    showTags: true});
		Tornado.panelManager.addPanel(panel);
	});
</script>

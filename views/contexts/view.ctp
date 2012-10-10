<script type="text/javascript">
	jq(document).ready(function () {
		var contextView = new Tornado.ContextView(<?php echo $context_id; ?>, "#context-tasks");
		Tornado.viewManager.addView(contextView);

        var defaultContext = {};
     	defaultContext.id = <?php echo $context_id; ?>;

     	Tornado.setDefaultContext(defaultContext);
	});
</script>

<h3>Tasks</h3>
<div id="context-tasks"></div>

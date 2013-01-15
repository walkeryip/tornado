<script type="text/javascript">
	jq(document).ready(function () {
		var contextPanel = new Tornado.ContextPanel(<?php echo $context_id; ?>, "#context-tasks");
		Tornado.panelManager.addPanel(contextPanel);
		Tornado.state.setContext({id: <?php echo $context_id; ?>});
	});
</script>

<div id="context-tasks"></div>

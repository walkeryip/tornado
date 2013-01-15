<script type="text/javascript">

	jq(document).ready(function () {
		var listPanel = new Tornado.ListPanel(<?php echo $task_list_id; ?>, "#tasks");
		Tornado.panelManager.addPanel(listPanel);
		Tornado.state.setList({id: <?php echo $task_list_id ?>});
	});
</script>

<div class="column">
	<div id="tasks"></div>
	<div id="task-panel"></div>
</div>
<div class="column">
	<div id="tag-tasks"></div>
	<div id="tag-tasks2"></div>
	<div id="context-tasks"></div>
</div>

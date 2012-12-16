<script type="text/javascript">
	jq(document).ready(function () {
		var contextView = new Tornado.ContextView(<?php echo $context_id; ?>, "#context-tasks");
		Tornado.viewManager.addView(contextView);

        var defaultContext = {};
		var defaultUser = {};

     	defaultContext.id = <?php echo $context_id; ?>;
		defaultUser.id = <?php echo $user_id ?>;

     	Tornado.setDefaultContext(defaultContext);
		Tornado.setDefaultUser(defaultUser);
	});
</script>

<div id="context-tasks"></div>

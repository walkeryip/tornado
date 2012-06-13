<script type="text/javascript">
	jq(document).ready(function () {
		//var listView = new Tornado.ListView(5, "ListView");
		var contextView = new Tornado.ContextView(<?php echo $context['Context']['id']; ?>, "ContextView", "#context-tasks");
		//Tornado.viewManager.addView(listView);
		Tornado.viewManager.addView(contextView);

        var defaultContext = {};
     	defaultContext.id = 6;

     	Tornado.setDefaultContext(defaultContext);
	});
</script>

<h2><?php echo $context['Context']['name'] ?></h2> 
<i><?php echo $context['Context']['created'] ?></i>
<!--
<h3>Lists</h3>
<div id="lists">
	<?php echo $this->element('lists', array('lists' => $lists)); ?>
</div>-->

<h3>Tasks</h3>
<div id="context-tasks"></div>

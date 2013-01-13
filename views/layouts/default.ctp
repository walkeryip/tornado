<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('t[x]rnado ::'); ?>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $this->Html->css('normalize');
    echo $this->Html->css('common');

    echo $scripts_for_layout;
    ?>
    <script type="text/javascript" src="/tornado/js/lib/mustache.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/prototype.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery.simplemodal.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery.tinysort.min.js"></script>


    <script>
        jQuery.noConflict();
        var jq = jQuery;
    </script>

    <script type="text/javascript" src="/tornado/js/tornado.js"></script>
    <script type="text/javascript" src="/tornado/js/common.js"></script>
    <script type="text/javascript" src="/tornado/js/state.js"></script>
    <script type="text/javascript" src="/tornado/js/panel-manager.js"></script>
    <script type="text/javascript" src="/tornado/js/breadcrumbs.js"></script>
    <script type="text/javascript" src="/tornado/js/navigationtree.js"></script>
    <script type="text/javascript" src="/tornado/js/models/item.js"></script>
    <script type="text/javascript" src="/tornado/js/models/label.js"></script>
    <script type="text/javascript" src="/tornado/js/models/tag.js"></script>
    <script type="text/javascript" src="/tornado/js/models/context.js"></script>
    <script type="text/javascript" src="/tornado/js/models/task.js"></script>
    <script type="text/javascript" src="/tornado/js/models/list.js"></script>
    <script type="text/javascript" src="/tornado/js/models/label.js"></script>
    <script type="text/javascript" src="/tornado/js/models/user.js"></script>
    <script type="text/javascript" src="/tornado/js/views/element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/task-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/list-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/tag-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/context-element.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/mixed-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/single-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/task-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/list-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/context-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/tag-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/lists-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/deadline-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/todo-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/tags-panel.js"></script>
    <script type="text/javascript" src="/tornado/js/panels/contexts-panel.js"></script>
	<script>	
		Tornado.initialize();
		Tornado.state.setUser({id: <? echo $_SESSION['Auth']['User']['id']; ?>, name: "<? echo $_SESSION['Auth']['User']['username']; ?>"});
	</script>
</head>
<body>
<div id="user-menu">
<? if (isset($_SESSION['Auth']['User'])) {?>

<p class="user-logged-in">Logged in as <? echo $_SESSION['Auth']['User']['username']; ?></p>
<p class="auth-actions"><a href="/tornado/logout">Logout</a></p>

<? } else { ?>
<p class="auth-actions">
<a href="/tornado/login">Login</a>
<a href="/tornado/register">Register</a>
</p>
<? } ?>
</div>

<div id="container">
    <div id="header">
        <h1><?php echo $this->Html->link(__('t[x]rnado', true), '/'); ?></h1>
    </div>
<? if (isset($_SESSION['Auth']['User'])) { ?>
    <div id="menu">
        <ul>
            <li><?php echo $this->Html->link('Lists', '/task_lists/'); ?></li>
            <li><?php echo $this->Html->link('Tasks', '/tasks/'); ?></li>
            <li><?php echo $this->Html->link('Contexts', '/contexts/'); ?></li>
            <li><?php echo $this->Html->link('Tags', '/tags/'); ?></li>
            <li><?php echo $this->Html->link('Shared', '/shared/'); ?></li>
            <!--<li><?php echo $this->Html->link('Stuff', '/stuff/'); ?></li>
            <li><?php echo $this->Html->link('Settings', '/settings/'); ?></li>-->
        </ul>
    </div>
    <div id="inputbar">
        <span>task</span>
        <input type="text"/>
        <button>add</button>
    </div>
<? } ?>
    <div id="content">
		<div id="breadcrumbs"></div>
        <?php echo $content_for_layout; ?>
    </div>
    <div id="footer">
    </div>
</div>
<div id="message-confirm-box" style="display: none">
    <p class="message"></p>
    <button class="yes">Yes</button>
    <button class="no">No</button>
</div>
</body>
</html>

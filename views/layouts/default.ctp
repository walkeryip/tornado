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
    <script type="text/javascript" src="/tornado/js/lib/prototype.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/scriptaculous.js?load=effects"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery.simplemodal.1.4.2.min.js"></script>

    <script>
        jQuery.noConflict();
        var jq = jQuery;
    </script>

    <script type="text/javascript" src="/tornado/js/common.js"></script>
    <script type="text/javascript" src="/tornado/js/view-manager.js"></script>
    <script type="text/javascript" src="/tornado/js/tornado.js"></script>
    <script type="text/javascript" src="/tornado/js/models/label.js"></script>
    <script type="text/javascript" src="/tornado/js/models/tag.js"></script>
    <script type="text/javascript" src="/tornado/js/models/context.js"></script>
    <script type="text/javascript" src="/tornado/js/models/item.js"></script>
    <script type="text/javascript" src="/tornado/js/models/task.js"></script>
    <script type="text/javascript" src="/tornado/js/models/list.js"></script>
    <script type="text/javascript" src="/tornado/js/models/label.js"></script>
    <script type="text/javascript" src="/tornado/js/views/item-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/task-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/list-element.js"></script>
    <script type="text/javascript" src="/tornado/js/views/view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/mixed-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/task-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/list-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/context-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/tag-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/deadline-view.js"></script>
    <script type="text/javascript" src="/tornado/js/views/todo-view.js"></script>
</head>
<body>
<div id="container">
    <div id="header">
        <h1><?php echo $this->Html->link(__('t[x]rnado', true), '/'); ?></h1>
    </div>
    <div id="menu">
        <ul>
            <li><?php echo $this->Html->link('Todo', '/task_lists/'); ?></li>
            <li><?php echo $this->Html->link('Tasks', '/tasks/'); ?></li>
            <li><?php echo $this->Html->link('Agenda', '/tasks/agenda/'); ?></li>
            <li><?php echo $this->Html->link('Contexts', '/contexts/'); ?></li>
            <li><?php echo $this->Html->link('Tags', '/tags/'); ?></li>
            <li><?php echo $this->Html->link('Lists', '/task_lists/lists/'); ?></li>
            <li><?php echo $this->Html->link('Stuff', '/stuff/'); ?></li>
            <li><?php echo $this->Html->link('Settings', '/settings/'); ?></li>
        </ul>
    </div>
    <div id="inputbar">
        <span>task</span>
        <input type="text"/>
        <button>add</button>
    </div>
    <div id="content">
        <div id="flash">
            <?php echo $this->Session->flash(); ?>
        </div>
        <?php echo $content_for_layout; ?>
    </div>
    <div id="footer">
    </div>
</div>
<?php echo $this->element('sql_dump'); ?>
<div id="message-confirm-box" style="display: none">
    <p class="message"></p>
    <button class="yes">Yes</button>
    <button class="no">No</button>
</div>
</body>
</html>

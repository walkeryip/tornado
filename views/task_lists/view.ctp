<h2><?php echo $list['TaskList']['name'] ?></h2> 
<p><?php echo $list['TaskList']['description'] ?></p>
<i><?php echo $list['TaskList']['created'] ?></i>

<!--<pre><code><?php print_r($tasks); ?></code></pre>-->
<h3>Parent</h3>
<?php echo $html->link($list['Parent']['name'], array('action'=>'view', $list['Parent']['id'], null)); ?>

<h3>Sub lists</h3>
<?php echo $this->element('lists', array('lists' => $lists)); ?>

<h3>Tasks</h3>
<?php echo $this->element('tasks', array('tasks' => $tasks)); ?>

<h3>Done tasks</h3>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="Rasmus Haglund" />
    <title>
      <?php __('t[x]rnado ::'); ?>
      <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    echo $scripts_for_layout;
    $debug = isset($this->params["url"]["debug"]) && $this->params["url"]["debug"] == "true";
    ?>

    <?php
       if (!$debug) {
       ?>
    <link rel="stylesheet/less" type="text/css" href="/tornado/bootstrap/less/bootstrap.less" />
    <link rel="stylesheet/less" type="text/css" href="/tornado/bootstrap/less/responsive.less" />
    <link rel="stylesheet/less" type="text/css" href="/tornado/bootstrap/less/tornado.less" />
  
    <link rel="stylesheet" href="/tornado/css/font-awesome.min.css">

    <script src="/tornado/js/lib/less.js" type="text/javascript"></script>

    <script type="text/javascript" src="/tornado/js/lib/mustache.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/prototype.js"></script>
  <!--  <script type="text/javascript" src="/tornado/js/lib/scriptaculous.js?load=effects"></script>-->
    <script type="text/javascript" src="/tornado/js/lib/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery.simplemodal.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/jquery.tinysort.min.js"></script>
    <script src="/tornado/js/lib/bootstrap.js" type="text/javascript"></script>
    <script src="/tornado/js/lib/bootstrap-contextmenu.js" type="text/javascript"></script>

    <script type="text/javascript" src="/tornado/js/tornado.js"></script>
    <script type="text/javascript" src="/tornado/js/template-manager.js"></script>
    <script type="text/javascript" src="/tornado/js/commandbar.js"></script>
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
    <script type="text/javascript" src="/tornado/js/panels/general-panel.js"></script>

    <?php } else { ?>
    <link rel="stylesheet" type="text/css" href="/tornado/css/tornado.min.css" />
    <script type="text/javascript" src="/tornado/js/tornado-combined.js"></script>

    <?php } ?>


    <script>	
      Tornado.initialize();
      Tornado.state.setUser({id: <? echo $_SESSION['Auth']['User']['id']; ?>, name: "<? echo $_SESSION['Auth']['User']['username']; ?>"});
    </script>


  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/tornado/">t<i class="icon-check"></i>rnado</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
	      <? if (isset($_SESSION['Auth']['User'])) {?>
	      Logged in as <a href="#" class="navbar-link"><? echo $_SESSION['Auth']['User']['username']; ?></a>
	      <a href="/tornado/logout"><i class="icon-signout"></i>Logout</a>
	      <? } else { ?>
	      <a href="/tornado/login">Login</a>
	      <a href="/tornado/register">Register</a>
	      <? } ?>
            </p>

            <ul class="nav">
              <li><?php echo $this->Html->link('Lists', '/task_lists/'); ?></li>
              <li><?php echo $this->Html->link('Tasks', '/tasks/'); ?></li>
              <li><?php echo $this->Html->link('Contexts', '/contexts/'); ?></li>
              <li><?php echo $this->Html->link('Tags', '/tags/'); ?></li>
              <li><?php echo $this->Html->link('Shared', '/shared/'); ?></li>
              <li><a href="/tornado/task_lists/deleted" class="deleted"><i class="icon-trash"></i></a></li>
              <!--<li><?php echo $this->Html->link('Stuff', '/stuff/'); ?></li>
		  <li><?php echo $this->Html->link('Settings', '/settings/'); ?></li>-->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <ul id="breadcrumbs" class="breadcrumb"></ul>
    <div id="inputbar">
      <span>task</span>
      <input type="text"/>
      <button>add</button>
    </div>
    
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Navigation</li>
              <li><a href="#">Lists</a></li>
              <li><a href="#">Tags</a></li>
              <li><a href="#">Contexts</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
	<div id="content" class="span5">
          <?php echo $content_for_layout; ?>
	  
        </div><!--/span-->
      </div><!--/row-->
      
      <hr />
      
      <footer>
        <p>Copyleft Tornado 2013</p>
      </footer>
      
    </div><!--/.fluid-container-->
  </body>
</html>

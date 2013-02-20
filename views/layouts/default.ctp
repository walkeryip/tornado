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
  

    <script src="/tornado/js/lib/less.js" type="text/javascript"></script>

    <script type="text/javascript" src="/tornado/js/lib/mustache.js"></script>
    <script type="text/javascript" src="/tornado/js/lib/prototype.js"></script>
  <!--  <script type="text/javascript" src="/tornado/js/lib/scriptaculous.js?load=effects"></script>-->
    <script type="text/javascript" src="/tornado/js/lib/jquery-1.7.2.min.js"></script>
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
    <link rel="stylesheet" type="text/css" href="/tornado/css/tornado-responsive.min.css" />
    <script type="text/javascript" src="/tornado/js/tornado-combined.js"></script>

    <?php } ?>
    <link rel="stylesheet" href="/tornado/css/font-awesome.min.css">


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
	      <a href="#" class="navbar-link"> <i class="icon-user"></i><? echo $_SESSION['Auth']['User']['username']; ?></a>
	      <a href="/tornado/logout" class="navbar-link"><i class="icon-signout"></i>Logout</a>
	      <? } else { ?>
	      <a href="/tornado/login">Login</a>
	      <a href="/tornado/register">Register</a>
	      <? } ?>
            </p>

            <ul class="nav">
              <li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Lists<b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li><a tabindex="-1" href="/tornado/task_lists">All lists</a></li>
                  <li class="divider"></li>
                  <li id="list-autocomplete" class="autocomplete"><input type="text" data-provide="typeahead" source="Tornado.List.autocomplete"/></li>
                </ul>
	      </li><li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Contexts<b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li><a tabindex="-1" href="/tornado/contexts">All contexts</a></li>
                  <li class="divider"></li>
                  <li id="context-autocomplete" class="autocomplete"><input type="text" data-provide="typeahead" source="Tornado.List.autocomplete"/></li>
		</ul>
	      </li><li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Tags<b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li><a tabindex="-1" href="/tornado/tags">All tags</a></li>
                  <li class="divider"></li>
                  <li id="tag-autocomplete" class="autocomplete"><input type="text" data-provide="typeahead" source="Tornado.List.autocomplete"/></li>
                </ul>
	      </li><li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Shared<b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li><a tabindex="-1" href="/tornado/shared">All shared items</a></li>
                  <li><a tabindex="-1" href="#anotherAction"></a></li>
                  <li><a tabindex="-1" href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li><a tabindex="-1" href="#">Separated link</a></li>
                </ul>
	      </li><li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Tasks<b class="caret"></b></a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                  <li><a tabindex="-1" href="/tornado/tasks">All tasks</a></li>
                </ul>
	      </li>
              <li><a href="/tornado/task_lists/deleted" class="deleted"><i class="icon-trash"></i></a></li>
              <!--<li><?php echo $this->Html->link('Stuff', '/stuff/'); ?></li>
		  <li><?php echo $this->Html->link('Settings', '/settings/'); ?></li>-->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	      <? if (isset($_SESSION['Auth']['User'])) {?>

    <ul id="breadcrumbs" class="breadcrumb"></ul>
	      <? } ?>

    <div class="container-fluid">
      <div class="row-fluid">
	<div id="content" class="span5">
	      <? if (isset($_SESSION['Auth']['User'])) {?>

        <div id="inputbar">
	  <span class="label item">task</span>
	  <input type="text"/>
	  <button class="btn">add</button>
	</div>
	      <? } ?>

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

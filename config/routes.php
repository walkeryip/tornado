<?php
/**
 * Routes Configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/lists/add/*', array('controller' => 'task_lists', 'action' => 'add'));
Router::connect('/lists/view/*', array('controller' => 'task_lists', 'action' => 'view'));
Router::connect('/lists/edit/*', array('controller' => 'task_lists', 'action' => 'edit'));
Router::connect('/lists/delete/*', array('controller' => 'task_lists', 'action' => 'delete'));
Router::connect('/lists/restore/*', array('controller' => 'task_lists', 'action' => 'restore'));
Router::connect('/lists/activate/*', array('controller' => 'task_lists', 'action' => 'activate'));
Router::connect('/lists/deactivate/*', array('controller' => 'task_lists', 'action' => 'deactivate'));
Router::connect('/lists/tree/*', array('controller' => 'task_lists', 'action' => 'tree'));
Router::connect('/lists/shared/*', array('controller' => 'task_lists', 'action' => 'shared'));
Router::connect('/lists/move/*', array('controller' => 'task_lists', 'action' => 'move'));
Router::connect('/lists/', array('controller' => 'task_lists', 'action' => 'index'));
Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
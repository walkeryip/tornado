<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TasksContexts extends AppModel {
      var $name = 'TasksContexts';

      var $belongsTo = array('Context','Task');
}

?>

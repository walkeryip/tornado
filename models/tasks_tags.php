<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TasksTags extends AppModel {
      var $name = 'TasksTags';

      var $belongsTo = array('Tag','Task');

      var $scaffold;
}

?>

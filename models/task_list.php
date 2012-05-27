<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TaskList extends AppModel {
	var $name = 'TaskList';

	var $validate = array(
		'name' => 'notEmpty');

	var $belongsTo = array('Parent' => array('className' => 'TaskList', 'foreignKey' => 'parent_id'));
	var $hasAndBelongsToMany = array(
		'Tag' => array('className'=>'Tag'),
		'Task' => array('className'=>'Task'),
		'Context' => array('className' => 'Context')); 


}

?>

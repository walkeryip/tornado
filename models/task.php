<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Task extends AppModel {
	var $name = 'Task';

	var $validate = array(
		'name' => 'notEmpty');

	var $hasAndBelongsToMany = array(
		'Tag' => array('className'=>'Tag'),
		'Context' => array('className' => 'Context'),
		'List' => array('className' => 'TaskList')); 
}

?>

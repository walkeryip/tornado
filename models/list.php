<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class List extends AppModel {
	var $name = 'List';

	var $validate = array(
		'name' => 'notEmpty');

	var $hasAndBelongsToMany = array(
		'Tag' => array('className'=>'Tag'),
		'Task' => array('className'=>'Task'),
		'Context' => array('className' => 'Context')); 
}

?>

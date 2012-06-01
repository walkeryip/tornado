<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Tag extends AppModel {
	var $name = 'Tag';
	
	var $hasAndBelongsToMany = array(
		'Task' => array('className' => 'Task'),
		'TaskList' => array('className' => 'TaskList')); 

	public function getTagById($id){
		$conditions = array('Tag.id' => $id);
		return $this->find('first', array('conditions' => $conditions));
	}
}

?>



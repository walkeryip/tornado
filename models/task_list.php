<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TaskList extends AppModel {
	var $name = 'TaskList';

	/*var $validate = array(
	  'name' => 'notEmpty');*/

	var $hasAndBelongsToMany = array(
		'Tag' => array('className'=>'Tag'),
		'Task' => array('className'=>'Task'),
		'User' => array('className' => 'User'),
		'Context' => array('className' => 'Context')); 
	
	/*

	public function getTaskListsByContextId($id){
		$conditions = array('ContextsTaskLists.context_id' => $id);
		return $this->getTaskLists($id, $conditions, array('Tag', 'Context', 'ContextsTaskLists'), array('ContextsTaskLists'));
	}

	public function getTaskListsByTagId($id){
		$conditions = array('TagsTaskLists.tag_id' => $id);
		return $this->getTaskLists($id, $conditions, array('Tag', 'Context', 'TagsTaskLists'), array('TagsTaskLists'));
	}

	public function getTaskListById($id){
		$conditions = array('TaskList.id' => $id);
		return $this->find('first', array('recursive' => 1, 'conditions' => $conditions));
	}

	public function getTaskListsByParentId($id){
		$conditions = array('TaskList.parent_id' => $id);
		return $this->find('all', array('recursive' => 1, 'conditions' => $conditions));
	}

	
	*/	
}

?>

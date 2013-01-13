<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Task extends AppModel {
	var $name = 'Task';

	/*var $validate = array(
	  'name' => 'notEmpty');*/

	var $hasAndBelongsToMany = array(
		'Tag' => array('className'=>'Tag'),
		'Context' => array('className' => 'Context'),
		'User' => array('className' => 'User'),
		'TaskList' => array('className' => 'TaskList')); 
	/*
	

		public function getTasksByListId($id, $checked){
		$conditions = array('Task.checked' => $checked, 'TaskListsTasks.task_list_id' => $id);
		return $this->getTasks($id, $conditions, array('Tag', 'Context', 'TaskListsTasks'), array('TaskListsTasks'));
	}

	public function getTasksByListIdTest($id){
		$conditions = array('TaskListsTasks.task_list_id' => $id);
		return $this->getTasks($id, $conditions, array('Tag', 'Context', 'TaskListsTasks'), array('TaskListsTasks'));
	}

	public function getTasksByContextId($id, $checked){
		$conditions = array('Task.checked' => $checked, 'ContextsTasks.context_id' => $id);
		return $this->getTasks($id, $conditions, array('Tag', 'Context', 'ContextsTasks'), array('ContextsTasks'));
	}

	public function getTasksByTagId($id, $checked){
		$conditions = array('Task.checked' => $checked, 'TagsTasks.tag_id' => $id);
		return $this->getTasks($id, $conditions, array('Tag', 'Context', 'TagsTasks'), array('TagsTasks'));
	}

	public function getTaskById($id){
		return $this->find('first', array('conditions' => array('Task.id' => $id)));
	}

	public function addTags($tags, $userId){
		return $this->createLabels($this->Tag, $tags, $userId);
	}

	public function addContexts($contexts, $userId){
		return $this->createLabels($this->Context, $contexts, $userId);
	}

	public function addUsers($users, $user){
		return $this->getUsers($users, $user);
	}

	public function getTagsString(){
		return $this->getLabels($this->Tag);
	}

	public function getContextsString(){
		return $this->getLabels($this->Context);
	}

	public function getUsersString(){
		return $this->getLabels($this->User);
	}
	
	
	
	
	
    */	

}

?>

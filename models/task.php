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
		'TaskList' => array('className' => 'TaskList')); 

	public function getTasks($id, $conditions, $contain, $bind){
		$this->Behaviors->attach('Containable');
		$this->bindModel(array('hasOne' => $bind));
		$data = $this->find('all', array(
			'fields' => array('Task.*'),
			'contain' => $contain,
			'conditions' => $conditions));

		return $data;
	}

	public function getTasksByListId($id, $checked){
		$conditions = array('Task.checked' => $checked, 'TaskListsTasks.task_list_id' => $id);
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

	public function addTags($tags){
		$this->createLabels($this->Tag, $tags);
	}

	public function addContexts($contexts){
		$this->createLabels($this->Context, $contexts);
	}

	public function getTagsString(){
		return $this->getLabels($this->Tag);
	}

	public function getContextsString(){
		return $this->getLabels($this->Context);
	}

}

?>


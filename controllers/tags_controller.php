<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');

	function index($id = null){
		$this->set('tags', $this->Tag->find('all'));
	}

	function view($id){
		$tag = $this->Tag->getTagById($id);
		$lists = $this->Tag->TaskList->getTaskListsByTagId($id);
		$tasks = $this->Tag->Task->getTasksByTagId($id, false);
		$tasksDone = $this->Tag->Task->getTasksByTagId($id, true);

		$this->set('tag', $tag);
		$this->set('lists', $lists);
		$this->set('tasks', $tasks);
		$this->set('tasksDone', $tasksDone);
	}
}

?>

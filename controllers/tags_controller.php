<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('tags', $this->Tag->find('all'));
	}

	function view($id){
		$tag = $this->Tag->getTagById($id);
		$lists = $this->Tag->TaskList->getTaskListsByTagId($id);
		$tasks = $this->Tag->Task->getTasksByTagId($id, false);
		$tasksDone = $this->Tag->Task->getTasksByTagId($id, true);

		if ($this->RequestHandler->isAjax()){
			$tag['List'] = $lists;
			$tag['Task'] = $tasks;
        	$this->set('data', $tag);
        	$this->render('/general/json', 'ajax');
		} else {
			$this->set('tag', $tag);
			$this->set('lists', $lists);
			$this->set('tasks', $tasks);
			$this->set('tasksDone', $tasksDone);
		}
	}
}

?>

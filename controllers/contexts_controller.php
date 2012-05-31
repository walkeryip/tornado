<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');

	function index($id = null){
		$this->set('contexts', $this->Context->find('all'));
	}

	function view($id){
		$context = $this->Context->getContextById($id);
		$lists = $this->Context->TaskList->getTaskListsByContextId($id);
		$tasks = $this->Context->Task->getTasksByContextId($id, false);
		$tasksDone = $this->Context->Task->getTasksByContextId($id, true);

		$this->set('context', $context);
		$this->set('lists', $lists);
		$this->set('tasks', $tasks);
		$this->set('tasksDone', $tasksDone);
	}
}

?>

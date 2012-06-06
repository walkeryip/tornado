<?php

class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('contexts', $this->Context->find('all'));
	}

	function view($id){
		$context = $this->Context->getContextById($id);
		$lists = $this->Context->TaskList->getTaskListsByContextId($id);
		$tasks = $this->Context->Task->getTasksByContextId($id, false);
		$tasksDone = $this->Context->Task->getTasksByContextId($id, true);

		if ($this->RequestHandler->isAjax()){			
			$context['List'] = $lists;
			$context['Task'] = $tasks;

        	$this->set('data', $context);
        	$this->render('/general/json', 'ajax');
		} else {

			$this->set('context', $context);
			$this->set('lists', $lists);
			$this->set('tasks', $tasks);
			$this->set('tasksDone', $tasksDone);
		}
	}



}

?>

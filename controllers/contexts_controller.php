<?php

class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('contexts', $this->Context->find('all'));
	}

	function view($id){
		/*$context = $this->Context->getContextById($id);
		$lists = $this->Context->TaskList->getTaskListsByContextId($id);
		$tasks = $this->Context->Task->getTasksByContextId($id, false);
		$tasksDone = $this->Context->Task->getTasksByContextId($id, true);*/

		if ($this->RequestHandler->isAjax()){			
			/*$context['List'] = $lists;
			$context['Task'] = $tasks;*/

			$data["Contexts"] = $this->Context->query("select * from contexts as Context where id = " . $id);

			$data["ContextsTasks"] = $this->Context->query("select * from contexts_tasks as ContextTask where context_id = " . $id);
			$data["ContextsTaskLists"] = $this->Context->query("select * from contexts_task_lists as ContextTaskList where context_id = " . $id);

			$taskContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "task_id");
			$taskListContextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "task_list_id");

			if (sizeof($taskListContextIds)>0){
				$data["TaskLists"] = $this->Context->query("select * from task_lists as TaskList where id in (" . implode(",", array_unique($taskListContextIds)) . ")");
			}
			if (sizeof($taskContextIds)>0){
		    	$data["Tasks"] = $this->Context->query("SELECT * FROM tasks as Task WHERE id in (" . implode(",", array_unique($taskContextIds)) . ")");
			}

			$this->set("data", $data);
        	$this->render('/general/json', 'ajax');
		} else {
			$context = $this->Context->getContextById($id);
			$this->set('context_id', $context["Context"]["id"]);
		}
	}



}

?>

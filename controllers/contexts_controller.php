<?php

class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		$this->set('contexts', $this->Context->find('all'));
	}
	
	function all(){
		$contexts = $this->Context->find('all');
		$data["Contexts"] = $contexts;
		$this->set("data", $data);
        $this->render('/general/json', 'ajax');
	}

	function view($id){		

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
	}
	
	function delete($id = null){
		$status = false;
		if ($this->Context->delete($id)){
			$status = true;
		} 

        $this->set('data', $status);
        $this->render('/general/json', 'ajax');
	}
	
	function edit($id = null){
		if ($this->Context->save($this->data)){
			$this->data = $this->Context->find(array('id' => $id));
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	
}

?>

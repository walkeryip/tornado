<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function view($id){
		if ($this->RequestHandler->isAjax()){
			$this->data = $this->Task->getTaskById($id);

        	$this->set('data', $this->data);
        	$this->render('/general/json', 'ajax');
		}
	}

	function add($id = null){
		if (!empty($this->data)){
			if (isset($this->data["Task"]["tags"])){
				$test = $this->Task->addTags($this->data["Task"]['tags']);
				//print_r($test);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["Task"]["contexts"])){
				$test = $this->Task->addContexts($this->data["Task"]['contexts']);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}
			// Attach to parent
			//$this->data['TaskList']['TaskList'][0] = $id;

			$this->Task->create();
			//$this->data["Task"]["id"] = $this->Task->id;

			//print_r($this->data);
			if ($this->Task->save($this->data)){
                $this->data = $this->Task->find(array('id' => $this->Task->id));
				//print_r($this->data);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function edit($id = null){
		if (isset($this->data["Task"]["tags"])){
			$this->data["Tag"] = $this->Task->addTags($this->data['Task']['tags']); 
		}
		
		if (isset($this->data["Task"]["contexts"])){
			$this->data["Context"] = $this->Task->addContexts($this->data['Task']['contexts']);
		}
					
		if ($this->Task->save($this->data)){
			$this->data = $this->Task->find(array('id' => $id));
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	

	function all($checked = false){
		$data = array();
		
		$data["Tasks"] = $this->Task->query("SELECT * FROM tasks as Task where checked = " . $checked);
		$taskIds = $this->accId($data["Tasks"], "Task", "id");

		$data["TaskLists"] = $this->Task->query("select * from task_lists as TaskList where id in (select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");

		$data["TagsTasks"] = $this->Task->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
		$data["ContextsTasks"] = $this->Task->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");

		$tagsTasksTagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
		$data["Tags"] = $this->Task->Tag->query("select * from tags as Tag where id in (" . 
			implode(",", $tagsTasksTagIds) . ")");

		$contextsTasksContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		$data["Contexts"] = $this->Task->Context->query("select * from contexts as Context where id in (" . 
			implode(",", $contextsTasksContextIds) . ")");

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}

	function setChecked($id, $checked){	
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;
		
			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('data', $this->data);
			} else {
				$this->set('data', false);
			}

			$this->render("/general/json", "ajax");
		}

	}

	function check($id = null){
		$this->setChecked($id, 1);
	}

	function uncheck($id = null){
		$this->setChecked($id, 0);
	}

	function delete($id = null){
		$status = false;
		if ($this->Task->delete($id)){
			$status = true;
		} 

        $this->set('data', $status);
        $this->render('/general/json', 'ajax');
	}
}

?>

<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 
	
	function index($id = null){
	}
	
	function todo(){
	}

	function add($id = null){
		if (!empty($this->data)){
			if (isset($this->data["TaskList"]["tags"])){
				$test = $this->TaskList->addTags($this->data["TaskList"]["tags"]);
				//print_r($test);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["TaskList"]["contexts"])){
				$test = $this->TaskList->addContexts($this->data["TaskList"]["contexts"]);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}
			// Attach to parent
			//$this->data['TaskList']['TaskList'][0] = $id;

			$this->TaskList->create();
			//$this->data["Task"]["id"] = $this->Task->id;

			//print_r($this->data);
			if ($this->TaskList->save($this->data)){
                $this->data = $this->TaskList->find(array('TaskList.id' => $this->TaskList->id));
				//print_r($this->data);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}


	function view($id = null){
		
		if ($this->RequestHandler->isAjax()){
			$this->TaskList->id = $id;
	
			$data = array();
			
			$data["TaskLists"] = $this->TaskList->query("select * from task_lists as TaskList where id = " . $id . " or parent_id = " . $id);
			$data["Tasks"] = $this->TaskList->Task->query("SELECT * FROM tasks as Task WHERE id in (SELECT task_id FROM task_lists_tasks WHERE task_list_id = " . $id . ")");
	
			$taskIds = $this->accId($data["Tasks"], "Task", "id");
			$data["TagsTasks"] = $this->TaskList->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["ContextsTasks"] = $this->TaskList->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["TagsTaskLists"] = $this->TaskList->query("select * from tags_task_lists as TagTaskList where task_list_id = " . $id);
			$data["ContextsTaskLists"] = $this->TaskList->query("select * from contexts_task_lists as ContextTaskList where task_list_id = " . $id);
	
			$tagsTasksTagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$tagsTaskListsTagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$data["Tags"] = $this->TaskList->Tag->query("select * from tags as Tag where id in (" . 
				implode(",", array_unique(array_merge($tagsTasksTagIds,$tagsTaskListsTagIds))) . ")");
	
			$contextsTasksContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$contextsTaskListsContextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
			$data["Contexts"] = $this->TaskList->Context->query("select * from contexts as Context where id in (" . 
				implode(",", array_unique(array_merge($contextsTasksContextIds,$contextsTaskListsContextIds))) . ")");
	
	        $this->set('data', $data);
	        $this->render('/general/json', 'ajax');
		} else {
			$this->set('task_list_id', $id);
		}
	}
	



	function accId($objList, $ident, $var){
		$result = array();
		foreach ($objList as $obj){
			array_push($result,$obj[$ident][$var]);
		} 

		return $result;
	}

	function arrayStringJoin($a, $b){
		if (strlen($a) == 0){
			return $b;
		} else if (strlen($b) == 0){
			return $a;
		} else {
			return $a . "," . $b;
		}
	}

	function edit($id = null){
		if (isset($this->data["TaskList"]["tags"])){
			$this->data["Tag"] = $this->TaskList->addTags($this->data['TaskList']['tags']); 
		}
		
		if (isset($this->data["TaskList"]["contexts"])){
			$this->data["Context"] = $this->TaskList->addContexts($this->data['TaskList']['contexts']);
		}	
					
		if ($this->TaskList->save($this->data)){
			$this->data = $this->TaskList->find(array('TaskList.id' => $id));
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}

	function delete($id = null){
		if ($this->RequestHandler->isAjax()){
			$status = false;
			if ($this->TaskList->delete($id)){
				$status = true;
			} 

        	$this->set('data', $status);
        	$this->render('/general/json', 'ajax');
		}
	}
	
	function all(){
			$tags = $this->TaskList->find('all');
			$data["TaskLists"] = $tags;
			$this->set("data", $data);
        	$this->render('/general/json', 'ajax');
	}
}

?>

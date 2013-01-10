<?php

class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
	        
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("user_id", $userId);
	}
	
	function all(){
		$userId = $_SESSION['Auth']['User']['id'];

		$this->set("data", $this->getContexts());
		$this->set("user_id", $userId);
        $this->render('/general/json', 'ajax');
	}

	function getContexts($id = null){
		$userId = $_SESSION['Auth']['User']['id'];

		if ($id != null) {
			$data["Contexts"] = $this->Context->getContextById($id, $userId);
		} else {
			$data["Contexts"] = $this->Context->getContexts($userId);
		}
		
		$contextIds = $this->accId($data["Contexts"], "Context", "id");
		$tagIds = array();
		if ($id != null) {
			$data["ContextsTasks"] = $this->Context->getContextsTasksByContextIds($contextIds);
			$data["ContextsTaskLists"] = $this->Context->getContextsTaskListsByContextIds($contextIds);

			$taskIds = $this->accId($data["ContextsTasks"], "ContextTask", "task_id");
			$taskListIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "task_list_id");

			$userIds = array();
			$data["Users"] = array();
		}


		if (!empty($taskListIds)){
			$data["TaskLists"] = $this->Context->getTaskListsByTaskListIds($taskListIds, $userId);

			$data["TaskListsUsers"] = $this->Context->getTaskListsUsersByTaskListIds($taskListIds);			
			$userIds += $this->accId($data["TaskListsUsers"], "TaskListUser", "user_id");
			
			$data["TagsTaskLists"] = $this->Context->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsTaskLists"] = $this->Context->getContextsTaskListsByTaskListIds($taskListIds);
			
			$tagIds += $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$contextIds += $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
		}
		if (!empty($taskIds)){
		   	$data["Tasks"] = $this->Context->getTasksByTaskIds($taskIds, $userId);

			$data["TasksUsers"] = $this->Context->getTasksUsersByTaskIds($taskIds);
			$userIds += $this->accId($data["TasksUsers"], "TaskUser", "user_id");
			
			$data["TagsTasks"] = $this->Context->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Context->getContextsTasksByTaskIds($taskIds);
			
			$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		}
		if (!empty($tagIds)){
			$data["Tags"] = $this->Context->getTagsByTagIds($tagIds, $userId);
		}
		if (!empty($contextIds)){
			$data["Contexts"] += $this->Context->getContextsByContextIds($contextIds, $userId);
		}
	
		if (!empty($userIds)){
		   	$data["Users"] = $this->Context->getUsersByUserIds($userIds);
		}
				
		return $data;
	}

	function getContextById($id){
		return $this->getContexts($id);
	}
	
	function view($id){		
		$userId = $_SESSION['Auth']['User']['id'];
				$this->set("user_id", $userId);

		if ($this->RequestHandler->isAjax()){
			$this->set("data", $this->getContextById($id));
        	$this->render('/general/json', 'ajax');
		} else {
			$context = $this->Context->getContextById($id, $_SESSION['Auth']['User']['id']);
			if ($context != null){
				$this->set('context_id', $context[0]["Context"]["id"]);
			}
		}
	}
	
	function delete($id = null){
		$status = false;

		$data["Contexts"] = array();
		$data["Contexts"][0] = array();
		$data["Contexts"][0]["Context"] = array();
		$data["Contexts"][0]["Context"]["id"] = $id;
		$data["Contexts"][0]["Context"]["deleted"] = true;

		$this->Context->set('deleted', true);

		if ($this->Context->save()){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
/*
		$status = false;
		if ($this->Context->delete($id)){
			$status = true;
		} 

        $this->set('data', $status);
        $this->render('/general/json', 'ajax');*/
	}
	
	function edit($id = null){
		if ($this->Context->save($this->data)){
		  $this->data = $this->getContextById($id);
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
			$this->set('data', "false");
		}

	   	$this->render('/general/json', 'ajax');
	}	
}

?>

<?php

class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		
	}
	
	function all(){
		$this->set("data", $this->getContexts());
        $this->render('/general/json', 'ajax');
	}

	function getContextById($id){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["Contexts"] = $this->Context->getContextById($id, $userId);
		
		$data["ContextsTasks"] = $this->Context->getContextsTasksByContextId($id);
		$data["ContextsTaskLists"] = $this->Context->getContextsTaskListsByContextId($id);

		$taskIds = $this->accId($data["ContextsTasks"], "ContextTask", "task_id");
		$taskListIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "task_list_id");

		$tagIds = array();
		$contextIds = array();
		$data["Tags"] = array();
		
		// TODO: dessa borde kunna göras generella och användas på flera ställen, t ex under tags
		if (sizeof($taskListIds)>0){
			$data["TaskLists"] = $this->Context->getTaskListsByTaskListIds($taskListIds, $userId);
			
			$data["TagsTaskLists"] = $this->Context->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsTaskLists"] = $this->Context->getContextsTaskListsByTaskListIds($taskListIds);
			
			$tagIds += $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$contextIds += $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
		}
		if (sizeof($taskIds)>0){
		   	$data["Tasks"] = $this->Context->getTasksByTaskIds($taskIds, $userId);
			
			$data["TagsTasks"] = $this->Context->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Context->getContextsTasksByTaskIds($taskIds);
			
			$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		}
		if (sizeof($tagIds)>0){
			$data["Tags"] += $this->Context->getTagsByTagIds($tagIds, $userId);
		}
		if (sizeof($contextIds)>0){
			$data["Contexts"] += $this->Context->getContextsByContextIds($contextIds, $userId);
		}
		
		return $data;
	}
	
	function getContexts(){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["Contexts"] = $this->Context->getContexts($userId, $userId);
		
		$contextIds = $this->accId($data["Contexts"], "Context", "id");
		$data["ContextsTasks"] = $this->Context->getContextsTasksByContextIds($contextIds);
		$data["ContextsTaskLists"] = $this->Context->getContextsTaskListsByContextIds($contextIds);

		$taskIds = $this->accId($data["ContextsTasks"], "ContextTask", "task_id");
		$taskListIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "task_list_id");

		if (sizeof($taskListIds)>0){
			$data["TaskLists"] = $this->Context->getTaskListsByTaskListIds($taskListIds, $userId);
		}
		if (sizeof($taskIds)>0){
		   	$data["Tasks"] = $this->Context->getTasksByTaskIds($taskIds, $userId);
		}
				
		return $data;
	}
	
	function view($id){		
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

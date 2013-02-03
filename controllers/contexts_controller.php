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

	function getContexts($id = null, $params){
		$userId = $_SESSION['Auth']['User']['id'];

		if (isset($params["context_id"])) {
		  $id = $params["context_id"];
		}

		$params["context_id"] = $id;
		$data["Contexts"] = $this->Context->getContexts($userId, $params);
		  
		$contextIds = $this->accId($data["Contexts"], "Context", "id");
		$tagIds = array();
		if ($id != null) {
			$data["ContextsTasks"] = $this->Context->getContextsTasksByContextIds($contextIds);
			$data["ContextsLists"] = $this->Context->getContextsTaskListsByContextIds($contextIds);

			$taskIds = $this->accId($data["ContextsTasks"], "ContextTask", "task_id");
			$listIds = $this->accId($data["ContextsLists"], "ContextList", "list_id");

			$userIds = array();
			$data["Users"] = array();
		}


		if (!empty($listIds)){
		  $params["list_id"] = implode(",", $listIds);
		  //$data["Lists"] = $this->Context->getTaskListsByTaskListIds($listIds, $userId);
		  $data["Lists"] = $this->Context->getTaskLists($userId, $params);

			$data["ListsUsers"] = $this->Context->getTaskListsUsersByTaskListIds($listIds);			
			$userIds += $this->accId($data["ListsUsers"], "ListUser", "user_id");
			
			$data["TagsLists"] = $this->Context->getTagsTaskListsByTaskListIds($listIds);
			$data["ContextsLists"] = $this->Context->getContextsTaskListsByTaskListIds($listIds);
			
			$tagIds += $this->accId($data["TagsLists"], "TagList", "tag_id");
			$contextIds += $this->accId($data["ContextsLists"], "ContextList", "context_id");
		}
		if (!empty($taskIds)){
		  $params["task_id"] = implode(",", $taskIds);
		  //   	$data["Tasks"] = $this->Context->getTasksByTaskIds($taskIds, $userId);
		  $data["Tasks"] = $this->Context->getTasks($userId, $params);

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
		  //$data["Contexts"] += $this->Context->getContextsByContextIds($contextIds, $userId);
		  $data["Contexts"] += $this->Context->getContexts($userId, array("context_id" => implode(",", $contextIds)));
		}
	
		if (!empty($userIds)){
		   	$data["Users"] = $this->Context->getUsersByUserIds($userIds);
		}
				
		return $data;
	}

	function getContextById($id, $params){
	  return $this->getContexts($id, $params);
	}
	
	function view($id = null){		
		$userId = $_SESSION['Auth']['User']['id'];
				$this->set("user_id", $userId);

		if ($this->RequestHandler->isAjax()){
		  $this->set("data", $this->getContextById($id, $this->params["url"]));
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

		if ($this->Context->delete()){
			$status = true;
		} 

		$this->set('data', $data);
		$this->render('/general/json', 'ajax');
	}
	
	function edit($id = null){
		if ($this->Context->save($this->data)){
		  $this->data = $this->getContextById($id, $this->params["url"]);
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
			$this->set('data', "false");
		}

	   	$this->render('/general/json', 'ajax');
	}	

	function autocomplete(){
	  $userId = $_SESSION['Auth']['User']['id'];
		
	  //$this->params["url"]["name"] = $name;
	  $this->data = 
	    $this->Context->query("select Context.* from contexts as Context where Context.user_id = " . $userId .  " and name like '%" . $this->params["url"]["query"] . "%' limit 8");
	  $this->set('data', $this->data);
	    
	    $this->render("/general/json", "ajax");
	}
}

?>

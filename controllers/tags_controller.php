<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("user_id", $userId);
	}
	
	function all(){
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("data", $this->getTags());
		$this->set('user_id', $userId);
        $this->render('/general/json', 'ajax');
	}

	function getTags($id = null){
		$userId = $_SESSION['Auth']['User']['id'];

		if ($id != null) {
			$data["Tags"] = $this->Tag->getTagById($id, $userId);
		} else {
			$data["Tags"] = $this->Tag->getTags($userId);
		}
		
		$tagIds = $this->accId($data["Tags"], "Tag", "id");
		$contextIds = array();

		// We only want to get all associated tasks and lists when providing an id
		if ($id != null) {
			$data["TagsTasks"] = $this->Tag->getTagsTasksByTagIds($tagIds);
			$data["TagsLists"] = $this->Tag->getTagsTaskListsByTagIds($tagIds);

			$taskIds = $this->accId($data["TagsTasks"], "TagTask", "task_id");
			$listIds = $this->accId($data["TagsLists"], "TagList", "list_id");

			$userIds = array();
			$data["Users"] = array();
		}


		if (!empty($listIds)){
			$data["Lists"] = $this->Tag->getTaskListsByTaskListIds($listIds, $userId);

			$data["ListsUsers"] = $this->Tag->getTaskListsUsersByTaskListIds($listIds);			
			$userIds += $this->accId($data["ListsUsers"], "ListUser", "user_id");

			$data["TagsLists"] = $this->Tag->getTagsTaskListsByTaskListIds($listIds);
			$data["ContextsLists"] = $this->Tag->getContextsTaskListsByTaskListIds($listIds);
			
			$tagIds += $this->accId($data["TagsLists"], "TagList", "tag_id");
			$contextIds += $this->accId($data["ContextsLists"], "ContextList", "context_id");
		}
		if (!empty($taskIds)){
		   	$data["Tasks"] = $this->Tag->getTasksByTaskIds($taskIds, $userId);

			$data["TasksUsers"] = $this->Tag->getTasksUsersByTaskIds($taskIds);
			$userIds += $this->accId($data["TasksUsers"], "TaskUser", "user_id");

			$data["TagsTasks"] = $this->Tag->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Tag->getContextsTasksByTaskIds($taskIds);
		
			$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		}
		if (!empty($tagIds)){
			$data["Tags"] += $this->Tag->getTagsByTagIds($tagIds, $userId);
		}
		if (!empty($contextIds)){
			$data["Contexts"] = $this->Tag->getContextsByContextIds($contextIds, $userId);
		}
	
		if (!empty($userIds)){
		   	$data["Users"] = $this->Tag->getUsersByUserIds($userIds);
		}
				
		return $data;
	}

	function getTagById($id){
		return $this->getTags($id);
	}

	function view($id){	
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set('user_id', $userId);
	
		if ($this->RequestHandler->isAjax()){
			$this->set("data", $this->getTagById($id));
        	$this->render('/general/json', 'ajax');
		} else {
			$tag = $this->Tag->getTagById($id, $_SESSION['Auth']['User']['id']);
			if ($tag != null) {
				$this->set('tag_id', $tag[0]["Tag"]["id"]);
			}
		}
	}
	
	function delete($id = null){
	  $status = false;
		if ($this->Tag->delete()){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}
	
	function edit($id = null){
		if ($this->Tag->save($this->data)){
		  $this->data = $this->getTagById($id);
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	
}

?>

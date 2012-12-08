<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function index($id = null){
		
	}
	
	function all(){
		$this->set("data", $this->getTags());
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
			$data["TagsTaskLists"] = $this->Tag->getTagsTaskListsByTagIds($tagIds);

			$taskIds = $this->accId($data["TagsTasks"], "TagTask", "task_id");
			$taskListIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "task_list_id");

			$userIds = array();
			$data["Users"] = array();
		}


		if (!empty($taskListIds)){
			$data["TaskLists"] = $this->Tag->getTaskListsByTaskListIds($taskListIds, $userId);

			$data["TaskListsUsers"] = $this->Tag->getTaskListsUsersByTaskListIds($taskListIds);			
			$userIds += $this->accId($data["TaskListsUsers"], "TaskListUser", "user_id");

			$data["TagsTaskLists"] = $this->Tag->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsTaskLists"] = $this->Tag->getContextsTaskListsByTaskListIds($taskListIds);
			
			$tagIds += $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$contextIds += $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
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
		if ($this->Tag->delete($id)){
			$status = true;
		} 

        $this->set('data', $status);
        $this->render('/general/json', 'ajax');
	}
	
	function edit($id = null){
		if ($this->Tag->save($this->data)){
			$this->data = $this->Tag->find(array('id' => $id));
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	
}

?>

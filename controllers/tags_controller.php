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

	function getTagById($id){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["Tags"] = $this->Tag->getTagById($id, $userId);
		
		$data["TagsTasks"] = $this->Tag->getTagsTasksByTagId($id);
		$data["TagsTaskLists"] = $this->Tag->getTagsTaskListsByTagId($id);

		$taskIds = $this->accId($data["TagsTasks"], "TagTask", "task_id");
		$taskListIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "task_list_id");

		$tagIds = array();
		$contextIds = array();
		$data["Contexts"] = array();
		
		// TODO: dessa borde kunna göras generella och användas på flera ställen, t ex under tags
		if (sizeof($taskListIds)>0){
			$data["TaskLists"] = $this->Tag->getTaskListsByTaskListIds($taskListIds, $userId);
			
			$data["TagsTaskLists"] = $this->Tag->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsTaskLists"] = $this->Tag->getContextsTaskListsByTaskListIds($taskListIds);
			
			$tagIds += $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$contextIds += $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
		}
		if (sizeof($taskIds)>0){
		   	$data["Tasks"] = $this->Tag->getTasksByTaskIds($taskIds, $userId);
			
			$data["TagsTasks"] = $this->Tag->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Tag->getContextsTasksByTaskIds($taskIds);
			
			$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		}
		if (sizeof($tagIds)>0){
			$data["Tags"] += $this->Tag->getTagsByTagIds($tagIds, $userId);
		}
		if (sizeof($contextIds)>0){
			$data["Contexts"] += $this->Tag->getContextsByContextIds($contextIds, $userId);
		}

		return $data;
	}

	function getTags(){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["Tags"] = $this->Tag->getTags($userId);
		
		$tagIds = $this->accId($data["Tags"], "Tag", "id");
		$data["TagsTasks"] = $this->Tag->getTagsTasksByTagIds($tagIds);
		$data["TagsTaskLists"] = $this->Tag->getTagsTaskListsByTagIds($tagIds);

		$taskIds = $this->accId($data["TagsTasks"], "TagTask", "task_id");
		$taskListIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "task_list_id");

		if (sizeof($taskListIds)>0){
			$data["TaskLists"] = $this->Tag->getTaskListsByTaskListIds($taskListIds, $userId);
		}
		if (sizeof($taskIds)>0){
		   	$data["Tasks"] = $this->Tag->getTasksByTaskIds($taskIds, $userId);
		}
				
		return $data;
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

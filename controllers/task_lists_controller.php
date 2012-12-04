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
		$userId = $_SESSION['Auth']['User']['id'];

		if (!empty($this->data)){
			if (isset($this->data["TaskList"]["tags"])){
				$test = $this->TaskList->addTags($this->data["TaskList"]["tags"], $userId);
				//print_r($test);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["TaskList"]["contexts"])){
				$test = $this->TaskList->addContexts($this->data["TaskList"]["contexts"], $userId);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}

			$this->data["User"] = array();
			$this->data["User"]["User"] = $userId;

			// Attach to parent
			//$this->data['TaskList']['TaskList'][0] = $id;

			$this->TaskList->create();
			//$this->data["Task"]["id"] = $this->Task->id;

			//print_r($this->data);
			if ($this->TaskList->save($this->data)){
                $this->data = $this->getTaskListById($this->TaskList->id);
				//print_r($this->data);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function getTaskLists(){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["TaskLists"] = $this->TaskList->getTaskLists($userId);
		$taskListIds = $this->accId($data["TaskLists"], "TaskList", "id");

		$data["TaskListsTasks"] = $this->TaskList->getTaskListsTasksByTaskListIds($taskListIds);
		$data["TagsTaskLists"] = $this->TaskList->getTagsTaskListsByTaskListIds($taskListIds);
		$data["ContextsTaskLists"] = $this->TaskList->getContextsTaskListsByTaskListIds($taskListIds);

		$taskIds = $this->accId($data["TaskListsTasks"], "TaskListTask", "task_id");
		$tagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
		$contextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");

		if (sizeof($taskIds)>0){
			$data["Tasks"] = $this->TaskList->getTasksByTaskIds($taskIds, $userId);
		}

		if (sizeof($tagIds)>0){
		   	$data["Tags"] = $this->TaskList->getTagsByTagIds($tagIds, $userId);
		}

		if (sizeof($contextIds)>0){
		   	$data["Contexts"] = $this->TaskList->getContextsByContextIds($contextIds, $userId);
		}

		return $data;
	}

	function getTaskListById($id){
		$userId = $_SESSION['Auth']['User']['id'];
		$data["TaskLists"] = $this->TaskList->getTaskListAndParentByTaskListId($id, $userId);
		$taskListIds = $this->accId($data["TaskLists"], "TaskList", "id");

		$data["TaskListsTasks"] = $this->TaskList->getTaskListsTasksByTaskListIds($taskListIds);
		$data["TagsTaskLists"] = $this->TaskList->getTagsTaskListsByTaskListIds($taskListIds);
		$data["ContextsTaskLists"] = $this->TaskList->getContextsTaskListsByTaskListIds($taskListIds);
		
		$taskIds = $this->accId($data["TaskListsTasks"], "TaskListTask", "task_id");
		$tagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
		$contextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");

		$data["Tags"] = array();
		$data["Contexts"] = array();

		if (sizeof($taskIds) > 0){
			$data["Tasks"] = $this->TaskList->getTasksByTaskIds($taskIds, $userId);
		
			$data["TagsTasks"] = $this->TaskList->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->TaskList->getContextsTasksByTaskIds($taskIds);
		
			$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		}

		if (sizeof($tagIds)>0){
			$data["Tags"] += $this->TaskList->getTagsByTagIds($tagIds, $userId);
		}

		if (sizeof($contextIds)>0){
			$data["Contexts"] += $this->TaskList->getContextsByContextIds($contextIds, $userId);
		}
		
		return $data;
	}

	function view($id = null){
		if ($this->RequestHandler->isAjax()){
	        $this->set('data', $this->getTaskListById($id));
	        $this->render('/general/json', 'ajax');
		} else {
			$taskList = $this->TaskList->getTaskListByTaskListId($id, $_SESSION['Auth']['User']['id']);
			if ($taskList != null){
				$this->set('task_list_id', $taskList[0]["TaskList"]["id"]);
			}
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
		$userId = $_SESSION['Auth']['User']['id'];

		if (isset($this->data["TaskList"]["tags"])){
			$test = $this->TaskList->addTags($this->data['TaskList']['tags'], $userId); 
			$this->data["Tag"] = array();
			$this->data["Tag"]["Tag"] = $test;
		}
		
		if (isset($this->data["TaskList"]["contexts"])){
			$test = $this->TaskList->addContexts($this->data['TaskList']['contexts'], $userId);
			$this->data["Context"] = array();
			$this->data["Context"]["Context"] = $test;
		}	
					
		if ($this->TaskList->save($this->data)){
			$this->data = $this->getTaskListById($id);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}

	function delete($id){
		$status = false;


		$data["TaskLists"] = array();
		$data["TaskLists"][0] = array();
		$data["TaskLists"][0]["TaskList"] = array();
		$data["TaskLists"][0]["TaskList"]["id"] = $id;
		$data["TaskLists"][0]["TaskList"]["deleted"] = true;

		if ($this->TaskList->delete($id)){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}

	function move($listId, $fromListId, $toListId) {
		$this->TaskList->id = $listId;
		$this->data["TaskList"]["parent_id"] = $toListId;
		
		if ($this->TaskList->save($this->data)){
			$this->data = $this->getTaskListById($listId);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
		
		$this->render("/general/json", "ajax");
	}

	function tree(){
		$userId = $_SESSION['Auth']['User']['id'];
		$data = $this->TaskList->getNavigationTree($userId);
		
		$this->set('data', $data);
		$this->render('/general/json', 'ajax');

	}
	
	function all(){
		$this->set("data", $this->getTaskLists());
        $this->render('/general/json', 'ajax');
	}
}

?>

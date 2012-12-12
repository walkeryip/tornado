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
			$this->data["User"] = array();
			$this->data["User"]["User"] = $userId;

			if (isset($this->data["TaskList"]["tags"])){
				$test = $this->TaskList->addTags($this->data["TaskList"]["tags"], $userId);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["TaskList"]["contexts"])){
				$test = $this->TaskList->addContexts($this->data["TaskList"]["contexts"], $userId);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}

			if (isset($this->data["TaskList"]["users"])){
				$test = $this->TaskList->addUsers($this->data["TaskList"]["users"], $userId);
				//print_r($test);
				$this->data["User"] = array();
				$this->data["User"]["User"] = $test;
			}


			$this->TaskList->create();

			if ($this->TaskList->save($this->data)){
                $this->data = $this->getTaskListById($this->TaskList->id);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function getTaskLists($id = null){
		$userId = $_SESSION['Auth']['User']['id'];

		if ($id != null) {
			$data["TaskLists"] = $this->TaskList->getTaskListAndParentByTaskListId($id, $userId);
		} else {
			$data["TaskLists"] = $this->TaskList->getRootTaskLists($userId);
		}

		$taskListIds = $this->accId($data["TaskLists"], "TaskList", "id");

		if (!empty($taskListIds)) {
			if ($id != null) {
				$data["TaskListsTasks"] = $this->TaskList->getTaskListsTasksByTaskListId($id);
		
				$taskIds = $this->accId($data["TaskListsTasks"], "TaskListTask", "task_id");
			}

			$data["TagsTaskLists"] = $this->TaskList->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsTaskLists"] = $this->TaskList->getContextsTaskListsByTaskListIds($taskListIds);

			$tagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$contextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");

			$data["Tags"] = array();
			$data["Contexts"] = array();

			$data["TaskListsUsers"] = $this->TaskList->getTaskListsUsersByTaskListIds($taskListIds);			
			$userIds = $this->accId($data["TaskListsUsers"], "TaskListUser", "user_id");

			$data["Users"] = array();

			if (!empty($taskIds)){
				$data["Tasks"] = $this->TaskList->getTasksByTaskIds($taskIds, $userId);
				$data["TasksUsers"] = $this->TaskList->getTasksUsersByTaskIds($taskIds);
				$userIds += $this->accId($data["TasksUsers"], "TaskUser", "user_id");

				if ($id != null) {
					$data["TagsTasks"] = $this->TaskList->getTagsTasksByTaskIds($taskIds);
					$data["ContextsTasks"] = $this->TaskList->getContextsTasksByTaskIds($taskIds);
					$tagIds += $this->accId($data["TagsTasks"], "TagTask", "tag_id");
					$contextIds += $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
				}
			}

			if (!empty($tagIds)){
			   	$data["Tags"] = $this->TaskList->getTagsByTagIds($tagIds, $userId);
			}

			if (!empty($contextIds)){
			   	$data["Contexts"] = $this->TaskList->getContextsByContextIds($contextIds, $userId);
			}
	
			if (!empty($userIds)){
			   	$data["Users"] = $this->TaskList->getUsersByUserIds($userIds);
			}
		}

		return $data;
	}

	function getTaskListById($id){
		return $this->getTaskLists($id);
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
		
		if (isset($this->data["TaskList"]["users"])){
			$test = $this->TaskList->addUsers($this->data['TaskList']['users'], $userId);
			$this->data["User"] = array();
			$this->data["User"]["User"] = $test;
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

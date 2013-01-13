<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 
	
	function index($id = null){
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("user_id", $userId);
	}
	
	function todo(){
	}

	function add($id = null){
		$userId = $_SESSION['Auth']['User']['id'];
		//echo "<pre><code>";
		//print_r($this->data);
		//$this->mapData($this->data);
		//print_r($this->data);
		//echo "</code></pre>";
		
		if (!empty($this->data)){
			$this->data["User"] = array();
			$this->data["User"]["User"] = $userId;

			if (isset($this->data["List"]["tags"])){
				$test = $this->TaskList->addTags($this->data["List"]["tags"], $userId);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["List"]["contexts"])){
				$test = $this->TaskList->addContexts($this->data["List"]["contexts"], $userId);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}

			if (isset($this->data["List"]["users"])){
				$test = $this->TaskList->addUsers($this->data["List"]["users"], $userId);
				//print_r($test);
				$this->data["User"] = array();
				$this->data["User"]["User"] = $test;
			}


		$this->data["TaskList"] = $this->data["List"];
		unset($this->data["List"]);

			$this->TaskList->create();

			if ($this->TaskList->save($this->data)){
                $this->data = $this->getTaskListById($this->TaskList->id);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function getTaskLists($id = null, $shared = false){
		$userId = $_SESSION['Auth']['User']['id'];

		if ($id != null || $shared) {
		  $data["Lists"] = $this->TaskList->getTaskListAndParentByTaskListId($id, $userId, $shared);
		} else {
			$data["Lists"] = $this->TaskList->getRootTaskLists($userId);
		}

		$taskListIds = $this->accId($data["Lists"], "List", "id");

		if (!empty($taskListIds)) {
			if ($id != null) {
				$data["ListsTasks"] = $this->TaskList->getTaskListsTasksByTaskListId($id);
		
				$taskIds = $this->accId($data["ListsTasks"], "ListTask", "task_id");
			}

			$data["TagsLists"] = $this->TaskList->getTagsTaskListsByTaskListIds($taskListIds);
			$data["ContextsLists"] = $this->TaskList->getContextsTaskListsByTaskListIds($taskListIds);

			$tagIds = $this->accId($data["TagsLists"], "TagList", "tag_id");
			$contextIds = $this->accId($data["ContextsLists"], "ContextList", "context_id");

			$data["Tags"] = array();
			$data["Contexts"] = array();

			$data["ListsUsers"] = $this->TaskList->getTaskListsUsersByTaskListIds($taskListIds);			
			$userIds = $this->accId($data["ListsUsers"], "ListUser", "user_id");

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
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set('user_id', $userId);
		if ($this->RequestHandler->isAjax()){
	        $this->set('data', $this->getTaskListById($id));
	        $this->render('/general/json', 'ajax');
		} else {
			$taskList = $this->TaskList->getTaskListByTaskListId($id, $_SESSION['Auth']['User']['id']);
			if ($taskList != null){
				$this->set('task_list_id', $taskList[0]["List"]["id"]);
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

	function mapData($data) {
	  foreach ($data as $k=>$v) {
	    if ($k == "List") {
	      $row["List"] = $row[$k];
	      unset($row[$k]);

	      /*	      foreach ($data["Lists"] as $nk=>$nv) {
		if ($k == "List") {
		  $data["Lists"]["List"] = $data["Lists"][$k];
		  unset($data["Lists"][$k]);
		}
		}*/
	    }
	  }
	}

	function edit($id = null){
	  $userId = $_SESSION['Auth']['User']['id'];



		if (isset($this->data["List"]["tags"])){
			$test = $this->TaskList->addTags($this->data['List']['tags'], $userId); 
			$this->data["Tag"] = array();
			$this->data["Tag"]["Tag"] = $test;
		}
		
		if (isset($this->data["List"]["contexts"])){
			$test = $this->TaskList->addContexts($this->data['List']['contexts'], $userId);
			$this->data["Context"] = array();
			$this->data["Context"]["Context"] = $test;
		}	
		
		if (isset($this->data["List"]["users"])){
			$test = $this->TaskList->addUsers($this->data['List']['users'], $userId);
			$this->data["User"] = array();
			$this->data["User"]["User"] = $test;
		}	

		$this->data["TaskList"] = $this->data["List"];
		unset($this->data["List"]);
					
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


		$data["Lists"] = array();
		$data["Lists"][0] = array();
		$data["Lists"][0]["List"] = array();
		$data["Lists"][0]["List"]["id"] = $id;
		$data["Lists"][0]["List"]["deleted"] = true;

		$this->TaskList->set("deleted",true);
		if ($this->TaskList->save()){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}

	function move($listId, $fromListId, $toListId = null) {
		$this->TaskList->id = $listId;
		$this->data["List"]["parent_id"] = $toListId;
		
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
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("data", $this->getTaskLists());
		$this->set('user_id', $userId);
        $this->render('/general/json', 'ajax');
	}

	function shared(){
		$userId = $_SESSION['Auth']['User']['id'];
	  	$this->set("data", $this->getTaskLists(null, true));
		$this->set('user_id', $userId);
		$this->render('/general/json', 'ajax');
	}
}

?>

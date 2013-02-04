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

	function deleted(){
	}

	function add($id = null){
		$userId = $_SESSION['Auth']['User']['id'];
		$params = $this->params["url"];
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
			  $params["list_id"] = $this->TaskList->id;
			  $this->data = $this->getTaskListById($params);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function getTaskLists($params = null){
	  $shared = false;
		$userId = $_SESSION['Auth']['User']['id'];
		$id = $params["list_id"];

		$data["Lists"] = $this->TaskList->getTaskLists($userId, $params);
		  
		$taskListIds = $this->accId($data["Lists"], "List", "id");
		if (!empty($taskListIds)) {

		  if (($id != "null" && $id != null) || isset($params["list_id"]) && $params["list_id"] == "null") {
			  
		          $data["ListsTasks"] = $this->TaskList->getTaskListsTasksByTaskListId($id);
			  //print_r($data["ListsTasks"]);
		          $taskIds = $this->accId($data["ListsTasks"], "ListTask", "task_id");
			} else {
			  $tasks = $this->TaskList->getTasks($userId, $params);
			  $taskIds = $this->accId($tasks, "Task", "id");
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
			  
			  $params["task_id"] = implode(",", $taskIds);
			  $data["Tasks"] = $this->TaskList->getTasks($userId, $params);
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
			  $data["Contexts"] = $this->TaskList->getContexts($userId, array("context_id" => implode(",", $contextIds)));
			}
	
			if (!empty($userIds)){
			   	$data["Users"] = $this->TaskList->getUsersByUserIds($userIds);
			}
		}

		return $data;
	}

	function getTaskListById($params = null){
	  return $this->getTaskLists($params);
	}

	function view($id = null){
	  $params =  $this->params["url"];
	  $userId = $_SESSION['Auth']['User']['id'];
	  $this->set('user_id', $userId);
	  if ($this->RequestHandler->isAjax()){
	    $listId = isset($params["list_id"]) ? $params["list_id"] : null;
	    $this->set('data', $this->getTaskListById($params));
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
	  $params = $this->params["url"];


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
		  $params["list_id"] = $this->TaskList->id;
		  $this->data = $this->getTaskListById($params);
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
	  $params = $this->params["url"];
		$this->TaskList->id = $listId;
		$this->data["List"]["parent_id"] = $toListId;

		$this->data["TaskList"] = $this->data["List"];
		unset($this->data["List"]);
		
		if ($this->TaskList->save($this->data)){

		  $params["list_id"] = $this->TaskList->id;
		  $this->data = $this->getTaskListById($params);
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

	function activate($id) {
	  $this->setActive($id, true);
	}

	function deactivate($id) {
	  $this->setActive($id, false);
	}

	function setActive($id, $active){
	  if ($id){
	    $params = $this->params["url"];
	    $this->TaskList->id = $id;
	    $this->data['TaskList']['active'] = $active;
	    
	    if ($this->TaskList->save($this->data)){
	      $params["list_id"] = $this->TaskList->id;
	      $this->data = $this->getTaskListById($params);
	      $this->set('data', $this->data);
	    } else {
	      $this->set('data', false);
	    }
	    
	    $this->render("/general/json", "ajax");
	  }
	}

	function restore($id){
	  if ($id){
	    $params = $this->params["url"];
	    $this->TaskList->id = $id;
	    $this->data['TaskList']['deleted'] = false;
	    
	    if ($this->TaskList->save($this->data)){
	      unset($this->params["url"]["deleted"]);
	      $this->params["url"]["list_id"] = $id;
	      $this->data = $this->getTaskListById($params);
	      $this->set('data', $this->data);
	    } else {
	      $this->set('data', false);
	    }
	    
	    $this->render("/general/json", "ajax");
	  }
	}

	function autocomplete(){
	  $userId = $_SESSION['Auth']['User']['id'];
	  $params = $this->params["url"];
		
	  $this->data = 
	    $this->TaskList->query("select List.id, List.active, List.name, List.parent_id from task_lists as List inner join task_lists_users on " .
				"task_lists_users.task_list_id = List.id and List.deleted = false and task_lists_users.user_id = " . 
				   $userId . " where name like '%" . $params["query"] . "%' group by List.id limit 8");
	  $this->set('data', $this->data);
	    
	    $this->render("/general/json", "ajax");
	}
}

?>

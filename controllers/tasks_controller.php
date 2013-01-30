<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function view(){
	  $userId = $_SESSION['Auth']['User']['id'];
	  $this->data["Tasks"] = $this->Task->getTasks($userId, $this->params["url"]);
	  $this->set("user_id", $userId);
	  $this->set('data', $this->data);
	  $this->render('/general/json', 'ajax');
	}

	function index($id = null){
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("user_id", $userId);
	}

	function add($id = null){
		$userId = $_SESSION['Auth']['User']['id'];
		if (!empty($this->data)){
			$this->data["User"] = array();
			$this->data["User"]["User"] = $userId;

			if (isset($this->data["Task"]["tags"])){
				$test = $this->Task->addTags($this->data["Task"]['tags'], $userId);
				//print_r($test);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["Task"]["contexts"])){
				$test = $this->Task->addContexts($this->data["Task"]['contexts'], $userId);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			} 

			if (isset($this->data["Task"]["users"])){
				$test = $this->Task->addUsers($this->data["Task"]['users'], $userId);
				//print_r($test);
				$this->data["User"] = array();
				$this->data["User"]["User"] = $test;
			}
		
			if (isset($this->data["List"])) {
			  $this->data["TaskList"] = $this->data["List"];
			}

			// Attach to parent
			//$this->data['TaskList']['TaskList'][0] = $id;

			$this->Task->create();
			//$this->data["Task"]["id"] = $this->Task->id;

			//print_r($this->data);
			if ($this->Task->save($this->data)){
			  $this->data = $this->getTaskById($this->Task->id);
				//print_r($this->data);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function edit($id = null){
		$userId = $_SESSION['Auth']['User']['id'];

		if (isset($this->data["Task"]["tags"])){
			$this->data["Tag"] = $this->Task->addTags($this->data['Task']['tags'], $userId); 
		}
		
		if (isset($this->data["Task"]["contexts"])){
			$this->data["Context"] = $this->Task->addContexts($this->data['Task']['contexts'], $userId);
		}
		
		if (isset($this->data["Task"]["contexts"])){
			$this->data["User"] = $this->Task->addUsers($this->data['Task']['users'], $userId);
		}
					
		if ($this->Task->save($this->data)){
		  $this->data = $this->getTaskById($id, $this->params["url"]);
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	

	function getTaskById($id){
		$userId = $_SESSION['Auth']['User']['id'];
		$data = array();
		$data["Tasks"] = $this->Task->getTaskByTaskId($id, $userId);

		$taskIds = $this->accId($data["Tasks"], "Task", "id");

		if (!empty($taskIds)){
			$data["ListsTasks"] = $this->Task->getTaskListsTasksByTaskIds($taskIds);
			$listIds = $this->accId($data["ListsTasks"], "ListTask", "list_id");

			if (!empty($listIds)){
				$data["Lists"] = $this->Task->getTaskListsByTaskListIds($listIds, $userId);
			}

			$data["TasksUsers"] = $this->Task->getTasksUsersByTaskIds($taskIds);
			$data["TagsTasks"] = $this->Task->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Task->getContextsTasksByTaskIds($taskIds);

			$tagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$userIds = $this->accId($data["TasksUsers"], "TaskUser", "user_id");

			if (!empty($tagIds)){
				$data["Tags"] = $this->Task->Tag->getTagsByTagIds($tagIds, $userId);
			}			
			
			if (!empty($contextIds)){
			  $data["Contexts"] = $this->Task->Context->getContexts($userId, array("context_id" => implode(",", $contextIds)));
			}
			
			if (!empty($userIds)) {
				$data["Users"] = $this->Task->User->getUsersByUserIds($userIds);
			}

		}
		return $data;
	}
	
	/* TODO: ADD PARENT */
	function getTasks($params){
		$userId = $_SESSION['Auth']['User']['id'];
		$data = array();
		$data["Tasks"] = $this->Task->getTasks($userId, $params);
		
		$taskIds = $this->accId($data["Tasks"], "Task", "id");

		if (!empty($taskIds)) {
			$data["Lists"] = $this->Task->getTaskListsByTasksIds($taskIds);
			$data["TagsTasks"] = $this->Task->getTagsTasksByTaskIds($taskIds);
			$data["ContextsTasks"] = $this->Task->getContextsTasksByTaskIds($taskIds);
			$data["TasksUsers"] = $this->Task->getTasksUsersByTaskIds($taskIds);

			$tagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$contextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$userIds = $this->accId($data["TasksUsers"], "TaskUser", "user_id");
		}		

		if (!empty($tagIds)){
			$data["Tags"] = $this->Task->getTagsByTagIds($tagIds, $userId);
		}

		if (!empty($contextIds)){
			$data["Contexts"] = $this->Task->getContextsByContextIds($contextIds, $userId);
		}

		if (!empty($userIds)) {
			$data["Users"] = $this->Task->getUsersByUserIds($userIds);
		}

		return $data;
	}
			
	function all($checked = "false"){
		$userId = $_SESSION['Auth']['User']['id'];
        $this->set('data', $this->getTasks($checked));
		$this->set("user_id", $userId);
        $this->render('/general/json', 'ajax');
	}

	function shared() {
		$userId = $_SESSION['Auth']['User']['id'];
        $this->set('data', $this->getTasks("false", true));
        $this->render('/general/json', 'ajax');
	}

	function setChecked($id, $checked){	
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;
		
			if ($this->Task->save($this->data)){
			  $this->data = $this->getTaskById($id, $this->params["url"]);
				$this->set('data', $this->data);
			} else {
				$this->set('data', false);
			}

			$this->render("/general/json", "ajax");
		}

	}

	function move($taskId, $fromListId, $toListId) {
		$data = array();
		$index = 0;

		$this->Task->deleteTaskListTaskByTaskIdAndTaskListId($taskId, $fromListId);
		$data["ListsTasks"] = array();

		if (mysql_affected_rows() >= 0){
			$data["ListsTasks"][$index] = array();
			$data["ListsTasks"][$index]["ListTask"] = array();
			$data["ListsTasks"][$index]["ListTask"]["deleted"] = true;
			$data["ListsTasks"][$index]["ListTask"]["task_id"] = $taskId;
			$data["ListsTasks"][$index]["ListTask"]["list_id"] = $fromListId;
			$index++;
		}

		$this->Task->addTaskListTask($taskId, $toListId);

		if (mysql_affected_rows() > 0){
			$data["ListsTasks"][$index] = array();
			$data["ListsTasks"][$index]["ListTask"] = array();
			$data["ListsTasks"][$index]["ListTask"]["id"] = mysql_insert_id();
			$data["ListsTasks"][$index]["ListTask"]["task_id"] = $taskId;
			$data["ListsTasks"][$index]["ListTask"]["list_id"] = $toListId;
		}

		
				$this->set('data', $data);
			$this->render("/general/json", "ajax");
	}

	function check($id){
		$this->setChecked($id, 1);
	}

	function uncheck($id){
		$this->setChecked($id, 0);
	}

	function delete($id){
		$status = false;

		$data["Tasks"] = array();
		$data["Tasks"][0] = array();
		$data["Tasks"][0]["Task"] = array();
		$data["Tasks"][0]["Task"]["id"] = $id;
		$data["Tasks"][0]["Task"]["deleted"] = true;

		$this->Task->set("deleted",true);
		if ($this->Task->save()){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}

	function restore($id){
	  if ($id){
	    $this->Task->id = $id;
	    $this->data['Task']['deleted'] = false;
	    
	    if ($this->Task->save($this->data)){
	      $this->data = $this->getTaskById($id, $this->params["url"]);
	      $this->set('data', $this->data);
	    } else {
	      $this->set('data', false);
	    }
	    
	    $this->render("/general/json", "ajax");
	  }
	}
}

?>

<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function view($id){
			$this->data = $this->Task->getTaskById($id);

        	$this->set('data', $this->data);
        	$this->render('/general/json', 'ajax');
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
			$this->data = $this->getTaskById($id);
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
			$data["TaskListsTasks"] = $this->Task->getTaskListsTasksByTaskIds($taskIds);
			$taskListIds = $this->accId($data["TaskListsTasks"], "TaskListTask", "id");

			if (!empty($taskListIds)){
				$data["TaskLists"] = $this->Task->getTaskListsByTaskListIds($taskListIds, $userId);
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
				$data["Contexts"] = $this->Task->Context->getContextsByContextIds($contextIds, $userId);
			}
			
			if (!empty($userIds)) {
				$data["Users"] = $this->Task->User->getUsersByUserIds($userIds);
			}

		}
		return $data;
	}
	
	/* TODO: ADD PARENT */
	function getTasks($checked){
		$userId = $_SESSION['Auth']['User']['id'];
		$data = array();
		$data["Tasks"] = $this->Task->getTasks($userId, $checked);
		
		$taskIds = $this->accId($data["Tasks"], "Task", "id");
		$data["TaskLists"] = $this->Task->getTaskListsByTasksIds($taskIds);
		$data["TagsTasks"] = $this->Task->getTagsTasksByTaskIds($taskIds);
		$data["ContextsTasks"] = $this->Task->getContextsTasksByTaskIds($taskIds);
		$data["TasksUsers"] = $this->Task->getTasksUsersByTaskIds($taskIds);

		$tagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
		$contextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		$userIds = $this->accId($data["TasksUsers"], "TaskUser", "user_id");
		
		if (!empty($tagIds)){
			$data["Tags"] = $this->Task->Tag->getTagsByTagIds($tagIds, $userId);
		}

		if (!empty($contextIds)){
			$data["Contexts"] = $this->Task->Context->getContextsByContextIds($contextIds, $userId);
		}

		if (!empty($userIds)) {
			$data["Users"] = $this->Task->User->getUsersByUserIds($userIds);
		}

		return $data;
	}
			
	function all($checked = false){
        $this->set('data', $this->getTasks($checked));
        $this->render('/general/json', 'ajax');
	}

	function setChecked($id, $checked){	
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;
		
			if ($this->Task->save($this->data)){
				$this->data = $this->getTaskById($id);
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
		$data["TaskListsTasks"] = array();

		if (mysql_affected_rows() >= 0){
			$data["TaskListsTasks"][$index] = array();
			$data["TaskListsTasks"][$index]["TaskListTask"] = array();
			$data["TaskListsTasks"][$index]["TaskListTask"]["deleted"] = true;
			$data["TaskListsTasks"][$index]["TaskListTask"]["task_id"] = $taskId;
			$data["TaskListsTasks"][$index]["TaskListTask"]["task_list_id"] = $fromListId;
			$index++;
		}

		$this->Task->addTaskListTask($taskId, $toListId);

		if (mysql_affected_rows() > 0){
			$data["TaskListsTasks"][$index] = array();
			$data["TaskListsTasks"][$index]["TaskListTask"] = array();
			$data["TaskListsTasks"][$index]["TaskListTask"]["id"] = mysql_insert_id();
			$data["TaskListsTasks"][$index]["TaskListTask"]["task_id"] = $taskId;
			$data["TaskListsTasks"][$index]["TaskListTask"]["task_list_id"] = $toListId;
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

		if ($this->Task->delete($id)){
			$status = true;
		} 

        $this->set('data', $data);
        $this->render('/general/json', 'ajax');
	}
}

?>

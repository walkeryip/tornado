<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 

	function view($id){
		if ($this->RequestHandler->isAjax()){
			$this->data = $this->Task->getTaskById($id);

        	$this->set('data', $this->data);
        	$this->render('/general/json', 'ajax');
		}
	}

	function add($id = null){
		if (!empty($this->data)){
			if (isset($this->data["Task"]["tags"])){
				$test = $this->Task->addTags($this->data["Task"]['tags']);
				//print_r($test);
				$this->data["Tag"] = array();
				$this->data["Tag"]["Tag"] = $test;
			} 

			if (isset($this->data["Task"]["contexts"])){
				$test = $this->Task->addContexts($this->data["Task"]['contexts']);
				//print_r($test);
				$this->data["Context"] = array();
				$this->data["Context"]["Context"] = $test;
			}
			// Attach to parent
			//$this->data['TaskList']['TaskList'][0] = $id;

			$this->Task->create();
			//$this->data["Task"]["id"] = $this->Task->id;

			//print_r($this->data);
			if ($this->Task->save($this->data)){
                $this->data = $this->Task->find(array('id' => $this->Task->id));
				//print_r($this->data);
				$this->set('data', $this->data);
				$this->render('/general/json', 'ajax');
			}
		}
	}

	function edit($id = null){
		if (isset($this->data["Task"]["tags"])){
			$this->data["Tag"] = $this->Task->addTags($this->data['Task']['tags']); 
		}
		
		if (isset($this->data["Task"]["contexts"])){
			$this->data["Context"] = $this->Task->addContexts($this->data['Task']['contexts']);
		}
					
		if ($this->Task->save($this->data)){
			$this->data = $this->Task->find(array('id' => $id));
			//print_r($this->data);
			$this->set('data', $this->data);
		} else {
        	$this->set('data', "false");
		}
	
	   	$this->render('/general/json', 'ajax');
	}	

	
	function getTasks($checked){
		$userId = $_SESSION['Auth']['User']['id'];
		$data = array();
		$data["Tasks"] = $this->Task->getTasks($userId, $checked);
		
		$taskIds = $this->accId($data["Tasks"], "Task", "id");
		$data["TaskLists"] = $this->Task->getTaskListsByTasksIds($taskIds);
		$data["TagsTasks"] = $this->Task->getTagsTasksByTaskIds($taskIds);
		$data["ContextsTasks"] = $this->Task->getContextsTasksByTaskIds($taskIds);
		$data["TasksUsers"] = $this->Task->getUsersTasksByTaskIds($taskIds);

		$tagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
		$data["Tags"] = $this->Task->Tag->getTagsByTagIds($tagIds);

		$contextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
		$data["Contexts"] = $this->Task->Context->getContextsByContextIds($contextIds);
		
		$userIds = $this->accId($data["TasksUsers"], "TaskUser", "user_id");
		$data["Users"] = $this->Task->User->getUsersByUserIds($userIds);
		
		return $data;
	}
			
	function all($checked = false){
	

		/*$data = $this->Task->Context->query("select * from tasks as Task " .
		"inner join tasks_users as TasksUsers on TasksUsers.task_id = Task.id and TasksUsers.user_id = 5 " .
		"inner join tags_tasks as TagsTasks on TagsTasks.task_id = Task.id " . 
		"inner join tags as Tag on Tag.id = TagsTasks.tag_id " .
		"inner join contexts_tasks as ContextsTasks on ContextsTasks.task_id = Task.id " .
		"inner join contexts as Context on Context.id = ContextsTasks.context_id"); 
		*/
		//print_r($data);
			
        $this->set('data', $this->getTasks($checked));
        $this->render('/general/json', 'ajax');
	}

	function setChecked($id, $checked){	
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;
		
			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('data', $this->data);
			} else {
				$this->set('data', false);
			}

			$this->render("/general/json", "ajax");
		}

	}

	function check($id = null){
		$this->setChecked($id, 1);
	}

	function uncheck($id = null){
		$this->setChecked($id, 0);
	}

	function delete($id = null){
		$status = false;
		if ($this->Task->delete($id)){
			$status = true;
		} 

        $this->set('data', $status);
        $this->render('/general/json', 'ajax');
	}
}

?>

<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 
	var $scaffold;

/*	function index($id = null){
		$tasksDone = $this->Task->find('all', array('conditions' => array('Task.checked' => 1)));
		$tasks = $this->Task->find('all', array('recursive' => 1, 'conditions' => array('Task.checked' => 0)));

		$this->set('tasksDone', $tasksDone);
		$this->set('tasks', $tasks);
	}*/

	function view($id){
		if ($this->RequestHandler->isAjax()){
			$this->data = $this->Task->getTaskById($id);

        	$this->set('data', $this->data);
        	$this->render('/general/json', 'ajax');
		} else {

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
		if ($this->RequestHandler->isAjax()){
				$this->data["Tag"] = $this->Task->addTags($this->data['Task']['tags']); 
				$this->data["Context"] = $this->Task->addContexts($this->data['Task']['contexts']);
	
					
				if ($this->Task->save($this->data)){
					$this->data = $this->Task->find(array('id' => $id));
					//print_r($this->data);
					$this->set('data', $this->data);
				} else {
        			$this->set('data', "false");
				}
	
	   			$this->render('/general/json', 'ajax');
		} else {
			if (!$id){
				$this->Session->setFlash("Invalid task");
				$this->redirect(array('action' => 'index'), null, true);
			}

			if (empty($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				
				$this->data['Task']['tags'] = $this->Task->getLabels($this->data['Tag']);
				$this->data['Task']['contexts'] = $this->Task->getLabels($this->data['Context']);

				$this->set('taskId', $id);
				$this->render('/elements/task_edit', 'ajax');	
			} else {
				$this->Task->addTags($this->data['Task']['tags']); 
				$this->Task->addContexts($this->data['Task']['contexts']);

				if ($this->Task->save($this->data)){
					$this->data = $this->Task->find(array('id' => $id));
					$this->set('task', $this->data);
					$this->render('/elements/task', 'ajax');
				}
			}
		}
	}	

	function all($checked = false){
		if ($this->RequestHandler->isAjax()){
			$data = array();
		
		    $data["Tasks"] = $this->Task->query("SELECT * FROM tasks as Task where checked = " . $checked);
			$taskIds = $this->accId($data["Tasks"], "Task", "id");

			$data["TaskLists"] = $this->Task->query("select * from task_lists as TaskList where id in (select task_list_id from task_lists_tasks where task_id in (" . implode(",", $taskIds) . "))");

			$data["TagsTasks"] = $this->Task->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["ContextsTasks"] = $this->Task->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");

			$tagsTasksTagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$data["Tags"] = $this->Task->Tag->query("select * from tags as Tag where id in (" . 
				implode(",", $tagsTasksTagIds) . ")");

			$contextsTasksContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$data["Contexts"] = $this->Task->Context->query("select * from contexts as Context where id in (" . 
				implode(",", $contextsTasksContextIds) . ")");


			//$tasks = $this->TaskList->Task->getTasksByListIdTest($id);
			//$list['List'] = $lists;
			//$list['Task'] = $tasks;
        	$this->set('data', $data);
        	$this->render('/general/json', 'ajax');
		} else {
			
			//$this->set('list_id', $id);
			//$this->set('tasks', $tasks);
			//$this->set('tasksDone', $tasksDone);
		}
	}

	function setChecked($id, $checked){	
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;

//			if ($this->RequestHandler->isAjax()){
		
				if ($this->Task->save($this->data)){
					$this->data = $this->Task->find(array('id' => $id));
					$this->set('data', $this->data);
				} else {
					$this->set('data', false);
				}

			$this->render("/general/json", "ajax");
			/*else {
				if ($this->Task->save($this->data)){
					$this->data = $this->Task->find(array('id' => $id));
					$this->set('task', $this->data);
					$this->render('/elements/task', 'ajax');
				}
			}*/
		}

	}

	function check($id = null){
		$this->setChecked($id, 1);
	}

	function uncheck($id = null){
		$this->setChecked($id, 0);
	}

	function delete($id = null){
		if ($this->RequestHandler->isAjax()){
			$status = false;
			if ($this->Task->delete($id)){
				$status = true;
			} 

        	$this->set('data', $status);
        	$this->render('/general/json', 'ajax');
		} else {
			if (!$id){
				$this->Session->setFlash("Invalid task");
				$this->redirect($this->referer());
			}

			if ($this->Task->delete($id)){
				$this->Session->setFlash("The task has been deleted!");
				$this->redirect($this->referer());
			}
		}
	}
}

?>

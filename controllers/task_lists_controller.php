<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');
    var $components = array('RequestHandler'); 
	var $scaffold;

	function index($id = null){
		if ($this->RequestHandler->isAjax()){
			$this->data = $this->TaskList->getTaskListsByParentId(null);

        	$this->set('data', $this->data);
        	$this->render('/general/json', 'ajax');
		} else {
			$this->data = $this->TaskList->getTaskListsByParentId(null);

			$this->set('lists', $this->data);
		}
	}

	function todo(){
		$this->data = $this->TaskList->getTaskListsByParentId(null);
		
		$this->set('lists', $this->data);
	}

	function add($id = null){
		if (!empty($this->data)){
			$this->TaskList->create();

			$this->TaskList->addTags($this->data['TaskList']['tags']); 
			$this->TaskList->addContexts($this->data['TaskList']['contexts']);
			
			$this->TaskList->id = null;

			$this->data['TaskList']['parent_id'] = $id;	
			
			if ($this->TaskList->save($this->data)){
				$this->data = $this->TaskList->getTaskListsByParentId($id);

				if ($this->RequestHandler->isAjax()){
        			$this->set('data', $this->data);
        			$this->render('/general/json', 'ajax');
				} else {
					$this->set('lists', $this->data);
					$this->render('/elements/lists', 'ajax');
				}
			} else {
				$this->Session->setFlash("Failed to save list. Please try again");
			}
		}
	}


	function view($id = null){
		$this->TaskList->id = $id;

		if ($this->RequestHandler->isAjax()){
			$data = array();
		
			$data["TaskLists"] = $this->TaskList->query("select * from task_lists as TaskList where id = " . $id . " or parent_id = " . $id);
		    $data["Tasks"] = $this->TaskList->Task->query("SELECT * FROM tasks as Task WHERE id in (SELECT task_id FROM task_lists_tasks WHERE task_list_id = " . $id . ")");

			$taskIds = $this->accId($data["Tasks"], "Task", "id");
			$data["TagsTasks"] = $this->TaskList->query("select * from tags_tasks as TagTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["ContextsTasks"] = $this->TaskList->query("select * from contexts_tasks as ContextTask where task_id in (" . implode(",", $taskIds) . ")");
			$data["TagsTaskLists"] = $this->TaskList->query("select * from tags_task_lists as TagTaskList where task_list_id = " . $id);
			$data["ContextsTaskLists"] = $this->TaskList->query("select * from contexts_task_lists as ContextTaskList where task_list_id = " . $id);

			$tagsTasksTagIds = $this->accId($data["TagsTasks"], "TagTask", "tag_id");
			$tagsTaskListsTagIds = $this->accId($data["TagsTaskLists"], "TagTaskList", "tag_id");
			$data["Tags"] = $this->TaskList->Tag->query("select * from tags as Tag where id in (" . 
				implode(",", array_unique(array_merge($tagsTasksTagIds,$tagsTaskListsTagIds))) . ")");

			$contextsTasksContextIds = $this->accId($data["ContextsTasks"], "ContextTask", "context_id");
			$contextsTaskListsContextIds = $this->accId($data["ContextsTaskLists"], "ContextTaskList", "context_id");
			$data["Contexts"] = $this->TaskList->Context->query("select * from contexts as Context where id in (" . 
				implode(",", array_unique(array_merge($contextsTasksContextIds,$contextsTaskListsContextIds))) . ")");


			//$tasks = $this->TaskList->Task->getTasksByListIdTest($id);
			//$list['List'] = $lists;
			//$list['Task'] = $tasks;
        	$this->set('data', $data);
        	$this->render('/general/json', 'ajax');
		} else {
			
			$this->set('list_id', $id);
			//$this->set('tasks', $tasks);
			//$this->set('tasksDone', $tasksDone);
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
        if ($this->RequestHandler->isAjax()){

            $this->TaskList->addTags($this->data['TaskList']['tags']);
            $this->TaskList->addContexts($this->data['TaskList']['contexts']);

            if ($this->TaskList->save($this->data)){
                $this->data = $this->TaskList->getTaskListById($id);
                $this->set('data', $this->data);
            } else {
                $this->set('data', "false");
            }

            $this->render('/general/json', 'ajax');
        }

    }

	function delete($id = null){
		if (!$id){
			$this->Session->setFlash("Invalid list");
			$this->redirect($this->referer());
		}

		if ($this->TaskList->delete($id)){
			$this->Session->setFlash("The list has been deleted!");
			$this->redirect($this->referer());
		}
	}
}

?>

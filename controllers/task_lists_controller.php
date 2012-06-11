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

		$conditions = array('TaskList.id' => $id);
		$list = $this->TaskList->getTaskListById($id);
		$lists = $this->TaskList->getTaskListsByParentId($id);
		$tasks = $this->TaskList->Task->getTasksByListId($id, false);
		$tasksDone = $this->TaskList->Task->getTasksByListId($id, true);

		if ($this->RequestHandler->isAjax()){
			$tasks = $this->TaskList->Task->getTasksByListIdTest($id);
			$list['List'] = $lists;
			$list['Task'] = $tasks;
        	$this->set('data', $list);
        	$this->render('/general/json', 'ajax');
		} else {
			$this->set('list', $list);
			$this->set('lists', $lists);
			$this->set('tasks', $tasks);
			$this->set('tasksDone', $tasksDone);
		}
	}

	function edit($id = null){
		if (!$id){
			$this->Session->setFlash("Invalid list");
			$this->redirect(array('action' => 'index'), null, true);
		}

		if (empty($this->data)){
			$this->data = $this->TaskList->getTaskListById($id);
				
			$this->data['TaskList']['tags'] = $this->TaskList->getLabels($this->data['Tag']);
			$this->data['TaskList']['contexts'] = $this->TaskList->getLabels($this->data['Context']);

			$this->set('listId', $id);
			$this->render('/elements/list_edit', 'ajax');	
		} else {
			$this->TaskList->addTags($this->data['TaskList']['tags']); 
			$this->TaskList->addContexts($this->data['TaskList']['contexts']);

			if ($this->TaskList->save($this->data)){
				$this->data = $this->TaskList->getTaskListById($id);
				$this->set('list', $this->data);
				$this->render('/elements/list', 'ajax');
			}
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

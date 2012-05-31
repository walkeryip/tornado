<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $scaffold;

	function index($id = null){
		$this->data = $this->TaskList->getTaskListsByParentId(null);

		$this->set('lists', $this->data);
	}

	function todo(){
		$this->data = $this->TaskList->getTaskListsByParentId(null);
		
		$this->set('lists', $this->data);
	}

	function add($id = null){
		if (!empty($this->data)){

			$this->TaskList->addTags($this->data['TaskList']['tags']); 
			$this->TaskList->addContexts($this->data['TaskList']['contexts']);
			$this->TaskList->id = null;
			$this->TaskList->parent_id = $id;

			$this->TaskList->create();
			if ($this->TaskList->save($this->data)){
				$this->data = $this->TaskList->getTaskListsByParentId($id);

				$this->set('lists', $this->data);
				$this->render('/elements/lists', 'ajax');
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

		$this->set('list', $list);
		$this->set('lists', $lists);
		$this->set('tasks', $tasks);
		$this->set('tasksDone', $tasksDone);
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
			$this->redirect(array('action' => 'index'), null, true);
		}

		if ($this->TaskList->delete($id)){
			$this->Session->setFlash("The list has been deleted!");
			$this->redirect(array('action' => 'index'), null, true);
		}
	}
}

?>

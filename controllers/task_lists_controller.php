<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $scaffold;

	function index($id = null){
		$this->data = $this->TaskList->find('all', array('recursive' => 1, 'conditions' => array(
							'TaskList.parent_id' => 0)));

		$this->set('lists', $this->data);
	}

	function todo(){
		$this->data = $this->TaskList->find('all', 
			array('recursive' => 1,
				  'conditions' => array('TaskList.parent_id' => 'null')));
		
		$this->set('lists', $this->data);
	}

	function add($id = null){
		if (!empty($this->data)){
			$this->createLabels($this->TaskList->Tag, $this->data['TaskList']['tags']);
			$this->createLabels($this->TaskList->Context, $this->data['TaskList']['contexts']);

			$this->data['TaskList']['id'] = null;
			$this->data['TaskList']['parent_id'] = $id;
			$this->TaskList->create();
			if ($this->TaskList->save($this->data)){
				$this->data = $this->TaskList->find('all',
						array('recursive' => 1,
				  		'conditions' => array('TaskList.parent_id' => $id)));
				$this->set('lists', $this->data);
				$this->render('/elements/lists', 'ajax');
			} else {
				$this->Session->setFlash("Failed to save list. Please try again");
			}
		}
	}

	function view($id = null){
		$this->TaskList->id = $id;
		$list = $this->TaskList->find('first', 
			array('recursive' => 1,
				  'conditions' => array('TaskList.id' => $id)));
		
		$lists = $this->TaskList->find('all',
			array('recursive' => 1,
				  'conditions' => array('TaskList.parent_id' => $id)));

		$this->loadModel('Task');
		$this->Task->Behaviors->attach('Containable');
		$this->Task->bindModel(array('hasOne' => array('TaskListsTasks')));
		$tasks = $this->Task->find('all', array(
					'fields' => array('Task.*'),
					'contain' => array('Tag', 'Context', 'TaskListsTasks'),
					'conditions' => array(
						'Task.checked' => false,
						'TaskListsTasks.task_list_id' => $id)));

		$tasksDone = $this->Task->find('all', array(
					'fields' => array('Task.*'),
					'contain' => array('Tag', 'Context', 'TaskListsTasks'),
					'conditions' => array(
						'Task.checked' => true,
						'TaskListsTasks.task_list_id' => $id)));

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
			$this->data = $this->TaskList->find(array('TaskList.id' => $id));
				
			//$this->setTags($id);
			$this->data['TaskList']['tags'] = $this->getLabels($this->data['Tag']);
			$this->data['TaskList']['contexts'] = $this->getLabels($this->data['Context']);
			//$this->setContexts($id);

			$this->set('listId', $id);
			$this->render('/elements/list_edit', 'ajax');	
		} else {
			$this->createLabels($this->TaskList->Tag, $this->data['TaskList']['tags']);
			$this->createLabels($this->TaskList->Context, $this->data['TaskList']['contexts']);

			if ($this->TaskList->save($this->data)){
				$this->data = $this->TaskList->find(array('TaskList.id' => $id));
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

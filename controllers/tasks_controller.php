<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $scaffold;

	function index($id = null){
		$tasksDone = $this->Task->find('all', array('conditions' => array('Task.checked' => 1)));
		$tasks = $this->Task->find('all', array('recursive' => 1, 'conditions' => array('Task.checked' => 0)));

		$this->set('tasksDone', $tasksDone);
		$this->set('tasks', $tasks);
	}

	function add($id){
		if (!empty($this->data)){
			$this->Task->addTags($this->data['Task']['tags']); 
			$this->Task->addContexts($this->data['Task']['contexts']);

			// Attach to parent
			$this->data['TaskList']['TaskList'][0] = $id;

			$this->Task->create();
			if ($this->Task->save($this->data)){
				$this->data = $this->Task->getTasksByListId($id, false); 
					
				$this->set('tasks', $this->data);
				$this->render('/elements/tasks', 'ajax');
			} else {
				$this->Session->setFlash("Failed to save task. Please try again");
			}
		}
	}

	function edit($id = null){
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

	function setChecked($id, $checked){
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = $checked;

			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('task', $this->data);
				$this->render('/elements/task', 'ajax');
			}
		}
	}

	function check($id = null){
		$this->setChecked($id, 1);
	}

	function uncheck($id = null){
		$this->setChecked($id, 0);
	}

	function delete($id = null){
		if (!$id){
			$this->Session->setFlash("Invalid task");
			$this->redirect(array('action' => 'index'), null, true);
		}

		if ($this->Task->delete($id)){
			$this->Session->setFlash("The task has been deleted!");
			$this->redirect(array('action' => 'index'), null, true);
		}
	}
}

?>

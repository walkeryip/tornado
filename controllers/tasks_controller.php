<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class TasksController extends AppController {
	var $name = 'Tasks';
	var $helpers = array('Html', 'Form', 'Ajax');

	function index($id = null){
		$this->data = $this->Task->find('all', array('recursive' => 1));

		$this->set('tasks', $this->data);
	}

	function add(){
		if (!empty($this->data)){
			$this->createTags();
			$this->createContexts();

			$this->Task->create();
			if ($this->Task->save($this->data)){
				$this->Session->setFlash("The task has been created!");
				$this->redirect(array('action' => 'index'), null, true);
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
				
			$this->data['Task']['tags'] = $this->getLabels($this->data['Tag']);
			$this->data['Task']['contexts'] = $this->getLabels($this->data['Context']);

			$this->set('taskId', $id);
			$this->render('/elements/task_edit', 'ajax');	
		} else {
			$this->createLabels($this->Task->Tag, $this->data['Task']['tags']);
			$this->createLabels($this->Task->Context, $this->data['Task']['contexts']);

			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('task', $this->data);
				$this->render('/elements/task', 'ajax');
			}
		}
	}	

	function check($id = null){
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = 1;

			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('task', $this->data);
				$this->render('/elements/task', 'ajax');
			}
		}
	}

	function uncheck($id = null){
		if ($id){
			$this->Task->id = $id;
			$this->data['Task']['checked'] = 0;

			if ($this->Task->save($this->data)){
				$this->data = $this->Task->find(array('id' => $id));
				$this->set('task', $this->data);
				$this->render('/elements/task', 'ajax');
			}
		}
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

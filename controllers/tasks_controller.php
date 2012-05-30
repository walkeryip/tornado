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
			$this->createLabels($this->Task->Tag, $this->data['Task']['tags']);
			$this->createLabels($this->Task->Context, $this->data['Task']['contexts']);

			$this->data['List']['List'][0] = $id; 

			$this->Task->create();
			if ($this->Task->save($this->data)){

				$this->Task->Behaviors->attach('Containable');
				$this->Task->bindModel(array('hasOne' => array('TaskListsTasks')));
				$this->data = $this->Task->find('all', array(
					'fields' => array('Task.*'),
					'contain' => array('Tag', 'Context', 'TaskListsTasks'),
					'conditions' => array(
						'Task.checked' => false,
						'TaskListsTasks.task_list_id' => $id)));

				$this->set('tasks', $this->data);
				$this->render('/elements/tasks', 'ajax');
			} else {
				$this->Session->setFlash("Failed to save task. Please try again");
			}
		}
	}

/*function add($id = null){
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
	}*/

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

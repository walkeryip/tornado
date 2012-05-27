<?php

class TaskListsController extends AppController {
	var $name = 'TaskLists';
	var $helpers = array('Html', 'Form', 'Ajax');

	function index($id = null){
		$this->data = $this->TaskList->find('all', array('recursive' => 1));

		$this->set('lists', $this->data);
	}

	function todo(){
		$this->data = $this->TaskList->find('all', 
			array('recursive' => 1,
				  'conditions' => array('TaskList.parent_id' => 'null')));
		
		$this->set('lists', $this->data);
	}

	function view($id = null){
		$this->data = $this->TaskList->find('first', 
			array('recursive' => 1,
				  'conditions' => array('TaskList.id' => $id)));
		
		$this->set('list', $this->data);
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

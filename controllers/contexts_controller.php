<?php

// Tags code from http://mrphp.com.au/code/working-habtm-form-data-cakephp
class ContextsController extends AppController {
	var $name = 'Contexts';
	var $helpers = array('Html', 'Form');

	function index($id = null){
		//$this->setTags($id);	
		//$this->setContexts($id);		

		$this->set('contexts', $this->Context->find('all'));
	}

	function add(){
		/*if (!empty($this->data)){
			$this->createTags();
			$this->createContexts();

			$this->Task->create();
			if ($this->Task->save($this->data)){
				$this->Session->setFlash("The task has been created!");
				$this->redirect(array('action' => 'index'), null, true);
			} else {
				$this->Session->setFlash("Failed to save task. Please try again");
			}
		}*/
	}

	function edit($id = null){
		/*if (!$id){
			$this->Session->setFlash("Invalid task");
			$this->redirect(array('action' => 'index'), null, true);
		}

		if (empty($this->data)){
			$this->data = $this->Task->find(array('id' => $id));
				
			$this->data = $this->Task->read(null, $id);

			$this->setTags($id);
			$this->setContexts($id);	
		} else {
			$this->createTags();
			$this->createContexts();

			if ($this->Task->save($this->data)){
				$this->Session->setFlash("The task has been saved!");
				$this->redirect(array('action' => 'index'), null, true);
			} else {
				$this->Session->setFlash("Failed to save task. Please try again");
			}
		}*/
	}	

	function delete($id = null){
		/*if (!$id){
			$this->Session->setFlash("Invalid task");
			$this->redirect(array('action' => 'index'), null, true);
		}

		if ($this->Task->delete($id)){
			$this->Session->setFlash("The task has been deleted!");
			$this->redirect(array('action' => 'index'), null, true);
		}*/
	}
}

?>

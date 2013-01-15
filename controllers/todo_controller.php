<?php

class TodoController extends AppController {
	//var $name = 'Todo';
	var $helpers = array('Html', 'Form', 'Ajax');

	function index($id = null){
		$this->data = $this->TaskList->find('all', 
			array('recursive' => 1,
				  'conditions' => array('List.parent <>' => 'null')));

		$this->set('lists', $this->data);
	}
}

?>

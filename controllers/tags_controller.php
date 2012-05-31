<?php

class TagsController extends AppController {
	var $name = 'Tags';
	var $helpers = array('Html', 'Form');

	function index($id = null){
		$this->set('tags', $this->Tag->find('all'));
	}
}

?>

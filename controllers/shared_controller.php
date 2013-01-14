<?php

class SharedController extends AppController {
	var $name = 'Shared';
	var $uses = array();

	function index(){
		$userId = $_SESSION['Auth']['User']['id'];
		$this->set("user_id", $userId);
	}
}

?>

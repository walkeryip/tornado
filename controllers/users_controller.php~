<?php

class UsersController extends AppController {
	var $name = 'Users';
	var $components = array(
		'RequestHandler');
	
	function register() {    
		if(!empty($this->data)) {        
			$this->User->create();           
			
			if($this->User->save($this->data)) {            
				$this->Auth->login($this->data);            
				$this->redirect('home');    
			} 
		}
	}
		
	public function login() {
	
	}
	
	public function logout() {
	    $this->redirect($this->Auth->logout());
	}
}

?>


<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>	
	<label for="UserUsername">Username</label>
	<input name="data[User][username]" type="text" autocomplete="on" id="UserUsername"><br />
	<label for="UserPassword">Password</label>
	<input type="password" name="data[User][password]" autocomplete="on" id="UserPassword">
    
    </fieldset>
<?php echo $this->Form->end('Login'); ?>
</div>

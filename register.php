<?php 
	require_once 'core/init.php';

	if(input::exists()){
		//echo input::get('username');
		$validate = new Validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 5,
				'max' => 20,
				'unique' => 'users'
			);
			'password' => array(
				'required' => true,
				'min' => 6,
			);
			'rePassword' => array(
				'required' => true,
				'matches' => 'password'
			);
			'name' => array(
				
			);
		));
	}
 ?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" autocomplete="off"></input>
	</div>
	<div class="field">
		<label for="password">Insert password:</label>
		<input type="password" name="password" id="password"></input>
	</div>
	<div class="field">
		<label for="rePassword">Insert password again:</label>
		<input type="password" name="rePassword" id="rePassword"></input>
	</div>
	<div class="field">
		<label for="name">Insert name:</label>
		<input type="text" name="name" id="name"></input>
	</div>
	<input type="submit" value="Register"></input>
</form>
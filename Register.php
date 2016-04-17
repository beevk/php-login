<?php 
	require_once 'core/Init.php';

	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			//Next command doesn't execute hence preventing XSS
			//echo "I've been run";
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 4,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array(
					'required' => true,
					'min' => 6,
				),
				'rePassword' => array(
					'required' => true,
					'matches' => 'password'
				),
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 50
				),
			));

			if($validation->passed()){
				echo "Passed";
			}
			else{
				foreach($validation->errors() as $error){
					echo $error . "<br />";
				}
			}
		}
	}
 ?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off"></input>
	</div>
	<div class="field">
		<label for="password">Insert password:</label>
		<input type="password" name="password"></input>
	</div>
	<div class="field">
		<label for="rePassword">Insert password again:</label>
		<input type="password" name="rePassword" ></input>
	</div>
	<div class="field">
		<label for="name">Insert name:</label>
		<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name"></input>
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>"></input>

	<input type="submit" value="Register"></input>

</form>
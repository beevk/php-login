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
					'min' => 4,
					'max' => 50
				),
			));

			if($validation->passed()){
				//echo "Passed";
				//Session::flash('success', 'You have registered successully!');
				//header('Location: Index.php');
				$user = new User();
				$salt = Hash::salt(32);
				echo $salt . '<br />';
				echo Hash::make(Input::get('password'), $salt) . '<br />';

				try{

					$user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'joined' => date('Y-m-d H:i:s'),
						'groups' => 1
						));
					
					Session::flash('home', 'You have been registered successully!');
					Redirect::to('Index.php');

				}
				catch(Exception $e){
					die($e->getMessage());
				}
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
		<input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" autofocus>
	</div>
	<div class="field">
		<label for="password">Insert password:</label>
		<input type="password" name="password">
	</div>
	<div class="field">
		<label for="rePassword">Insert password again:</label>
		<input type="password" name="rePassword" >
	</div>
	<div class="field">
		<label for="name">Insert name:</label>
		<input type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	<input type="submit" value="Register">

</form>
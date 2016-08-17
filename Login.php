<?php
	require_once "core/Init.php";
	if(Input::exists()){
		//echo "Test works fine";
		if(Token::check(Input::get('token'))){
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
				));
			if($validation->passed()){
				//logs user in
				$user = new User();
				$login = $user->login(Input::get('username'), Input::get('password'));

				if($login){
					echo 'Success!';
				}
				else{
					echo "login failed!";
				}
			}
			else{
				foreach($validation->errors() as $error){
					echo $error . '<br />';
				}
			}
		}
	}
?>
<form method="post" action="">
	<div class="field">
		<label for="username"> Username </label>
		<input type="text" name="username" id="username" autocomplete="off">
	</div>
	<div class="field">
		<label for="password"> Password </label>
		<input type="password" name="password" id="password" autocomplete="off">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="submit" value="log in">
</form>
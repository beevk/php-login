<?php 
	require_once 'core/Init.php';

	$user = new User();

	if(!$user->isLoggedIn()) {
		Redirect::to('Index.php');
	}

	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			//Check current password, check new password fields
			//generate new salt, hash new password and insert it to DB
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'currentPassword' => array(
					'required' => true,
					'min' => 6
				),
				'passwordNew' => array(
					'required' => true,
					'min' => 6
				),
				'rePasswordNew' => array(
					'required' => true,
					'min' => 6,
					'matches' => 'passwordNew'
				)
			));
			if($validation->passed()) {
				//update password
			
				if(Hash::make(Input::get('currentPassword'), $user->data()->salt) !== $user->data()->password) {
					echo "Your current password is wrong";
				}
				else {
					$salt = Hash::salt(32);
					$user->update(array(
						'password' => Hash::make(Input::get('currentPassword'), $salt),
						'salt' => $salt
					));

					Session::flash('home', 'Password updated Successfully!');
					Redirect::to('Index.php');
				}
			}
			else {
				foreach ($validation->errors() as $error) {
					echo $error . '<br />';
				}
			}
		}
	}

 ?>
 <form action="" method="post">
	<div class="field">
		<label for="currentPassword"> Current Password </label>
		<input type="password" name="currentPassword" id="currentPassword" autocomplete="off" autofocus>
	</div>

	<div class="field">
		<label for="passwordNew">Insert new password:</label>
		<input type="password" name="passwordNew">
	</div>

	<div class="field">
		<label for="rePasswordNew">Insert new password again:</label>
		<input type="password" name="rePasswordNew" >
	</div>
	
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

	<input type="submit" value="Change">

</form>
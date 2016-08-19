<?php 
	require_once 'core/Init.php';

	if(!$username = Input::get('user')) {
		Redirect::to('Index.php');
	}
	else {
		//echo $username;
		$user = new User($username);
		if(!$user->exists()) {
			Redirect::to(404);
		}
		else {
			//echo "Exists!";
			$data = $user->data();
		}
	?>
	<h3> Username: <?php echo escape($data->username); ?> </h3>
	<p> Full Name: <?php echo escape($data->name);?> </p>
	<p> Joined date: <?php echo escape($data->joined);?> </p>


	<?php
	}

<?php 
	require_once 'core/Init.php';

	$user = new User();
	$user->logout();

	Redirect::to('Index.php');
 ?>
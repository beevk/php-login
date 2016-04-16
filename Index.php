<?php 
	require_once 'core/Init.php';

	$user = DB::getInstance()->update('users', 6, array(
		'password' => 'nohoney',
		'name' => 'Chandra Bdr Gurung'
	));
	
 ?>
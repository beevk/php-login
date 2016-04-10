<?php 
	require_once 'core/init.php';

	$user = db::getInstance()->update('users', 6, array(
		'password' => 'nohoney',
		'name' => 'Chandra Bdr Gurung'
	));
	
 ?>
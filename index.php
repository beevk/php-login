<?php 
	require_once 'core/init.php';

	//echo config::get('mysql/host');

	//$user = db::getInstance()->query("SELECT * FROM users WHERE username = ?", array('Billy'));
	$user = db::getInstance()->get('users', array('username', '=', 'chandra'));
	if(!$user->count()){
		echo "No User!<br />";
	}
	else{
		echo "OK!<br />";
	}
 ?>
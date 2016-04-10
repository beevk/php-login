<?php 
	require_once 'core/init.php';

	//echo config::get('mysql/host');

	//$user = db::getInstance()->query("SELECT * FROM users");
	$user = db::getInstance()->get('users', array('username', '=', 'alex'));
	if(!$user->count()){
		echo "No User!<br />";
	}
	else{
		//echo "OK!<br />";
		//foreach($user->results() as $user){
		//	echo $user->username . "<br />";
		echo $user->first()->username;
		}
	}
 ?>
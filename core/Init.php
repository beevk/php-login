<?php 
	session_start();

	$GLOBALS['config'] = array(
		'mysql' => array(
				'host' => '127.0.0.1',
				'username' => 'root',
				'password' => 'honeyhive',
				'db' => 'lr'
		),
		'remember' => array(
			'cookieName' => 'hash',
			'cookieExpiry' => 604800
		),
		'session' => array(
			'sessionName' => 'user',
			'tokenName' => 'token'
		)
	);

	spl_autoload_register(function($class){
		require_once 'classes/' . $class . '.php';
	});

	require_once 'functions/Sanitize.php';
?>

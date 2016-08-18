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

	if(Cookie::exists(Config::get('remember/cookieName')) && !Session::exists(Config::get('session/sessionName'))) {
		//echo "User asked to be remembered!";
		$hash = Cookie::get(Config::get('remember/cookieName'));
		$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

		if($hashCheck->count()) {
 			//echo "Hash maches! Log  user in.";
			//echo $hashCheck->first()->user_id;
 			$user = new User($hashCheck->first()->user_id);
 			$user->login();

		}

	}


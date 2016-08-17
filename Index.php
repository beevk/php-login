<?php 
	require_once 'core/Init.php';

	/*$user = DB::getInstance()->update('users', 6, array(
		'password' => 'nohoney',
		'name' => 'Chandra Bdr Gurung'
	));
        echo "Updated successfully";
    */
    if(Session::exists('home')) {
    	echo "<p>" . Session::flash('home') . "</p>";
    }
	
    echo Session::get(Config::get('session/sessionName'));
 ?>

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
	
    //echo Session::get(Config::get('session/sessionName'));

    $user = new User(); //Current user
    //$anotherUser = new User(18); //Another User
    //echo $user->data()->username;

    if($user->isLoggedIn()) {
        //echo "Logged in";
        ?>
        <p> Welcome <a href="Profile.php?user=<?php echo escape($user->data()->username);?>"> <?php echo escape($user->data()->username); ?></a>!</p>
        <ul>
            <li><a href = 'Update.php'> Update Details</a></li>
            <li><a href = 'ChangePassword.php'> Change password </a></li>
            <li><a href = 'Logout.php'> Log out</a></li>
        </ul>
    
    <?php    
        if($user->hasPermission('admin')) {
            echo "You are an Administrator!<br />";
        }
        if($user->hasPermission('moderator')) {
            echo "You are an Moderator!<br />";
        }
    }
    else{
        echo "<p>You need to <a href='Login.php'>Login</a> or <a href='Register.php'>Register</a> </p>";
    }
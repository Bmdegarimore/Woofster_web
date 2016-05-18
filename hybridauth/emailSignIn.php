<?php
	session_start();
	include('../app/userspace/model/dbModel.php');
	include('UserUniqueIdentifier.php');

	//Variable declarations
	$email;
	$password;

	/* Handle if headers are already in existance, just destroy them */
	if($_SESSION['logged_in'] || $_SESSION['user_uid']){
        session_destroy();
	}

	//Get the email from post
	if(isset($_POST['email'])){
		$email = $_POST['email'];
	}

	//Get the password from post
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}

	//Generate the unique identifier to use in selecting the user from the database
	$uniqueIdentifier = new UserUniqueIdentifier($email, 'email');
	$uidstr = $uniqueIdentifier->uniqueId;

	//Query the model to see if the user is in the database, if they're not, add them to it
    $model = new DBModel();

    $model->connect();

    $result = $model->selectEmailUser($uidstr, $password);

	//Check if the account and password matches
	if(count($result) == 1){
		//If yes, then navigate to the app
		$_SESSION['user_name'] = $result['username'];

		/* From the login-with.php. These are some of the fields they pulled
		$_SESSION['user_email'] = $user_profile->email;
        $_SESSION['user_uid'] = $user_profile->identifier;
        $_SESSION['user_name'] = $user_profile->displayName;
        $_SESSION['user_photoURL'] = $user_profile->photoURL;
        */

		//Store the user's uniqueIdentifier 
        $_SESSION['user_uniqueId'] = $uidstr;

		//Navigate forward to the app
		$model->disconnect();
		header("Location: ../app/userspace/");
	}
	//If no, then display the login fields again, and provide a redirect back to the home page
	else {
		//TODO: Add login from this actual page
		//Temporarily navigating back to the home page
		$model->disconnect();
		session_destroy();
		header("Location: ../");
	}
?>
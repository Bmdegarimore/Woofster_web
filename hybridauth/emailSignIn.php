<?php
	session_start();
	include('app/userspace/model/dbModel.php');
	include('hybridauth/UserUniqueIdentifier.php');

	/* Handle if headers are already in existance, just destroy them */
	if($_SESSION['logged_in'] || $_SESSION['user_uniqueId']){
        session_destroy();
	}

	//Get the email from post
	if(isset($_POST['signinEmail'])){
		$signinEmail = $_POST['signinEmail'];
	}

	//Get the password from post
	if(isset($_POST['signinPassword'])){
		$signinPassword = $_POST['signinPassword'];
	}

	//Generate the unique identifier to use in selecting the user from the database
	$uniqueIdentifier = new UserUniqueIdentifier($signinEmail, 'email');
	$uidstr = $uniqueIdentifier->uniqueId;

	//Query the model to see if the user is in the database, if they're not, add them to it
    $model = new DBModel();

    $model->connect();

    //Hard coded temporarily
    $result = $model->selectEmailUser($uidstr, $signinPassword);

	//Check if the account and password matches
	if(count($result) == 1){
		//If yes, then navigate to the app
		$_SESSION['user_name'] = $result[0]['username'];
		$_SESSION['logged_in'] = true;

		//TODO: See if you can just remove this
		$_SESSION['user_uid'] = $uidstr;

		//Store the user's uniqueIdentifier 
        $_SESSION['user_uniqueId'] = $uidstr;

		//Navigate forward to the app
		$model->disconnect();
		header("Location: app/userspace/");
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
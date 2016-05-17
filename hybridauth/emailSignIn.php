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

	//Query the model to see if the user is in the database, if they're not, add them to it
    $model = new DBModel();

    $model->connect();

    $model->selectEmailUser($email, $password);

	//Check if the account exists
		//Check if the password is correct
			//If yes, then navigate to the app
			//If no, then display the login fields again, and provide a redirect back to the home page
?>
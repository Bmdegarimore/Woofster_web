<?php
	session_start();
	//DONT NEED INHERITING FROM SPLASHPAGE
	//include('app/userspace/model/dbModel.php');
	include('hybridauth/UserUniqueIdentifier.php');

	//Set validation flags to false
	$signinEmailValid = false;
	$signinPasswordValid = false;

	/* Handle if headers are already in existance, just destroy them */
	if($_SESSION['logged_in'] || $_SESSION['user_uniqueId']){
        session_destroy();
	}

	//Get the email from post
	if(isset($_POST['signinEmail'])){
		$signinEmail = $_POST['signinEmail'];

		//Sanitize email
		if(strlen($signinEmail) < 50 && filter_var($signinEmail, FILTER_VALIDATE_EMAIL)){
			$signinEmail = filter_var($signinEmail, FILTER_SANITIZE_EMAIL);
			$signinEmailValid = true;
		}
	}

	//Get the password from post
	if(isset($_POST['signinPassword'])){
		$signinPassword = $_POST['signinPassword'];

		//sanitize the signinPassword
		if(strlen($signinPassword) > 5 && strlen($signinPassword) < 17){
			$signinPasswordValid = true;
		}
	}

	if($signinEmailValid && $signinPasswordValid){
		//Generate the unique identifier to use in selecting the user from the database
		$uniqueIdentifier = new UserUniqueIdentifier($signinEmail, 'email');
		$uidstr = $uniqueIdentifier->uniqueId;

		//Query the model to see if the user is in the database, if they're not, add them to it
	    //$model = new DBModel();

	    //$model->connect();

	    //Hard coded temporarily
	    //$result = $DB->selectEmailUser($uidstr, $signinPassword);
	    $result = $DB->validateUserPassword($uidstr,$signinPassword);
		//Check if the account and password matches
		if($result){
			$result = $DB->selectProfileInfo($uidstr);

			//If yes, then navigate to the app
			$_SESSION['user_name'] = $result[0]['firstName'] . ' ' . $result[0]['lastName'];
			$_SESSION['logged_in'] = true;
			$_SESSION['user_uid'] = $uidstr;

			//Store the user's uniqueIdentifier 
			$_SESSION['user_uniqueId'] = $uidstr;

			//Navigate forward to the app
			$DB->disconnect();
			header("Location: app/userspace/");
		}else{
			//session_destroy();
			$_SESSION['error'] = 'Username or password incorrect. Please check your username and password';
			header("Location: ../");
		}
	}else{

	//If no, then display the login fields again, and provide a redirect back to the home page
	$DB->disconnect();
	//session_destroy();
	$_SESSION['error'] = 'Login credentials are invalid. Please check your username and password';
	header("Location: ../");
	}
?>
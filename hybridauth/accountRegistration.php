<?php
	//DONT NEED INHERITING FROM SPLASHPAGE
	//include('app/userspace/model/dbModel.php');
	include('hybridauth/UserUniqueIdentifier.php');

	//initialize the valid flags to false
	$fnameValid = false;
	$lnameValid = false;
	$emailValid = false;
	$passwordValid = false;

	//Get the first name
	if(isset($_POST['fname'])){
		$fname = $_POST['fname'];

		//Sanitize fname
		if(strlen($fname) > 0 && strlen($fname) < 21){
			$fname = filter_var($fname, FILTER_SANITIZE_STRING);
			$fnameValid = true;
		} else{
			$_SESSION['error'] = "First name is not a valid format.";
		}
	}

	//Get the last name
	if(isset($_POST['lname'])){
		$lname = $_POST['lname'];

		//Sanitize lname
		if(strlen($lname) > 0 && strlen($lname) < 21){
			$lname = filter_var($lname, FILTER_SANITIZE_STRING);
			$lnameValid = true;
		} else {
			$_SESSION['error'] = "Last name is not a valid format.";
		}
	}

	//Get the email
	if(isset($_POST['email'])){
		$email = $_POST['email'];

		//Sanitize email
		if(strlen($email) < 50 && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			$emailValid = true;
		}else{
			$_SESSION['error'] = "Email is not a valid format.";
		}
	}

	//Get the password
	if(isset($_POST['password'])){
		$password = $_POST['password'];
		$isLength = false;
		$isLowercase = false;
		$isUppercase = false;
		$isNumeric = false;
		$isSpecialCharacter = false;
		
		$LOWERCASE = '/^(?=.*[a-z])/';
		$UPPERCASE = '/^(?=.*[A-Z])/';
		$NUMERIC = '/^(?=.*\d)/';
		$SPECIAL_CHARACTER = '/^(?=.*[$@$!%*?&])/';
		
		//Validate password
		if(strlen($password) >= 8 && strlen($password) < 17){
			
			$isLength = true;
		}else{
			$isLength = false;
		}
	
		if (preg_match($LOWERCASE, $password)) {
		    $isLowercase = true;
		} else {
		    $isLowercase = false;
		}
		
		if (preg_match($UPPERCASE, $password)) {
		    $isUppercase = true;
		} else {
		    $isUppercase = false;
		}
		
		if (preg_match($NUMERIC, $password)) {
		    $isNumeric = true;
		} else {
		    $isNumeric = false;
		}
		
		if (preg_match($SPECIAL_CHARACTER, $password)) {
		    $SPECIAL_CHARACTER = true;
		} else {
		    $SPECIAL_CHARACTER = false;
		}
		
		if($LOWERCASE && $UPPERCASE && $NUMERIC && $SPECIAL_CHARACTER ){
			$passwordValid = true;
		} else {
			$passwordValid = false;
			$_SESSION['error'] = "Password invalid. Needs 8 to 17 characters including 1 uppercase, 1 lowercase, 1 numeric, 1 special character.";
		}
		
	}

	if($fnameValid && $lnameValid && $emailValid && $passwordValid){
		//TODO: Validate email & Password
		$model = new DBModel();
		$model->connect();

		//Generate UniqueIdentifier
		//Generate the unique identifier to use in selecting the user from the database
		$uniqueIdentifier = new UserUniqueIdentifier($email, 'email');
		$uidstr = $uniqueIdentifier->uniqueId;

		//Check if the account already exists
		$result = $model->selectUser($uidstr);

		if(count($result) == 0){
			// Hash password based on stand hash for php
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			//Insert the user into the users table
			$model->insertEmailUser($email, $hashedPassword, $uidstr);

			//Insert the profile information into the profile info table
			$model->insertProfileInfo($uidstr, $fname, $lname, $email);
			
			$result = $DB->selectUser($uidstr);

			//If yes, then navigate to the app
			$_SESSION['user_name'] = $result[0]['username'];
			$_SESSION['logged_in'] = true;
			$_SESSION['user_uid'] = $uidstr;

			//Store the user's uniqueIdentifier 
			$_SESSION['user_uniqueId'] = $uidstr;

			//Navigate forward to the app
			$model->disconnect();
			unset($model);
			
			header("Location: app/userspace/");

			/* $model->disconnect();
			unset($model);

			//Set header to email sign in after making sure that the email and password post variables are still available
			$_POST['signinEmail'] = $email;
			$_POST['signinPassword'] = $password;
			$_POST['submit'] = 'SIGNIN';
			header('Location: splashPage.php');*/
		}
		else if(count($result) == 1){
			$_SESSION['error']= "That account already exists!";
			header("Location: index.php");
		}
		else {
			$_SESSION['error'] = "There are multiple accounts with this email address, please contact an administrator.";
			header("Location: index.php");
		}
	}else{
		header("Location: index.php");
	}
?>
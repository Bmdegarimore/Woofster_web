<?php
	include('app/userspace/model/dbModel.php');
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
		}
	}

	//Get the last name
	if(isset($_POST['lname'])){
		$lname = $_POST['lname'];

		//Sanitize lname
		if(strlen($lname) > 0 && strlen($lname) < 21){
			$lname = filter_var($lname, FILTER_SANITIZE_STRING);
			$lnameValid = true;
		}
	}

	//Get the email
	if(isset($_POST['email'])){
		$email = $_POST['email'];

		//Sanitize email
		if(strlen($email) < 50 && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);
			$emailValid = true;
		}
	}

	//Get the password
	if(isset($_POST['password'])){
		$password = $_POST['password'];

		//sanitize password
		if(strlen($password) > 5 && strlen($password) < 17){
			$passwordValid = true;
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
		}
		else if(count($result) == 1){
			echo "That account already exists!";
		}
		else {
			echo "There are multiple accounts with this email address, please contact an administrator";
		}

		//Set header to email sign in after making sure that the email and password post variables are still available
		/*$_POST['email'] = $email;
		$_POST['password'] = $password;
		header('Location: emailSignIn.php');*/
	}
?>
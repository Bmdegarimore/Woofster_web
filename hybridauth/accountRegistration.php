<?php
	include('app/userspace/model/dbModel.php');
	include('hybridauth/UserUniqueIdentifier.php');

	//Get the first name
	if(isset($_POST['fname'])){
		$fname = $_POST['fname'];
	}

	//Get the last name
	if(isset($_POST['lname'])){
		$lname = $_POST['lname'];
	}

	//Get the email
	if(isset($_POST['email'])){
		$email = $_POST['email'];
	}

	//Get the password
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}

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
		//Insert the user into the users table
		$model->insertEmailUser($email, $password, $uidstr);

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
?>
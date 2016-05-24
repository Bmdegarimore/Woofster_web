<?php
session_start();
include('app/userspace/model/dbModel.php');
// Create connection to DB for clients and admins
$DB = new DBModel();
$DB->connect();
    if(isset($_POST['submit'])){
        $controller = strtoupper($_POST['submit']);
        switch ($controller) {
            case SIGNIN:
                include("hybridauth/emailSignIn.php");
                break;
            case REGISTER:
                include("hybridauth/accountRegistration.php");
                break;
            case RESET:
                $email = $_POST['signinEmail'];
                if($DB->confirmEmail($email)){
                    // Create a connection to mailman to send email
                    include_once('email/mailman.php');
                    $resetURL = $DB->createToken($email);
                    $mailMan = new Mailman();
                    $mailMan->connect();
                    $mailMan->sendPasswordReset($email,$resetURL);
                    //Insert a message reset was sent....
                    header("Location: index.php");
                    
                }else{
                    $_SESSION['error'] = "Account not found. Please create an account.";
                    header("Location: index.php");
                }
                break;
            default:
                header("Location: index.php");
                break;
        }
    }else{
        header("Location: index.php");
    }
?>
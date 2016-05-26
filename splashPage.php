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
                    $_SESSION['passed']= "A reset request was sent to your email.";
                    header("Location: index.php");
                    
                    
                }else{
                    $_SESSION['error'] = "Account not found. Please create an account.";
                    header("Location: index.php");
                }
                break;
            case CHANGE:
                // Confirm post was sent
                if(isset($_POST['email']) && $_SESSION["validated"] == "true"){
                    // Unset session validator and selector session
                    unset($_SESSION["selector"]);
                    
                    unset($_SESSION["validator"]);
                    //Check to make sure passwords are the same
                    if($_POST['rePassword'] == $_POST['password']){
                        // INSERT VALIDATION FOR EMAIL
                        $email = $_POST['email'];
                        //INSERT VALIDATION FOR PASSWORD
                        $password = $_POST['password'];
                        // Checks email exists and changes password
                        if($DB->confirmEmail($email)){
                            $DB->changePassword($email,$password);
                            $_SESSION['passed']= "Password reset! Please sign in";
                            header("Location: index.php");
                        }
                            
                    }else{
                         //print_r($_POST);
                        $_SESSION['error'] = "Passwords missmatched! Please resubmit request.";
                        header("Location: index.php");
                    }
                }else{
                    $_SESSION['error'] = "Empty email or password field when resetting. Please resubmit.";
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
<?php
session_start();
include('app/userspace/model/dbModel.php');
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
                if($DB->confirmEmail($_POST['signinEmail'])){
                    echo('path to reset');
                    include("loginFPass.php");
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
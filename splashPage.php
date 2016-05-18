<?php
    if(isset($_POST['submit'])){
        $controller = strtoupper($_POST['submit']);
        switch ($controller) {
            case SIGNIN:
                include("hybridauth/emailSignIn.php");
                break;
            case REGISTER:
                include("hybridauth/accountRegistration.php");
                break;
            default:
                header("Location: index.html");
                break;
        }
    }else{
        header("Location: index.html");
    }
?>
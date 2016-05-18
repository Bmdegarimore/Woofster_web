<?php
    if(isset($_POST['submit'])){
        $controller = strtoupper($_POST['submit']);
        switch ($controller) {
            case SIGNIN:
                echo "Check if valid account";
                echo "Redirect";
            break;
            case REGISTER:
                echo "Check if email exists";
                echo "Either return back to login or create account and login";
                break;
            default:
                header("Location:index.html");
                break;
        }
    }else{
        header("Location:index.html");
    }
?>
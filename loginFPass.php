<?php
    session_start();
    
    if(isset($_GET['selector']) && isset($_GET['validator'])){
        $selector = $_GET['selector'];
        // Checks if even number hash only works with even numbers.
        if(strlen($_GET['validator']) % 2 == 0){
            
            $validator = $_GET['validator'];
            include('app/userspace/model/dbModel.php');
            $DB = new DBModel();
            $DB->connect();
            $isValid = $DB->checkToken($selector, $validator);  
        }else{
            $isValid = false;
        }
    }else{
       $isValid = false;
    }
    
    $DB->deleteToken($selector);

    // If valid then showReset.php loads else 
    if($isValid){
        $_SESSION["validated"] = "true";
        $_SESSION["selector"] = $selector;
        $_SESSION["validator"] = $validator;
        include('app/userspace/view/showReset.php');
        
    }else{
        $_SESSION["error"] = "Password reset expired!";
        unset($_SESSION['validated']);
         // Remove the token from the DB regardless of success or failure.
        header("Location:index.php");
    }

?>
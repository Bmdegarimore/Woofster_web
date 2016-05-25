<?php
    session_start();
    // Assumes nothing is valid
    $isValid = false;
    
    // Checks is selector and validator are set.  Also validator when hashed requires an even number. If none of these
    // criterias are met the page reloads index.php. If correct then shows resetpage.
    if(isset($_GET['selector']) && isset($_GET['validator']) && (strlen($_GET['validator']) % 2 == 0)){
        $selector = $_GET['selector'];
        $validator = $_GET['validator'];
        include('app/userspace/model/dbModel.php');
        $DB = new DBModel();
        $DB->connect();
        $isValid = $DB->checkToken($selector, $validator);  
        
        // Deletes token whether the validator matched with Database. Prevents someone from used link more than once.
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
        
    }else{
       unset($_SESSION['validated']);
         // Remove the token from the DB regardless of success or failure.
        header("Location:index.php");
    }
    
    
?>
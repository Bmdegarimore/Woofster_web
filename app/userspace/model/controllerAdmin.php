<?php

session_start();

 
 $user = $_SESSION['username'];

  
//Get action
 if(isset($_GET['update'])){
    $action=$_GET['update']; 
     //$_SESSION['update'] = $action; 
 }
 $action = $_SESSION['update'];

include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/model/adminModel.php');


// Initialize Database
$db = new AdminModel();
$db->connect();
 
//event is currently showing all events
$events = $db->selectAllEvents();

switch($action){
       
    //Save event after edit
   case showUsers:
      //reload display
      $events = $db->selectAllUsers();
        
      // Load show events
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showEmails.php');
      break;
   case events:
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showAllEvents.php');
      break;
   default:
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showAllEvents.php');
      break;
        
}


      
?>
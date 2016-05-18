<?php

session_start();



include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/model/adminModel.php');

$user = $_SESSION['username'];

    
//Get action
if(isset($_GET['action'])){
	$action=$_GET['action']; 
    $_SESSION['action'] = $action; 
}

   

// Initialize Database
$db = new AdminModel();
$db->connect();
 
//event is currently showing all events
$events = $db->selectAllEvents();
include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showAllEvents.php');



      
?>
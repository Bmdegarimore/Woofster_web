<?php

session_start();

//include("model/adminModel.php");

include('../model/adminModel');
//include('/home/woofster/public_html/app/userspace/model/adminModel.php');
$user = $_SESSION['username'];

    
//Get action
/*if(isset($_GET['action'])){
	$action=$_GET['action']; 
    $_SESSION['action'] = $action; 
}
$action = "update";*/
   
//Post used to confirm change in contact
/*if($_POST['update'] == 'update'){
	$action = 'update';
} else if($_POST['update']== 'delete'){
    $action = 'delete';
} else if($_POST['update']== 'add'){
    $action = 'insert';
}
  */
// Initialize Database
$db = new AdminModel();
$db->connect();
 
//Help pass contacts to different switches
$events = $db->selectAllEvents();
require('../view/showAllEvents');
//include('/home/woofster/public_html/app/userspace/view/showAllEvents');



/*switch($action){
       
    //Save event after edit
    case "update":
        $updatedTitle = $_POST['eventTitle'];
        $updatedDate = $_POST['eventDate'];
        $updatedNotes = $_POST['notes'];
        $existingEventID = $_POST['eventID'];
        $userID = $uidstr;
    
        //reload display
        $events = $db->selectAllEvents();
        
        // Load show events
        include_once '../view/showAllEvents.php';
        break;
       


        //reload display
        $events = $db->selectAllEvents($uidstr);
        // Load show events
        include_once '../view/showAllEvents.php';
        break;
       
    //Display list
    default:
        include '../view/showAllEvents.php';
	*/
?>
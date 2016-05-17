<?php

session_start();

include("model/eventModel.php");
//set $uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];

    
//Get action
if(isset($_GET['action'])){
	$action=$_GET['action']; 
    $_SESSION['action'] = $action; 
}
   
//Post used to confirm change in contact
if($_POST['update'] == 'update'){
	$action = 'update';
} else if($_POST['update']== 'delete'){
    $action = 'delete';
} else if($_POST['update']== 'add'){
    $action = 'insert';
}
  
// Initialize Database
$db = new EventModel();
$db->connect();
 
//Help pass contacts to different switches
$events = $db->selectEvents($uidstr);

switch($action){
       
    //Save event after edit
    case "update":
        $updatedTitle = $_POST['eventTitle'];
        $updatedDate = $_POST['eventDate'];
        $updatedNotes = $_POST['notes'];
        $existingEventID = $_POST['eventID'];
        $userID = $uidstr;

         //validate user input
        $validatedTitle = $db->validateTitle($updatedTitle);
        $validatedDate = $db->validateDate($updatedDate);
        $validatedNotes = $db->validateNotes($updatedNotes);
        
        //if files are valid, then save to db
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
          $db->updateEvent($validatedTitle,$validatedDate,$validatedNotes,$existingEventID,$userID);
          //Set a flag to indicate that the event has been added
            $_SESSION['event_flag'] = 'edited';
        }
        else{
            $_SESSION['event_flag'] = 'failed';
        }
    
        //reload display
        $events = $db->selectEvents($userID);
        
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Delete an event
    case "delete":
        $eventIDInfo = $_POST['eventID'];
        $loginIDInfo = $uidstr;
        
        $db->deleteEvent($eventIDInfo,$loginIDInfo);
        
        //set a flag to indicate successful delete
        $_SESSION['event_flag'] = 'deleted';

        //reload display
        $events = $db->selectEvents($uidstr);
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Insert an event
    case "insert":
        //Grab Posts to insert into database
        $newTitle = $_POST['eventTitle'];
        $newDateTime= $_POST['eventDate'];
        $newNotes = $_POST['notes'];
        $existingUser = $uidstr;
        
        //validate user input
        $validatedTitle = $db->validateTitle($newTitle);
        $validatedDate = $db->validateDate($newDateTime);
        $validatedNotes = $db->validateNotes($newNotes);
        //validation funtion returns new validated vars
        //Attempt to insert into database
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
            $db->insertEvent($validatedTitle,$validatedDate,$validatedNotes,$existingUser);
            //Set a flag to indicate that the event has been added
            $_SESSION['event_flag'] = 'added';
        }
        else{
            $_SESSION['event_flag'] = 'failed';
        }


        //reload display
        $events = $db->selectEvents($uidstr);
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Display list
    default:
        include 'view/showEvents.php';
		break;    
}
?>
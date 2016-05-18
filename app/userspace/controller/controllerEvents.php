<?php

session_start();

include("model/eventModel.php");
//set $uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];

$title = $_POST['eventTitle'];
$eventDate = $_POST['eventDate'];

// IF NOTES IS SET FROM EDIT FORM BUT EMPTY NEED TO SET TO NULL
if($_POST['notes'] === " "){
    $_POST['notes'] = null;
}
$note = $_POST['notes'];

$eventID = $_POST['eventID'];
$userID = $uidstr;

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

         //validate user input
        $validatedTitle = $db->validateTitle($title);
        $validatedDate = $db->validateDate($eventDate);
        $validatedNotes = $db->validateNotes($notes);
        
        //if files are valid, then save to db
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
          $db->updateEvent($validatedTitle,$validatedDate,$validatedNotes,$eventID,$userID);
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
        $eventID = $_POST['eventID'];
        $userID = $uidstr;
        
        $db->deleteEvent($eventID,$userID);
        
        //set a flag to indicate successful delete
        $_SESSION['event_flag'] = 'deleted';

        //reload display
        $events = $db->selectEvents($userID);
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Insert an event
    case "insert":
        
        //validate user input
        $validatedTitle = $db->validateTitle($title);
        $validatedDate = $db->validateDate($eventDate);
        $validatedNotes = $db->validateNotes($notes);
        //validation funtion returns new validated vars
        //Attempt to insert into database
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
            $db->insertEvent($validatedTitle,$validatedDate,$validatedNotes,$userID);
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
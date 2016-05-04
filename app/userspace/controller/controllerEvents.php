<?php

session_start();

    include("model/eventModel.php");
    //set $uidstr to equal the session id
    $uidstr = $_SESSION['user_uniqueId'];

   // $_SESSION['action'] = $action;

    
    
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
   
   echo($_POST['update']);

   
   // Initialize Database
   $db = new EventModel();
   $db->connect();
 
   //Help pass contacts to different switches
   $events = $db->selectEvents($uidstr);
   //print_r($events);
   

   switch($action){
       
    //Save event after edit
    case "update":
        $updatedTitle = $_POST['eventTitle'];
        $updatedDate = $_POST['eventDate'];
        $updatedNotes = $_POST['notes'];
        $existingEventID = $_POST['eventID'];
        $userID = $uidstr;

        echo('Title:'.$updatedTitle) . "<br>";
        echo('Date:'.$updatedDate) . "<br>";
        echo('Notes:'.$updatedNotes) . "<br>";
        echo('eventID'.$eventID) . "<br>";
        echo('user'.$userID) . "<br>";

         //validate user input
        $validatedTitle = $db->validateTitle($updatedTitle);
        $validatedDate = $db->validateDate($updatedDate);
        $validatedNotes = $db->validateNotes($updatedNotes);
        
        //if files are valid, then save to db
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
          $db->updateEvent($validatedTitle,$validatedDate,$validatedNotes,$existingEventID,$userID);
        }
        else{
          echo "<p style='color:red;'>" . "we were unable to edit your event." . "</p>";
        }
        //for debugging purposes
        /*echo $validatedTitle . "<br>";
        echo $validatedDate . "<br>";
        echo $validatedNotes . "<br>";*/
        
        
        //Set a flag to indicate that the event has been added
        $_SESSION['event_flag'] = 'edited';

        //reload display
        $events = $db->selectEvents($userID);
        
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Delete an event
    case "delete":
        $eventIDInfo = $_POST['eventID'];
        $loginIDInfo = $uidstr;
        
        echo('Event:'.$eventIDInfo);
        echo('Login:'.$loginIDInfo);
        
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
        
        // Delete once everything is working 
        /*echo('Before validation Title:'.$newTitle.'<br>');
        echo('Before validation Date Time:'.$newDateTime.'<br>');
        echo('Before validation Notes:'.$newNotes.'<br>');
        echo $user_uniqueId;*/

        
        //validate user input
        $validatedTitle = $db->validateTitle($newTitle);
        $validatedDate = $db->validateDate($newDateTime);
        $validatedNotes = $db->validateNotes($newNotes);
        //validation funtion returns new validated vars
        //Attempt to insert into database
        if(($validatedTitle != false) && ($validatedDate != false) && ($validatedNotes != false)){
            $db->insertEvent($validatedTitle,$validatedDate,$validatedNotes,$existingUser);
          }
          else{
            echo "<p style='color:red;'>" . "we were unable to add your event." . "</p>";


          }

          //for debugging purposes
        /*echo "After validate title:" . $validatedTitle . "<br>";
        echo "After validation Date:" . $validatedDate . "<br>";
        echo "After validation notes:" . $validatedNotes . "<br>";*/

       // $db->insertEvent($newTitle,$newDateTime,$newNotes,$existingUser);

        //Set a flag to indicate that the event has been added
        $_SESSION['event_flag'] = 'added';

        //reload display
        $events = $db->selectEvents($uidstr);
        // Load show events
        include_once 'view/showEvents.php';
        break;
       
    //Display list
    default:
        include 'view/showEvents.php';
        
    
   }
?>
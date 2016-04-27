<?php
session_start();
    include("eventModel.php");
    //set $uidstr to equal the session id
    $uidstr = $_SESSION['user_uniqueId'];
    
    
   //Get action
   if(isset($_GET['action'])){
    $action=$_GET['action'];    
   }
   
   //Post used to confirm change in contact
   if($_POST['update']== 'update'){
    $action = 'save';
   } else if($_POST['update']== 'delete'){
    $action = 'save';
   } else if($_POST['update']== 'add'){
    $action = 'insert';
   }
   
   // Initialize Database
   $db = new EventModel();
   $db->connect();
 
   //Help pass contacts to different switches
   $events = $db->selectEvents($uidstr);
   //print_r($events);
   
   switch($action){
    //User edit existing contact
    case "edit":
        if(isset($_GET['id']))
        {
            include 'editEvent.php';
        }else{
            include 'failure.php';
        }
        break;
       
    //Save contact after edit
    case "save":
         //create array to hold content for insertion in db
        $content = array();
        $content['title'] = $_POST['eventTitle'];
        $content['eventDate'] = $_POST['eventDate'];
        $content['notes'] = $_POST['notes'];
        $content['uidstr'] = $uidstr;
        //save to db
        $db->insertEvent($content);
        include 'success.php';
        break;
       
    //Delete a contact
    case "delete":
        if(isset($_GET['id'])){
            include 'deleteEvent.php';
        }else{
            include 'failure.php';
        }
        break;
       
    //Insert a contact
    case "insert":
        //Grab Posts to insert into database
        $newTitle = $_POST['eventTitle'];
        $newDateTime= $_POST['eventDate'];
        $newNotes = $_POST['notes'];
        $existingUser = $uidstr;
        
        //Attempt to insert into database
        $db->insertEvent($newTitle,$newDateTime,$newNotes,$existingUser);
        //reload display
        $events = $db->selectEvents($uidstr);
        include_once 'showEvents.php';
        break;
       
    //Display list
    default:
        include 'showEvents.php';
        
    
   }
?>
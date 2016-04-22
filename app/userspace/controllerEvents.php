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
    $action = 'save';
   }
   
   // Initialize Database
   $db = new EventModel();
   $db->connect();
   
   //$query = "d41d8cd98f00b204e9800998ecf8427e";
   //Help pass contacts to different switches
   $events = $db->select($uidstr);
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
        $content['repeated'] = $_POST['isRepeated'];
        $content['frequency'] = $_POST['repeatFreq'];
        $content['notes'] = $_POST['notes'];
        $content['uidstr'] = $uidstr;
        //save to db
        $db->insert($content);
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
      
    //Add a user
    case "add":
        // TODO: Add to database
        include 'addEvent.php';
        break;
    //Display list
    default:
        include 'showEvents.php';
        
    
   }
?>
<?php
    include("eventModel.php");
    
   //Get action
   if(isset($_GET['action'])){
    $action=$_GET['action'];    
   }
   
   //Post used to confirm change in contact
   if($_POST['update']== 'update'){
    $action = 'save';
   } else if($_POST['update']== 'delete'){
    $action = 'save';
   }
   
   // Initialize Database
   $db = new EventModel();
   $db->connect();
   
   $query = 'd41d8cd98f00b204e9800998ecf8427e';
   //Help pass contacts to different switches
   $events = $db->select($query);
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
        // TODO: write save to database
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
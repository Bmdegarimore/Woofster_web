<?php
    include("../model/eventModel.php");
    
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
        if(isset($_GET['id'])){
            $index = (int)($_GET['id']);
    
            if($index == ($events[$index][eventID])){
                include '../view/editEvent.php';
            }else{
                include '../view/failure.php';
            }
        }else{
            include 'view/failure.php';
        }
        break;
       
    //Save contact after edit
    case "save":
        // TODO: write save to database
        include 'view/success.php';
        break;
       
    //Delete a contact
    case "delete":
        if(isset($_GET['id'])){
            $index = (int)($_GET['id']);
            if($index == ($events[$index][eventID])){
                include '../view/deleteEvent.php';
            }else{
                include '../view/failure.php';
            }
        }else{
            include '../view/failure.php';
        }
        break;
      
    //Add a user
    case "add":
        // TODO: Add to database
        include '../view/addEvent.php';
        break;
    //Display list
    default:
        include '../view/showEvents.php';
        
    
   }
?>
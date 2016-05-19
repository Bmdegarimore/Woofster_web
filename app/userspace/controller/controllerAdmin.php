<?php

session_start();

 
 $user = $_SESSION['username'];

  
//Get action
 if(isset($_GET['update'])){
    $action=$_GET['update']; 
 
 }


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
   
   case download:
      $data = $db->selectAllUsers();
      include_once('download.php');
      break;
   
   case stats:
      //Loads the model for our stats
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/model/chartModel.php');
      $db->disconnect();
      $chartModel = new ChartModel();
      $chartModel->connect();
      $totalEvents = $chartModel->selectEvents(date(m));
      $col[]= ['day','hour','count'];
      $data = '[';
      foreach($totalEvents as $event){
         //$data .="[new Date(".$event['year'].",".$event['month'].",".$event['day']."),".$event['count']."],";
         $data .= "[".$event['day'].",".$event['count']."],";
         //array_push($data, '['.$event['day'].','.$event['hour'].','.$event['count'].']');
      }
      $data .= ']';
      
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showCalendarChart.php');
      break;
   
   default:
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showAllEvents.php');
      break;
        
}


      
?>
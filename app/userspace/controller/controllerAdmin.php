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
   
  
   case stats:
      //Loads the model for our stats
      include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/model/chartModel.php');
      $db->disconnect();
      $chartModel = new ChartModel();
      $chartModel->connect();
      // Counts the total amount events for the month
      $countedEvents = $chartModel->numberOfEvents(date(m));
      // Used to show stats on the bar graph per day
      $totalEvents = $chartModel->selectEvents(date(m));
      // Number of users
      $numberUsers = $chartModel->numberOfUsers(date(m));
      // Calculate Avg Events Per User
      $avgEventsPerUser = round((int)$countedEvents / (int)$numberUsers);
      //Count the amount of social media users
      $numberSocialMediaUsers = $chartModel->numberOfSocialMedia(date(m));
      // Count the amount of email users
      $numberEmailUsers = $chartModel->numberOfEmailUsers(date(m));
      
      $numberOfNotificationsPast = $chartModel->notificationSent(date(m),date(d));
    
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
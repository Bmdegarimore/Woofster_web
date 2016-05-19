<?php
//WE DONT NEED THIS CONTROLLER
session_start();
  /* require('../model/chartModel.php');
    $chartModel = new ChartModel();
    $chartModel->connect();
    $totalEvents = $chartModel->selectEvents(date(m));
    print_r($totalEvents);
    $JSONTotalEvents = $chartModel->convertToJSON($totalEvents);
    print_r($JSONTotalEvents);*/
 
 $user = $_SESSION['username'];

  
//Get action
 if(isset($_GET['update'])){
    $action=$_GET['update']; 
     $_SESSION['update'] = $action; 
 }
 $action = $_SESSION['update'];

include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/model/chartModel.php');


// Initialize Database
$chartModel = new ChartModel();
$chartModel->connect();
 
$totalEvents = $chartModel->selectEvents(date(m));
include($_SERVER['DOCUMENT_ROOT'].'/app/userspace/view/showCalendarChart.php');



       
    


      
?>
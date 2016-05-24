<?php

session_start();
//set uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];
$username = $_SESSION['username'];

//define("ROOT",dirname(__FILE__).'/' );
//require(ROOT . '../app/userspace/model/BaseModel.php');
include('BaseModel.php');


class AdminModel extends BaseModel{

  // Place to store the database connection
  //protected static $connection;

  public function selectAllEvents(){
    
    try{
      // Creates a prepared select statement to select all events
      $statement = $this->connection->prepare("SELECT events.title, events.eventDate, events.notes, users.username FROM events
                                                      INNER JOIN users ON events.unique_loginID = users.unique_loginID ");
      // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
      // References namespace of dog to query
      $statement->execute();

      // Returns selected rows
      $row = $statement->fetchAll();
      return $row;

    } catch(PDOException  $e ){
      print "Error!: " . $e->getMessage() . "<br/>";
      return false;
    }

    return $row;
   


  }

  public function selectAllUsers(){
    
    try{
      // Creates a prepared select statement to select all events
      $statement = $this->connection->prepare("SELECT `username` FROM `users`");
      
      // References namespace of dog to query
      $statement->execute();

      // Returns selected rows
      $row = $statement->fetchAll();

    } catch(PDOException  $e ){
      print "Error!: " . $e->getMessage() . "<br/>";
      return false;
    }

    return $row;


  }
  
}//end of AdminModel


?>




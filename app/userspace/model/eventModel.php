<?php
session_start();
//set uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];
$action = $_SESSION['action'];


class EventModel {

  // Place to store the database connection
  protected static $connection;

  public function connect(){
    try {
      // Retrieves data needed to connect to data base via config.ini
      $config = parse_ini_file('../../../config/config.ini');

      // Attempts to connect to database
      self::$connection = new PDO($config['dbname'], $config['username'], $config['password']);

    } catch (PDOException $e) {
      // Displays error message need to change when in production to clean error message
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
      return false;
    }

    return self::$connection;
  }

  public function disconnect(){
    self::$connection = null;
  }

  public function selectEvents($loginID){
    try{
      // Creates a prepared select statement
      $statement = self::$connection->prepare("select * from events where unique_loginID = :loginID");
      // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
      // References namespace of dog to query
      $statement->bindParam(':loginID', $loginID, PDO::PARAM_STR);
      $statement->execute();

      // Returns selected rows
      $row = $statement->fetchAll();

    } catch(PDOException  $e ){
      print "Error!: " . $e->getMessage() . "<br/>";
      return false;
    }

    return $row;
  }

  // Adds a new event to event table
  public function insertEvent($title,$eventDate,$notes,$unique_loginID){

    try{
      //Insert new events
      $statement = self::$connection->prepare("INSERT INTO events (title,eventDate,notes,unique_loginID)VALUES(:title,:eventDate,:notes,:unique_loginID)");
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $statement->bindParam(':notes',$notes, PDO::PARAM_STR);
        $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);		

      $statement->execute();

      } catch(PDOException  $e ) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return false;
      }	 
     
  }

  /*TODO: look into creating a column titled "Status" w/default of active, when user selects event to delete, then the status will changed to deleted (or colomn deleted as a bool), save on tables maybe*/

  public function deleteEvent($eventID,$loginID) {
    try{
      //Grab the event from events table
      $statement = self::$connection->prepare("SELECT * FROM events WHERE eventID = :eventID and unique_loginID = :loginID");
      $statement->bindParam(':eventID', $eventID, PDO::PARAM_INT);
      $statement->bindParam(':loginID', $loginID, PDO::PARAM_STR);
      $statement->execute();

      $row = $statement->fetchAll();
      
      //Get the event data
      $eventTitle = $row[0]['title'];
      $eventDate = $row[0]['eventDate'];
      $notes = $row[0]['notes'];

      //insert the event into the deleted events table
      $statement2 = self::$connection->prepare("INSERT INTO deletedEvents (title,eventDate,notes,unique_loginID,eventID)VALUES(:title,:eventDate,:notes,:unique_loginID,:eventID)");
      $statement2->bindParam(':title', $eventTitle, PDO::PARAM_STR);
      $statement2->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
      $statement2->bindParam(':notes',$notes, PDO::PARAM_STR);
      $statement2->bindParam(':unique_loginID', $loginID, PDO::PARAM_STR);
      $statement2->bindParam(':eventID', $eventID, PDO::PARAM_INT);
      $statement2->execute();

      // Deletes an event based on eventID and loginID
      $statement3 = self::$connection->prepare("DELETE FROM events WHERE eventID = :eventID and unique_loginID = :loginID");
      $statement3->bindParam(':eventID', $eventID, PDO::PARAM_INT);
      $statement3->bindParam(':loginID', $loginID, PDO::PARAM_STR);
      $statement3->execute();
    } catch(PDOException  $e ) {
      print "Error!: " . $e->getMessage() . "<br/>";
      return false;
    }	  
  }

  public function updateEvent($title,$eventDate,$notes,$eventID,$unique_loginID) {
    try{
      // Update an event based on eventID and loginID
      //$testTitle,$testDate,$testFreq,$testRepeatFreq,$testNotes,$testEventID,$testUnique
      //Insert new events
      $statement = self::$connection->prepare("UPDATE events SET title = :title, eventDate = :eventDate, notes= :notes WHERE eventID = :eventID and unique_loginID = :unique_loginID");
      $statement->bindParam(':title', $title, PDO::PARAM_STR);
      $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
      $statement->bindParam(':notes',$notes, PDO::PARAM_STR);
      $statement->bindParam(':eventID',$eventID, PDO::PARAM_STR);
      $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);	
      $statement->execute();

    } catch(PDOException  $e ) {
      print "Error!: " . $e->getMessage() . "<br/>";
      return false;
    }	  
  }

  
  public function validate($eventTitle, $eventDate, $notes){
  
    $isValid = true;

    //validate title
    if(!empty($eventTitle) && $eventTitle <= 128){
        $eventTitle = trim($eventTitle);
        $eventTitle = stripslashes($eventTitle);
        $eventTitle = htmlspecialchars($eventTitle);
    }
    else{
      $e = "You must enter a title containing no more than 128 characters.";
      $isValid = false;
    }
    //validate date
    if(!empty($eventDate)){
        $eventDate = trim($eventDate);
        $eventDate = stripslashes($eventDate);
        $eventDate = htmlspecialchars($eventDate);
    }
    else{
      $e = "You must enter a date for your event.";
      $isValid = false;
    }
    //validation for notes
    if(strlen($notes) <= 255){
        $notes = trim($notes);
        $notes = stripslashes($notes);
        $notes= htmlspecialchars($notes);
    }
    else{
      $e = "Your notes must be less than 255 charcters.";
      $isValid = false;
    }
    
  
  }


}

?>
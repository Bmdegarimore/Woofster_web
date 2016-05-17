<?php
session_start();
//set uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];
$action = $_SESSION['action'];


require('BaseModel.php');

class EventModel extends BaseModel {

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

  //validate title
  public function validateTitle($eventTitle){

      //if is not empty and less than 128 characters
      if((!empty($eventTitle)) && (strlen($eventTitle) <= 128)){
      
        //then sanitize and fliter input 
        $eventTitle = trim($eventTitle);
        $eventTitle = stripslashes($eventTitle);
        $eventTitle = htmlspecialchars($eventTitle);
        //echo $eventTitle;
         return $eventTitle;
        
       }   
        else{
     
          echo "<p style='color:red;'>" . "Please enter a title less than 128 characters," . "</p>";
          //$_SESSION['event_flag'] = 'Was not able to edit your event' . $e ;
          return false;
        }
       
  }



    //validate date
  public function validateDate($eventDate){

      //if date is set
      if(isset($eventDate)){
      
        //then sanitize and fliter input 
        $eventDate = trim($eventDate);
        $eventDate = stripslashes($eventDate);
        $eventDate = htmlspecialchars($eventDate);
        //echo $eventDate;
        return $eventDate;
        
       }   
        else{

          echo "<p style='color:red;'>" . "Please enter a valid date and time for your event,"  . "</p>";;
          //$_SESSION['event_flag'] = 'Was not able to edit your event';
          return false;
        }
        
  }


 //validate notes
  public function validateNotes($notes){

      //if is not empty and less than 255 characters
      if(isset($notes)){
        
        if(strlen($notes) <= 255){
        //then sanitize and fliter input 
        $notes = trim($notes);
        $notes = stripslashes($notes);
        $notes = htmlspecialchars($notes);
        //echo $notes;
        return $notes;
      }
      else if ($notes = "" || $notes = null){
     
        //echo $notes;
        return $notes;
      }
      else{
      
        echo  "<p style='color:red;'>" . "Please keep your notes under 255 characters."  . "</p>";;
        return false;
        } 
        
      }    
  }







  /*public function validate($eventTitle){//, $eventDate, $notes){

     $isValid = false;

    //validate title
    if(!empty($eventTitle)){ //&& strlen($eventTitle) <= 1){

        echo sizeof($eventTitle);
        $eventTitle = trim($eventTitle);
        $eventTitle = stripslashes($eventTitle);
        $eventTitle = htmlspecialchars($eventTitle);
        $this->eventTitle = $eventTitle;
        $isValid = true;

        
    }
    else{
      $e = "You must enter a title containing no more than 128 characters.";
      
    }

    //validate date
    if(!empty($eventDate)){

        $eventDate = trim($eventDate);
        $eventDate = stripslashes($eventDate);
        $eventDate = htmlspecialchars($eventDate);
        $isValid = true;
        
    }
    else{
      $e = "You must enter a date for your event.";

    }

    //validation for notes
    if(strlen($notes) <= 255){

        $notes = trim($notes);
        $notes = stripslashes($notes);
        $notes= htmlspecialchars($notes);
        $isValid = true;
        
    }
    else{
      $e = "Your notes must be less than 255 charcters.";
     
    }
    
    if($isValid = true){

      $_SESSION['eventTitle'] = $eventTitle;
      $_SESSION['eventDate'] = $eventDate;
      $_SESSION['notes'] = $notes;

        if($action == "insert"){
           echo "Your event has been created and added to the database.";
        }
        else if($action == "update"){
          echo "Your event has been updated.";
        }
      }//end of isValid = true
      else if ($isValid = false){

        echo $e;
      }
  
  }//end of validate function*/




}//end of eventModel

?>
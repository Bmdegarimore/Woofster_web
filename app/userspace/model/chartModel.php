<?php
include_once('BaseModel.php');

class ChartModel extends BaseModel {
    
    public function selectEvents($currentMonth){
        try{
            // Creates a prepared select statement
            //$statement = $this->connection->prepare("SELECT DAY(eventDate) AS day, COUNT(*) AS count FROM events WHERE MONTH(eventDate) = :month GROUP BY DAY(eventDate)");
            $statement = $this->connection->prepare("SELECT YEAR(eventDate)AS year, MONTH(eventDate) AS month, DAY(eventDate) AS day, COUNT(*) AS count FROM events WHERE MONTH(eventDate) = :month GROUP BY DAY(eventDate)");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return $row;
    }
  
  public function convertToJSON($array){
    return json_encode($array);
  }
  
    public function numberOfEvents($currentMonth){
        try{
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT * FROM events WHERE MONTH(eventDate) = :month");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return count($row);
    }
    
    public function numberOfUsers($currentMonth){
        try{
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT unique_loginID FROM events WHERE MONTH(eventDate) = :month GROUP BY unique_loginID");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return count($row);
    }
    
    public function numberOfSocialMedia($currentMonth){
        try{
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT users.unique_loginID FROM events, users WHERE users.socialNetwork = 'Google' OR users.socialNetwork ='Facebook' and MONTH(eventDate) = :month GROUP BY users.unique_loginID");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return count($row);
    }
    
    public function numberOfEmailUsers($currentMonth){
        try{
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT users.unique_loginID FROM events, users WHERE users.socialNetwork = 'Email' and MONTH(eventDate) = :month GROUP BY users.unique_loginID");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return count($row);
    }
    
       public function notificationSent($currentMonth,$currentDay){
        try{
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT * FROM events WHERE MONTH(eventDate) = :month and DAY(eventDate) < :day");
            // References namespace of dog to query
            $statement->bindParam(':month', $currentMonth, PDO::PARAM_INT);
            $statement->bindParam(':day', $currentDay, PDO::PARAM_INT);
            $statement->execute();
    
            // Returns selected rows
            $row = $statement->fetchAll();
    
        } catch(PDOException  $e ){
          print "Error!: " . $e->getMessage() . "<br/>";
          return false;
        }
    
        return count($row);
    }
    
    

}
?>
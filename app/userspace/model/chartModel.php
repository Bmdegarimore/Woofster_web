<?php
require('BaseModel.php');

class ChartModel extends BaseModel {
    
    public function selectEvents($currentMonth){
    try{
      // Creates a prepared select statement
      $statement = $this->connection->prepare("SELECT DAY(eventDate) AS day, HOUR(eventDate) AS hour, COUNT(*) AS count FROM events WHERE MONTH(eventDate) = :month GROUP BY DAY(eventDate),HOUR(eventDate)");
      // $statement = $this->connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
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

}
?>
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

}
?>
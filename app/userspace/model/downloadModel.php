<?php

class DownloadModel{

  protected $db;

  public function __construct(PDO $db){
    $this->db = $db;
  }


  
  public function selectAllUsers(){

      // Creates a prepared select statement to select all events
      $statement = $this->db->prepare("SELECT `username` FROM `users`");
      
      // References namespace of dog to query
      $statement->execute();

      // Returns selected rows
      return $statement;
  }//end of DownloadModel
}
?>
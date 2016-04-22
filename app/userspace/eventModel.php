<?php
session_start();
//set uidstr to equal the session id
$uidstr = $_SESSION['user_uniqueId'];


    class EventModel{
        
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
        
        public function select($query){
            try{
                // Creates a prepared select statement
		//$statement = self::$connection->prepare("SELECT eventDate,notes,repeated,repeatFrequency,title,dogs.name,eventID, events.unique_loginID FROM events,dogs WHERE events.dogID=dogs.dogID and events.unique_loginID=:user order by dogs.name");
		$statement = self::$connection->prepare("SELECT eventDate,notes,repeated,repeatFrequency,title,dogs.name,eventID, events.unique_loginID FROM events,dogs WHERE events.unique_loginID=:user and dogs.unique_loginID=:user order by dogs.name");
	       // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
                // References namespace of dog to query
		$statement->bindParam(':user', $query, PDO::PARAM_STR);
                $statement->execute();
                // Returns selected rows
		
                $row = $statement->fetchAll();
		
            }catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br/>";
                return false;
            }
    
            return $row;
        }
        
        public function insert($content){
        //Insert new events
            $statement = self::$connection->prepare("INSERT INTO events (eventDate,notes,repeated,repeatFrequency,title, unique_loginID)VALUES (:eventDate, :notes, :repeated, :repeatFrequency, :title, :uidstr )");
            $statement->bindParam(':eventDate', $content['eventDate'], PDO::PARAM_STR);
            $statement->bindParam(':notes', $content['notes'], PDO::PARAM_STR);
            $statement->bindParam(':repeated', $content['repeated'], PDO::PARAM_STR);
            $statement->bindParam(':repeatFrequency', $content['frequency'], PDO::PARAM_STR);
            $statement->bindParam(':title', $content['title'], PDO::PARAM_STR);
            $statement->bindParam(':uidstr', $content['uidstr'], PDO::PARAM_STR);

            $statement->execute();
        }
        
        
        public function delete(){
           //Delete events 
        }
        
        public function update(){
           //Alter existing events
	   try{
		
                // Creates a prepared select statement
		$statement = self::$connection->prepare("SELECT eventDate,notes,repeated,repeatFrequency,title,name,dogs.eventID FROM events,dogs WHERE events.eventID=dogs.eventID and events.unique_loginID=:user order by dogs.name");
                // References namespace of dog to query
		$statement->bindParam(':title', $title, PDO::PARAM_STR);
		$statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
		$statement->bindParam(':repeated', $repeated, PDO::PARAM_STR);
		$statement->bindParam(':repeatFrequency', $repeatFrequency, PDO::PARAM_STR);
		$statement->bindParam(':notes', $notes, PDO::PARAM_STR);
                $statement->execute();
		
            }catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br/>";
                return false;
            }
	   
        }
        
        
    }

?>
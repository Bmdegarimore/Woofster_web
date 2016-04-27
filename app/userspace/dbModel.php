<?php
     class DBModel{
        
        // Place to store the database connection
        protected static $connection;
        
        public function connect(){
            try {
                // Retrieves data needed to connect to data base via config.ini
                //$config = parse_ini_file('../../config/config.ini');
                // Retrieves data needed to connect to data base via config.ini
                $config = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/capstone/config.ini');
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
        
	// Select events based on unique_loginID
        public function selectEvents($query){
            try{
		
                // Creates a prepared select statement
                $statement = self::$connection->prepare("select * from events where unique_loginID = :query");
                // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
                // References namespace of dog to query
                $statement->bindParam(':query', $query, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();

            } catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br/>";
                return false;
            }

            return $row;
        }
	  /*
        public function selectUser($uid) {
            try{
        
                // Creates a prepared select statement
                // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
                $statement = self::$connection->prepare("SELECT * FROM users WHERE unique_loginID = :uid");

                // References namespace of dog to query
                $statement->bindParam(':uid', $uid, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();

            } catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br>";
                return false;
            }

            return $row;
        }

        public function selectDog($uid){
            try{
        
                // Creates a prepared select statement
                // $statement = self::$connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
                $statement = self::$connection->prepare("SELECT * FROM dogs WHERE unique_loginID = :uid");

                // References namespace of dog to query
                $statement->bindParam(':uid', $uid, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();

            } catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br>";
                return false;
            }

            return $row;
        }
        */
        // Adds a new event to event table
        public function insertEvent($title,$eventDate,$repeated,$repeatFrequency,$notes,$unique_loginID,$dogID){
            try{
	       //Insert new events
	       $statement = self::$connection->prepare("INSERT INTO events (title,eventDate,repeated,repeatFrequency,notes,unique_loginID)VALUES(:title,:eventDate,:repeated,:repeatFrequency,:notes,:unique_loginID)");
	       $statement->bindParam(':title', $title, PDO::PARAM_STR);
	       $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
	       $statement->bindParam(':repeated', $repeated, PDO::PARAM_STR);
	       $statement->bindParam(':repeatFrequency', $repeatFrequency, PDO::PARAM_STR);
	       $statement->bindParam(':notes',$notes, PDO::PARAM_STR);
	       $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);		
	       
	       $statement->execute();
	    } catch(PDOException  $e )
	  {
               print "Error!: " . $e->getMessage() . "<br/>";
               return false;
          }	  
        }
	/* Disabled since not using yet for MVP  
        public function insertUser($username, $provider, $uid){
            //Insert the user
            $statement = self::$connection->prepare("INSERT INTO users (username, socialNetwork, unique_loginID)
                VALUES (:username, :socialnetwork, :unique_loginID)");
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->bindParam(':socialnetwork', $provider, PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $uid, PDO::PARAM_STR);

            $statement->execute();
        }

        public function insertDog($name, $uid){
            //Insert the dog
            $statement = self::$connection->prepare("INSERT INTO dogs (name, birthdate, unique_loginID)
                VALUES (:name, :birthdate, :unique_loginID)");
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':birthdate', date("Y-m-d"), PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $uid, PDO::PARAM_STR);

            $statement->execute();
        }
        */
	public function deleteEvent($eventID,$loginID)
	{
	  try{
	       // Deletes an event based on eventID and loginID
               $statement = self::$connection->prepare("DELETE FROM `events` WHERE eventID = :eventID and unique_loginID = :loginID");
               $statement->bindParam(':eventID', $eventID, PDO::PARAM_INT);
	       $statement->bindParam(':loginID', $loginID, PDO::PARAM_STR);
               $statement->execute();

	  } catch(PDOException  $e )
	  {
               print "Error!: " . $e->getMessage() . "<br/>";
               return false;
          }	  
	}
	
	public function updateEvent($title,$eventDate,$repeated,$repeatFrequency,$notes,$eventID,$unique_loginID)
	{
	  try{
	       // Update an event based on eventID and loginID
	       //$testTitle,$testDate,$testFreq,$testRepeatFreq,$testNotes,$testEventID,$testUnique
              //Insert new events
	       $statement = self::$connection->prepare("UPDATE events SET title = :title, eventDate = :eventDate, repeated = :repeated, repeatFrequency= :repeatFrequency, notes= :notes WHERE eventID = :eventID and unique_loginID = :unique_loginID");
	       $statement->bindParam(':title', $title, PDO::PARAM_STR);
	       $statement->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
	       $statement->bindParam(':repeated', $repeated, PDO::PARAM_STR);
	       $statement->bindParam(':repeatFrequency', $repeatFrequency, PDO::PARAM_STR);
	       $statement->bindParam(':notes',$notes, PDO::PARAM_STR);
	       $statement->bindParam(':eventID',$eventID, PDO::PARAM_STR);
	       $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);	
               $statement->execute();

	  } catch(PDOException  $e )
	  {
               print "Error!: " . $e->getMessage() . "<br/>";
               return false;
          }	  
	}
    }

?>
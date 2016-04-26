<?php
     class DBModel{
        
        // Place to store the database connection
        protected static $connection;
        
        public function connect(){
            try {
                // Retrieves data needed to connect to data base via config.ini
                $config = parse_ini_file('../../config/config.ini');
                
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
                $statement = self::$connection->prepare("select :query");
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

        public function selectUser($uid) {
            try{
        
                // Creates a prepared select statement
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
        
        public function insert($table,$fields,$values){
            //Insert new events
            $statement = self::$connection->prepare("INSERT INTO :table (:fields)VALUES(:values)");
            $statement->bindParam(':table', $table, PDO::PARAM_STR);
            $statement->bindParam(':fields', $fields, PDO::PARAM_STR);
            $statement->bindParam(':values', $values, PDO::PARAM_STR);

            $statement->execute();
        }

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
    }

?>
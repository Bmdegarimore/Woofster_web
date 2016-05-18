<?php
     require('BaseModel.php');
     
     class DBModel extends BaseModel{
        
        public function select($query){
            try{
		
                // Creates a prepared select statement
                $statement = $this->connection->prepare("select :query");
                // $statement = $this->connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
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
                $statement = $this->connection->prepare("SELECT * FROM users WHERE unique_loginID = :uid");

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

        public function selectEmailUser($email, $password){
            try{
                // Creates a prepared select statement
                $statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username and password = :password");

                // References namespace of dog to query
                $statement->bindParam(':username', $email, PDO::PARAM_STR);
                $statement->bindParam(':password', $password, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();
            } catch(PDOException $e){
                print "Error! " . $e->getMessage() . "<br>";
                return false;
            }

            return $row;
        }

        public function selectDog($uid){
            try{
        
                // Creates a prepared select statement
                // $statement = $this->connection->prepare("SELECT * FROM Dogs INNER JOIN Events ON Dogs.dogID = Events.dogID WHERE Dogs.unique_loginID =d41d8cd98f00b204e9800998ecf8427e order by dogs.name");
                $statement = $this->connection->prepare("SELECT * FROM dogs WHERE unique_loginID = :uid");

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
            $statement = $this->connection->prepare("INSERT INTO :table (:fields)VALUES(:values)");
            $statement->bindParam(':table', $table, PDO::PARAM_STR);
            $statement->bindParam(':fields', $fields, PDO::PARAM_STR);
            $statement->bindParam(':values', $values, PDO::PARAM_STR);

            $statement->execute();
        }

        public function insertUser($username, $provider, $uid){
            //Insert the user
            $statement = $this->connection->prepare("INSERT INTO users (username, socialNetwork, unique_loginID)
                VALUES (:username, :socialnetwork, :unique_loginID)");
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->bindParam(':socialnetwork', $provider, PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $uid, PDO::PARAM_STR);

            $statement->execute();
        }

        public function insertEmailUser($username, $password, $uid){
            //Insert the user
            $statement = $this->connection->prepare("INSERT INTO users (username, socialNetwork, unique_loginID, password)
                VALUES (:username, 'email', :unique_loginID, :password)");
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->bindParam(':password', $password, PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $uid, PDO::PARAM_STR);

            $statement->execute();
        }

        public function insertProfileInfo($unique_loginID, $fname, $lname, $email){
            //Insert the user
            $statement = $this->connection->prepare("INSERT INTO profileInfo (firstName, lastName, unique_loginID, email)
                VALUES (:firstName, :lastName, :unique_loginID, :email)");
            $statement->bindParam(':firstName', $fname, PDO::PARAM_STR);
            $statement->bindParam(':lastName', $lname, PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);

            $statement->execute();
        }

        public function insertDog($name, $uid){
            //Insert the dog
            $statement = $this->connection->prepare("INSERT INTO dogs (name, birthdate, unique_loginID)
                VALUES (:name, :birthdate, :unique_loginID)");
            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':birthdate', date("Y-m-d"), PDO::PARAM_STR);
            $statement->bindParam(':unique_loginID', $uid, PDO::PARAM_STR);

            $statement->execute();
        }
	/**
	 * Checks to validate account exists
	 **/
	public function validatePassword($username,$password){
	  try{
	       
                // Creates a prepared select statement
                $statement = $this->connection->prepare("SELECT password FROM admins WHERE username = :username LIMIT 1");
                // References namespace of dog to query
                $statement->bindParam(':username', $username, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();
		
		if(password_verify($password, $row[0]['password'])){
		    return true;
		}else{
		    return false;
		}

            } catch(PDOException  $e ){
                print "Error!: " . $e->getMessage() . "<br>";
                return false;
            }

            
	}
    }

?>
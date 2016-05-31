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

        public function selectEmailUser($uid, $password){
            try{
                // Creates a prepared select statement
                $statement = $this->connection->prepare("SELECT * FROM users WHERE unique_loginID = :uid and password = :password");

                // References namespace of dog to query
                $statement->bindParam(':uid', $uid, PDO::PARAM_STR);
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
	
	
	/**
	 * Checks email to verify it exists.  Returns true or false. Used to in part to reset customer's password
	 **/
	public function confirmEmail($userEmail){
	  try{
	       $statement = $this->connection->prepare("SELECT * FROM `users` WHERE username = :userEmail and socialNetwork = 'email'");
	       // References namespace of email
                $statement->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
                $statement->execute();

                // Returns selected rows
                $row = $statement->fetchAll();
		
            } catch(PDOException $e){
                print "Error! " . $e->getMessage() . "<br>";
                return false;
            }
	    
	  if(count($row) >= 1){
	       return true;
	  } else {
	       return false;
	  }


	}
	
	/**
	 * Changes the password for user account once they validate content. Used with change case in splashPage.php
	 **/
	public function changePassword($email,$password){
	  try{
	       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	       $email .= "_email";
     
	       // Creates a prepared select statement
	       $statement = $this->connection->prepare("UPDATE users SET password = :password WHERE unique_loginID = :unique_loginID");
     
	       // References namespace of dog to query
	       $statement->bindParam(':password',$hashedPassword , PDO::PARAM_STR);
	       $statement->bindParam(':unique_loginID', $email, PDO::PARAM_STR);
	       $statement->execute();
     
	       // Returns selected rows
	       $row = $statement->fetchAll();
	  }catch(PDOException $e){
	       print "Error! " . $e->getMessage() . "<br>";
	       return false;
	  }
	}
	
	  /**
	   * Private method used with create token to find the unique_login_ID that needs to be reset.
	   **/
	  private function findUID($userEmail, $socialMediaType){
	       try{
		     // Creates a prepared select statement
		     $statement = $this->connection->prepare("SELECT unique_loginID AS userid FROM users WHERE username = :userEmail and socialNetwork = :socialMedia");
     
		     // References namespace of dog to query
		     $statement->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
		     $statement->bindParam(':socialMedia', $socialMediaType, PDO::PARAM_STR);
		     $statement->execute();
     
		     // Returns selected rows
		     $row = $statement->fetchAll();
		 } catch(PDOException $e){
		     print "Error! " . $e->getMessage() . "<br>";
		     return false;
		 }
	       if(!empty($row)){
		 return $row[0]['userid']; 
	       }
		 return false;
	  }
	  
	/**
	 * Generates a token the user needs to reset password. This is done to make it more secure.
	 **/
	public function createToken($userEmail){
	  $uid = $this->findUID($userEmail,'email');
	  
	  $selector = bin2hex(random_bytes(8));
	  $token = random_bytes(32);
	  
	  
	  $expires = new DateTime('NOW');
	  $expires->add(new DateInterval('PT24H')); // 24hour
     
	  $statement = $this->connection->prepare("INSERT INTO passwordRecovery (unique_login, selector, token, expires) VALUES (:userid, :selector, :token, :expires);");
	  $statement->bindParam(':userid',$uid, PDO::PARAM_STR);
	  $statement->bindParam(':selector',$selector, PDO::PARAM_STR);
	  $statement->bindParam(':token',hash('sha256', $token),PDO::PARAM_STR);
	  $statement->bindParam(':expires', $expires->format('Y-m-d H:i:s'), PDO::PARAM_STR);
	
          $statement->execute();
	  
	  
	  return $urlToEmail = 'http://woofster.greenrivertech.net/loginFPass.php?'.http_build_query([
	      'selector' => $selector,
	      'validator' => bin2hex($token)
	  ]);
	}
	/**
	 * Selects the selector from email reset and compares the expiration date.  If expired then token is deleted, but
	 * if valid the method forwards the user to another page to change passwords.  The token is then deleted.
	 **/
	public function checkToken($selector, $validator){
	  $statement = $this->connection->prepare("SELECT * FROM passwordRecovery WHERE selector = :selector AND expires >= NOW()");
	  $statement->bindParam(':selector',$selector, PDO::PARAM_STR);
	  $statement->execute();
	  
	  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
	  //print_r($results);
	  if (!empty($results)) {
	      $calc = hash('sha256', hex2bin($validator));
	  
	      if (hash_equals($calc, $results[0]['token'])) {
		  // The reset token is valid. Authenticate the user.
		  return true;
	      } else{
	       return false;
	      }
	  }
	}
	
	public function deleteToken($selector){
	  $statement = $this->connection->prepare("DELETE FROM passwordRecovery WHERE selector = :selector");
	  $statement->bindParam(':selector',$selector, PDO::PARAM_STR);
	  $statement->execute();
	  
	  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
     
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
    		} else {
    		    return false;
    		}
        } catch(PDOException  $e ){
            print "Error!: " . $e->getMessage() . "<br>";
            return false;
        }

            
	}

    /**
     * Checks to validate account exists
     **/
    public function validateUserPassword($unique_loginID,$password){
        try{
           
            // Creates a prepared select statement
            $statement = $this->connection->prepare("SELECT password FROM users WHERE unique_loginID = :unique_loginID LIMIT 1");
            // References namespace of dog to query
            $statement->bindParam(':unique_loginID', $unique_loginID, PDO::PARAM_STR);
            $statement->execute();

            // Returns selected rows
            $row = $statement->fetchAll();
	    $hash = $row[0]['password'];
	    
	    
	 
            if(password_verify($password, $row[0]['password'])){
		return true;
            } else {
                return false;
            }
        } catch(PDOException  $e ){
            print "Error!: " . $e->getMessage() . "<br>";
            return false;
        }

            
    }
}

?>
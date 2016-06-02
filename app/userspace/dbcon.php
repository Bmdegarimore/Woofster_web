<?php

      function connect(){

         try {
            // Retrieves data needed to connect to data base via config.ini
            $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/../config/config.ini');
      
            // Attempts to connect to database
            $connection = new PDO($config['dbname'], $config['username'], $config['password']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
      
          } catch (PDOException $e) {
            // Displays error message need to change when in production to clean error message
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
            return false;
          }
      
         return $connection;
        }    
?>
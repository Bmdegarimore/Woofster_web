<?php
    Class Mailman{
        
        // Place to store the database connection
        protected static $mailman;
        // Stores the batched emails to send
        private $dailyMail = 'mail.log';
        
         public function connect(){
            echo "We have connected" . " <br>";
            try {
                // Retrieves data needed to connect to data base via config.ini
                $config = parse_ini_file('../../config/config.ini');

                // Attempts to connect to database
                self::$mailman = new PDO($config['dbname'], $config['username'], $config['password']);
              
                } catch (PDOException $e) {
                    // Displays error message need to change when in production to clean error message
                    print "Error!: " . $e->getMessage() . "<br/>";
                    die();
                    return false;
                }
                
		return self::$mailman;
        
        }
        
        // Disconnects from database
        public function disconnect(){
            echo "We have disconnected" . " <br>";

            self::$connection = null;
        }
        
        // Select emails to send from DB and return emails to send
        private function selectDailyEvents(){
            echo "We have called the selectDailyEvents functions" . " <br>";
            try{
                //Grabs todays date and pulls a range of notifications
                $currentDate = new DateTime(); //current date/time
                $currentDate->sub(new DateInterval("PT2H"));
                //$beginTimePST = $currentDate->format('Y-m-d H:00');
                $beginTimePST = $currentDate->format('Y-m-d H:i:00');
                
                //$currentDate->add(new DateInterval("PT1H59I"));
                // Check 15 mins out from current time
                $currentDate->modify('+15 minutes');
                $endTimePST = $currentDate->format('Y-m-d H:i:00');
                echo($endTimePST."end and begin".$beginTimePST);
                
                // Creates a prepared select statement
                $statement = self::$mailman->prepare("SELECT eventDate, title, notes, users.username FROM events, users WHERE users.unique_loginID = events.unique_loginID and events.eventDate BETWEEN :startDate AND :stopDate ORDER BY eventDate ASC");
                
                $statement->bindParam(':startDate', $beginTimePST, PDO::PARAM_STR);
                $statement->bindParam(':stopDate', $endTimePST, PDO::PARAM_STR);
                $statement->execute();
          
                // Returns selected rows
                $row = $statement->fetchAll();
                print_r($row);
          
            } catch(PDOException  $e ){
              print "Error!: " . $e->getMessage() . "<br/>";
              return false;
            }
            return $row;
        }
        
        // Takes DB queries and sends out emails to customer
        public function checkTheMail(){
            echo "We have called the checkTheMail" . " <br>";
            // Select all the daily notifications
            $notifications = $this->selectDailyEvents();
         
            foreach($notifications as $individualEvents){
                echo("Title:".$individualEvents['title']);
                echo("Note:".$individualEvents['notes']);
                echo("Date:".$individualEvents['eventDate']);
                echo("Email:".$individualEvents['username']."\n");
                $message = "<p><b>Title:</b> ".$individualEvents['title']." Event</p><p>Date and Time".$individualEvents['eventDate']."</p><p><b>Notes for Event:</b> ".$individualEvents['notes']."</p>";
                $this->sendEmail($individualEvents['username'], $message);
                
            }
        }
        
        // Method that calls email
        private function sendEmail($to, $body , $subject = "Event Reminder"){
            echo "We have called the sendEmail functions";
            //Email to applicant     
            require_once('swift_required.php');
             
            $email_address = "";
            //Create the Transport
            $transport = Swift_MailTransport::newInstance();
                  
            //Create the Mailer using your created Transport
            $mailer = Swift_Mailer::newInstance($transport);
            // Create the message
            $message = Swift_Message::newInstance();
            $message->setTo(array(
              "$to" => "$to"
            ));
    
            $message->setSubject($subject);
            $message->setBody('<html>' .
                                    '<head></head>' .
                                    '<body style=\"background-color: #0099e6; \">' .
                                    $body.
                                    '<br>'.
                                    '<p style=\"font-color: #73879;\"></p>'.
                                    '<h5 style=\"font-color: #73879;\>Thanks,</h5><br>'.
                                    '<h5 style=\"font-color: #73879;\><i class="fa fa-paw"></i>Woofster Team</h5>'.
                                    '<h5 style=\"font-color: #73879;\></h5>'.
                                    '<p> style=\"font-color: #73879;\</p>'.
                                    '</body>' .
                                    '</html>',
                                      'text/html' // Mark the content-type as HTML
              );
            $message->setFrom("DoNotReply@Woofster.com", "WoofsterMailer");
             
            // Send the email
            $mailer = Swift_Mailer::newInstance($transport);
            $mailer->send($message);
    
            //END OF EMAIL
        }
        
        
    }
?>
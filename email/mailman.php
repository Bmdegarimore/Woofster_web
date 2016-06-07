<?php
    Class Mailman{
        
        // Place to store the database connection
        protected static $mailman;
        // Stores the batched emails to send
        private $dailyMail = 'mail.log';
        
         public function connect(){
            
            try {
                // Retrieves data needed to connect to data base via config.ini
                $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/../config/config.ini');

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
                echo("Notes:".$individualEvents['notes']);
                echo("Date:".$individualEvents['eventDate']);
                echo("Email:".$individualEvents['username']."\n");
                $message = '<p style="font-size: 16pt;">'. '<b>Title:</b>'.$individualEvents['title'].' Event</p>'. '<p style="font-style: italic; font-size: 10pt;">(Tip: Hover over time below to add to your calendar)</p>'. '<p><b>Date and Time</b>'. 
                $individualEvents['eventDate'].'</p><p><b>Notes for Event:</b> '.$individualEvents['notes'].'</p>';
                $this->sendEmail($individualEvents['username'], $message);

               /* $message = "<p><b>Title:</b> ".$individualEvents['title']." Event</p><p>Date and Time".$individualEvents['eventDate']."</p><p><b>Notes for Event:</b> ".$individualEvents['notes']."</p>";
                $this->sendEmail($individualEvents['username'], $message);*/
                
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
            $message->setBody('<html>'.
                                '<head>'.
                                    '<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">'.
                                    '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">'.
                                '</head>'.
                                
                                '<body style="background-color:#00a8ff;  font-family: Helvetica Neue, Roboto, Arial, Droid Sans, sans-serif;">'.
                                    '<div class="container" style="background-color:#00a8ff; border-style:solid;">'.
                                        '<div class = "row" style="background-color:#bdc3c7;">'.
                                            '<div class="col-lg-12" style="display:inline;">'.
                                                '<h1 style = "color: #5B6479;">Woofster Event Reminder</h1>'.
                                            '</div>'.
                                            '<br>'.
                                        '</div>'.
                                        '<div class="row" style="background-color:#fff;">'.
                                            '<div class="col-lg-12">'.
                                                $body.
                                            '</div>'.
                                        '</div>'.
                                        '<div class="row" style="padding-bottom: 2px; background-color:#bdc3c7;">'.
                                            '<h5 style="margin-left: 1em; font-size:14pt;">Thanks,</h5>'.
                                            '<span style="margin-left: 1em;"><img style="width:2.5em; height: 2.5em; display: inline" class="img-responsive"src="http://woofster.greenrivertech.net/img/paw.png" alt="image of a paw"> Woofster Team</span>'.
                                        '</div>'.
                                    '</div>'.
                                '</body>'.
                            '</html>',
                                      'text/html' // Mark the content-type as HTM

              );
            $message->setFrom("DoNotReply@Woofster.com", "WoofsterMailer");
             
            // Send the email
            $mailer = Swift_Mailer::newInstance($transport);
            $mailer->send($message);
    
            //END OF EMAIL
        }
        /**
         * Sends an email with a reset password link to email address
         **/
        public function sendPasswordReset($to, $url, $subject = "Reset Request"){
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
                                    '<head>'.'<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">'.'</head>' .
                                    '<head>'.'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">'.'</head>' .
                                    '<body>' .
                                        '<div class="container">'.
                                            '<div class="row">'.
                                                '<div class="col-sm-12">'.
                                                    '<h1>Howdy from Woofster!</h1>'.
                                                    '<br>'.
                                                    '<div style="margin-left: 2%;">'.
                                                        '<p>Click below to fetch your new password:</p>'.
                                                        '<p><a href="'.$url.'"><button class="btn btn-primary">Reset password</button></a></p>'.
                                                        '<p><i>Note: Link will expires in 24 hours</i></p>'.
                                                    '</div>'.
                                                    '<h5 style="font-size:14pt;display:inline;">' . 'Thanks,' . '</h5>'.
                                                    '<span><img style="width:2.5em; height: 2.5em; display: inline" class="img-responsive"src="http://woofster.greenrivertech.net/img/paw.png" alt="image of a paw"> Woofster Team</span>'.   
                                                '</div>'.
                                            '</div>'.
                                        '</div>'.
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
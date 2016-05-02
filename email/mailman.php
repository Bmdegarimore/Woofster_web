<?php
    Class Mailman{
        // Place to store the database connection
        protected static $mailman;
        // Stores the batched emails to send
        private $dailyMail = 'mail.log';
        
         public function connect(){
            try {
                // Retrieves data needed to connect to data base via config.ini
                $config = parse_ini_file('../../config/config.ini');
                // Retrieves data needed to connect to data base via config.ini
                //$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/capstone/config.ini');
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
        
        public function disconnect(){
            self::$connection = null;
        }
        
        private function selectDailyEvents(){
            try{
                //Grabs todays date and pulls a range of notifications
                $currentDate = new DateTime(); //current date/time
                $currentDate->sub(new DateInterval("PT2H"));
                $beginTimePST = $currentDate->format('Y-m-d H:i:s');
                
                $currentDate->add(new DateInterval("PT1H"));
                $endTimePST = $currentDate->format('Y-m-d H:i:s');
                echo($endTimePST."end and begin".$beginTimePST);
                
                // Creates a prepared select statement
                $statement = self::$mailman->prepare("SELECT eventDate, title, notes, users.username FROM events, users WHERE users.unique_loginID = events.unique_loginID and events.eventDate BETWEEN :startDate AND :stopDate ORDER BY eventDate ASC");
                
                $statement->bindParam(':startDate', $beginTimePST, PDO::PARAM_STR);
                $statement->bindParam(':stopDate', $endTimePST, PDO::PARAM_STR);
                $statement->execute();
          
                // Returns selected rows
                $row = $statement->fetchAll();
          
            } catch(PDOException  $e ){
              print "Error!: " . $e->getMessage() . "<br/>";
              return false;
            }
        
            return $row;
        }
        
        public function checkTheMail(){
            // Select all the daily notifications
            $notifications = $this->selectDailyEvents();
            
            // Opens dailyMail file to add new content.  Old content erases if rewrite to file.
            //$myfile = fopen($this->dailyMail, "w") or die("Unable to open file!");
            //print_r($notifications);
            foreach($notifications as $individualEvents){
                echo("Title:".$individualEvents['title']);
                echo("Note:".$individualEvents['notes']);
                echo("Date:".$individualEvents['eventDate']);
                echo("Email:".$individualEvents['username']);
                $message = "<p>Title: ".$individualEvents['title']." Event</p><p>Notes for Event: ".$individualEvents['notes']."</p>";
                $this->sendEmail($individualEvents['username'], $message);
                
            }
            /*
            $txt = "John Denver\n";
            fwrite($myfile, $txt);
            $txt = "Jane Doe\n";
            fwrite($myfile, $txt);
            fclose($myfile);
            */
        }
        
        private function sendEmail($to, $body , $subject = "Event Reminder"){
            //Email to applicant     
            require_once('swift_required.php');
             
            $email_address = "";
            //Create the Transport
            $transport = Swift_MailTransport::newInstance();
             
            /*
            You could alternatively use a different transport such as Sendmail or Mail:
             
            //Sendmail
            $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
             
            //Mail
            $transport = Swift_MailTransport::newInstance();
            */
             
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
                                    '<body>' .
                                    $body.
                                    '<br>'.
                                    '<p></p>'.
                                    '<h5>Thanks,</h5><br>'.
                                    '<h5>Woofster Team</h5>'.
                                    '<h5></h5>'.
                                    '<p></p>'.
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
        
        function append_cronjob($command){

            if(is_string($command)&&!empty($command)&&cronjob_exists($command)===FALSE){
        
                //add job to crontab
                exec('echo -e "`crontab -l`\n'.$command.'" | crontab -', $output);
        
        
            }
        
            return $output;
        }
        
        
    }
?>
<?php 


function sendEmail($to, $body , $subject = "Event Reminder "){
	//Email to applicant     
	require_once('../email/swift_required.php');
	 
	$email_address = "bmdegarimore@outlook.com";
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
	  "$to" => ""
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

?>
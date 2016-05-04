<?php
    include("mailman.php");
    
    // Creates a new Mailman
    $woofsterMailman = new Mailman();
    
    // Mailman connects to DB
    $woofsterMailman->connect();
    
    // Mailman checks the mail and sends it out
    $woofsterMailman->checkTheMail();

?>
<?php
    include("mailman.php");
    $woofsterMailman = new Mailman();
    $woofsterMailman->connect();
    $woofsterMailman->checkTheMail();
    


//sendEmail("branflakes@outlook.com", "Hello World", "Event Reminder");
?>
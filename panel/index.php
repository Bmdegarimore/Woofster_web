<?php
//Start a session
session_start();
// Start the buffer
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include('header.html'); ?>
    
    <body>
        
    </body>
</html>
<?php include('footer.html'); ?>


<?php
    //Flush buffer
    ob_flush();
?>
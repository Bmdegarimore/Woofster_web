<?php
//Start a session
session_start();
// Start the buffer
<<<<<<< Updated upstream
=======
  if(!isset($_SESSION['username'])){
    header("Location: ../../");
  }
>>>>>>> Stashed changes
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <?php include('header.html'); ?>
    
<<<<<<< Updated upstream
    <body>
=======
    <body class = "nav-md">

    <?php 
    	include("nav.php");
    ?>

        <div class="right_col" role="main">
            <div class="row">
            <!-- Page content goes here -->
            <?php
              if(isset($_GET['controller'])){
                $controller = strtoupper($_GET['controller']);
                //$action = strtoupper($_GET['action']);
                switch ($controller) {
                    case ADMIN:
                        include('../app/userspace/controller/controllerAdmin.php');
                        break;
                    /*case ADMIN:
                        echo "I'm an admin";
                        break;*/
                    default:
                       include('../app/userspace/controller/controllerAdmin.php');
                }
              }else{
                include('../app/userspace/controller/controllerAdmin.php');
              }
            ?>
            </div>
            <?php
                require("footer.html");
            ?>
        </div>

>>>>>>> Stashed changes
        
    </body>
</html>
<?php include('footer.html'); ?>


<?php
    //Flush buffer
    ob_flush();
<<<<<<< Updated upstream
?>
=======
?>

<?php



 
>>>>>>> Stashed changes

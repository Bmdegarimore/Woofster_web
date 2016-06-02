<?php
//include_once('../app/userspace/config.php');

//Start a session
session_start();
// Start the buffer


if(!isset($_SESSION['username'])){
    header("Location: loginAdmin.php");
}
  

ob_start();
?>

    <?php 
    
    include('header.html'); ?>
    

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
                    /*case DOWNLOAD:
                        include('../app/userspace/controller/controllerDownload.php');*/
                    default:
                       include('../app/userspace/controller/controllerAdmin.php');
                }
              }else{
                include('../app/userspace/controller/controllerAdmin.php');
              }
            ?>
            </div>
            <?php
                include("footer.html");
            ?>
        </div>


    <?php
      include('scripts.php');
    ?>
    </body>
</html>
<?php
    //Flush buffer
    ob_flush();
?>
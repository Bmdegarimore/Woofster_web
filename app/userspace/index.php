<?php
   //Starting session so I can grab stuff from $_SESSION
  session_start();

  if(!isset($_SESSION['user_uid'])){
    header("Location: ../../");
  }
    require("header.php");
?>
<html>
    <body class="nav-md">
        <?php
            require("nav.php");
        ?>
        <div class="right_col" role="main">
            <div class="row">
            <!-- Page content goes here -->
            <?php
               /* select makes a choice of page to load, then grab any additional GETs to change logic, or default to controllerEvents.php */

              //Check the get array for the select element
              if (isset($_GET['select'])) {
                //If it's equal to events...
                if($_GET['select'] == "events") {
                  //Set the page to the controller for events
                  $page = "controllerEvents";
                }
                else {
                  $page = "main"; //Default
                }
              //Load the page
              include($page.'.php');
              } else {
                include('controllerEvents.php');
              }
            ?>
            </div>
            <?php
                require("footer.html");
            ?>
        </div>
    </body
</html>
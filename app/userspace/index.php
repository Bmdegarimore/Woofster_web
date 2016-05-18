<?php
   //Starting session so I can grab stuff from $_SESSION
  session_start();

  if(!isset($_SESSION['user_uniqueId'])){
    header("Location: ../../");
  }
    require("header.html");
?>
<body class="nav-md">
        <?php
            require("nav.php");
        ?>
        <div class="right_col" role="main">
            <div class="row">
            <!-- Page content goes here -->
            <?php
              if(isset($_GET['controller'])){
                $controller = strtoupper($_GET['controller']);
                //$action = strtoupper($_GET['action']);
                switch ($controller) {
                    case EVENTS:
                        include('controller/controllerEvents.php');
                        break;
                 
                    default:
                       include('controller/controllerEvents.php');
                }
              }else{
                include('controller/controllerEvents.php');
              }
            ?>
            </div>
            <?php
                require("footer.html");
            ?>
        </div>
    <?php
      include('scripts.php');
    ?>
</body>
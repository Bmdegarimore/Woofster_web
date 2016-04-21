<?php 
  //Starting session so I can grab stuff from $_SESSION
  session_start();

  if(!isset($_SESSION['user_uid'])){
    header("Location: ../../");
  }
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>User Page</title>

  <!-- Global CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <!--<link rel="stylesheet" href="css/launcherStyle.css">-->

  <!-- Custom styling plus plugins -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <!--<link rel="stylesheet" type="text/css" href="css/maps/jquery-jvectormap-2.0.3.css" />-->
  <link href="assets/css/icheck/flat/green.css" rel="stylesheet" />
  <link href="assets/css/floatexamples.css" rel="stylesheet" type="text/css" />
  
  <!-- Global JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <!-- Custom JS -->
  <script src="assets/js/nprogress.js"></script>
  <script src="assets/js/custom.js"></script>

  <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

   
  <div class="container body">


    <div class="main_container">

      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">

          <div class="navbar nav_title" style="border: 0;">
            <a href="./" class="site_title"><i class="fa fa-paw"></i> <span>Woofster!</span></a>
          </div>
          <div class="clearfix"></div>

          <!-- menu prile quick info -->
          <div class="profile">
            <div class="profile_pic">
              <?php 
                //Get the profile picture
                if(isset($_SESSION['user_photoURL'])) { 
                  echo "<img src='" . $_SESSION['user_photoURL'] . 
                        "' alt='User profile picture' class='img-circle profile_img'>"; 
                }
              ?>
            </div>
            <div class="profile_info">
              <span>Welcome,</span>
              <?php 
                //Show the user's name if it's set
                if(isset($_SESSION['user_name'])) { 
                  echo "<h2>" . $_SESSION['user_name'] . "</h2>"; 
                }
              ?>
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br />

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>Features</h3>
              <ul class="nav side-menu">
                <li><a href="./"><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  </ul>
                </li>
                <li><a href="?select=events"><i class="fa fa-table"></i> Events <span class="fa fa-chevron-down"></span></a>
                </li>
              </ul>
            </div>
            <div class="menu_section">
              <h3>In Development</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-phone"></i> Mobile Notifications <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  </ul>
                </li>
              </ul>

               <ul class="nav side-menu">
                <li><a><i class="fa fa-paw"></i> Dog profiles <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu" style="display: none">
                  </ul>
                </li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->

          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
              <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
              <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
              <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout">
              <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
          </div>
          <!-- /menu footer buttons -->
        </div>
      </div>

      <!-- top navigation Bar -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php 
                    //Get the profile picture & username
                    if(isset($_SESSION['user_photoURL']) && isset($_SESSION['user_name'])) { 
                      echo "<img src='" . $_SESSION['user_photoURL'] . 
                            "' alt='User profile picture'> " . $_SESSION['user_name']; 
                    }
                  ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="../../hybridauth/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>

              <!--<li role="presentation" class="dropdown">
                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-envelope-o"></i>
                  <span class="badge bg-green">6</span>
                </a>
                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <a>
                      <span class="image">
                                        <img src="images/img.jpg" alt="Profile Image" />
                                    </span>
                      <span>
                                        <span>John Smith</span>
                      <span class="time">3 mins ago</span>
                      </span>
                      <span class="message">
                                        Film festivals used to be do-or-die moments for movie makers. They were where...
                                    </span>
                    </a>
                  </li>
                  <li>
                    <div class="text-center">
                      <a href="inbox.html">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>-->
          </nav>
    </div>

  </div>
    
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">

       
        <div class="row">
            <!-- Page content goes here -->
            <?php
              /* select makes a choice of page to load, then grab any additional GETs to change logic, or default to main.php */

              //Check the get array for the select element
              if (isset($_GET['select'])) {
                //If it's equal to events...
                if($_GET['select'] == "events") {
                  //Set the page to the controller for events
                  $page = "controllerEvents";
                  
                  //Check if the action is set in the get array
                  if(isset($_GET['action'])) {
                    //Grab the action from the get array
                    $action = $_GET['action'];
                     
                    //Get the row & id if they're set
                    if(isset($_GET['row']) && isset($_GET['id'])) {
                      $row = $_GET['row'];
                      $id = $_GET['id'];
                    }
                  }
                }
                //If the selection isn't for events
                else {
                  //Load whatever is selected 
                  $page = $_GET['select'];
                }
              }
              else {
                $page = "main"; //Default
              }
              
              //Load the page
              include($page.'.php');
            ?>
        </div>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Team Woofster 2016
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
      <!-- /page content -->

</body>
</html>
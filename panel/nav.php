  <?php
  session_start();
  $_SESSION['update'] = $_GET['update'];
  ?>
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
              <span>Welcome Admin, </span>
              <!--<?php 
                //Show the user's name if it's set
                /*if(isset($_SESSION['user_name'])) { 
                  echo "<h2>" . $_SESSION['user_name'] . "</h2>"; 
                }*/
              ?>-->
            </div>
          </div>
          <!-- /menu prile quick info -->

          <br/>

          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

            <div class="menu_section">
              <h3>Features</h3>
              <ul class="nav side-menu">
                <li><a href="?controller=admin&update=events "><i class="fa fa-bars" ></i>Admin Events View</a></li>
                <li><a href="?controller=admin&update=showUsers"><i class="fa fa-envelope" aria-hidden="true" ></i> User Emails</a></li>
                    <?php
                    echo $_POST['update'];
                    ?>
                
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->

        </div>
      </div><!--end of main container-->

      <!-- top navigation Bar -->
      <div class="top_nav">

        <div class="nav_menu">
          <nav class="" role="navigation">
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <?php 
                    //Get the profile picture & username
                    if(isset($_SESSION['user_name'])) { 
                      echo $_SESSION['user_name']; 
                    }
                  ?>
                  <span class=" fa fa-angle-down"></span>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <li><a href="../../hybridauth/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
    </div>

  </div><!--end container body-->   
  <?php
 
//top navigation 
?>
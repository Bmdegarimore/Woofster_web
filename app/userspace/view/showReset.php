<?php
    session_start();
    if(!isset($_SESSION["selector"]) && !isset($_SESSION["validator"])){
        session_destroy();
        header("Location: ../.../../index.php");
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Woofster</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="931022949770-dqsih5ukkmtdgko5ev0sducs73oekhmd.apps.googleusercontent.com">
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Copse' rel='stylesheet' type='text/css'>

    <!-- Custom Css-->
    <link rel="stylesheet" type="text/css" href="../../../css/style.css">
    <!-- Global JS -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


  </head>
  <body>

    <!-- Landing Section -->
    <div class="landing">
      <div class="container">
        <div class="row animated bounceInDown well">
          <div class="col-lg-12">
            <div class="text-center">
              
                  
                    <h2 class="text-muted">Password Reset</h2>
                    <form class='form-signin' action='splashPage.php' method='post'>
                      <fieldset>
                            <input class="form-control login-input" placeholder="Email Address" type="email" name='email' maxlength='45' required>
                            <br>
                            <input class="form-control" placeholder="Password" type="password"  name='password' maxlength='16' required>
                            <br>
                            <input class="form-control" placeholder="Password" type="password"  name='rePassword' maxlength='16' required>
                            <br>
                            <button class="btn btn-lg btn-primary btn-block btn-center submitButton" type="submit" name="submit" value="change">Register</button>
                      </fieldset >
                    </form>
            </div>
          </div><!-- /col-lg-12 -->
        </div><!-- /row -->
      </div><!-- /container -->
    </div> <!-- /landing -->

    

    <footer class="container-fluid text-center bg-grey">
     
      <p>&copy; 2016 Team Woofster</p>		
    </footer>
    
  </body>
</html>
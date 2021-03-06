<?php
    session_start();
     /* Handle if headers are already in existance, just destroy them */
    if($_SESSION['logged_in'] || $_SESSION['user_uniqueId']){
       session_destroy();
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
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-social.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">

    <!-- Global JS -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.countdown.js"></script>

    <!-- Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-74411916-1', 'auto');
      ga('send', 'pageview');

    </script>
    <!-- End Of Analytics -->

  </head>
  <body class="landing">
      <div class="container">
        <div class="row animated bounceInDown well col-md-6 col-md-offset-3">
          <div class="col-lg-12">
            <div class="text-center">
              <img class='img-responsive' src="img/logo.png">
                    <?php if(!empty($_SESSION['error'])){
                            echo('<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>');
                        
                            unset($_SESSION['error']);
                        }else if(!empty($_SESSION['passed'])){
                            echo('<div class="alert alert-success" role="alert">'.$_SESSION['passed'].'</div>');
                            unset($_SESSION['passed']);
                        }
                    ?>
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#login" aria-controls="home" role="tab" data-toggle="tab">Login</a></li>
                <li role="presentation"><a href="#signup" aria-controls="profile" role="tab" data-toggle="tab">Sign Up</a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="login">
                  <h2 class="text-muted" id="titleSignin">Please Sign In</h2>
                  <form class="form-signin" action="splashPage.php" method="post">
                    <fieldset>
                        <input class="form-control login-input" placeholder="Email Address" name="signinEmail" type="email" maxlength='45' required>
                        <br>
                        <input id="passwordField" class="form-control" placeholder="Password" name="signinPassword" type="password" maxlength='16' required>
                          <a id="forgotPassword" href="#">Forgot Password?</a>
                        <hr>
                        <div class="row">
                                <button class="btn btn-lg btn-primary submitButton" id="submitSignin" type="submit" name="submit" value="signin">Sign in</button>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="socialSpan col-lg-5"><a class="btn btn-primary btn-lg social-facebook" href="hybridauth/login-with.php?provider=Facebook"><i class="fa fa-facebook"></i></a></span>
                                <span class="socialSpan"><a class="btn btn-primary btn-lg social-google" href="hybridauth/login-with.php?provider=Google"><i class="fa fa-google-plus"></i></a></span>
                            </div>

                        </div>
                    </fieldset>
                  </form>
                </div> <!-- END SIGN IN PANEL -->
                <div role="tabpanel" class="tab-pane" id="signup">
                  <h2 class="text-muted">Sign Up for Free</h2>
                  <form class='form-signin' action='splashPage.php' method='post'>
                    <fieldset>
                            <input class='form-control' placeholder='First Name' type='text' name='fname' maxlength='20' required>
                            <br>
                            <input class='form-control' placeholder='Last Name' type='text' name='lname' maxlength='20' required>
                            <br>
                            <input class="form-control login-input" placeholder="Email Address" id="email" type="email" name='email'  minlength="3" maxlength='45' required>
                            <br>
                            <input class="form-control" placeholder="Password" type="password"  id='password' name='password' minlength="8" maxlength='16' required>
                            <hr>
                            <div class="row">
                                <button id="submitSignin" class="btn btn-lg btn-primary submitButton" type="submit" name="submit" value="register">Register</button>
                            </div>
                    </fieldset >
                  </form>
                </div> <!-- END SIGN UP PANEL -->
              </div> <!-- END TAB CONTENT -->
            </div> <!-- End Sign in Content area -->
          </div><!-- /col-lg-12 -->
        </div><!-- /row -->
      </div><!-- /container -->

    <!-- Modal Sign Up -->
    <div id="signUpModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sign Up For Woofster</h4>
          </div>
          
          <div class="modal-body">
            <!-- Sign Up Form-->
            <form action="https://formspree.io/fitpuphealth@gmail.com" method="POST" class="form-horizontal">
              <!-- Email input-->
              <div class="control-group">
                <label class="control-label" for="Email">Email:</label>
                <div class="controls">
                  <input id="Email" name="Email" class="form-control" type="email" placeholder="Fit.fido@email.com" class="input-large" required>
                </div>
              </div>

              <!-- Text input-->
              <div class="control-group">
                <label class="control-label" for="userid">First Name:</label>
                <div class="controls">
                  <input id="userid" name="userid" class="form-control" type="text" placeholder="Fit" class="input-large" required="">
                </div>
              </div>

              <!-- Text input-->
              <div class="control-group">
                <label class="control-label" for="userid">Last Name:</label>
                <div class="controls">
                  <input id="userid" name="userid" class="form-control" type="text" placeholder="Fido" class="input-large" required="">
                </div>
              </div>
            </form>
          </div> <!-- end modal body -->
      
          <div class="modal-footer">
            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="confirmsignup"></label>
              <div class="controls">
                <input type="submit" id="confirmsignup" name="confirmsignup" class="btn btn-success" value="Sign Up!"></input>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Sign In Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sign In</h4>
          </div>
    
          <div class="modal-body">
            <a href="hybridauth/login-with.php?provider=Google"><img src="img/signingoogle.png" class="img-responsive"></a>
            <br>
            <a href="hybridauth/login-with.php?provider=Facebook"><img src="img/signinfacebook.png" class="img-responsive"></a>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
    
    <!-- Terms of service modal -->
    <div id='termsModal' class='modal fade' role='dialog'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <div class='modal-header'>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class='modal-title'>Terms of Agreement</h4>
          </div>
          
          <div class='modal-body'>
            <p>
              Woofster will use your personal data to provide you a high quality experience. 
              Privacy is a priority for us. We hate spam too. We will never share your information.
             </p>
          </div>

          <div class='modal-footer'>
            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
          </div>
        </div>
      </div>
    </div>

    <footer class="container-fluid text-center bg-grey">
      <a class="topPage" href="#myPage" title="To Top">
        <i class="glyphicon glyphicon-chevron-up"></i>
      </a>
      <p><a data-toggle="modal" href="#termsModal">Terms Of Service</a></p>
      <p>&copy; 2016 Team Woofster</p>    
    </footer>
    
    <script>
        // Will be used to 
        $( "#forgotPassword" ).toggle(function() {
            $( "#passwordField" ).hide();
            $("#passwordField").prop('disabled', true);
            $(".socialSpan").hide();
            $("#submitSignin").text("Reset");
            $("#submitSignin").val("reset");
            $("#titleSignin").text("Enter your email:");
            $("#forgotPassword").text("Cancel");
            
        }, function(){
            $("#passwordField").prop('disabled', false);
            $( "#passwordField" ).show();
            $(".socialSpan").show();
            $("#submitSignin").text("Sign in");
            $("#submitSignin").val("signin");
            $("#titleSignin").text("Please Sign In");
            $("#forgotPassword").text("Forgot Password?");
        });
        /*
        $(".submitButton").click(function(){
            if ($(this).val()=== "register") {
                
            }else if ($(this).val() === "signin") {
                //code
            }else {
                
            }
            
        });*/
    </script>
  </body>
</html>
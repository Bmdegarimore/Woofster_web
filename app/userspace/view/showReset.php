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
    <link rel="stylesheet" type="text/css" href="app/userspace/assets/css/resetStyle.css">
    <!-- Custom Css-->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Global JS -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


  </head>
  <body class="landing">
      <div class="container">
        
        <div class="row well col-md-6 col-md-offset-3">
          <div class="col-lg-12">
            <div class="text-center">
                <h2 class="text-muted">Password Reset</h2>
                    <form class='form-vertical' role= "form" action='splashPage.php' method='post'>
                            <p id="required"><span class="glyphicon glyphicon-asterisk"></span> = required.</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span id="check1" class="glyphicon glyphicon-asterisk"></span>
                                </span>
                                <input class="form-control" id="email" placeholder="Current Email Address" type="email" name='email' maxlength='45' required>
                            </div>
                            <div>
                                <p id="emailExample" class= "text-muted">Email format: username@email.com</p>
                            </div>
                            <br>
                            <div class="password-group input-group">
                                <span class="input-group-addon" >
                                    <span id="check2" class="glyphicon glyphicon-asterisk"></span>
                                </span>
                                <input class="form-control" placeholder="New Password" type="password"  id='password' name='password' maxlength='17' required>
                                <span id="show"class="input-group-addon">
                                    <span class="glyphicon glyphicon-eye-open" type="button"></span>
                                </span>
                            </div>
                            <div class="col-lg-12 password-group">
                                <h4 class= "text-muted" id="requirements">Requires:</h4>
                                <ul>
                                    <li id="length" class= "text-muted">8 or More Characters</li>
                                    <li id="uppercase" class= "text-muted">Uppercase</li>
                                    <li id="lowercase" class= "text-muted">Lowercase</li>
                                    <li id="numeric" class= "text-muted">Numeric</li>
                                    <li id="specialCharacter" class= "text-muted">Special Character: $@$!%*?&</li>
                                </ul>
                            </div>
            
                            <br>
                        
                            <br>
                            <button id="submit" class="btn btn-primary submitButton" type="submit" name="submit" value="change">Change Password</button>
                    
                    </form>
            </div>
        </div><!-- /col-lg-12 -->
        </div><!-- /row -->
      </div><!-- /container -->
    <script src="app/userspace/assets/js/formStyle.js"></script>

    <footer class="container-fluid text-center bg-grey">
     
      <p>&copy; 2016 Team Woofster</p>		
    </footer>
    
  </body>
</html>
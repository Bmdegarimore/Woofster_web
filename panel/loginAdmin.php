<?php

    // Restarts Session
    session_start();
    
    /* Handle if headers are already in existance, just destroy them */
    if($_SESSION['logged_in'] || $_SESSION['user_uniqueId']){
       session_destroy();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Global CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Copse' rel='stylesheet' type='text/css'>

    <!-- Custom Css-->
    <link rel="stylesheet" type="text/css" href="../app/userspace/assets/css/panelLoginStyle.css">

</head>
<body>

<!-- Landing Section -->
  <div class="landing">
    <div class="container">
      <div class="row animated bounceInDown well">
        <div class="col-lg-12">


    <div class="text-center">
        <form class="form-signin" method="post" action="authenticate.php">
            <h2 class="form-signin-heading modal-title">Please sign in</h2>
        
            <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" autofocus="" value="<?php if(isset($_SESSION['username'])){echo($_SESSION['username']);}?>" required>
            
            <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required >
           
            <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Sign in</button>
            
            <?php if(!empty($_SESSION['error'])){
                    echo('<div class="alert alert-danger" role="alert">'.$_SESSION['error'].'</div>');
                    
                    unset($_SESSION['error']);
                }
             ?>
        </form>
    </div>
                 
        </div><!-- /col-lg-6 -->

        
      </div><!-- /row -->

  </div><!-- /headerwrap -->
</div>

<footer class="container-fluid text-center bg-grey">
  <a class="topPage" href="#myPage" title="To Top">
  </a>
  <p>&copy; 2016 Team Woofster</p>		
</footer>


</body>
</html>
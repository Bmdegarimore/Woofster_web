<?php
session_start();
include('config.php');
include('hybridauth/Hybrid/Auth.php');
if(isset($_GET['provider'])) {
        $provider = $_GET['provider'];

        try{

                $hybridauth = new Hybrid_Auth( $config );

                $authProvider = $hybridauth->authenticate($provider);

                $user_profile = $authProvider->getUserProfile();

                if($user_profile && isset($user_profile->identifier))
                {
                        if(!isset($_SESSION['logged_in'])){
                            $_SESSION['logged_in'] = true;
                        }
                        else {
                            //Handle if the session is already in there
                        }

                        /*echo "<b>Name</b> :".$user_profile->displayName."<br>";
                        echo "<b>Profile URL</b> :".$user_profile->profileURL."<br>";
                        echo "<b>Image</b> :".$user_profile->photoURL."<br> ";
                        echo "<img src='".$user_profile->photoURL."'/><br>";
                        echo "<b>Email</b> :".$user_profile->email."<br>";
                        echo "<br> <a href='logout.php'>Logout</a>";*/
                }	        

        }
        catch( Exception $e )
        { 

                switch( $e->getCode() )
                {
                        case 0 : 
                                echo "Error 4040"; break;
                        case 1 : 
                                echo "Error 3800"; break;
                        case 2 : 
                                echo "Error 3900"; break;
                        case 3 : 
                                echo "Error 4033"; break;
                        case 4 : 
                                echo "Error 4034"; break;
                        case 5 : 
                                echo "Error 4200";
                                break;
                        case 6 : 
                                echo "Error 4210";
                                $authProvider->logout();
                                break;
                        case 7 : 
                                echo "Error 4100";
                                $authProvider->logout();
                                break;
                        case 8 : 
                                echo "Error 5090"; break;
                }

                // well, basically you should not display this to the end user, just give him a hint and move on..
                /*echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

                echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";*/

                echo "<p>It looks like you encountered an error! <br> <a href='../index.html'>Back to home page</a></p>";

        }
        
        //Temporarily redirect the user back to the index page
        header("Location: ../index.html");
}
?>
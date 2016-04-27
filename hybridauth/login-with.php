<?php
session_start();
include('config.php');
include('hybridauth/Hybrid/Auth.php');
include('dbModel.php');
include('UserUniqueIdentifier.php');

/* Handle if headers are already in existance, just destroy them */
if($_SESSION['logged_in'] || $_SESSION['user_uid']){
        session_destroy();
}

if(isset($_GET['provider'])) {
        $provider = $_GET['provider'];

        try{
                //Create a new hybridauth object with the configuration 
                $hybridauth = new Hybrid_Auth( $config );

                //Authenticate the user with their provider
                $authProvider = $hybridauth->authenticate($provider);

                //Try to grab the profile
                $user_profile = $authProvider->getUserProfile();

                if($user_profile && isset($user_profile->identifier))
                {
                        //Set logged_in session variable to true
                        $_SESSION['logged_in'] = true;

                        //Get the user's email, uid, name, and photourl
                        $_SESSION['user_email'] = $user_profile->email;
                        $_SESSION['user_uid'] = $user_profile->identifier;
                        $_SESSION['user_name'] = $user_profile->displayName;
                        $_SESSION['user_photoURL'] = $user_profile->photoURL;

                        //Query the model to see if the user is in the database, if they're not, add them to it
                        $model = new DBModel();

                        $model->connect();

                        //Concat the user id and the provider
                        $uniqueIdentifier = new UserUniqueIdentifier($user_profile->identifier, $provider);
                        $uidstr = $uniqueIdentifier->uniqueId;

                        //Store the user's uniqueIdentifier 
                        $_SESSION['user_uniqueId'] = $uidstr;

                        //Query the database to see if the uidstr is stored in the user's database
                        $userResult = $model->selectUser($uidstr);

                        //Check if there was a result
                        if(count($userResult) == 1){
                                //Check if the user has a dog
                                //$dogResult = $model->selectDog($uidstr);

                                //If the user has a dog
                                /* Disabled til another sprint
                                if($dogResult == 1){
                                        //do nothing, it's all good
                                }
                                else if ($dogResult == 0) {
                                        //Create the dog
                                        $model->insertDog('dog', $uidstr);
                                } */
                        }
                        else if(count($userResult) == 0) {
                                //Create the user using the email, provider, and uidstr
                                $model->insertUser($user_profile->email, $provider, $uidstr);

                                //Create the dog
                                //$model->insertDog('dog', $uidstr);
                        }

                        /*echo "<b>Name</b> :".$user_profile->displayName."<br>";
                        echo "<b>Profile URL</b> :".$user_profile->profileURL."<br>";
                        echo "<b>Image</b> :".$user_profile->photoURL."<br> ";
                        echo "<img src='".$user_profile->photoURL."'/><br>";
                        echo "<b>Email</b> :".$user_profile->email."<br>";
                        echo "<br> <a href='logout.php'>Logout</a>";*/

                        //Redirect the user to the userspace
                        $model->disconnect();
                        header("Location: ../app/userspace/");
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

                //Destroy any lingering session variables
                session_destroy();

                //Can be used down the road if we want to automatically send data to the server on an error
                /*echo "<br /><br /><b>Original error message:</b> " . $e->getMessage();

                echo "<hr /><h3>Trace</h3> <pre>" . $e->getTraceAsString() . "</pre>";*/

                echo "<p>It looks like you encountered an error! <br> <a href='../index.html'>Back to home page</a></p>";

        }
}
?>
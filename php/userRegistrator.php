<?php
    require 'helper.php';
/***
 takes in user entered info and creates a user from it
 ***/

    $username = $_POST['username'];
    $password = $_POST['password'];
    $bio = $_POST['bio'];
    $email = $_POST['email'];

    $retrievedUser = 'Helper'::getUserByName($username);
    
    $response = array();
    
    if ($retrievedUser[0]['username'] === null){
        'Helper'::registerUser($username, $password, $bio, $email);
	$ndb = new PDO('Helper'::NOTIFICATIONS_DATABASE_LOCATION);
	$ndb->exec("INSERT INTO settings VALUES (\"" . $username . "\",\"true\",\"true\",\"true\",\"true\",\"true\");");
        $response['success'] = 'true';
        
    }else{
        $response['success'] = 'false';
    }

    echo json_encode($response);
    ?>

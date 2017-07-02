<?php
require 'helper.php';
    /***
 removes the specified challenge from the database
 ***/
    
    //determine which challenge is to be removed from the user entered name from the post request
    $challengeName = $_POST['challengeName'];

    'Helper'::removeChallenge($challengeName);
    $response = array();
    $response['success'] = 'true';
	echo json_encode($response);
?>

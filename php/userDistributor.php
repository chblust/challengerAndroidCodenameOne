<?php
/***
 * returns user metaData for all usernames requested by client, excluding user passwords
 */
require 'helper.php';
//gets list of usernames from request
$usernames = $_POST['usernames'];
//setup returnArray
$userData = array();
//uses helper method to retrieve user metadata from database for each user requested
$index = 0;
foreach ($usernames as $username){
		$userData[$index] = 'Helper'::getUserByName($username)[0];
        unset($userData[$index]['password']);
	unset($userData[$index]['salt']);
		$index++;
}
//send client json containing user metadata
echo json_encode($userData);
?>

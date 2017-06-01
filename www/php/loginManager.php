<?php
/***
 * Determines if user entered credentials match, tells client true, false, or if the user does not exist. null
 */
require 'helper.php';
//get user entered info from request
$username = $_POST['username'];
$password = $_POST['password'];
//uses helper method to retrieve a user from the database
$results = 'Helper'::getUserByName($username);
//sets up return array
$return = array();

//logic for determining response to client
if ($results[0]['username'] === null){
	$return['success'] = 'null';
}else if ($results[0]['password'] === $password){
	$return['success'] = 'true';
}else{
	$return['success'] = 'false';
}

//sends a json with the response message to client
echo json_encode($return);
?>

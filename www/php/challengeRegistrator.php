<?php
require 'helper.php';
//retrieve challenge attributes from post request
$name = $_POST['name'];
$author = $_POST['username'];
$instructions = $_POST['instructions'];
//setup response array
$response = array();
//check to see if challenge with name already exists
if(!isset('Helper'::getChallengeByName($name, "challenge")[0]['name'])){
	//register the challenge in the database
	'Helper'::registerChallenge($name, $author, $instructions);
	//setup client response
	$response['success'] = 'true';
}else{
	//setup client response
	$response['success'] = 'false';
}

//send client response in json format
echo json_encode($response);

?>

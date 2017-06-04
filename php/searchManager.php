<?php
require "helper.php";
//retrieve entry from post request
$entry = $_POST['entry'];
//setup return array
$returnData = array();

//determine whether the query is for challenges or users take appropriate measures
$results = array();
switch($_POST['queryType']){
	case 'users':
		//get usernames similar to entry from database
		$results = 'Helper'::searchForUser($entry);
		break;
	case 'challenges':
		//get challenges similar to entry from database
		$results = 'Helper'::searchForChallenge($entry);
		break;
}

//return array of results in json format
echo json_encode($results);
?>

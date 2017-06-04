<?php
error_reporting(E_ALL);
/***
 * determines the intent of the request, executes the appropriate code
 */
 //ensures client is a real Challenger client
$securityKey = "4qfY2ASbr0VTqwItKrrMHSvPKgUj89aJ4QjlbOEHawx8V1Ef9ahy95JREJAZgycxYRCsj9OcgqKDQx75mOcZ0aObgv8Hv1576oJu";

if ($securityKey === $_POST['securityKey']){

//makes sure request has intent, logic for executing the appropriate code
if(isset($_POST['intent'])){
switch($_POST['intent']){
	case 'login':
	require 'loginManager.php';
	break;

	case 'getUsers':
	require 'userDistributor.php';
	break;

	case 'getChallenges':
	require 'challengeDistributor.php';
	break;

	case 'search':
	require 'searchManager.php';
	break;
	
	case 'upload':
	require 'uploadManager.php';
	break;
	
	case 'like':
	require 'likeManager.php';
	break;

	case 'rechallenge':
	require 'rechallengeManager.php';
	break;

	case 'createUser':
	require 'userRegistrator.php';
	break;

	case 'follow':
	require 'followManager.php';
	break;

	case 'image':
	require 'imageManager.php';
	break;

	case 'edit':
	require 'userMetadataEditor.php';
	break;

	case 'createChallenge':
	require 'challengeRegistrator.php';
	break;

	case 'removeChallenge':
	require 'challengeRemover.php';
	break;
	
	case 'removeVideo':
	require 'videoRemover.php';
	break;
        
    case 'report':
    require 'reportManager.php';
    break;
        
    case 'acceptance':
    require 'acceptanceManager.php';
        break;
}
}else{
    var_dump($_POST);
}
}else{
    echo $securityKey . " !+= " . $_POST['securityKey'];
}
?>

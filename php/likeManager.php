<?php
require 'helper.php';
    //determine type of like and user who is doing it from post request
    $user = $_POST['username'];
    $type = $_POST['type'];
    $challengeName = $_POST['challengeName'];
    switch($type){
            case 'challenge':
                //use helper method to add user to challenge like records
            if('Helper'::hasLiked($user, $challengeName)){
                'Helper'::unLikeChallenge($challengeName, $user);
            }else{
                'Helper'::likeChallenge($challengeName, $user);
                $author = 'Helper'::getChallengeByName($challengeName, "challenge")[0]['author'];
		'Helper'::sendPushNotification($author, "like", $user, $challengeName);
            }
                break;
            case 'video':
            $uploader = $_POST['uploader'];
                //user helper method to add user to video like records
            if('Helper'::hasLikedVideo($user, $uploader, $challengeName)){
                'Helper'::unLikeVideo($challengeName, $uploader, $user);
            }else{
                'Helper'::likeVideo($challengeName, $uploader, $user);
		'Helper'::sendPushNotification($uploader, 'vlike', $user, $challengeName);
            }
                break;
    }
    
    
    
?>

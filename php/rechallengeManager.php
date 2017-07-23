<?php
//this file needs to add the user and the challenge to the rechallenge records and add the rechallenge
//to the feed of the user's followers
require 'helper.php';
    
    //get variables from post request
    $rechallengeUser = $_POST['username'];
    $challengeName = $_POST['challengeName'];
    if ('Helper'::hasRechallenged($rechallengeUser, $challengeName)){
        'Helper'::unRechallengeChallenge($challengeName, $rechallengeUser);
    }else{
        'Helper'::rechallengeChallenge($challengeName, $rechallengeUser);
        $author = 'Helper'::getChallengeByName($challengeName, 'challenge')[0]['author'];
        'Helper'::sendPushNotification($author, 'rechallenge', $rechallengeUser, $challengeName);
    }
    
            
    
    
?>

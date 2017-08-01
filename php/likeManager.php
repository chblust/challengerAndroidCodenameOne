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
		'Helper'::sendPushNotification($author, "like", $user, $challengeName, '');
            }
                break;
            case 'video':
            $uploader = $_POST['uploader'];
                //user helper method to add user to video like records
            if('Helper'::hasLikedVideo($user, $uploader, $challengeName)){
                'Helper'::unLikeVideo($challengeName, $uploader, $user);
            }else{
                'Helper'::likeVideo($challengeName, $uploader, $user);
		'Helper'::sendPushNotification($uploader, 'vlike', $user, $challengeName, '');
            }
                break;
           case 'comment':
           $uuid = $_POST['uuid'];
           if('Helper'::hasLikedComment($uuid, $user)){
               'Helper'::unLikeComment($uuid, $user);
           }else{
               'Helper'::likeComment($uuid, $user);
                $db = new PDO('Helper'::COMMENTS_DATABASE_LOCATION);
                $results = $db->query("SELECT challenge,author FROM comments WHERE uuid=\"" . $uuid . "\";")->fetchAll()[0];
                $author = $results["author"];
                $challenge = $results["challenge"];
                'Helper'::sendPushNotification($author, "clike", $user, $challenge, $uuid);
           }
           break;
    }
    
    
    
?>

<?php
require 'helper.php';
    /***
 either follows a user or unfollows a user
***/

//get user entered info from post request
    $user = $_POST['username'];
    $userToFollow = $_POST['userToFollow'];


  
    
    
            //use helper method to create follow entry in followRecords table of challengerDatabase IF $user isn't following $userToFollow
            
            if ('Helper'::isFollowing($user, $userToFollow)){
                'Helper'::unFollowUser($user, $userToFollow);
            }else{
                'Helper'::followUser($user, $userToFollow);
                'Helper'::sendPushNotification($userToFollow, "follow", $user, "", "");
            }
    
    


?>

<?php
require 'helper.php';
    //determine type of like and user who is doing it from post request
    $user = $_POST['username'];
    $type = $_POST['type'];
    switch($type){
            case 'challenge':
                //use helper method to add user to challenge like records
            if('Helper'::hasLiked($user, $_POST['challengeName'])){
                'Helper'::unLikeChallenge($_POST['challengeName'], $user);
            }else{
                'Helper'::likeChallenge($_POST['challengeName'], $user);
            }
                break;
            case 'video':
                //user helper method to add user to video like records
            if('Helper'::hasLikedVideo($user, $_POST['uploader'], $_POST['challengeName'])){
                'Helper'::unLikeVideo($_POST['challengeName'], $_POST['uploader'], $user);
            }else{
                'Helper'::likeVideo($_POST['challengeName'], $_POST['uploader'], $user);
            }
                break;
    }
    
    
    
?>

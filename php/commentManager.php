<?php
require 'helper.php';
$type = $_POST['type'];
$db = new PDO('Helper'::COMMENTS_DATABASE_LOCATION);

if ($type == 'send'){
    $author = $_POST['username'];
    $challenge = $_POST['challenge'];
    $message = $_POST['message'];
    $replyingTo = $_POST['replyingTo'];
    $query = "INSERT INTO comments VALUES (\"" . uniqid(true) . "\",\"" . $author . "\",\"" . $challenge . "\",\"" . $message . "\",date(\"now\"),\"" . $replyingTo . "\");";
    $db->exec($query);
    $response = array();
    $response['success'] = 'true';
    echo json_encode($response);
    }
else{
    $ret = array();
    $challenge = $_POST['challenge'];
    $query = "";
    if($type == 'get'){
        $query = "SELECT * FROM comments WHERE challenge=\"" . $challenge . "\" AND replyingTo=\"\";";
    }else if ($type == 'replys'){
        $uuid = $_POST['uuid'];
        $query = "SELECT * FROM comments WHERE replyingTo=\"" . $uuid . "\";";
    }
    $result = $db->query($query);
    if($result != false){
    $result->setFetchMode(PDO::FETCH_ASSOC);
    $comments = $result->fetchAll();
    $index = 0;
    foreach($comments as $comment){
        $ret[$index] = $comment;
        $ret[$index]['likers'] = array();
        $ret[$index]['replys'] = array();
        
        $likeResult = $db->query("SELECT liker FROM commentLikes WHERE uuid=\"" . $comment['uuid'] . "\";");
        if($likeResult != false){
            $likeResult->setFetchMode(PDO::FETCH_ASSOC);
            $likes = $likeResult->fetchAll();
            $lindex = 0;
            foreach($likes as $like){
                $ret[$index]['likers'][$lindex] =  $like['liker'];
                $lindex++;
            }
        }
   
        $replyResult = $db->query("SELECT author FROM comments WHERE replyingTo=\"" . $comment['uuid'] . "\";");
        if($replyResult != false){
            $replyResult->setFetchMode(PDO::FETCH_ASSOC);
            $replys = $replyResult->fetchAll();
            $rindex = 0;
            foreach($replys as $reply){
                $ret[$index]['replys'][$rindex] = $reply['author'];
                $rindex++;
            }
        }
        $index++;
    }
    }
    echo json_encode($ret);
}


?>

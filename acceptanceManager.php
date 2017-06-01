<?php
require 'helper.php';
    $type = $_POST['type'];
    $user = $_POST['username'];
    $challenge = $_POST['challengeName'];
    $response = array();
    
    switch($type){
            case "check":
            if ('Helper'::userHasAccepted($user, $challenge)){
                $response['response'] = 'true';
            }else{
                $response['response'] = 'false';
            }
            
            echo json_encode($response);
            break;
        case "get":
            $db = new PDO('Helper'::DATABASELOCATION);
            $results = $db->query("SELECT user FROM acceptanceRecords WHERE challenge=\"" . $challenge . "\";");
            $results->setFetchMode(PDO::FETCH_ASSOC);
            $usernames = array();
            $index = 0;
            while($username = $results->fetch()){
                $usernames[$index]["username"] = $username["user"];
                $query = "SELECT liker FROM videoLikeRecords WHERE challenge=\"" . $challenge . "\" AND user=\"" . $username["user"] . "\";";
                
                $likeResults = $db->query($query);
                
                $likeResults->setFetchMode(PDO::FETCH_ASSOC);
                $i = 0;
                while($liker = $likeResults->fetch()){
                	$usernames[$index]["likers"][$i] = $liker["liker"];
                	$i++;
                }
                $index++;
            }
            echo json_encode($usernames);
    }
   








?>

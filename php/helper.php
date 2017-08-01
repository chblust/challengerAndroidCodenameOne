<?php
class Helper{
const DATABASELOCATION = "sqlite:/var/www/data/challengerDatabase";
const REPORT_DATABASE_LOCATION = "sqlite:/var/www/data/reportDatabase";
const NOTIFICATIONS_DATABASE_LOCATION = "sqlite:/var/www/data/notificationsDatabase";
const COMMENTS_DATABASE_LOCATION = "sqlite:/var/www/data/commentsDatabase";
/***
 * returns an array of the user metadata for the user with the username $name
 */
static function getUserByName($name){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT * FROM userMetadata WHERE username=\"" . $name . "\";";
	//execute query
	$results = $db->query($query);
	//return query results in array form using fetch method	
	$data = array();
	
	$results->setFetchMode(PDO::FETCH_ASSOC);
  
    $data[0] = $results->fetch();
		
    $data[0]['followers'] = array();
    
    $followerResults = $db->query("SELECT user FROM followRecords WHERE isFollowing=\"" . $name . "\";");
    
    $followerResults->setFetchMode(PDO::FETCH_ASSOC);
    
    $index = 0;
    while($nextFollower = $followerResults->fetch()){
        $data[0]['followers'][$index] = $nextFollower['user'];
        $index++;
    }
    
    
    $followingResults = $db->query("SELECT isFollowing FROM followRecords WHERE user=\"" . $name . "\";");
    
    $followingResults->setFetchMode(PDO::FETCH_ASSOC);
    
    $data[0]['following'] = array();
    
    $index = 0;
    while($nextFollowing = $followingResults->fetch()){
        $data[0]['following'][$index] = $nextFollowing['isFollowing'];
        $index++;
    }
    
	return $data;
}
/***
 * returns an array of the challenge metadata for the challenge with the name $name and the feed type $type
 */
static function getChallengeByName($name, $type){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT * FROM challengeMetaData WHERE name=\"" . $name . "\";";
	//execute query
	$results = $db->query($query);
	//return query in array form
	$data = array();
	
    /***
     How the following nested madness works:
        -for each challenge, do three things:
            1: add initial metadata to response array
            2: add the number of acceptances the challenge has to the response array
	    3: add each liker user to the response array from the likeRecords table
            4: add each rechallenger user to the response array from the rechallengeRecords table
  	    
	  ***/
    
    $index = 0;
	$results->setFetchMode(PDO::FETCH_ASSOC);
    $next = $results->fetch();
		$data[$index] = $next;
	
	//query database to get each acceptance
	$accResults = $db->query("SELECT user FROM acceptanceRecords WHERE challenge=\"" . $name . "\";");
	$accResults->setFetchMode(PDO::FETCH_ASSOC);
	$acc = $accResults->fetchAll();
	
	if($acc == false){
		$data[$index]['acceptedCount'] = '0';
	}else{
		$count = sizeof($acc);
		$data[$index]['acceptedCount'] = "$count";
	}





        
        //setup liker array for challenge
        $data[$index]['likers'] = array();
        //setup query to get likes for this challenge
        $likerResults = $db->query("SELECT user FROM likeRecords WHERE challenge=\"" . $name . "\";");
        $likerResults->setFetchMode(PDO::FETCH_ASSOC);
        //setup new iteration index to add the likers to this challenge
        $index2 = 0;
        //iterate through likers and add them to the response array
        while ($nextLiker = $likerResults->fetch()){
            $data[$index]['likers'][$index2] = $nextLiker['user'];
            $index2++;
        }
        
        //setup rechallenger array for challenge
        $data[$index]['rechallengers'] = array();
        //setup query to get rechallenges for this challenge
        $rechallengeResults = $db->query("SELECT user FROM rechallengeRecords WHERE challenge=\"" . $name . "\";");
        $rechallengeResults->setFetchMode(PDO::FETCH_ASSOC);
        //setup new iteration index to add the likers to this challenge
        $index2 = 0;
        //iterate through likers and add them to the response array
        while ($nextRechallenger = $rechallengeResults->fetch()){
            $data[$index]['rechallengers'][$index2] = $nextRechallenger['user'];
            $index2++;
        }
        
        
        
		
	
    
    
    $data[$index]['feedType'] = $type;
	return $data;
}


/***
 * retuns an array of all usernames from the database
 */
static function getAllUsernames(){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT username FROM userMetadata;";
	//execute query
	$results = $db->query($query);
	//return query in array form
	$data = array();
	$index = 0;
	$results->setFetchMode(PDO::FETCH_ASSOC);
	while($next = $results->fetch()){
		$data[$index] = $next['username'];
		$index++;
	}
	return $data;
}
/***
 * returns an array of all Challenge names from the database
 */
static function getAllChallengeNames(){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT name FROM challengeMetadata;";
	//execute query
	$results = $db->query($query);
	//return query in array form
	$data = array();
	$index = 0;
	$results->setFetchMode(PDO::FETCH_ASSOC);
	while($next = $results->fetch()){
		$data[$index] = $next;
		$index++;
	}
	return $data;
}
/***
 * returns an array of the usernames from the database that contain the entry
 */
static function searchForUser($entry){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT username FROM userMetadata WHERE username LIKE \"%" . $entry . "%\";";
	//execute query
	$results = $db->query($query);
	//return query in array form
	$data = array();
	$index = 0;
	$results->setFetchMode(PDO::FETCH_ASSOC);
	while($next = $results->fetch()){
		$data[$index] = $next['username'];
		$index++;
	}
	return $data;
}
/**
 * returns an array of the challenge names from the database that contain the entry
 */
static function searchForChallenge($entry){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	//setup query
	$query = "SELECT name FROM challengeMetadata WHERE name LIKE \"%" . $entry . "%\";";
	//execute query
	$results = $db->query($query);
	//return query in array form
	$data = array();
	$index = 0;
	$results->setFetchMode(PDO::FETCH_ASSOC);
	while($next = $results->fetch()){
		$data[$index] = $next['name'];
		$index++;
	}
	return $data;
}
/***
 * creates a new challenge entry in the database,
 * adds challenge to follower feeds
 */
static function registerChallenge($name, $author, $instructions){
	//establish connection to database
	$db = new PDO('Helper'::DATABASELOCATION);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//setup execution to create challenge
	$creatorQuery =  "INSERT INTO challengeMetadata VALUES (\"" . $name . "\",\"" . $author . "\",\"" . $instructions . "\",date(\"now\"));";
	//execute challenge creation query
	$db->exec($creatorQuery);
	//setup query to get list of user followers
	$followerQuery = "SELECT user FROM followRecords WHERE isFollowing=\"" . $author . "\";";
	//execute follower retrieval query
	$followerQueryResults = $db->query($followerQuery);
	//turn query results into an array
	$followers = array();
	$index = 0;
	$followerQueryResults->setFetchMode(PDO::FETCH_ASSOC);
	while($next = $followerQueryResults->fetch()){
		$followers[$index] = $next['user'];
		$index++;
	}
    //add poster to followers to make sure challenge appears on poster's feed
    $followers[$index] = $author;
    
	//logic for adding upload to user feeds
		//setup query to add challenge to user feeds
		$feedQuery = "INSERT INTO feedData VALUES ";
		//add challenge to all follower feeds
		for ($i = 0; $i < count($followers); $i++){
			$feedQuery .= "(\"" . $followers[$i] . "\",\"" . $name . "\",\"" . $author . "\",\"challenge\")";
			if ($i != count($followers) - 1){
				$feedQuery .= ",";
			}
        }
		$feedQuery .= ";";
		$db->exec($feedQuery);
        
    
    mkdir("/var/www/php/uploads/" . 'Helper'::getSafeString($name));
    exec("chmod 777 /var/www/php/uploads/" . 'Helper'::getSafeString($name));	
}
    /***
     *  -adds who accepted what challenge to the database acceptanceRecords
        -adds an acceptance to the feed of all the followers of $user
     ***/
    static function acceptChallenge($challengeName, $user){
      	if (!'Helper'::userHasAccepted($user, $challengeName)){

	  //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "INSERT INTO acceptanceRecords VALUES (\"" . $challengeName . "\",\"" . $user . "\");";
        //execute query
        $db->exec($query);
        
        //setup query to get list of user followers
        $followerQuery = "SELECT user FROM followRecords WHERE isFollowing=\"" . $user . "\";";
        //execute follower retrieval query
        $followerQueryResults = $db->query($followerQuery);
        //turn query results into an array
        $followers = array();
        $index = 0;
        $followerQueryResults->setFetchMode(PDO::FETCH_ASSOC);
        while($next = $followerQueryResults->fetch()){
            $followers[$index] = $next['user'];
            $index++;
        }

	$followers[$index] = $user;
        
        $feedQuery = "INSERT INTO feedData VALUES ";
        //add challenge to all follower feeds
        for ($i = 0; $i < count($followers); $i++){
            $feedQuery .= "(\"" . $followers[$i] . "\",\"" . $challengeName . "\",\"" . $user . "\",\"acceptance\")";
            if ($i != count($followers) - 1){
                $feedQuery .= ",";
            }
        }
        $feedQuery .= ";";
        $db->exec($feedQuery);
	}
    }
    
    /***
     *  adds a user to the challenge like records
     ***/
    static function likeChallenge($challengeName, $user){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "INSERT INTO likeRecords VALUES (\"" . $challengeName . "\",\"" . $user . "\");";
        //execute query
        $db->exec($query);
    }
    
    /***
     removes a user from the challenge like records
     ***/
    static function unLikeChallenge($challengeName, $user){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "DELETE FROM likeRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $user . "\";";
        //execute query
        $db->exec($query);
    }
    
    /***
     adds a user with a challenge and accepted user to the video like records
     ***/
    static function likeVideo($challengeName, $uploaderName, $likerName){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "INSERT INTO videoLikeRecords VALUES (\"" . $challengeName . "\",\"" . $uploaderName . "\",\"" . $likerName . "\");";
        //execute query
        $db->exec($query);
    }
    /***
     removes a user with a challenge and accepted user from the video like records
     ***/
    static function unLikeVideo($challengeName, $uploaderName, $likerName){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "DELETE FROM videoLikeRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $uploaderName . "\" AND liker=\"" . $likerName . "\";";
        //execute query
        $db->exec($query);
    }
    
    /***
     adds a user with a challenge to the rechallengeRecords
     ***/
    static function rechallengeChallenge($challengeName, $rechallengeUser){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "INSERT INTO rechallengeRecords VALUES (\"" . $challengeName . "\",\"" . $rechallengeUser . "\");";
        //execute query
        $db->exec($query);
        
        //for each follower, add rechallenge to feed
        //setup query to get list of user followers
        $followerQuery = "SELECT user FROM followRecords WHERE isFollowing=\"" . $rechallengeUser . "\";";
        //execute follower retrieval query
        $followerQueryResults = $db->query($followerQuery);
        //turn query results into an array
        $followers = array();
        $index = 0;
        $followerQueryResults->setFetchMode(PDO::FETCH_ASSOC);
        while($next = $followerQueryResults->fetch()){
            $followers[$index] = $next['user'];
            $index++;
        }
        
        $followers[$index] = $rechallengeUser;
        //logic for adding upload to user feeds
        if (count($followers) != 0){
            //setup query to add challenge to user feeds
            $feedQuery = "INSERT INTO feedData VALUES ";
            //add challenge to all follower feeds
            for ($i = 0; $i < count($followers); $i++){
                $feedQuery .= "(\"" . $followers[$i] . "\",\"" . $challengeName . "\",\"" . $rechallengeUser . "\",\"reChallenge\")";
                if ($i != count($followers) - 1){
                    $feedQuery .= ",";
                }
            }
            $feedQuery .= ";";
            $db->exec($feedQuery);
        }
    }
    
    /***
     removes a user with a challenge to the rechallengeRecords
     ***/
    static function unRechallengeChallenge($challengeName, $rechallengeUser){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "DELETE FROM rechallengeRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $rechallengeUser . "\";";
        //execute query
        $db->exec($query);
        
        $db->exec("DELETE FROM feedData WHERE poster=\"" . $rechallengeUser . "\" AND challenge=\"" . $challengeName . "\" AND type=\"reChallenge\";");
    }

    /***
     creates a new user entry in the database
     ***/
    static function registerUser($username, $password, $bio, $email){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $salt = bin2hex(random_bytes(64));
        $hp = hash('sha512', $password . $salt);
        $query = "INSERT INTO userMetadata VALUES (\"" . $username . "\",\"" . $hp . "\",\"" . $bio . "\",\"" . $email . "\",\"" . $salt . "\");";
        //execute query
        $db->exec($query);
    }
    
    /***
     creates follow entry in followRecords table of challengerDatabase
    ***/
    static function followUser($user, $userToFollow){
        //first thing we gotta do is write this new follow relationship to the database

	//establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query
        $query = "INSERT INTO followRecords VALUES (\"" . $user . "\",\"" . $userToFollow . "\");";
        $db->exec($query);

	//next thing that needs to happen is some of the recent posts of the followed user need to be places in the following user's feed
	//get the names of the last 10 challenges the user posted
	$query = "SELECT challenge,type FROM feedData WHERE poster=\"" . $userToFollow . "\" AND user=\"" . $userToFollow . "\" limit(5);";
	$nameResults = $db->query($query);
	if($nameResults != null){
		$nameResults->setFetchMode(PDO::FETCH_ASSOC);
		$names = $nameResults->fetchAll();
		
		$query = "INSERT INTO feedData VALUES";
		for($i = 0; $i < count($names); $i++){
			$query .= " (\"" . $user . "\",\"" . $names[$i]['challenge'] . "\",\"" . $userToFollow . "\",\"" . $names[$i]['type'] . "\")";
			if($i != count($names) - 1){
				$query .= ",";
			} 
		}
		$query .= ";";
		$db->exec($query);
	}
    }
    
    /***
     removes follow entry in followRecords table of challengerDatabase
     ***/
    static function unFollowUser($user, $userToUnFollow){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query to not only remove the follow relationship, but to also remove the followed's challenges from the ex-following
        $query = "DELETE FROM followRecords WHERE user=\"" . $user . "\" AND isFollowing=\"" . $userToUnFollow . "\"; DELETE FROM feedData WHERE user=\"" . $user . "\" AND poster=\"" . $userToUnFollow . "\";";
        $db->exec($query);
    }
    
    
    
/***
 *  returns a string form of a challenge name that is suitable for the name of a linux directory
 ***/
    static function getSafeString($name){
        $ret = "";
        foreach(str_split($name) as $char){
            if ($char === " "){
                $ret .= "_";
            }else{
                $ret .= $char;
            }
        }
        return $ret;
    }

    /***
     removes a challenge with the name $challengeName from:
        -challengeMetadata
        -each feed entry where it appears
        -each rechallengeRecords entry where it appears
        -each likeRecords entry where it appears
        -each acceptanceRecords entry where it appears
        -the entire directory for the challenge video uploads
     ***/
    static function removeChallenge($challengeName){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        //setup query to remove challenge from challengeMetadata
        $query = "DELETE FROM challengeMetadata WHERE name=\"" . $challengeName . "\";";
        
        //now, onto removing the feed entries
        $query .= "DELETE FROM feedData WHERE challenge=\"" . $challengeName . "\";";
       
        //next we will remove the likes and rechallenge entries
        $query .= "DELETE FROM likeRecords WHERE challenge=\"" . $challengeName . "\";";
        $query .= "DELETE FROM rechallengeRecords WHERE challenge=\"" . $challengeName . "\";";
        
        //and then the acceptance entries
        $query .= "DELETE FROM acceptanceRecords WHERE challenge=\"" . $challengeName . "\";";
        
        //finally delete the likes of videos that were entered into the database
        $query .= "DELETE FROM videoLikeRecords WHERE challenge=\"" . $challengeName . "\";";
       
        //execute the boatload of queries
        $db->exec($query);
        
        //then delete the directory with the video uploads
        exec("rm -r uploads/" . 'Helper'::getSafeString($challengeName));
        
    }
    /***
     removes the video posted to $challengeName by $uploader and the following information from the database:
            -all likes of this video
            -all acceptance feed entries of this video
            -the acceptanceRecords entry of this video
     ***/
    static function removeVideo($challengeName, $uploader){
        //establish connection to database
        $db = new PDO('Helper'::DATABASELOCATION);
        
        //setup query to remove all likes of this video from videoLikeRecords
        $query = "DELETE FROM videoLikeRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $uploader . "\";";
        
        //next we delete all the feed entries that are an acceptance of this challenge
        $query .= "DELETE FROM feedData WHERE challenge=\"" . $challengeName . "\" AND poster=\"" . $uploader . "\" AND type=\"acceptance\";";
        
        //lastly we take care of all the entries in acceptanceRecords where this video appears
        $query .= "DELETE FROM acceptanceRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $uploader . "\";";
        
        //execute that shit
        $db->exec($query);
	
	exec("rm -r /var/www/php/uploads/" . 'Helper'::getSafeString($challengeName) . "/" . $uploader);
    }

static function removeUser($username){
	$db = new PDO('Helper'::DATABASELOCATION);
	//get a list of the challenges this user has posted, if any
	$challengeNameResults = $db->query("SELECT name FROM challengeMetadata WHERE author=\"" . $username . "\";");
	if ($challengeNameResults != false){
		//now delete all those challenges
		$challengeNameResults->setFetchMode(PDO::FETCH_ASSOC);
		$challengeNames = $challengeNameResults->fetchAll();
	
		foreach($challengeNames as $challenge){
			'Helper'::removeChallenge($challenge['name']);
		}

		//next, obliterate all traces of this user ever existing;
		}	
	
	
	$query = "DELETE FROM userMetadata WHERE username=\"" . $username . "\";";
	$query .= "DELETE FROM followRecords WHERE user=\"" . $username . "\" OR isFollowing=\"" . $username . "\";";
	$db->exec($query);
	exec("/var/www/images/" . $username);
}
    /***
     returns true if user is following user2
     ***/
    static function isFollowing($user, $user2){
        foreach('Helper'::getUserByName($user)[0]['following'] as $following){
            if ($following === $user2){
                return true;
            }
        }
        return false;
    }
    
    static function hasRechallenged($user, $challengeName){
        $db = new PDO('Helper'::DATABASELOCATION);
        $results = $db->query("SELECT * FROM rechallengeRecords WHERE user=\"" . $user . "\" AND challenge=\"" . $challengeName . "\";");
        
        if ($results->fetchAll()[0] == null){
            return false;
        }
        return true;
    }
    
    static function hasLiked($user, $challengeName){
        $db = new PDO('Helper'::DATABASELOCATION);

        
        if ($db->query("SELECT * FROM likeRecords WHERE user=\"" . $user . "\" AND challenge=\"" . $challengeName . "\";")->fetchAll()[0] == null){
            return false;
        }
        return true;
    }
    
    static function hasLikedVideo($liker, $user, $challengeName){
        $db = new PDO('Helper'::DATABASELOCATION);

        if (($db->query("SELECT * FROM videoLikeRecords WHERE user=\"" . $user . "\" AND challenge=\"" . $challengeName . "\" AND liker=\"" . $liker . "\";"))->fetchAll()[0] == null){
            return false;
        }
        return true;
    }
  
    static function hasLikedComment($uuid, $liker){
        $db = new PDO('Helper'::COMMENTS_DATABASE_LOCATION);
        if(($db->query("SELECT * FROM commentLikes WHERE liker=\"" . $liker . "\";"))->fetchAll()[0] == null){
            return false;
        }
        return true;
    }

    static function likeComment($uuid, $liker){
        $db = new PDO('Helper'::COMMENTS_DATABASE_LOCATION);
        $db->exec("INSERT INTO commentLikes VALUES (\"" . $uuid . "\",\"" . $liker . "\");");
    }

    static function unLikeComment($uuid, $liker){
        $db = new PDO('Helper'::COMMENTS_DATABASE_LOCATION);
        $db->exec("DELETE FROM commentLikes WHERE uuid = \"" . $uuid . "\" AND liker=\"" . $liker . "\";");
    }
    
    static function userHasAccepted($user, $challengeName){
         $db = new PDO('Helper'::DATABASELOCATION);
        $query = "SELECT * FROM acceptanceRecords WHERE challenge=\"" . $challengeName . "\" AND user=\"" . $user . "\";";
        if (($db->query($query))->fetchAll()[0] == null){
            return false;
            }
            return true;
    }
	static function sendPushNotification($user, $type, $sender, $challenge, $uuid){
		if($user !== $sender){
		require '/var/www/pushManagement/vendor/autoload.php';
		//first check to see if notification exists
        	$db = new PDO('Helper'::NOTIFICATIONS_DATABASE_LOCATION);
		$result = $db->query("SELECT * FROM notifications WHERE username=\"" . $user . "\" AND type=\"" . $type . "\" AND sender=\"" . $sender . "\" AND challenge=\"" . $challenge . "\" AND uuid=\"" . $uuid . "\";");
		
		if($result->fetchAll()[0] == null){
                    $db->exec("INSERT INTO notifications VALUES (\"" . $user . "\",\"" . $type . "\",\"" . $sender . "\",\"" . $challenge . "\");");
		    
$body = '';
switch($type){
case 'acceptance':
$body = $sender . ' has accepted your challenge: ' . $challenge;
break;

case 'follow':
$body = $sender . ' has started following you!';
break;

case 'like':
$body = $sender . ' liked your challenge: ' . $challenge;
break;

case 'vlike':
$body = $sender . ' liked your video you posted to ' . $challenge;
break;

case 'rechallenge':
$body = $sender . ' reChallenged your challenge: ' . $challenge;
break;

//comments

case 'comment':
$body = $sender . ' commented on your challenge: ' . $challenge;
break;

case 'clike':
$body = $sender . ' liked your comment you posted to ' . $challenge;
break;

case 'reply':
$body = $sender . ' replied to your comment you posted to ' . $challenge;
break;
}


                    
                    $options = array(
    		    'cluster' => 'us2',
    		    'encrypted' => true
  		    );
  		    $pusher = new Pusher(
    		    'e0cf251611da3086a1f5',
    		    '1c6faa912e843a5e522a',
    		    '364524',
    		    $options
  		    );

		    $pusher->notify(
 		     array($user),
  	       	    array(
    		    'apns' => array(
     		     'aps' => array(
        		    'alert' => array(
                                 'body' => $body
				),
                             'challenge' => $challenge,
         		     'type' => $type,
                	     'sender' => $sender,
                             'uuid' => $uuid,  		    
      		    ),
    		    ),
		      )
		    );
              }   
          }
	} 
     
}
     
     
     
     
     
     
     
     
     
     
?>

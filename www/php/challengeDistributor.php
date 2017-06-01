<?php
/***
 * returns all challenge metadata for each challenge name requested by client
 */
require 'helper.php';
    //figure out whether client wants a challenge, feed, or the top challenges
    $type = $_POST['type'];
    //setup return array
    $challengeData = array();
    
    
    switch($type){
        case 'list' :
            //get list of challenge names from request
            $feedEntries = $_POST['feedEntries'];
            
            //uses helper method to retrieve all challengeMetadata for each challenge name
            $index = 0;
            foreach($feedEntries as $challengeName){
                $challengeData[$index] = 'Helper'::getChallengeByName($challengeName)[0];
                $challengeData[$index]['poster'] = 'null'; 
                $index++;
            }

            break;
            
            
        case 'home':
           
            //figure out which user the feed is for
            $user = $_POST['username'];
            
          
                //get list of feedEntries by user from database
                $db = new PDO('Helper'::DATABASELOCATION);
                $challengeNameResults = $db->query("SELECT * FROM feedData WHERE poster=\"" . $user . "\" AND user=\"" . $user . "\" ;");
                $challengeNameResults->setFetchMode(PDO::FETCH_ASSOC);
                $feedEntries = array();
                $index = 0;
                while($challengeName = $challengeNameResults->fetch()){
                    
                    $feedEntries[$index]['challengeName'] = $challengeName['challenge'];
                    $feedEntries[$index]['type'] = $challengeName['type'];
                    $index++;
                }
                $index = 0;
                foreach($feedEntries as $feedEntry){
                    $challengeData[$index] = 'Helper'::getChallengeByName($feedEntry['challengeName'], $feedEntry['type'])[0];
                    $challengeData[$index]['poster'] = 'null';
                    $index++;
                }
            break;
            
            
        case 'feed':
            //figure out which user the feed is for
            $user = $_POST['username'];
            
            //get list of the challenges needed from feedData
            $db = new PDO('Helper'::DATABASELOCATION);
            $challengeNameResults = $db->query("SELECT * FROM feedData WHERE user=\"" . $user . "\";");
            $challengeNameResults->setFetchMode(PDO::FETCH_ASSOC);
            $feedEntries = array();
            $index = 0;
            while($challengeName = $challengeNameResults->fetch()){
                
                $feedEntries[$index]['challengeName'] = $challengeName['challenge'];
                $feedEntries[$index]['type'] = $challengeName['type'];
                $feedEntries[$index]['poster'] = $challengeName['poster'];
                $index++;
            }
            $index = 0;
            foreach($feedEntries as $feedEntry){
                $challengeData[$index] = 'Helper'::getChallengeByName($feedEntry['challengeName'], $feedEntry['type'])[0];
                $challengeData[$index]['poster'] = $feedEntry['poster'];
                $index++;
            }

            break;
           
        case 'top':
        	$db = new PDO('Helper'::DATABASELOCATION);
        	$results = $db->query("select name from challengeMetadata innner join likeRecords ON (name = challenge) group by name order by count(*) limit 50;");
            $results->setFetchMode(PDO::FETCH_ASSOC);
            $index = 0;
		$challenges = array();
		while($result = $results->fetch()){
			$challenges[$index] = $result['name'];
			$index++;
		}

		$index = 0;
            foreach($challenges as $challenge){
            	$challengeData[$index] = 'Helper'::getChallengeByName($challenge, 'challenge')[0];
            	$challengeData[$index]['feedType'] = 'challenge';
            	$challengeData[$index]['poster'] = 'null';
		$index++;
            }
        	break;
    
    }
    
    
    
    
    
//return json enocoded results
echo json_encode($challengeData);
?>

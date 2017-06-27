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
            //$results = $db->query("SELECT user FROM acceptanceRecords WHERE challenge=\"" . $challenge . "\";");
           // $results = $db->query("select userResult from (select user as userResult,challenge as challengeResult from acceptanceRecords WHERE challenge = \"" . $challenge . "\") LEFT JOIN videoLikeRecords ON (userResult = videoLikeRecords.user AND challengeResult = videoLikeRecords.challenge) GROUP BY user ORDER BY count(*) DESC;");
           	$uploaderResults = $db->query("SELECT user FROM acceptanceRecords WHERE challenge=\"" . $challenge . "\" GROUP BY user;");
		
		$uploaderResults->setFetchMode(PDO::FETCH_ASSOC);
		$order = array();
		$index = 0;
	//	var_dump($uploaderResults->fetchAll());
		while($uploader = $uploaderResults->fetch()['user']){
			
			$likeCountResults = $db->query("SELECT * FROM videoLikeRecords WHERE challenge=\"" . $challenge . "\" AND user=\"" . $uploader . "\";");
			$likeCountResults->setFetchMode(PDO::FETCH_ASSOC);
			$order[$index] = $likeCountResults->fetchAll();
			$order[$index]["username"] = $uploader;
			$index++;
		}
		//var_dump($order);

		//sort by count
	//	for($index = 0; $index < sizeof($order); $index++){
		//	for($i = 0; $i < sizeof($order); $i++){
		//		if(sizeof($order[$index]) > sizeof($order[$i])){
		//			
		//		}
		//	}
		//}

		function cmp($a, $b){
			return (sizeof($b) - sizeof($a));
		}
		
		usort($order, 'cmp');
//var_dump($order);
		$index = 0;
		$sortedUsernames = array();
		foreach($order as $orderarr){
			$sortedUsernames[$index] = $orderarr['username'];
			$index++;
		}
		//var_dump($sortedUsernames);




		$usernames = array();


		 $index = 0;
            foreach($sortedUsernames as $username){
                $usernames[$index]["username"] = $username;
                $query = "SELECT liker FROM videoLikeRecords WHERE challenge=\"" . $challenge . "\" AND user=\"" . $username . "\";";
                
                $likeResults = $db->query($query);
                
                $likeResults->setFetchMode(PDO::FETCH_ASSOC);
                $i = 0;
                while($liker = $likeResults->fetch()){
                	$usernames[$index]["likers"][$i] = $liker["liker"];
                	$i++;
                }
                $index++;
            }


		//now determine which usernames to send back

		$response = array();
		$responseCount = 50;//the amount of acceptances that will appear at once on the client
		$rIndex = 0;
		if(isset($_POST['setLimit'])){
        $limit = $_POST['setLimit'];
	$index = 0;
        for($index = $limit - 1; $index < count($usernames) && $index < $limit + $responseCount- 1; $index++){
                if ($usernames[$index] != null){
                        $response['acceptances'][$rIndex] = $usernames[$index];
                        $rIndex++;
                }
        }
	if($index == count($usernames)){
		$response['end'] = 'true';
	}else{
		$response['end'] = 'false';
	}

}
            echo json_encode($response);
    }
   








?>

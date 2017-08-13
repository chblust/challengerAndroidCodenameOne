<?php
require 'helper.php';
$mskhfile = fopen("mskh.txt", "r");
$mskh = fread($mskhfile, filesize("mskh.txt"));

if($mskh === hash('sha512', $_POST['moderatorKey'])){
	$type = $_POST['type'];
	$db = new PDO('Helper'::REPORT_DATABASE_LOCATION);
	switch($type){
	case 'getChallenges':
		$results = $db->query("SELECT * FROM challengeReports;");
		$results->setFetchMode(PDO::FETCH_ASSOC);
		$reports = $results->fetchAll();
		if($reports[0] != null){
			echo json_encode($reports);
		}else{
			echo "none";
		}
		break;
	case 'getUsers':
		$results = $db->query("SELECT * FROM userReports;");
                $results->setFetchMode(PDO::FETCH_ASSOC);
                $reports = $results->fetchAll();
                if($reports[0] != null){
                        echo json_encode($reports);
                }else{
                        echo "none";
                }
                break;
	case 'getVideos':
		$results = $db->query("SELECT * FROM videoReports;");
                $results->setFetchMode(PDO::FETCH_ASSOC);
                $reports = $results->fetchAll();
                if($reports[0] != null){
                        echo json_encode($reports);
                }else{
                        echo "none";
                }
                break;
	case 'getComments':
		$results = $db->query("SELECT * FROM commentReports;");
                $results->setFetchMode(PDO::FETCH_ASSOC);
                $reports = $results->fetchAll();
                if($reports[0] != null){
                        echo json_encode($reports);
                }else{
                        echo "none";
                }
                break;
	}
}else{
    echo $mskh . " != " . $_POST['moderatorKey'];
}



?>

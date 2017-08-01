<?php
    require 'helper.php';
/***
 simply takes in a report from a user and enters it into the database
 ***/

//get report information form post request
    $type = $_POST['type'];
    $reporter = $_POST['username'];
    $reason = $_POST['reason'];
    $db = new PDO('Helper'::REPORT_DATABASE_LOCATION);
    switch($type){
    
            case 'user':
                $offender = $_POST['offender'];
                $db->exec("INSERT INTO userReports VALUES (\"" . $offender . "\",\"" . $reporter . "\",\"" . $reason . "\", date(\"now\"));");
                break;
            case 'challenge':
                $challenge = $_POST['challenge'];
                $db->exec("INSERT INTO challengeReports VALUES (\"" . $challenge . "\",\"" . $reporter . "\",\"" . $reason . "\", date(\"now\"));");
                break;
            case 'video':
                $challenge = $_POST['challenge'];
                $offender = $_POST['offender'];
                $db->exec("INSERT INTO videoReports VALUES (\"" . $challenge . "\",\"" . $offender . "\",\"" . $reporter . "\",\"" . $reason . "\", date(\"now\"));");
                break;
           case 'comment':
                $uuid = $_POST['uuid'];
                $db->exec("INSERT INTO commentReports VALUES (\"" . $uuid . "\",\"" . $reporter . "\",\"" . $reason . "\",date(\"now\"));");
    
    }







?>

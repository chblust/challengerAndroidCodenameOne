<?php
    require 'helper.php';
    // Turn off output buffering
//retrieve string data from post request
    ob_implicit_flush(true);
    $user = $_POST['username'];
    $challengeName = 'Helper'::getSafeString($_POST['challengeName']);
    //setup response array to tell client if the upload worked
    $response = array();
    //if file upload was a success, prepare file for streaming
    $newPath = "/var/www/php/uploads/" . $challengeName . "/" . $user . ".upload";
    if(move_uploaded_file($_FILES['upload']['tmp_name'], $newPath)){
       //tell client upload was successful
        
        $response['success'] = 'true';
        echo json_encode($response);
        //run program that segments the video file for streaming
	exec("chmod 777 " . $newPath);
        $segmentCommand = "/var/www/segmenterSoftware/segmenter -i uploads/" . $challengeName."/" . $user . ".upload";
        exec($segmentCommand);
        //add acceptance entry in database
 
        'Helper'::acceptChallenge($_POST['challengeName'], $user);
    }else{
        //tell client upload failed
        $response['success'] = 'false';
        echo json_encode($response);
    }
    
?>

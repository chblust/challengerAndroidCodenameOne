<?php
/***
 determines whether or not to set image, change image, or echo image
 ***/
    
    $set = $_POST['set'];
    $user = $_POST['username'];
    $userImagePath = "/var/www/images/" . $user;
    switch($set){
        case 'true':
            $response = array();
            exec("rm " . $userImagePath);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $userImagePath)){
                $response['success'] = 'true';
            }else{
                $response['success'] = 'false';
            }
            echo json_encode($response);
            break;
            
        case 'false':
            if (file_exists($userImagePath)){
            readFile($userImagePath);
            }else{
                echo 'false';
            }
            break;
    }

?>

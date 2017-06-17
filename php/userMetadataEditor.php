<?php
    require 'helper.php';
/***
 determines which information is being changed based on what is set, changes information accordingly
 ***/
    $user = $_POST['username'];
    
    $db = new PDO('Helper'::DATABASELOCATION);
   
    if(isset($_POST['newPassword'])){
       $db->exec("UPDATE userMetadata SET password=\"" . $_POST['newPassword'] . "\" WHERE username=\"" . $user . "\";");
       }
       if(isset($_POST['newBio'])){
          $db->exec("UPDATE userMetadata SET bio=\"" . $_POST['newBio'] . "\" WHERE username=\"" . $user . "\";");
        
        }
        if(isset($_POST['newEmail'])){
           $db->exec("UPDATE userMetadata SET email=\"" . $_POST['newEmail'] . "\" WHERE username=\"" . $user . "\";");
        
        }








?>

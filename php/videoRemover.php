<?php
require 'helper.php';
    /***
     removes the specified video from the database
     ***/
    
    $challengeName = $_POST['challengeName'];
    $uploader = $_POST['uploader'];
    
    'Helper'::removeVideo($challengeName, $uploader);
?>

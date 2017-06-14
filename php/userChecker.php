<?php
require 'helper.php';
$user = $_POST['username'];
$db = new PDO('Helper'::DATABASELOCATION);
$results = $db->query("SELECT * FROM userMetadata WHERE username=\"" . $user . "\";");
$results->setFetchMode(PDO::FETCH_ASSOC);
var_dump($results->fetch());










?>

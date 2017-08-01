<?php
$db = new PDO('sqlite:/var/www/data/challengerDatabase');

$query = "SELECT username FROM userMetadata;";

$results = $db->query($query);

$results->setFetchMode(PDO::FETCH_ASSOC);

$usernames = $results->fetchAll();

foreach ($usernames as $username){
    $db->exec("UPDATE userMetadata SET salt = \"" . bin2hex(random_bytes(64)) . "\" WHERE username=\"" . $username['username'] . "\";");
} 


?>

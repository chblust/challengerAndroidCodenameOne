<?php
$db = new PDO('sqlite:/var/www/data/challengerDatabase');

$results = $db->query("SELECT password, salt FROM userMetadata;");

$results->setFetchMode(PDO::FETCH_ASSOC);
$pairs = $results->fetchAll();

foreach($pairs as $pair){
    $hp = hash('sha512', $pair['password'] . $pair['salt']);
    $db->exec("UPDATE userMetadata SET password = \"" . $hp . "\" WHERE salt = \"" . $pair['salt'] . "\";");
}

?>

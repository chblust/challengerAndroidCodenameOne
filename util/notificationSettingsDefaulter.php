<?php
$cdb = new PDO('sqlite:/var/www/data/challengerDatabase');
$ndb = new PDO('sqlite:/var/www/data/notificationsDatabase');
$results = $cdb->query("SELECT username FROM userMetadata;");
$results->setFetchMode(PDO::FETCH_ASSOC);
$names = $results->fetchAll();
$query = "INSERT INTO settings VALUES ";
foreach($names as $name){
	$ndb->exec("INSERT INTO settings VALUES (\"" . $name['username'] . "\",\"true\",\"true\",\"true\",\"true\",\"true\");");
}




?>

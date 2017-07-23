<?php
require 'helper.php';
$user = $_POST['username'];
$type = $_POST['type'];
$db = new PDO('Helper'::NOTIFICATIONS_DATABASE_LOCATION);
switch($type){
case 'get':
$results = $db->query("SELECT * FROM notifications WHERE username=\"" . $user . "\";");
$results->setFetchMode(PDO::FETCH_ASSOC);
$notifications = $results->fetchAll();

echo json_encode($notifications);
break;
case 'remove':
$notification = $_POST['notification'];
$db->exec("DELETE FROM notifications WHERE username=\"" . $notification['username'] . "\" AND type=\"" . $notification['type'] . "\" AND sender=\"" . $notification['sender'] . "\" AND challenge=\"" . $notification['challenge'] . "\";");
break;
}

?>

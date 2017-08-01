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
        $notificationType = $_POST['notificationType'];
        $sender = $_POST['sender'];
        $challenge = $_POST['challenge'];
        var_dump($_POST);
        $db->exec("DELETE FROM notifications WHERE username=\"" . $user . "\" AND type=\"" . $notificationType . "\" AND sender=\"" . $sender . "\" AND challenge=\"" . $challenge . "\";");
        break;
}

?>

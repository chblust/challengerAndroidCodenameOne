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
	case 'set':
		$query = "UPDATE settings SET ";
		$setting = $_POST['setting'];
		$update = $_POST['update'];
		switch($setting){
		case 'accept':
			$query .= "accept";
			break;
		case 'follow':
			$query .= "follow";
			break;
		case 'like':
			$query .= "like";
			break;
		case 'rechallenge':
			$query .= "rechallenge";
			break;
		case 'comment':
			$query .= "comment";
			break;
		}
		$query .= " = \"" . $update . "\"  WHERE username = \"" . $user . "\";";
		$db->exec($query);
		break;
	case 'getSettings':
		$results = $db->query("SELECT * FROM settings WHERE username = \"" . $user . "\";");
		$results->setFetchMode(PDO::FETCH_ASSOC);
		$settings = $results->fetchAll()[0];
		echo json_encode($settings);
		break;
}

?>

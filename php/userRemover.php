<?php
require 'helper.php';

$username = $_POST['username'];

'Helper'::removeUser($username);

?>

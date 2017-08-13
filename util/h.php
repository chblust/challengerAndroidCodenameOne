<?php
$skhpath = "/var/www/php/skh.txt";

$skhfile = fopen($skhpath, "w");

fwrite($skhfile, hash('sha512',$SK));
fclose($skhfile);
?>

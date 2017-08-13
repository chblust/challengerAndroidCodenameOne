<?php

$SK = "cf016a5b-25a7-4c96-8a38-ae8b6a7af6ba";
$skhpath = "/var/www/php/mskh.txt";

$skhfile = fopen($skhpath, "w");

fwrite($skhfile, hash('sha512',$SK));
fclose($skhfile);
?>

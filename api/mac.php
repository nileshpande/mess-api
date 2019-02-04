<?php

$ip = $_SERVER['REMOTE_ADDR'];
$mac = shell_exec('arp '.$ip.' | awk \'{print $4}\'');

//Working fine when sample client IP is provided...
//$mac = shell_exec('arp -a 192.168.0.107'); 

$findme = "Physical";
$pos = strpos($mac, $findme);
$macp = substr($mac,($pos+42),26);

if(empty($mac))
{
    die("No mac address for $ip not found");
}

// having it
echo "mac address for $ip: $macp";


?>
<?php

$url = "http://pprlhousing.com/api/v1/common/contactus.php";  //The url from where you are getting the contents
$response = (file_get_contents($url)); //Converting in json string
$returndata=json_decode($response,true);
echo $returndata['responce_status_massage'];
?>
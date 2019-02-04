<?php

header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$business_type = $postdata2['business_type'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
		echo "$business_type ".$business_type;
		if("$business_type" == "0"){
			$data = array("status" => true, "responce_status_massage" => "Hello!");
			print json_encode($data);			
		}
	}
?>
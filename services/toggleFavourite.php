<?php
include("../connection.php");
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);
/*
"user_id": "",
"business_type": 3,
"service_provider_id": 1,
"favourite_type": 1
*/
$user_id = $postdata2['user_id'];
$business_type = $postdata2['business_type'];
$service_provider_id = $postdata2['service_provider_id'];
$favourite_type = $postdata2['favourite_type'];
$property_id = $postdata2['favourite_type'];


if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if($favourite_type== 2)
	{
		// request is for property
		$business_type = 0;
		$service_provider_id = 0;
		if(empty($user_id) || empty($property_id))
		{
			$data2 = array("status" => true, "responce_status_massage" => "Invalid Input");
			print json_encode($data2,JSON_NUMERIC_CHECK);
			die();
		}
		$sql_present="Select * from app_user_favorite where `app_user_data_id`='$user_id' and `favorite_type`='$favourite_type' and `property_id`='$property_id'";
	}
	if($favourite_type== 1)
	{
		// request is for service
		$property_id=0;
		if(empty($user_id) || empty($service_provider_id) || empty($business_type))
		{
			$data2 = array("status" => true, "responce_status_massage" => "Invalid Input");
			print json_encode($data2,JSON_NUMERIC_CHECK);
			die();
		}
		$sql_present="Select * from app_user_favorite where `app_user_data_id`='$user_id' and `favorite_type`='$favourite_type' and `business_type`='$business_type' and `sp_id`='$service_provider_id'";
	} 
	
	$sect_present = $conn->query($sql_present);
	if ($sect_present->num_rows) 
	{
		$row = $sect_present->fetch_assoc();
		$fid=$row['id'];
		$sql_delete="DELETE FROM `app_user_favorite` WHERE `id`=$fid";
		$sql_delete_done = $conn->query($sql_delete);
		if($sql_delete_done)
		{
			$data2 = array("status" => true, "responce_status_massage" => "Removed From Favorites");
			print json_encode($data2,JSON_NUMERIC_CHECK);
			die();
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Error Occurred");
			print json_encode($data2,JSON_NUMERIC_CHECK);
			die();
		}
	}
	 
	else
	{
		$sql_select ="INSERT INTO app_user_favorite (`app_user_data_id`, `business_type`, `sp_id`, `favorite_type`, `property_id`) VALUES ('$user_id','$business_type','$service_provider_id','$favourite_type','$property_id')";
		
		$select_data_j = $conn->query($sql_select); 
		
		if($select_data_j)
		{
			$data2 = array("status" => true, "responce_status_massage" => "Marked As favourite!","favourite_type"=> $favourite_type);
			print json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Failed to Marked As favourite!","favourite_type"=> $favourite_type);
			print json_encode($data2,JSON_NUMERIC_CHECK);
		}
	}
}
else
{
	$data2 = array("status" => true, "responce_status_massage" => "No Input");
	print json_encode($data2,JSON_NUMERIC_CHECK);
}
?>
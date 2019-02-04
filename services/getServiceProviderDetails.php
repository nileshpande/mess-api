<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$business_type = $postdata2['business_type'];
	$service_provider_id = $postdata2['service_provider_id'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
	
	if(!empty($business_type))
	{
	// stricktly check post value SERVICE_PROVIDER value 100%
	if($business_type==3)
	{
		$sql_select = "select `service_provider_id`, `cp_id`, `sp_url`, `source`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `country`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `std_code`, `office_telephone`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `users_details` from tbl_service_provider1 where is_active = 1 and `service_provider_id` = '$service_provider_id' and `Is_paid` = 1 and `is_expired` = 0";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$business_type;
			$data[] = $row;	
		}
		if (!empty($data))
		{ 
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found", "business_type" => $business_type , "data"=> $data);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
			echo json_encode($data2);
		}		
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "Something went wrong!");
		echo json_encode($data);
	}
	}
	// stricktly check post value MERCHANT value 100%
	else if($business_type==2)
	{
		$sql_select = "select `service_provider_id`, `cp_id`, `sp_url`, `source`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `country`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `std_code`, `office_telephone`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `users_details` from tbl_merchant1 where is_active = 1 and `service_provider_id` = '$service_provider_id' and `Is_paid` = 1 and `is_expired` = 0";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$business_type;
			$data[] = $row;			
		}
		if (!empty($data))
		{ 
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found","business_type" => $business_type ,"data"=> $data);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
			echo json_encode($data2);
		}		
	}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Something went wrong!");
			echo json_encode($data);
		}
	}
		
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Wrong Input!");
			echo json_encode($data);

		}
		
		
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "INVALID INPUT!");
		echo json_encode($data);
		
	}
	
	
	}
	
	else
	{
		$data = array("status" => false, "responce_status_massage" => "No Input!");
		echo json_encode($data);
		
	}
	
	$conn->close();
?>
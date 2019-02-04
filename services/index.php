<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
	
	$sql_select = "select image,category_id,service_name from tbl_category1 where isactive = 1 order by service_name limit 4";
	
	$select_data = $conn->query($sql_select);
	
	$sql_select2 = "select image,category_id,service_name from tbl_category_merchant1 where isactive = 1 order by service_name limit 4";
	
	$select_data2 = $conn->query($sql_select2);
	
	$sql_select_ser = "SELECT `service_provider_id`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `lag`, `lat`, `is_active` FROM `tbl_service_provider1` where is_top = 1 and is_paid = 1 and is_active = 1 limit 4";
	
	$select_data_ser = $conn->query($sql_select_ser);
	
	$sql_select_mer = "SELECT `service_provider_id`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `lag`, `lat`, `is_active` FROM `tbl_merchant1` where is_top = 1 and is_paid = 1 and is_active = 1 limit 4";
	
	$select_data_mer = $conn->query($sql_select_mer);
	
	
	if($select_data and $select_data2)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$image=substr($row[image], strrpos($row[image], '/') + 1);
			if($image=="")
			{
				$row[image]="images/no-image1.jpg";
			}
			if($row[image]== "")
			{
				$row[image]="images/no-image1.jpg";
			}
			$row["business_type"]=3;
			$data[] = $row;			
		}
		while($row2 = $select_data2->fetch_assoc())
		{
			$image=substr($row2[image], strrpos($row2[image], '/') + 1);
			if($image=="")
			{
				$row2[image]="images/no-image1.jpg";
			}
			if($row2[image]== "")
			{
				$row2[image]="images/no-image1.jpg";
			}
			$row2["business_type"]=2;
			$data2[] = $row2;			
		}
		
		while($row_ser = $select_data_ser->fetch_assoc())
		{
			
			$image=substr($row_ser[profile_pic1], strrpos($row_ser[profile_pic1], '/') + 1);
			if(($image==""))
			{
				$row_ser[profile_pic1]="images/no-image1.jpg";
			}
			if($row_ser[profile_pic1]== "")
			{
				$row_ser[profile_pic1]="images/no-image1.jpg";
			}
			$data_ser[] = $row_ser;	
				
		}
		while($row_mer = $select_data_mer->fetch_assoc())
		{
			$image=substr($row_mer[profile_pic1], strrpos($row_mer[profile_pic1], '/') + 1);
			if(($image=="") || ($row_mer[profile_pic1] =="" ))
			{
				$row_mer[profile_pic1]="images/no-image1.jpg";
			}
			if($row_mer[profile_pic1]== "")
			{
				$row_mer[profile_pic1]="images/no-image1.jpg";
			}
			$data_mer[] = $row_mer;			
		}
		if ((!empty($data)) and (!empty($data2)))
		{ 
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found","banner_url" => "http://pprlhousing.com/images/app_service.jpg", "top_service_categories" => $data ,"top_merchant_categories" => $data2, "top_service_providers" => $data_ser ,"top_merchants" => $data_mer);
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
	$conn->close();
?>
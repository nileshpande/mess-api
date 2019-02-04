<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$input_req = $postdata2['input_req'];
	$state_id = $postdata2['state_id'];
	$dist_id = $postdata2['dist_id'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if($input_req=="state")
		{
			/* $state = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Lakshadweep","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Orissa","Pondicherry","Punjab","Rajasthan","Sikkim","Tamil Nadu","Tripura","Uttar Pradesh","Uttaranchal","West Bengal"); */
			
			$state = array("Maharashtra");
			
			$data = array("status" => true, "responce_status_massage" => "States are!", "data" => $state);
			echo json_encode($data);
		}
		else if($input_req== "district")
		{
			$sql_select = "select district_id,district_name from tbl_district where state='".$state_id."'";
			$select_data = $conn->query($sql_select);
			if($select_data)
			{	
				while($row = $select_data->fetch_assoc())
				{
					$distid=$row['district_id'];
					$name=$row['district_name'];

					$data2["id"]=$distid.':'.$name;
					$data2["name"]=$name;
					$data[] = $data2;			
				}
			if (!empty($data))
			{ 
				$data = array("status" => true, "responce_status_massage" => "All Disctricts!", "data" => $data);
				echo json_encode($data);
			}
			else
			{
				$data = array("status" => false, "responce_status_massage" => "Error occured!");
				echo json_encode($data);
			}
			}
			else
			{
				$data = array("status" => false, "responce_status_massage" => "Error occured!");
				echo json_encode($data);
			}
		}
		else if($input_req== "taluka")
		{
			$taluka=explode(':',$dist_id);
			$taluka_id=$taluka[0];
			$taluka_name=$taluka[1];
		
			$sql_select = "select * from tbl_taluka where district_id='".$taluka_id."'";
			$select_data = $conn->query($sql_select);
			if($select_data)
			{	
				while($row = $select_data->fetch_assoc())
				{
					$talid=$row['taluka_id'];
					$name=$row['taluka_name'];

					$data2["id"]=$talid.':'.$name;
					$data2["name"]=$name;
					$data[] = $data2;			
				}
			if (!empty($data))
			{ 
				$data = array("status" => true, "responce_status_massage" => "All Talukas!", "data" => $data);
				echo json_encode($data);
			}
			else
			{
				$data = array("status" => false, "responce_status_massage" => "No Data!");
				echo json_encode($data);
			}
			}
			else
			{
				$data = array("status" => false, "responce_status_massage" => "Error occured!");
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
		$data = array("status" => false, "responce_status_massage" => "No Input!");
		echo json_encode($data);
	}
	
	$conn->close();
?>
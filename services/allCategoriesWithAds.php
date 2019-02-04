<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$checkreq = $postdata2['business_type'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
	
	if(!empty($checkreq))
	{
	// stricktly check post value SERVICE_PROVIDER value 100%
	if($checkreq==3)
	{
		$sql_select = "select image,category_id,service_name from tbl_category1 where isactive = 1 order by service_name";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		$result_add =  $conn->query("select image from advertisement_table where active_status = 1");
	  
		while($row_add = $result_add->fetch_array())
		{
			$add_data[image] = $row_add[image];
			$add_data["ui_type"]="ADD";
		}
		$countersp=1;
		$counter=1;
		$add_counter=0;
		$rowcountsp=mysqli_num_rows($select_data);
		$select_data = $conn->query($sql_select);
		while($counter <= $rowcountsp)
		{
			if(($counter%5)==0)
			{
				$data[]=$add_data;
				$add_counter++;
			}
			else
			{
				
				$row = mysqli_fetch_assoc($select_data);
				$row["business_type"]=$checkreq;
				$data[] = $row;
			}
			if($add_counter==1)
			{
				$rowcountsp=$rowcountsp+$add_counter;
				$add_counter=0;
			}
			$counter++;
			
		}
		if (!empty($data))
		{ 
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found", "business_type" => $checkreq , "data"=> $data);
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
	else if($checkreq==2)
	{
		$sql_select = "select image,category_id,service_name from tbl_category_merchant1 where isactive = 1 order by service_name";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		
	  $result_add =  $conn->query("select image from advertisement_table where active_status = 1");
	  
		while($row_add = $result_add->fetch_array())
		{
			$add_data[image] = $row_add[image];
			$add_data["ui_type"]="ADD";
		}
		$countersp=1;
		$counter=1;
		$add_counter=0;
		$rowcountsp=mysqli_num_rows($select_data);
		$select_data = $conn->query($sql_select);
		while($counter <= $rowcountsp)
		{
			if(($counter%5)==0)
			{
				$data[]=$add_data;
				$add_counter++;
			}
			else
			{
				
				$row = mysqli_fetch_assoc($select_data);
				$row["business_type"]=$checkreq;
				$data[] = $row;
			}
			if($add_counter==1)
			{
				$rowcountsp=$rowcountsp+$add_counter;
				$add_counter=0;
			}
			$counter++;
			
		}
		if (!empty($data))
		{ 
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found","business_type" => $checkreq ,"data"=> $data);
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
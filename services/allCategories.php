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
	if($checkreq== 3)
	{
		$sql_select = "select image,category_id,service_name from tbl_category1 where isactive = 1 order by service_name";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$checkreq;
			$image=substr($row[image], strrpos($row[image], '/') + 1);
			if($image=="")
			{
				$row[image]="images/no-image1.jpg";
			}
			if($row[image]== "")
			{
				$row[image]="images/no-image1.jpg";
			}
			$data[] = $row;
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
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$checkreq;
			$image=substr($row[image], strrpos($row[image], '/') + 1);
			if($image=="")
			{
				$row[image]="images/no-image1.jpg";
			}
			if($row[image]== "")
			{
				$row[image]="images/no-image1.jpg";
			}
			$data[] = $row;			
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
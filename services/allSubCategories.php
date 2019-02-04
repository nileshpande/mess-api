<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$checkreq = $postdata2['business_type'];
	$checkreq_id = $postdata2['category_id'];
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
	
	if(!empty($checkreq))
	{
	// stricktly check post value SERVICE_PROVIDER value 100%
	if($checkreq== 3)
	{
		$sql_select = "select subcategory_id,category_id,subservice_name,image from tbl_subcategory1 where category_id = '$checkreq_id' and isactive = '1'";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$checkreq;
			$data[] = $row;			
		}
		if (!empty($data))
		{ 
			$sql_select2 = "select `service_name` from tbl_category1 where isactive = 1 and 1 and `category_id` = '$checkreq_id'";
			$select_data2 = $conn->query($sql_select2);
			$row2 = mysqli_fetch_row($select_data2);
			$catname=$row2[0];
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found", "business_type" => $checkreq ,"category_id" => $checkreq_id ,"category_name" => $catname , "data"=> $data);
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
	else if($checkreq== 2)
	{
		$sql_select = "select subcategory_id,category_id,subservice_name,image from tbl_subcategory_merchant1 where category_id = '$checkreq_id' and isactive = '1'";
	
	$select_data = $conn->query($sql_select);
	if($select_data)
	{	
		while($row = $select_data->fetch_assoc())
		{
			$row["business_type"]=$checkreq;
			$data[] = $row;			
		}
		if (!empty($data))
		{ 
			$sql_select2 = "select `service_name` from tbl_category_merchant1 where isactive = 1 and `category_id` = '$checkreq_id'";
			$select_data2 = $conn->query($sql_select2);
			$row2 = mysqli_fetch_row($select_data2);
			$catname=$row2[0];
			
			$data2 = array("status" => true, "responce_status_massage" => "Data Found", "business_type" => $checkreq ,"category_id" => $checkreq_id ,"category_name" => $catname , "data"=> $data);
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
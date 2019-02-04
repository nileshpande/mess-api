<?php
include_once('connection.php');
header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$service_category_query = $postdata2['service_category_query'];
	
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{	
		$service_category_query=$_GET['service_category_query'];
		if($service_category_query!= "")
		{
			$sql_select="SELECT service_name FROM category_search WHERE service_name LIKE '%".$service_category_query."%' ORDER BY service_name ASC LIMIT 7";
			$select_data = $conn->query($sql_select);
			if($select_data)
			{	
				$data = array();
	 
				while($row = mysqli_fetch_assoc($select_data))
				{
					$data[] = $row;
				}
				if (!empty($data))
				{ 
			
					$data2 = array("status" => true, "responce_status_massage" => "Data Found","data"=> $data);
					print json_encode($data2,JSON_NUMERIC_CHECK);
					
				}
				else
				{
					$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
					print json_encode($data2);
				}
			}
		}
		else
		{
			$data = array("status" => false);
			print json_encode($data);
		}
						
		
	}
?>
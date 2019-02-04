<?php
include_once('connection.php');
header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	
	$location_query = $postdata2['location_query'];
	
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{	
		$location_query=$_GET['location_query'];
		if($location_query!= "")
		{
			$sql_select="SELECT taluka_name FROM tbl_taluka WHERE taluka_name LIKE '%".$location_query."%' ORDER BY taluka_name ASC LIMIT 5";
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
<?php 
include("include-files/connection.php");
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

$checkreq = $postdata2['business_type'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$date= date('Y-m-d');
			
	$sqlist="SELECT COUNT(*) FROM `student` WHERE deactivated = 0";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	$row = $sql_result->fetch_row();
	$countmembers = $row[0];
	$countmembers--;
	$data[] = $countmembers;
	
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
	$data = array("status" => false, "responce_status_massage" => "Invalid method");
	echo json_encode($data);
}
$conn->close();
?>
<?php 
include("include-files/connection.php");

header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 

$postdata2=json_decode($postdata,true);



if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$date= date('Y-m-d');
	
	
	// This file here decode JWT token then return status of key 
	// and gives data responce.
	
	require_once 'jwtdecode.php';
	
	
	
	$sqlist="SELECT * FROM `student`";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	
	$row=$sql_result->fetch_assoc();
	
	while($row=$sql_result->fetch_assoc())
	{
		$data[] = $row;
	}
	
	if (!empty($data))
	{ 
		
		$data2 = array("status" => true, "responce_status_massage" => "Data Found",   "data"=> $data);
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
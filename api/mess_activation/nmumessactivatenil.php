<?php
include("connection.php");


if($_GET['mobile'] != "" and $_GET['key'] != "")
{
	$mobile=$_GET['mobile'];
	$key=$_GET['key'];
	$validity=$_GET['validity'];
	$product_version=$_GET['product_version'];
	
	$sql="SELECT * FROM `active_users` WHERE mobile = '$mobile' and valid_key = '$key' and paid = '1' and validity = '$validity' and product_version = '$product_version'";
	$sql_result = $conn->query($sql);
	$row = $sql_result->fetch_row();
	$countmembers = $row[0];
	
	if($countmembers==0)
	{
		$data2 = array("status" => false, "responce_status_massage" => "Wrong Input");
		print json_encode($data2,JSON_NUMERIC_CHECK);
		die();
	}
	else
	{ }
	$sql_result = $conn->query($sql);
	$row = $sql_result->fetch_assoc();
	
	$data=$row;
	
	if($row['max_system']<=0)
	{
		$data2 = array("status" => false, "responce_status_massage" => "Max system limit finished");
		print json_encode($data2,JSON_NUMERIC_CHECK);
		die();
	}
	else
	{ }
	
	
	$data2 = array("status" => true, "responce_status_massage" => "Data Found","data"=> $data);
	$maxsystem=$row['max_system']-1;
	
	$sqlupdatedata="UPDATE `active_users` SET `max_system`= '$maxsystem' WHERE mobile = '$mobile' and valid_key = '$key' and paid = '1' and validity = '$validity' and product_version = '$product_version'";
	$sql_result = $conn->query($sqlupdatedata);
	
	print json_encode($data2,JSON_NUMERIC_CHECK);
}
else
{
	$data2 = array("status" => false, "responce_status_massage" => "Wrong Input");
	print json_encode($data2,JSON_NUMERIC_CHECK);
}
?>
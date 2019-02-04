<?php 
include("include-files/connection.php");

header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 

$postdata2=json_decode($postdata,true);

$reg_id = $postdata2['reg_id'];

if(isset($postdata2['submit']) and isset($postdata2['startdate']))
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($postdata2['regno']) and ($postdata2['regno']!=""))
	{
		$regno = $postdata2['regno'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['startdate']) and ($postdata2['startdate']!=""))
	{
		$startdate = $postdata2['startdate'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['enddate']) and ($postdata2['enddate']!=""))
	{
		$enddate = $postdata2['enddate'];	
		if($get_lost == false)
		{
			$date2=date_create($startdate);
			$date1=date_create($enddate);
			$diff=date_diff($date2,$date1);
			$total_khade_demand = $diff->days;
			$total_khade_demand++;
			echo $total_khade_demand;
			
		}
		if($date >= $startdate or $date >= $enddate or $total_khade_demand < 1)
		{
			 $get_lost=true;
		}
	}
	else { $get_lost=true; }	//	required
	
	
	
	if($total_khade_demand > 7)
	{
		$get_lost == true;
	}
	//Checking server side required. By $get_lost .
	
	if($get_lost == true)
	{
		$data = array("status" => false, "responce_status_massage" => "illigal method");
		echo json_encode($data);
	}
	else
	{
		$sql_insert = "INSERT INTO `khada_table`(`reg_id`,`total_khade_demand`,`start_date`,`end_date`,`informed_date`) VALUES ('$regno','$total_khade_demand','$startdate','$enddate','$date')";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		$sp_id= mysqli_insert_id($conn);
		if($sql_inse)
		{
			$data = array("status" => true, "responce_status_massage" => "Success");
			echo json_encode($data);
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Failed Try Again");
			echo json_encode($data);
		}
	}
}
else
{
	$data = array("status" => false, "responce_status_massage" => "Invalid method");
	echo json_encode($data);
}
$conn->close();
?>
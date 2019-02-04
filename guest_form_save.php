<?php 
include("include-files/connection.php");

header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 

$postdata2=json_decode($postdata,true);

$reg_id = $postdata2['reg_id'];

if(isset($_POST['submit']) and isset($_POST['name']))
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($_POST['known']) and ($_POST['known']=="on"))
	{
		$regno = $_POST['regno'];	
		$known=1;
		if(isset($_POST['amount']) and ($_POST['amount']!=""))
		{
			$amount = $_POST['amount'];	
		}
		else 
		{
			$sqlistconf="SELECT * FROM `mess_config`";
			$sql_resultconf = $conn->query($sqlistconf);
			$rowconf = $sql_resultconf->fetch_array();
			$amount = $rowconf['outsider_member_rate'];
			
		}
	}
	else 
	{ 
		$known=0;
		$regno=0; 
		if(isset($_POST['amount']) and ($_POST['amount']!=""))
		{
			$amount = $_POST['amount'];	
		}
		else 
		{
			$sqlistconf="SELECT * FROM `mess_config`";
			$sql_resultconf = $conn->query($sqlistconf);
			$rowconf = $sql_resultconf->fetch_array();
			$amount = $rowconf['outsider_member_rate'];
			
		}	
	}	
	
	if(isset($_POST['name']) and ($_POST['name']!=""))
	{
		$name = $_POST['name'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['shift']) and ($_POST['shift']!=""))
	{
		$shift = $_POST['shift'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['fiest']) and ($_POST['fiest']!=""))
	{
		$fiest = $_POST['fiest'];
	}
	else { $get_lost=true; }	//	required
	
	/*if(isset($_POST['paid']) and ($_POST['paid']!=""))
	{
		$paid = $_POST['paid'];
	}
	else
	{ 
		$paid=0; 
	}	//	required*/
	$paid=1;
	
	//Checking server side required. By $get_lost .
	
	if($get_lost == true)
	{
		$data = array("status" => false, "responce_status_massage" => "Invalid method");
		echo json_encode($data);
	}
	else
	{
		$sql_insert = "INSERT INTO `guest`(`known_unkonwn`, `reg_id`,`name`,`shift`,`normal_feist`,`date`,`paid_status`,`amount`) VALUES ('$known','$regno','$name','$shift','$fiest','$date','$paid','$amount')";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		$sp_id= mysqli_insert_id($conn);
		if($sql_inse)
		{
			$data = array("status" => True, "responce_status_massage" => "Congrats");
			echo json_encode($data);
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Failed Try again");
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
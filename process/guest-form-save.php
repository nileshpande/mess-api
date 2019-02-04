<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);

$amount=0;

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
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		$sql_insert = "INSERT INTO `guest`(`known_unkonwn`, `reg_id`,`name`,`shift`,`normal_feist`,`date`,`paid_status`,`amount`) VALUES ('$known','$regno','$name','$shift','$fiest','$date','$paid','$amount')";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		$sp_id= mysqli_insert_id($conn);
		if($sql_inse)
		{
			header("location:../dashboard.php?msg=Congrats");
		}
		else
		{
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}
}
else
{
	header("location:../dashboard.php?msg=rikame kama kru naye");
}

?>
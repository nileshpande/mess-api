<?php
//------------- choose connection file ------------
session_start();
include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);
$role=$_SESSION['messuser_role'];

if(isset($_POST['loginid']) and isset($_POST['password']) and $role==1)
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	 
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($_POST['name']) and ($_POST['name']!=""))
	{
		$name = $_POST['name'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['contact']) and ($_POST['contact']!=""))
	{
		$contact = $_POST['contact'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['address']) and ($_POST['address']!=""))
	{
		$address = $_POST['address'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['loginid']) and ($_POST['loginid']!=""))
	{
		$loginid = $_POST['loginid'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['password']) and ($_POST['password']!=""))
	{
		$password = $_POST['password'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['role']) and ($_POST['role']!=""))
	{
		$role = $_POST['role'];	
	}
	else { $get_lost=true; }	//	required
	
	//Checking server side required. By $get_lost .
	
	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		
		$sql_insert = "INSERT INTO `authentic_user` (`name`,`contactno`,`address`,`loginid`,`password`,`role`) VALUES ('$name','$contact','$address','$loginid','$password','$role')";
		 
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
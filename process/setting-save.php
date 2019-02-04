<?php
//------------- choose connection file ------------
session_start();
include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);
$role=$_SESSION['messuser_role'];

if(isset($_POST['fiestrate']) and isset($_POST['monthreate']) and $role==1)
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($_POST['fiestrate']) and ($_POST['fiestrate']!=""))
	{
		$fiestrate = $_POST['fiestrate'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['monthreate']) and ($_POST['monthreate']!=""))
	{
		$monthreate = $_POST['monthreate'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['outsiderate']) and ($_POST['outsiderate']!=""))
	{
		$outsiderate = $_POST['outsiderate'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['nashtarate']) and ($_POST['nashtarate']!=""))
	{
		$nashtarate = $_POST['nashtarate'];	
	}
	else { $get_lost=true; }	//	required
	
	//Checking server side required. By $get_lost .
	
	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		$sql_insert = "UPDATE `mess_config` SET monthly_rate = '$monthreate' , feist_rate = '$fiestrate' , 	outsider_member_rate = '$outsiderate' , nashta_rate = '$nashtarate'";
		 
		$sql_inse = $conn->query($sql_insert);
		
		
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
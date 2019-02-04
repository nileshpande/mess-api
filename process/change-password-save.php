<?php
//------------- choose connection file ------------
session_start();
include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);

$userid=$_SESSION['messuserid'];
$userpwd=$_SESSION['messpassword'];

if(isset($_POST['oldpwd']) and isset($_POST['newpwd']))
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($_POST['oldpwd']) and ($_POST['oldpwd']!=""))
	{
		$oldpwd = $_POST['oldpwd'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['newpwd']) and ($_POST['newpwd']!=""))
	{
		$newpwd = $_POST['newpwd'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['cnfpwd']) and ($_POST['cnfpwd']!=""))
	{
		$cnfpwd = $_POST['cnfpwd'];	
	}
	else { $get_lost=true; }	//	required
	
	//Checking server side required. By $get_lost .
	
	
	if(($userpwd==$oldpwd) and ($oldpwd!=$newpwd) and ($cnfpwd==$newpwd))
	{
		
	}
	else
	{
		
		$get_lost=true;
	}
	
	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		$sql_insert = "UPDATE `authentic_user` SET password = '$newpwd' WHERE  password = '$userpwd' and loginid = '$userid'";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		$sp_id= mysqli_insert_id($conn);
		
		if($sql_inse)
		{
			unset($_SESSION['messusername']);
			unset($_SESSION['messpassword']);
			unset($_SESSION['messuser_role']);
			if(!isset($_SESSION['messusername']) && !isset($_SESSION['messpassword']) && !isset($_SESSION['messuser_role']))
			{		
				header("location:../index.php?msg=password changed. Please login.");
			}
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
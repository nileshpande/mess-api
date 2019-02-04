<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);
// [nashtastarttime] => 15:02 [nashtaendtime] => 15:02 [lunchstarttime] => 15:02 [lunchendtime] => 15:02 [dinnerstarttime] => 15:02 [dinnerendtime] => 15:02 )

// Preparation of all input data $get_lost will be true.
//if any serverside required validation fails.

$get_lost=false;

if(!empty($_POST['nashtastarttime']))
{
	$nashtastarttime = $_POST['nashtastarttime'];	
}
else { $get_lost=true; }	//	required

if(!empty($_POST['nashtaendtime']))
{
	$nashtaendtime = $_POST['nashtaendtime'];	
}
else { $get_lost=true; }	//	required

if(!empty($_POST['lunchstarttime']))
{
	$lunchstarttime = $_POST['lunchstarttime'];	
}
else { $get_lost=true; }	//	required

if(!empty($_POST['lunchendtime']))
{
	$lunchendtime = $_POST['lunchendtime'];	
}
else { $get_lost=true; }	//	required

if(!empty($_POST['dinnerstarttime']))
{
	$dinnerstarttime = $_POST['dinnerstarttime'];	
}
else { $get_lost=true; }	//	required

if(!empty($_POST['dinnerendtime']))
{
	$dinnerendtime = $_POST['dinnerendtime'];
	
}
else { $get_lost=true; }	//	required

	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=असफल. पुन्हा प्रयत्न करा");
	}
	else
	{
		$sql_insert = "UPDATE `mess_config` SET nashtastarttime = '$nashtastarttime' , nashtaendtime = '$nashtaendtime' , 	lunchstarttime = '$lunchstarttime' , lunchendtime = '$lunchendtime' , dinnerstarttime = '$dinnerstarttime' , 	dinnerendtime = '$dinnerendtime'";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		
		if($sql_inse)
		{
			header("location:logout.php");
		}
		else
		{
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}



?>
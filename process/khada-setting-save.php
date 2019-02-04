<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);

// Preparation of all input data $get_lost will be true.
//if any serverside required validation fails.

$get_lost=false;

if(!empty($_POST['noofkhada']))
{
	$noofkhada = $_POST['noofkhada'];	
}
else { $get_lost=true; }	//	required



	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=असफल. पुन्हा प्रयत्न करा");
	}
	else
	{
		$sql_insert = "UPDATE `mess_config` SET khada_limit = '$noofkhada' ";
		 
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		
		if($sql_inse)
		{
			header("location:../dashboard.php?msg=Congrats");
		}
		else
		{
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}



?>
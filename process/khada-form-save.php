<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);


if(isset($_POST['submit']) and isset($_POST['startdate']))
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	$date=date('Y-m-d');
	
	if(isset($_POST['regno']) and ($_POST['regno']!=""))
	{
		$regno = $_POST['regno'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['startdate']) and ($_POST['startdate']!=""))
	{
		$startdate = $_POST['startdate'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['enddate']) and ($_POST['enddate']!=""))
	{
		$enddate = $_POST['enddate'];	
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
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		$sql_insert = "INSERT INTO `khada_table`(`reg_id`,`total_khade_demand`,`start_date`,`end_date`,`informed_date`) VALUES ('$regno','$total_khade_demand','$startdate','$enddate','$date')";
		 
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
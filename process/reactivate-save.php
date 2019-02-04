<?php
include("../include-files/connection.php");
$date=date('Y-m-d'); 
$get_lost = false;
if(isset($_POST['memberid']))
{
	if(isset($_POST['memberid']) and ($_POST['memberid']!=""))
	{
		$memberid = $_POST['memberid'];	
	}
	else { $get_lost=true;  }	//	required
	
	
	
	if($get_lost==true)
	{
		header("location:../dashboard.php?msg=Failed");
	}
	else
	{
		$sql_upd = "UPDATE `student` SET deactivated = '0' , update_date = '$date'  WHERE reg_id = '$memberid'";
		
		$sql_upd_acc = "UPDATE `account_status` SET closed = '0'   WHERE reg_id = '$memberid'";
		
		$sql_updated = $conn->query($sql_upd);
		
		$sql_updated_acc = $conn->query($sql_upd_acc);
		
		$sql_status_tbl="INSERT INTO `active_deactivate` (`reg_id`,`date`,`status`,`amount`,`paid`) values('$memberid','$date','2','0','0')";
		$sql_updated_status_tbl = $conn->query($sql_status_tbl);
		
		if($sql_updated)
		{
			header("location:../dashboard.php?msg=Activated.");		
		}
		else
		{
			header("location:../dashboard.php?msg=Failed to update");
		}
		

	}
}
else
{
	header("location:../dashboard.php?msg=Failed to update2");
}
?>
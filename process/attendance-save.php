<?php 
include("../include-files/connection.php");

if(isset($_POST['reg_id']) and $_POST['reg_id']!="" )
{
	$reg_id=$_POST['reg_id'];
	$rowcount=0;
	$sqlist="SELECT COUNT(*) FROM `student` WHERE reg_id = '$reg_id'";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	$row = $sql_result->fetch_row();
	$rowcount = $row[0];
}
else
{
	$rowcount=0;	
}

if($rowcount>0)
{
	$date=date('Y-m-d'); 
	$month=date('m');
	$year=date('Y');
	$day = date('l', strtotime($date));
	$present_status=1;
	
	$timezone = new DateTimeZone("Asia/Kolkata" );
	$date2 = new DateTime();
	$date2->setTimezone($timezone );
	$time = (string)$date2->format( 'H:i:s' );  
	
	//Check double bhukkad thali.
	
	$sqtime="SELECT * FROM `mess_config`";
	$sql_result_time = $conn->query($sqtime)or die(mysqli_error($conn));
	$row_time = $sql_result_time->fetch_assoc();
	
	$nashtastarttime=$row_time['nashtastarttime'];
	$nashtaendtime=$row_time['nashtaendtime']; 
	$lunchstarttime=$row_time['lunchstarttime'];
	$lunchendtime=$row_time['lunchendtime']; 
	$dinnerstarttime=$row_time['dinnerstarttime'];
	$dinnerendtime=$row_time['dinnerendtime'];
	
	$currentstart=0;
	$currentend=0;
	$shift_time=0;
	if(($time>$row_time['nashtastarttime']) and ($time<$row_time['nashtaendtime']))
	{ $currentstart=$row_time['nashtastarttime'];  $currentend = $row_time['nashtaendtime']; $shift_time=1; }
	else if(($time>$row_time['lunchstarttime']) and ($time<$row_time['lunchendtime']))
	{ $currentstart=$row_time['lunchstarttime'];  $currentend = $row_time['lunchendtime']; $shift_time=2; }
	else if(($time>$row_time['dinnerstarttime']) and ($time<$row_time['dinnerendtime']))
	{ $currentstart=$row_time['dinnerstarttime'];  $currentend = $row_time['dinnerendtime']; $shift_time=3; }
	else
	{ $currentstart=0;  $currentend = 0; }
	
	$bhukkadcount=0;
	$sqbhukkad="SELECT COUNT(*) FROM `attendance` WHERE reg_id_student = '$reg_id' and time > '$currentstart' and time < '$currentend' and date = '$date'";
	$sql_result_b = $conn->query($sqbhukkad)or die(mysqli_error($conn));
	$rowbhukkad = $sql_result_b->fetch_row();
	$bhukkadcount = $rowbhukkad[0];
	
	if($bhukkadcount>0)
	{
		echo "double";
		die();
	}
	else
	{
		
		$sqlist="INSERT INTO `attendance` (`reg_id_student`,`date`,`time`,`present_status`,`day`,`month`,`year`,`shift_time`) VALUES ('$reg_id','$date','$time','$present_status','$day','$month','$year','$shift_time')";
		
		$sql_result = $conn->query($sqlist);
		if($sql_result==1)
		{
			echo "success";
		}
		else
		{
			echo "fail";
		}
	}
	
}
else
{
	echo "fail";
}
?>

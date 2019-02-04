<?php
session_start();
include("../include-files/connection.php");
$todaydate=date("Y-m-d");

///   Type of job check greater than 1 . 1 Is only for session type 2 and 3 are for bill and db backup.

$sqlcronjob="SELECT * FROM `cron_and_status` WHERE date <= '$todaydate' and type_of_ob > '1' and complete = '0'";
$sql_resulcronjob = $conn->query($sqlcronjob);
	
$countcronjob=mysqli_num_rows($sql_resulcronjob);

if($countcronjob>0)
{
	$workdone=false;
	while($rowcronjob = $sql_resulcronjob->fetch_array())
	{
		if($rowcronjob['type_of_ob']==2)
		{
			 
			include("bill-generator-monthly.php");
			if($countbills>0)
			{
				$workdone=true;
				$updtebillid=$rowcronjob['id'];
				$sql_bill="UPDATE `cron_and_status` SET `complete`='1'  WHERE id = '$updtebillid'";
				$sql_acc = $conn->query($sql_bill);
				
				$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m")+1, 1));  /////  This only for next month 
				
				$sql_bill_cron="INSERT INTO `cron_and_status` (`type_of_ob`,`date`,`time`) VALUES('2','$first_day_this_month','08:00')";
				$sql_cron = $conn->query($sql_bill_cron);
				
			}
			else
			{
				$workdone=false;
			}
			
		}
		else if($rowcronjob['type_of_ob']==3)
		{
			include("db-backup-cron.php");
			$dbdone = backup_tables('localhost','root','','mymess');
			if($dbdone==true)
			{
				$workdone=true;
				$updtedbid=$rowcronjob['id'];
				$sql_db="UPDATE `cron_and_status` SET `complete`='1'  WHERE id = '$updtedbid'";
				$sql_acc = $conn->query($sql_db);
				
				$nextdate=date( "Y-m-d", strtotime( "$todaydate +7 day" ) );
				
				$sql_db_cron="INSERT INTO `cron_and_status` (`type_of_ob`,`date`,`time`) VALUES('3','$nextdate','08:00')";
				$sql_cron = $conn->query($sql_db_cron);
				
				
			}
			else
			{
				$workdone=false;
			}
		}
		else
		{
			
		}
	}
	/* echo $sql_bill_cron."-".$sql_db_cron;
	die(); */
	if($workdone==true)
	{
		echo "<script>window.location.replace('../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे. Data processing done.');</script>";
		/* header("location:../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे. Data processing done."); */
	}
	else
	{
		echo "<script>window.location.replace('../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे. Some data not processed.');</script>";
		/* header("location:../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे. Some data not processed."); */
	}
}
else
{
	echo "<script>window.location.replace('../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे');</script>";
	/* header("location:../dashboard.php?msg=सॉफ्टवेअर मधे आपले स्वागत आहे"); */
}
?>
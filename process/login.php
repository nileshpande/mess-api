<?php
session_start();
include("include-files/connection.php");
$gastroscopic="include-files/ulgenosyscal/sys-pneumonoultramicroscopicsilicovolcanoconiosis-gem.php";
include($gastroscopic);

/**** Already Login part   ***********/

if(isset($_SESSION['messuserid']) && isset($_SESSION['messpassword']) && isset($_SESSION['messuser_role']))
{	
	echo "<script>window.location.replace('../dashboard.php?msg=already Logged In.');</script>";
}
else { 	}

if(isset($_POST['login']))
{
	/************** geting mac availble is vernarable. so changed plan for activation o fsoftware************/
	/*
	$getmac = exec('getmac');
	$getmac = substr($getmac, 0, 17);
	/* $getmac = substr($getmac, 0, strpos($getmac, "\Device" ));
	$getmac = str_replace(' ', '', $getmac);
	 */
	 
	$getmac = execnil(9673);
	
	$loginid=$_POST['loginid'];
	$password=$_POST['password'];
	
	$sql = "SELECT * FROM authentic_user WHERE loginid = '$loginid' and password = '$password'";
	$result =$conn->query($sql)or trigger_error(mysql_error());
	
	$row =mysqli_fetch_array($result);
	
	$count = mysqli_num_rows($result);
	$_SESSION['messuserid']=$row['loginid'];
	$_SESSION['messpassword']=$password;
	$_SESSION['messuser_role']=$row['role'];
	$user_role=$_SESSION['messuser_role'];
	if($count == 1) 
	{
		
		if($user_role==0)
		{
			unset($_SESSION['messuserid']);
			unset($_SESSION['messpassword']);
			unset($_SESSION['messuser_role']);
			echo "<script>window.location.replace('../index.php?msg=नियमाचे उल्लंघन करू नका');</script>";
		}
		else
		{
			$mess_config = "SELECT * FROM mess_config WHERE system_key = '$getmac'";
			$resultconfig =$conn->query($mess_config)or trigger_error(mysql_error());
			$rowconfig =mysqli_fetch_array($resultconfig);
			$countconfig = mysqli_num_rows($resultconfig);		
			if($countconfig == 1) 
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
	
				$sqtime="SELECT * FROM `mess_config`";
				$sql_result_time = $conn->query($sqtime);
				$row = $sql_result_time->fetch_assoc();
				
				$nashtastarttime=$row['nashtastarttime'];
				$nashtaendtime=$row['nashtaendtime']; 
				$lunchstarttime=$row['lunchstarttime'];
				$lunchendtime=$row['lunchendtime']; 
				$dinnerstarttime=$row['dinnerstarttime'];
				$dinnerendtime=$row['dinnerendtime'];
				
				$currentstart=0;
				$currentend=0;
				if(($time>$row['nashtastarttime']) and ($time<$row['nashtaendtime']))
				{ $currentstart=$row['nashtastarttime'];  $currentend = $row['nashtaendtime']; }
				else if(($time>$row['lunchstarttime']) and ($time<$row['lunchendtime']))
				{ $currentstart=$row['lunchstarttime'];  $currentend = $row['lunchendtime']; }
				else if(($time>$row['dinnerstarttime']) and ($time<$row['dinnerendtime']))
				{ $currentstart=$row['dinnerstarttime'];  $currentend = $row['dinnerendtime']; }
				else
				{ $currentstart=0;  $currentend = 0; }
			
				$_SESSION['currentstart']=$currentstart;
				$_SESSION['currentend']=$currentend;
				$_SESSION['orgname']=$rowconfig['organization_name'];
				
				///************************************************************************************     
				//Auto operation during login process. Bill Generation monthly here ***////
				
				echo "<script>window.location.replace('../cronjobs/cron-job-check.php');</script>";
				/* header("location:../cronjobs/cron-job-check.php"); */
				
				//// **********************************************************************************
				//This code will generate croon operation output and then redirect to home page.
			}
			else
			{
				unset($_SESSION['messuserid']);
				unset($_SESSION['messpassword']);
				unset($_SESSION['messuser_role']);
				echo "<script>window.location.replace('../register.php?msg=कृपया सॉफ्टवेर आक्टीवेट करण्यासाठी NP Solutions ला संपर्क साधा');</script>";
				/* header("location:../register.php?msg=कृपया सॉफ्टवेर आक्टीवेट करण्यासाठी NP Solutions ला संपर्क साधा"); */
			}
		}
		  
	}
	else
	{
		$mess_config = "SELECT * FROM mess_config WHERE system_key = '$getmac'";
		$resultconfig =$conn->query($mess_config)or trigger_error(mysql_error());
		$rowconfig =mysqli_fetch_array($resultconfig);
		$countconfig = mysqli_num_rows($resultconfig);		
		if($countconfig == 1) 
		{	
			echo "<script>window.location.replace('../index.php?msg=पासवर्ड किंवा आयडी चुकले आहे');</script>";
			/* header("location: ../index.php?msg=पासवर्ड किंवा आयडी चुकले आहे"); */
		}
		else
		{
			echo "<script>window.location.replace('../register.php?msg=कृपया सॉफ्टवेर आक्टीवेट करण्यासाठी NP Solutions ला संपर्क साधा');</script>";
			/* header("location:../register.php?msg=कृपया सॉफ्टवेर आक्टीवेट करण्यासाठी NP Solutions ला संपर्क साधा"); */
		}
		
		
	}
}
?>
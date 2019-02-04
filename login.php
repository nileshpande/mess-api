<?php 

include("include-files/connection.php");
require_once 'jwtencode.php';

header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

//echo $jwt.'</br>';

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($postdata2['loginid']) && isset($postdata2['password']) )
{
	
$loginid = $postdata2['loginid'];
$password = $postdata2['password'];

$gastroscopic="include-files/ulgenosyscal/sys-pneumonoultramicroscopicsilicovolcanoconiosis-gem.php";
include($gastroscopic);

/**** Already Login part   ***********/



	 
	/************** geting mac availble is vernarable. so changed plan for activation o fsoftware************/
	/*
	$getmac = exec('getmac');
	$getmac = substr($getmac, 0, 17);
	/* $getmac = substr($getmac, 0, strpos($getmac, "\Device" ));
	$getmac = str_replace(' ', '', $getmac);
	 */
	 
	$getmac = execnil(9673);
	
	 
	 
	 
	$sql = "SELECT * FROM authentic_user WHERE loginid = '$loginid' and password = '$password'";
	$result =$conn->query($sql)or trigger_error(mysql_error());
	 
	$row =mysqli_fetch_array($result);
	$user_role=$row['role'];
	$count = mysqli_num_rows($result);
	$data[]=$postdata2;
	if($count == 1) 
	{
		//echo "count1";
		if($user_role==0)
		{
			$data2 = array("status" => false, "responce_status_massage" => "Wrong role"  );
			echo json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$mess_config = "SELECT * FROM mess_config WHERE system_key = '$getmac'";
			$resultconfig =$conn->query($mess_config)or trigger_error(mysql_error());
			$rowconfig =mysqli_fetch_array($resultconfig);
			$countconfig = mysqli_num_rows($resultconfig);		
			if($countconfig == 1) 
			{	
				
	
				$sqtime="SELECT * FROM `mess_config`";
				$sql_result_time = $conn->query($sqtime);
				$row = $sql_result_time->fetch_assoc();
				
				
				
				$configdata[]=$row;
				
				///************************************************************************************     
				//Auto operation during login process. Bill Generation monthly here ***////
				
				$data2 = array("status" => true, "responce_status_massage" => "Data Found" ,"token" => $jwt , "data"=> $data , "configdata"=> $configdata);
				echo json_encode($data2,JSON_NUMERIC_CHECK);
				/* header("location:../cronjobs/cron-job-check.php"); */
				
				//// **********************************************************************************
				//This code will generate croon operation output and then redirect to home page.
			}
			else
			{
				$data2 = array("status" => false, "responce_status_massage" => "Non activated software1"  , "data"=> $data);
				echo json_encode($data2,JSON_NUMERIC_CHECK);
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
			$data2 = array("status" => false, "responce_status_massage" => "Invalid Id Password"  , "data"=> $data);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
			/* header("location: ../index.php?msg=पासवर्ड किंवा आयडी चुकले आहे"); */
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Non activated software"  , "data"=> $data);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
			/* header("location:../register.php?msg=कृपया सॉफ्टवेर आक्टीवेट करण्यासाठी NP Solutions ला संपर्क साधा"); */
		}
		
		
	}


}
else
{
	 
	$data = array("status" => false, "responce_status_massage" => "Invalid method");
	echo json_encode($data);
}
$conn->close();
?>
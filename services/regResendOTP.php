<?php 
include_once('../connection.php');
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$business_type = $postdata2['business_type'];
	$regid = $postdata2['regid'];
	if($business_type== "" || $regid== "")
	{
		$data2 = array("status" => false, "responce_status_massage" => "Please give input");
		print json_encode($data2,JSON_NUMERIC_CHECK);
	}
	else
	{
		if($business_type== 2)
		{ $tablename="tbl_merchant1"; } else if($business_type== 3){ $tablename="tbl_service_provider1";  } 
	
		$sql_select ="select `otp`,`mobile`,`email_id` from $tablename where `service_provider_id` = '$regid'";
		$select_data_j = $conn->query($sql_select);
		$rowcount=mysqli_num_rows($select_data_j);
		
		$select_data_j = $conn->query($sql_select);
		if($rowcount >0)
		{
			$row = mysqli_fetch_assoc($select_data_j);
			$otp=$row['otp'];
			$usermobile=$row['mobile'];
			$email=$row['email_id'];
			$user_msg = urlencode("This is your OTP: ".$otp." Please enter this otp for veryfication and ".$regid."  is your registed ID thankyou");
			$adminmobileno = "91".$usermobile;
			 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=98765&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
			
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			
			//otpsend
			$data2 = array("status" => true, "responce_status_massage" => "OTP Resent","business_type" => $business_type, "mobile"=> $usermobile,"email" => $email,"regid" => $regid);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
			
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Wrong Request");
			print json_encode($data2,JSON_NUMERIC_CHECK);
		}
	}
}	
else
{
	$data2 = array("status" => false, "responce_status_massage" => "Please give input");
	print json_encode($data2,JSON_NUMERIC_CHECK);
}	
?>
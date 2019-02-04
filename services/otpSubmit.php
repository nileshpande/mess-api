<?php 
include_once('../connection.php');
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$otp = $postdata2['otp'];
	$regid = $postdata2['regid'];
	$business_type = $postdata2['business_type'];
	$mobile = $postdata2['mobile'];
	$email = $postdata2['email'];
	
	if($otp== "" || $regid== "" || $business_type== "")
	{
		$data2 = array("status" => false, "responce_status_massage" => "Please give input");
		print json_encode($data2,JSON_NUMERIC_CHECK);
	}
	else
	{
			
		if($business_type==2)
		{
			
			$sqlotp  ="UPDATE tbl_merchant1 set verifyotp = 1 WHERE service_provider_id = ".$regid;

			$result_otp=$conn->query($sqlotp)or trigger_error($conn->$result_otp);
			 echo $conn->error;	
			if($result_otp)
			{ $otpverified = 1; } else { $otpverified = 0; }
		
		$sql_how_many="select finall_category from tbl_merchant1 where service_provider_id = '$regid'";
		$reshowpkg =$conn->query($sql_how_many);
		$rowhowpkg=mysqli_fetch_row($reshowpkg);
		$how_many_cat=$rowhowpkg['0'];
		
		}
		if($business_type==3)
		{
			
			$sqlotp  ="UPDATE tbl_service_provider1 set verifyotp = 1 WHERE service_provider_id = ".$regid;

			$result_otp=$conn->query($sqlotp)or trigger_error($conn->$result_otp);
			 echo $conn->error;
			if($result_otp)
			{ $otpverified = 1; } else { $otpverified = 0; }
			
		$sql_how_many="select finall_category from tbl_service_provider1 where service_provider_id = '$regid'";
		$reshowpkg =$conn->query($sql_how_many);
		$rowhowpkg=mysqli_fetch_row($reshowpkg);
		$how_many_cat=$rowhowpkg['0'];
		}
		
		$count_cat = substr_count($how_many_cat, ',');
		
		if($otpverified== 1)
		{
		
			/*"regid": "clf8",
	"business_type":3,
	"mobile":9673129396,
	"email":"np3225@gmail.com"*/
			
			
				$rowotp['regid'] = $regid;
				$rowotp['email'] = $email;
				$rowotp['business_type'] = $business_type;
				$rowotp['mobile'] = $mobile;
				
				$data = $rowotp;
				$data2 = array("status" => true, "responce_status_massage" => "Verified sucessfuly","business_type" => $business_type, "mobile"=> $mobile,"email" => $email,"regid" => $regid);
				echo json_encode($data2,JSON_NUMERIC_CHECK);
			
			
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Wrong OTP");
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
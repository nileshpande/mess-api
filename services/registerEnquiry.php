<?php
include_once('connection.php');
header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	/*
	"user_name": "",
	"user_mobile_no": "",
	"user_email": "",
	"service_provider_id": 1,
	"business_type": 2 for "MERCHANT" 3 for "SERVICE_PROVIDER"
	*/
	$user_name = $postdata2['user_name'];
	$user_mobile_no = $postdata2['user_mobile_no'];
	$user_email = $postdata2['user_email'];
	$service_provider_id = $postdata2['service_provider_id'];
	$business_type = $postdata2['business_type'];
	$error="noerror";
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{	
		if($business_type== 3)
		{$table_name= "tbl_service_provider1";}
		if($business_type== 2)
		{$table_name= "tbl_merchant1";}
	if($user_name=="" || $user_mobile_no=="" || $service_provider_id=="" || $business_type==""){$error="error";}
	if($error=="noerror")
	{
		
		$sql_select="select address,category,sub_category,mobile,shop_name,email_id from `$table_name` where service_provider_id='$service_provider_id'";
		$select_data = $conn->query($sql_select);
		
		if($select_data)
		{	
			$row=$select_data->fetch_array();
			/* $sp_mobile="9673129396"; */ $sp_mobile=$row['mobile']; 
			$sp_shop=$row['shop_name'];
			$sp_email=$row['email_id'];
			$sp_address=$row['address'];
			$sp_category=$row['category'];
			$sp_subcategory=$row['sub_category'];
			$sp_category=str_replace(",","",$sp_category);
			$sp_subcategory=str_replace(",","",$sp_subcategory);
			
			/********Sending SMS & email of paid listed SP & merchants to the visitor******************/
			$user_msg = urlencode("Dear Customer, thanks for visiting PPRLHousing.com find ".$sp_category.",".$sp_subcategory." Services \n 1: ".$sp_shop."\n".$sp_mobile."\n Address:-".$sp_address);
			$adminmobileno = "91".$user_mobile_no;/* $adminmobileno = "91".$user_mobile_no; */
			
			$usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=98765&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
				
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
			
			//Sending Visitor Contact details to SP& Merchants
				 
				 
			$user_msg = urlencode("Dear Service Provider, ".$user_name." is looking for  ".$sp_category.",".$sp_subcategory."  Services \n Contact Details:
			Mob-".$user_mobile_no." \n Email-".$user_email." ");
			/* $adminmobileno = "919673129396"; */  $adminmobileno = "91".$sp_mobile; 
			
			 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=98765&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_exec($ch);
				 
			
				$data2 = array("status" => true, "responce_status_massage" => "Thank you");
				print json_encode($data2,JSON_NUMERIC_CHECK);
				
			
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
			print json_encode($data2);
		}
	}				
	else
	{
		$data2 = array("status" => false, "responce_status_massage" => "Enter Required Data!");
		print json_encode($data2);
	}
	}
?>
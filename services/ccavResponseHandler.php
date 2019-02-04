<?php 
include("../connection.php"); 
include('Crypto.php'); 


	error_reporting(0);
 
 	$working_key='7AA7103C59760F217D3E96EC51A4ABD8';	//Working Key should be provided here.
	$encResponse=$_POST["encResp"];	
//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$working_key);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);

	
	
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	

	
	$order_id=""; $tracking_id=""; $bank_ref_no=""; $payment_mode_card=""; $card_name=""; $card_amount="";$billing_name="";$billing_address="";$regid="";$temp_id="";$order_status =""; $status_message="";$days=""; $package=""; $page_name ='';
	
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		
	   // echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
		if($i==0){	$order_id = $information[1]; }
		if($i==1){	$tracking_id = $information[1]; }
		if($i==2){	$bank_ref_no = $information[1]; }
		if($i==3){	$order_status = $information[1]; }
		if($i==5){	$payment_mode_card = $information[1]; }
		if($i==6){	$card_name = $information[1]; }
		if($i==8){	$status_message = $information[1]; }
		if($i==10){	$card_amount = $information[1]; }
		if($i==11){	$billing_name = $information[1]; }
		if($i==12){	$billing_address = $information[1]; }
		if($i==26){	$pkg_id = $information[1]; }
		if($i==27){	$validity = $information[1]; }
		if($i==28){	$ser_mer = $information[1]; }
		if($i==29){	 $ammount = $information[1]; }
		if($i==30){	 $regid = $information[1];}
		
		
	}
	
	$sqlpkg="SELECT * FROM `ser_mer_pckage` WHERE id= '$pkg_id'";
	$respkg =$conn->query($sqlpkg);
	
	$datepkg=mysqli_fetch_assoc($respkg);
	$validity=$datepkg['validity'];
	
	$ammount=$datepkg['ammount'];
	
	if($order_status == "Success")
	{
	
	$start_date=date("Y-m-d");
	
	$next_date= date('Y-m-d', strtotime($start_date. ' + '.$validity.' days'));
	
	$date=date("Y-m-d");
	
	
	
	 $spayment = "INSERT INTO `tbl_payment_sales`(`cust_id`, `payment_mode`,`order_id`, `tracking_id`, `bank_ref_no`, `order_status`, `payment_mode_card`, `card_name`, `status_message`, `card_amount`, `billing_name`, `billing_address`, `net_amount`,`created_by`,`created_date`,`payment_from`) VALUES ('".$regid."','3','".$order_id."','".$tracking_id."','".$bank_ref_no."','".$order_status."','".$payment_mode_card."','".$card_name."','".$status_message."','".$card_amount."','".$billing_name."','".$billing_address."','".$card_amount."','".$regid."','$date','1')";	

	$sql_inse = $conn->query($spayment) or trigger_error(mysql_error());
	
		if($sql_inse)
		{
			
			$insertjalabho= true;
		}
		else
		{
			$insertjalabho= false;
		}
		
	
		//sending message to sp-merchant.
		//updating sp-merchant table.
		
		if($ser_mer== 3)
		{
			$update_query ="update tbl_service_provider1  set Is_paid='1' , pkg_id = '$pkg_id' , pkg_amt = '$ammount' , expiry_date = '$next_date' ,  start_date = '$start_date' , is_expired = '0' where service_provider_id ='$regid'"; 
	$sql_upda = $conn->query($update_query) or trigger_error(mysql_error());
	
		if($sql_upda)
		{
			
			$updatejalabho= true;

		}
		else
		{
			$updatejalabho= false;
		
		}
	
	$result12  = $conn->query("select name,mobile from tbl_service_provider1 where service_provider_id = '".$regid."'");
	$row12 = $result12->fetch_array();
	
	$user_msg = urlencode("Dear Sir / Madam, Yours Order of services provider is confirm with us. order Number:- ".$order_id.", Customer Name :-  ".$row12['name'].". of Payment :- ".$card_amount." ,Looking forward to a long and fruitful association with you!");
	$adminmobileno = "91".$row12['mobile'];
	//$usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pitdemo&password=12345&type=0&dlr=1&destination=$adminmobileno&source=FREEDM&message=$user_msg";
	 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=12345&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
		}
		
		
	
		
		else if($ser_mer == 2)
		{
			$update_query ="update tbl_merchant1 set Is_paid='1' , pkg_id = '$pkg_id' , pkg_amt = '$ammount' , expiry_date = '$next_date' ,  start_date = '$start_date' , is_expired = '0' where service_provider_id ='$regid'"; 
			
			$sql_upda = $conn->query($update_query) or trigger_error(mysql_error());
			
		
		if($sql_upda)
		{
			
			$updatejalabho= true;
			
		}
		else
		{
			$updatejalabho= false;
			
		}
	
	$result12  = $conn->query("select name,mobile from tbl_merchant1 where service_provider_id = '".$regid."'");
	$row12 = $result12->fetch_array();
	
	$user_msg = urlencode("Dear Sir / Madam, Yours Order of Product supplyers is confirm with us. order Number:- ".$order_id.", Customer Name :-  ".$row12['name'].". of Payment :- ".$card_amount." ,Looking forward to a long and fruitful association with you!");
	$adminmobileno = "91".$row12['mobile'];
	//$usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pitdemo&password=12345&type=0&dlr=1&destination=$adminmobileno&source=FREEDM&message=$user_msg";
	 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=12345&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
			
			
			
		}
		
		
		
		if($updatejalabho)
		{
			$data = array("status" => true, "responce_status_massage" => "Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.","updatejalabho" => $updatejalabho,"insertjalabho" => $insertjalabho,"validity" => $validity ,"amount" => $ammount);
			echo json_encode($data);
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Data filling failed Please contact to us!","updatejalabho" => $updatejalabho,"insertjalabho" => $insertjalabho);
			echo json_encode($data);
		}
		
	}
	else if($order_status==="Aborted")
	{
	
		$data = array("status" => false, "responce_status_massage" => "Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail");
		echo json_encode($data);
	
	}
	else if($order_status==="Failure")
	{
		$data = array("status" => false, "responce_status_massage" => "Thank you for shopping with us.However,the transaction has been declined!");
		echo json_encode($data);
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "Security Error. Illegal access detected!");
		echo json_encode($data);
	}
?>

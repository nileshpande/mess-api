<?php 
include_once('../connection.php');
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);
/*
"ammount":460,
	"pkgid":1,
	"business_type":3,
	"validity":365,
	"regid":12345
*/
$pkgid = $postdata2['pkgid'];
$business_type = $postdata2['business_type'];
$regid = $postdata2['regid'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
		   
		   //setting package and duration session for database update
		       
			  
		   if($business_type == 3 )
		   {
			   
			   $sql="select * from tbl_service_provider1 where service_provider_id='$regid' ";
			   $res=$conn->query($sql);
			   
			   
		   }
		   else  if($business_type == 2 )
		   {
			   
			   $sql="select * from tbl_merchant1 where service_provider_id='$regid' ";
			   $res=$conn->query($sql);
			   
			   
		   }
		   
		   
			$sqlpkg="select * from ser_mer_pckage where id = '$pkgid'";
			$reshowpkg =$conn->query($sqlpkg);
			
			
			
		
			$rowser = mysqli_fetch_assoc($res);
			 
			$data = array();
			while($rowpkg = mysqli_fetch_assoc($reshowpkg))
			{
				$rand=rand(100,10000);
				
				$nowamt = str_replace(array('b', 'c', 'd', 'e', 'f', 'g','h','i','j','k'),
				array('1', '2', '3', '4', '5', '6','7','8','9','0'),$rowpkg['ammount']);
				
				$row['pkg_amt']=$nowamt;
				$row['amount']=$nowamt;
				
				/* $row['pkg_amt']=1;
				$row['amount']=1; */
				$row['order_id']=$rand.$rowser['service_provider_id'];
				$row['action']="https://www.pprlhousing.com/api/v1/services/ccavRequestHandler.php";
				$row['tid']=$row['order_id'];
				$row['merchant_id']="65129";
				$row['currency']="INR";
				$row['redirect_url']="https://www.pprlhousing.com/api/v1/services/ccavResponseHandler.php";
				$row['cancel_url']="https://www.pprlhousing.com/services/index.php";
				$row['language']="EN";
				$row['billing_name']=$rowser['name'];
				$row['billing_address']=$rowser['address'];
				if(!empty($rowser['taluka_name'])){ $row['billing_city']=$rowser['taluka_name']; }else{$row['billing_city']="Jalgaon";}
				$row['billing_state']="MH";
				$row['billing_zip']="425001";
				$row['billing_country']="India";
				$row['billing_tel']=$rowser['mobile'];
				if(!empty($rowser['email_id'])){ $row['billing_email']=$rowser['email_id']; }else{$row['billing_email']="info@pprlhousing.com";}
				//optional
				
				$row['delivery_name']="Vinay";
				$row['delivery_address']="kp pune";
				$row['delivery_city']="Pune";
				$row['delivery_state']="maharashtra";
				$row['delivery_zip']="411 035";
				$row['delivery_country']="India";
				$row['delivery_tel']="9673129396";
				$row['merchant_param1']="India";
				$row['merchant_param2']=$pkgid;
				$row['merchant_param3']=$business_type;
				$row['merchant_param4']=$ammount;
				$row['merchant_param5']=$regid;
				
			
		

				
				$data= $row; 
				
			}
			$data2 = array("status" => true, "responce_status_massage" => "Data found","data" => $data);
			print json_encode($data2,JSON_NUMERIC_CHECK);
			
		
	
}
else
{
	$data2 = array("status" => false, "responce_status_massage" => "No Input");
	print json_encode($data2,JSON_NUMERIC_CHECK);
}	
?>
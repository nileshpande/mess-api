<?php
include("../connection.php"); 
//if(isset($_POST)){print_r($_POST);} 

if(!empty($_POST))
{
   $date=date('Y-m-d');
		
		if(!empty($_POST['district']))
		{
			$district=explode(':',$_POST['district']);
			$district_id=$district[0];
			$district_name=$district[1];
			
			
			
		}
		else
		{
			$district_id='0';
			$district_name='0';
			
		}
		
		if(!empty($_POST['taluka']))
		{
			$taluka=explode(':',$_POST['taluka']);
			$taluka_id=$taluka[0];
			$taluka_name=$taluka[1];
		
			
		}
		else
		{
			$taluka_id='0';
			$taluka_name='0';
			
		}
		
		
if(empty($_POST['address']))
{
$address=$_POST['shop-house-no'].' '.$_POST['building-name'].' '.$taluka_name.' '.$_POST['pincode'];
 	
}
else 
{
	$address=$_POST['address'];   
}
		
		
		
		
		
		
		
		
		
		
		
		
		
		$category = "";	
		$sub_category = "";	
		
		$cat_id="";
		$cat_name="";
		$subcat_id="";
		$subcat_name="";
		
		if(isset($_POST['fname']) && isset($_POST['lname'])) 
		//fullname= fname+lname.
		{
			$fullname = $_POST['fname']." ".$_POST['lname'];
			//this $fullname will be inserted into query.
		}
		if(isset($_POST['usermobile']))
		//foldername= fname+mobile.
		{
			$foldername = $_POST['fname'].$_POST['usermobile'];
		}
		
		if(isset($_POST['opendays-from']) and isset($_POST['todays'])) 
		//opendays= opendays+todays.
		{
			$open_days = $_POST['opendays-from'].','.$_POST['todays'];
			//this $open_days will be inserted into query.
		}
		if(isset($_POST['hrs-from']) and isset($_POST['hrs-to']))
		//working hours= open+end.
		{
			$working_hours = $_POST['hrs-from'].','.$_POST['hrs-to'];
			$duration=$_POST['hrs-to']-$_POST['hrs-from'];
			//this $working_hours and $duration will be inserted into query.
		}
		
		/***************************************************************************
		$_POST['email'] , $_POST['mob']  $_POST['shop-name'] $_POST['shop-house-no']
		$_POST['building-name'] $_POST['street'] $_POST['land-mark'] $_POST['area'] $_POST['other'] $_POST['state'] $_POST['district'] $_POST['taluka'] $_POST['city-village'] $_POST['pincode'] $_POST['locationof-ser']
		
		*************** will be inserted directly into query ***********************
		$_POST['location'] is useless at this time.
		
		
		
		***************************************************************************/
		
		if(isset($_POST['service-merchant']))
		{
			if($_POST['service-merchant']==3)  // '3' for service provider check
			{
				if(isset($_POST['sercat1']) and $_POST['sercat1'] != "0")
				{ 
					//first service
					 
					$category=explode(':',$_POST['sercat1']);
					
					 
					$cat_id=$category[1].',';
					$cat_name=$category[2].',';
					
					/* echo "catid=".$cat_id;
					echo "cat_name=".$cat_name;
					die();	 */
					
					
					if(isset($_POST['sersubcat1']) and $_POST['sersubcat1'] != "0")
					{
						//first sub category
						 
						  $sub_category=explode(':',$_POST['sersubcat1']);
						$subcat_id=$sub_category[1].',';
						$subcat_name=$sub_category[2].',';  
						  	
					}
				
				//second
				
				if(isset($_POST['sercat2']) and $_POST['sercat2'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['sercat2']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					 	 
					if(isset($_POST['sersubcat2']) and $_POST['sersubcat2'] != "0")
					{
						//first sub category
						 
						 $sub_category=explode(':',$_POST['sersubcat2']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
						
						
						
					}				
				}
				
				//Third
				
				if(isset($_POST['sercat3']) and $_POST['sercat3'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['sercat3']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					
					
					if(isset($_POST['sersubcat3']) and $_POST['sersubcat3'] != "0")
					{
						//first sub category
						 
						  $sub_category=explode(':',$_POST['sersubcat3']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';
						 
						
					}				
				}
				
				//Fourth
				
				if(isset($_POST['sercat4']) and $_POST['sercat4'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['sercat4']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					
					
					
					if(isset($_POST['sersubcat4']) and $_POST['sersubcat4'] != "0")
					{
						//first sub category
						 
					 $sub_category=explode(':',$_POST['sersubcat4']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Fifth
				
				if(isset($_POST['sercat5']) and $_POST['sercat5'] != "0")
				{ 
					//concatinate others
					 
					
					$category=explode(':',$_POST['sercat5']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					
					if(isset($_POST['sersubcat5']) and $_POST['sersubcat5'] != "0")
					{
						//first sub category
						  $sub_category=explode(':',$_POST['sersubcat5']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Sixth
				
				if(isset($_POST['sercat6']) and $_POST['sercat6'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['sercat6']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					
					if(isset($_POST['sersubcat6']) and $_POST['sersubcat6'] != "0")
					{
						//first sub category
						 $sub_category=explode(':',$_POST['sersubcat6']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].','; 
						
					}				
				}
				
				//Seventh
				
				if(isset($_POST['sercat7']) and $_POST['sercat7'] != "0")
				{ 
					//concatinate others
				 
					
					$category=explode(':',$_POST['sercat7']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					 
					
					
					if(isset($_POST['sersubcat7']) and $_POST['sersubcat7'] != "0")
					{
						//first sub category
						  $sub_category=explode(':',$_POST['sersubcat7']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Eighth
				
				if(isset($_POST['sercat8']) and $_POST['sercat8'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['sercat8']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					 
					
					
					
					if(isset($_POST['sersubcat8']) and $_POST['sersubcat8'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['sersubcat8']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Nineth
				
				if(isset($_POST['sercat9']) and $_POST['sercat9'] != "0")
				{ 
					//concatinate others
					  
					$category=explode(':',$_POST['sercat9']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
				 
					
					
					if(isset($_POST['sersubcat9']) and $_POST['sersubcat9'] != "0")
					{
						//first sub category
						  $sub_category=explode(':',$_POST['sersubcat9']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Tenth
				
				if(isset($_POST['sercat10']) and $_POST['sercat10'] != "0")
				{ 
					//concatinate others
					$category=explode(':',$_POST['sercat10']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					 
					
					if(isset($_POST['sersubcat10']) and $_POST['sersubcat10'] != "0")
					{
						//first sub category
					
						$sub_category=explode(':',$_POST['sersubcat10']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';
						
						   
					}				
				}
			}
		}
			/***************************************************************
			*********************** Merchant start *************************
			****************************************************************/
			else if($_POST['service-merchant']==2) // '2' for otherwise merchant check
			{
				
				if(isset($_POST['mercat1']) and $_POST['mercat1'] != "0")
				{ 
					//first service
					 
					$category=explode(':',$_POST['mercat1']);
					$cat_id=$category[1].',';
					$cat_name=$category[2].',';
					
					if(isset($_POST['mersubcat1']) and $_POST['mersubcat1'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat1']);
						
						$subcat_id=$sub_category[1].',';
						$subcat_name=$sub_category[2].',';  
					}				
				}
				
				//second
				
				if(isset($_POST['mercat2']) and $_POST['mercat2'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat2']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					if(isset($_POST['mersubcat2']) and $_POST['mersubcat2'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat2']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Third
				
				if(isset($_POST['mercat3']) and $_POST['mercat3'] != "0")
				{ 
					//concatinate others
				 
					$category=explode(':',$_POST['mercat3']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat3']) and $_POST['mersubcat3'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat3']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Fourth
				
				if(isset($_POST['mercat4']) and $_POST['mercat4'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat4']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					if(isset($_POST['mersubcat4']) and $_POST['mersubcat4'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat4']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Fifth
				
				if(isset($_POST['mercat5']) and $_POST['mercat5'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat5']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat5']) and $_POST['mersubcat5'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat5']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
						
					}				
				}
				
				//Sixth
				
				if(isset($_POST['mercat6']) and $_POST['mercat6'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat6']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat6']) and $_POST['mersubcat6'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat6']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Seventh
				
				if(isset($_POST['mercat7']) and $_POST['mercat7'] != "0")
				{ 
					//concatinate others
				 
					$category=explode(':',$_POST['mercat7']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat7']) and $_POST['mersubcat7'] != "0")
					{
						//first sub category
						 
						$sub_category=explode(':',$_POST['mersubcat7']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Eighth
				
				if(isset($_POST['mercat8']) and $_POST['mercat8'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat8']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					
					if(isset($_POST['mersubcat8']) and $_POST['mersubcat8'] != "0")
					{
						//first sub category
						$sub_category=explode(':',$_POST['mersubcat8']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Nineth
				
				if(isset($_POST['mercat9']) and $_POST['mercat9'] != "0")
				{ 
					//concatinate others
					 
					$category=explode(':',$_POST['mercat9']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat9']) and $_POST['mersubcat9'] != "0")
					{
						//first sub category
						$sub_category=explode(':',$_POST['mersubcat9']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
				//Tenth
				
				if(isset($_POST['mercat10']) and $_POST['mercat10'] != "0")
				{ 
					//concatinate others
					$category=explode(':',$_POST['mercat10']);
					$cat_id.=$category[1].',';
					$cat_name.=$category[2].',';
					
					if(isset($_POST['mersubcat10']) and $_POST['mersubcat10'] != "0")
					{
						//first sub category
						$sub_category=explode(':',$_POST['mersubcat10']);
						$subcat_id.=$sub_category[1].',';
						$subcat_name.=$sub_category[2].',';  
					}				
				}
				
			}
			
		}
		if(isset($_POST['merchant-type']))
		{
			$merchant_type ="";
			$merchant_type = $_POST['merchant-type'];
		}//merchant sub part radio button value.
		else{$merchant_type=0;}
		
		$verification_code = rand(10000,100000);
		$password=substr($_POST['usermobile'],4,10);
		$password=md5($_POST['usermobile']);
			
			
		//File Upload section
		
		require_once("../common/image_resize.php");		
		
		mkdir("../../../images/service-merchant/".$foldername);	
		$target_dir ="../../../images/service-merchant/$foldername/";	
		
		if(isset($_FILES['pancard']['name']) && ($_FILES['pancard']['name']!=""))
		{
			$filetmp1 = $_FILES['pancard']['tmp_name'];	
			$target_file1 = $target_dir.basename($_FILES['pancard']['name']);	
			$imageFileType1 = pathinfo($target_file1,PATHINFO_EXTENSION);	
			$target_file1 = $target_dir . "pancard.".$imageFileType1;
			smart_resize_image($filetmp1,null,600,370,true,$target_file1,true,false,100,false);
			$panfilename=$foldername."/pancard.".$imageFileType1;
		}
		else { $panfilename="";  }	
		
		if(isset($_FILES['adharcard']['name']) && ($_FILES['adharcard']['name']!=""))
		{
			$filetmp2 = $_FILES['adharcard']['tmp_name'];	
			$target_file2 = $target_dir.basename($_FILES['adharcard']['name']);		
			$imageFileType2 = pathinfo($target_file2,PATHINFO_EXTENSION);	
			$target_file2 = $target_dir . "adharcard.".$imageFileType2;
			smart_resize_image($filetmp2,null,600,370,true,$target_file2,true,false,100,false);
			$aadharfilename=$foldername."/adharcard.".$imageFileType2;
		}	
		else { $aadharfilename="";  }	

		if(isset($_FILES['photo1']['name']) && ($_FILES['photo1']['name']!=""))	
		{	
			$filetmp3 = $_FILES['photo1']['tmp_name'];	
			$target_file3 = $target_dir.basename($_FILES['photo1']['name']);
			$imageFileType3 = pathinfo($target_file3,PATHINFO_EXTENSION);
			$target_file3 = $target_dir . "photo1.".$imageFileType3;
			smart_resize_image($filetmp3,null,600,370,true,$target_file3,true,false,100,false);
			$profile1name=$foldername."/photo1.".$imageFileType3;
		}
		else { $profile1name="";  }		

		if(isset($_FILES['photo2']['name']) && ($_FILES['photo2']['name']!=""))	
		{	
			$filetmp4 = $_FILES['photo2']['tmp_name'];
			$target_file4 = $target_dir.basename($_FILES['photo2']['name']);
			$imageFileType4 = pathinfo($target_file4,PATHINFO_EXTENSION);
			$target_file4 = $target_dir . "photo2.".$imageFileType4;
			smart_resize_image($filetmp4,null,600,370,true,$target_file4,true,false,100,false);
			$profile2name=$foldername."/photo2.".$imageFileType4;
		}
		else { $profile2name=""; }
				
		if($_POST['service-merchant']==3)
		{
			$sql_insert = "INSERT INTO `tbl_service_provider1`(`name`, `mobile`, `email_id`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `address`, `country`, `State`,`city`, `district_id`,`district_name`,`taluka_id`, `taluka_name`, `office_telephone`,`pincode`, `bussiness_type`, `nature_of _bussiness`,`category`,`finall_category`,`sub_category`, `final_subcategory`,`location_of_service`, `working_hours`, `duration`, `open_days`,`added_by`,`is_active`, `sp_username`, `sp_password`, `verification_code`,`created_date`,`adharcard`,`pancard`,`profile_pic1`,`profile_pic2`) VALUES ('$fullname','".$_POST['usermobile']."','".$_POST['email']."','".$_POST['shop-name']."','".$_POST['shop-house-no']."','".$_POST['building-name']."','".$_POST['street']."','".$_POST['land-mark']."','".$_POST['area']."','$address','India','".$_POST['state']."','".$_POST['city-village']."','$district_id','$district_name','$taluka_id','$taluka_name','".$_POST['office_contact']."','".$_POST['pincode']."','".$_POST['service-merchant']."','".$merchant_type."','$cat_name','$cat_id','$subcat_name','$subcat_id','".$_POST['locationof-ser']."','".$working_hours."','".$duration."','".$open_days."','4','1','".$_POST['usermobile']."','$password','$verification_code','$date','$aadharfilename','$panfilename','$profile1name','$profile2name')";
			
			$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
			$sp_id= mysqli_insert_id($conn);
			if($sql_inse)
			{ 
					$email=$_POST['email'];
						$username=$_POST['usermobile'];
						//$password=$_POST['usermobile'];
						
									$to = $email;
									$sub = "PPRL Listing";
									//Login details are temperorily stopped
									/*$msg = "Dear Customer below is your login details. \nusername=$username \n password=$password"; */
									
									$msg = "Dear Customer you have been successfully listed on pprlhousing"; 
									 
									 mail($to, $sub, $msg, "From: info@pprlhousing.com"); 
				 
			}
		 
		}
			
		else if($_POST['service-merchant']==2)
		{
			 
			$sql_insert = "INSERT INTO `tbl_merchant1`(`name`, `mobile`, `email_id`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `address`, `country`, `State`,`city`, `district_id`,`district_name`,`taluka_id`, `taluka_name`, `office_telephone`,`pincode`, `bussiness_type`, `nature_of _bussiness`,`category`,`finall_category`,`sub_category`, `final_subcategory`,`location_of_service`, `working_hours`, `duration`, `open_days`,`added_by`,`is_active`, `sp_username`, `sp_password`, `verification_code`,`created_date`,`adharcard`,`pancard`,`profile_pic1`,`profile_pic2`) VALUES ('$fullname','".$_POST['usermobile']."','".$_POST['email']."','".$_POST['shop-name']."','".$_POST['shop-house-no']."','".$_POST['building-name']."','".$_POST['street']."','".$_POST['land-mark']."','".$_POST['area']."','$address','India','".$_POST['state']."','".$_POST['city-village']."','$district_id','$district_name','$taluka_id','$taluka_name','".$_POST['office_contact']."','".$_POST['pincode']."','".$_POST['service-merchant']."','".$merchant_type."','$cat_name','$cat_id','$subcat_name','$subcat_id','".$_POST['locationof-ser']."','".$working_hours."','".$duration."','".$open_days."','4','1','".$_POST['usermobile']."','$password','$verification_code','$date','$aadharfilename','$panfilename','$profile1name','$profile2name')";
			 
			$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
			 $sp_id= mysqli_insert_id($conn); 
			  
			if($sql_inse)
			{ 
						$email=$_POST['email'];
						$username=$_POST['usermobile'];
						//$password=$_POST['usermobile'];
						
									$to = $email;
									$sub = "PPRL Listing";
									//Login details are temperorily stopped
									/*$msg = "Dear Customer below is your login details. \nusername=$username \n password=$password"; */
									
									$msg = "Dear Customer you have been successfully listed on pprlhousing"; 
									 
									 mail($to, $sub, $msg, "From: info@pprlhousing.com"); 
		  
				 
			}
			
		}
 
}

		$usermobile=$_POST['usermobile'];
		$email=$_POST['email'];
		
			if($sql_inse)
			{
				if($_POST['service-merchant']==2)
				{
					$otp=$sp_id;
				$otp=$otp.rand(10,100);
				
				$sqlotp  ="UPDATE tbl_merchant1 set otp = ".$otp." WHERE service_provider_id = ".$sp_id;
				
				$result_otp=$conn->query($sqlotp)or trigger_error($conn->$result_otp);
				
	
				$user_msg = urlencode("One more step for complete registration please enter you this OTP: ".$otp." and your id is: ".$sp_id." thankyou");
	$adminmobileno = "91".$usermobile;
	//$usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pitdemo&password=12345&type=0&dlr=1&destination=$adminmobileno&source=FREEDM&message=$user_msg";
	 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=98765&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
						
						
						
			$data2 = array("status" => true, "responce_status_massage" => "Sucessfuly Done","business_type" => 2, "mobile"=> $usermobile,"email" => $email,"regid" => $sp_id);
			echo json_encode($data2,JSON_NUMERIC_CHECK);
			
						
				}
				else if($_POST['service-merchant']==3)
				{
						$otp=$sp_id;
				$otp=$otp.rand(10,100);
				
				$sqlotp  ="UPDATE tbl_service_provider1 set otp = ".$otp." WHERE service_provider_id = ".$sp_id;
				
				$result_otp=$conn->query($sqlotp)or trigger_error($conn->$result_otp);
				
	
				$user_msg = urlencode($otp." : is your One Time Password (OTP). Please Enter the OTP for Verification on pprlhousing.com. Your id is: ".$sp_id." thankyou.");
	$adminmobileno = "91".$usermobile;
	//$usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pitdemo&password=12345&type=0&dlr=1&destination=$adminmobileno&source=FREEDM&message=$user_msg";
	 $usersmsstr2 = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-pprlhs&password=98765&type=0&dlr=1&destination=$adminmobileno&source=PPRLHS&message=$user_msg";
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$usersmsstr2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	
				$data2 = array("status" => true, "responce_status_massage" => "Sucessfuly Done","business_type" => 3, "mobile"=> $usermobile,"email" => $email,"regid" => $sp_id);
				echo json_encode($data2,JSON_NUMERIC_CHECK);
			
				
				}
				
				
			}
			else
			{
				$data = array("status" => false, "responce_status_massage" => "Something went wrong!");
				echo json_encode($data);
							
			} 

					



?>

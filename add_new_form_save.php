<?php 
include("include-files/connection.php");

header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 

$postdata2=json_decode($postdata,true);

$reg_id = $postdata2['reg_id'];

if($_SERVER['REQUEST_METHOD'] == "POST" && $reg_id > 0)
{
	$todaydate= date('Y-m-d');
	
	
	// This file here decode JWT token then return status of key 
	// and gives data responce.
	/********************************/
	require_once 'jwtdecode.php';
	/*******************************/
	
	
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	
	if(isset($postdata2['fname']) and ($postdata2['fname']!=""))
	{
		$fname = $postdata2['fname'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['mname']) and ($postdata2['mname']!=""))
	{
		$mname = $postdata2['mname'];	
	}
	else { $mname=""; }
	
	if(isset($postdata2['lname']) and ($postdata2['lname']!=""))
	{
		$lname = $postdata2['lname'];
	}
	else { $lname=""; }
	
	if(isset($postdata2['phonenumber']) and ($postdata2['phonenumber']!=""))
	{
		$phonenumber = $postdata2['phonenumber'];
	}
	else { $phonenumber=""; }
	
	if(isset($postdata2['mobilenumber']) and ($postdata2['mobilenumber']!=""))
	{
		$mobilenumber = $postdata2['mobilenumber'];
	}
	else { $mobilenumber=""; }
	
	if(isset($postdata2['department']) and ($postdata2['department']!=""))
	{
		$department = $postdata2['department'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['branch']) and ($postdata2['branch']!=""))
	{
		$branch = $postdata2['branch'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['hostelnumber']) and ($postdata2['hostelnumber']!=""))
	{
		$hostelnumber = $postdata2['hostelnumber'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['roomnumber']) and ($postdata2['roomnumber']!=""))
	{
		$roomnumber = $postdata2['roomnumber'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['bldgrp']) and ($postdata2['bldgrp']!=""))
	{
		$bldgrp = $postdata2['bldgrp'];
	}
	else { $bldgrp = 0; }	
	
	if(isset($postdata2['course']) and ($postdata2['course']!=""))
	{
		$course = $postdata2['course'];
	}
	else { $course = 0; }
	
	if(isset($postdata2['advancepay']) and ($postdata2['advancepay']!=""))
	{
		$advancepay = $postdata2['advancepay'];
	}
	else { $advancepay = 0; }
	
	if((isset($postdata2['corradddress']) and ($postdata2['corradddress']!="")) or (isset($postdata2['permadddress']) and ($postdata2['permadddress']!="")))
	{
		// Permanant address can me corresepondance address
		//but corresepondance address can't be always permanant address.
		// this situation is handeled here.
		
		if($postdata2['permadddress']!="")
		{
			$permadddress=$postdata2['permadddress'];
			
			if($postdata2['corradddress']=="")
			{
				$corradddress=$permadddress;
			}
		}
		else
		{
			$permadddress="";
		}
		if($postdata2['corradddress']!="")
		{
			$corradddress=$postdata2['corradddress'];	
		}	
		
	}
	else { $get_lost=true; }	//	required
	
	if(isset($postdata2['dateoj']) and ($postdata2['dateoj']!=""))
	{
		$dateoj = $postdata2['dateoj'];
	}
	else { $get_lost=true; }	//	required
	
	/*if(isset($postdata2['studpic']) and ($postdata2['studpic']!=""))
	{
		$studpic = $postdata2['studpic'];
	}
	else { $studpic=""; }	//	required
	*/
	
	//Checking server side required. By $get_lost .
	
	$year=date('Y');
	
	if($get_lost == true)
	{
		$data2 = array("status" => false, "responce_status_massage" => "Wrong Input!" );
		echo json_encode($data2);
	}
	else
	{
		
			
		$sql_insert = "INSERT INTO `student`(`fname`, `mname`, `lname`, `addres_permanant`, `address_corespondance`, `phone_number`, `mobile`, `department`, `branch`, `hostel_no`, `room_no`, `start_date_mess`,`year`,`blood_grp`,`course`) VALUES ('$fname','$mname','$lname','$permadddress','$corradddress','$phonenumber','$mobilenumber','$department','$branch','$hostelnumber','$roomnumber','$dateoj','$year','$bldgrp','$course')";
		
		$sql_inse = $conn->query($sql_insert)or die(mysqli_error($conn));
		$stud_id= mysqli_insert_id($conn);
		if($sql_inse)
		{
			if($_FILES['studpic']['name']!="")
			{
				$photoname=$fname."-".$stud_id;
				$uploadDir="../student-images/";
				$extension1=strtolower(substr($_FILES['studpic']['name'], strpos($_FILES['studpic']['name'], '.')+1));
				$Fname1=  $photoname.".".$extension1; //database variable
				$tmpName_propertyimg1 = $_FILES['studpic']['tmp_name'];
				$fileUPDB1=$Fname1;	
				$filepath1= $uploadDir.$Fname1;
				//echo $filepath1;
				//move_uploaded_file($tmpName_propertyimg1,$filepath1);
				
				$sql_image="update student set photo = '$fileUPDB1' where reg_id='$stud_id'";
				//echo $sql_image;
				
				$target_file1=$uploadDir.$fileUPDB1;
				//echo $target_file1."---";
				require_once("image_resize.php");
				
				smart_resize_image($tmpName_propertyimg1,null,800,600,true,$target_file1,true,false,100,false);
				
				
				$image_res=$conn->query($sql_image);
				if($sql_inse)
				{
					
					if($advancepay>0)
					{
						$sql_insert_acc = "INSERT INTO `account_status`(`reg_id`, `name`, `extra_payment`, `date`,`pay_date`,`year`) VALUES ('$stud_id','".$fname." ".$mname." ".$lname."','$advancepay','$todaydate','$todaydate','$year')";
			
						$sql_acc = $conn->query($sql_insert_acc);
					}
					else {}
					//die();
					$data = array("status" => true, "responce_status_massage" => "Success");
					echo json_encode($data);
				}
				else
				{
					$data = array("status" => false, "responce_status_massage" => "Failed Try Again");
					echo json_encode($data);
				}
			}
			
			
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Failed Try Again");
			echo json_encode($data);
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
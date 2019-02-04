<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");
$todaydate=date("Y-m-d");
print_r($_POST);

if(isset($_POST['submit']) and isset($_POST['fname']))
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	
	if(isset($_POST['fname']) and ($_POST['fname']!=""))
	{
		$fname = $_POST['fname'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['mname']) and ($_POST['mname']!=""))
	{
		$mname = $_POST['mname'];	
	}
	else { $mname=""; }
	
	if(isset($_POST['lname']) and ($_POST['lname']!=""))
	{
		$lname = $_POST['lname'];
	}
	else { $lname=""; }
	
	if(isset($_POST['phonenumber']) and ($_POST['phonenumber']!=""))
	{
		$phonenumber = $_POST['phonenumber'];
	}
	else { $phonenumber=""; }
	
	if(isset($_POST['mobilenumber']) and ($_POST['mobilenumber']!=""))
	{
		$mobilenumber = $_POST['mobilenumber'];
	}
	else { $mobilenumber=""; }
	
	if(isset($_POST['department']) and ($_POST['department']!=""))
	{
		$department = $_POST['department'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['branch']) and ($_POST['branch']!=""))
	{
		$branch = $_POST['branch'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['hostelnumber']) and ($_POST['hostelnumber']!=""))
	{
		$hostelnumber = $_POST['hostelnumber'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['roomnumber']) and ($_POST['roomnumber']!=""))
	{
		$roomnumber = $_POST['roomnumber'];
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['bldgrp']) and ($_POST['bldgrp']!=""))
	{
		$bldgrp = $_POST['bldgrp'];
	}
	else { $bldgrp = 0; }	
	
	if(isset($_POST['course']) and ($_POST['course']!=""))
	{
		$course = $_POST['course'];
	}
	else { $course = 0; }
	
	if(isset($_POST['advancepay']) and ($_POST['advancepay']!=""))
	{
		$advancepay = $_POST['advancepay'];
	}
	else { $advancepay = 0; }
	
	if((isset($_POST['corradddress']) and ($_POST['corradddress']!="")) or (isset($_POST['permadddress']) and ($_POST['permadddress']!="")))
	{
		// Permanant address can me corresepondance address
		//but corresepondance address can't be always permanant address.
		// this situation is handeled here.
		
		if($_POST['permadddress']!="")
		{
			$permadddress=$_POST['permadddress'];
			
			if($_POST['corradddress']=="")
			{
				$corradddress=$permadddress;
			}
		}
		else
		{
			$permadddress="";
		}
		if($_POST['corradddress']!="")
		{
			$corradddress=$_POST['corradddress'];	
		}	
		
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['dateoj']) and ($_POST['dateoj']!=""))
	{
		$dateoj = $_POST['dateoj'];
	}
	else { $get_lost=true; }	//	required
	
	/*if(isset($_POST['studpic']) and ($_POST['studpic']!=""))
	{
		$studpic = $_POST['studpic'];
	}
	else { $studpic=""; }	//	required
	*/
	
	//Checking server side required. By $get_lost .
	
	$year=date('Y');
	
	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=rikame kama kru naye");
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
					header("location:../dashboard.php?msg=Congrats-ID-$stud_id");
				}
				else
				{
					header("location:../dashboard.php?msg=Failed Try again");
				}
			}
			
			
		}
		else
		{
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}
}
else
{
	header("location:../dashboard.php?msg=rikame kama kru naye");
}

?>
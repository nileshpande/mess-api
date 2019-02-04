<?php
//------------- choose connection file ------------

include("../include-files/connection.php");
//include("connection-pdo.php");

print_r($_POST);

if(isset($_POST['submit']) and isset($_POST['fname']) and isset($_POST['reg_id']) and $_POST['reg_id']!="")
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
	
	if(isset($_POST['course']) and ($_POST['course']!=""))
	{
		$course = $_POST['course'];
	}
	else { $course=""; }
	
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
	
	
	
	//Checking server side required. By $get_lost .
	
	$year=date('Y');
	
	if($get_lost == true)
	{
		header("location:../dashboard.php?msg=rikame kama kru naye");
	}
	else
	{
		$stud_id=$_POST['reg_id'];
		
		$sql_updte="UPDATE `student` SET fname = '$fname' , mname = '$mname' ,lname = '$lname' ,addres_permanant = '$permadddress' ,address_corespondance = '$corradddress' , phone_number = '$phonenumber' ,mobile = '$mobilenumber' ,department = '$department' ,branch = '$branch' ,hostel_no = '$hostelnumber' ,room_no = '$roomnumber' ,course = '$course' where reg_id='$stud_id' ";
		
		//$sql_insert = "INSERT INTO `student`(`fname`, `mname`, `lname`, `addres_permanant`, `address_corespondance`, `phone_number`, `mobile`, `department`, `branch`, `hostel_no`, `room_no`, `start_date_mess`,`year`) VALUES ('$fname','$mname','$lname','$permadddress','$corradddress','$phonenumber','$mobilenumber','$department','$branch','$hostelnumber','$roomnumber')";
		
		$sql_upd = $conn->query($sql_updte)or die(mysqli_error($conn));
		
		if($sql_upd)
		{	
			header("location:../dashboard.php?msg=Congrats");
		}
		else
		{
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}
}
else if(isset($_POST['photo']) and isset($_POST['reg_id']) and ($_POST['reg_id']!=""))
{
	$stud_id=$_POST['reg_id'];
	
	$sqlist="SELECT fname FROM `student` WHERE reg_id = '$stud_id'";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	$row = $sql_result->fetch_array();
	
	$fname=$row['fname'];
	
	if($_FILES['studpic']['name']!="")
	{
		$photoname=$fname."-".$stud_id;
		$uploadDir="../student-images/";
		$extension1=strtolower(substr($_FILES['studpic']['name'], strpos($_FILES['studpic']['name'], '.')+1));
		$Fname1=  $photoname.".".$extension1; //database variable
		$tmpName_propertyimg1 = $_FILES['studpic']['tmp_name'];
		$fileUPDB1=$Fname1;	
		$target_file1=$uploadDir.$fileUPDB1;
		$filepath1= $uploadDir.$Fname1;
		
		require_once("image_resize.php");
				
		smart_resize_image($tmpName_propertyimg1,null,800,600,true,$target_file1,true,false,100,false);
		//move_uploaded_file($tmpName_propertyimg1,$filepath1);
		
		$sql_image="update student set photo = '$fileUPDB1' where reg_id='$stud_id'";
		echo $sql_image;
		$image_res=$conn->query($sql_image);
		if($sql_image)
		{
			header("location:../dashboard.php?msg=Congrats");
		}
		else
		{
			
			header("location:../dashboard.php?msg=Failed Try again");
		}
	}
	else
	{ echo "fsdfsd";
			die();
		header("location:../dashboard.php?msg=Failed Try again");
	}
	
}
else
{ 
	header("location:../dashboard.php?msg=rikame kama kru naye");	
}

?>
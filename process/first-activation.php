<?php

//print_r($_POST);
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Preparation of all input data $get_lost will be true.
	//if any serverside required validation fails.
	
	$get_lost=false;
	
	if(isset($_POST['name']) and ($_POST['name']!=""))
	{
		$name = $_POST['name'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['orgname']) and ($_POST['orgname']!=""))
	{
		$orgname = $_POST['orgname'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['mobile']) and ($_POST['mobile']!=""))
	{
		$mobile = $_POST['mobile'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['orgcontact']) and ($_POST['orgcontact']!=""))
	{
		$orgcontact = $_POST['orgcontact'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['key']) and ($_POST['key']!=""))
	{
		$key = $_POST['key'];
		$productkey=$key;
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['password']) and ($_POST['password']!=""))
	{
		$password = $_POST['password'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['cnfpassword']) and ($_POST['cnfpassword']!=""))
	{
		$cnfpassword = $_POST['cnfpassword'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['logid']) and ($_POST['logid']!=""))
	{
		$logid = $_POST['logid'];	
	}
	else { $get_lost=true; }	//	required
	
	
	////////////////////////////////////////////
	$importeddb=false;
	$createddb=false;
	// database file path
	$filename = 'mymess_blank.sql';

	// MySQL host
	$mysql_host = 'localhost';

	// MySQL username
	$mysql_username = 'root';

	// MySQL password
	$mysql_password = '';


	// Database name
	$mysql_database = 'mymess';


	// Create connection
	$conn = new mysqli($mysql_host, $mysql_username, $mysql_password);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	
	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS  ".$mysql_database;
	if ($conn->query($sql) === TRUE) {
		$createddb=true;
	} else {
		$createddb=false;
	}

	$conn->close();

	/////////////////////////////////////////



	// Connect to MySQL server
	$connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database);

	if (mysqli_connect_errno())
		echo "Failed to connect to MySQL: " . mysqli_connect_error();

	// Temporary variable, used to store current query
	$templine = '';

	// Read in entire file
	$lines = file($filename);

	// Loop through each line
	foreach ($lines as $line) {
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
			continue;

		// Add this line to the current segment
		$templine .= $line;

		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';') {
			// Perform the query
			if(!mysqli_query($connection, $templine)){
				/* print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />'); */
			}
			// Reset temp variable to empty
			$templine = '';
		}
	}

	mysqli_close($connection);

	$importeddb=true;
	
	
	
	if($get_lost!=true and $importeddb==true)
	{
		include("../include-files/connection.php");
		
		$sql_chk="SELECT * FROM mess_config";
		$sql_chekresult = $conn->query($sql_chk);
		$row = $sql_chekresult->fetch_row();
		$countconfig = $row[0];
		
		$sql_chk="SELECT * FROM authentic_user WHERE role=1 ";
		$sql_chekresult = $conn->query($sql_chk);
		$row = $sql_chekresult->fetch_row();
		$countuser = $row[0];
		
		if($countconfig>0 or $countuser>0)
		{
			header("location:../index.php?msg=Already added data. For any Problem contact to NP solutions");
		}
		else
		{ 
			/***************     verifying data with api with key and owner name mobile ********************/
			
			$url = "http://nptek.xyz/mess-mgt-soft/api/mess_activation/nmumessactivatenil.php?mobile=".$mobile."&key=".$key."&validity=1&product_version=1";  //The url from where you are getting the contents
			$response = (file_get_contents($url)); //Converting in json string
			$returndata=json_decode($response,true);
			//echo $url;
			if($returndata['status']==true)
			{
				$key=$returndata['data']['soft_key'];
			}
			else 
			{ 
				header("location:../index.php?msg=".$key=$returndata['responce_status_massage']." Contact to NP solutions");
				die();
			}
			
			
			///  Insert data into mess_config
			$sql_conf_insert="INSERT INTO `mess_config`(`name`, `organization_name`, `contact_number_person`, `contact_number_organization`, `active_status`, `system_key`,`your_key`) VALUES ('$name','$orgname','$mobile','$orgcontact','1','$key','$productkey')";
			$sql_inse = $conn->query($sql_conf_insert)or die(mysqli_error($conn));
			
			///  Insert data into authentic  user_error
			$sql_conf_insert2="INSERT INTO `authentic_user`(`loginid`, `password`, `name`, `contactno`, `active_status`, `role`) VALUES ('$logid','$password','$name','$mobile','1','1')";
			$sql_inse2 = $conn->query($sql_conf_insert2);
			
			
			

			if($sql_inse==1 and $sql_inse2==1)
			{
				/////  Cron operation data insertion
				
				$todaydate=date("Y-m-d");
				$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m")+1, 1));
				
				$sqlcron="INSERT INTO `cron_and_status` (`type_of_ob`, `date`, `time`, `complete`) VALUES ('1', '$todaydate', '08:00', '0'),('2', '$first_day_this_month', '08:00', '0'),('3', '$todaydate', '08:00', '0')";
				
				$sql_cronopp = $conn->query($sqlcron);
				
				header("location:../index.php?msg=Successfully added. now Login");
			}
			else
			{
				
				header("location:../index.php?msg=Some error occured. Contact to NP solutions");
			}
		}
		
	}
	else
	{
		header("location:../index.php?msg=Wrong Input. Contact to NP solutions");
	}
}
else
{
	header("location:../index.php?msg=Illigal access. Contact to NP solutions");
}
?>
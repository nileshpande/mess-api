<?php

	$db_host="localhost";
	$db_user="root";
	$db_pass="";
	$db_name="nmumess";

	try
	{
		$connpdo=new PDO("mysql:host=$db_host;dbname=$db_name", $db_user,$db_pass);
		$connpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						   
		//echo "connected successfully";	
	}
	catch(PDOException $e)
	{
		echo "Connection failed:".$e->getMessage();
	}
?>
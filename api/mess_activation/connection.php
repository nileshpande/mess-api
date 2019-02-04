<?php	
$conn = new mysqli("localhost", "nptek_mess", "Nilesh47$", "nptek_messactivation");
if(!$conn)
{
	$conn=new mysqli("localhost","root","Nilesh47$","pprlhkvx_newhouse");
	if(!$conn)
	{
		die("Could not connect to database".mysql_error());

	}
}
?>
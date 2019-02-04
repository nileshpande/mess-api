<?php	
$conn=new mysqli("localhost", "pprlhous_newhous", "nilesh47$", "pprlhous_newhouse");
if(!$conn)
{
	$conn=new mysqli("localhost","root","","pprlhkvx_newhouse");
	if(!$conn)
	{
		die("Could not connect to database".mysql_error());

	}
}
?>
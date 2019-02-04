<?php 

	session_start();

	if(isset($_SESSION['messuserid']) && isset($_SESSION['messpassword']) && isset($_SESSION['messuser_role']))
	{	

	}
	else
	{
		echo "<script>window.location.replace('index.php?msg=लॉगईन करा.');</script>";	
	}		

?>
<?php session_start();

unset($_SESSION['messusername']);
unset($_SESSION['messpassword']);
unset($_SESSION['messuser_role']);
if(!isset($_SESSION['messusername']) && !isset($_SESSION['messpassword']) && !isset($_SESSION['messuser_role']))
{		
	header("location:../index.php?msg=लॉग आउट झाले.");
}  

?>
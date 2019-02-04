<?php 

	/******basename(__FILE__);       
	*******this also can be use for page name some time fail also
	*******/
	
	$pagerfxr = basename($_SERVER['PHP_SELF']);
	$role=$_SESSION['messuser_role'];
	
	/*Super admin check*/
	if((($role ==1) and ($pagerfxr=="dashboard.php" || $pagerfxr=="presentday.php" || $pagerfxr=="khada-form.php" || $pagerfxr=="guest-form.php"  || $pagerfxr=="add-new-form.php" || $pagerfxr=="member-list.php" || $pagerfxr=="change-password.php" || $pagerfxr=="profile.php" || $pagerfxr=="edit-member-form.php" || $pagerfxr=="setting.php" || $pagerfxr=="new-user.php" || $pagerfxr=="bill.php" || $pagerfxr=="account-history.php" || $pagerfxr=="student-history.php" || $pagerfxr=="member-details.php" || $pagerfxr=="deactivate-member-form.php" || $pagerfxr=="revenue.php" || $pagerfxr=="reactivate-member-form.php" || $pagerfxr=="export-data.php" || $pagerfxr=="no-dues.php" || $pagerfxr=="advance-history.php" || $pagerfxr=="khada-list.php"))) 
	{}
	/*Admin check*/
	else if((($role ==2) and ($pagerfxr=="dashboard.php" || $pagerfxr=="presentday.php" || $pagerfxr=="khada-form.php" || $pagerfxr=="guest-form.php"  || $pagerfxr=="add-new-form.php" || $pagerfxr=="member-list.php" || $pagerfxr=="change-password.php" || $pagerfxr=="profile.php" || $pagerfxr=="bill.php" || $pagerfxr=="account-history.php" || $pagerfxr=="student-history.php" || $pagerfxr=="member-details.php"  || $pagerfxr=="deactivate-member-form.php" || $pagerfxr=="reactivate-member-form.php" || $pagerfxr=="no-dues.php" || $pagerfxr=="advance-history.php" || $pagerfxr=="khada-list.php"))) 
	{}
	/*attender check*/
	else if((($role ==3) and ($pagerfxr=="dashboard.php" || $pagerfxr=="presentday.php" || $pagerfxr=="khada-form.php" || $pagerfxr=="guest-form.php"  || $pagerfxr=="add-new-form.php" || $pagerfxr=="member-list.php" || $pagerfxr=="change-password.php" || $pagerfxr=="profile.php" || $pagerfxr=="student-history.php" || $pagerfxr=="member-details.php" || $pagerfxr=="advance-history.php" || $pagerfxr=="khada-list.php"))) 
	{}
	else
	{
		echo "<script>window.location.replace('dashboard.php?msg=Acess Denined Contact to Super Power.');</script>";
	}
?>

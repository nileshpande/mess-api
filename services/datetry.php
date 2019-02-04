<?php
include("../connection.php"); 
$sqlpkg="SELECT * FROM `ser_mer_pckage` WHERE id= 2";
	$respkg =$conn->query($sqlpkg);
	
	$datepkg=mysqli_fetch_assoc($respkg);
	$validity=$datepkg['validity'];
	
	$ammount=$datepkg['ammount'];
	
	echo "data amt".$ammount."</br>";
	
	echo "data val".$validity."</br>";
	
$start_date=date("Y-m-d");
	
$next_date= date('Y-m-d', strtotime($start_date. ' + '.$validity.' days'));
	
echo $next_date."</br>";

?>
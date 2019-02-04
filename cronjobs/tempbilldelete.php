<?php
include("../include-files/connection.php");
$sqlbills="SELECT * FROM `student` WHERE deactivated = '0' ";
$sql_result = $conn->query($sqlbills)or die(mysqli_error($conn));
while($rowbill=$sql_result->fetch_array())
{
	$sqldelete="DELETE FROM `billing` WHERE `date` >= '2018-06-01' and `reg_id` = '".$rowbill['reg_id']."' and paid='0' ORDER BY `billing`.`id` DESC LIMIT 1";
	$sql_rdelete = $conn->query($sqldelete)or die(mysqli_error($conn));
	
	$sql_updateunpaid_bill="UPDATE `billing` SET `paid`='0'  WHERE `date` >= '2018-05-01' and reg_id = '$regno' and `paid`='4'";
	$sql_unpaidbill = $conn->query($sql_updateunpaid_bill);
	
	
}

?>
<?php
include("../include-files/connection.php");
$sqlbills="SELECT * FROM `student`";
$sql_result = $conn->query($sqlbills)or die(mysqli_error($conn));
while($rowbill=$sql_result->fetch_array())
{
	$sqldelete="DELETE FROM `billing` WHERE `date` = '2018-02-01' and `reg_id` = '".$rowbill['reg_id']."' and paid='0' ORDER BY `billing`.`id` DESC LIMIT 1";
	$sql_rdelete = $conn->query($sqldelete)or die(mysqli_error($conn));
}

?>
<?php
 
include("../include-files/connection.php");
$todaydate=date("Y-m-d");
$sqlstud="SELECT * FROM `student` WHERE deactivated = '0' and start_date_mess < '2018-01-01' and reg_id > '0'";
$sql_resultstud = $conn->query($sqlstud);
while($rowstud = $sql_resultstud->fetch_array())
{
	$couterbill=0;
	$sql1bill="SELECT * FROM `billing` WHERE paid = '0' and reg_id = '".$rowstud['reg_id']."' and date = '2018-01-01'";
	$sql_result1 = $conn->query($sql1bill)or die(mysqli_error($conn));
	$row1 = $sql_result1->fetch_array();
	if(mysqli_num_rows($sql_result1)) {$couterbill++;} else {}
			
	$sql2bill="SELECT * FROM `billing` WHERE paid = '0' and reg_id = '".$rowstud['reg_id']."' and date = '2018-02-01'";
	$sql_result2 = $conn->query($sql2bill)or die(mysqli_error($conn));
	$row2 = $sql_result2->fetch_array();
	if(mysqli_num_rows($sql_result2)) {$couterbill++;} else {}
			
	
	$sql3bill="SELECT * FROM `billing` WHERE paid = '0' and reg_id = '".$rowstud['reg_id']."' and date = '2018-03-01'";
	$sql_result3 = $conn->query($sql3bill)or die(mysqli_error($conn));
	$row3 = $sql_result3->fetch_array();
	if(mysqli_num_rows($sql_result3)) {$couterbill++;} else {}
	
	if($couterbill==3)
	{
	echo $rowstud['reg_id']."-".$couterbill."<br>";
	
	$thakbaki2=$row1['amount_tobe_pay'];
	$amount_tobe_pay2=$thakbaki2+$row2['amount_this_month'];
	$thakbaki3=$amount_tobe_pay2;
	$amount_tobe_pay3=$thakbaki3+$row3['amount_this_month'];

	
	$sqlupdbill2="UPDATE `billing` SET thak_baki = '$thakbaki2' amount_tobe_pay = '$amount_tobe_pay2', paid = '4' WHERE reg_id = '".$rowstud['reg_id']."' and id = '".$row2['id']."' and paid = '0'";
	
	$sqlupdbill3="UPDATE `billing` SET thak_baki = '".$thakbaki3."' , amount_tobe_pay = '$amount_tobe_pay3' WHERE reg_id = '".$rowstud['reg_id']."' and id = '".$row3['id']."' and paid = '0'";
	
	
	$sqlupdacct="UPDATE `account_status` SET thak_baki = '".$thakbaki3."'   WHERE reg_id = '".$rowstud['reg_id']."' ";
	
	$resltupdbill2 = $conn->query($sqlupdbill2);
	$resltupdbill3 = $conn->query($sqlupdbill3); 
	$resltupdact = $conn->query($sqlupdacct); 
	
	
	echo "<br>".$sqlupdbill2."<br>".$sqlupdbill3."<br>";
	}
	else
	{}
}
die();
/* 2nd old code
$sqlistbill="SELECT * FROM `billing` WHERE date >= '2018-02-01' and paid = '0'";
$sql_resultbill = $conn->query($sqlistbill);
while($rowbill = $sql_resultbill->fetch_array())
{
	$sqlacc="UPDATE `account_status` SET thak_baki = '".$rowbill['thak_baki']."',extra_payment ='".$rowbill['extra_payment']."' WHERE reg_id = '".$rowbill['reg_id']."'";
	$sql_resultacc = $conn->query($sqlacc);
	echo $rowbill['thak_baki'],"</br>";
}

*/
//1st old code
/* 
$sqlistguest="SELECT * FROM `guest` WHERE date >= '2018-01-01' and date <= '2018-01-31' and paid_status = '1'";
	
	//echo $sqlistguest;
	$sql_resultguest = $conn->query($sqlistguest);
	
	while($rowguest = $sql_resultguest->fetch_array())
	{
		$sqlbills="SELECT * FROM `billing` WHERE reg_id = '".$rowguest['reg_id']."'";
		$sql_resultbills = $conn->query($sqlbills);
		$rowbill = $sql_resultbills->fetch_array();
		$tempthisbill=$rowbill['amount_this_month'];
		$temptobebill=$rowbill['amount_tobe_pay'];
		echo $temptobebill."\n";
		$tempthisbill=$tempthisbill+$rowguest['amount'];
		$temptobebill=$temptobebill+$rowguest['amount'];
		echo $temptobebill."\n"."-----".$rowguest['reg_id']; 
		
		$sql_upda="UPDATE `billing` SET `amount_this_month`='$tempthisbill' ,`amount_tobe_pay`='$temptobebill'  WHERE reg_id = '".$rowguest['reg_id']."'";
		$sql_acc = $conn->query($sql_upda);
		
		
		
		
	} */
	
?>
<?php
session_start(); 
include("../include-files/connection.php");
$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m"), 1));
if(isset($_POST['regno']) and isset($_POST['billno']) and $_POST['regno']!="" and $_POST['billno']!="" and isset($_POST['amount']) and $_POST['amount']!="")
{
	$auther=$_SESSION['messuserid'];
	$reg_id=$_POST['regno'];
	$amount=$_POST['amount'];
	$billno=$_POST['billno'];
	$strinintigercheck=$amount/1;
	if($strinintigercheck<=0){echo "Fail Wrong Amount";die();} else {}
	$thakbaki=0;
	$extrapay=0;
	$amountrecived=0;
	$paidstatus=0;
	$date=date("Y-m-d");
	$sqlist="SELECT * FROM `billing`  WHERE reg_id = '$reg_id' and  date >='$first_day_this_month' and paid = '0' ORDER BY `billing`.`id` DESC LIMIT 1";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	/* echo $sqlist; */
	$rowbill=$sql_result->fetch_array();
	$billofmemcount=mysqli_num_rows($sql_result);
	
	if($billofmemcount==1)
	{
		if($rowbill['amount_tobe_pay']==$amount)
		{
			$thakbaki=0;
			$extrapay=0;
			$amountrecived=$amount;
			$paidstatus=1;
		}
		else if($rowbill['amount_tobe_pay']>$amount)
		{
			$thakbaki=$rowbill['amount_tobe_pay']-$amount;
			$amountrecived=$amount;
			$extrapay=0;
			$paidstatus=2;
		}
		else
		{
			$extrapay=$amount-$rowbill['amount_tobe_pay'];
			$amountrecived=$amount;
			$thakbaki=0;
			$paidstatus=3;
		}
		
		$sql_updatebill="UPDATE `billing` SET `paid`='$paidstatus',`date`='$date',`auther`='$auther', `paid_ammount`='$amount' WHERE id = '$billno'";
		
		$sql_updatedueskippedbill="UPDATE `billing` SET `paid`='4' WHERE reg_id = '$reg_id' and `paid`='0'";
		
		/* Skipped bill. Many times member skip 1 month bill and pay on second month. After paying second bill 
		Previous bill remains unpaid. If croon operation happens that unnecessary bill gets counted.
		member will suffer from repeat billing		
		
		   Here   4   is status of skipped bill .
		
		*/
	
		$sql_updateacc="UPDATE `account_status` SET `thak_baki`='$thakbaki',`extra_payment`='$extrapay',`last_pay_amount`='$amountrecived',`pay_date`='$date'  WHERE reg_id = '$reg_id'";
		
		//echo $sql_updatebill."</br>".$sql_updateacc;
		
		$sql_result_bill = $conn->query($sql_updatebill);
		$sql_result_acc = $conn->query($sql_updateacc);
		$sql_result_skippedduebill = $conn->query($sql_updatedueskippedbill);
		
		if($sql_result_acc and $sql_result_bill and $sql_result_skippedduebill)
		{
			echo "done";
		}
		else
		{
			echo "failed Update";
		}
	}
	else
	{
		echo "failed No bill";
	}
	
}
else
{
	echo "failed Improper POST Value";
}
?>
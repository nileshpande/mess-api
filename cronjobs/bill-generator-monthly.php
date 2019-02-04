<?php
 
include("../include-files/connection.php");
$todaydate=date("Y-m-d");
//$autherid=$_SESSION['messuserid'];

$countbills=0;
$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));  /////  This only for previous month 
//   $first_day_this_month = date('Y-m-01');    /////   This only for current month

////  Get Total monthly rate

$sqlistconf="SELECT * FROM `mess_config`";
$sql_resultconf = $conn->query($sqlistconf);
$rowconf = $sql_resultconf->fetch_array();

////  Get Total Guest this month

$firstdaycurretnmonth=date("Y-m-d", mktime(0, 0, 0, date("m"), 1)); 

$sqlistmember="SELECT * FROM `student` WHERE deactivated = '0' and start_date_mess < '$firstdaycurretnmonth'";
$sql_resultmember = $conn->query($sqlistmember);


$month_end = strtotime('last day of this month', time());

$daysinmonth = date('Y-m-d', $month_end);
 
$lastdaydate=date("Y-m-d", mktime(0, 0, 0, date("m"), 0));

while($rowmember = $sql_resultmember->fetch_array())
{
	$regno=$rowmember['reg_id'];
	$totalkhada=0;		
	$guesttotalamount=0;
	$totalbillthismonth=0;
	$guestcountthismonth=0;
	$ammounttobepay=0;
	$extra_payment=0;
	$sqlistguest="SELECT * FROM `guest` WHERE reg_id = '$regno' and date <= '$lastdaydate' and date >= '$first_day_this_month' and paid_status = '1'";
	
	//echo $sqlistguest;
	$sql_resultguest = $conn->query($sqlistguest);
	
	while($rowguest = $sql_resultguest->fetch_array())
	{
		$guesttotalamount=$guesttotalamount+$rowguest['amount'];
		//echo $guesttotalamount."guest";
		$guestcountthismonth++;
	}
	
	////  Get Total max allowed khades

	$sqlistkhada="SELECT * FROM `khada_table` WHERE reg_id = '$regno' and start_date <= '$lastdaydate' and start_date >= '$first_day_this_month'";
	$sql_resultkhada = $conn->query($sqlistkhada);
	//echo $sqlistkhada;
	while($rowkhada = $sql_resultkhada->fetch_array())
	{
		if($rowkhada['end_date']>$lastdaydate)
		{
			$date1=date_create($rowkhada['start_date']);
			$date2=date_create($lastdaydate);
			$diff=date_diff($date1,$date2);
			$daysdiff = $diff->format("%a");
			$totalkhada=$totalkhada+$daysdiff;
		}
		else
		{
			
			$totalkhada=$totalkhada+$rowkhada['total_khade_demand'];
		}
		//echo "---".$totalkhada."khada yache ahet ---".$rowmember['reg_id'];
	}
	if($totalkhada>$rowconf['khada_limit'])
	{
		$totalkhada=$rowconf['khada_limit'];
	}
	else { } 
	

	////  Subtract amount of khada from monthly rate. by permissible ammount.
	
	$khadadayrate=$rowconf['monthly_rate']/30;
	$khadadayrate=$khadadayrate*$totalkhada;
	
	if($regno==0)
	{
		$totalbillthismonth=$guesttotalamount;
	}
	else
	{
		$sqldeact="SELECT * FROM `active_deactivate` WHERE `reg_id` = '$regno' and `status` = '2' and `date` > '$first_day_this_month' and `date` < '$firstdaycurretnmonth'";
		$sql_resultdeact = $conn->query($sqldeact);
		$rowdeact = $sql_resultdeact->fetch_row();
		$countdeact = $rowdeact[0];
		$sql_resultdeact = $conn->query($sqldeact);
		$rowdeact = $sql_resultdeact->fetch_array();
		
		
		
		if($countdeact>0)
		{
			$khddrate=$rowconf['monthly_rate']/30;
			
			$date_join5=date_create($rowdeact['date']);
			$date_join6=date_create($lastdaydate);
			$diff4=date_diff($date_join5,$date_join6);
			$daysdiff_join3 = $diff4->format("%a");
			
			$deactbill=($daysdiff_join3+1)*$khddrate;
			
			$totalbillthismonth=$totalbillthismonth+$deactbill;
			//print_r($rowdeact);
			//echo $totalbillthismonth."-";
		}
		else
		{
			$totalbillthismonth=$guesttotalamount+$rowconf['monthly_rate'];
		}
		
	}
	
	$totalbillthismonth=$totalbillthismonth-$khadadayrate;
	
	////  Get details from accounts and billing table.
	
	$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id=".$rowmember['reg_id']." and paid = 0 ORDER BY `billing`.`id` DESC LIMIT 1";
	
	$sql_resultbillbaki = $conn->query($sqlistbillbaki);
	$rowbillbaki = $sql_resultbillbaki->fetch_array();
	
	$countbillbaki=mysqli_num_rows($sql_resultbillbaki);
	
	$sqlistbaki="SELECT * FROM `account_status` WHERE reg_id=".$rowmember['reg_id'];
	$sql_resultbaki = $conn->query($sqlistbaki);
	$rowbaki = $sql_resultbaki->fetch_array();
	
	$countaccountbaki=mysqli_num_rows($sql_resultbaki);
	
	if($countbillbaki==0)
	{
		if($countaccountbaki>0)
		{
			$thakbaki=$rowbaki['thak_baki'];
		}
		else
		{
			$thakbaki=0;
		}
		
	}
	else
	{
		
		$laybillbaki=0;
		$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id=".$rowmember['reg_id']." and paid = 0 ORDER BY `billing`.`id` DESC LIMIT 1";
		$sql_resultbillbaki = $conn->query($sqlistbillbaki);
		
		while($rowbillbaki = $sql_resultbillbaki->fetch_array())
		{
			$laybillbaki=$laybillbaki+$rowbillbaki['amount_tobe_pay'];
			
		}
		$thakbaki=$laybillbaki;
		
	}
	
	/// Exception of date of joining
	
	if($rowmember['start_date_mess']>$first_day_this_month and $countdeact==0)
	{
		$khadadayrate=$rowconf['monthly_rate']/30;
		
		$date_join1=date_create($first_day_this_month);
		$date_join2=date_create($rowmember['start_date_mess']);
		$diff=date_diff($date_join1,$date_join2);
		$daysdiff_join = $diff->format("%a");
		
		$joinbill=$daysdiff_join*$khadadayrate;
		
		$totalbillthismonth=$totalbillthismonth-$joinbill;
	}
	else
	{
		
	}
	
	
	
	/* echo $totalbillthismonth;
	die(); */
	
	$ammounttobepay=$totalbillthismonth+$thakbaki;
	if($rowbaki['extra_payment']>0)
	{
		$extra_payment=$rowbaki['extra_payment'];
	}
	else
	{
		$extra_payment=0;
	}
	
	$ammounttobepay=$ammounttobepay-$extra_payment;
	
	////  Store In bill table.
	
	if($ammounttobepay<0)
	{
		$paidstatus=3;
	}
	else
	{
		$paidstatus=0;
	}
	
	//extra payment in negative ahe so already paid rahil.
	
	$sql_updateunpaid_bill="UPDATE `billing` SET `paid`='4'  WHERE reg_id = '$regno' and `paid`='0'";
	$sql_unpaidbill = $conn->query($sql_updateunpaid_bill);
	
	$sql_insert = "INSERT INTO `billing`(`reg_id`, `name`, `thak_baki`, `extra_payment`, `amount_this_month`, `amount_tobe_pay`, `date`,`paid`,`khadathismonth`,`guestthismonth`) VALUES ('$regno','".$rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']."','$thakbaki','$extra_payment','$totalbillthismonth','$ammounttobepay','$todaydate','$paidstatus','$totalkhada','$guestcountthismonth')";
	
	//echo $sql_insert;
	

	$sql_inse = $conn->query($sql_insert);
	//echo "------------------------------------------".$sql_inse,"/////";
	
	$sqlistaccount="SELECT COUNT(*) FROM `account_status` WHERE reg_id='$regno'";
	$sql_resultaccount = $conn->query($sqlistaccount);
	$rowaccount = $sql_resultaccount->fetch_row();
	$countaccount = $rowaccount[0];
	
	if($countaccount>0)
	{
		$sql_upda="UPDATE `account_status` SET `thak_baki`='$thakbaki' ,`extra_payment`='$extra_payment', `date`='$todaydate'  WHERE reg_id = '$regno'";
		$sql_acc = $conn->query($sql_upda);
		//echo $extra_payment."/////////";
		///skipped bill which are totaly unpaid.
		
	}
	else
	{
		$thisyear=date("Y");
		$sql_insert_acc = "INSERT INTO `account_status`(`reg_id`, `name`, `thak_baki`, `extra_payment`, `date`, `year`) VALUES ('$regno','".$rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']."','$thakbaki','$extra_payment','$todaydate','$thisyear')";
		
		$sql_acc = $conn->query($sql_insert_acc);
		//echo "insert";
	}
		/*die();
	////  Update Accounts table.

	$sqlistguest="SELECT * FROM `student` WHERE deactivated = 0";
	$sql_resultguest = $conn->query($sqlistguest);
	$rowguest = $sql_resultguest->fetch_array();
	*/
	$countbills++;
}

?>
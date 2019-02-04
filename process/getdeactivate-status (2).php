<?php
include("../include-files/connection.php");
$countbills=0;
$todaydate=date("Y-m-d");
$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m"), 1));  /////  This only for previous month 
//   $first_day_this_month = date('Y-m-01');    /////   This only for current month
$month_end = strtotime('last day of this month', time());
//$firstdaycurretnmonth=date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
$daysinmonth = date('Y-m-d', $month_end);
$guesttotalamount=0;
$lastdaydate=date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
$lastdaydatecurrentmonth=date("Y-m-d", mktime(0, 0, 0, date("m")+1	, 0));
if(isset($_POST['dateclose']) and isset($_POST['memberid']))
{
	$reg_id=$_POST['memberid'];
	$sqlist="SELECT * FROM `student` WHERE reg_id = '$reg_id' and deactivated = '0'";
	$sql_result = $conn->query($sqlist);
	$row = $sql_result->fetch_array();
	$countactivestud=mysqli_num_rows($sql_result);
	if($countactivestud==0)
	{
		echo "Deactivated"; die();
	}
	else 
	{
		$sqldeact="SELECT * FROM `active_deactivate` WHERE `reg_id` = '$reg_id' and `status` = '2' ORDER BY `active_deactivate`.`id` DESC LIMIT 1";
		//echo $sqldeact; die();
		$sql_resultdeact = $conn->query($sqldeact);
		$rowdeact = $sql_resultdeact->fetch_row();
		$countdeact = $rowdeact[0];
		$sql_resultdeact = $conn->query($sqldeact);
		$rowdeact = $sql_resultdeact->fetch_array();
	}
	$sqlconf="SELECT * FROM `mess_config`";
	$sql_result_conf = $conn->query($sqlconf);
	$row_conf = $sql_result_conf->fetch_array();
	
	$dayrate=$row_conf['monthly_rate']/30;
	$dinnerrate=$dayrate/2;
	$lunchrate=$dinnerrate;
	$nashta=$row_conf['nashta_rate'];
	$guestrate=$row_conf['outsider_member_rate'];
	
	//////// Here need to calculate extra or thak baki 
	
	$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id='$reg_id' and paid = 0 ORDER BY `billing`.`id` DESC LIMIT 1";

	$sql_resultbillbaki = $conn->query($sqlistbillbaki);
	$rowbillbaki = $sql_resultbillbaki->fetch_array();
	
	$countbillbaki=mysqli_num_rows($sql_resultbillbaki);
	
	$sqlistbaki="SELECT * FROM `account_status` WHERE reg_id='$reg_id'";
	$sql_resultbaki = $conn->query($sqlistbaki);
	$rowbaki = $sql_resultbaki->fetch_array();
	
	$countaccountbaki=mysqli_num_rows($sql_resultbaki);
	
	if($countbillbaki==0)
	{
		if($countaccountbaki>0)
		{
			$thakbaki=$rowbaki['thak_baki'];
			$extrapay=$rowbaki['extra_payment'];
		}
		else
		{
			$thakbaki=0;
			$extrapay=0;
		}
		
	}
	else
	{
		
		$laybillbaki=0;
		$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id='$reg_id' and paid = 0";
		$sql_resultbillbaki = $conn->query($sqlistbillbaki);
		
		while($rowbillbaki = $sql_resultbillbaki->fetch_array())
		{
			$laybillbaki=$laybillbaki+$rowbillbaki['amount_tobe_pay'];
			
		}
		$thakbaki=$laybillbaki;
		
	}
	
	
	/////////////////////
	
	$sqlistguest="SELECT * FROM `guest` WHERE reg_id = '$reg_id' and date >= '$lastdaydatecurrentmonth' and date <= '$first_day_this_month' and paid_status = '1'";
				
	//echo $sqlistguest;
	$sql_resultguest = $conn->query($sqlistguest);
	
	while($rowguest = $sql_resultguest->fetch_array())
	{
		$guesttotalamount=$guesttotalamount+$rowguest['amount'];
		//echo $guesttotalamount."guest";
	}
				
	?>
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Guest Rate</h4>
		<p class="category">Form <?php 
		
		$first_day_this_month = date('Y-m-01'); echo $first_day_this_month; 
		$dateclose=$_POST['dateclose'];
		
		$date1=date_create($first_day_this_month);
		$date2=date_create($dateclose);
		$diff=date_diff($date1,$date2);
		$daysdiff = $diff->format("%a");
		
		$month_end = strtotime('last day of this month', time());
		$daysinmonth = date('d', $month_end);
		
		////   Kiti divas khalla.
		
		if($countdeact>0)
		{
			$sqlcount="SELECT * FROM `attendance` WHERE reg_id_student = '$reg_id' and date >= '".$rowdeact['date']."'";
		}
		else
		{
			$sqlcount="SELECT * FROM `attendance` WHERE reg_id_student = '$reg_id' and date >= '$first_day_this_month'";
		}
		
		$sql_result_count = $conn->query($sqlcount);
		$guestpaisa=0;
		$nashtapaieformonthlybill=0;
		while($rowcount=$sql_result_count->fetch_array())
		{
			if($rowcount['shift_time']==1)
			{
				$nashtapaieformonthlybill=$nashtapaieformonthlybill+$nashta;
				$guestpaisa=$guestpaisa+$nashta;
			}
			else if($rowcount['shift_time']==2)
			{
				$guestpaisa=$guestpaisa+$guestrate;
			}
			else if($rowcount['shift_time']==3)
			{
				$guestpaisa=$guestpaisa+$guestrate;
			}
			else
			{ }
			//echo $guestpaisa."--";
		}
		$guestpaisa=$guestpaisa+$guesttotalamount;
		
		if($countdeact>0 and $rowdeact['date']>=$first_day_this_month)
		{
			$date_join4=date_create($rowdeact['date']);
			$date_join6=date_create($_POST['dateclose']);
			$diff=date_diff($date_join4,$date_join6);
			$daysdiff_join2 = $diff->format("%a");
		}
		else
		{
			if($row['start_date_mess']>=$first_day_this_month)
			{
				
				
				$date_join4=date_create($row['start_date_mess']);
				$date_join6=date_create($_POST['dateclose']);
				$diff=date_diff($date_join4,$date_join6);
				$daysdiff_join2 = $diff->format("%a");
				
				
			}
			else
			{
				$date_join4=date_create($first_day_this_month);
				$date_join6=date_create($_POST['dateclose']);
				$diff=date_diff($date_join4,$date_join6);
				$daysdiff_join2 = $diff->format("%a");
			}
		}
		
		
		
		if($thakbaki>0)
		{
			$guestpaisa=$guestpaisa+$thakbaki;
		}
		else if($extrapay>0)
		{
			$guestpaisa=$extrapay-$guestpaisa;
		}
		else { }
		
		?> To Closing Day</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8">
				<h4 class="title "><?php echo $daysdiff_join2;  ?> Days of Your this month.</h4>
				<h4 class="title"><?php echo (round($guestpaisa,2)); ?> &#8377; Ammount</h4>
				<form method="POST" id="guestdeactivate">
				<input type="text" name="member" readonly hidden required value="<?php echo $reg_id; ?>" />
				<input type="text" name="amount" readonly hidden required value="<?php echo $guestpaisa; ?>" />
				<input type="text" name="thismonthpresentdays" readonly hidden required value="<?php echo $daysdiff_join2; ?>" />
				<input type="text" name="date" readonly hidden required value="<?php echo $dateclose; ?>" />
				<input type="text" name="type" readonly hidden required value="1" />
				<input type="submit" class="btn btn-success btn-fill btn-lg" name="submit" value="Submit As Guest"  onclick="return deactivateguest();" />
				</form>
			</div>
			<div class="col-lg-12">
			
			
			</div>
			
		</div>
	</div>
	<div class="card-footer">
	   
		<hr>
		<div class="stats">
			<i class="ti-check"></i> Some details	
		</div>
	</div>
</div>

</div>
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Monthly Rate</h4>
		<p class="category">CLearance Form</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8">
				<h4 class="title ">Present Days :- <?php
				
				$totalkhada=0;		
				
				$totalbillthismonth=0;
				$ammounttobepay=0;
				$extra_payment=0;
				
				
				////  Get Total max allowed khades

				$sqlistkhada="SELECT * FROM `khada_table` WHERE reg_id = '$reg_id' and start_date <= '$lastdaydate' and start_date >= '$first_day_this_month'";
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
				if($totalkhada>$row_conf['khada_limit'])
				{
					$totalkhada=$row_conf['khada_limit'];
				}
				else { } 
				

				////  Subtract amount of khada from monthly rate. by permissible ammount.
				
				$khadadayrate=$row_conf['monthly_rate']/30;
				$khadadayrate=$khadadayrate*$totalkhada;
				
				
				$totalbillthismonth=$guesttotalamount+$row_conf['monthly_rate'];
				
				
				$totalbillthismonth=$totalbillthismonth-$khadadayrate;
				
				////  Get details from accounts and billing table.
				
				$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id='$reg_id' and paid = 0";
				$sql_resultbillbaki = $conn->query($sqlistbillbaki);
				$rowbillbaki = $sql_resultbillbaki->fetch_array();
				
				$countbillbaki=mysqli_num_rows($sql_resultbillbaki);
				
				$sqlistbaki="SELECT * FROM `account_status` WHERE reg_id='$reg_id'";
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
					$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id='$reg_id' and paid = 0";
					$sql_resultbillbaki = $conn->query($sqlistbillbaki);
					
					while($rowbillbaki = $sql_resultbillbaki->fetch_array())
					{
						$laybillbaki=$laybillbaki+$rowbillbaki['amount_tobe_pay'];
						
					}
					$thakbaki=$laybillbaki;
					
				}
				
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
				////  28 or 31 days monthly rate are fix
				$presentdaysthismonth=30-$totalkhada; 
				//echo $presentdaysthismonth;
				/* $presentdaysthismonth=$daysinmonth-$totalkhada; echo $presentdaysthismonth;  */
				
				 $monthlypaybill=$presentdaysthismonth*$dayrate;
				
				//// This code make change according date of joining if joinning and deactivate month are same.
				
				if($countdeact>0 and $rowdeact['date']>=$first_day_this_month)
				{
					$date_join4=date_create($rowdeact['date']);
					$date_join6=date_create($_POST['dateclose']);
					$diff=date_diff($date_join4,$date_join6);
					$daysdiff_join = $diff->format("%a");
					$joinbill=$daysdiff_join*$dayrate;
						
						$monthlypaybill=$joinbill;
				}
				else
				{
					if($row['start_date_mess']>=$first_day_this_month)
					{
						
						
						$date_join4=date_create($row['start_date_mess']);
						$date_join6=date_create($_POST['dateclose']);
						$diff=date_diff($date_join4,$date_join6);
						$daysdiff_join = $diff->format("%a");
						$joinbill=$daysdiff_join*$dayrate;
						
						$monthlypaybill=$joinbill;
					}
					else
					{ 
						$date_join4=date_create($first_day_this_month);
						$date_join6=date_create($_POST['dateclose']);
						$diff=date_diff($date_join4,$date_join6);
						$daysdiff_join = $diff->format("%a");
						$joinbill=$daysdiff_join*$dayrate;
						
						$monthlypaybill=$joinbill;
					}
				}
				
				
					$monthlypaybill=$monthlypaybill+$nashtapaieformonthlybill;
					
					if($thakbaki>0)
					{
						$monthlypaybill=$monthlypaybill+$thakbaki;
					}
					else if($extrapay>0)
					{
						$monthlypaybill=$extrapay-$monthlypaybill;
					}
					else { }
					
					echo $daysdiff_join-$totalkhada;
					?>
					</h4>
				<h4 class="title">
					<?php
				echo (round($monthlypaybill,2)); ?> &#8377; Ammount</h4>
				<form method="POST" id="monthlydeactivate">
				<input type="text" name="member" readonly hidden required value="<?php echo $reg_id; ?>" />
				<input type="text" name="amount" readonly hidden required value="<?php echo $monthlypaybill; ?>" />
				<input type="text" name="thismonthpresentdays" readonly hidden required value="<?php echo $daysdiff_join; ?>" />
				<input type="text" name="date" readonly hidden required value="<?php echo $dateclose; ?>" />
				<input type="text" name="type" readonly hidden required value="2" />
				<input type="submit" class="btn btn-success btn-fill btn-lg" name="submit" value="Submit As Monthly"  onclick="return deactivatemonthly();" />
				</form>
			</div>
			<div class="col-lg-12">
			
			
			</div>
			
		</div>
	</div>
	<div class="card-footer">
	   
		<hr>
		<div class="stats">
			<i class="ti-check"></i> Some details	
		</div>
	</div>
</div>

</div>

	<?php
}
else
{
	echo "false";
}
?>
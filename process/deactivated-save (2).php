<?php
include("../include-files/connection.php");
$get_lost = false;
if(isset($_POST['member']) and isset($_POST['amount']) and isset($_POST['date']))
{
	if(isset($_POST['member']) and ($_POST['member']!=""))
	{
		$member = $_POST['member'];	
	}
	else { $get_lost=true;  }	//	required
	
	if(isset($_POST['amount']) and ($_POST['amount']!=""))
	{
		$amount = $_POST['amount'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['type']) and !empty($_POST['type']))
	{
		$type = $_POST['type'];	
		
	}
	else { $get_lost=true; echo $get_lost; }	//	required
	
	if(isset($_POST['thismonthpresentdays']) and ($_POST['thismonthpresentdays']!=""))
	{
		$thismonthpresentdays = $_POST['thismonthpresentdays'];	
	}
	else { $get_lost=true; }	//	required
	
	if(isset($_POST['date']) and ($_POST['date']!=""))
	{
		$date = $_POST['date'];	
	}
	else { $get_lost=true;  }	//	required
	
	if($get_lost==true)
	{
		?>
<div class="row" >
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Error</h4>
		<p class="category">Error</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8 text-center">
				<div class="swal2-icon swal2-success animate" style="display: block;"><span class="line tip animate-success-tip"></span> <span class="line long animate-success-long"></span><div class="placeholder"></div> <div class="fix"></div></div>
				<h2 class="swal2-title">Error !</h2>
			</div>
			<?php print_r($_POST); ?>
			
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

	</div>
		<?php
		die();
	}
	else
	{
		$sql_upd = "UPDATE `student` SET deactivated = '1' , deactivated_date = '$date' , deactivate_type = '$type' WHERE reg_id = '$member'";
		 
		$sql_updated = $conn->query($sql_upd);
		
		$sql_status_tbl="INSERT INTO `active_deactivate` (`reg_id`,`date`,`status`,`amount`,`paid`) values('$member','$date','1','0','0')";
		$sql_updated_status_tbl = $conn->query($sql_status_tbl);
		
		$sqlistmember="SELECT * FROM `student` WHERE reg_id = '$member'";
		$sql_resultmember = $conn->query($sqlistmember);
		$rowmember = $sql_resultmember->fetch_array();
		$extra_payment=0;
		if($amount>0)
		{
			$amount_this_month=$amount;	
		}
		else if($amount<0)
		{
			$extra_payment=$amount*-1;
		}
		else {}
		$sql_insertbill="INSERT INTO `billing`(`reg_id`, `name`, `thak_baki`, `extra_payment`, `amount_this_month`, `amount_tobe_pay`, `date`,`note`,`paid`,`paid_ammount`) VALUES ('$member','".$rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']."','0','$extra_payment','$amount','$amount','$date','Deactivated Last Bill','1','$amount')";
		
		$sql_resultbill = $conn->query($sql_insertbill);
		
		$sqlistaccount="SELECT COUNT(*) FROM `account_status` WHERE reg_id='$member'";
		$sql_resultaccount = $conn->query($sqlistaccount);
		$rowaccount = $sql_resultaccount->fetch_row();
		$countaccount = $rowaccount[0];
		
		if($countaccount>0)
		{
			$sql_upd_acc = "UPDATE `account_status` SET last_pay_amount = '$amount' , thak_baki = '0', extra_payment = '0' ,  pay_date = '$date', closed = '1' WHERE reg_id = '$member'";
		}
		else
		{
			/*$thisyear=date("Y");
			$sql_upd_acc = "INSERT INTO `account_status`(`reg_id`, `date`,`last_pay_amount`,`pay_date`,`year`,`closed`) VALUES ('$member','$date','$amount','$date','$thisyear','1')";*/
			$sql_upd_acc = "UPDATE `account_status` SET last_pay_amount = '$amount' , thak_baki = '0', extra_payment = '0' ,   pay_date = '$date', closed = '1' WHERE reg_id = '$member'";
		}
		
		
		 
		$sql_updated_acc = $conn->query($sql_upd_acc);
		
		$sql_updatedueskippedbill="UPDATE `billing` SET `paid`='4' WHERE reg_id = '$member' and `paid`='0'";
		
		$sql_updated_bill_all = $conn->query($sql_updatedueskippedbill);
		
		if($sql_updated and $sql_updated_acc and $sql_resultbill and $sql_updated_bill_all)
		{
		?>
<div class="row" >
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Deactivated</h4>
		<p class="category">Completed</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8 text-center">
				<div class="swal2-icon swal2-success animate" style="display: block;"><span class="line tip animate-success-tip"></span> <span class="line long animate-success-long"></span><div class="placeholder"></div> <div class="fix"></div></div>
				<h2 class="swal2-title">Deactivated !</h2>
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

	</div>
		<?php		
		}
		else
		{
			?>
<div class="row" >
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Error</h4>
		<p class="category">Error</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8 text-center">
				<div class="swal2-icon swal2-success animate" style="display: block;"><span class="line tip animate-success-tip"></span> <span class="line long animate-success-long"></span><div class="placeholder"></div> <div class="fix"></div></div>
				<h2 class="swal2-title">Error !</h2>
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

	</div>
		<?php
		die();
		}
		

	}
}
else
{
?>
<div class="row" >
<div class="col-md-6">
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Error</h4>
		<p class="category">Error</p>
	</div>
	<div class="card-content">
		<div class="row">
			
			<div class="col-lg-8 text-center">
				<div class="swal2-icon swal2-success animate" style="display: block;"><span class="line tip animate-success-tip"></span> <span class="line long animate-success-long"></span><div class="placeholder"></div> <div class="fix"></div></div>
				<h2 class="swal2-title">Error !</h2>
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

	</div>
<?php
}
?>
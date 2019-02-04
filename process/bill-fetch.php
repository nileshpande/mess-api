<?php 
include("../include-files/connection.php");
$first_day_this_month=date("Y-m-d", mktime(0, 0, 0, date("m"), 1));
	if(isset($_POST['reg_id']) and $_POST['reg_id']!="" )
	{
		$reg_id=$_POST['reg_id'];

		$sqlist="SELECT * FROM `student` WHERE reg_id = '$reg_id'";
		$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
		$rowmember=$sql_result->fetch_array();
		$billofmemcount=mysqli_num_rows($sql_result);
	}
	else
	{
		?>
		<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category">No Data</p>
	</div>
		<div class="card-content">
			<div class="row" >
			<h3>No Data</h3>
			</div>
		</div>
		<div class="card-footer">
			
			<hr>
			<div class="stats">
				<i class="ti-check"></i> Info
			</div>
		</div>
	</div>	
		<?php
		die();
		
	}
$ontimelooptop=0;
$totaldata=0;
//echo $sqlist;

if($billofmemcount>0)
{
	$sqlistmember="SELECT * FROM `billing` WHERE paid = '0' and reg_id = '$reg_id' and date >='$first_day_this_month' ORDER BY `billing`.`id` DESC";
	$sql_resultmember = $conn->query($sqlistmember);
	$rowbill=$sql_resultmember->fetch_array();
	?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']; ?></p>
	</div>
	<div class="card-content">
		<div class="row" >
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Bill</h4>
				<p class="category"><?php $month = date('F', strtotime('-1 months', strtotime($rowbill['date'])));  echo $month;

				 ?></p>
			</div>
			<div class="card-content">
				<table id="bootstrap-table" class="table table-hover" style="margin-top: 0px;">
				<thead>
					<tr>
						<th class="bs-checkbox ">
						Item
						</th>
						<th class="bs-checkbox ">
						Calculation
						</th>
					</tr>
				</thead>
				<tbody>
				<tr>
						<td>Khade This month :-  <?php echo (round($rowbill['khadathismonth'],2)); ?></td>
						<td>Guest This month  :- <?php echo (round($rowbill['guestthismonth'],2)); ?></td>
					</tr>
					<tr>
						<td>Extra Payment</td>
						<td> <?php echo (round($rowbill['extra_payment'],2)); ?></td>
					</tr>
					<tr>
						<td>Thak Baki</td>
						<td> <?php echo (round($rowbill['thak_baki'],2)); ?></td>
					</tr>
					<tr>
						<td>Current Month</td>
						<td> <?php echo (round($rowbill['amount_this_month'],2)); ?></td>
					</tr>
					<tr>
						<td>Total </td>
						<td> <?php echo (round($rowbill['amount_tobe_pay'],2)); ?></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="card-footer" id="paidbill"> 
				
				<hr>
				<form action="" method="POST" id="billpayment" >
					<div class="form-group">
					<input type="text"  name="regno" value="<?php echo $reg_id; ?>" hidden readonly required id="regno" />
					<input type="text"  name="billno" value="<?php echo $rowbill['id']; ?>" hidden readonly required id="billno" />
					<input type="number" class="form-control" name="amount" id="amount" min="1" max="9999" />
					</div>
					<div class="form-group">
					<input type="Submit" name="submit" value="submit" class="btn btn-success" onclick="return payment();"  />
					</div>
				</form>
			</div>
			<div class="card-footer" id="billprint" style="display:none;">
				<h3 class="title text-success">Paid</h3>
				<input name="b_print" type="button" class="ipt"   onClick="printdiv('bill');" value=" Print ">
			</div>
		</div>
<?php
}
else
{
	?>
<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']; ?></p>
	</div>
		<div class="card-content">
			<div class="row" >
			<h3>No Data</h3>
			</div>
		</div>
		<div class="card-footer">
			
			<hr>
			<div class="stats">
				<i class="ti-check"></i> Info
			</div>
		</div>
	</div>
	<?php
	die();
}
if($billofmemcount>0)
{
	?>
</div>
	</div>
	<div class="card-footer">
		
		<hr>
		<div class="stats">
			<i class="ti-check"></i> Payment	
		</div>
	</div>
</div>								

<?php
}							

if($billofmemcount==0)
{
	?>
	<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $rowmember['fname']." ".$rowmember['mname']." ".$rowmember['lname']; ?></p>
	</div>
		<div class="card-content">
			<div class="row" >
			<div class="col-md-4">
			<h3>No Data</h3>
			</div>
			</div>
		</div>
		<div class="card-footer">
			
			<hr>
			<div class="stats">
				<i class="ti-check"></i> Info
			</div>
		</div>
	</div>	
	<?php
}
?>
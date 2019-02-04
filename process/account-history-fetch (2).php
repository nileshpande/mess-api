<?php 
include("../include-files/connection.php");

	if(isset($_POST['reg_id']) and $_POST['reg_id']!="" )
	{
		$reg_id=$_POST['reg_id'];

		$sqlist="SELECT * FROM `billing` INNER JOIN student ON billing.reg_id=student.reg_id  WHERE student.reg_id = '$reg_id' and billing.reg_id = '$reg_id'";
		$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
		
	}
	else
	{
		?>
		<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></p>
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
		
		
	}
$ontimelooptop=0;
$totaldata=0;
//echo $sqlist;
while($row=$sql_result->fetch_array())
{
$totaldata++;
if($ontimelooptop==0)
{	
?>

<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></p>
	</div>
	<div class="card-content">
		<div class="row" >
<?php
$ontimelooptop++;
}
else
{
	
}	

?>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
			<h4 class="card-title"><?php $month = date('F', strtotime('-1 months', strtotime($row['date'])));  echo $month;  ?></h4>
				
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
						<td>Extra Payment</td>
						<td> <?php echo (round($row['extra_payment'],2)); ?></td>
					</tr>
					<tr>
						<td>Thak Baki</td>
						<td> <?php echo (round($row['thak_baki'],2)); ?></td>
					</tr>
					<tr>
						<td>Current Month</td>
						<td> <?php echo (round($row['amount_this_month'],2)); ?></td>
					</tr>
					<tr>
						<td>Total </td>
						<td> <?php echo (round($row['amount_tobe_pay'],2)); ?></td>
					</tr>
					<tr>
						<td>Note </td>
						<td> <?php echo $row['note']; ?></td>
					</tr>
<?php if($row['paid']>=1 and $row['paid']< 4){ ?>
					<tr>
						<td>Date </td>
						<td><?php $billdate = strtotime($row['date']);
							echo date('d/m/Y', $billdate);  ?>
						</td>
					</tr>
					<?php } else {  ?>
					<tr>
						<td>--
						<td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
			</div>
			<div class="card-footer">
				
				<hr>
				Status :<?php if($row['paid']==1){ echo $row['paid_ammount']." &#8377;  Paid"; } else if($row['paid']==2) { echo (round($row['paid_ammount'],2)); echo " &#8377;  Paid"; }  else if($row['paid']==3) { echo $row['paid_ammount']." &#8377;  Paid"; } else if($row['paid']==4) { echo " UnPaid & skipped"; }else { echo "Unpaid"; } ?>
				
			</div>
		</div>

	</div>
	
	<?php
	
}
if($totaldata>0)
{
	?>
</div>
	</div>
	<div class="card-footer">
		
		<hr>
		<div class="stats">
			<i class="ti-check"></i> Old Bills
		</div>
	</div>
</div>								

<?php
}							

if($totaldata==0)
{
	?>
	<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category"><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></p>
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
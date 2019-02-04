<?php 
include("../include-files/connection.php");

	if(isset($_POST['reg_id']) and $_POST['reg_id']!="" )
	{
		$reg_id=$_POST['reg_id'];

		$sqlist="SELECT * FROM `advance_record` INNER JOIN student ON advance_record.reg_id=student.reg_id  WHERE student.reg_id = '$reg_id' and advance_record.reg_id = '$reg_id'";
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
	<div class="col-md-4" id="printableArea<?php echo $totaldata; ?>">
		<div class="card">
			<div class="card-header">
			<h4 class="card-title"><?php echo $row['date']; ?></h4>
				
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
						<td>Total </td>
						<td> <?php echo (round($row['amount'],2)); ?></td>
					</tr>
					<tr>
						<td>Extra Payment</td>
						<td> <?php echo (round($row['extra_cr'],2)); ?></td>
					</tr>
					<tr>
						<td>Thak Baki</td>
						<td> <?php echo (round($row['thakbaki_cr'],2)); ?></td>
					</tr>
					 
				</tbody>
				</table>
			</div>
			<div class="card-footer">
				<input type="button" onclick="printdiv('printableArea<?php echo $totaldata; ?>')" value="print a div!" />
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
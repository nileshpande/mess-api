<?php 
include("../include-files/connection.php");
$todaydate=date("Y-m-d");
if(isset($_POST['reg_id']) and $_POST['reg_id']!="" )
{
	$reg_id=$_POST['reg_id'];
	$rowcount=0;
	$sqlist="SELECT COUNT(*) FROM `student` WHERE reg_id = '$reg_id'";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	$row = $sql_result->fetch_row();
	$rowcount = $row[0];
}
else
{
	$rowcount=0;	
}
if($rowcount>0)
{
	$sqlist="SELECT * FROM `student` WHERE reg_id = '$reg_id' and start_date_mess <= '$todaydate' and deactivated = 0";
	$sql_result = $conn->query($sqlist);
	$row=$sql_result->fetch_array();
	
	if(mysqli_num_rows($sql_result) == 0)
	{
		?>
	<div class="col-md-8" id="history">	<div class="card">
	<div class="card-header">
		<h4 class="card-title">Account Info</h4>
		<p class="category">  </p>
	</div>
		<div class="card-content">
			<div class="row">
			<div class="col-md-8">
			<h3>No Data</h3></br> May be</br> 1) wrong Number</br> or </br> 2) Deactivated.
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
	</div>
	<?php
		
		
		die();
	}
	else { }
	
	$todaydate=date('Y-m-d');
	$sqlkhada="SELECT COUNT(*) FROM `khada_table` WHERE reg_id = '$reg_id' and start_date <= '$todaydate' and end_date >= '$todaydate'";
	$sql_result_khada = $conn->query($sqlkhada);
	$row_khada = $sql_result_khada->fetch_row();
	$khadacount = $row_khada[0];
?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Presenty</h4>
			<p class="category">Latest Month</p>
		</div>
		<div class="card-content">
			<div class="row" >
			<form <?php if($khadacount>0){ ?>id="khadaremoval" <?php } else { ?>id="presentysubmit" <?php } ?> action="" method="POST">
			<input type="text" hidden readonly name="reg_id" value="<?php echo $row['reg_id']; ?>" id="reg_id" />
				<div class="col-lg-4">
					<img src="student-images/<?php echo $row['photo']; ?>" alt="Raised Image" class="rounded">
				</div>
				<div class="col-lg-8">
					<div class="radio">
						<input type="radio" name="radio1" id="radio2" value="option2" checked="">
						<label for="radio2">
							Self
						</label>
					</div>
					<div class="radio " >
						<input type="radio" name="radio1" id="radio1" value="option1">
						<label for="radio1">
							Freind
						</label>
					</div>
					<p class="text-danger"><?php echo $row['department']; ?> - <?php echo $row['branch']; ?></p>
					<h4 class="title ">No:- <?php echo $row['room_no']; ?> ---  Hostel No:- <?php echo $row['hostel_no']; ?></h4>
					<h4 class="title">Contact No:- <?php echo $row['mobile']; ?></h4>
				</div>
				<div class="col-lg-4 text-center">
				<h5 class="title text-danger">
			
			<?php 
					
			$sqlistbaki="SELECT * FROM `account_status` WHERE reg_id=".$row['reg_id'];
			$sql_resultbaki = $conn->query($sqlistbaki)or die(mysqli_error($conn));
			$rowbaki = $sql_resultbaki->fetch_array();
			
			$sqlistbillbaki="SELECT * FROM `billing` WHERE reg_id=".$row['reg_id']." and paid = 0";
			$sql_resultbillbaki = $conn->query($sqlistbillbaki);
			$rowbillbaki = $sql_resultbillbaki->fetch_array();
			
			$countbillbaki=mysqli_num_rows($sql_resultbillbaki);
			
			if($countbillbaki>0)
			{
				echo "&#8377; ".(round($rowbillbaki['amount_this_month'],2));
				echo " Bill Pending Ahe </br>";
				
			}
			else {}
			echo "&#8377;  ".(round($rowbaki['thak_baki'],2)); echo " Thak baki </br>";
			if($rowbaki['extra_payment']>0)
			{echo "&#8377;  ".(round($rowbaki['extra_payment'],2)); echo " Extra Payment </br>";}
			else {}
			?> 
			</h5>
				</div>
				<div class="col-lg-12">
					<div class=" col-lg-4 text-center">
						<h3 class="title text-success"><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></h3>
					</div>
					
<?php 
	
	if($khadacount>0)
	{
?>
					<div class=" col-lg-12 text-center">
						<h5 class="title text-danger">Khada chalu ahe. Thali denyasathi Remove Khada Var Click kara</h5>
					</div>
					<div class="col-lg-4">
						<button type="submit" class="btn btn-warning btn-fill btn-wd" onclick="return removekhada();"   >Remove Khada</button>
					</div>
					<div class="col-lg-4">
						<a href="presentday.php?msg=Enter Number" class="btn btn-danger btn-fill btn-wd"  >No Check Again</a>
					</div>
<?php
	}
else
	{	
?>
					<div class="col-lg-4">
						<button type="submit" class="btn btn-success btn-fill btn-wd" onclick="return presentylava();"   >Submit</button>
					</div>
					
					<div class="col-lg-4">
						<a href="presentday.php?msg=Enter Number" class="btn btn-danger btn-fill btn-wd"  >No Check Again</a>
					</div>
<?php } ?>
				</div>
			</form>
			</div>
		</div>
		<div class="card-footer">
			
			<hr>
			<div class="stats">
				<i class="ti-check"></i> Verify Details
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Advance pay</h4>
			<p class="category">Will Adjuste in upcomming bill.</p>
		</div>
		<div class="card-content">
			<div class="row" >
				<form id="advancepayall" action="" method="POST">
				<input type="text" hidden readonly name="addreg_id" value="<?php echo $row['reg_id']; ?>" id="addreg_id" />
				<div class="col-lg-8">
					<input type="number"  name="advanceamt" min="1" max="4000" class="form-control" required="true" aria-required="true" id="advanceamt" /> 
				</div>
				<div class="col-lg-4">
					<input type="submit" name="Submit" value="submit" class="btn btn-success" onclick="return advanceghya();" />
				</div>
				</form>
			</div>
		</div>
		<div class="card-footer"><hr><div class="stats"><i class="ti-check"></i> Verify Details</div></div>
	</div>
<?php
}
else
{
?>
<div class="card">
<div class="card-header">
	<h4 class="card-title">Account Info</h4>
	<p class="category">No</p>
</div>
<div class="card-content">
	<div class="row" >
	<div class="col-lg-12">
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
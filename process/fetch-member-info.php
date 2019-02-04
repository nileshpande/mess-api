<?php 
include("../include-files/connection.php");

if(isset($_POST['regno']) )
{
	$reg_id=$_POST['regno'];
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
	$sqlist="SELECT * FROM `student` WHERE reg_id = '$reg_id' and deactivated = 0";
	$sql_result = $conn->query($sqlist);
	$row=$sql_result->fetch_array();
	
	if(mysqli_num_rows($sql_result) == 0)
	{
		echo "fail";
		die();
	}
	else { }
	
	$todaydate=date('Y-m-d');
	$sqlkhada="SELECT COUNT(*) FROM `khada_table` WHERE reg_id = '$reg_id' and start_date <= '$todaydate' and end_date >= '$todaydate'";
	$sql_result_khada = $conn->query($sqlkhada);
	$row_khada = $sql_result_khada->fetch_row();
	$khadacount = $row_khada[0];
	
?>
<div class="col-lg-4">
	<img src="student-images/<?php echo $row['photo']; ?>" alt="Raised Image" class="rounded">
</div>
<div class=" col-lg-4 text-center">
	<h3 class="title text-success"><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></h3>
</div>
<div class="col-lg-8">

	<p class="text-danger"><?php echo $row['department']; ?> - <?php echo $row['branch']; ?></p>
	<h4 class="title ">No:- <?php echo $row['room_no']; ?> ---  Hostel No:- <?php echo $row['hostel_no']; ?></h4>
	<h4 class="title">Contact No:- <?php echo $row['mobile']; ?></h4>
</div>

<?php
}
else
{
echo "fail";
	
}
?>


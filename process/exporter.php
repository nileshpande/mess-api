<?php
include("../include-files/connection.php");
$todaydate=date("Y-m-d");
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$csv_export = '';
	
	if($_POST['type']==1)
	{
		include("../cronjobs/db-backup-cron.php");
		$dbdone = backup_tables('localhost','root','','mymess');
		echo $dbdone;
	}

	if($_POST['type']==2)
	{
		/************    Data exported in   .CSV    and . Xlsx   both format ***********/
		
		$firstrow=true;
		$deptstud=$_POST['deptstud'];
		$sqlist="SELECT * FROM `student` WHERE deactivated = '0' and department = '$deptstud' and reg_id > '0'";
		$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
		$file="file";
		$filetype=".csv";
		$fp = fopen($file.$filetype, 'w');
		$table="<table><tr><td>Id</td><td>Name</td><td>Department</td><td>Mobile</td><td>Branch</td><td>Hostel No</td><td>Room No</td><td>Bllod Group</td><td>Joining date</td><td>Deactivated Date any</td><td>Status deactivated</td><td>Pursuing</td></tr>";
		while($row=$sql_result->fetch_assoc())
		{
			$table=$table."<tr><td>".$row['reg_id']."</td><td>".$row['fname']." ".$row['mname']." ".$row['lname']."</td>";
			$table=$table."<td>".$row['department']."</td>";
			$table=$table."<td>".$row['mobile']."</td>";
			$table=$table."<td>".$row['branch']."</td>";
			$table=$table."<td>".$row['hostel_no']."</td>";
			$table=$table."<td>".$row['room_no']."</td>";
			$table=$table."<td>".$row['blood_grp']."</td>";
			$table=$table."<td>".$row['start_date_mess']."</td>";
			$table=$table."<td>".$row['deactivated_date']."</td>";
			$table=$table."<td>".$row['deactivated']."</td>";
			$table=$table."<td>".$row['course']."</td>";
			$table=$table."</tr>";
			$data[]=$row;
		}
			
			foreach ($data as $fields=>$first) 
			{
				fputcsv($fp, $first);
			}
			fclose($fp);
			$table=$table."</table>";
			header("Content-Disposition: attachment; filename=\"students.xls\"");
			header("Content-Type: application/xlsx");
					
			echo $table;
	}

	if($_POST['type']==3)
	{
		/************    Data exported in   .CSV    and . Xlsx   both format ***********/
		
		$firstrow=true;
		$deptdebt=$_POST['deptdebt'];
		
		$sqlist="SELECT student.*,billing.* FROM student INNER JOIN billing ON student.reg_id = billing.reg_id WHERE student.deactivated = '0' and student.department = '$deptdebt' and student.reg_id > '0' and billing.paid = '0'";
		$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
		$file="file";
		$filetype=".csv";
		$fp = fopen($file.$filetype, 'w');
		$table="<table><tr><td>Id</td><td>Name</td><td>Department</td><td>Mobile</td><td>Branch</td><td>Hostel No</td><td>Room No</td><td>Bllod Group</td><td>Joining date</td><td>Deactivated Date any</td><td>amount_tobe_pay</td><td>Pursuing</td></tr>";
		while($row=$sql_result->fetch_assoc())
		{
			$table=$table."<tr><td>".$row['reg_id']."</td><td>".$row['fname']." ".$row['mname']." ".$row['lname']."</td>";
			$table=$table."<td>".$row['department']."</td>";
			$table=$table."<td>".$row['mobile']."</td>";
			$table=$table."<td>".$row['branch']."</td>";
			$table=$table."<td>".$row['hostel_no']."</td>";
			$table=$table."<td>".$row['room_no']."</td>";
			$table=$table."<td>".$row['blood_grp']."</td>";
			$table=$table."<td>".$row['start_date_mess']."</td>";
			$table=$table."<td>".$row['deactivated_date']."</td>";
			$table=$table."<td>".$row['amount_tobe_pay']."</td>";
			$table=$table."<td>".$row['course']."</td>";
			$table=$table."</tr>";
			$data[]=$row;
		}
			
		foreach ($data as $fields=>$first) 
		{
			fputcsv($fp, $first);
		}
		fclose($fp);
		$table=$table."</table>";
		header("Content-Disposition: attachment; filename=\"pedingbillmembers.xls\"");
		header("Content-Type: application/xlsx");
				
		echo $table;
	}
}
else
{
	echo "error";
}
?>
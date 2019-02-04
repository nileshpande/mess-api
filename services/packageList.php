<?php 
include_once('../connection.php');
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$regid = $postdata2['regid'];
	$business_type = $postdata2['business_type'];
	$mobile = $postdata2['mobile'];
	$email = $postdata2['email'];
	
	if($regid== "" || $business_type== "")
	{
		$data2 = array("status" => false, "responce_status_massage" => "Please give input");
		print json_encode($data2,JSON_NUMERIC_CHECK);
	}
	else
	{
			
		if($business_type==2)
		{
			$sql_how_many="select finall_category from tbl_merchant1 where service_provider_id = '$regid'";
			$reshowpkg =$conn->query($sql_how_many);
			$rowhowpkg=mysqli_fetch_row($reshowpkg);
			$how_many_cat=$rowhowpkg['0'];
		
		}
		if($business_type==3)
		{
			$sql_how_many="select finall_category from tbl_service_provider1 where service_provider_id = '$regid'";
			$reshowpkg =$conn->query($sql_how_many);
			$rowhowpkg=mysqli_fetch_row($reshowpkg);
			$how_many_cat=$rowhowpkg['0'];
		}
		
		$count_cat = substr_count($how_many_cat, ',');
		
		if($reshowpkg)
		{
		
			$sqlpkg="select `id`,`name`,`validity`,`how_many_cat`,`ammount` from ser_mer_pckage where how_many_cat >= '$count_cat' and ser_mer = '$business_type' and forcrm = 0 ";
			$respkg =$conn->query($sqlpkg);
			
			while($row_pkg = $respkg->fetch_assoc())
			{
				$nowamt = str_replace(array('b', 'c', 'd', 'e', 'f', 'g','h','i','j','k'),
				array('1', '2', '3', '4', '5', '6','7','8','9','0'),$row_pkg['ammount']);
				$row_pkg['amount'] = $nowamt;
				/* $row_pkg['amount'] = 1; */
				$row_pkg['regid'] = $regid;
				$row_pkg['business_type'] = $business_type;
				$row_pkg['pkgid'] = $row_pkg['id'];
				
				$data[] = $row_pkg;
				
			
			}
			$data2 = array("status" => true, "responce_status_massage" => "Packages are","data" => $data);
				print json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "Wrong data");
			print json_encode($data2,JSON_NUMERIC_CHECK);
		}
	}
	
}	
else
{
	$data2 = array("status" => false, "responce_status_massage" => "Please give input");
	print json_encode($data2,JSON_NUMERIC_CHECK);
}	
?>
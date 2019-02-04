<?php
include_once('../connection.php');
header('Content-type: application/json');
$postdata = file_get_contents("php://input"); 
$postdata2=json_decode($postdata,true);

$mobile = $postdata2['mobile'];
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	if(!empty($mobile))
	{
		$numbercheck="/^[0-9\/-]+$/";
		//$email="vivek84505@gmail.com";
   
			if(preg_match($numbercheck,$mobile))
			{
				$res_sp=$conn->query("select * from tbl_service_provider1 where mobile='$mobile'");
				$numrows_sp=$res_sp->num_rows;
				
				$res_merchant=$conn->query("select * from tbl_merchant1 where mobile='$mobile'");
				$numrows_merchant=$res_merchant->num_rows;
				
				if($numrows_sp > 0 || $numrows_merchant > 0 )
				{
					$data = array("status" => true, "responce_status_massage" => "This no is already registered Please enter another Number!");
					echo json_encode($data);
				} 
				else
				{
					$data = array("status" => false, "responce_status_massage" => "Continue!");
					echo json_encode($data);
				}
			}
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "Wrong Input!");
		echo json_encode($data);
	}
}
else
{
	$data = array("status" => false, "responce_status_massage" => "No Input!");
	echo json_encode($data);		
}
	
$conn->close();

?>
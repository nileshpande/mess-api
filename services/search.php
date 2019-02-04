<?php 
	include_once('connection.php');
	header('Content-type: application/json');
	$postdata = file_get_contents("php://input"); 
	$postdata2=json_decode($postdata,true);
	/*
	"business_type": "SERVICE_PROVIDER" or "MERCHANT" or "ALL",
	"category_id": 1 or null,
	"sub_category_id": 1 or null,
	"location": "jalgaon" or null ,
	"search_query": "query" or null,
	"page_no": 2 or null
	
	*/
	$checkreq = $postdata2['business_type'];
	if(isset($postdata2['category_id']))
	{
		$checkreq_id = $postdata2['category_id'];
	}
	if(isset($postdata2['sub_category_id']))
	{
		$checkreq_sub_cat_id = $postdata2['sub_category_id'];
		$checkreq_id=null;
	}
	
	if(isset($postdata2['location']))
	{
		$checkreq_loc = $postdata2['location'];
		$checkreq_loc=trim($checkreq_loc,' ');
		$checkreq_loc=$conn->real_escape_string($checkreq_loc);
		$checkreq_loc = mysqli_real_escape_string($conn, $checkreq_loc);
	}
	if(isset($postdata2['search_query']))
	{
	$checkreq_search_query = $postdata2['search_query'];
	$checkreq_search_query=trim($checkreq_search_query,' ');
	$checkreq_search_query=$conn->real_escape_string($checkreq_search_query);
	
	$checkreq_search_query = mysqli_real_escape_string($conn, $checkreq_search_query);
	}
	
	if(isset($postdata2['page_no']))
	{
		$checkreq_page_no = $postdata2['page_no'];
	}
	else
	{
		$checkreq_page_no=null;
	}
	
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		if(isset($checkreq_search_query))
		{
			$catsearch="SELECT * FROM `category_search` WHERE `service_name`='$checkreq_search_query'";
			$select_data_c =  $conn->query($catsearch);
			$row_c = mysqli_fetch_array($select_data_c);
			
			$checkreq = $row_c['buss_type'];
			$ismain=$row_c['is_maincat'];
			
			if($ismain==1)
			{
				$checkreq_id = $row_c['catid'];
				$checkreq_sub_cat_id = null;
			}
			if($ismain==0)
			{
				$checkreq_sub_cat_id = $row_c['catid'];
				$checkreq_id = null;
			}
			
			
		}
		
		// stricktly check post value SERVICE_PROVIDER value 100%
	if($checkreq== 3)
	{
		$tablename="tbl_service_provider1";
		$bustype="3";
		//query start
	$sql_select = "select `service_provider_id`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `lag`, `lat`, `is_active` from $tablename where `is_active` = 1 and `is_paid` = 1";
	$noothercat=true;
	if($checkreq_sub_cat_id!="" && $checkreq_sub_cat_id!= null )
	{
		$sql_select=$sql_select." and find_in_set($checkreq_sub_cat_id,`final_subcategory`)"; 
		$noothercat=false;
	}
	if(($checkreq_id!="" and $checkreq_id!= null) and $noothercat )
	{
		$sql_select=$sql_select." and find_in_set($checkreq_id,`finall_category`)"; 
		
	}
	
	/* echo $sql_select; */
	if(isset($checkreq_loc))
	{
		if($checkreq_loc!="" && $checkreq_loc!= null)
		{
			$sql_select=$sql_select." and  (`taluka_name`  like '$checkreq_loc%' or 'district_name'  like '$checkreq_loc%' )";
		}
	}
	if($checkreq_page_no!=null)
	{
		
		$current_page=$checkreq_page_no;
		$result_category =  $conn->query($sql_select);
		
		$total_products = mysqli_num_rows($result_category);
		
		$products_per_page = 8;
		$total_pages = ceil($total_products / $products_per_page);
		
		if ($current_page > $total_pages) 
		{
		$current_page = 1;
		}
		// redirect too-small page numbers (or strings converted to 0) to the first page
		if ($current_page < 1) 
		{
			$current_page = 1;
		}
		// determine the start and end shirt for the current page; for example, on
		// page 3 with 8 shirts per page, $start and $end would be 17 and 24
		$start = (($current_page - 1) * $products_per_page) + 1;
		$end = $current_page * $products_per_page;
		if ($end > $total_products) 
		{
			$end = $total_products;
		}
		$sql_select=$sql_select." ORDER BY `service_provider_id` DESC LIMIT ".$products_per_page;
		
	}
	if($checkreq_page_no== null)
	{
		
		$current_page = 1;
		$result_category =  $conn->query($sql_select);
		
		$total_products = mysqli_num_rows($result_category);
		$products_per_page = 8;
		$total_pages = ceil($total_products / $products_per_page);
		
		if ($current_page > $total_pages) 
		{
		$current_page = 1;
		}
		// redirect too-small page numbers (or strings converted to 0) to the first page
		if ($current_page < 1) 
		{
			$current_page = 1;
		}
		// determine the start and end shirt for the current page; for example, on
		// page 3 with 8 shirts per page, $start and $end would be 17 and 24
		$start = (($current_page - 1) * $products_per_page) + 1;
		$end = $current_page * $products_per_page;
		if ($end > $total_products) 
		{
			$end = $total_products;
		}
		$sql_select=$sql_select." LIMIT ".$products_per_page;
	}
	
	if($start==1){$start=0;}else{$start--;}
	$sql_select=$sql_select." OFFSET $start";
	
	$select_data_j = $conn->query($sql_select);
	if($select_data_j)
	{	
		$data = array();
		$filepath="images/service-merchant/";
		while($row_j = mysqli_fetch_assoc($select_data_j))
		{
			$row_j['profile_pic1']=$filepath.$row_j['profile_pic1'];
			$image=substr($row_j['profile_pic1'], strrpos($row_j['profile_pic1'], '/') + 1);
			if($image=="")
			{
				$row_j['profile_pic1']="images/no-image1.jpg";
			}
			if($row_j['profile_pic1']== "")
			{
				$row_j['profile_pic1']="images/no-image1.jpg";
			}
			/* $row_j['address']=implode("-",$postdata2); */
			$data[] = $row_j;			
		}
		if (!empty($data))
		{ 
	
			$data2 = array("status" => true, "responce_status_massage" => "Data Found","business_type" => $checkreq,"total_pages" => $total_pages,"current_page" => $current_page,"data"=> $data);
			
			print json_encode($data2,JSON_NUMERIC_CHECK);
		}
		else
		{
			$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
			print json_encode($data2);
		}		
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "No Data Found!");
		
		print json_encode($data);
	}
		
	}
		// stricktly check post value MERCHANT value 100%
		else if($checkreq== 2)
		{
			$tablename="tbl_merchant1";
			$bustype="2";
			//query start
		$sql_select = "select `service_provider_id`, `name`, `email_id`, `mobile`, `shop_name`, `shop_no`, `building_name`, `street`, `landmark`, `area`, `other`, `State`, `district_id`, `district_name`, `taluka_id`, `taluka_name`, `city`, `address`, `location`, `pincode`, `location_of_service`, `open_days`, `working_hours`, `office_mobile`, `bussiness_type`, `bussiness_type_text`, `nature_of _bussiness`, `category`, `finall_category`, `sub_category`, `final_subcategory`, `profile_pic1`, `profile_pic2`, `description`, `duration`, `lag`, `lat`, `is_active` from $tablename where `is_active` = 1 and `is_paid` = 1";
		$noothercat=true;
		if($checkreq_sub_cat_id!="" && $checkreq_sub_cat_id!= null )
		{
			$sql_select=$sql_select." and find_in_set($checkreq_sub_cat_id,`final_subcategory`)"; 
			$noothercat=false;
		}
		if(($checkreq_id!="" and $checkreq_id!= null) and $noothercat )
		{
			$sql_select=$sql_select." and find_in_set($checkreq_id,`finall_category`)"; 
			
		}
		
		if(isset($checkreq_loc))
		{
			if($checkreq_loc!="" && $checkreq_loc!= null)
			{
				$sql_select=$sql_select." and  (`taluka_name`  like '$checkreq_loc%' or 'district_name'  like '$checkreq_loc%' )";
			}
		}
		
		if($checkreq_page_no!=null)
		{
			
			$current_page=$checkreq_page_no;
			$result_category =  $conn->query($sql_select);
			
			$total_products = mysqli_num_rows($result_category);
			
			$products_per_page = 8;
			$total_pages = ceil($total_products / $products_per_page);
			
			if ($current_page > $total_pages) 
			{
			$current_page = 1;
			}
			// redirect too-small page numbers (or strings converted to 0) to the first page
			if ($current_page < 1) 
			{
				$current_page = 1;
			}
			// determine the start and end shirt for the current page; for example, on
			// page 3 with 8 shirts per page, $start and $end would be 17 and 24
			$start = (($current_page - 1) * $products_per_page) + 1;
			$end = $current_page * $products_per_page;
			if ($end > $total_products) 
			{
				$end = $total_products;
			}
			$sql_select=$sql_select." ORDER BY `service_provider_id` DESC LIMIT ".$products_per_page;
			
		}
		if($checkreq_page_no== null)
		{
			
			$current_page = 1;
			$result_category =  $conn->query($sql_select);
			
			$total_products = mysqli_num_rows($result_category);
			$products_per_page = 8;
			$total_pages = ceil($total_products / $products_per_page);
			
			if ($current_page > $total_pages) 
			{
			$current_page = 1;
			}
			// redirect too-small page numbers (or strings converted to 0) to the first page
			if ($current_page < 1) 
			{
				$current_page = 1;
			}
			// determine the start and end shirt for the current page; for example, on
			// page 3 with 8 shirts per page, $start and $end would be 17 and 24
			$start = (($current_page - 1) * $products_per_page) + 1;
			$end = $current_page * $products_per_page;
			if ($end > $total_products) 
			{
				$end = $total_products;
			}
			$sql_select=$sql_select." ORDER BY `service_provider_id` DESC LIMIT ".$products_per_page;
		}
		
		if($start==1){$start=0;}else{$start--;}
		$sql_select=$sql_select." OFFSET $start";

		$select_data_j = $conn->query($sql_select);
		if($select_data_j)
		{	
			$data = array();
			$filepath="images/service-merchant/";
			while($row_j = mysqli_fetch_assoc($select_data_j))
			{
				$row_j['profile_pic1']=$filepath.$row_j['profile_pic1'];
				$image=substr($row_j['profile_pic1'], strrpos($row_j['profile_pic1'], '/') + 1);
				if($image=="")
				{
					$row_j['profile_pic1']="images/no-image1.jpg";
				}
				if($row_j['profile_pic1']== "")
				{
					$row_j['profile_pic1']="images/no-image1.jpg";
				}
				/* $row_j['address']=implode("-",$postdata2); */
				$data[] = $row_j;			
			}
			if (!empty($data))
			{ 
		
				$data2 = array("status" => true, "responce_status_massage" => "Data Found","business_type" => $checkreq,"total_pages" => $total_pages,"current_page" => $current_page,"data"=> $data);
				
				print json_encode($data2,JSON_NUMERIC_CHECK);
			}
			else
			{
				$data2 = array("status" => false, "responce_status_massage" => "No Data!","data"=> $data);
				print json_encode($data2);
			}		
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "No Data Found!");
			
			print json_encode($data);
		}
			
		}
		else
		{
			$data = array("status" => false, "responce_status_massage" => "Wrong Input");
			print json_encode($data);

		}
	}
	else
	{
		$data = array("status" => false, "responce_status_massage" => "INVALID INPUT!");
		print json_encode($data);
		
	}
	
	$conn->close();
?>
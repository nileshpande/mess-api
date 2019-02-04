<?php include("process/login-checker.php"); ?>
<?php include("include-files/connection.php"); ?>
<?php include("process/page-roll-fixer.php"); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title><?php echo $title; ?></title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


     <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
	    
		<?php include("include-files/side-menu.php");  ?>

	    <div class="main-panel">
			
			<?php include("include-files/menu.php");  ?>
			
	        <div class="content">
	            <div class="container-fluid">
	               
					<!---------    row end   ------>
					<div class="row">
						<div class="col-md-7">
							<div class="card">
	                            <div class="card-header">
	                                <h4 class="card-title">Billing</h4>
	                                <p class="category">List</p>
	                            </div>
	                            <div class="card-content">
								<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Name</th>
												<th>Room No</th>
												
												<th class="disabled-sorting">Actions</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>ID</th>
												<th>Name</th>
												<th>Room No</th>
												
												<th>Actions</th>
											</tr>
										</tfoot>
										<tbody>
								<?php
									$sqlist="SELECT * FROM `student`";
									$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
									
									while($row=$sql_result->fetch_array())
									{ 
										if($row['reg_id']=="0") { } 
										else {
										?>
										<tr>
											<td><?php echo $row['reg_id']; ?></td>
											<!--<td><img style="max-width:100px;max-height:100px;" src="<?php echo "student-images/".$row['photo']; ?>" /></td>-->
											<td><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></td>
											<td><?php echo $row['mobile']; ?></td>
											<td><?php echo $row['hostel_no']; ?></td>
											<td><?php echo $row['room_no']; ?></td>
											
											<td>
											<form method="POST" id="billingform">
											<input type="text" name="reg_id" id="reg_id" value="<?php echo $row['reg_id']; ?>" hidden readonly />
											<button class="btn btn-fill btn-info btn-icon " onclick="return billing();" type="submit"><i class="fa fa-eye"></i></button>
											</form>
											</td>
										</tr>
										<?php
										}
									}
								?>
											
										   </tbody>
									    </table>
	                            </div>
								<div class="card-footer">
	                               
	                                <hr>
	                                <div class="stats">
	                                    <i class="ti-check"></i> Billin List
	                                </div>
	                            </div>
	                        </div>
							
						</div>
						<div class="col-md-5" id="bill">
							
							
						</div>
					</div>
					
                </div>
	        </div>
            <?php include("include-files/footer.php"); ?>
	    </div>
	</div>
</body>

	<!--   Core JS Files. Extra: TouchPunch for touch library inside jquery-ui.min.js   -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="assets/js/perfect-scrollbar.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Forms Validations Plugin -->
	<script src="assets/js/jquery.validate.min.js"></script>

	<!-- Promise Library for SweetAlert2 working on IE -->
	<script src="assets/js/es6-promise-auto.min.js"></script>

	<!--  Switch and Tags Input Plugins -->
	<script src="assets/js/bootstrap-switch-tags.js"></script>

	<!-- Circle Percentage-chart -->
	<script src="assets/js/jquery.easypiechart.min.js"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>
	
	<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
	<script src="assets/js/moment.min.js"></script>
	
	<!--  Date Time Picker Plugin is included in this js file -->
	<script src="assets/js/bootstrap-datetimepicker.js"></script>
	
	<!--  Select Picker Plugin -->
	<script src="assets/js/bootstrap-selectpicker.js"></script>
	<!--  Plugin for DataTables.net  -->
	<script src="assets/js/jquery.datatables.js"></script>
	<!--  Notifications Plugin    -->
	<script src="assets/js/bootstrap-notify.js"></script>

	<!-- Sweet Alert 2 plugin -->
	<script src="assets/js/sweetalert2.js"></script>

	
	<!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- DEMO and DEMO2 change between these js -->
	<script src="assets/js/demo.js"></script>

	<?php
	
	if(isset($_GET['msg']))
	{
	?>
	<script type="text/javascript">
    	$(document).ready(function(){


        	$.notify({
            	icon: 'ti-unlock',
            	message: "<b> <?php echo $_GET['msg']; ?></b> ."

            },{
                type: 'success',
                timer: 4000
            });

    	});
	</script>
	<?php
	}
	?>
	<script type="text/javascript">
        $().ready(function(){
			 $('#datatables').DataTable({
	            "pagingType": "full_numbers",
	            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
	            responsive: true,
	            language: {
	            search: "_INPUT_",
		            searchPlaceholder: "Search records",
		        }
	        });
			$('#guestFormValidation').validate();
        });
    </script>
	<script>
	 function billing()
	 {
		 //  $("#registerform").prop("disabled",true);
				 
		var data=$("#reg_id").val();
		if(data.length==0)
		{
			return true;
		}
		else
		{
		$.ajax({
			type: 'post',
			url: 'process/bill-fetch.php',
			data: $("#billingform").serialize(),
			success: function(html)
			{
				// alert(html);
				$("#bill").html(html);
				 
			} 
			 
			})
		}
		return false;
	 }
			 	
	</script>
<!--------------    Custom Js File    ----------------->
<!--------------    Here you can add any custom js file by a single file  ---->
<?php include("include-files/custom-js-file.php"); ?>
<!--------------    Custom Js File    ----------------->
</html>

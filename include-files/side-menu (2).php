<?php
	include("include-files/connection.php");
	$sqlist="SELECT * FROM `mess_config`";
	$sql_result = $conn->query($sqlist)or die(mysqli_error($conn));
	$row = $sql_result->fetch_assoc();
			

	$date=date('Y-m-d'); 
	$month=date('m');
	$year=date('Y');
	$day = date('l', strtotime($date));
	$present_status=1;
	
	$timezone = new DateTimeZone("Asia/Kolkata" );
	$date2 = new DateTime();
	$date2->setTimezone($timezone );
	$time = (string)$date2->format( 'H:i:s' );  
	
?>
<div class="sidebar" data-background-color="<?php if(($time>$row['nashtastarttime']) and ($time<$row['nashtaendtime'])) { echo "white"; } else if(($time>$row['lunchstarttime']) and ($time<$row['lunchendtime'])){ echo "white"; } else if(($time>$row['dinnerstarttime']) and ($time<$row['dinnerendtime'])){ echo "brown"; } else { echo "white"; } ?>" data-active-color="<?php if(($time>$row['nashtastarttime']) and ($time<$row['nashtaendtime'])) { echo "success"; } else if(($time>$row['lunchstarttime']) and ($time<$row['lunchendtime'])){ echo "danger"; } else if(($time>$row['dinnerstarttime']) and ($time<$row['dinnerendtime'])){ echo "info"; } else { echo "warning"; } ?>">
<?php
$activepage= basename($_SERVER['PHP_SELF']);
?>
	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | brown"
			
			$time will give you different effect
			
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
			<div class="logo">
				<a href="dashboard.php" class="simple-text logo-mini">
					NP
				</a>

				<a href="dashboard.php" class="simple-text logo-normal">
					NP Solutions
				</a>
			</div>
	    	<div class="sidebar-wrapper">
				
	            <ul class="nav">
				<?php if($role==1 or $role==2 or $role==3){ ?>
	                <li <?php if($activepage=="dashboard.php"){?> class="active" <?php }else {}  ?> >
						<a href="dashboard.php">
							<i class="ti-panel"></i>
							<p>डॅशबोर्ड </p>
						</a>
					</li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>
					<li <?php if($activepage=="presentday.php"){?> class="active" <?php }else {}  ?> >
                    <a href="presentday.php">
                        <i class="ti-user"></i>
                        <p>हजेरी</p>
                    </a>
					</li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>
					<li <?php if($activepage=="add-new-form.php"){?> class="active" <?php }else {}  ?> >
						<a href="add-new-form.php">
							<i class="ti-write"></i>
							<p>नवीन प्रवेश फॉर्म</p>
						</a>
					</li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>	
					<li <?php if($activepage=="guest-form.php"){?> class="active" <?php }else {}  ?> >
						<a href="guest-form.php">
							<i class="ti-pencil-alt2"></i>
							<p>गेस्ट फॉर्म</p>
						</a>
					</li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>
					<li <?php if($activepage=="khada-form.php"){?> class="active" <?php }else {}  ?> >
						<a href="khada-form.php">
							<i class="ti-file"></i>
							<p>खाडा फॉर्म</p>
						</a>
					</li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>
					<li <?php if($activepage=="member-list.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="member-list.php" >
	                        <i class="ti-book"></i>
	                        <p>सदस्य यादी</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1 or $role==2){ ?>	
					<li <?php if($activepage=="bill.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="bill.php" >
	                        <i class="ti-receipt"></i>
	                        <p>Bill</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1 or $role==2){ ?>
					<li <?php if($activepage=="account-history.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="account-history.php" >
	                        <i class="ti-stats-up"></i>
	                        <p>Accounting History</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1 or $role==2 or $role==3){ ?>
					<li <?php if($activepage=="student-history.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="student-history.php" >
	                        <i class="ti-id-badge"></i>
	                        <p>Student History</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1){ ?>
					<li <?php if($activepage=="setting.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="setting.php" >
	                        <i class="ti-settings"></i>
	                        <p>Setting</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1 or $role==2){ ?>
					<li <?php if($activepage=="no-dues.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="no-dues.php" >
	                        <i class="ti-thumb-up"></i>
	                        <p>No Dues</p>
	                    </a>
	                </li>
				<?php } ?>
				<?php if($role==1){ ?>
					<li <?php if($activepage=="export-data.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="export-data.php" >
	                        <i class="ti-truck"></i>
	                        <p>Export data</p>
	                    </a>
	                </li>
					<li <?php if($activepage=="new-user.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="new-user.php" >
	                        <i class="ti-import"></i>
	                        <p>New User</p>
	                    </a>
	                </li>
					
					<li <?php if($activepage=="revenue.php"){?> class="active" <?php }else {}  ?> >
	                    <a href="revenue.php" >
	                        <i class="ti-money"></i>
	                        <p>Revenue</p>
	                    </a>
	                </li>
				<?php } ?>
				
	            </ul>
	    	</div>
	    </div>
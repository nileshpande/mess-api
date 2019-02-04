<nav class="navbar navbar-default">
	            <div class="container-fluid">
					<div class="navbar-minimize">
						<button id="minimizeSidebar" class="btn btn-fill btn-icon"><i class="ti-more-alt"></i></button>
					</div>
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#Dashboard">
							<?php echo $_SESSION['orgname']; ?>
						</a>
	                </div>
	                <div class="collapse navbar-collapse">


	                    <ul class="nav navbar-nav navbar-right">
	                        <li>
	                            <a href="#stats" class="dropdown-toggle btn-magnify" data-toggle="dropdown">
	                                <i class="ti-user"></i>
									<p>Profile</p>
	                            </a>
								<ul class="dropdown-menu">
	                                <li><a href="profile.php">View Profile</a></li>
	                                <li><a href="change-password.php">Change Password</a></li>
	                            </ul>
	                        </li>
							<!---
	                        <li class="dropdown">
	                            <a href="#notifications" class="dropdown-toggle btn-rotate" data-toggle="dropdown">
	                                <i class="ti-bell"></i>
	                                <span class="notification">5</span>
									<p class="hidden-md hidden-lg">
										Notifications
										<b class="caret"></b>
									</p>
	                            </a>
	                            <ul class="dropdown-menu">
	                                <li><a href="#not1">Notification 1</a></li>
	                                <li><a href="#another">Another notification</a></li>
	                            </ul>
	                        </li>
							--->
							<li>
								<a href="process/logout.php" class="btn-rotate" >
	                            
									<i class="ti-lock"></i>
									<p>
										LogOut
									</p>
	                            </a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>
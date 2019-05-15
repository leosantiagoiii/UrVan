<!DOCTYPE html>
<?php date_default_timezone_set("Asia/Manila"); ?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin - Dashboard</title>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
    </head>
    <body id="page-top">
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <a class="navbar-brand mr-1" href="index.php">UrVan</a>
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
            </button>
            <!-- Navbar Search -->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div> -->
            </form>
            <!-- Navbar -->
            <ul class="navbar-nav ml-auto ml-md-0">
<!--                 <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge badge-danger">9+</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <span class="badge badge-danger">10</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li> -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-fw"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="admin_settings.php">Settings</a>
                        <a class="dropdown-item" href="admin_activitylog.php">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="sidebar navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" target="_blank">
                        <i class="fas fa-fw fa-home"></i>
                        <span>See UrVan</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-user-edit"></i>
                        <span>Manage Content</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <h6 class="dropdown-header">Posts:</h6>
                        <a class="dropdown-item" href="admin_news_and_updates.php">News & Updates</a>
                        <a class="dropdown-item" href="admin_tours_and_packages.php">Tours & Packages</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Other Pages:</h6>
                        <a class="dropdown-item" href="arch_neu.php"><small><small>Archived (News & Updates)</small></small></a>
                        <a class="dropdown-item" href="arch_tou.php"><small><small>Archived (Tours & Packages)</small></small></a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-people-carry"></i>
                        <span>Membership</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <a class="dropdown-item" href="admin_membership_requests.php"><small>Membership Requests</small></a>
                        <a class="dropdown-item" href="training_sem.php">Training Seminar</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Payments</h6>
                        <a class="dropdown-item" href="membership_fee.php">Membership Fee</a>
                        <a class="dropdown-item" href="subsc_cap.php">Subscribed Capital</a>
                    </div>
                </li>

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Pages</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <h6 class="dropdown-header">Login Screens:</h6>
                        <a class="dropdown-item" href="login.php">Login</a>
                        <a class="dropdown-item" href="register.php">Register</a>
                        <a class="dropdown-item" href="forgot-password.php">Forgot Password</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Other Pages:</h6>
                        <a class="dropdown-item" href="404.php">404 Page</a>
                        <a class="dropdown-item" href="blank.php">Blank Page</a>
                    </div>
                </li> -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-fw fa-suitcase"></i>
                        <span>Trips</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                        <h6 class="dropdown-header">Trips:</h6>
                        <a class="dropdown-item" href="past_trips.php">Past Trips</a>
                        <a class="dropdown-item" href="ongoing_trips.php">Ongoing Trips</a>
                        <a class="dropdown-item" href="cancelled_trips.php">Cancelled Trips</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Trip References:</h6>
                        <a class="dropdown-item" href="deposit_slips_trips.php">Deposit Slips</a>
                        <a class="dropdown-item" href="deposit_breakdowns.php">Cost Breakdowns</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Queueing:</h6>
                        <a class="dropdown-item" href="driver_queue.php">Driver Queue</a>
                        <a class="dropdown-item" href="van_queue.php">Van Queue</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="drivers.php">
                        <i class="fas fa-fw fa-user-friends"></i>
                        <span>Authorized Drivers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="member_vehicles.php">
                        <i class="fas fa-fw fa-shuttle-van"></i>
                        <span>Vehicles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="EvaluationAssessment.php">
                        <i class="fas fa-fw fa-thumbs-up"></i>
                        <span>Eval. Assessment</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php" target="_blank">
                        <i class="fas fa-fw fa-chalkboard"></i>
                        <span>Reports</span>
                    </a>
                </li>
                
                <!-- <li class="nav-item">
                    <a class="nav-link" href="charts.php">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Charts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tables.php">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Tables</span>
                    </a>
                </li> -->

            </ul>
            <div id="content-wrapper">
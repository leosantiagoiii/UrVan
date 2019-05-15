<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";
require "../../includes/dbconnect.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen">
        <meta name="keywords" content="au theme template">
        <!-- Title Page-->
        <title>Tables</title>
        <!-- Fontfaces CSS-->
        <link href="css/font-face.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
        <!-- Bootstrap CSS-->
        <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">
        <!-- Vendor CSS-->
        <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
        <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
        <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
        <!-- Main CSS-->
        <link href="css/theme.css" rel="stylesheet" media="all">
    </head>
    <body class="animsition">
        <div class="page-wrapper">
            <!-- HEADER MOBILE-->
            <header class="header-mobile d-block d-lg-none">
                <div class="header-mobile__bar">
                    <div class="container-fluid">
                        <div class="header-mobile-inner">
                            <a class="logo" href="index.html">
                                <img src="images/icon/logo.png" alt="CoolAdmin" />
                            </a>
                            <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="navbar-mobile">
                    <div class="container-fluid">
                        <ul class="navbar-mobile__list list-unstyled">
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="index.html">Dashboard 1</a>
                                    </li>
                                    <li>
                                        <a href="index2.html">Dashboard 2</a>
                                    </li>
                                    <li>
                                        <a href="index3.html">Dashboard 3</a>
                                    </li>
                                    <li>
                                        <a href="index4.html">Dashboard 4</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="chart.html">
                                <i class="fas fa-chart-bar"></i>Charts</a>
                            </li>
                            <li>
                                <a href="table.html">
                                <i class="fas fa-table"></i>Tables</a>
                            </li>
                            <li>
                                <a href="form.html">
                                <i class="far fa-check-square"></i>Forms</a>
                            </li>
                            <li>
                                <a href="#">
                                <i class="fas fa-calendar-alt"></i>Calendar</a>
                            </li>
                            <li>
                                <a href="map.html">
                                <i class="fas fa-map-marker-alt"></i>Maps</a>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="login.html">Login</a>
                                    </li>
                                    <li>
                                        <a href="register.html">Register</a>
                                    </li>
                                    <li>
                                        <a href="forget-pass.html">Forget Password</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                                <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                    <li>
                                        <a href="button.html">Button</a>
                                    </li>
                                    <li>
                                        <a href="badge.html">Badges</a>
                                    </li>
                                    <li>
                                        <a href="tab.html">Tabs</a>
                                    </li>
                                    <li>
                                        <a href="card.html">Cards</a>
                                    </li>
                                    <li>
                                        <a href="alert.html">Alerts</a>
                                    </li>
                                    <li>
                                        <a href="progress-bar.html">Progress Bars</a>
                                    </li>
                                    <li>
                                        <a href="modal.html">Modals</a>
                                    </li>
                                    <li>
                                        <a href="switch.html">Switchs</a>
                                    </li>
                                    <li>
                                        <a href="grid.html">Grids</a>
                                    </li>
                                    <li>
                                        <a href="fontawesome.html">Fontawesome Icon</a>
                                    </li>
                                    <li>
                                        <a href="typo.html">Typography</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- END HEADER MOBILE-->
            <!-- MENU SIDEBAR-->
            <aside class="menu-sidebar d-none d-lg-block">
                <div class="logo">
                    <a href="#">
                        <img src="images/icon/logo.png" alt="Cool Admin" />
                    </a>
                </div>
                <div class="menu-sidebar__content js-scrollbar1">
                    <nav class="navbar-sidebar">
                        <ul class="list-unstyled navbar__list">
                            <li class="active has-sub">
                                <a class="js-arrow" href="index.php">
                                    <i class="fas fa-tachometer-alt"></i>My Profile
                                    
                                </a>
                                
                            </li>
                            <li>
                                <a href="inbox.html">
                                <i class="fas fa-chart-bar"></i>Inbox</a>
                                
                            </li>
                            
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-trophy"></i>Features
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="table.php">
                                        <i class="fas fa-table"></i>Manage Vehicles</a>
                                    </li>
                                    <li>
                                        <a href="chart.php">
                                        <i class="far fa-check-square"></i>Share Monitoring</a>
                                    </li>
                                    
                                    <li>
                                        <a href="table.php">
                                        <i class="fas fa-map-marker-alt"></i>My Performance</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a class="js-arrow" href="#">
                                    <i class="fas fa-copy"></i>Pages
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>
                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="login.html">
                                        <i class="fas fa-sign-in-alt"></i>Login</a>
                                    </li>
                                    <li>
                                        <a href="register.html">
                                        <i class="fas fa-user"></i>Register</a>
                                    </li>
                                    <li>
                                        <a href="forget-pass.html">
                                        <i class="fas fa-unlock-alt"></i>Forget Password</a>
                                    </li>
                                </ul>
                            </li>
                            
                        </ul>
                    </nav>
                </aside>
                <!-- END MENU SIDEBAR-->
                <!-- PAGE CONTAINER-->
                <div class="page-container">
                    <!-- HEADER DESKTOP-->
                    <header class="header-desktop">
                        <div class="section__content section__content--p30">
                            <div class="container-fluid">
                                <div class="header-wrap">
                                    <form class="form-header" action="" method="POST">
                                        <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                                        <button class="au-btn--submit" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                        </button>
                                    </form>
                                    <div class="header-button">
                                        <div class="noti-wrap">
                                            <div class="noti__item js-item-menu">
                                                <i class="zmdi zmdi-comment-more"></i>
                                                <span class="quantity">1</span>
                                                <div class="mess-dropdown js-dropdown">
                                                    <div class="mess__title">
                                                        <p>You have 2 news message</p>
                                                    </div>
                                                    <div class="mess__item">
                                                        <div class="image img-cir img-40">
                                                            <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                                        </div>
                                                        <div class="content">
                                                            <h6>Michelle Moreno</h6>
                                                            <p>Have sent a photo</p>
                                                            <span class="time">3 min ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="mess__item">
                                                        <div class="image img-cir img-40">
                                                            <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
                                                        </div>
                                                        <div class="content">
                                                            <h6>Diane Myers</h6>
                                                            <p>You are now connected on message</p>
                                                            <span class="time">Yesterday</span>
                                                        </div>
                                                    </div>
                                                    <div class="mess__footer">
                                                        <a href="#">View all messages</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="noti__item js-item-menu">
                                                <i class="zmdi zmdi-email"></i>
                                                <span class="quantity">1</span>
                                                <div class="email-dropdown js-dropdown">
                                                    <div class="email__title">
                                                        <p>You have 3 New Emails</p>
                                                    </div>
                                                    <div class="email__item">
                                                        <div class="image img-cir img-40">
                                                            <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                                        </div>
                                                        <div class="content">
                                                            <p>Meeting about new dashboard...</p>
                                                            <span>Cynthia Harvey, 3 min ago</span>
                                                        </div>
                                                    </div>
                                                    <div class="email__item">
                                                        <div class="image img-cir img-40">
                                                            <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                                        </div>
                                                        <div class="content">
                                                            <p>Meeting about new dashboard...</p>
                                                            <span>Cynthia Harvey, Yesterday</span>
                                                        </div>
                                                    </div>
                                                    <div class="email__item">
                                                        <div class="image img-cir img-40">
                                                            <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                                        </div>
                                                        <div class="content">
                                                            <p>Meeting about new dashboard...</p>
                                                            <span>Cynthia Harvey, April 12,,2018</span>
                                                        </div>
                                                    </div>
                                                    <div class="email__footer">
                                                        <a href="#">See all emails</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="noti__item js-item-menu">
                                                <i class="zmdi zmdi-notifications"></i>
                                                <span class="quantity">3</span>
                                                <div class="notifi-dropdown js-dropdown">
                                                    <div class="notifi__title">
                                                        <p>You have 3 Notifications</p>
                                                    </div>
                                                    <div class="notifi__item">
                                                        <div class="bg-c1 img-cir img-40">
                                                            <i class="zmdi zmdi-email-open"></i>
                                                        </div>
                                                        <div class="content">
                                                            <p>You got a email notification</p>
                                                            <span class="date">April 12, 2018 06:50</span>
                                                        </div>
                                                    </div>
                                                    <div class="notifi__item">
                                                        <div class="bg-c2 img-cir img-40">
                                                            <i class="zmdi zmdi-account-box"></i>
                                                        </div>
                                                        <div class="content">
                                                            <p>Your account has been blocked</p>
                                                            <span class="date">April 12, 2018 06:50</span>
                                                        </div>
                                                    </div>
                                                    <div class="notifi__item">
                                                        <div class="bg-c3 img-cir img-40">
                                                            <i class="zmdi zmdi-file-text"></i>
                                                        </div>
                                                        <div class="content">
                                                            <p>You got a new file</p>
                                                            <span class="date">April 12, 2018 06:50</span>
                                                        </div>
                                                    </div>
                                                    <div class="notifi__footer">
                                                        <a href="#">All notifications</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="account-wrap">
                                            <div class="account-item clearfix js-item-menu">
                                                <div class="image">
                                                    <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                                </div>
                                                <div class="content">
                                                    <a class="js-acc-btn" href="#">john doe</a>
                                                </div>
                                                <div class="account-dropdown js-dropdown">
                                                    <div class="info clearfix">
                                                        <div class="image">
                                                            <a href="#">
                                                                <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                                            </a>
                                                        </div>
                                                        <div class="content">
                                                            <h5 class="name">
                                                            <a href="#">john doe</a>
                                                            </h5>
                                                            <span class="email">johndoe@example.com</span>
                                                        </div>
                                                    </div>
                                                    <div class="account-dropdown__body">
                                                        <div class="account-dropdown__item">
                                                            <a href="#">
                                                            <i class="zmdi zmdi-account"></i>Account</a>
                                                        </div>
                                                        <div class="account-dropdown__item">
                                                            <a href="#">
                                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                                        </div>
                                                        <div class="account-dropdown__item">
                                                            <a href="#">
                                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                        </div>
                                                    </div>
                                                    <div class="account-dropdown__footer">
                                                        <a href="#">
                                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- END HEADER DESKTOP-->
                    <!-- MAIN CONTENT-->
                    <div class="main-content">
                        <div class="section__content section__content--p30">
                            <div class="container-fluid">
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- DATA TABLE -->
                                        <h3 class="title-5 m-b-35">Your Vehicles</h3>
                                        <div class="table-data__tool">
                                            <div class="table-data__tool-left">
                                                <div class="rs-select2--light rs-select2--md">
                                                    <div class="dropDownSelect2"></div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="table-responsive table-responsive-data2">
                                            <table class="table table-data2">
                                                <thead>
                                                                                                  
                                                    <tr>
                                                     
                                                        <th>Vehicle ID</th>
                                                        <th>Vehicle Make</th>
                                                        <th>Vehicle Model</th>
                                                        <th>Vehicle Year</th>
                                                        <th>Vehicle Plate Number </th>
                                                        <th>Status </th>
                                                        <th>Franchise </th>
                                                        <th></th>
                                                    </tr>
                                                    
                                                </thead>
                                                <tbody>
                                                    <?php $query="SELECT * FROM vehicle_table WHERE member_id = '$_SESSION[memberid]'";
                                                    $result=mysqli_query($conn,$query);
                                                    while($rowv=mysqli_fetch_assoc($result)) { ?>
                                                    
                                                    
                                                    
                                                    <tr class="tr-shadow">
                                                        
                                                        <td><?php echo $rowv['id']; ?></td>
                                                        <td><?php echo $rowv['make']; ?></td>
                                                        <td><?php echo $rowv['model']; ?></td>
                                                        <td><?php echo $rowv['year']; ?></td>
                                                        <td><?php echo $rowv['plate_number']; ?></td>
                                                        <td><?php echo $rowv['status']; ?></td>
                                                         <td><?php echo $rowv['franchised']; ?></td>
                                                        <td>
                                                            <div class="table-data-feature">
                                                               <!--  // echo '<td><a href=delCred.php?id=' .$row["id"] . '>DEL</a></td>'; -->
                                                               <form method="POST" action="../../includes/member_status.inc.php">
                                                                <input type = "hidden" value = "<?php echo $rowv['id']; ?>" name = "id"/>
                                                                <?php

                                                                if($rowv['status']=='ACTIVE'){
                                                                echo '<input type="Submit" value="INACTIVE" class="submit">';
                                                                }
                                                                else
                                                                {
                                                                echo '<input type="Submit" value="ACTIVE" class="submit">';
                                                                }
                                                                ?>
                                                                <input type="hidden" value="<?php echo $rowv['status']; ?>" name = "status">
                                                            </form>
                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                                <i class="zmdi zmdi-more"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                          <!--            
                                                 <tr class="spacer"></tr>
                                                <tr class="tr-shadow">
                                                    <td>
                                                        <label class="au-checkbox">
                                                            <input type="checkbox">
                                                            <span class="au-checkmark"></span>
                                                        </label>
                                                    </td>
                                                    <td></td>
                                                    <td>
                                                        <span class="block-email"></span>
                                                    </td>
                                                    <td class="desc"></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="table-data-feature">
                                                            <button class="btn btn-primary btn-sm" type="submit">Inactive</button> &nbsp
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                            </button>
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                            <i class="zmdi zmdi-more"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <tr class="spacer"></tr>
                                            <tr class="tr-shadow">
                                                <td>
                                                    <label class="au-checkbox">
                                                        <input type="checkbox">
                                                        <span class="au-checkmark"></span>
                                                    </label>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <span class="block-email"></span>
                                                </td>
                                                <td class="desc"></td>
                                                <td> </td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <button class="btn btn-primary btn-sm" type="submit">Inactive</button> &nbsp
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                        <i class="zmdi zmdi-more"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <tr class="spacer"></tr>
                                        <tr class="tr-shadow">
                                            <td>
                                                <label class="au-checkbox">
                                                    <input type="checkbox">
                                                    <span class="au-checkmark"></span>
                                                </label>
                                            </td>
                                            <td></td>
                                            <td>
                                                <span class="block-email"></span>
                                            </td>
                                            <td class="desc"></td>
                                            <td> </td>
                                            
                                            <td>
                                                <div class="table-data-feature">
                                                    <button class="btn btn-primary btn-sm" type="submit">Inactive</button> &nbsp
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                                    <i class="zmdi zmdi-more"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr> -->
                                        <?php  }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <!-- DATA TABLE-->
                            <div class="table-responsive m-b-40">
                                <table class="table table-borderless table-data3">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Vehicle Make</th>
                                            <th>Vehicle Model</th>
                                             <th>Vehicle Year</th>
                                            <th>Plate Number</th>
                                            <th>Status</th>
                                            <th>Franchise</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query="SELECT * FROM vehicle_table WHERE member_id = '$_SESSION[memberid]'";
                                                    $result=mysqli_query($conn,$query);
                                                    while($rowv=mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $rowv['id']; ?></td>
                                            <td><?php echo $rowv['make']; ?></td>
                                            <td><?php echo $rowv['model']; ?></td>
                                            <td><?php echo $rowv['year']; ?></td>
                                            <td><?php echo $rowv['plate_number']; ?></td>
                                            <td><?php echo $rowv['status']; ?></td>
                                            <td><?php echo $rowv['franchised']; ?></td>

                                        </tr>
                                        <!-- <tr>
                                            <td>2018-09-28 01:22</td>
                                            <td>Mobile</td>
                                            <td>Samsung S8 Black</td>
                                            <td class="process">Processed</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-27 02:12</td>
                                            <td>Game</td>
                                            <td>Game Console Controller</td>
                                            <td class="denied">Denied</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-26 23:06</td>
                                            <td>Mobile</td>
                                            <td>iPhone X 256Gb Black</td>
                                            <td class="denied">Denied</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-25 19:03</td>
                                            <td>Accessories</td>
                                            <td>USB 3.0 Cable</td>
                                            <td class="process">Processed</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-29 05:57</td>
                                            <td>Accesories</td>
                                            <td>Smartwatch 4.0 LTE Wifi</td>
                                            <td class="denied">Denied</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-24 19:10</td>
                                            <td>Camera</td>
                                            <td>Camera C430W 4k</td>
                                            <td class="process">Processed</td>
                                            
                                        </tr>
                                        <tr>
                                            <td>2018-09-22 00:43</td>
                                            <td>Computer</td>
                                            <td>Macbook Pro Retina 2017</td>
                                            <td class="process">Processed</td>
                                            
                                        </tr> -->
                                         <?php  }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DATA TABLE-->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>
<!-- Main JS-->
<script src="js/main.js"></script>
</body>
</html>
<!-- end document-->
<?php
}
else
{
header ("Location:../../index.php");
}
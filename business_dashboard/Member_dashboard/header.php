<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "../../includes/dbconnect.inc.php";
}
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
        <title>Dashboard </title>
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
        <link href="vendor/vector-map/jqvmap.min.css" rel="stylesheet" media="all">
        <!-- Main CSS-->
        <link href="css/theme.css" rel="stylesheet" media="all">
        <style>
            .col
            {
                padding-left: 300px;
            }

           /* #btn {
                margin-left: 300px;
            }*/
            .submit{
                width: 90px;
                height: 40px;
                background-color: #4272d7;
                color: white;
                border-radius: 5px;
            }

            @media (max-width: 425px) {
    #btn{
         margin-left: 15px;
    }
    h1{
        margin-left: 15px;
    }
}
   @media (max-width: 768px) {
    #btn{
         margin-left: 15px;
    }
    h1{
        margin-left: 15px;
    }
}

        </style>

    </head>
    <!-- <body> -->
    <div class="page-wrapper">
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar2">
            <div class="logo">
                <a href="index.php">
                   <center> <img src="images/icon/logo.png" alt="Member-Driver" style="width: 60%" /> </center>
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar1">
                <div class="account2">                  
                       <?php
                        $query=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'");
                        $row=mysqli_fetch_assoc($query);
                        ?>
                        
                             <div class="image img-cir img-120">
                            <center><img class="sansa" src="<?php
                            if($row['member_profile_pic']==NULL){
                                echo 'https://www.w3schools.com/howto/img_avatar.png';
                            }
                            elseif($row['member_profile_pic']==''){
                                echo 'https://www.w3schools.com/howto/img_avatar.png';
                            }
                            else{
                                echo '../../includes/'.$row['member_profile_pic'];
                            }
                            ?>"></center>
                            <br>
                            
                        </div>
                      
                    <?php
                $query=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'");
                $row=mysqli_fetch_assoc($query);
                ?>
                    <br> 
                    <h4><?php echo $row['member_first_name'].' '.$row['member_last_name']; ?></h4>
                    <a href="../../includes/logout.inc.php">Sign out</a>                  
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="index.php">
                                <i class="fas fa-tachometer-alt"></i>My Profile  
                            </a>
                        </li>
                        <li>
                            <a href="member_settings.php">
                                <i class="fas fa-key"></i>Change Password</a>
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
                                    <a href="manage_vehicles.php">
                                       <i class="fas fa-car"></i>Manage Vehicles</a>
                                </li>
                                <li>
                                    <a href="upload_butaw.php">
                                        <i class="far fa-check-square"></i>Pay Share Capital</a>
                                </li>
                                
                                <li>
                                    <a href="mem_performance.php">
                                        <i class="fas fa-map-marker-alt"></i>My Performance</a>
                                </li>
                                <li>
                                    <a href="mem_auth_driver.php">
                                       <i class="fas fa-eye"></i>View Authorized Drivers</a>
                                </li>
                            </ul>
                        </li>
                     
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        
        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop2">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap2">
                            <div class="logo d-block d-lg-none">
                                 <a href="index.php">
                   <center> <img src="images/icon/logo.png" alt="Member-Driver" style="width: 60%" /> </center>
                </a>
                            </div>
                            <div class="header-button2">
                                <div class="header-button-item js-item-menu">
                                    <i class="zmdi zmdi-search"></i>
                                    <div class="search-dropdown js-dropdown">
                                        <form action="">
                                            <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />
                                            <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                                <div class="header-button-item  js-item-menu">
                                    <i class="zmdi zmdi-menu"></i>
                                    <div class="notifi-dropdown js-dropdown">
                                        
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                               <a href="index.php"> <i class="zmdi zmdi-home"></i>
                                            </div>
                                            <div class="content">
                                                  Home <span class="sr-only">(current)</span></a>
                                               
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <a href="member_settings.php"> <i class="zmdi zmdi-key"></i>
                                            </div>
                                            <div class="content">
                                                <h5>Change Password</h5></a>
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                               <a href="manage_vehicles.php"> <i class="zmdi zmdi-car"></i>
                                            </div>
                                            <div class="content">
                                                <h5>Manage Vehicles</h5> </a> 
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c2 img-cir img-40">
                                               <a href="upload_butaw.php"> <i class="zmdi zmdi-money"></i>
                                            </div>
                                            <div class="content">
                                                <h5>Pay Share Capital</h5> </a> 
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                               <a href="mem_performance.php"> <i class="zmdi zmdi-assignment-account"></i>
                                            </div>
                                            <div class="content">
                                                <h5>My Performance</h5> </a> 
                                            </div>
                                        </div>
                                        <div class="notifi__item">
                                            <div class="bg-c3 img-cir img-40">
                                               <a href="mem_auth_driver.php"> <i class="zmdi zmdi-account"></i>
                                            </div>
                                            <div class="content">
                                                <h5>View Authorized Drivers</h5> </a> 
                                            </div>
                                        </div>
                                         <div class="notifi__item">
                                            <div class="bg-c4 img-cir img-40">
                                                <a href="../../includes/logout.inc.php"><i class="zmdi zmdi-power-off"> </i>
                                            </div>
                                            <div class="content">
                                                
                                            <h5>Log-out</h5></a>
                                            </div>
                                        </div>

        
                                        
                                        
                                    </div>

                                </div>
                                
                                <div class="header-button-item mr-0 js-sidebar-btn"> 
                                   <!--  <i class="zmdi zmdi-menu"> </i> -->
                                    <div class="notifi-dropdown js-dropdown">
                                        <!--   <ul class="navbar-nav mr-auto navbar-h">
                                                <li class="nav-item active">
                                                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="about.php">About</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="news.php">News</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a class="nav-link" href="tours.php">Tours & Packages</a>
                                                </li>
                                                <li class="nav-item">
                                                      <a href="contact-us.php" class="nav-link">Contact Us</a>
                                                </li>
                                          </ul> -->
                                   
                                    </div>
                                
                               <!--  <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="index.php">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                        </div>
                                        
                                        <div class="account-dropdown__item">
                                            <a href="../../includes/logout.inc.php">
                                            <i class="zmdi zmdi-email"></i>Log-out</a>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
          
    
            <!-- END HEADER DESKTOP-->
        </div>
    </div>

    <style type="text/css">
        .header-button-item has-noti js-item-menu
        {
            z-index: 1 !important;
        }
    </style>

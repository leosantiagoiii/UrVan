<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";
require "../../includes/dbconnect.inc.php";
?>

    <body class="animsition">
        <div class="page-wrapper">
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
                        <!-- <div class="card" style="padding:30px;"> -->
                            <!-- <h3>Profile Picture</h3> -->
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
                            ?>" style="object-fit: cover;"></center>
                            <br>
                            <form action="../../includes/driver_upload_profilepic.inc.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="client_id" value="<?php echo $row['member_id'];?>">
                                <input type="file" name="image_file">
                                <button class="btn btn-success btn-block mt-3" name="uploadp">Upload</button>
                            </form>
                        </div>
                    
                    <?php
                $query=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'");
                $row=mysqli_fetch_assoc($query);
                ?>
                    
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
                <div class="page-container">
                    <!-- HEADER DESKTOP-->
                   <!--  <header class="header-desktop">
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
                    </header> -->
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
                                            <table id="example" class="display table table-data2" style="width:100%">
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
                                                               
                                                            </div>
                                                        </td>
                                                    </tr>
                                          
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
                                        
                                         <?php  }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DATA TABLE-->
                        </div>
                    </div>
                    <br> <br> <br>
                </div>
            </div>
        </div>
        
    </div>
</div>

  <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018-2019 URVAN</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
<!-- Jquery JS-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

<script> $(document).ready( function () {
            $('#example').DataTable();
});
 </script>
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


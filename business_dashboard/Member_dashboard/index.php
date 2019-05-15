<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";
require "../../includes/dbconnect.inc.php";
?>
<body class="animsition">
    <div class="page-wrapper">
        <!-- PAGE CONTAINER-->
        <div class="page-container2">
            <!-- HEADER DESKTOP-->
            
            <section>
                <div class="section__content section__content--p30">
                    <?php
                    $query=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'");
                    $row=mysqli_fetch_assoc($query);
                    ?>
                    <!-- <style> 
                    .card
                    {
                        margin-top:100px;
                    }
                    </style> -->
                    <div class="container-fluid">
                    
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card" style="padding:20px">
                                    <form action="../../includes/member_profile_update.inc.php" method="POST">
                                        <h1><?php echo $row['member_first_name'].' '.$row['member_last_name']; ?>'s Profile</h1>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <label for="">First Name</label>
                                                <div class="input-group mb-6">
                                                    <input required type="text" class="form-control" name="member_first_name" value="<?php echo $row['member_first_name'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Last Name</label>
                                                <div class="input-group mb-6">
                                                    <input required type="text" class="form-control" name="member_last_name" value="<?php echo $row['member_last_name'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                        <label for="">Birthday</label>
                                        <div class="input-group mb-6">
                                            <input required type="date" class="form-control" name="member_birthdate" value="<?php echo $row['member_birthdate'];?>">
                                        </div>
                                    </div>
                                            <div class="col-sm-6">
                                        <label for="">Phone Number</label>
                                        <div class="input-group mb-6">
                                            <input required type="text" class="form-control" name="member_phone_number" value="<?php echo $row['member_phone_number'];?>">
                                        </div>
                                    </div>
                                      </div>
                                       <div class="form-group row">
                                     <div class="col-sm-6">
                                        <label for="">Civil Status</label>
                                        <div class="input-group mb-6">
                                            <input required type="text" class="form-control" name="member_civil_status" value="<?php echo $row['member_civil_status'];?>">
                                        </div>
                                    </div>
                                      <div class="col-sm-6">
                                        <label for=""> Address</label>
                                        <div class="input-group mb-6">
                                            <input required type="text" class="form-control" name="member_address" value="<?php echo $row['member_address'];?>">
                                        </div>
                                    </div>

                                      </div>
                                        <div style="text-align: right;">
                                <button class="btn btn-primary" style="margin-top:0px;" name="savechange" type="submit">Save Changes</button>
                            </div>
                            <div style="margin-top:20px;text-align: right;font-style: oblique;margin-bottom:20px;">
                                <small>Did you know you created your account on <?php echo $row['member_created_at'];?></small>
                            </div>
                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
              
               <?php
                            $query=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'");
                            $row=mysqli_fetch_assoc($query);
                            ?>
            
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8">
                            
                            <div class="card" style="padding:30px;">
                                <h3>Profile Picture</h3>
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
                                ?>" 
                                style="border-radius: 50%;object-fit: cover; width: 100%; height: auto"></center>
                                <br>
                                <form action="../../includes/driver_upload_profilepic.inc.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="client_id" value="<?php echo $row['member_id'];?>">
                                    <input type="file" name="image_file">
                                    <button class="btn btn-success btn-block mt-3" name="uploadp">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </section>
            <section>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-6">
                                
                            </div>
                            <div class="col-xl-6">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
            <!-- END PAGE CONTAINER-->
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
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>
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
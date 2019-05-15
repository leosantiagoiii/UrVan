<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";
require "../../includes/dbconnect.inc.php";
?>
<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        
        
        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            
            <!--  -->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        
                        <div class="container-fluid">
                            <!--Add News-->
                           <div class="row m-t-30">
                        <div class="col-md-12">
                            <!-- DATA TABLE-->
                            <div class="table-responsive m-b-40">
                                <table class="table table-borderless table-data3">
                                    <thead>
                                        <tr>
                                            <th>Driver ID</th>
                                            <th>Driver Name</th>
                                            <th>Driver Licence</th>
                                             <th>Driver Contact</th>
                                            <th>Date Created</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $query="SELECT * FROM official_authorized_driver_table WHERE member_id = '$_SESSION[memberid]'";
                                                    $result=mysqli_query($conn,$query);
                                                    while($rowv=mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $rowv['driver_id']; ?></td>
                                            <td><?php echo $rowv['driver_name']; ?></td>
                                            <td><?php echo $rowv['driver_licence']; ?></td>
                                            <td><?php echo $rowv['driver_contact']; ?></td>
                                            <td><?php echo $rowv['created_at']; ?></td>

                                        </tr>
                                        
                                         <?php  }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- END DATA TABLE-->
                        </div>
                    </div>
                            
                            <!-- DATA TABLE -->
                            
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        
        
    </div>
</div>
</div>


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
$('#example1').DataTable();
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
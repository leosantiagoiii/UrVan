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
            
            <?php
            $sumquery="SELECT SUM(amount) AS finalsum FROM official_member_capital WHERE member_id = '$_SESSION[memberid]' AND status='APPROVED'";
            $resultc=mysqli_query($conn,$sumquery);
            $rowv=mysqli_fetch_assoc($resultc);
            $sum = $rowv['finalsum'];
            ?>
            <?php
            if($rowv['finalsum'] <=59999.00){ ?>
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <i class="fas fa-upload"></i>
                                        Pay Share Capital
                                    </div>
                                    <div class="card-body">
                                        <form action="../../includes/upload_butaw.inc.php" enctype="multipart/form-data" method="POST">
                                            <div class="form-group">
                                                <div class="form-row">
                                                    <div class="col-md-8">
                                                        <div class="form-label-group">
                                                            Upload the Deposit Slip
                                                            <input type="file" name="capital-image" class="form-control" style="padding:13px 10px;">
                                                            <input type="hidden" name="member_id" value="<?php echo $_SESSION['memberid']; ?>">
                                                            <br>
                                                            <input type="text" autocomplete = "off" class="form-control form-control-lg" name = "Refnum" placeholder="Enter Reference Number">
                                                            <input type="text" autocomplete = "off" class="form-control form-control-lg" name = "Amount" placeholder="Enter Amount">
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <input type="submit" name="submitCapital" class="btn btn-primary btn-md" value="Pay Now">
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            else{
            echo "Congrats! Your payment has been completed!";
            }
            ?>
            
            
            
            <!-- END HEADER DESKTOP-->
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        
                        <div class="container-fluid">
                            
                            <h3 class="title-5 m-b-35">Approved Payments</h3>
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
                                            
                                            <th>ID</th>
                                            <th>Member ID</th>
                                            <th>Reference Number</th>
                                            <th>Amount</th>
                                            <th>Deposit Slip </th>
                                            <th>Payment Date</th>
                                            
                                            
                                        </tr>
                                        
                                    </thead>
                                    <tbody>
                                        <?php $query="SELECT * FROM official_member_capital WHERE member_id = '$_SESSION[memberid]'AND status='APPROVED'";
                                        $result=mysqli_query($conn,$query);
                                        while($rowv=mysqli_fetch_assoc($result)) { ?>
                                        
                                        <tr class="tr-shadow">
                                            
                                            <td><?php echo $rowv['id']; ?></td>
                                            <td><?php echo $rowv['member_id']; ?></td>
                                            <td><?php echo $rowv['ref_num']; ?></td>
                                            <td><?php echo $rowv['amount']; ?></td>
                                            <td><a target="_blank" href="../../includes/<?php echo $rowv['file_path'];?>">View </a>
                                        </td>
                                        <td><?php echo $rowv['created_at']; ?></td>
                                    </tr>
                                    
                                    <?php  }
                                    ?>
                                    
                                </tbody>
                                <tr>
                                    
                                    <tbody>
                                        <?php
                                        $cap_query="SELECT SUM(amount) AS count FROM official_member_capital WHERE member_id = '$_SESSION[memberid]' AND status='APPROVED'";
                                        $resultc=mysqli_query($conn,$cap_query);
                                        $rowv=mysqli_fetch_assoc($resultc);
                                        $sum = $rowv['count'];
                                        ?>
                                        <tr>
                                            <th> Total Paid-Up  </th>
                                            <td>
                                                <?php echo $sum ; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </tr>
                            </table>
                            
                            
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- DATA TABLE -->
                                    <br>
                                    <h3 class="title-5 m-b-35">Pending Payments</h3>
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
                                                    
                                                    <th>ID</th>
                                                    <th>Member ID</th>
                                                    <th>Reference Number</th>
                                                    <th>Amount</th>
                                                    <th>Image </th>
                                                    <th>Payment Date</th>
                                                    
                                                    
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                                <?php $query="SELECT * FROM official_member_capital WHERE member_id = '$_SESSION[memberid]'AND status='PENDING'";
                                                $result=mysqli_query($conn,$query);
                                                while($rowv=mysqli_fetch_assoc($result)) { ?>
                                                
                                                <tr class="tr-shadow">
                                                    
                                                    <td><?php echo $rowv['id']; ?></td>
                                                    <td><?php echo $rowv['member_id']; ?></td>
                                                    <td><?php echo $rowv['ref_num']; ?></td>
                                                    <td><?php echo $rowv['amount']; ?></td>
                                                    <td><a target="_blank" href="../../includes/<?php echo $rowv['file_path'];?>">View </a>
                                                </td>
                                                
                                                <td><?php echo $rowv['created_at']; ?></td>
                                            </tr>
                                            
                                            <?php  }
                                            ?>
                                            
                                        </tbody>
                                        <tr>
                                            
                                            <tbody>
                                                <?php
                                                $cap_query="SELECT SUM(amount) AS count FROM official_member_capital WHERE member_id = '$_SESSION[memberid]' AND status='PENDING'";
                                                $resultc=mysqli_query($conn,$cap_query);
                                                $rowv=mysqli_fetch_assoc($resultc);
                                                $sum = $rowv['count'];
                                                ?>
                                                <tr>
                                                    <th> Total Paid-Up  </th>
                                                    <td>
                                                        <?php echo $sum ; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </tr>
                                    </table>
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
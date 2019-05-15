<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";
require "../../includes/dbconnect.inc.php";
$sql=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$_SESSION[memberid]' ORDER BY created_at ASC");
?>
<body class="animsition">
    <div class="page-wrapper">
        
        <div class="page-container">
            
            <div class="main-content">
                <!-- <div class="section__content section__content--p30"> -->
                    <div class="container-fluid">
                        <div class="container-fluid">
                            
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    
                                    <div class="table-responsive m-b-40">
                                        <table class="table table-borderless table-data3">
                                            <thead>
                                                <tr>                             
                                                    <th>Destination</th>
                                                    <th>Van Used</th>
                                                    <th>Overall Rating</th>
                                                    <th>Remarks </th>
                                                    <th>Trip Dates </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php
                                                 $rateARR=array();
                                                while($row=mysqli_fetch_assoc($sql)){
                                                $rating_id=$row['rating_id'];
                                                $sql3=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$row[major_id]' ORDER BY created_at DESC");
                                                $row3=mysqli_fetch_assoc($sql3);
                                                $sql2=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id'AND value IS NOT NULL");
                                                
                                                while($row2=mysqli_fetch_assoc($sql2)){ ?>
                                                 
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $tour_id=$row3['tour_id'];
                                                        $mu=mysqli_query($conn,"SELECT * FROM tours_and_packages_table WHERE tour_id='$tour_id'");
                                                        $mumi=mysqli_fetch_assoc($mu);
                                                        echo $mumi['tour_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $vanid=$row['van_id'];
                                                        $mei=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vanid'");
                                                        $mai=mysqli_fetch_assoc($mei);
                                                        echo $mai['make'].' '.$mai['model'].' ('.$mai['year'].') with the Plate Number of '.$mai['plate_number']; ?>
                                                    </td>

                                                    <td>

                                                        <?php
                                                        if(!isset($row2['value'])){
                                                        echo "No rating";
                                                        }
                                                        else{
                                                        echo $row2['value'];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if(!isset($row2['remarks'])){
                                                        echo "No remarks";
                                                        }
                                                        else{
                                                        echo $row2['remarks'];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $t1=strtotime($row3['start_date']);
                                                        $t2=strtotime($row3['end_date']);
                                                        if($t1==$t2){
                                                        echo $nT1=DATE("Y M d", $t1);
                                                        }
                                                        else{
                                                        $nT1=DATE("Y M d", $t1);
                                                        $nT2=DATE("Y M d", $t2);
                                                        echo $nT1.' to '.$nT2;
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $rateARR[]=$row2['value'];
                                            } 

                                            if(!isset($rateARR)){
                                                        $sum=0;
                                                        $size=0;
                                                        }
                                                        else{
                                                        $sum = array_sum($rateARR);
                                                        $size = sizeof($rateARR);
                                                        }
                                                        
                                                        if($sum<=0 OR $size<=0){
                                                         $finalAns = "No ratings yet";
                                                        }
                                                        else{

                                                         $sun = number_format($finalAns = ($sum/$size),2);
                                                        } 

                                                    } ?>
                                                

                                                       
                                                        

                                               <!--  -->
                                            </tbody>
                                            <tbody>
                                                
                                                <tr>
                                                    <td> <h5>Average Rating </h5></td>
                                                    <td>
                                                        <?php echo $sun; ?>
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                    <br> <br> <br> <br> <br> <br><br>
                                    
                                </div>
                            </div>
                           <!--  <a href="driv_performance.php"> LINK </a> -->
                            <div class="row m-t-30">
                                <div class="col-md-12">
                                    
                                    <div class="table-responsive m-b-40">
                                        <table class="table table-borderless table-data3">
                                            <thead>
                                                <h1> Driver's Performance </h1>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Licence</th>
                                                    <th>Email</th>
                                                    <th>Overall Rating</th>
                                                    <th> </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $ratingARR=array();
                                                $off_mem=mysqli_query($conn,"SELECT * FROM official_authorized_driver_table WHERE member_id ='$_SESSION[memberid]'");
                                                while($row2=mysqli_fetch_assoc($off_mem)){
                                                $member_id=$row2['member_id'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $row2['driver_id'];?></td>
                                                    <td><?php echo $row2['driver_name'];?></td>
                                                    
                                                    <td><?php echo $row2['driver_licence'];?></td>
                                                    <td><?php echo $row2['driver_email'];?></td>
                                                    <td>
                                                        <?php
                                                        $sqi=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$row2[driver_id]'");
                                                        while($reu=mysqli_fetch_assoc($sqi)){
                                                        $rating_id=$reu['rating_id'];
                                                        $smi=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id' AND value IS NOT NULL");
                                                        while($roi=mysqli_fetch_assoc($smi)){
                                                        $ratingARR[]=$roi['value'];
                                                        }
                                                        }
                                                        if(!isset($ratingARR)){
                                                        $sum=0;
                                                        $size=0;
                                                        }
                                                        else{
                                                        $sum = array_sum($ratingARR);
                                                        $size = sizeof($ratingARR);
                                                        }
                                                        
                                                        if($sum<=0 OR $size<=0){
                                                        echo $finalAns = "No ratings yet";
                                                        }
                                                        else{
                                                        echo  $finalAns = ($sum/$size);
                                                        } ?>
                                                        
                                                    </td>
                                                    <td>
                                                        
                                                        <button type="button" data-toggle="modal" data-target="#driv<?php echo $row2['driver_id']; ?>" class="btn btn-primary btn-block">View More</button>

                                                        
                                                        <div class="modal fade bd-example-modal-lg " id="driv<?php echo $row2['driver_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $row2['driver_name'].' ('.$row2['driver_id'].')';?></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row form-group">
                                                                            <div class="col-lg-4">
                                                                                <div class="row form-group">
                                                                                    <div class="col-lg-12">
                                                                                        <?php
                                                                                        if($row2['driver_profile_pic']==null){ ?>
                                                                                        <img src="https://www.w3schools.com/howto/img_avatar.png" style="width:100%;border-radius: 50%" alt="">
                                                                                        <?php
                                                                                        } ?>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            <div class="col-lg-8">
                                                                                <div class="row form-group">
                                                                                    <div class="col-lg-6">
                                                                                        <label style="font-weight: 500;">Name: </label><br>
                                                                                        <?php echo $row2['driver_name']; ?>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <label style="font-weight: 500;">Contact no.: </label><br>
                                                                                        <?php echo $row2['driver_contact'];?>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="col-sm-12">
                                                                                    <table class="table table-borderless table-data3">
                                                                                        <thead>
                                                                                            <center> <h4> Driver's Performance </h4> </center>
                                                                                            <tr>
                                                                                                <th>Trip Dates</th>
                                                                                                <th> Evaluation </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            $sqi=mysqli_query($conn,"SELECT * FROM booking_history_trip WHERE driver_pk='$row2[driver_id]' ORDER BY created_at DESC");
                                                                                            
                                                                                            if(!isset($ratingARR)){
                                                                                            $sum=0;
                                                                                            $size=0;
                                                                                            }
                                                                                            else{
                                                                                            $sum = array_sum($ratingARR);
                                                                                            $size = sizeof($ratingARR);
                                                                                            }
                                                                                            
                                                                                            if($sum<=0 OR $size<=0){
                                                                                            $finalAns = "No ratings yet";
                                                                                            }
                                                                                            else{
                                                                                            $finalAns = ($sum/$size);
                                                                                            }
                                                                                            while($row=mysqli_fetch_assoc($sqi)){
                                                                                            $rating_id=$row['rating_id'];
                                                                                            $sql3=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE major_id='$row[major_id]'");
                                                                                            $row3=mysqli_fetch_assoc($sql3);
                                                                                            $smi=mysqli_query($conn,"SELECT * FROM booking_rating_overall WHERE rating_id='$rating_id' AND value IS NOT NULL ORDER BY created_at DESC");
                                                                                            while($roi=mysqli_fetch_assoc($smi)){?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    
                                                                                                    <?php
                                                                                                    $t1=strtotime($row3['start_date']);
                                                                                                    $t2=strtotime($row3['end_date']);
                                                                                                    if($t1==$t2){
                                                                                                    echo $nT1=DATE("Y M d", $t1);
                                                                                                    }
                                                                                                    else{
                                                                                                    $nT1=DATE("Y M d", $t1);
                                                                                                    $nT2=DATE("Y M d", $t2);
                                                                                                    echo $nT1.' to '.$nT2;
                                                                                                    } ?>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    
                                                                                                    
                                                                                                    echo $ratingARR[]=$roi['value'];
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    ?>
                                                                                                </td>
                                                                                                
                                                                                                
                                                                                                
                                                                                            </td>
                                                                                            
                                                                                        </tr>
                                                                                        <?php
                                                                                        }
                                                                                        }
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                                
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <?php
                                                unset($ratingARR);
                                                
                                                } ?>
                                            </tbody>
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
<style type="text/css">
.modal-content{
margin-top: 120px;
margin-left: 100px;
position:absolute;
z-index:9999 !important;

}


</style>
</body>
</html>
<!-- end document-->
<?php
}
else
{
header ("Location:../../index.php");
}
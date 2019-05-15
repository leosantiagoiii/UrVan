<?php
session_start();
if(isset($_SESSION['adminid'])){
require "header.php";
require "../includes/dbconnect.inc.php"; ?>
<div class="container-fluid">
   <!-- Breadcrumbs-->
   <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="index.php">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Overview</li>
   </ol>

   <?php
   // $rando=DATE("Y-m-d");
   $now=DATE("Y");
   $ago1=DATE("Y",strtotime("-1 year"));
   $ago2=DATE("Y",strtotime("-2 year"));
   $ago3=DATE("Y",strtotime("-3 year"));
   $ago4=DATE("Y",strtotime("-4 year"));
   $today=DATE("Y-m-d");
   $yearEnder=$now.'-04-30';
   if($today==$yearEnder){ ?>
      <div class="jumbotron">
         <?php
         $meimo=mysqli_query($conn,"SELECT DISTINCT major_id FROM booking_history_trip WHERE YEAR(created_at)='$now'");
         $arrayForRep=array();
         while($roip=mysqli_fetch_assoc($meimo)){
            $major_id = $roip['major_id'];
            $sle=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$major_id'");
            $trand=mysqli_fetch_assoc($sle);
            if($trand['total_afterbal']!=null){
               $arrayForRep[]=$trand['total_afterbal'];
               $tripmoney[]=$trand['total_afterbal'];
            }
            else{
               $arrayForRep[]=$trand['total_amount'];
               $tripmoney[]=$trand['total_amount'];
            }
         }
         $sumTrip=array_sum($tripmoney); //

         $fol=mysqli_query($conn,"SELECT * FROM official_member_member_payment WHERE YEAR(created_at)='$now'");
         while($foal=mysqli_fetch_assoc($fol)){
            $arrayForRep[]=$foal['amount'];
            $membershippay[]=$foal['amount'];
         }
         $sumMemberPay=array_sum($membershippay); //

         $dow=mysqli_query($conn,"SELECT * FROM official_member_capital WHERE YEAR(created_at)='$now' AND status='APPROVED'");
         while($do=mysqli_fetch_assoc($dow)){
            $arrayForRep[]=$do['amount'];
            $memca[]=$do['amount'];
         }
         $sumMemCap=array_sum($memca); //

         $summy=number_format(array_sum($arrayForRep),2);
         unset($arrayForRep); ?>
         <h1 class="display-4">BTTSC's Annual Report Is Ready</h1>
         <p class="lead">
            This year, BTTSC has made PHP <?php echo $summy; ?>
         </p>
         <p class="lead">
            <a class="btn btn-primary btn-lg" href="yrlyRep.php?yr=<?php echo $now; ?>&1=<?php echo $sumTrip;?>&2=<?php echo $sumMemberPay;?>&3=<?php echo $sumMemCap;?>" role="button">Learn more</a>
         </p>
      </div>
      <?php
   } ?>

   <div class="row">
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-file-invoice-dollar"></i>
               </div>
               <?php
               $ui=0;
               $sl=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='NO' AND refunded='NO'");
               while($ty=mysqli_fetch_assoc($sl)){
                  $mejor=$ty['major_id'];
                  $yu=mysqli_query($conn,"SELECT * FROM booking_deposit_slip WHERE approval='PENDING' AND major_id='$mejor' AND deposit_slip IS NOT NULL");
                  $djsk=mysqli_num_rows($yu);
                  if($djsk==1){
                     $ui++;
                  }
               }
               ?>
               <div class="mr-5"><?php echo $ui; ?> Deposits</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="deposits.php">
               <span class="float-left">View Details</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-expand-arrows-alt"></i>
               </div>
               <?php
               $boom=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE completion='NO'");
               $hoo=0;
               while($rowz=mysqli_fetch_assoc($boom)){
                  $anova=mysqli_query($conn,"SELECT * FROM booking_balance WHERE major_id='$rowz[major_id]' AND amount IS NULL");
                  while($annova2=mysqli_fetch_assoc($anova)){
                     $hoo++;
                  }
               }
               ?>
               <div class="mr-5"><?php echo $hoo; ?> Extended Trip Reviews</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="deposit_trips.php">
               <span class="float-left">View Details</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>

      <!-- <div class="col-xl-3 col-sm-6 mb-3">
         <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-user-plus"></i>
               </div>
               <?php //$sql="SELECT * FROM member_appointment_details_table WHERE member_appointment_approval='PENDING' OR member_appointment_approval='APPROVED'";
               //$result=mysqli_query($conn,$sql); ?>
               <div class="mr-5"><?php //echo mysqli_num_rows($result); ?> Membership Requests</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="admin_membership_requests.php">
               <span class="float-left">View Details</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div> -->

      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-user-plus"></i>
               </div>
               <?php
               $ssm=mysqli_query($conn,"SELECT * FROM initial_member_appointment");
               $cco=mysqli_num_rows($ssm); ?>
               <div class="mr-5"><?php echo $cco; ?> Membership Requests</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="mem_requests.php">
               <span class="float-left">View Details</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>

      <div class="col-xl-3 col-sm-6 mb-3">
         <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
               <div class="card-body-icon">
                  <i class="fas fa-fw fa-hand-holding-usd"></i>
               </div>
               <?php
               $sql1=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE refund_2nddep='RECEIVED' OR refund_2nddep='WAITING' OR refund_2nddep='GIVEN' ORDER BY created_at DESC");
               $res1=mysqli_num_rows($sql1);
               $num_of_new_accs=$res1;
               ?>
               <div class="mr-5"><?php echo $num_of_new_accs; ?> Requests for Refund</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="refunds_checker.php">
               <span class="float-left">View Details</span>
               <span class="float-right">
                  <i class="fas fa-angle-right"></i>
               </span>
            </a>
         </div>
      </div>

   </div>

   <div class="row">
      <div class="col-lg-6">
         <div class="card mb-3">
            <div class="card-header">
               <i class="fas fa-chevron-up"></i>
               Number of Trips per year
            </div>
            <div class="card-body">
               <div style="width:100%;">
                  <?php
                  $r=mysqli_query($conn,"SELECT DISTINCT YEAR(created_at) FROM booking_majordetails WHERE completion='YES' AND refunded='NO' ORDER BY YEAR(created_at)"); ?>
                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                     google.charts.load('current', {'packages':['corechart']});
                     google.charts.setOnLoadCallback(drawChart);
                     function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                           ['Year', 'Sales'],
                           <?php
                           while($rr=mysqli_fetch_assoc($r)){
                              $rrr=$rr['YEAR(created_at)'];
                              $mel=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE YEAR(created_at)='$rrr' AND completion='YES' AND refunded='NO'");
                              $mell=mysqli_num_rows($mel);
                              echo '["'.$rrr.'",'.$mell.'],';
                           } ?>
                        ]);
                        var options = {
                           title: 'Company Performance',
                           legend: { position: 'bottom' }
                        };
                        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                        chart.draw(data, options);
                     }
                  </script>
                  <div id="curve_chart"></div>
               </div>
            </div>
         </div>         
      </div>
      <div class="col-lg-6">
         <div class="card mb-3">
            <div class="card-header">
               <i class="fas fa-money-bill-alt"></i>
               Cash Garnered from Trips
            </div>
            <div class="card-body">
               <div style="width:100%;">
                  <?php
                  $r=mysqli_query($conn,"SELECT DISTINCT YEAR(created_at) FROM booking_majordetails WHERE completion='YES' AND refunded='NO' ORDER BY created_at LIMIT 5");
                  $array=array();
                  $muku=array();
                  $newArray=array();
                  while($rr=mysqli_fetch_assoc($r)){
                     $rrr=$rr['YEAR(created_at)'];
                     $muku[]=$rrr;
                     "<br>";
                     $ku=mysqli_query($conn,"SELECT * FROM booking_majordetails WHERE YEAR(created_at)=$rrr AND completion='YES' AND refunded='NO'");
                     while($so=mysqli_fetch_assoc($ku)){
                        $mejor_id=$so['major_id'];
                        $tot=0;
                        $ko=0;
                        $hand=mysqli_query($conn,"SELECT * FROM booking_transactions WHERE major_id='$mejor_id'");
                        while($handi=mysqli_fetch_assoc($hand)){
                           if($handi['total_afterbal']==null){
                              $ko=$handi['total_amount'];
                           }
                           else{
                              $ko=$handi['total_afterbal'];
                           }
                           $tot=$ko;
                           $array[]=$tot;
                           // $newArray[$rrr][$mejor_id]=$tot;
                           $newArray[$rrr][$mejor_id]['sales']=$tot;
                        }
                     }
                  }
                  $sum=0;
                  $newnewArray=array();
                  foreach($newArray as $key => $story){
                     $summ=0;
                     foreach($story as $subkey => $subvalue){
                        foreach($subvalue as $sub3key => $sub2value){
                           $sum+=$sub2value;
                           $summ+=$sub2value;
                        }
                     }
                     $newnewArray[$key]=$summ;
                  }
                  // echo "SUM: ".$sum;
                  // echo print_r($newnewArray); ?>
                  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                  <script type="text/javascript">
                     google.charts.load('current', {'packages':['corechart']});
                     google.charts.setOnLoadCallback(drawChart);

                     function drawChart() {
                       var data = google.visualization.arrayToDataTable([
                         // ['Year', 'Sales', 'Expenses'],
                         // ['2004',  1000,      400],
                         ['Year','Sales'],
                         <?php
                         foreach($newnewArray as $key => $val){
                           echo '["' . $key . '",' .  $val . '],';
                         } ?>
                       ]);

                       var options = {
                         title: 'Company Performance',
                         legend: { position: 'bottom' }
                       };

                       var chart = new google.visualization.LineChart(document.getElementById('jk_chart'));

                       chart.draw(data, options);
                     }
                  </script>
                  <div id="jk_chart"></div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="card mb-3">
      <div class="card-header">
         <i class="fas fa-chart-line"></i>
         Revenue thru Trips
      </div>
      <div class="card-body">
         <form action="revenue_per_yr.php" target="_blank" method="get">
            <div class="form-group">
               <label for="">Year:</label>
               <div class="row">
                  <div class="col-lg-8">
                     <select name="tripin" required="" class="form-control" id="">
                        <option value="">Select One</option>
                        <option value="all">All</option>
                        <?php $kka=mysqli_query($conn,"SELECT DISTINCT YEAR(created_at) FROM booking_majordetails WHERE completion='YES' AND refunded='NO' ORDER BY YEAR(created_at)");
                        while($fav=mysqli_fetch_assoc($kka)){ ?>
                        <option value="<?php echo $fav['YEAR(created_at)']; ?>"><?php echo $fav['YEAR(created_at)']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-lg-4">
                     <button class="btn btn-primary mt-2 btn-block" type="submit" name="viewbutton">View</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>

   <div class="card mb-3">
      <div class="card-header">
         <i class="fas fa-user-circle"></i>
         Members
      </div>
      <div class="card-body">
         <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Phone No.</th>
                     <th style="width:5%;">Email</th>
                     <th>Vechiles</th>
                     <th>Status</th>
                     <th>Created at</th>
                     <th>Options</th>
                  </tr>
               </thead>
               <tfoot>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Phone No.</th>
                     <th>Email</th>
                     <th>Vechiles</th>
                     <th>Status</th>
                     <th>Created at</th>
                     <th>Options</th>
                  </tr>
               </tfoot>
               <tbody>
                  <?php
                  $rere=mysqli_query($conn,"SELECT * FROM official_member_table WHERE member_id IN (SELECT member_id FROM verify_mem_table WHERE verify_active='1')");
                  while($rows=mysqli_fetch_assoc($rere)){
                     $quu=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE member_id='$rows[member_id]'");
                     $counT=mysqli_num_rows($quu);
                  ?>
                  <tr>
                     <td><?php echo $rows['member_id'];?></td>
                     <td><?php echo $rows['member_first_name'].' '.$rows['member_last_name'];?></td>
                     <td><?php echo $rows['member_phone_number'];?></td>
                     <td><?php echo $rows['member_email'];?></td>
                     <td class="text-center">
                        <?php if($counT<=0){echo 'NONE';} else {echo $counT; } ?>
                     </td>
                     <td>
                        <?php
                        if($rows['active']=="0"){
                           echo "Active";
                        }
                        else{
                           echo "Inactive";
                        } ?>                     
                     </td>
                     <td><?php echo $rows['member_created_at'];?></td>
                     <td>
                        <form action="" method="GET">
                           <input type="hidden" name="member_id" value="<?php echo $rows['member_id'];?>">
                           <input type="hidden" name="count" value="<?php echo $counT; ?>">
                              <a href="member_details.php?member_id=<?php echo $rows['member_id'];?>" class="btn btn-primary w-100 mb-1">Details</a>
                              <a href="add_driv.php?member_id=<?php echo $rows['member_id'];?>" class="btn btn-success w-100 mb-1">Drivers</a>
                              <button type="submit" name="Vehicles" class="btn btn-warning text-white w-100 mb-1" formaction="add_vehicles.php">Vehicles</button>
                              <?php
                              if($rows['active']=="0"){ ?>
                                 <button type="submit" name="DeacBut" class="btn btn-danger w-100 " formaction="../includes/deac_mem.inc.php">Deactivate</button>
                                 <?php 
                              } else { ?>
                                 <button type="submit" name="AcBut" class="btn btn-success w-100 " formaction="../includes/deac_mem.inc.php">Activate</button>
                                 <?php
                              } ?>
                        </form>
                     </td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </div>
      <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
   </div>
</div>
<!-- /.container-fluid -->
<?php
require "footer.php";
}
else{
echo '<h1 class="log-status">Forbidden</h1>';
} ?>
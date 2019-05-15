<?php
session_start();
require "dbconnect.inc.php";
$stat=$_POST['status'];
$vehicleid=$_POST['id'];
$member_id=$_SESSION['memberid'];
$sql=mysqli_query($conn,"SELECT * FROM vehicle_table WHERE vehicle_table.id='$vehicleid'");
$row=mysqli_fetch_assoc($sql);
$fran=$row['franchised'];
if ($stat=='ACTIVE'){
    $updatestat="UPDATE vehicle_table SET status ='INACTIVE'  WHERE vehicle_table.id= $vehicleid";
    $upresult=mysqli_query($conn, $updatestat);
    if($fran=="YES"){
        $sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE vehicle_id='$vehicleid'");
        $sqnum=mysqli_num_rows($sq);
        if($sqnum>=1){
            mysqli_query($conn,"DELETE FROM vehicleQueue_franchised WHERE vehicle_id='$vehicleid'");
        }
    }
    else{
        $sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicleid'");
        $sqnum=mysqli_num_rows($sq);
        if($sqnum>=1){
            mysqli_query($conn,"DELETE FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicleid'");
        }
    }
}
else { //inactive
    $updatestat="UPDATE vehicle_table SET status ='ACTIVE'  WHERE vehicle_table.id= $vehicleid";
    $upresult=mysqli_query($conn, $updatestat);
    if($fran=="YES"){
        $sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_franchised WHERE vehicle_id='$vehicleid'");
        $sqnum=mysqli_num_rows($sq);
        if($sqnum>=1){}
        else{
            mysqli_query($conn,"INSERT INTO vehicleQueue_franchised (franc_id,vehicle_id,member_id) VALUES ('','$vehicleid','$member_id')");
        }
    }
    else{
        $sq=mysqli_query($conn,"SELECT * FROM vehicleQueue_not_franchised WHERE vehicle_id='$vehicleid'");
        $sqnum=mysqli_num_rows($sq);
        if($sqnum>=1){}
        else{
            mysqli_query($conn,"INSERT INTO vehicleQueue_not_franchised (franc_id,vehicle_id,member_id) VALUES ('','$vehicleid','$member_id')");
        }
    }
}
header ("Location:../business_dashboard/Member_dashboard/manage_vehicles.php");
?>
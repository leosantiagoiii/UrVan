<?php 
session_start();
if (!isset($_SESSION['adminid'])){
    echo 'Forbidden';
} else {
    require "dbconnect.inc.php";
    $admin_username=$_POST['admin_username'];
    $ss="SELECT * FROM admin_table WHERE admin_id=$_SESSION[adminid]";
    $rr=mysqli_query($conn,$ss);
    $ro=mysqli_fetch_assoc($rr);
    $old_uname=$ro['admin_username'];
    if($old_uname!=$admin_username){
        $update="UPDATE activity_log_table SET
        activity_log_username='$admin_username' WHERE
        activity_log_username='$old_uname'";
        mysqli_query($conn,$update);
    }
    $admin_first_name=$_POST['admin_first_name'];
    $admin_last_name=$_POST['admin_last_name'];
    $admin_email=$_POST['admin_email'];
    $admin_phone_number=$_POST['admin_phone_number'];
    $query="UPDATE admin_table SET admin_phone_number='$admin_phone_number',admin_username='$admin_username', admin_first_name='$admin_first_name', admin_last_name='$admin_last_name' WHERE admin_id=$_SESSION[adminid]";
    mysqli_query($conn,$query);
    header('Location:../business_dashboard/admin_settings.php');
}
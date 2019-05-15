<?php 
session_start();
if (!isset($_SESSION['adminid'])){
    echo 'Forbidden';
} else {
    require "dbconnect.inc.php";
    $OldPassword=$_POST['OldPassword'];
    $NewPassword=$_POST['NewPassword'];
    $awa="SELECT admin_password FROM admin_table WHERE admin_id=$_SESSION[adminid]";
    $gr=mysqli_query($conn,$awa);
    if($row=mysqli_fetch_assoc($gr)){
        $pwver=password_verify($OldPassword,$row['admin_password']);
        if($pwver==false){
            header('Location:../business_dashboard/admin_settings.php?passwordchange=error');
            exit();
        }
        else{
            $encrypt_password=password_hash($NewPassword,PASSWORD_DEFAULT);
            $query="UPDATE admin_table SET admin_password='$encrypt_password' WHERE admin_id=$_SESSION[adminid]";
            mysqli_query($conn,$query);
            header('Location:../business_dashboard/admin_settings.php?passwordchange=success');
        }
    }
}
<?php 
session_start();
if (!isset($_SESSION['memberid'])){
    echo 'Forbidden';
} else {
    require "dbconnect.inc.php";
    $OldPassword=$_POST['OldPassword'];
    $NewPassword=$_POST['NewPassword'];
    $a="SELECT * FROM official_member_table WHERE member_id='$_SESSION[memberid]'";
    $gr=mysqli_query($conn,$a);
    if($row=mysqli_fetch_assoc($gr)){
        $pwver=password_verify($OldPassword,$row['member_password']);
        if($pwver==false){
            header('Location:../business_dashboard/Member_dashboard/member_settings.php?passwordchange=error');
            exit();
        }
        else{
            $row['member_password'].'<br>';
            $encrypt_password=password_hash($NewPassword,PASSWORD_DEFAULT);
            $query="UPDATE official_member_table SET member_password='$encrypt_password' WHERE member_id='$_SESSION[memberid]'";
            mysqli_query($conn,$query);
            $encrypt_password;
            header('Location:../business_dashboard/Member_dashboard/member_settings.php?passwordchange=success');
        }
    }
}
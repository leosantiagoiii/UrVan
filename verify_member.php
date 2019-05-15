<?php require "header.php"; ?>
<div class="container text-center" style="padding:30px;">
    <div style="border-style:solid;border-width:1px;margin:200px 0;padding:30px;box-shadow: 17px 20px 0px 0px rgba(0,0,0,0.75);">
        <?php
        if(isset($_GET['member_email']) && !empty($_GET['member_email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        require 'includes/dbconnect.inc.php';
        
        $ha=$_GET['hash'];
        $em=$_GET['member_email'];
        
        $search="SELECT * FROM verify_mem_table WHERE verify_active='0' AND verify_hash='$ha' AND member_email='$em'";
        
        $result=mysqli_query($conn,$search);
        $count=mysqli_num_rows($result);
        if($count>0){
        $query="UPDATE verify_mem_table SET verify_active=1 WHERE verify_active=0 AND verify_hash='$ha' AND member_email='$em'";
        $result=mysqli_query($conn,$query);
        echo '<h2>Hurrah!</h2><div>Your account has been activated, '.$em.'</div>';
        }else{
        echo '
        <h2>Um, excuse me.</h2>
        <div>This link is either invalid or you\'ve already activated your account.</div>
        ';
        }
        }else{
        echo '
        <h2>I\'m sorry but...</h2>
        <div>You\'re account has not been activated yet</div>
        ';
        }?>
    </div>
</div>
<?php
require "footer.php";
?>
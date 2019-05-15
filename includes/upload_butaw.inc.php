<?php session_start();
require "dbconnect.inc.php";
if(!isset($_SESSION['memberid'])){
    header("Location:../index.php?error");
    exit();
}
else{
    if(!isset($_POST['submitCapital'])){
        header("Location:../index.php?error");
        exit();
    }
    else{
        $amount=$_POST['Amount'];
        $ref_num=$_POST['Refnum'];
        $member_id=$_POST['member_id'];
        $target_dir = "capital_slip/";
        $tt=explode(".", $_FILES['capital-image']['name']);
        $newtt=round(microtime(true));
        $target_file = $target_dir . uniqid("",false) . basename($_FILES["capital-image"]["name"]);
        $name_of_image = $newtt . basename($_FILES["capital-image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if(isset($_POST["submitCapital"])) {
            $check = getimagesize($_FILES["capital-image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }  
        if ($_FILES["capital-image"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ){
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        if ($uploadOk == 0){
            echo "Sorry, your file was not uploaded.";
        }
        else{
            $sql="SELECT * FROM official_member_capital WHERE member_id='$member_id'";
            $res=mysqli_query($conn,$sql);
            $row=mysqli_fetch_assoc($res);
            $img=$row['file_path'];
            
            if(move_uploaded_file($_FILES["capital-image"]["tmp_name"], $target_file)){
                
               
               
                $sql="INSERT INTO official_member_capital (id, member_id, file_path, ref_num, amount, status) VALUES ('', '$member_id','$target_file','$ref_num', '$amount', 'PENDING')";
                mysqli_query($conn,$sql);
                 header("Location:../business_dashboard/Member_dashboard/upload_butaw.php?deposit_slip_upload=success");
                exit();
            }
            else{
                echo "Sorry, error uploading the file. Perhaps try again?<br>";
                echo '<a href="../upload_butaw.inc.php?profile_pic_upload=error">Return to Profile</a>';
            }
        }
    }
}
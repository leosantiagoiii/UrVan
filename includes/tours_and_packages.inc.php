<?php session_start();
require "dbconnect.inc.php";
$file = $_FILES['tour-image']['tmp_name'];
$package_name=$_POST['package-name'];
$package_price=$_POST['package-price'];
$package_desc=$_POST['package-desc'];
$latitude=$_POST['latitude'];
$longitude=$_POST['longitude'];
$completeadd=$_POST['completeadd'];
$NCR_choice=$_POST['NCR_choice'];
$single_trip=$_POST['single_trip'];
$multicity=$_POST['multicity'];
$singleloc=$_POST['singleloc'];

if(!isset($file)){
    echo "Please select an image";
}
else
{

    $packages_image = addslashes(file_get_contents($_FILES['tour-image']['tmp_name']));
    $packages_image_name = addslashes($_FILES['tour-image']['name']);
    $packages_image_size = getimagesize($_FILES['tour-image']['tmp_name']);

    $okpo=null;
    if($packages_image_size!==false){
        $okpo=1;
    }
    else{
        $okpo=0;
    }
    if ($_FILES["tour-image"]["size"] > 1000000){
        echo $_FILES["tour-image"]["size"]."Sorry, your file is too large.<br>";
        $okpo = 0;
    }
    if($okpo==0){
        echo "Header img not uploaded<br>";
        exit();
    }
    else{
        $query="INSERT INTO tours_and_packages_table (tour_id,tour_name,tour_description,tour_price,tour_image_name,tour_image) VALUES ('','$package_name','$package_desc','$package_price','$packages_image_name','$packages_image')";
        if(!$insert=mysqli_query($conn,$query)){
            echo "Problem uploading image.";
        }
        else{
            //echo "Image uploaded<p/>Your img:<p/><img src=tour_and_packages_image_get.inc.php?tour_id=$lastid>";
        }
    }

}

$lastid=mysqli_insert_id($conn);

$ls="INSERT INTO tour_and_packages_location (id,tour_id,formatted_address,longitude,latitude) VALUES ('','$lastid','$completeadd','$longitude','$latitude')";
mysqli_query($conn,$ls);


if($NCR_choice=="YES"){
    mysqli_query($conn,"INSERT INTO tours_and_packages_NCR (tour_id) VALUES ('$lastid')");
}

// 
if($single_trip=="YES"){
    mysqli_query($conn,"INSERT INTO tours_and_packages_single (tour_id) VALUES ('$lastid')");
}
// 

if($multicity=="YES"){
    mysqli_query($conn,"INSERT INTO tours_and_packages_multicity (tour_id) VALUES ('$lastid')");
}

if($singleloc=="YES"){
    mysqli_query($conn,"INSERT INTO tours_and_packages_singletrip (tour_id) VALUES ('$lastid')");
}


if(isset($_FILES['tours_gallery']['name'])){
    $count=count($_FILES['tours_gallery']['name']);
    for($i=0;$i<$count;$i++){
        $target_dir="tourgallery/";
        $x=explode(".", $_FILES['tours_gallery']['name'][$i]);
        $newx=round(microtime(true));
        $target_file = $target_dir . $newx . basename($_FILES["tours_gallery"]["name"][$i]);
        $name_of_image = $newx . basename($_FILES["tours_gallery"]["name"][$i]);
        $uploadOk = null;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["tours_gallery"]["tmp_name"][$i]);
        if($check !== false){
            // echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else{
            echo "File is not an image.";
            $uploadOk = 0;
        }
        if (file_exists($target_file)){
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        if ($_FILES["tours_gallery"]["size"][$i] > 2000000){
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
            if (move_uploaded_file($_FILES["tours_gallery"]["tmp_name"][$i], $target_file)){
                $sql="INSERT INTO tours_and_packages_gallery_table 
                (tour_gallery_id,tour_id,target_dir) VALUES ('','$lastid','$target_file')";
                mysqli_query($conn,$sql);
            }
            else{
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    header("Location:../business_dashboard/admin_tours_and_packages.php?posting=success&package-name=$package_name");
}
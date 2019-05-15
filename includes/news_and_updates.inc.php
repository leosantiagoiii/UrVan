<?php session_start();
require "dbconnect.inc.php";
$file = $_FILES['article-image']['tmp_name'];
$news_title = $_POST['article-title'];
$news_content = $_POST['article-content'];
$news_is_featured = $_POST['is-featured'];
$news_author = $_POST['article-author'];

if ($news_is_featured == 'TRUE') {
    $news_is_featured = 'TRUE';
} else {
    $news_is_featured = 'FALSE';
}

if (!empty($_FILES['article-image']['tmp_name'])) {

    $news_image = addslashes(file_get_contents($_FILES['article-image']['tmp_name']));
    $news_image_name = addslashes($_FILES['article-image']['name']);
    $news_image_size = getimagesize($_FILES['article-image']['tmp_name']);

    $ok=null;

    if($news_image_size!==false){
        $ok=1;
    }
    else{
        $ok=0;
    }
    if ($_FILES["article-image"]["size"] > 1000000){
        echo "Sorry, your file is too large.<br>";
        $ok = 0;
    }

    if($ok==0){
        echo "Header img not uploaded<br>";
        exit();
    }
    else{
        $query = "INSERT INTO news_and_updates_table (news_id,news_is_featured,news_title,news_content,news_image_name,news_image,news_time_posted,news_author) VALUES ('','$news_is_featured','$news_title','$news_content','$news_image_name','$news_image',CURRENT_TIMESTAMP(),'$news_author')";
        if (!$insert = mysqli_query($conn, $query)) {
            echo "Problem uploading image.";
            exit();
        } else {
            header("Location:../business_dashboard/admin_news_and_updates.php?posting=success");
        }
    }

} else {

    $query = "INSERT INTO news_and_updates_table (news_id,news_is_featured,news_title,news_content,news_image_name,news_image,news_time_posted,news_author) VALUES ('','$news_is_featured','$news_title','$news_content',NULL,NULL,CURRENT_TIMESTAMP(),'$news_author')";
    if (!$insert = mysqli_query($conn, $query)) {
        echo "Problem posting article.";
        exit();
    } else {
        header('Location:../business_dashboard/admin_news_and_updates.php?posting=success');
    }

}

$lastid=mysqli_insert_id($conn);

if(isset($_FILES['news_gallery']['name'])){
    $count=count($_FILES['news_gallery']['name']);
    for($i=0;$i<$count;$i++){
        $target_dir="newsgallery/";
        $x=explode(".", $_FILES['news_gallery']['name'][$i]);
        $newx=round(microtime(true));
        $target_file = $target_dir . $newx . basename($_FILES["news_gallery"]["name"][$i]);
        $name_of_image = $newx . basename($_FILES["news_gallery"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["news_gallery"]["tmp_name"][$i]);
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
        if ($_FILES["news_gallery"]["size"][$i] > 1000000){
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
            exit();
        }
        else{
            if (move_uploaded_file($_FILES["news_gallery"]["tmp_name"][$i], $target_file)){
                $sql="INSERT INTO news_and_updates_gallery_table 
                (news_gallery_id,news_id,target_dir) VALUES ('','$lastid','$target_file')";
                mysqli_query($conn,$sql);
            }
            else{
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
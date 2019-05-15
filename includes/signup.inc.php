<?php
//code only going to run when signup is clicked. for security.
if(isset($_POST['signup-button'])){

    require "dbconnect.inc.php";

    //rider home address

    $client_first_name=$_POST['rider-first-name'];
    $client_last_name=$_POST['rider-last-name'];
    $client_nickname=$_POST['rider-nickname'];
    $client_email=$_POST['rider-email'];
    $client_username=$_POST['rider-username'];
    $client_password=$_POST['rider-password'];
    $client_password_repeat=$_POST['rider-password-repeat'];
    $client_phone_number=$_POST['rider-phone-number'];

    $address_line=$_POST['address_line'];
    $barangay=$_POST['barangay'];
    $city=$_POST['city'];
    $province=$_POST['province'];
    $postal_code=$_POST['postal_code'];
    $addrFrmManual=$address_line.", ".$barangay.", ".$city.", ".$province.", ".$postal_code.", "."Philippines";

    if(!empty($address_line)||!empty($barangay)||!empty($city)||!empty($province)||!empty($postal)){
        $url='https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($addrFrmManual).'&key=AIzaSyCTc_dzW2Snm5EOKlo3aj1SAbLCAhbNfPI';
        $getJson=file_get_contents($url);
        $json2PHP=json_decode($getJson, true);
        $longitude=$json2PHP['results'][0]['geometry']['location']['lng'];
        $latitude=$json2PHP['results'][0]['geometry']['location']['lat'];
        $formattedAdd=$json2PHP['results'][0]['formatted_address'];
        $place_id=$json2PHP['results'][0]['place_id'];
    }

    $emergency_name=$_POST['emergency_name'];
    $emergency_num=$_POST['emergency_num'];

    $sams=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_email='$client_email'");
    $sja=mysqli_num_rows($sams);
    if($sja>=1){
        header("Location:../signup.php?error=email_exists&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-home-address=".$addrFrmManual."&rider-username=".$client_username."&rider-phone-number=".$client_phone_number."&rider-nickname=".$client_nickname."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
        exit();
    }

    $kkkkkl=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_username='$client_username'");
    $opopppp=mysqli_num_rows($kkkkkl);
    if($opopppp>=1){
        header("Location:../signup.php?error=username_exists&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-home-address=".$addrFrmManual."&rider-email=".$client_email."&rider-phone-number=".$client_phone_number."&rider-nickname=".$client_nickname."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
        exit();
    }

    //blank fields
    if(empty($client_first_name) || empty($client_last_name) || empty($formattedAdd) || empty($client_email) || empty($client_username) || empty($client_password) || empty($client_password_repeat) || empty($client_phone_number) || empty($emergency_name)){
        header("Location:../signup.php?error=emptyfields&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-home-address=".$addrFrmManual."&rider-email=".$client_email."&rider-username=".$client_username."&rider-phone-number=".$client_phone_number."&rider-nickname=".$client_nickname."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
        exit();
    }
    /*
    //invalid name and username
    elseif(!filter_var($client_email, FILER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $client_username)){
        header("Location:../signup.php?error=invalidmail&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-home-address=".$addrFrmManual."&rider-username=".$client_username."&rider-phone-number=".$client_phone_number);
        exit();
    }
    */
    //invalid email and username
    elseif(!filter_var($client_email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $client_username)){
        header("Location:../signup.php?error=invalidmailuname&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-phone-number=".$client_phone_number."&rider-username=&rider-email="."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
        exit();
    }
    //invalid email
    elseif(!filter_var($client_email, FILTER_VALIDATE_EMAIL)){
        header("Location:../signup.php?error=invalidmail&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-username=".$client_username."&rider-phone-number=".$client_phone_number."&rider-email="."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude); //added the &rider-email
        exit();
    }
    //invalid username
    elseif(!preg_match("/^[a-zA-Z0-9]*$/", $client_username)){
        header("Location:../signup.php?error=invalidusername&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-email=".$client_email."&rider-phone-number=".$client_phone_number."&rider-username="."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude); //added the &rider-username
        exit();
    }
    //invalid phone number
    elseif(!preg_match("/^[0-9]*$/", $client_phone_number)){
        header("Location:../signup.php?error=invalidphonenumber&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-email=".$client_email."&rider-username=".$client_username."&rider-phone-number="."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude); //added the &rider-phone-number
        exit();
    }
    //password check
    elseif($client_password !== $client_password_repeat){
        header("Location:../signup.php?error=passwordcheck&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-phone-number=".$client_phone_number."&rider-username=".$client_username."&rider-email=".$client_username."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
        exit();
    }
    //no double usernames and email
    else{

        $sql = "SELECT client_username AND client_email FROM clients_table WHERE client_username=? OR client_email=?";
        $statement = mysqli_stmt_init($conn);
        //$statement = mysqli_query($conn,$sql);
        if(!mysqli_stmt_prepare($statement,$sql)){
            header("Location:../signup.php?error=sqlerror");
            exit();
        }
        else{
            mysqli_stmt_bind_param($statement,"ss",$client_username,$client_email);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $resultcheck = mysqli_stmt_num_rows($statement);
            if($resultcheck>0){
                header("Location:../signup.php?error=invalidemailandusername&rider-first-name=".$client_first_name."&rider-last-name=".$client_last_name."&rider-nickname=".$client_nickname."&rider-home-address=".$addrFrmManual."&rider-email=&rider-phone-number=".$client_phone_number."&rider-username="."&em_name=".$emergency_name."&em_num=".$emergency_num."&long=".$longitude."&lat=".$latitude);
                exit();
            }
            else{
                $sql = "INSERT INTO clients_table (client_username,client_email,client_password,client_first_name,client_last_name,client_nickname,client_home_address,client_phone_number) VALUES (?,?,?,?,?,?,?,?)";
                $statement = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($statement,$sql)){
                    header("Location:../signup.php?error=sqlerrorness");
                    exit();
                }
                else{
                    $encrypt_password=password_hash($client_password,PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($statement,"ssssssss",$client_username,$client_email,$encrypt_password,$client_first_name,$client_last_name,$client_nickname,$addrFrmManual,$client_phone_number);
                    mysqli_stmt_execute($statement);
                    $q=mysqli_query($conn,"SELECT * FROM clients_table WHERE client_username='$client_username'");
                    $fetch=mysqli_fetch_assoc($q);
                    $hash=md5(rand(0,1000));
                    $sq="INSERT INTO verify_client_table
                    (
                    verify_id,client_id,client_hash,client_verify
                    ) VALUES
                    (
                    '',
                    $fetch[client_id],
                    '$hash',
                    '0'
                    )";
                    mysqli_query($conn,$sq);

                    $last_id=mysqli_insert_id($conn);
                    $sasa=mysqli_query($conn,"SELECT client_id FROM verify_client_table WHERE verify_id='$last_id'");
                    $sasaa=mysqli_fetch_assoc($sasa);
                    $id=$sasaa['client_id'];

                    $ting=mysqli_query($conn,"SELECT client_id FROM clients_table WHERE client_id='$id'");
                    $cli=mysqli_fetch_assoc($ting);
                    $idd=$cli['client_id'];
                    mysqli_query($conn,"INSERT INTO clients_emergency (id,client_id,emergency_name,emergency_num) VALUES ('','$idd','$emergency_name','$emergency_num')");
                    mysqli_query($conn,"INSERT INTO clients_location (id,place_id,client_id,longitude,latitude,formatted_addr) VALUES ('','$place_id','$idd','$longitude','$latitude','$formattedAdd')");
                    // email
                    $from="noreply@urvan.webstarterz.com";
                    $to=$client_email;
                    //$replyto=""; bttsc email
                    $subject="Confirm your email, ".$client_first_name." as an UrVan passenger";
                    $message='
                        <html style=\'background-color:blue;color:white;\'>
                            <head>Email Confirmation</head>
                            <p>Click the link below to verify your account, @'.$client_username.'</p>
                            <p>http://urvan.webstarterz.com/verify_client.php?client_id='.$fetch['client_id'].'&client_hash='.$hash.'</p>
                        </html>
                    ';
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= "From: UrVan / BTTSC ".$from."\r\n";
                    //$headers .= 'Reply-to: <'.$replyto.'>' . "\r\n"; bttsc email
                    mail($to,$subject,$message,$headers);
                    // email

                    header("Location:../signup.php?verify=email&success=signupsuccessful");
                    exit();
                }
            }
        }

    }
    mysqli_stmt_close($statement);
    mysqli_close($conn);
}
else {
    echo '<h1>forbidden</h1><br>please return to the homepage. click <a href="../index.php">here</a>';
}
<?php
session_start();
if (isset($_SESSION['adminid'])) {
    require "header.php";
    require "../includes/dbconnect.inc.php";
?>

<main>

    <div class="container-fluid">

          <!--sett-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-cog"></i>
              Main Settings
            </div>
            <div class="card-body">
              <form action="../includes/admin_settings_modify.inc.php" method="POST">
                <?php $query="SELECT * FROM admin_table WHERE admin_id='$_SESSION[adminid]'";
                $result=mysqli_query($conn,$query);
                while( $row=mysqli_fetch_assoc($result) ) { ?>
                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-6">
                          <label for="FirstName">First Name</label>
                          <input name="admin_first_name" class="form-control form-control-lg" id="FirstName" type="text" placeholder="" required value="<?php echo $row['admin_first_name']; ?>" >
                      </div>
                      <div class="col-6">
                        <label for="LastNaem">Last Name</label>
                        <input name="admin_last_name" class="form-control form-control-lg" id="LastNaem" type="text" placeholder="" required value="<?php echo $row['admin_last_name']; ?>" >
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-4">
                          <label for="UserName">Username</label>
                          <input name="admin_username" class="form-control form-control-lg" id="UserName" type="text" placeholder="" required value="<?php echo $row['admin_username']; ?>" >
                      </div>
                      <div class="col-4">
                        <label for="Email">Email</label>
                        <input name="admin_email" class="form-control form-control-lg" id="Email" type="text" placeholder="" required value="<?php echo $row['admin_email']; ?>" readonly>
                      </div>
                      <div class="col-4">
                        <label for="PhoneNumber">Phone number</label>
                        <input name="admin_phone_number" class="form-control form-control-lg" id="PhoneNumber" type="number" placeholder="" required value="<?php echo $row['admin_phone_number']; ?>">
                      </div>
                    </div>
                  </div>

                <?php } ?>

                <input type="submit" class="btn btn-success btn-lg" value="Save" name="SaveChanges">
              </form>
            </div>
            <div class="card-footer small text-muted">Updated <?php date_default_timezone_set('Asia/Manila'); echo date("h:i:sa");?></div>
          </div>
          <!--sett-->

          <!--sett-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-key"></i>
              Password
            </div>
            <div class="card-body">
              <form action="../includes/admin_password_modify.inc.php" method="POST">
                <?php $query="SELECT * FROM admin_table WHERE admin_id='$_SESSION[adminid]'";
                $result=mysqli_query($conn,$query);
                while( $row=mysqli_fetch_assoc($result) ) { ?>
                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-4">
                          <label for="OldPw">Old Password</label>
                          <input class="form-control form-control-lg" name="OldPassword" id="OldPw" type="password" placeholder="" required value="">
                      </div>
                      <div class="col-4">
                        <label for="NewPW">New Password</label>
                        <input class="form-control form-control-lg" name="NewPassword" id="NewPW" type="password" placeholder="" required value="">
                      </div>
                      <div class="col-4">
                        <label for="reppass">Repeat New Password</label>
                        <input class="form-control form-control-lg" name="NewPasswordRepeat" id="reppass" type="password" placeholder="" onkeyup="checkPass(); return false;" required value="">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-9"></div>
                      <div class="col-3">
                          <span id="confirmMessage" class="confirmMessage"></span>
                      </div>
                    </div>
                  </div>
                <?php } ?>

                <input type="submit" class="btn btn-primary btn-lg" value="Save" name="SaveChanges">
              </form>
            </div>
            <div class="card-footer small text-muted">Updated <?php date_default_timezone_set('Asia/Manila'); echo date("h:i:sa");?></div>
          </div>
          <!--sett-->

    </div>
    
    <script>
      function checkPass(){
        var pass1=document.getElementById('NewPW');
        var pass2=document.getElementById('reppass');
        var message = document.getElementById('confirmMessage');
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
        var color="#000000";
        if(pass2.value==null){
          pass2.style.backgroundColor = color;
          message.style.color = color;
          message.innerHTML = "Passwords shouldnt be left blank"
        }
        else if(pass1.value == pass2.value){
          pass2.style.backgroundColor = goodColor;
          message.style.color = goodColor;
          message.innerHTML = "Passwords Match!"
        }else{
            pass2.style.backgroundColor = badColor;
            message.style.color = badColor;
            message.innerHTML = "Passwords Do Not Match!"
        }
      }
    </script>

</main>

<?php
require "footer.php";
} else {
    echo '<h1 class="log-status">Forbidden</h1>';
}?>
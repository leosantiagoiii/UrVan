<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin - Login</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <style>
    .background-admin-login{
    background-image:url('../images/login-bg-one.png');
    background-size:cover;
    background-repeat: no-repeat;
    }
    </style>
  </head>
  <body class="background-admin-login">
    <div class="container">
      <div class="card card-login mx-auto mt-5 ">
        <div class="card-header" style="font-size:20px;font-weight: 700;"><a href="../index.php">Home</a> | Business Login</div>
        <div class="card-body">
          <form action="../includes/login_business.inc.php" method="post">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputEmail" class="form-control" placeholder="Email/Username" required="required" autofocus="autofocus" name="admin-email-uname" value="<?php
                $var = NULL;
                if(isset($_GET['error'])=='emptyfields' || isset($_GET['error'])=='wrongpassword'){
                echo $_GET['admin-email-uname'];
                } elseif(isset($_GET['error'])=='nouserindatabase'){
                echo NULL;
                } else {
                echo NULL;
                }
                ?>">
                <label for="inputEmail">Email/Username</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="admin-password">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <button class="btn btn-primary btn-block" type="submit" value="Login" name="login-admin-button">Login</button>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="../index.php"><b>Go Back Home</b></a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  </body>
</html>
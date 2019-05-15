<?php
session_start();
if(isset($_SESSION['adminid'])){
  require "header.php";
?>

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>

          <!-- Page Content -->
          <h1>Blank Page</h1>
          <hr>
          <p>This is a great starting point for new custom pages.</p>

        </div>
        <!-- /.container-fluid -->

<?php
  require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>

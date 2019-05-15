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
            <li class="breadcrumb-item active">404 Error</li>
          </ol>

          <!-- Page Content -->
          <h1 class="display-1">404</h1>
          <p class="lead">Page not found. You can
            <a href="javascript:history.back()">go back</a>
            to the previous page, or
            <a href="index.html">return home</a>.</p>

        </div>
        <!-- /.container-fluid -->

<?php
  require "footer.php"; 
}
else{
  echo '<h1 class="log-status">Forbidden</h1>';
} ?>
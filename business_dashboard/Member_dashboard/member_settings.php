<?php
session_start();
if (isset($_SESSION['memberid'])) {
require "header.php";

require "../../includes/dbconnect.inc.php";
?>
<body class="animsition">
    <div class="page-wrapper">
        <div class="page-container">
            <!-- HEADER DESKTOP-->
          <section class="statistic">
            
          <!-- STATISTIC-->
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                <form action="../../includes/member_password_modify.inc.php" method="POST"> 
                 
                <div class="form-group">
                  <div class="row">
                   
                
              <h1> Change your password: </h1>
                 <br> 
             
             </div>
                  <div class="row">
                  <div class="col-lg-3">
                      <label for="OldPw">Old Password</label>
                      <input class="form-control " name="OldPassword" id="OldPw" type="password" placeholder="" required value="">
                    </div>
                   <div class="col-lg-3">
                      <label for="NewPW">New Password</label>
                      <input class="form-control " name="NewPassword" id="NewPW" type="password" placeholder="" required value="">
                    </div>
                   <div class="col-lg-3">
                      <label for="reppass">Repeat New Password</label>
                      <input class="form-control " name="NewPasswordRepeat" id="reppass" type="password" placeholder="" onkeyup="checkPass(); return false;" required value="">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3">
                      <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                  </div>
                </div>
                <input type="submit" id="btn" class="btn btn-primary btn-lg" value="Save" name="SaveChanges">
                </form>
                <br><br><br><br><br><br><br>
                </div>
              </div>
            </div>
          </section>
          <!-- END STATISTIC-->
          
          
     
          
      </div>
    </div>
  </div>

      <div class="card-footer small text-muted">Updated <?php date_default_timezone_set('Asia/Manila'); echo date("h:i:sa");?></div>
    </div>
<section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Copyright © 2018-2019 URVAN</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  
  </div>



<?php
require "footer.php";
 }
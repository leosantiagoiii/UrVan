   <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
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
</body>
</html>
<?php require "header.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <style>
  
  /* janella 1/20/19 */
  /*contact us page */
  * {
  box-sizing: border-box;
  }
  .bg-img {
  /* The image used */
  background-image: url("images/contact.png");
  /* Control the height of the image */
  min-height: 650px;
  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  }
  /* Add styles to the form container */
  .container {
  position: absolute;
  top: 35px;
  left: 60px;
  margin: 20px;
  max-width: 450px;
  padding: 16px;
  background-color: white;
  }
  /* Full-width input fields */
  input[type=text], input[type=password] , input[type=email] {
  width: 100%;
  padding: 10px;
  margin: 3px 0 8px 0;
  border: none;
  background: #f1f1f1;
  }
  textarea[id=subject] {
  width: 100%;
  padding: 10px;
  margin: 3px 0 8px 0;
  border: none;
  background: #f1f1f1;
  }
  input[type=text]:focus, input[type=password]:focus, input[type=email]:focus{
  background-color: #ddd;
  outline: none;
  }
  textarea[id=subject]:focus{
  background-color: #ddd;
  outline: none;
  }
  /* Set a style for the submit button */
  .btn-k {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  }
  .btn-k:hover {
  opacity: 1;
  }
  .top-right {
  position: absolute;
  top: 154px;
  right: 205px;
  }
  #icons{
  width: 80px;
  padding-left: 20px;
  }
  #counterContact {
  position: relative;
  display: inline;
  padding-top: 80px;
  }
  #over {
  position:absolute;
  left:3%;
  top:43%;
  max-width: 8%;
  }
  #over1 {
  position:absolute;
  left:13%;
  top:43%;
  max-width: 8%;
  }
  #over2 {
  position:absolute;
  left:23%;
  top:43%;
  max-width: 8%;
  }
  #over3{
  position:absolute;
  left:33%;
  top:43%;
  max-width: 8%;
  }
  .container-fluid{
  padding-left: 5px;
  padding-top: 11px;
  }
  </style>
</head>
<main>
  <div class="bg-img" style="padding:30px;font-family:raleway;">
    <section class="container-fluid" >
      <section class="col-lg-5 col-sm-6 col-md-4">
        <form action="includes/contact_msg.inc.php" class="container-fluid" method="POST">
          <h1>Contact Us</h1>
          <label for="fname"><b>Full Name</b></label>
          <input class="form-control" type="text" placeholder="Enter First Name" name="fullname" required>
          <label for="lname"><b>Subject</b></label>
          <input class="form-control" type="text" placeholder="Enter Last Name" name="subject" required>
          <label for="email"><b>Email</b></label>
          <input class="form-control" type="email" placeholder="Enter Email" name="email" required>
          <label for="subject"><b>Message</b></label>
          <textarea class="form-control" id="subject" name="message" placeholder="Write something.." style="height:100px" required></textarea>
          <br>
          <button type="submit" class="btn-k btn-block" name="send">Send</button>
        </form>
      </div>
      <div class="containerContact">
        <div class="row-fluid">
          <div class="span12">
            <div id="counterContact">
              <a href="https://www.facebook.com/groups/470083646501584/?ref=br_rs" target="_blank"><img id="over"  src="images/fb-icon.png" /> </a>
              <a href="" target="_blank"><img id="over1"  src="images/mail-icon.png" /> </a>
              <a href="https://www.google.com/maps/place/Galamay-Amo,+San+Jose,+Batangas/@13.9019269,121.0797909,14z/data=!4m5!3m4!1s0x33bd12603138372f:0xa97c32a6d55527b3!8m2!3d13.9013259!4d121.0979963" target="_blank"><img id="over2"  src="images/location-icon.png" /> </a>
              <a href="" target="_blank"><img id="over3"  src="images/phone-icon.png" /> </a>
              </b>
              
            <img src="images/contact3.jpg" alt="bg" width="100%" height="370px;"> </a> </p>
          </div>
        </div>
      </div>
      
      
    </section>
  </section>
</section>
</div>
</main>
<?php require "footer.php"; ?>
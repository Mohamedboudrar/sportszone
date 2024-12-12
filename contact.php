<!DOCTYPE html>
<html lang="en">

<head>
  <title>SportsZone || Contact</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700|Muli:300,400" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="css/aos.css">
  <link href="css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="css/style.css">



</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

   <?php include_once("includes/navbar.php");?>

    <div class="intro-section site-blocks-cover innerpage" style="background-image: url('images/hero4.jpg');">
      <div class="container">
        <div class="row align-items-center text-center border">
          <div class="col-lg-12 mt-5" data-aos="fade-up">
            <h1>Get In Touch</h1>
            
          </div>
        </div>
      </div>
    </div>

    
    <div class="site-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-12">
        <h2 class="mb-4 text-center">Contact Us</h2>
      </div>
      
      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" id="name" class="form-control" placeholder="Enter your name" required>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="form-group">
          <label for="phone" class="form-label">Your Phone</label>
          <input type="tel" id="phone" class="form-control" placeholder="Enter your phone number" required>
        </div>
      </div>

      <div class="col-lg-12 mb-3">
        <div class="form-group">
          <label for="message" class="form-label">Message</label>
          <textarea id="message" class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
        </div>
      </div>

      <div class="col-lg-12 text-center">
        <button type="submit" class="btn btn-primary px-5" id="sendMessageBtn">Send</button>
      </div>
    </div>
  </div>
</div>



    <?php include_once("includes/footer.php");?>
    

  </div>
  <!-- .site-wrap -->


  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff5e15"/></svg></div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.mb.YTPlayer.min.js"></script>




  <script src="js/main.js"></script>
  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
<script>
  (function(){
    emailjs.init("QYOgbxA4W7aXK7Scd"); // Your EmailJS User ID here
  })();

  document.getElementById("sendMessageBtn").addEventListener("click", function() {
  // Get user input values
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const message = document.getElementById("message").value;

  if (name && email && phone && message) {
    const templateParams = {
      user_name: name,
      user_email: email,
      user_phone: phone,
      message: message
    };

    // Log the params to verify
    console.log("Sending email with params:", templateParams);

    // Send email using EmailJS service
    emailjs.send("service_xoqvviu", "template_9zwa5ca", templateParams)
      .then(function(response) {
        console.log('Success:', response);
        alert("Your message has been sent successfully!");
        location.reload();
      }, function(error) {
        console.log('Error:', error);
        alert("Failed to send your message. Please try again.");
      });
  } else {
    alert("Please fill in all fields.");
  }
});

</script>

</body>

</html>
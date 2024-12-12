<?php session_start();
// Database Connection
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>SportsZone || Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Dancing+Script:400,700|Muli:300,400" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
    
    <div class="hero-slide owl-carousel site-blocks-cover">
      <div class="intro-section" style="background-image: url('images/hero4.jpg');">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-7 mx-auto text-center" data-aos="fade-up">
            <h1>Serve Your Passion – Elevate Your Game with Tennis!</h1>

          
              
            </div>
          </div>
        </div>
      </div>

      <div class="intro-section" style="background-image: url('images/hero5.jpg');">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-7 mx-auto text-center" data-aos="fade-up">
            <h1>Kickstart Your Journey – Live the Passion of Football!</h1>
          </div>
          </div>
        </div>
      </div>

    </div>
    <!-- END slider -->

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="images/hero6.jpg" alt="Image" class="img-fluid">
          </div>
          <div class="col-md-6">
            <span class="text-serif text-primary">About Us</span>
            <h3 class="heading-92913 text-black">Welcome To Our Website</h3>
            <p>Welcome to SportsZone, your trusted partner in action and recreation. We specialize in providing seamless sports facility reservation services tailored to your needs. Whether for practice, tournaments, or leisure, we ensure your experience is convenient, hassle-free, and perfectly organized.</p><br>
            <p>Book with us, and let every game reflect your passion for sports.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto py-16 ">
    <div class="grid md:grid-cols-3 gap-8">
        <?php 
        $services = [
            [
                'icon' => 'fa-solid fa-dumbbell',
                'title' => 'State-of-the-Art Facilities',
                'description' => 'Modern equipment and professional-grade sports infrastructure'
            ],
            [
              'icon' => 'fa-solid fa-building',
              'title' => 'Modern Infrastructure',
              'description' => 'Clean, spacious, and fully-equipped sports facilities'
            ],
            [
                'icon' => 'fa-solid fa-users',
                'title' => 'Community Programs',
                'description' => 'Inclusive training and development for all skill levels'
            ]
        ];

        foreach ($services as $service): ?>
            <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <div class="bg-blue-100 rounded-full p-4 w-24 h-24 flex items-center justify-center">
                        <i class="<?= $service['icon'] ?> text-5xl text-blue-600"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3"><?= $service['title'] ?></h3>
                <p class="text-gray-600"><?= $service['description'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="site-section bg-image overlay" style="background-image: url('images/hero7.jpg');">
   <div class="container">
       <div class="row">
           <div class="col">
               <div class="counter-39392">
                   <h3>50+</h3>
                   <span>Sports Facilities</span>
               </div>
           </div>
           <div class="col">
               <div class="counter-39392">
                   <h3>7000+</h3>
                   <span>Athletes Trained</span>
               </div>
           </div>
           <div class="col">
               <div class="counter-39392">
                   <h3>120</h3>
                   <span>Training Programs</span>
               </div>
           </div>
       
           <div class="col">
               <div class="counter-39392">
                   <h3>100</h3>
                   <span>Sports Disciplines</span>
               </div>
           </div>
       </div>
   </div>
</div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center">
            <span class="text-serif text-primary">Facilities</span>
            <h3 class="heading-92913 text-black text-center">Our Facilities</h3>
          </div>
        </div>
        <div class="row">
         <?php $query=mysqli_query($con,"select * from tblboat limit 6");
$cnt=1;
while($result=mysqli_fetch_array($query)){
?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-39381">
              <img src="admin/images/<?php echo $result['Image'];?>" alt="Image"  style="width: 100%; height: 200px; object-fit: cover;" >
              <div class="p-4">
                <h3><a href="zone-details.php?bid=<?php echo $result['ID']; ?>"><span class="icon-room mr-1 text-primary"></span> <?php echo $result['BoatName']?> <br> </a></h3>
                
                <div class="d-flex">
                <p><?php echo $result['Description']?></p>
                  <div class="ml-auto price">
                    <span class="bg-primary">$<?php echo $result['Price']?></span>
                  </div>
                  
                </div>
              </div>
            </div>
          </div><?php $cnt++;} ?>
          
       

        </div>
      </div>
    </div>

    



    <div class="site-section bg-image overlay" style="background-image: url('images/hero7.jpg');">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            <h2 class="text-white mb-1">Get In Touch With Us</h2>
            <p class="mb-0">
                <a href="contact.php" class="btn btn-light py-3 px-5 text-black">
                    <strong>Contact Us</strong>
                </a>
            </p>
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
  <style>
    .bg-image {
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        position: relative;
    }

    .overlay {
        position: relative;
    }

    .overlay:before {
        position: absolute;
        content: "";
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        background: rgba(0, 0, 0, 0.6);
    }

    .site-section {
        padding: 2.5em 0;
    }

    .btn-light {
        background: #fff;
        border-radius: 30px;
        color: #000;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .text-black {
        color: #000 !important;
    }

    /* Improved button styles */
    .btn {
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-primary {
        background-color: #2563eb;
        border: none;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }
  </style>

</body>

</html>
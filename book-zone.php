<?php 
session_start();
include('includes/config.php');
include('includes/alert-handler.php');

if (isset($_POST['submit'])) {
    $boatid = $_GET['bid'];
    $fname = $_POST['fname'];
    $emailid = $_POST['emailid'];
    $phonenumber = $_POST['phonenumber'];
    $bookingdate = $_POST['bookingdate'];
    $timefrom = $_POST['timefrom'];
    $timeto = $_POST['timeto'];
    $nopeople = $_POST['numnerofpeople'];
    $bno = mt_rand(100000000, 9999999999);

    // Get zone capacity
    $zoneQuery = mysqli_query($con, "SELECT Capacity FROM tblboat WHERE ID='$boatid'");
    $zoneData = mysqli_fetch_array($zoneQuery);
    $zoneCapacity = $zoneData['Capacity'];

    // Validate number of people
    if ($nopeople > $zoneCapacity) {
        showToast("Maximum capacity for this zone is $zoneCapacity people.");
        exit();
    }

    // Validate date (must be future date)
    $currentDate = date('Y-m-d');
    if ($bookingdate <= $currentDate) {
        showToast('Please select a future date for booking.');
        exit();
    }

    // Validate time (must be 1 hour exactly)
    $time1 = strtotime($timefrom);
    $time2 = strtotime($timeto);
    $difference = round(abs($time2 - $time1) / 3600, 2);
    
    if ($difference != 1) {
        showToast('Booking duration must be exactly 1 hour.');
        exit();
    }

    // Check if time is in the past for today's bookings
    if ($bookingdate == date('Y-m-d') && $timefrom <= date('H:i')) {
        showToast('Please select a future time slot.');
        exit();
    }

    // Check if user already has a booking for this date
    $userBookingCheck = mysqli_query($con, "SELECT * FROM tblbookings 
        WHERE EmailId = '$emailid' 
        AND BookingDate = '$bookingdate'
        AND BookingStatus != 'Rejected'");
    
    if (mysqli_num_rows($userBookingCheck) > 0) {
        showToast('You already have a booking for this date.');
        exit();
    }

    // Check availability
    $ret = mysqli_query($con, "SELECT * FROM tblbookings 
        WHERE BookingDate = '$bookingdate' 
        AND BoatID = '$boatid' 
        AND BookingStatus != 'Rejected'
        AND (
            ('$timefrom' BETWEEN TimeFrom AND TimeTo) 
            OR ('$timeto' BETWEEN TimeFrom AND TimeTo) 
            OR (TimeFrom BETWEEN '$timefrom' AND '$timeto')
        )");
    
    if (mysqli_num_rows($ret) > 0) {
        showToast('The Zone is not available for the selected time slot.');
        exit();
    }

    // If all validations pass, insert the booking
    $query = mysqli_query($con, "INSERT INTO tblbookings (
        BoatID, BookingNumber, FullName, EmailId, PhoneNumber, 
        BookingDate, TimeFrom, TimeTo, NumnerofPeople, postingDate
    ) VALUES (
        '$boatid', '$bno', '$fname', '$emailid', '$phonenumber', 
        '$bookingdate', '$timefrom', '$timeto', '$nopeople', NOW()
    )");

    if ($query) {
        showToastAndRedirect('Booking successful! Your booking number is: ' . $bno, 'status.php', 'success');
    } else {
        showToast('Something went wrong. Please try again.');
    }
    exit();
}

// Get zone details
$bid = intval($_GET['bid']);
$query = mysqli_query($con, "SELECT * FROM tblboat WHERE ID='$bid'");
$result = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>SportsZone || Booking Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Dancing+Script:400,700|Muli:300,400" rel="stylesheet">
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

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

  <style>
  .card {
      border-radius: 15px;
      border: none;
      transition: all 0.3s ease;
  }

  .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
  }

  .form-control {
      border-radius: 8px;
      padding: 10px 15px;
      border: 1px solid #e0e0e0;
  }

  .form-control:focus {
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
      border-color: #2563eb;
  }

  .btn-primary {
      border-radius: 8px;
      padding: 12px 30px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .badge {
      padding: 8px 12px;
      border-radius: 6px;
      font-weight: 500;
  }

  .form-label {
      font-weight: 500;
      margin-bottom: 0.5rem;
  }

  .form-text {
      color: #6b7280;
      font-size: 0.875rem;
      margin-top: 0.25rem;
  }

  .text-muted {
      color: #4b5563 !important;
  }

  .shadow-sm {
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06) !important;
  }

  .toastify {
      padding: 12px 20px;
      color: white;
      font-size: 15px;
      font-weight: 500;
      border-radius: 8px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
  }

  .toastify.on {
      opacity: 1;
  }

  .bg-image {
      background-size: cover;
  }
  </style>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

  


    
    <?php include_once("includes/navbar.php");?>
    <?php 
$bid=$_GET['bid'];
$query = mysqli_query($con, "SELECT * FROM tblboat WHERE ID='$bid'");
$cnt=1;
while($result=mysqli_fetch_array($query)){
?>
    
    
    <div class="site-section" style="padding-top: 80px;">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <!-- Zone Image Card -->
            <div class="card shadow-sm">
                <img src="admin/images/<?php echo $result['Image'];?>" alt="Image" class="card-img-top" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $result['BoatName']; ?></h4>
                    <p class="card-text"><?php echo $result['Description']; ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">Price: <?php echo $result['Price']; ?> MAD / Person</span>
                        <span class="badge bg-info text-white">Capacity: <?php echo $result['Capacity']; ?> people</span>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-md-6">
            <!-- Booking Form Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">Book Your Slot</h3>
                    <form action="#" method="post" class="needs-validation" novalidate>
                        <!-- Personal Information -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Personal Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="emailid" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="emailid" name="emailid" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phonenumber" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phonenumber" name="phonenumber" 
                                           pattern="[0-9]{10}" maxlength="10" required>
                                    <div class="form-text">10 digits number</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numnerofpeople" class="form-label">Number of People</label>
                                    <input type="number" class="form-control" id="numnerofpeople" 
                                           name="numnerofpeople" min="1" 
                                           max="<?php echo $result['Capacity']; ?>" required>
                                    <div class="form-text">Max capacity: <?php echo $result['Capacity']; ?> people</div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Booking Details</h5>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="bookingdate" class="form-label">Select Date</label>
                                    <input type="date" class="form-control" id="bookingdate" name="bookingdate" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="timefrom" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="timefrom" name="timefrom" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="timeto" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="timeto" name="timeto" readonly required>
                                    <div class="form-text">Duration: 1 hour</div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">
                                Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div><?php } ?>

    <div class="site-section bg-image overlay" style="background-image: url('images/hero7.jpg');">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            <h2 class="text-white mb-1">Get In Touch With Us</h2>
            <p class="mb-0"><a href="contact.php" class="btn btn-light py-3 px-5 text-black"><strong>Contact Us</strong></a></p>
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

</body>
  <script type="text/javascript">
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
        });
    </script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Set min date to tomorrow
      var tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      var tomorrowFormatted = tomorrow.toISOString().split('T')[0];
      document.querySelector('input[name="bookingdate"]').min = tomorrowFormatted;

      // Calculate end time automatically
      document.querySelector('input[name="timefrom"]').addEventListener('change', function() {
          var startTime = this.value;
          if (startTime) {
              var endTime = new Date('2000-01-01 ' + startTime);
              endTime.setHours(endTime.getHours() + 1);
              var endTimeString = endTime.toTimeString().slice(0, 5);
              document.querySelector('input[name="timeto"]').value = endTimeString;
              document.querySelector('input[name="timeto"]').readOnly = true;
          }
      });
  });
  </script>

</html>
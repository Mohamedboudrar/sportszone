<?php 
session_start();
include('includes/config.php');
include('includes/alert-handler.php');

// Initialize search parameters
$emailid = '';
$phonenumber = '';
$showResults = false;

// Store search parameters in session when form is submitted
if(isset($_POST['submit'])) {
    $emailid = $_POST['emailid'];
    $phonenumber = $_POST['phonenumber'];
    $showResults = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>SportsZone || Booking Status</title>
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
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">
    <?php include_once("includes/navbar.php");?>
    
    <div class="content-wrapper">
        <div class="site-section" style="padding-top: 80px;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h3 class="text-center mb-4">Check Booking Status</h3>
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="emailid">Email Address</label>
                                            <input type="email" class="form-control" name="emailid" required="true" 
                                                   value="<?php echo htmlspecialchars($emailid); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="phonenumber">Phone Number</label>
                                            <input type="text" class="form-control" name="phonenumber" maxlength="10" 
                                                   pattern="[0-9]+" required="true" 
                                                   value="<?php echo htmlspecialchars($phonenumber); ?>">
                                        </div>
                                        <div class="form-group col-md-12 text-center">
                                            <button type="submit" name="submit" class="btn btn-primary px-5">
                                                Check Status
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($showResults): ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <?php
                        $query = mysqli_query($con, "SELECT tblbookings.*, tblboat.BoatName, tblboat.Image 
                            FROM tblbookings 
                            LEFT JOIN tblboat ON tblboat.ID=tblbookings.BoatID 
                            WHERE tblbookings.EmailId='$emailid' 
                            AND tblbookings.PhoneNumber='$phonenumber'
                            ORDER BY tblbookings.ID DESC");
                        
                        if(mysqli_num_rows($query) > 0):
                        ?>
                        <div class="row">
                            <?php while($row = mysqli_fetch_array($query)): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card booking-card shadow-sm">
                                    <div class="zone-image-preview">
                                        <img src="admin/images/<?php echo $row['Image']; ?>" alt="Zone Image">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['BoatName']; ?></h5>
                                        <div class="booking-details">
                                            <p><strong>Booking Number:</strong> <?php echo $row['BookingNumber']; ?></p>
                                            <p><strong>Date:</strong> <?php echo $row['BookingDate']; ?></p>
                                            <p><strong>Time:</strong> <?php echo $row['TimeFrom']; ?> - <?php echo $row['TimeTo']; ?></p>
                                            <p><strong>Status:</strong> 
                                                <span class="badge <?php 
                                                    echo ($row['BookingStatus'] == 'Accepted') ? 'bg-success' : 
                                                        (($row['BookingStatus'] == 'Rejected') ? 'bg-danger' : 'bg-warning'); 
                                                ?>">
                                                    <?php echo ($row['BookingStatus'] == 'Accepted') ? 'Accepted' : 
                                                               (($row['BookingStatus'] == 'Rejected') ? 'Rejected' : 'Not Processed Yet'); ?>
                                                </span>
                                            </p>
                                            <?php if(!empty($row['AdminRemark'])): ?>
                                                <div class="admin-remark mt-3">
                                                    <p class="mb-1"><strong>Admin Remark:</strong></p>
                                                    <div class="alert <?php 
                                                        echo ($row['BookingStatus'] == 'Accepted') ? 'alert-success' : 
                                                            (($row['BookingStatus'] == 'Rejected') ? 'alert-danger' : 'alert-warning'); 
                                                    ?> py-2">
                                                        <?php echo htmlspecialchars($row['AdminRemark']); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($row['BookingStatus'] == 'Pending'): ?>
                                                <div class="text-end">
                                                    <a href="cancel-booking.php?bid=<?php echo base64_encode($row['ID']);?>&eml=<?php echo base64_encode($row['EmailId']);?>&pno=<?php echo base64_encode($row['PhoneNumber']);?>" 
                                                       class="btn btn-danger btn-sm" 
                                                       onclick="return confirm('Are you sure you want to cancel this booking?');">
                                                        Cancel Booking
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                        <?php else: ?>
                            <div class="alert alert-info text-center">
                                No bookings found for the provided email and phone number.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
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
  <style>
    .booking-card {
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid #eee;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .booking-card:hover {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .preview-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .extended-info {
      max-height: 0;
      opacity: 0;
      transition: all 0.3s ease;
      overflow: hidden;
    }

    .booking-card.expanded .extended-info {
      max-height: 1000px;
      opacity: 1;
      margin-top: 1.5rem;
    }

    .badge {
      padding: 0.5rem 1rem;
      border-radius: 30px;
    }

    .zone-image-preview {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      overflow: hidden;
      flex-shrink: 0;
    }

    .zone-image-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .preview-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

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

    .admin-remark .alert {
        font-size: 0.9rem;
        margin-bottom: 0;
        border-left: 4px solid;
    }

    .admin-remark .alert-success {
        border-left-color: #28a745;
        background-color: rgba(40, 167, 69, 0.1);
    }

    .admin-remark .alert-danger {
        border-left-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
    }

    .admin-remark .alert-warning {
        border-left-color: #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
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

    .btn-danger {
        border-radius: 6px;
        font-size: 0.875rem;
        padding: 8px 16px;
    }

    /* Improved card styles */
    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .zone-image-preview img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .site-wrap {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
    }

    .content-wrapper {
        flex: 1 0 auto;
    }

    .footer {
        flex-shrink: 0;
        margin-top: auto;
    }
  </style>
  <script>
  function toggleCard(card) {
    card.classList.toggle('expanded');
  }
  </script>
</html>
<?php session_start();
// Database Connection
include('includes/config.php');

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
    
    
    
    <div class="site-section mt-5">
      <div class="container">
        <div class="row">





<div class="col-md-12">
<table id="example1" class="table table-bordered table-striped">
    <tbody>
        <?php 
        $bid = base64_decode($_GET['bid']);
        $eml = base64_decode($_GET['eml']);
        $pno = base64_decode($_GET['pno']);
        $query = mysqli_query($con, "
            SELECT tblbookings.*, tblboat.ID, tblboat.BoatName 
            FROM tblbookings 
            JOIN tblboat ON tblboat.ID = tblbookings.BoatID  
            WHERE tblbookings.ID = '$bid' 
            AND tblbookings.EmailId = '$eml' 
            AND tblbookings.PhoneNumber = '$pno'
        ");
        $cnt = 1;
        while ($result = mysqli_fetch_array($query)) {
        ?>

        <!-- Booking Number -->
        <tr>
            <th>Booking Number</th>
            <td colspan="3"><?php echo $result['BookingNumber']; ?></td>
        </tr>

        <!-- Name and Email -->
        <tr>
            <th>Name</th>
            <td><?php echo $result['FullName']; ?></td>
            <th>Email ID</th>
            <td><?php echo $result['EmailId']; ?></td>
        </tr>

        <!-- Mobile Number and Number of People -->
        <tr>
            <th>Mobile Number</th>
            <td><?php echo $result['PhoneNumber']; ?></td>
            <th>Number of People</th>
            <td><?php echo $result['NumnerofPeople']; ?></td>
        </tr>

        <!-- Booking Date and Time -->
        <tr>
            <th>Booking Date</th>
            <td><?php echo $result['BookingDate']; ?></td>
            <th>Booking Time</th>
            <td><?php echo $result['TimeFrom']; ?> to <?php echo $result['TimeTo']; ?></td>
        </tr>

        <!-- Boat Name -->

        <!-- Booking Status -->
        <tr>
            <th>Boat Name</th>
              <td >
                  <?php echo $result['BoatName']; ?> 
                  <a href='zone-details.php?bid=<?php echo $result['BoatID']; ?>' target="_blank">View Details</a>
              </td>
            <th>Booking Status</th>
            <td >
                <?php if ($result['BookingStatus'] == ''): ?>
                    <span class="badge bg-warning text-dark">Not Processed Yet</span>
                <?php elseif ($result['BookingStatus'] == 'Accepted'): ?>
                    <span class="badge bg-success">Accepted</span>
                <?php elseif ($result['BookingStatus'] == 'Rejected'): ?>
                    <span class="badge bg-danger">Rejected</span>
                <?php endif; ?>
            </td>
        </tr>

        <!-- Admin Remark -->
        <tr>
            <th>Remark</th>
            <td colspan="3"><?php echo $result['AdminRemark']; ?></td>
        </tr>

        <?php $cnt++; } ?>
    </tbody>
</table>


              </div>


        </div>
      </div>
    </div>
    

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

</html>
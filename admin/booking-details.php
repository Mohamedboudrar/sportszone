<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_log("Starting booking process...");
// Database Connection
include('includes/config.php');
include('../includes/functions.php');
include('../includes/alert-handler.php');

//Validating Session
if(strlen($_SESSION['aid'])==0)
  { 
header('location:index.php');
}
else{

// Add this temporarily at the top of the file after session_start()
$test_mail = mail("sportszone@gmail.com", "Test Subject", "Test Message", "From: sportszone@gmail.com");
if($test_mail) {
    error_log("Test mail sent successfully");
} else {
    error_log("Failed to send test mail");
}

if(isset($_POST['submit'])){
    $bid = intval($_GET['bid']);
    $estatus = mysqli_real_escape_string($con, $_POST['status']);
    $oremark = mysqli_real_escape_string($con, $_POST['officialremak']);

    $query = mysqli_query($con, "UPDATE tblbookings 
                                SET AdminRemark='$oremark', 
                                    BookingStatus='$estatus',
                                    UpdationDate=NOW() 
                                WHERE ID='$bid'");

    if($query) {
        if($estatus == 'Accepted') {
            try {
                // Get all booking details including zone info
                $bookingQuery = mysqli_query($con, "
                    SELECT b.ID, b.BookingNumber, b.FullName, b.EmailId, b.PhoneNumber, 
                           b.NumnerofPeople, b.BookingDate, b.TimeFrom, b.TimeTo, 
                           b.BookingStatus, b.AdminRemark, b.postingDate,
                           bt.BoatName, bt.Price, bt.Description 
                    FROM tblbookings b 
                    LEFT JOIN tblboat bt ON b.BoatID = bt.ID 
                    WHERE b.ID='$bid'
                ");
                
                $bookingDetails = mysqli_fetch_array($bookingQuery);
                
                // Debug log to check what we're getting
                error_log("Booking Query Result: " . print_r($bookingDetails, true));
                
                // Verify we have an email before attempting to send
                if(empty($bookingDetails['EmailId'])) {
                    showToastAndRedirect('Booking accepted but no email address found for the user.', 'all-booking.php', 'error');
                } else {
                    $emailResult = sendBookingConfirmationEmail($bookingDetails);
                    if($emailResult) {
                        showToastAndRedirect('Booking accepted and confirmation email sent to ' . $bookingDetails['EmailId'], 'all-booking.php');
                    } else {
                        showToastAndRedirect('Warning: Booking accepted but failed to send email to ' . $bookingDetails['EmailId'], 'all-booking.php', 'error');
                    }
                }
            } catch (Exception $e) {
                showToastAndRedirect('Error: ' . $e->getMessage(), 'all-booking.php', 'error');
            }
        } elseif($estatus == 'Rejected') {
            try {
                // Get booking details for rejection email
                $bookingQuery = mysqli_query($con, "
                    SELECT b.*, bt.BoatName 
                    FROM tblbookings b 
                    LEFT JOIN tblboat bt ON b.BoatID = bt.ID 
                    WHERE b.ID='$bid'
                ");
                
                $bookingDetails = mysqli_fetch_array($bookingQuery);
                
                if(empty($bookingDetails['EmailId'])) {
                    showToastAndRedirect('Booking rejected but no email address found for the user.', 'all-booking.php', 'error');
                } else {
                    $emailResult = sendBookingRejectionEmail($bookingDetails);
                    if($emailResult) {
                        showToastAndRedirect('Booking rejected and notification email sent to ' . $bookingDetails['EmailId'], 'all-booking.php');
                    } else {
                        showToastAndRedirect('Warning: Booking rejected but failed to send email to ' . $bookingDetails['EmailId'], 'all-booking.php', 'error');
                    }
                }
            } catch (Exception $e) {
                showToastAndRedirect('Error: ' . $e->getMessage(), 'all-booking.php', 'error');
            }
        }
    } else {
        showToast('Failed to update booking status');
    }
}

// Add this new code block for handling booking cancellation
if(isset($_POST['admin_cancel_booking'])) {
    $bid = intval($_GET['bid']);
    
    // First get the booking details for the email notification
    $bookingQuery = mysqli_query($con, "SELECT * FROM tblbookings WHERE ID='$bid' AND BookingStatus='Accepted'");
    $bookingDetails = mysqli_fetch_array($bookingQuery);
    
    if($bookingDetails) {
        // Delete the booking
        $query = mysqli_query($con, "DELETE FROM tblbookings WHERE ID='$bid' AND BookingStatus='Accepted'");
        
        if($query) {
            // Send email notification
            $to = $bookingDetails['EmailId'];
            $subject = "Booking Cancellation Notice";
            $message = "Dear " . $bookingDetails['FullName'] . ",\n\n";
            $message .= "Your booking (Booking Number: " . $bookingDetails['BookingNumber'] . ") has been cancelled by the administrator.\n";
            $message .= "Booking Details:\n";
            $message .= "Date: " . $bookingDetails['BookingDate'] . "\n";
            $message .= "Time: " . $bookingDetails['TimeFrom'] . " to " . $bookingDetails['TimeTo'] . "\n";
            $message .= "\nIf you have any questions, please contact us.\n\n";
            $message .= "Thank you for your understanding.";
            
            mail($to, $subject, $message, "From: sportszone@gmail.com");
            
            showToastAndRedirect('Booking has been cancelled and deleted successfully.', 'all-booking.php', 'success');
        } else {
            showToast('Failed to cancel booking.');
        }
    } else {
        showToast('Booking not found or already cancelled.');
    }
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SportsZone | Booking Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
<?php include_once("includes/navbar.php");?>
  <!-- /.navbar -->

 <?php include_once("includes/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Booking Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
        

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Booking Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
       
                  <tbody>
<?php $bid=intval($_GET['bid']);
$query=mysqli_query($con,"select tblbookings.*, tblboat.ID,tblboat.BoatName from tblbookings join tblboat on tblboat.ID=tblbookings.BoatID  where tblbookings.ID='$bid'");
$cnt=1;
while($result=mysqli_fetch_array($query)){
?>


       <tr>
                  <th>Booking Number</th>
                    <td colspan="3"><?php echo $result['BookingNumber']?></td>
                  </tr>

                  <tr>
                  <th> Name</th>
                    <td><?php echo $result['FullName']?></td>
                    <th>Email Id</th>
                   <td> <?php echo $result['EmailId']?></td>
                  </tr>
                  <tr>
                    <th> Mobile No</th>
                    <td><?php echo $result['PhoneNumber']?></td>
                    <th>No of Peoples</th>
                    <td><?php echo $result['NumnerofPeople']?></td>
                  </tr>
                  <tr>
                    <th>Booking Date</th>
                   <td><?php echo $result['BookingDate']?></td>
                   <th>Booking Time</th>
                   <td><?php echo $result['TimeFrom']?> to <?php echo $result['TimeTo']?></td>
                 </tr>
                 <tr>
                  <th>Posting Date</th>
                    <td ><?php echo $result['postingDate']?></td>
                    <th>Zone Name</th>
                    <td ><?php echo $result['BoatName']?>  <a href='edit-zone.php?bid=<?php echo $result['BoatID']; ?>'> View Details</a></td>
                  </tr>

 

<?php if($result['BookingStatus']!=''):?>
            <tr>
                  <th>Booking  Status</th>
                    <td><?php if($result['BookingStatus']==''): ?>
<span class="badge bg-warning text-dark">Not Processed Yet</span>
                  <?php elseif($result['BookingStatus']=='Accepted'): ?>
                    <span class="badge bg-success">Accepted</span>
                    <?php elseif($result['BookingStatus']=='Rejected'): ?>
                      <span class="badge bg-danger">Rejected</span>
                    <?php endif;?></td>
                    <th>Updation Date</th>
                    <td><?php echo $result['UpdationDate']?></td>
                  </tr>

      <tr>
                  <th> Remark</th>
                    <td colspan="3"><?php echo $result['AdminRemark']?></td>
                  </tr>
<?php endif;?>
<?php if($result['BookingStatus']=='Accepted'): ?>
    <tr>
        <td colspan="4" style="text-align:center;">
            <form method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking? This will permanently delete the booking.');">
                <button type="submit" name="admin_cancel_booking" class="btn btn-danger">
                    <i class="fas fa-times-circle"></i> Cancel Booking
                </button>
            </form>
        </td>
    </tr>
<?php endif; ?>

         <?php $cnt++;} ?>
             
                  </tbody>
     
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once('includes/footer.php');?>


</div>
<!-- ./wrapper -->


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Booking Satus</h4>
      </div>
      <div class="modal-body">
        <form name="takeaction" method="post">

          <p><select class="form-control" name="status" id="status" required>
            <option value="">Select Booking Status</option>
            <option value="Accepted">Accepted</option>
            <option value="Rejected">Rejected</option>
          </select></p>

        <p><textarea class="form-control" name="officialremak" placeholder="Official Remark" rows="5" required></textarea></p>
        <input type="submit" class="btn btn-primary" name="submit" value="update">

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>






<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script type="text/javascript">

  //For report file
  $('#rtable').hide();
  $(document).ready(function(){
  $('#status').change(function(){
  if($('#status').val()=='Accepted')
  {
  $('#rtable').show();
  jQuery("#table").prop('required',true);  
  }
  else{
  $('#rtable').hide();
  }
})}) 
</script>
</body>
</html>
<?php } ?>
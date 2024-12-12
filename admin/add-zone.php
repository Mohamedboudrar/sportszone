<?php session_start();
// Database Connection
include('includes/config.php');
//Validating Session
if(strlen($_SESSION['aid'])==0)
  { 
header('location:index.php');
}
else{

if(isset($_POST['submit'])){
//Getting Post Values  
$Boatname=$_POST['Boatname'];


$capacity=$_POST['capacity'];

$price=$_POST['price'];
$description=$_POST['description'];
$location = $_POST['location'];
$addedby=$_SESSION['aid'];
$image=$_POST['image'];
$extension = substr($image,strlen($image)-4,strlen($image));
//rename images
$Boatimage=md5($image).time().$extension;
move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$Boatimage);
$query=mysqli_query($con,"insert into tblBoat(BoatName,Image,Capacity,Price,Description,Location,AddedBy) values('$Boatname','$Boatimage','$capacity','$price','$description','$location','$addedby')");
if($query){
echo "<script>alert('Zone detail added successfully.');</script>";
echo "<script type='text/javascript'> document.location = 'add-zone.php'; </script>";
} else {
echo "<script>alert('Something went wrong. Please try again.');</script>";
}
}


  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SportsZone</title>

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
<?php include_once("includes/navbar.php");?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <?php include_once("includes/sidebar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add a Zone</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Zone</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Zone Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data">
                <div class="card-body">


   <div class="form-group">
                    <label for="exampleInputFullname">Name of Zone</label>
                    <input type="text" class="form-control" id="Boatname" name="Boatname" placeholder="Enter Name of Zone" required>
                  </div>

 <div class="form-group">
                    <label for="exampleInputFullname">Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                  </div>
                   <!-- <div class="form-group">
                    <label for="exampleInputFullname">Size</label>
                    
                    <select class="form-control" name="size" required>
                      <option value="">Choose Size of Jet</option>
                      <option value="Small">Small</option>
                      <option value="Medium">Medium</option>
                      <option value="Large">Large</option>

                     </select>
                  </div> -->

<div class="form-group">
                    <label for="exampleInputFullname">Number of Players</label>
                    <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Enter Capacity of Zone" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFullname">Price Per Person</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price Per Person" required>
                  </div>
                  <!-- <div class="form-group">
                    <label for="exampleInputFullname">From</label>
                    <input type="text" class="form-control" id="source" name="source" placeholder="Enter Source" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFullname">Destination</label>
                    <input type="text" class="form-control" id="destination" name="destination" placeholder="Enter Destination" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFullname">Route</label>
                    <input type="text" class="form-control" id="route" name="route" placeholder="Enter Route" required>
                  </div> -->

                <div class="form-group">
                    <label for="exampleInputFullname">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description of Zone" required></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFullname">Location</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description of Zone" required></textarea>
                  </div>


  <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                </div>
      
                </div>
                <!-- /.card-body -->
          
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->








    
              </form>
       
  
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include_once('includes/footer.php');?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
});
</script>
</body>
</html>
<?php } ?>

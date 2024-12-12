<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SportsZone | Zone Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .zone-header {
            background-color: #fff;
            padding: 2rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;  /* Space between name and price */
        }

        .zone-title {
            font-size: 2rem;
            font-weight: 600;
            color: #000;
            margin: 0;  /* Remove default margins */
            padding-right: 2rem;  /* Space before separator */
            border-right: 1px solid #e0e0e0;  /* Vertical separator line */
        }

        .price-badge {
            color: #000;
            font-weight: 500;
            font-size: 1.1rem;
            padding-left: 0.5rem;  /* Space after separator */
        }

        /* Rest of the CSS remains the same */
        .zone-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .info-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .info-card h3 {
            color: #1a1a1a;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .key-info {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .key-info-item {
            flex: 1;
        }

        .key-info-label {
            font-weight: 500;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .book-btn {
            background-color: #2563eb;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            transition: background-color 0.2s;
            width: 100%;
            margin-bottom: 1rem;
        }

        .book-btn:hover {
            background-color: #1d4ed8;
            color: white;
        }

        .location-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .location-header {
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .map-frame {
            width: 100%;
            height: 300px;
            border: 0;
        }

        .contact-section {
            background-color: #2563eb;
            color: white;
            padding: 3rem 0;
            text-align: center;
            margin-top: 3rem;
        }

        .contact-btn {
            background-color: white;
            color: #2563eb;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        .contact-btn:hover {
            background-color: #f8f9fa;
            color: #2563eb;
        }

        .sidebar-container {
            position: sticky;
            top: 20px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .zone-title {
                font-size: 1.5rem;
                border-right: none;  /* Remove separator on mobile */
                padding-right: 0;
                padding-bottom: 0.5rem;  /* Add some space below title */
                border-bottom: 1px solid #e0e0e0;  /* Horizontal separator on mobile */
                width: 100%;  /* Full width for the border */
            }

            .price-badge {
                padding-left: 0;
            }

            .key-info {
                flex-direction: column;
                gap: 1rem;
            }

            .map-frame {
                height: 250px;
            }
        }
    </style>
</head>

<body>
    <?php include_once("includes/navbar.php"); ?>

    <?php 
    $bid = $_GET['bid'];
    $query = mysqli_query($con, "SELECT * FROM tblboat WHERE ID='$bid'");
    while($result = mysqli_fetch_array($query)) {
    ?>

    <header class="zone-header">
        <div class="container">
            <div class="header-content">
                <h1 class="zone-title"><?php echo htmlspecialchars($result['BoatName']); ?></h1>
                
            </div>
        </div>
    </header>

    <main class="container pb-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Zone Image -->
                <img src="admin/images/<?php echo htmlspecialchars($result['Image']); ?>" 
                     alt="<?php echo htmlspecialchars($result['BoatName']); ?>" 
                     class="zone-image">
                
                <!-- Zone Information -->
                <div class="info-card">
                    <h3>Key Information</h3>
                    <div class="key-info">
                        <div class="key-info-item">
                            <div class="key-info-label">Capacity</div>
                            <div><?php echo htmlspecialchars($result['Capacity']); ?> persons</div>
                        </div>
                        <div class="key-info-item">
                            <div class="key-info-label">Price Per Person</div>
                            <div><?php echo htmlspecialchars($result['Price']); ?> DH</div>
                        </div>
                    </div>
                    <h3>About This Zone</h3>
                    <p><?php echo htmlspecialchars($result['Description']); ?></p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-container">
                    <!-- Booking Card -->
                    <div class="info-card text-center">
                        <h3>Ready to Book?</h3>
                        <p>Secure your spot now</p>
                        <a href="book-zone.php?bid=<?php echo $result['ID']; ?>" class="book-btn btn">
                            Book Now
                        </a>
                    </div>

                    <!-- Location Card -->
                    <div class="location-container">
                        <div class="location-header">
                            <h3 class="h5 mb-0">Location</h3>
                        </div>
                        <iframe src="<?php echo $result['Location']; ?>" 
                                class="map-frame"
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php } ?>

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

    <?php include_once("includes/footer.php"); ?>

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
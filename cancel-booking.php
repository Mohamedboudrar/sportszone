<?php
session_start();
include('includes/config.php');

if(isset($_GET['bid']) && isset($_GET['eml']) && isset($_GET['pno'])) {
    // Decode the base64 encoded parameters
    $booking_id = base64_decode($_GET['bid']);
    $email = base64_decode($_GET['eml']);
    $phone = base64_decode($_GET['pno']);

    // Prepare and execute delete query
    $delete_query = mysqli_prepare($con, "DELETE FROM tblbookings WHERE ID = ? AND EmailId = ? AND PhoneNumber = ?");
    mysqli_stmt_bind_param($delete_query, "iss", $booking_id, $email, $phone);
    
    if(mysqli_stmt_execute($delete_query)) {
        // Successful deletion
        showToastAndRedirect('Booking cancelled successfully', 'status.php');
    } else {
        // Deletion failed
        showToast('Failed to cancel booking');
    }
} else {
    // Invalid parameters
    $_SESSION['message'] = "Invalid booking details.";
    $_SESSION['message_type'] = "danger";
    header("Location: status.php");
    exit();
}
?>